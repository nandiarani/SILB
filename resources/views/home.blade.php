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
<form>
            <div class="form-group">
                
                <div class="row" >
                    <div class="col-md-1" style="margin-left:15px;">
                                <label style="font-size:18px;margin:0;padding: 0.375rem 0.75rem;">Filter</label>
                    </div>
                    
                    <div class="col-md-2">
                            <select id="tipe" class="form-control form-control-line">
                                    <option value="Bulanan" selected>Bulanan</option>
                                    <option value="Tahunan">Tahunan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="year" class="form-control form-control-line">
                                @foreach ($dropdownyear as $year)
                                    <option value="{{$year->year}}">{{$year->year}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="month" class="form-control form-control-line">
                                    @foreach ($dropdownmonth as $month)
                                        <option value="{{$month->mon}}">{{$month->month}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
            </div>
</form>
            <div class="col md-12">
                    <div id="sales-chart"></div>
            </div>
        </div>
    </div>
@endsection
    
@section('js')
    <script type="text/javascript">
        
    $(document).ready(function(){
        $('#tipe').change(function(){
            var tipe=$(this).find(":selected").val();
            if(tipe==='Tahunan')
                $('#month').css("visibility","hidden");
            else
            $('#month').css("visibility","visible");
        });
    });

    </script>
@endsection