@extends('layouts.app')

@section('content')
<div class="container">

    @php
    use Carbon\Carbon;
    $now = Carbon::now();
  @endphp


    <table class="table">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">content</th>
            <th scope="col">deadline</th>
            <th scope="col">submit</th>
            <th scope="col">notes</th>
            <th scope="col">status</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
        <tr>
            <td>{{$task -> name}}</td>
            <td>{{$task -> content}}</td>
            <td>{{$task->deadline}}</td>
            @if ($task->submitted_at == NULL)
            <td><a href="{{route('user.task.submitform' , [ 'taskid' =>  $task->id, 'projectid' => $project->id])}}" class="btn btn-success">submit</a></td>
            @else
            <td>
            <form action="{{ route('user.task.submitcancel', ['projectid' =>$project->id, 'taskid' => $task->id]) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">cancel submition</button>
            </form>
        </td>
        @endif 

        <td>
      
            @if($task->notes->count() > 0 && $task->submitted_at == NULL)
            <span class="badge bg-primary rounded-circle">
                {{$task->notes->count()}}
            </span>
            @else
            <p>no notes</p>
            @endif
        </td>

        <td>
      
            @php
    
            $deadline = Carbon::parse($task->deadline);
            $submitted = Carbon::parse($task->submitted_at);
        
        @endphp
    
        

        @if($task->submitted_at == NULL)
            @if($now->greaterThan($deadline))
            time is over
            @else
            there is time
            @endif
        @else

          @if($submitted->greaterThan($deadline))
           late
           @else
           on time
           @endif

        
        @endif

            
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection
