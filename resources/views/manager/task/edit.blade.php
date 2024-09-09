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

    <!-- Main Task Update Form -->


    @if ($task->iscomplete == 1)

    <form class="w-50 m-auto" method="post" action="{{ route('manager.task.update', ['projectid' => $projectid, 'userid' => $userid, 'task' => $task->id]) }}">
        @csrf
        @method('PUT')

        <h2>view {{$task->user->name}} task</h2>
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="name of the task" value="{{ $task->name }}" name="name" disabled>
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" placeholder="task content" value="{{ $task->content }}" name="content" disabled>
        </div>

        <div class="mb-3">
            <input type="datetime-local" class="form-control" placeholder="deadline" value="{{ $task->deadline }}" name="deadline" disabled>
        </div>

        <select name="user" class="form-select mb-3" disabled>
            <option value="{{ $taskuser->id }}"> {{ $taskuser->name }}</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"> {{ $user->name }}</option>
            @endforeach
        </select>

        <!-- Notes Section -->
        <div id="notes-container">
            @if($notes)
                <hr>
                @foreach ($notes as $note)
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="originalnotes[{{$note->id}}]" value="{{$note->content}}" placeholder="content" disabled>
        
                    
                                <a class="btn btn-danger disabled" href="{{route('manager.project.task.notedelete' , ['projectid' => $projectid, 'userid' => $userid,'taskid' => $task->id, 'noteid' => $note->id])}}" class="btn -btn-danger"> delete</a>

              
                    </div>
                @endforeach
            @endif
        </div>


        <button type="submit" class="btn btn-warning disabled">Resubmit</button>
        <a href="" class="btn btn-primary disabled" id="addnote">Add Note</a>


        
    </form>

    @else

    <form class="w-50 m-auto" method="post" action="{{ route('manager.task.update', ['projectid' => $projectid, 'userid' => $userid, 'task' => $task->id]) }}">
        @csrf
        @method('PUT')
        <h2>edit {{$task->user->name}} task</h2>
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="name of the task" value="{{ $task->name }}" name="name" >
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" placeholder="task content" value="{{ $task->content }}" name="content" >
        </div>

        <div class="mb-3">
            <input type="datetime-local" class="form-control" placeholder="deadline" value="{{ $task->deadline }}" name="deadline" >
        </div>

        <select name="user" class="form-select mb-3" >
            <option value="{{ $taskuser->id }}"> {{ $taskuser->name }}</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"> {{ $user->name }}</option>
            @endforeach
        </select>

        <!-- Notes Section -->
        <div id="notes-container">
            @if($notes)
                <hr>
                @foreach ($notes as $note)
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="originalnotes[{{$note->id}}]" value="{{$note->content}}" placeholder="content" >
        
                    
                                <a class="btn btn-danger" href="{{route('manager.project.task.notedelete' , ['projectid' => $projectid, 'userid' => $userid,'taskid' => $task->id, 'noteid' => $note->id])}}" class="btn -btn-danger"> delete</a>

              
                    </div>
                @endforeach
            @endif
        </div>

        
        <button type="submit" class="btn btn-warning ">Resubmit</button>
        @if ($task->submitted_at == NULL)
        <a href="" class="btn btn-primary disabled" id="addnote">Add Note</a>
        @else
        <a href="" class="btn btn-primary " id="addnote">Add Note</a>
        @endif


        
    </form>




    @endif



    
    @if ($task->submitted_at != NULL)
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Content</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $image)
                    <tr>
                        <td>{{ $image->name }}</td>
                        <td>{{ $image->content }}</td>
                        <td><img src="{{ $image->path }}" width="200px" alt=""></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>




<script>
    let noteCount = 0; 

    document.getElementById('addnote').addEventListener('click', function(event) {
        noteCount++;
        event.preventDefault();
        
        const newNoteField = document.createElement('div');
        newNoteField.classList.add('mb-3');
        newNoteField.innerHTML = `
            <input type="text" class="form-control" name="notes[${noteCount}]" placeholder="Note ${noteCount}">
        `;
        
        document.getElementById('notes-container').appendChild(newNoteField);
    });
</script>
@endsection
