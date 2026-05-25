<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    private $table = 'employees';
    private $code = 'EMP';
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'  => 'required|string|max:20|unique:employees,code',
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Employee::create([
            'code'  => strtoupper($request->code),
            'name'  => $request->name,
            'email' => strtolower($request->email),
        ]);

        // return redirect()->route('employees.index')
        //                  ->with('success', 'Karyawan berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        // return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'code'  => 'required|string|max:20|unique:employees,code,' . $employee->id,
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees,email,' . $employee->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $employee->update([
            'code'  => strtoupper($request->code),
            'name'  => $request->name,
            'email' => strtolower($request->email),
        ]);

        // return redirect()->route('employees.index')
        //                  ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee->delete();

        // return redirect()->route('employees.index')
        //                  ->with('success', 'Karyawan berhasil dihapus.');
    }
}
