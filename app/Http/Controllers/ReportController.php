<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function exportPDF(Task $task)
    {   
        $task->load(['project', 'employee', 'images']);
        // $task = Task::with(['project', 'employee'])
        //         ->where('id', $task->id)
        //         ->orderBy('created_at', 'desc')
        //         ->get();
        // return response()->json($task);

        $pdf = Pdf::loadView('pages.reports.pdf', compact('task'))
                ->setPaper('a4', 'landscape')
                ->setOption('margin-top', 10)
                ->setOption('margin-bottom', 10)
                ->setOption('margin-left', 10)
                ->setOption('margin-right', 10);

        return $pdf->download('Laporan_Tasks_' . now()->format('Y-m-d_His') . '.pdf');
    }
}
