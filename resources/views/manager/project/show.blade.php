@extends('layouts.app')

@section('content')
<div class="container">
   
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

            
                    <h2>users in the {{$project->name}} project</h2>
                    <a class=" btn btn-success" href="{{route('manager.project.adduser' , $project->id)}}">add user </a>

                    <a class=" btn btn-primary" href="{{route('manager.project.task' , $project->id)}}"> tasks for {{$project->name}} </a>
            
                    
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">email</th>
                            <th scope="col">tasks</th>
                            <th scope="col">delete</th>
                            <th scope="col">tasks to review</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                          <tr>
                            <td>{{$user -> name}}</td>
                            <td>{{$user -> email}}</td>
                            <td><a href="{{route('manager.task.index' , [ 'userid' =>  $user->id, 'projectid' => $project->id])}}" class="btn btn-primary">show</a></td>
                            <td>




                              <form method="post" action="{{route('manager.project.removeuser', [ 'userid' =>  $user->id, 'projectid' => $project->id])}}">
                                @csrf
                                @method('DELETE')
                            
                                <button type="submit"  class="btn btn-danger">delete</button> 
                              </form>

                            </td>
                            <td>
                              @if($user->tasks->whereNotNull('submitted_at')->count() > 0)
                              <span class="badge bg-primary rounded-circle">
                                {{$user->tasks->whereNotNull('submitted_at')->count()}}
                              </span>
                              @else
                              nothing to review
                  
                              @endif                            
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
</div>
@endsection
