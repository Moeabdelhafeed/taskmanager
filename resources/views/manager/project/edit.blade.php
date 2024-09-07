@extends('layouts.app')

@section('content')
<div class="container">
   
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="w-50 m-auto" method="post" action="{{route('manager.project.update', $project->id)}}">
                        <h1>edit {{$project->name }} project</h1>
                        @csrf
                        @method('PUT')
                        <div class="mb-3 ">
                          <input type="text" class="form-control" placeholder="name of the project" value="{{ $project -> name}}" name="name" >
                        </div>
                        @error('name')
                        <div class="alert alert-danger">
                            {{ $message}}
                        </div>
                        @enderror
                        <button type="submit"  class="btn btn-warning">edit</button> 
                      </form>
</div>
@endsection
