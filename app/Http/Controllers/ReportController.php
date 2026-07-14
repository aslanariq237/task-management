<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Project;
use App\Models\Task;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query()
            ->with(['project', 'employee'])
            ->where('status', 'completed')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('ended_at', $request->date);
        }

        $tasks = $query->paginate(10)->appends($request->query());
        $projects = Project::orderBy('name')->get();

        return view('pages.reports.index', compact('tasks', 'projects'));
    }

    public function exportPDF(Task $task)
    {
        $task->load(['project', 'employee', 'images']);

        $pdf = Pdf::loadView('pages.reports.pdf', compact('task'))
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        return $pdf->download('Laporan_Tasks_' . now()->format('Y-m-d_His') . '.pdf');
    }
}