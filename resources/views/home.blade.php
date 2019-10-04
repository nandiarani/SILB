@extends('layouts.dashboard')

@section('title')

<title>Dashboard</title>

@endsection

@section('breadcrumb')

@endsection

@section('contents')

<div class="card" >
        <div class="card-body">
            <div class="col md-12"  style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
                <h4 class="card-title">Laporan Keuangan</h4>
            </div>
            <form action="{{url('report')}}" method="POST">
                @csrf
                        <div class="form-group">
                            <div class="row" >
                                <div class="col-md-1" style="margin-left:15px;">
                                            <label style="font-size:18px;margin:0;padding: 0.375rem 0.75rem;">Filter</label>
                                </div>
                                
                                    <div class="col-md-2">
                                        <select name="tipe" id="tipe" class="form-control form-control-line">
                                                <option value="Bulanan" selected>Bulanan</option>
                                                <option value="Tahunan">Tahunan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="year" id="year" class="form-control form-control-line">
                                            @foreach ($dropdownyear as $year)
                                                <option value="{{$year->year}}" selected>{{$year->year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="month" id="month" class="form-control form-control-line">
                                                <option value="0">-</option>
                                                @foreach ($dropdownmonth as $month)
                                                    <option value="{{$month->mon}}">{{$month->month}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4" style="padding-right:0px;">
                                        <button class="btn waves-effect waves-light btn btn-primary pull-right hidden-sm-down" type="submit">Detail Laporan</button>
                                    </div>
                                </div>
                        </div>
            </form>
            <div class="col md-12">
                    <div id="report-chart"></div>
            </div>
        </div>
    </div>
@endsection
    
@section('js')
    <script type="text/javascript">
    $month=0;
    $.chart=function(){
        $year=$('#year').val();
        $month=$('#month').val();
        $('#report-chart').empty();
        $.ajax({
            url: '/fetchChart/' + $month + '/' + $year,
            type: "GET",
            dataType: "json",
            success: function(result) {
                Morris.Area({
                    element: 'report-chart',
                    data: result,
                    xkey: "period",
                    ykeys: ["penjualan", "pengeluaran"],
                    labels: ['Penjualan', 'Pengeluaran'],
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
    $(document).ready(function(){
        
        $.chart();
        $('#year').change(function(){
            $.chart();
        });
        $('#month').change(function(){
            $.chart();
        });
        $('#tipe').change(function(){
            var tipe=$(this).find(":selected").val();
            if(tipe==='Tahunan'){
                $('#month').css("visibility","hidden");
                $('#month').val('0');
                $month=0;
                $.chart();
            }
            else{
                $('#month').css("visibility","visible");
                $('#month').val('0');
            }
        });
    });
    </script>
@endsection