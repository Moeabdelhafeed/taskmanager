@extends('layouts.app')

@section('content')
<div class="container">

<h2 class="mt-4 ">{{$greeting }}</h2>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">show</th>
            <th scope="col">tasks</th>
            <th scope="col">notes</th>


        </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
        <tr>
            <td>{{$project -> name}}</td>
            <td><a href="{{route('user.task.index' , $project->id)}}" class="btn btn-primary">show</a></td>
            <td>
                @if($project->tasks->where('user_id', Auth::user()->id)->where('submitted_at', NULL)->count() > 0)
                <span class="badge bg-success rounded-circle">
                    {{$project->tasks->where('user_id', Auth::user()->id)->where('submitted_at', NULL)->count()}}
                </span>
                @else
                there are no new tasks
                @endif
            
            </td>

            <td>
                @if($project->tasks->where('user_id', Auth::user()->id)->where('submitted_at', NULL)->flatMap->notes->count() > 0)
                <span class="badge bg-primary rounded-circle">
                    {{$project->tasks->where('user_id', Auth::user()->id)->where('submitted_at', NULL)->flatMap->notes->count()}}
                </span>
                @else
                there are no new notes
                @endif
            
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection
