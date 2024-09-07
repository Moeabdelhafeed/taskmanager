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

                        <h2>users</h2>



                    <a href="{{route('register')}}" class="btn btn-success">create</a>
                    <a href="{{route('manager.user.indextrash')}}" class="btn btn-secondary">trash</a>

                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">edit</th>
                            <th scope="col">delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                          <tr>
                            <td>{{$user -> name}}</td>
              
                            <td><a href="{{route('manager.user.edit' , $user->id)}}" class="btn btn-warning">edit</a></td>
                            

                            <td>


                              <form method="post" action="{{route('manager.user.destroy', $user->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  class="btn btn-danger">delete</button> 
                              </form>

                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
</div>
@endsection
