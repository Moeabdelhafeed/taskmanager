<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('manager');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentHour = date('H');

        if ($currentHour >= 6 && $currentHour < 12) {
            $greeting = 'Good morning, ' . Auth::user()->name;
        } elseif ($currentHour >= 12 && $currentHour < 18) {
            $greeting = 'Good afternoon, ' . Auth::user()->name;
        } elseif ($currentHour >= 18 && $currentHour < 21) {
            $greeting = 'Good evening, ' . Auth::user()->name;
        } else {
            $greeting = 'Good night, ' . Auth::user()->name;
        }

        $projects = Auth::user()->createdprojects()->latest()->take(5)->get();
        $allprojects = Auth::user()->createdprojects;

        // Filter completed projects
        $completedprojects = $allprojects->filter(function ($project) {
            return $project->tasks->count() > 0 && $project->tasks->where('iscomplete', 0)->count() == 0;
        });

        $completedCount = $completedprojects->count();
        $totalCount = $allprojects->count();
        $incompleteCount = $totalCount - $completedCount;

        $table = [];

        $users = Auth::user()->createdusers()->count();

        $comptasks = $allprojects->sum(function ($project) {
            return $project->tasks->where('iscomplete', 1)->count();
        });

        $incomptasks = $allprojects->sum(function ($project) {
            return $project->tasks->where('iscomplete', 0)->count();
        });

        $submitedtasks = $allprojects->sum(function ($project) {
            return $project->tasks->whereNotNull('submitted_at')->count();
        });

        $table['users'] = $users;
        $table['completed projects'] = $completedCount;
        $table['incompleted projects'] = $incompleteCount;
        $table['completed tasks'] = $comptasks;
        $table['incompleted tasks'] = $incomptasks;
        $table['submitted tasks'] = $submitedtasks;

        return view('manager.home', compact('greeting', 'projects', 'allprojects', 'completedCount', 'incompleteCount', 'table', 'comptasks', 'incomptasks'));
    }
}
