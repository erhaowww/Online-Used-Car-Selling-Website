@extends('admin/master')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Comment Analysis</h1>
            <canvas id="scatterChart" style="height:230px"></canvas>
        </div>
    </div>
</div>


<script>
    $(function () {
        /* ChartJS
        * -------
        * Data and config for chartjs
        */
        'use strict';

        var comments = {!! json_encode($comments) !!};

        var scatterChartData = {
            datasets: [{
                label: '1 Star',
                data: comments.filter(comment => comment.rating === 1)
                    .map(comment => ({ x: comment.num_likes, y: comment.rating })),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255,99,132,1)',
                borderWidth: 1
            }, {
                label: '2 Stars',
                data: comments.filter(comment => comment.rating === 2)
                    .map(comment => ({ x: comment.num_likes, y: comment.rating })),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: '3 Stars',
                data: comments.filter(comment => comment.rating === 3)
                    .map(comment => ({ x: comment.num_likes, y: comment.rating })),
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: '4 Stars',
                data: comments.filter(comment => comment.rating === 4)
                    .map(comment => ({ x: comment.num_likes, y: comment.rating })),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: '5 Stars',
                data: comments.filter(comment => comment.rating === 5)
                    .map(comment => ({ x: comment.num_likes, y: comment.rating })),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        }

        var scatterChartOptions = {
            scales: {
                xAxes: [{
                    type: 'linear',
                    position: 'bottom',
                    ticks: {
                        beginAtZero: true,
                        precision: 0 // <-- Set precision to 0 to remove decimal places
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Number of likes'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                        max: 5
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Star rating'
                    }
                }]
            }
        }

        if ($("#scatterChart").length) {
            var scatterChartCanvas = $("#scatterChart").get(0).getContext("2d");
            var scatterChart = new Chart(scatterChartCanvas, {
                type: 'scatter',
                data: scatterChartData,
                options: scatterChartOptions
            });
        }

    });
</script>

@endsection