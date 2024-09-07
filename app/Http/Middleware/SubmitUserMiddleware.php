<?php

namespace App\Http\Middleware;

use App\Models\Project;
use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubmitUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $taskid =  $request->route('taskid');
        $projectid =  $request->route('projectid');
        
        $task = Task::findOrFail($taskid);
        $project = Project::findOrFail($projectid);
        
        foreach(Auth::user()->tasks as $usertask){
            if($usertask == $task){
                return $next($request);
            }
        }

        return redirect()->back();



        
    }
}
