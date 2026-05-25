<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();

        $tasksQuery = Task::with('project', 'employee');                      

        $userRoles = DB::table('model_has_roles')
                     ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                     ->where('model_has_roles.model_id', $user->id)
                     ->pluck('roles.name')
                     ->toArray();

        if(in_array('staff', $userRoles)){
            $tasksQuery->where('assigned_at', $user->id);        
        }

        $tasks = $tasksQuery->get();

        $completed = $tasks->where('status', 'completed');
        $onProgress = $tasks->where('status', 'on_progress');
        $overdue = $tasks->where('status', 'overdue');

        if (in_array('manager', $userRoles) || in_array('admin', $userRoles)) {
            $projects = Project::get();
            return view('pages.dashboard.pm', compact(
                'tasks',
                'projects',
                'completed',
                'onProgress',
                'overdue'
            )); 
        }
        // return response()->json($overdue);
        return view('pages.dashboard.staff', compact(
            'tasks',            
            'userRoles',
            'completed',
            'onProgress',
            'overdue'
        ));
    }
}
