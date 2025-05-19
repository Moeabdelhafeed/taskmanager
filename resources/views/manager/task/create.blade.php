@extends('layouts.app')

@section('content')
<div class="container">
   
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="w-50 m-auto" method="post" action="{{ route('manager.task.store', ['projectid' => $projectid, 'userid' => $userid]) }}">
                        @csrf
                        <h3>task for {{$user->name}}</h3>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Name of the task" value="{{ old('name') }}" name="name">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="content of the task" value="{{ old('name') }}" name="content">
                        </div>

                        <div class="mb-3">
                            <input type="datetime-local" class="form-control" placeholder="deadline" name="deadline">
                        </div>

                       
                        <button type="submit" class="btn btn-success">Create</button>
                    </form>
                    
</div>
@endsection
