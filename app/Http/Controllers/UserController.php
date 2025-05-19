<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');

        
        $this->middleware('submitcancel', ['only' => ['submitform', 'submit', 'submitedit', 'submitdelete' , 'submitupdate', 'submittask' ]]);

        $this->middleware('taskuser', ['except' => ['index', 'submit', 'submitedit', 'submitupdate',]]);

        $this->middleware('submituser', ['only' => ['submitform']]);
        
    }


    public function index(){
        $currentHour =  $ldate = date('H');

        if ($currentHour >= 6 && $currentHour < 12) {
            $greeting = 'Good morning, ' . Auth::user()->name;
        } elseif ($currentHour >= 12 && $currentHour < 18) {
            $greeting = 'Good afternoon, ' . Auth::user()->name;
        } elseif ($currentHour >= 18 && $currentHour < 21) {
            $greeting = 'Good evening, ' . Auth::user()->name;
        } else {
            $greeting = 'Good night, ' . Auth::user()->name;
        }

        $projects = Auth::user()->projects;

        return view('user.home', compact('greeting', 'projects'));
    }

    public function indextask(string $projectid){
        $project = Project::find($projectid);
        $tasks = $project->tasks->where('user_id', Auth::user()->id);
    
        

        return view('user.task.index', compact('tasks','project'));

    }

    public function submitform(string $projectid , string $taskid ){
        $images = Image::where('task_id', $taskid)->get();
        $task = Task::findOrFail($taskid);
        $notes = $task->notes;
        return view('user.task.submit', compact('taskid' , 'projectid', 'images', 'notes'));
    }

    public function submit(Request $request, string $projectid , string $taskid ){
        
        $validated = $request->validate([
            'name' => [
            'required',
            'string',
            'max:255',
        ],

        'content' => [
            'required',
            'string',
            'max:255',
        ],

        'image' => [
            'required',
            'file',
        ],
        ]);


        $file = $request->file('image');
        $name = $request->name;
        $content = $request->content;
        $taskid = $request->taskid;

        $task = Task::findOrFail($taskid);
        $imagename = $file->getClientOriginalName();



        $file->move('images', $imagename);

        $image = new Image;
        $image->name = $name;
        $image->content = $content;
        $image->task_id= $taskid;
        $image->path = $imagename;
        $image->save();
        
        return redirect(route('user.task.submitform', compact('taskid', 'projectid')));
    }

    public function submitedit(string $projectid ,string $taskid, string $imageid)
    {
        $image = Image::findOrFail($imageid);
        return view('user.task.submitedit', compact('taskid', 'projectid', 'image'));
    }
    
    public function submitupdate(Request $request, string $projectid, string $taskid, string $imageid)
    {
     
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'image' => 'required|file', 
        ]);
    
       
        $image = Image::findOrFail($imageid);
    
        $file = $request->file('image');
        $imagename = $file->getClientOriginalName(); 
    
     
        $file->move(public_path('images'), $imagename);
    
      
        $oldImagePath = public_path('images/' . $image->path);
        

        $image->name = $request->name;
        $image->path = $imagename; 
        $image->content = $request->content;
    
      
        $image->save();
    
    
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    
        
        return redirect(route('user.task.submitform', compact('taskid', 'projectid')));
    }

    public function submitdelete(Request $request, string $projectid, string $taskid, string $imageid){
        $image = Image::findOrFail($imageid);
        $image->delete();
        $imagePath = $image->path;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

         return redirect(route('user.task.submitform', compact('taskid', 'projectid')));
    
    }

    public function submittask(Request $request, string $projectid, string $taskid){
        $task = Task::findOrFail($taskid);

        $now = Carbon::now();
        $task->submitted_at = $now;

        $task->save();

        return redirect(route('user.task.index', compact('projectid')));
        
    }

    public function submitcancel(Request $request, string $projectid, string $taskid){

        $task = Task::findOrFail($taskid);
        $task->submitted_at = NULL;

        $task->save();

        return redirect(route('user.task.index', compact('projectid')));

    }
    

}
