<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Session\TokenMismatchException;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TaskDocumentation;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Task;

class TaskController extends Controller
{
    private $table = 'tasks';
    private $code = 'TSK';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Task::query()
                ->with('project')
                ->latest();

        $userRoles = DB::table('model_has_roles')
                     ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                     ->where('model_has_roles.model_id', $user->id)
                     ->pluck('roles.name')
                     ->toArray();
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // Cari di header receive
                $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");                
            });            
        }
        if(in_array('staff', $userRoles)){
            $query->where('assigned_at', $user->id);
        }

        $tasks = $query
        ->paginate(10)
        ->appends($request->query());
        return view('pages.tasks.index', compact('tasks'));
        // return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $employees = Employee::all();        
        return view('pages.tasks.form', compact('projects', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            // 'project_id'  => 'required|exists:projects,id',
            // 'assigned_at' => 'required',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string',
            // 'status'      => 'required|in:todo,in_progress,review,completed,cancelled',
            // 'started_at'  => 'required|date',
            // 'ended_at'    => 'nullable|date|after_or_equal:started_at',
        ]);        

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        try {
            DB::beginTransaction();
            $prefix = $this->code;
            $lastCode = Task::latest()->first();  
            $lastNumber = $lastCode
                ? intval(substr($lastCode->code, 4))
                : 1000;
            $newNumber = $lastNumber + 1;
            $newCode = "{$prefix}-{$newNumber}"; 
            $task = Task::create([
                'project_id'  => $request->project_id,
                'assigned_at' => $request->assigned_at,
                'code'        => $newCode,
                'name'        => $request->name,
                'description' => $request->description,
                'status'      => $request->status ?? 'on_progress',
                'started_at'  => $request->started_at,
                'ended_at'    => $request->ended_at,
            ]);            

            DB::commit();                     
            return redirect()->route('tasks.index')
                             ->with('success', 'Task berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e);
            // return redirect()->back()
            //                  ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            //                  ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('project.vendor', 'employee', 'images');
        // return response()->json($task);
        return view('pages.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $projects = Project::orderBy('name')->get();
        // return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {               
        $validator = Validator::make($request->all(), [
            'to_do'     => 'required|string',
            'notes'     => 'nullable|string',            
        ]);

        try {
            DB::beginTransaction();

            $task->update([
                'status' => $request->status,
                'client' => $request->client,
                'address'=> $request->address,
                'to_do'  => $request->to_do,
                'notes'  => $request->notes,
                'started_at'=> $request->started_at,
                'ended_at'=> $request->ended_at,
            ]);       
            // return response()->json($request->hasFile('images'));
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    // $path = $image->store('task_documentations', 'public');
                    $path = $image->move(public_path('storage/tasks'), $filename);

                    TaskDocumentation::create([
                        'task_id'     => $task->id,
                        'project_id'  => $task->project_id,
                        'employee_id' => Auth::user()->employee_id ?? null,
                        'image_url'   => 'tasks/'.$filename,
                        'location'    => $request->work_location ?? $request->address,
                        'taken_at'    => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('tasks.index')
                            ->with('success', 'Task berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan saat memperbarui task.', $e)
                            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, TaskDocumentation $documentation)
    {
        //
    }
}
