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

                    <form class="w-50 m-auto" method="post" action="{{route('user.task.submit' , [ 'taskid' =>  $taskid, 'projectid' => $projectid])}}" enctype="multipart/form-data">
                        <h1>submit a task proof</h1>
                        @csrf
                        <div class="mb-3 ">
                          <input type="text" class="form-control" placeholder="the title of the image" name="name" >
                        </div>
                        <div class="mb-3 ">
                            <input type="text" class="form-control" placeholder="the contetn of the image" name="content" >
                          </div>

                          <div class="mb-3">
                            <input type="file" name="image" id="file">
                          </div>

                          <hr>

                          @foreach ($notes as $note)
                          <div class="mb-3 ">
                            <input type="text" class="form-control" value="{{$note->content}}" disabled>
                          </div>
                          @endforeach
                          

                         
                        
                          

                        <button type="submit"  class="btn btn-success">create</button> 
                      </form>

                      <form method="post" action="{{route('user.task.submittask' , [ 'taskid' =>  $taskid, 'projectid' => $projectid])}}">
                        @csrf
                        <button type="submit"  class="btn btn-success">submit the task to review</button> 
                      </form>

                      


                      <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">content</th>
                            <th scope="col">image</th>
                            <th scope="col">edit</th>
                            <th scope="col">delete</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $image)
                        <tr>
                            <td>{{$image ->name}}</td>
                            <td>{{$image ->content}}</td>
                            <td><img src="{{$image->path}}" width="200px" alt=""></td>
                           
                            <td><a href="{{route('user.task.submitedit' , [ 'taskid' =>  $taskid, 'projectid' => $projectid , 'imageid' => $image->id] )}}" class="btn btn-warning">edit</a></td>

                            <td>
                                <form method="post" action="{{ route('user.task.submitdelete', ['projectid' => $projectid, 'taskid' => $taskid, 'imageid' => $image->id]) }}" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            
                            
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
</div>
@endsection
