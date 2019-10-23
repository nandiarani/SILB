@extends('layouts.dashboard')

@section('title')

<title>Peramalan Penjualan</title>

@endsection

@section('breadcrumb')

@endsection

@section('contents')

<div class="card">
    <div class="card-body">
        <div class="col md-12" style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
            <h4 class="card-title">Peramalan penjualan</h4>
        </div>
        <div class="col md-12">
            <div id="loader" style="width:100%;text-align:center;margin:10% 0px;">
                <img src="{{asset('assets/icon/loader.gif')}}" style="width:80px;height:80px;"/>
            </div>
            <canvas id="canvas">test</canvas>
        </div>
    </div>
</div>
@endsection

@section('js')
  <script>
      $(window).ready(function () {
          var ctx = document.getElementById('canvas').getContext('2d');
          $.ajax({
              url: '/fetchForecast',
              type: "GET",
              dataType: "json",
              success: function (result) {
                  var labeldata = result[0];
                  var forecast = result[1];
                  var sell = result[2].map(Number);
                  for (var i = 0; i < sell.length; i++) {
                      if (sell[i] == 0) {
                          sell[i] = null;
                      }
                  }
                  
          $('#loader').remove();
                  window.myLine = new Chart(ctx,{
                    type: 'line',
                      data: {
                          labels: labeldata,
                          datasets: [{
                              label: 'Hasil Peramalan',
                              fill: false,
                              backgroundColor: window.chartColors.red,
                              borderColor: window.chartColors.red,
                              data: forecast,
                          }, {
                              label: 'Hasil penjualan',
                              fill: false,
                              backgroundColor: window.chartColors.blue,
                              borderColor: window.chartColors.blue,
                              data: sell,
                          }]
                      },
                      options: {
                          responsive: true,
                          tooltips: {
                              mode: 'index',
                              intersect: false,
                          },
                          hover: {
                              mode: 'nearest',
                              intersect: true
                          },
                          scales: {
                              xAxes: [{
                                  display: true,
                                  scaleLabel: {
                                      display: true,
                                      labelString: 'Month'
                                  }
                              }],
                              yAxes: [{
                                  display: true,
                                  scaleLabel: {
                                      display: true,
                                      labelString: 'Value'
                                  }
                              }]
                          }
                        }
                    });
              }
          });
          }
      )
  </script>
@endsection
