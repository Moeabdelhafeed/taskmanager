@extends('layouts.app')

@section('content')
<div class="container">
   
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="w-50 m-auto" method="post" action="{{route('manager.user.update', $user->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 ">
                          <input type="text" class="form-control" placeholder="name of the user" value="{{ $user -> name}}" name="name" >
                        </div>
                        <div class="mb-3 ">
                            <input type="text" class="form-control" placeholder="email" value="{{ $user -> email}}" name="email" >
                          </div>

                          @foreach ($roles as $role)

                          @if($user -> role -> name == $role->name)

                          <div class="form-check">
                              <input class="form-check-input" value="{{$role ->id}}" type="radio" name="role_id" id="{{$role ->name}}" checked>
                              <label class="form-check-label" for="{{$role ->name}}">
                                  {{$role ->name}}
                              </label>
                            </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" value="{{$role ->id}}" type="radio" name="role_id" id="{{$role ->name}}">
                                <label class="form-check-label" for="{{$role ->name}}">
                                    {{$role ->name}}
                                </label>
                              </div>
                              @endif
                          @endforeach
                          @if($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                      
                        <button type="submit"  class="btn btn-warning">edit</button> 
                      </form>
</div>
@endsection
