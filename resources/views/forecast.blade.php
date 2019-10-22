@extends('layouts.dashboard')

@section('title')

<title>Peramalan Penjualan</title>

@endsection

@section('breadcrumb')

@endsection

@section('contents')

<div class="card" >
        <div class="card-body">
            <div class="col md-12"  style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
                <h4 class="card-title">Peramalan penjualan</h4>
            </div>
            <div class="col md-12">
                    <div id="forecast-chart"></div>
            </div>
        </div>
    </div>
@endsection
    
@section('js')
    <script type="text/javascript">
        
    $(document).ready(function(){
        $.chart();
    });
    $.chart=function(){
        $year=$('#year').val();
        $month=$('#month').val();
        $('#forecast-chart').empty();
        $.ajax({
            url: '/fetchForecast',
            type: "GET",
            dataType: "json",
            success: function(result) {
                Morris.Area({
                    element: 'forecast-chart',
                    data: [
                        {
                          "period": "2018-10-01",
                          "penjualan": 29400,
                          "mean":27268
                        },
                        {
                          "period": "2018-11-01",
                          "penjualan": 33500,
                          "mean":27268
                        },
                        {
                          "period": "2018-12-01",
                          "penjualan": 39000,
                          "mean":27268
                        },
                        {
                          "period": "2019-01-01",
                          "penjualan": 43900,
                          "mean":27268
                        },
                        {
                          "period": "2019-02-01",
                          "penjualan": 43000,
                          "mean":27268
                        },
                        {
                          "period": "2019-03-01",
                          "penjualan": 37700,
                          "mean":27268
                        },
                        {
                          "period": "2019-04-01",
                          "penjualan": 34200,
                          "mean":27268
                        },
                        {
                          "period": "2019-05-01",
                          "penjualan": 31850,
                          "mean":27268
                        },
                        {
                          "period": "2019-06-01",
                          "penjualan": 28500,
                          "mean":27268
                        },
                        {
                          "period": "2019-07-01",
                          "penjualan": 27900,
                          "mean": 27268
                        },
                        {
                          "period": "2019-08-01",
                          "penjualan": 31100,
                          "mean": 28665
                        },
                        {
                          "period": "2019-09-01",
                          "penjualan": 35300,
                          "mean": 33475
                        },
                        {
                          "period": "2019-10-01",
                          "mean": 34884
                        }
                      ],
                    xkey: "period",
                    ykeys: ["mean", "penjualan"],
                    labels: ['Peramalan', 'Penjualan'],
                    pointSize: 0,
                    fillOpacity: 0,
                    pointStrokeColors: ['#20aee3', '#24d2b5'],
                    behaveLikeLine: true,
                    gridLineColor: '#e0e0e0',
                    lineWidth: 3,
                    hideHover: 'auto',
                    lineColors: ['#20aee3', '#24d2b5'],
                    resize: true
            
                });
            }
        });
      }
      
    </script>
@endsection