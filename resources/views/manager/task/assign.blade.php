@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{route('manager.project.task.assign', ['projectid' => $project->id , 'taskid' => $task->id])}}" method="post">
    @csrf
    @method('PUT')
    <select name="user" class="form-select mb-3" >
        <option value="{{NULL}}"> the user is deleted please choose another user </option>
        @foreach ($users as $user)
        <option value="{{ $user->id }}"> {{ $user->name }}</option>
        @endforeach
    </select>

    <button class="btn btn-warning" type="submit">assign</button>
</form>
</div>
@endsection
