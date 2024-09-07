@extends('layouts.app')

@section('content')
<div class="container">
   
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="w-50 m-auto" method="post" action="{{route('manager.project.storeuser',)}}">

                        <h1>add a new user to {{$project->name}} project</h1>
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $id }}">

                        <select name="user" class="form-select">
                            <option selected>Open this select menu</option>
                        @foreach ($users as $user)
    
                            <option value="{{$user->id}}"> {{$user->name}}</option>
            

                        @endforeach
                    </select>

                        
                        <button type="submit"  class="mt-3 btn btn-success">create</button> 
                      </form>

                      @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
</div>
@endsection
