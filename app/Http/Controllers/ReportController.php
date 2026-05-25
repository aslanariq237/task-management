<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\Employee;

class ReportController extends Controller
{
    public function index(Request $request){
        $query = Task::query()
                ->with(['project', 'employee'])
                ->where('status', 'completed')
                ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // Cari di header receive
                $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");                
            });            
        }

        $tasks = $query
        ->paginate(10)
        ->appends($request->query());

        return view('pages.reports.index', compact('tasks'));
    }
}
