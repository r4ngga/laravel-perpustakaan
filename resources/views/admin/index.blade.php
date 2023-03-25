@extends('template/maindashboard')

@section('title','Dashboard')

@section('style')
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}
@endsection
@section('container')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col col-lg-4">
            <div class="card">
              <div class="card-body">
                @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
                    {{session('notify')}}
                </div>
                @endif
                <p>Welcome {{auth()->user()->name}}</p>
                <p>Admin Dashboard</p>
              </div>
            </div>
        </div>
        <div class="col col-lg-4">
          <div class="card border" style="">
            <div class="card-header">
                <h4>All Users</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  {{-- icon --}}
                  <i class="fa-solid fa-user fa-2x" aria-hidden="true"></i>
                </div>
                <div class="col">
                  {{-- count all user --}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col col-lg-4">
          <div class="card border">
            <div class="card-header">
                <h4>All Books</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  {{-- icon --}}
                 <i class="fa-solid fa-book fa-2x"></i>
                </div>
                <div class="col">
                  {{-- count all book --}}
                </div>
              </div>

            </div>
          </div>
        </div>
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col col-lg-4">
            <div class="card border">
               <div class="card-header">
                  <h4>Borrow a Book</h4>
               </div>
               <div class="card-body">
                  {{-- count borrow a book --}}
               </div>
            </div>
        </div>
        <div class="col col-lg-4">
            <div class="card">
                <div class="card-header"><h4>Book In / Out</h4></div>
                <div class="card-body" style="height: auto">
                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                        {{-- <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                        </div> --}}
                    </div> <canvas id="chartjs-pie" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script> --}}
<script>
$(document).ready(function() {
        var ctx = $("#chartjs-pie");
        var myLineChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Spring", "Summer", "Fall", "Winter"],
                datasets: [{
                    data: [1200, 1700, 800, 200],
                    backgroundColor: ["rgba(255, 0, 0, 0.5)", "rgba(100, 255, 0, 0.5)", "rgba(200, 50, 255, 0.5)", "rgba(0, 100, 255, 0.5)"]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Weather'
                }
            }
        });
    });
</script>

@endsection
