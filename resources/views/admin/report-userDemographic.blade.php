@extends('admin/master')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">User Demographic</h1>
            <canvas id="pieChart" style="height:230px"></canvas>
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
        
        var doughnutPieData = {
            datasets: [{
            data: {{ json_encode($dataArray) }},
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ['not filled', 'female', 'male']
            
        };
        var doughnutPieOptions = {
            responsive: true,
            animation: {
            animateScale: true,
            animateRotate: true
            }
        };

        if ($("#pieChart").length) {
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: doughnutPieData,
            options: doughnutPieOptions
            });
        }

    });
</script>

@endsection