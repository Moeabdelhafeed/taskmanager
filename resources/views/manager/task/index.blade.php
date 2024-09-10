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

                    <h2>tasks for {{$user->name}}</h2>


                    <a href="{{route('manager.task.create' , ['projectid' => $projectid, 'userid' => $userid])}}" class="btn btn-success">create</a>

                    @if ($user->tasks->where('iscomplete' , 1)->count() > 0)
                    <a href="{{route('manager.task.completeindex' , ['projectid' => $projectid, 'userid' => $userid])}}" class="btn btn-primary">completed tasks ({{$user->tasks->where('iscomplete' , 1)->count()}})</a>
                    @else
                    <a  class="disabled btn btn-primary">completed tasks ({{$user->tasks->where('iscomplete' , 1)->count()}})</a>
                    @endif
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">name</th>
                            <th scope="col">content</th>
                            <th scope="col">user name</th>
                            <th scope="col">deadline</th>
                            <th scope="col">status</th>
                            <th scope="col">review</th>
                            <th scope="col">delete</th>
                            <th scope="col">complete</th>
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
                            <td>{{$task -> user -> name}}</td>
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
                            <td><a href="{{route('manager.task.edit' , ['projectid' => $projectid, 'userid' => $userid, 'task' => $task->id])}}" class="btn btn-warning">review</a></td>
                            <td>


                              <form method="post" action="{{route('manager.task.destroy', ['projectid' => $projectid, 'userid' => $userid, 'task' => $task->id])}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  class="btn btn-danger">delete</button> 
                              </form>

                            </td>
                            <td>
                              <form method="POST" action="{{route('manager.task.complete', ['projectid' => $projectid, 'userid' => $userid, 'taskid' => $task->id])}}">
                                @csrf
                                @method('PUT')
                                @if($task->submitted_at == NULL)
                                  <button class="btn btn-success disabled">complete</button>
                                @else
                                <button class="btn btn-success">complete</button>
                                @endif

                              </form>
                              
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
</div>
@endsection
