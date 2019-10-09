@extends('layouts.dashboard') 

@section('title')
<title>SITran|Detil Penjualan</title>
@endsection 

@section('preloader')
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Loading Detil Penjualan</p>
    </div>
</div>
@endsection 

@section('breadcrumb') 
@endsection 

@section('contents')
<div class="card" >
    <div class="card-body">
        <div class="col md-12"  style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
            <h4 class="card-title">Pengelolaan Detil Penjualan</h4>
        </div>
        <a href="{{route('detil.create',$id_penjualan)}}" class="btn waves-effect waves-light btn btn-success pull-right hidden-sm-down">Tambah</a>
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
                @if ($message = Session::get('info'))
                <div class="alert alert-info alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
                @endif
            @if (count($detils)===0)
            <div class="col md-12" style="text-align:center;margin-top:5%;">
                <img src="{{asset('assets/icon/empty.png')}}" height="350" width="350">
            </div>
            <div class="col md-12" style="text-align:center;margin-bottom:5%;">
                <p class="text-muted" style="font-size:200%;">Data kosong :(</p>
            </div>
            @else
            <input type="hidden" value="{{$id_penjualan}}" id="id_penjualan">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{'#'}}</th>
                        <th>{{'Harga Per Ekor'}}</th>
                        <th>{{'Jumlah ikan'}}</th>
                        <th>{{'Subtotal'}}</th>
                        
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detils as $detil)
                    <tr>
                        <td style="vertical-align:middle;">{{$i++}}</td>
                        <td style="vertical-align:middle;">Rp. {{number_format($detil->harga_per_ekor,0,',','.')}}</td>
                        <td style="vertical-align:middle;">{{$detil->jumlah_ikan}}</td>
                        <td style="vertical-align:middle;">Rp. {{number_format($detil->subtotal,0,',','.')}}</td>
                        <td style="vertical-align:middle; width:20%; text-align:center;">
                            <button type="button" onclick="deleteItem({!!$detil->id_detil_penjualan!!})" class="btn btn btn-danger hidden-sm-down" >Hapus</button>
                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                            <a href="{{route('detil.edit',$detil->id_detil_penjualan)}}" class="btn btn btn-info hidden-sm-down ">Ubah</a> 
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td colspan="2">Rp. {{number_format($total,0,',','.')}}</td>
                    </tr>
                </tbody>
            </table>
            @endif


        </div>
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
        function deleteItem(id_detil_penjualan){
            
            var id_penjualan=$('#id_penjualan').val();
            var r= confirm("Are u sure to delete?");
            if(r==true){
                var project_url="{!! URL::to('/')!!}";
                $.ajax({
                    url:'/detil/'+id_detil_penjualan,
                    type:'POST',
                    data:{_method: 'delete' },
                    success: function(result) {
                        console.log('success');
                    }
                });
            }
            
        }
    </script>
@endsection