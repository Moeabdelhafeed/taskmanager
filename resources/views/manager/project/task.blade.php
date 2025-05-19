@extends('layouts.app')

@section('content')
<div class="container">

  @php
    use Carbon\Carbon;
    $now = Carbon::now();
  @endphp
   
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="overflow-auto border p-3 mb-5" style="height: 400px">


                        <h2>not completed tasks</h2>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">name</th>
                            <th scope="col">content</th>
                            <th scope="col">user name</th>
                            <th scope="col">deadline</th>
                            <th scope="col">status</th>
                            <th scope="col">assign</th>
                            <th scope="col">delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)

                            @php
                          $deadlinetime = Carbon::parse($task->deadline);
                        @endphp
                          <tr>
                            <td>{{$task -> name}}</td>
                            <td>{{$task -> content}}</td>
                            @if(!$project->users->contains($task->user))
          
                                  <td  class="text-danger fw-bold">The user is no longer in the project</td>
                              @else
                                  <td>{{ $task->user->name }}</td>
                              @endif
                            <td>{{$task -> deadline}}</td>
                            @if ($task->submitted_at != NULL)
                              @if($deadlinetime->isPast())
                                <td>late</td>
                              @else
                              <td>on time</td>
                              @endif
                            @else
                              @if($deadlinetime->isPast())
                                <td> the time is over</td>
                                @else
                                <td> on progress</td>
                                @endif
                            @endif

                            <td>
                              @if ($project->users->contains($task->user))
                               <a class="btn btn-warning disabled">assign</a>
                               @else
                               <a class="btn btn-warning" href="{{route('manager.project.task.assignform' , ['projectid' => $project->id , 'taskid' => $task ->id] )}}">assign</a>
                               @endif
                         </td>

                         <td>
                          @if ($project->users->contains($task->user))
                          <a class="btn btn-danger" >delete</a>
                          @else
                          <form method="POST" action="{{route('manager.project.task.delete' , ['projectid' => $project->id , 'taskid' => $task ->id])}}">
                           @csrf
                           @method('DELETE')

                           <button type="submit" class="btn btn-danger">delete</button>
                          </form>
                           @endif
                          </td>
                    
                    
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>


                      <div class="overflow-auto border p-3" style="height: 400px">


                        <h2> completed tasks</h2>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">name</th>
                            <th scope="col">content</th>
                            <th scope="col">user name</th>
                            <th scope="col">deadline</th>
                            <th scope="col">status</th>
                            <th scope="col">assign</th>
                            <th scope="col">delete</th>
                          </tr>
                          
                        </thead>
                        <tbody>
                            @foreach ($completedtasks as $task)

                            @php
                          $deadlinetime = Carbon::parse($task->deadline);
                        @endphp
                          <tr>
                            <td>{{$task -> name}}</td>
                            <td>{{$task -> content}}</td>
                            @if(!$project->users->contains($task->user))
          
                            <td class="text-danger fw-bold">The user is no longer in the project</td>
                        @else
                            <td>{{ $task->user->name }}</td>
                        @endif

                            <td>{{$task -> deadline}}</td>
                            @if ($task->submitted_at != NULL)
                              @if($deadlinetime->isPast())
                                <td>late</td>
                              @else
                              <td>on time</td>
                              @endif
                            @else
                              @if($deadlinetime->isPast())
                                <td> the time is over</td>
                                @else
                                <td> on progress</td>
                                @endif
                            @endif

                            <td>
                              @if ($project->users->contains($task->user))
                               <a class="btn btn-warning disabled" >assign</a>
                               @else
                               <a class="btn btn-warning" href="{{route('manager.project.task.assignform' , ['projectid' => $project->id , 'taskid' => $task ->id] )}}">assign</a>
                               @endif
                         </td>

                         <td>
                          @if ($project->users->contains($task->user))
                          <a class="btn btn-danger" >delete</a>
                          @else
                          <form method="POST" action="{{route('manager.project.task.delete', ['projectid' => $project->id , 'taskid' => $task ->id])}}">
                           @csrf
                           @method('DELETE')

                           <button type="submit" class="btn btn-danger">delete</button>
                          </form>
                           @endif
                          </td>
                    
                          </tr>
                          @endforeach
                        </tbody>
                      </table>

                    </div>


                   


                    
</div>
@endsection
