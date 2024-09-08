@extends('layouts.app')

@section('content')
<div class="container">

<h2 class="mt-4 ">{{$greeting }}</h2>

<div class="d-flex justify-content-between">
    <div class="overflow-auto border p-3 mb-5 w-50" style="height:350px">
      <h2>last addded projects</h2>
      <a href="{{route('manager.project.index')}}" style="text-decoration: none">
      <table class="table">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">tasks completion</th>
              <th scope="col"> tasks to review</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($projects as $project)
            <tr>
              <td>{{$project -> name}}</td>
              <td>
                @if($project->tasks->count() == 0)
                there is no tasks yets
                @else
                {{$project->tasks->where('iscomplete', 1)->count()}}/{{$project->tasks->count()}}
                @endif                            
              </td>
              <td>
                @if($project->tasks->whereNotNull('submitted_at')->count() > 0 && !$project->tasks->contains('iscomplete', true))
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
      </a>
      </div>

      <div style="max-width: 500px; max-height:500px;">
        <canvas id="projectChart"></canvas>
      </div>

    </div>




    <div class="d-flex justify-content-between">
      <div class="overflow-auto border p-3 mb-5 w-50" style="height:350px">
        <h2>Statistics</h2>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">total</th>
              </tr>
            </thead>
            <tbody>
            
                @foreach ($table as $name=>$total)
              <tr>
                <td>{{$name}}</td>
                <td> {{$total}}</td>
              </tr>
              @endforeach
      
            </tbody>
          </table>
        </div>
  
        <div class="" style="max-width: 500px; max-height:500px;">
          <canvas id="tasksChart"></canvas>
        </div>
  
      </div>


      


      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</div>

<script>
  const ctx = document.getElementById('projectChart').getContext('2d');
  const projectChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: ['Completed Projects', 'Incomplete Projects'],
          datasets: [{
              label: 'Projects',
              data: [{{ $completedCount }}, {{ $incompleteCount }}],
              backgroundColor: [
                  'rgba(54, 162, 235, 0.6)', 
                  'rgba(255, 99, 132, 0.6)' 
              ],
              borderColor: [
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 99, 132, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              legend: {
                  position: 'top',
              },
          }
      }
  });


  const ctxTasks = document.getElementById('tasksChart').getContext('2d');
const tasksChart = new Chart(ctxTasks, {
    type: 'pie',
    data: {
        labels: ['Completed Tasks', 'Not Completed Tasks'],
        datasets: [{
            label: 'Tasks',
            data: [{{ $comptasks }}, {{ $incomptasks }}],
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)', 
                'rgba(255, 205, 86, 0.6)' 
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 205, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
        }
    }
});



</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
