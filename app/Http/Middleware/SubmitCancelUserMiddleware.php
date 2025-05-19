<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubmitCancelUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $taskid = $request->route('taskid');
        $task = Task::findOrFail($taskid);

        if ($task->iscomplete == 0){
            return $next($request);
        }
        return redirect()->back();
       
    }
}
