@extends('admin.layout')
@section('title','Home')

@section('content')
    <div class="row col-">
            <div class="panel-box col-md-3 col-sm-6 col-xs-12">
        <span class="panel-box-icon bg-success">
            <li class="fa fa-picture-o" style="color: white"></li>
        </span>
                <div class="panel-box-content">
                    <span style="text-transform: uppercase">Wallpapers</span>
                    <span style="display: block;font-weight: bold;font-size: 18px;">{{$wallpaper->count()}}</span>
                </div>
            </div>
            <div class="panel-box col-md-3 col-sm-6 col-xs-12">
        <span class="panel-box-icon bg-danger">
            <li class="fa fa-tags" style="color: white"></li>
        </span>
                <div class="panel-box-content">
                    <span style="text-transform: uppercase">Categories</span>
                    <span style="display: block;font-weight: bold;font-size: 18px;">{{$category->count()}}</span>
                </div>
            </div>
        <div class="panel-box col-md-3 col-sm-6 col-xs-12">
        <span class="panel-box-icon bg-info">
            <li class="fa fa-android" style="color: white"></li>
        </span>
            <div class="panel-box-content">
                <span style="text-transform: uppercase">Android</span>
                <span style="display: block;font-weight: bold;font-size: 18px;">4</span>
            </div>
        </div>
        <div class="panel-box col-md-3 col-sm-6 col-xs-12">
        <span class="panel-box-icon bg-secondary">
            <li class="fa fa-eye" style="color: white"></li>
        </span>
            <div class="panel-box-content">
                <span style="text-transform: uppercase">Today Views</span>
                <span style="display: block;font-weight: bold;font-size: 18px;">{{$views->count()}}</span>
            </div>
        </div>
    </div>

    <canvas id="myChart"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['{{$chart_days[4]}}','{{$chart_days[3]}}','{{$chart_days[2]}}','{{$chart_days[1]}}','{{$chart_days[0]}}'],
                datasets: [{
                    label: '# of Views',
                    data: ['{{$chart_values[4]}}',{{$chart_values[3]}},{{$chart_values[2]}},{{$chart_values[1]}},{{$chart_values[0]}}]
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection
