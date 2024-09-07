@extends('layouts.app')

@section('content')
<div class="container">

          <h2 class="">projects</h2>
                    <a href="{{route('manager.project.create')}}" class="btn btn-success">create</a>
                    <a href="{{route('manager.project.indextrash')}}" class="btn btn-secondary">trash</a>

                    <div class="overflow-auto border p-3 mb-3 mt-3" style="height:350px">
                      <h2>on progress projects</h2>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">show</th>
                            <th scope="col">edit</th>
                            <th scope="col">delete</th>
                            <th scope="col">tasks completion</th>
                            <th scope="col"> tasks to review</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                          <tr>
                            <td>{{$project -> name}}</td>
                            <td><a href="{{route('manager.project.show' , $project->id)}}" class="btn btn-primary">show</a></td>
                            <td><a href="{{route('manager.project.edit' , $project->id)}}" class="btn btn-warning">edit</a></td>
                            <td>


                              <form method="post" action="{{route('manager.project.destroy', $project->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  class="btn btn-danger">delete</button> 
                              </form>

                            </td>
                            <td>
                              @if($project->tasks->count() == 0)
                              there is no tasks yets
                              @else
                              {{$project->tasks->where('iscomplete', 1)->count()}}/{{$project->tasks->count()}}
                              @endif                            
                            </td>
                            <td>
                              @if($project->tasks->whereNotNull('submitted_at')->count() > 0)
                              <span class="badge bg-primary rounded-circle">
                                {{$project->tasks->whereNotNull('submitted_at')->count()}}
                              </span>
                              @else
                              nothing to review
                  
                              @endif                            
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>

                    <div class="overflow-auto border p-3 mb-5" style="height:350px">
                      <h2>completed projects</h2>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">show</th>
                            <th scope="col">edit</th>
                            <th scope="col">delete</th>
                            <th scope="col">tasks completion</th>
                            <th scope="col"> tasks to review</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($completedprojects as $project)
                          <tr>
                            <td>{{$project -> name}}</td>
                            <td><a href="{{route('manager.project.show' , $project->id)}}" class="btn btn-primary">show</a></td>
                            <td><a href="{{route('manager.project.edit' , $project->id)}}" class="btn btn-warning">edit</a></td>
                            <td>


                              <form method="post" action="{{route('manager.project.destroy', $project->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  class="btn btn-danger">delete</button> 
                              </form>

                            </td>

                            <td>
                              @if($project->tasks->count() == 0)
                              there is no tasks yets
                              @else
                              {{$project->tasks->where('iscomplete', 1)->count()}}/{{$project->tasks->count()}}
                              @endif                            
                            </td>
                            <td>
                              @if($project->tasks->whereNotNull('submitted_at')->count() > 0)
                              <span class="badge bg-primary rounded-circle">
                                {{$project->tasks->whereNotNull('submitted_at')->count()}}
                              </span>
                              @else
                              nothing to review
                  
                              @endif                            
                            </td>

                            
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
</div>
@endsection







