<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    private $table = 'vendors';
    private $code = 'VND';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vendor::query()
                        ->latest();
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // Cari di header receive
                $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");                
            });            
        }

        $vendors = $query
                 ->paginate(10)
                 ->appends($request->query());
        return view('pages.vendors.index', compact('vendors'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Vendor $vendor)
    {
        return view('pages.vendors.create', compact('vendor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $validator = Validator::make($request->all(), [            
            'name'    => 'required|string',
            'email'   => 'required|email',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        try {
            DB::beginTransaction();

            $prefix = $this->code;
            $lastCode = Vendor::latest()->first();
            $lastNumber = $lastCode
                    ? intval(substr($lastCode->code, 4))
                    : 1000;
            $newNumber = $lastNumber + 1;
            $newCode = "{$prefix}-{$newNumber}";

            Vendor::create([
                'code'    => $newCode,
                'name'    => $request->name,
                'email'   => strtolower($request->email),
                'address' => $request->address,
            ]);

            DB::commit();

            return redirect()->route('vendors.index')
                            ->with('success', 'Vendor berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                            ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
