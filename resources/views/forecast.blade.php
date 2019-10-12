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
                    data: result,
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