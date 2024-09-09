<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Note;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;

class TaskManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('manager');
        $this->middleware('task');
    }

    public function index(string $projectid , string $userid)
    {
        $user = User::findOrFail($userid);
        $tasks = Task::where('project_id', $projectid)
        ->where('user_id', $userid)->where('iscomplete' , 0)
        ->get();
    

        return view('manager.task.index', compact('tasks', 'projectid' , 'userid', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create (string $projectid , string $userid)
    {
        $user = User::find($userid);
        return view('manager.task.create', compact('projectid' , 'userid', 'user'));
    }

    public function show(){

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , string $projectid, string $userid)
    {
        $validated = $request->validate([
            'name' => [
            'required',
            'string',
        ],
        'content' => [
            'required',
            'string',
        ],

        'deadline' => [
            'required',
            'date'
        ]
        ]);

        $task = new Task;

        $task-> name = $validated['name'];

        $task-> content = $validated['content'];

        $task->user_id = $userid;

        $task->project_id = $projectid;

        $task->deadline = $request->deadline;

        $task -> save();

        return redirect(route('manager.task.index', compact('projectid' , 'userid')));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $projectid, string $userid, string $id)
    {
        $task = Task::find($id);
        $notes = $task->notes;
        $project = Project::find($projectid);

        $users = $project->users()->where('id', '!=', $userid)->get();
        $taskuser = User::find($userid);

        $images = $task->images;

        return view('manager.task.edit', compact('projectid' , 'userid', 'task', 'users', 'taskuser', 'images', 'notes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $projectid, string $userid , string $id)
    {
        $validated = $request->validate([
            'name' => [
            'required',
            'string',
        ],
        'content' => [
            'required',
            'string',
        ],
        'user' => [
            'required',
            'integer',
        ],

        'deadline' => [
            'required',
            'date'
        ]

        ]);

       
        $originalnotes = $request->originalnotes;

        if($originalnotes){

        foreach($originalnotes as $noteid => $notecontent){
            $originalnote = Note::findOrFail($noteid);
            $originalnote->content = $notecontent;
            $originalnote->save();
        }
    }

        $notes = $request->notes;

        if($notes){
            foreach($notes as $noteid => $notecontent){
                if($notecontent == ""){
                    continue;
                }
                $note = new Note;
                $note->content = $notecontent;
                $note->task_id = $id;
                $note->save();
            }
        }

       

        $task = Task::find($id);

        $task -> name  = $request->name;
        $task -> content  = $request->content;
        $task -> user_id = $request->user;
        $task->deadline = $request->deadline;
        $task->submitted_at = NULL;
        $task ->save();

        return redirect(route('manager.task.index', compact('projectid' , 'userid')));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $projectid, string $userid , string $id)
{
    // Find the task by its ID
    $task = Task::find($id);

    // Check if the task exists before proceeding
    if ($task) {
        // Delete all images related to the task
        foreach ($task->images as $image) {
            $image->delete();
        }

        // Delete all notes related to the task
        foreach ($task->notes as $note) {
            $note->delete();
        }

        // Permanently delete the task itself
        $task->forceDelete();
    }

    // Redirect to the task index page
    return redirect()->back();
}


    public function notedelete(string $projectid, string $userid, string $taskid, string $noteid) {
        // Find and delete the specific note
        $note = Note::findOrFail($noteid);
        $note->delete();
    
        // Redirect to the task edit page, ensuring the parameters are correct
        return redirect()->route('manager.task.edit', [
            'projectid' => $projectid,
            'task' => $taskid,
            'userid' => $userid,
        ]);
    }

    public function taskcomplete(string $projectid, string $userid, string $taskid){
        $task = Task::findOrFail($taskid);
        $task->iscomplete = true;
        $task->save();

        return redirect(route('manager.task.index', compact('projectid', 'userid')));
    }

    public function taskcompleteindex(string $projectid, string $userid){

        $user = User::findOrFail($userid);
        $tasks = $user->tasks->where('iscomplete' , 1)->where('project_id' , $projectid);
        return view('manager.task.completeindex', compact('tasks' , 'projectid' , 'userid', 'user'));
    }

    public function taskcompleterestore(string $projectid, string $userid, string $taskid){

        $task = Task::findOrFail($taskid);
        $task->iscomplete = false;
        $task->save();

        return redirect(route('manager.task.index', compact('projectid', 'userid')));
    }

    
    
}