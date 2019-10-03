@extends('layouts.dashboard')

@section('title')
<title>SITran|Jenis Pengeluaran</title>
@endsection

@section('preloader')
<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Loading Jenis Pengeluaran</p>
        </div>
    </div>
@endsection
@section('breadcrumb')

@endsection

@section('contents')
<div class="card">
    <div class="card-body">
            <div class="col md-12" style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
                <h4 class="card-title">Pengelolaan Jenis Pengeluaran</h4>
            </div>
        <a href="{{route('jenis_pengeluaran.create')}}" class="btn waves-effect waves-light btn btn-success pull-right hidden-sm-down">Tambah</a>
        <div class="table-responsive">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
                @endif
            @if (count($jenis_pengeluarans)===0)
            <div class="col md-12" style="text-align:center;margin-top:5%;">
                    <img src="{{asset('assets/icon/empty.png')}}" height="350" width="350">
                </div>
                <div class="col md-12" style="text-align:center;margin-bottom:5%;">
                    <p class="text-muted" style="font-size:200%;">Data kosong :(</p>
                </div>
            @else
            <table class="table">
                    <thead>
                        <tr>
                            <th>{{'#'}}</th>
                            <th>{{'Jenis Pengeluaran'}}</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($jenis_pengeluarans as $jenis_pengeluaran)
                                <tr >
                                        <td style="vertical-align:middle;">{{$i++}}</td>
                                        <td style="vertical-align:middle;">{{$jenis_pengeluaran->jenis_pengeluaran}}</td>
                                        <td style="vertical-align:middle; width:20%; text-align:center;">
                                            <button type="button" onclick="deleteItem({!!$jenis_pengeluaran->id_jenis_pengeluaran!!})" class="btn btn btn-danger hidden-sm-down" >Delete</button>
                                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                                        </td>
                                    </tr>
                                @endforeach
                    </tbody>
                </table>
            @endif            
        </div>
        <div >{{$jenis_pengeluarans->links()}}</div>
    </div>
</div>

@endsection
@section('js')

    <script type="text/javascript">
        jQuery.ajaxSetup({
            headers: {            
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')        
            }    
        });
        function deleteItem(id_jenis_pengeluaran){
            var r= confirm("Are u sure to delete?");
            if(r==true){
                var project_url="{!! URL::to('/')!!}";
                $.ajax({
                    url:'/jenis_pengeluaran/'+id_jenis_pengeluaran,
                    type:'POST',
                    data:{_method: 'delete' },
                    success: function(result) {
                        window.location.href = "{{URL::to('/jenis_pengeluaran')}}"
                    }
                });
            }
        }
    </script>
@endsection