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
                        <h2>trashed projects</h2>

                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">restore</th>
                            <th scope="col">delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                          <tr>
                            <td>{{$project -> name}}</td>

                            <td><a href="{{route('manager.project.restoretrash', $project->id)}}"  class="btn btn-primary">restore</button> </td>

                            <td>
                              <form method="post" action="{{route('manager.project.destroytrash', $project->id)}}">
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
