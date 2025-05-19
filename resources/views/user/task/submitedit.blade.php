@extends('layouts.app')

@section('content')
<div class="container">
    
  @if($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif


                    <form class="w-50 m-auto" method="post" action="{{route('user.task.submitupdate' , [ 'taskid' =>  $taskid, 'projectid' => $projectid, 'imageid' => $image->id])}}" enctype="multipart/form-data">
                        <h1>update a task proof</h1>
                        @csrf
                        @method('PUT')
                        <div class="mb-3 ">
                          <input type="text" class="form-control" placeholder="the title of the image"  value="{{$image->name}}" name="name" >
                        </div>
                        <div class="mb-3 ">
                            <input type="text" class="form-control" placeholder="the contetn of the image" value="{{$image->content}}" name="content" >
                          </div>

                          <div class="mb-3">
                            <img src="{{$image->path}}" alt="" width="200px">
                          </div>

                          <div class="mb-3">
                            <input type="file" name="image" id="file">
                          </div>
                        <button type="submit"  class="btn btn-success">update</button> 
                      </form>

</div>
@endsection
