<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $projectid = $request->route('projectid'); 
    
        $project = Project::findOrFail($projectid);
    

        $createdby = $project->manager_id;
        if ($createdby == Auth::user()->id) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}    
