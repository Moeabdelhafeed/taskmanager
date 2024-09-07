<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('manager');
    }
    public function index()
    {
        

        $users =  Auth::user()->createdusers;
        return view('manager.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->id == $id){
            return redirect()->back()->withErrors(['edit'=> 'you can\'t edit yourself']);
        }
        $roles = Role::all();
        $user = User::find($id);

        if ($user->role->name == 'manager'){
            return redirect()->back()->withErrors(['delete'=> 'you can\'t edit an manager']);
        }
        return view('manager.user.edit', compact('user' , 'roles')) ;
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
        ],

        'role_id' => [
            'required',
            'integer',
        ],

        'email' => [
            'required',
            'string',
            'email',
            Rule::unique('users', 'email')->ignore($id)
        ],

        ]);

        $user = User::find($id);
        if (Auth::user()->id == $id){
            return redirect()->back()->withErrors(['edit'=> 'you can\'t edit yourself']);
        }

        if ($user->role->name == 'manager'){
            return redirect()->back()->withErrors(['delete'=> 'you can\'t edit an manager']);
        }

       

        $user ->name = $request->name;
        $user -> email = $request->email;
        $user -> role_id = $request->role_id;

        $user->save();
        
        return redirect(route('manager.user.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        if (Auth::user()->id == $id){
            return redirect()->back()->withErrors(['delete'=> 'you can\'t delete yourself']);
        }

        if ($user->role->name == 'manager'){
            return redirect()->back()->withErrors(['delete'=> 'you can\'t delete an manager']);
        }

        if ($user->tasks) {
            foreach ($user->tasks as $task) {
                $task->delete(); 
            }
        }

$user->delete();

        
        return redirect(route('manager.user.index'));
    }

    public function indextrash(){
        $users = User::onlyTrashed()->get();
        return view('manager.user.indextrash', compact('users'));
    }

    public function destroytrash(string $id){
        $user = User::onlyTrashed()->where('id',$id)->first();

        $tasks = $user->tasks()->onlyTrashed()->get();

       

        if ($tasks) {
            foreach ($tasks as $task) {
                $task->forceDelete(); 
            }
        }

        $user->forceDelete();
        return redirect(route('manager.user.indextrash'));
    }

    public function restoretrash(string $id){
        User::onlyTrashed()->where('id',$id)->restore();

        $user = User::find($id);

        if ($user->tasks) {
            foreach ($user->tasks()->withTrashed()->get() as $task) {
                $task->restore(); 
            }
        }
        return redirect(route('manager.user.indextrash'));
    }
}
