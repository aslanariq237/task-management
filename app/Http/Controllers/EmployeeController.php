<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    private $table = 'employees';
    private $code = 'EMP-';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        $query = Employee::query()
                    ->latest();
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // Cari di header receive
                $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");                
            });            
        }
        
        $employees = $query
        ->paginate(10)
        ->appends($request->query());
        return view('pages.employees.index', compact('employees'));
        // return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Employee $employee)
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('pages.employees.create', compact('employee', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {                
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $prefix = $this->code;
        $lastCode = Employee::latest('id')->first();
        $lastNumber = $lastCode
                ? intval(substr($lastCode->code, 4))
                : 1000;
        $newNumber = $lastNumber + 1;
        $newCode = "{$prefix}". str_pad($newNumber, 3, '0', STR_PAD_LEFT);;

        // return response()->json($newCode);
        $employee = Employee::create([
            'code'  => $newCode,
            'name'  => $request->name,
            'email' => strtolower($request->email),
        ]);

        $user = User::firstOrCreate([
            'employee_id'   => $employee->id,
            'name'          => $employee->name,
            'email'         => $employee->email,
            'password'      => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);



        return redirect()->route('employees.index')
                         ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {        
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('pages.employees.edit', compact('employee', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [            
            'name'  => 'required|string|max:100',
            'email' => 'required,',
        ]);        

        $employee->update([            
            'name'  => $request->name,
            'email' => strtolower($request->email),
        ]);        

        return redirect()->route('employees.index')
                         ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee->delete();

        return redirect()->route('employees.index')
                         ->with('success', 'Karyawan berhasil dihapus.');
    }
}
