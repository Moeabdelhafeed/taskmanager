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
                        <h2>trashed users</h2>

                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">restore</th>
                            <th scope="col">delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                          <tr>
                            <td>{{$user -> name}}</td>

                            <td><a href="{{route('manager.user.restoretrash', $user->id)}}"  class="btn btn-primary">restore</button> </td>

                            <td>
                              <form method="post" action="{{route('manager.user.destroytrash', $user->id)}}">
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
