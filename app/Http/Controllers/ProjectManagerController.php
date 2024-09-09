<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\error;

class ProjectManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('manager');
    }


    public function index()
    {
        $projects = Auth::user()->createdprojects->filter(function ($project) {
            // Check if the project has no tasks or all tasks are completed
            return $project->tasks()->count() === 0 || $project->tasks()->where('iscomplete', 0)->exists();
        });

        

        $completedprojects = Auth::user()->createdprojects->filter(function ($project) {
            return $project->tasks()->count() > 0 && !$project->tasks()->where('iscomplete', 0)->exists();
        });

        
        
    
        return view('manager.project.index', compact('projects' , 'completedprojects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return (view('manager.project.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]
    
    );

        $project = new Project;

        $project->name = $request -> name;
        $project->manager_id = Auth::user()->id;

        $project->save();
        return redirect(route('manager.project.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        $managerid = $project->manager->id;

        if(Auth::user()->id != $managerid){
            return redirect()->route('manager.project.index');
        }

        
    
        $users = $project->users; 
    
        return view('manager.project.show', compact('project', 'users', 'id'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $project = Project::find($id);
        return view('manager.project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('projects', 'name')->ignore($id)
        ],
        ]);
        
        $project= Project::find($id);

        $project -> name = $request->name;
        $project -> save();

        return redirect(route('manager.project.index')) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    // Retrieve all tasks associated with the project
    $tasks = Task::where('project_id', $id)->get();

    // Delete all tasks associated with the project
    foreach ($tasks as $task) {
        $task->delete();
    }

    // Retrieve the project by ID
    $project = Project::findOrFail($id);


    // Delete the project
    $project->delete();

    // Redirect to the project index with a success message
    return redirect()->route('manager.project.index');
}


public function indextrash(){
    $projects = Project::onlyTrashed()->where('manager_id', Auth::user()->id)->get();
    return view('manager.project.indextrash', compact('projects'));
}


public function restoretrash(string $id){
    $project = Project::onlyTrashed()->where('manager_id', Auth::user()->id)->where('id', $id)->restore();

    $tasks = Task::onlyTrashed()->where('project_id', $id)->restore();

    return redirect(route('manager.project.indextrash'));
}

public function destroytrash(string $id)
{

    $project = Project::onlyTrashed()->where('manager_id', Auth::user()->id)->where('id', $id)->first();
    if ($project) {
        $project->users()->detach();
        $tasks = Task::onlyTrashed()->where('project_id', $id)->get();

        foreach ($tasks as $task) {

            $task->images()->delete();
            $task->notes()->delete();

            $task->forceDelete();
        }

        $project->forceDelete();
    }

    return redirect(route('manager.project.indextrash'));
}




    public function adduser(string $id){
        $role = Role::where('name', 'user')->first();

        $allUsers = $role->users;

        $project = Project::find($id);

        $projectUsers = $project->users->pluck('id')->toArray();
        

        $users = $allUsers->filter(function($user) use ($projectUsers){
            return !in_array($user->id, $projectUsers);
        });

        return view('manager.project.adduser', compact('users', 'id', 'project'));
    }

    public function storeuser(Request $request)
    {

        $validated = $request->validate([
            'user' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);
    
        $user = User::findOrFail($validated['user']);
        $project = Project::findOrFail($validated['project_id']);

        $user->tasks()->withTrashed()->where('project_id', $validated['project_id'])->restore();
    
       
        $project->users()->attach($user->id);
    
        return redirect()->route('manager.project.show', ['project' => $project->id]);
    }

    public function removeuser(Request $request, string $projectid, string $userid)
{
    // Find the project and user by their IDs
    $project = Project::findOrFail($projectid);
    $user = User::findOrFail($userid);

    // Retrieve and delete tasks associated with the specific project and user
    $tasks = Task::where('project_id', $projectid)
                  ->where('user_id', $userid)
                  ->get();

   

    // Detach the user from the specific project
    $project->users()->detach($userid);

    // Redirect to the project show route with the project ID
    return redirect()->route('manager.project.show', ['project' => $projectid]);
}

public function task(string $projectid){

    $project = Project::findOrFail($projectid);

    $completedtasks = $project->tasks()->where('iscomplete' , 1)->get();

    $tasks = $project->tasks()->where('iscomplete' , 0)->get();

    return view('manager.project.task' , compact('tasks' , 'completedtasks' , 'project'));

}

public function assignuserform(string $projectid , string $taskid){

   
    $project = Project::findOrFail($projectid);

    $task = Task::findOrFail($taskid);

    $role = Role::where('name' , 'user')->first();

    $users = $role->users()->whereHas('projects', function ($query) use ($projectid) {
        $query->where('project_id', $projectid);
    })->get();

    return view('manager.task.assign', compact('users' , 'project' , 'task'));
}

public function assignuser(Request $request , string $projectid , string $taskid){
    $task = Task::findOrFail($taskid);

    $task->user_id= $request->user;

    $task->save();

    return redirect(route('manager.project.task' , ['id' => $projectid]));


}
    

}

