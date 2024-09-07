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
                            @if(is_null($task->user) || is_null($task->user->name))
                                  <td>The user is no longer in the project (add them back)</td>
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
                            @if(is_null($task->user) || is_null($task->user->name))
                                  <td>The user is no longer in the project (add them back)</td>
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
                    
                          </tr>
                          @endforeach
                        </tbody>
                      </table>

                    </div>


                   


                    
</div>
@endsection
