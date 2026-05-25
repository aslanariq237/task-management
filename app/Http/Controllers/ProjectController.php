<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\Project;
use App\Models\Employee;

class ProjectController extends Controller
{
    private $table = 'projects';
    private $code = 'PRJ';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query()->latest();
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // Cari di header receive
                $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");                
            });            
        }
        $projects = $query        
        ->paginate(10)
        ->appends($request->query());
        return view('pages.projects.index', compact('projects'));

        // return response()->json($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::orderBy('name')->get();
        return view('pages.projects.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)    
    {           
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'description' => 'nullable|string',
            // 'status'      => 'required',
            // 'started_at'  => 'required|date',
            // 'ended_at'    => 'nullable|date',
            // 'employee_id' => 'required',
            'members'     => 'nullable|array',
            'members.*'   => 'exists:employees,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        try {
            DB::beginTransaction();   
            $prefix = $this->code;
            $lastCode = Project::latest()->first();  
            $lastNumber = $lastCode
                ? intval(substr($lastCode->code, 4))
                : 1000;
            $newNumber = $lastNumber + 1;
            $newCode = "{$prefix}-{$newNumber}";            
            
            $project = Project::create([
                'employee_id' => Auth::user()->employee_id,
                'code'        => $newCode,
                'name'        => $request->name,
                'description' => $request->description,
                'status'      => $request->status ?? 'planned',
                'started_at'  => $request->started_at,
                'ended_at'    => $request->ended_at,
            ]);            

            // Tambahkan Members (jika ada)
            if (!empty($request->members)) {
                $memberIds = $request->members;
                // $memberIds = array_filter(explode(',', $request->members));

                $membersData = [];
                foreach ($memberIds as $employeeId) {
                    $employeeId = (int) trim($employeeId);
                    
                    // Hindari duplikat dengan Project Leader
                    if ($employeeId && $employeeId != $request->employee_id) {
                        $membersData[] = [
                            'project_id' => $project->id,
                            'employee_id' => $employeeId,
                            'joined_at'   => now(),
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ];
                    }
                }

                if (count($membersData) > 0) {
                    ProjectMember::insert($membersData);
                }
            }

            DB::commit();

            return redirect()->route('projects.index')
                             ->with('success', 'Project berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e);
            
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['projectMember.employee']);
        return view('pages.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project->load('projectMember');
        $employees = Employee::orderBy('name')->get();
        
        $selectedMembers = $project->projectMember->pluck('employee_id')->toArray();

        return view('pages.projects.edit', compact('project', 'employees', 'selectedMembers'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string',
            'status'      => 'required|in:planning,ongoing,completed,cancelled',
            'started_at'  => 'required|date',
            'ended_at'    => 'nullable|date|after_or_equal:started_at',
            'employee_id' => 'required|exists:employees,id',
            'members'     => 'nullable|array',
            'members.*'   => 'exists:employees,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Update Project
            $project->update([
                'employee_id' => $request->employee_id,
                'name'        => $request->name,
                'description' => $request->description,
                'status'      => $request->status,
                'started_at'  => $request->started_at,
                'ended_at'    => $request->ended_at,
            ]);

            // Hapus semua member lama
            $project->projectMember()->delete();

            // Tambahkan member baru
            if (!empty($request->members)) {
                $membersData = [];
                foreach ($request->members as $employeeId) {
                    if ($employeeId != $request->employee_id) {
                        $membersData[] = [
                            'project_id' => $project->id,
                            'employee_id' => $employeeId,
                            'joined_at'   => now(),
                        ];
                    }
                }

                if (count($membersData) > 0) {
                    ProjectMember::insert($membersData);
                }
            }

            DB::commit();

            // return redirect()->route('projects.index')
            //                  ->with('success', 'Project berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->projectMember()->delete();
        $project->delete();

        // return redirect()->route('projects.index')
        //                      ->with('success', 'Project berhasil dihapus.');
    }
}
