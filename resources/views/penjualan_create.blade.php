@extends('layouts.dashboard')

@section('title')
<title>SITran|Tambah Penjualan</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Tambah Penjualan</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{url('penjualan')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-12">Tahap</label>
                    <div class="col-md-12">
                        <input type="number" name="tahap" placeholder="" class="form-control form-control-line" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Penjualan ke</label>
                    <div class="col-md-12">
                        <input type="number" name="penjualan_ke" placeholder="" class="form-control form-control-line" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-md-12">Jumlah ikan</label>
                        <div class="col-md-12">
                            <input type="number" name="jumlah" placeholder="" class="form-control form-control-line" required autofocus>
                        </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Tanggal penjualan</label>
                    <div class="col-md-12">
                        <input type="date" name="tanggal" placeholder="" id="tanggal" class="form-control form-control-line" required autofocus value="{{$today}}" data-dependent="harga_per_ekor">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12">Harga per ekor</label>
                    <div class="col-md-12">
                        <select name="harga_per_ekor" id="harga_per_ekor" class="bootstrap-select form-control form-control-line">
                                @foreach ($hargas as $harga)
                                <option value="{{$harga->id_ukuran}}">Rp {{$harga->harga_per_ekor}}</option>
                                @endforeach
                            
                        </select>
                    </div>
                    {{ csrf_field() }}
                <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success" type="submit">Save</button>
                            <a href="{{route('penjualan.index')}}" class="btn btn btn-warning hidden-sm-down">Cancel</a>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#tanggal').change(function(){
            if($(this).val()!='')
            {
                var date = $(this).val();
                $.ajax({
                    url:'/penjualan/fetch/'+date,
                    type:"GET",
                    dataType:"json",
                    success:function(result)
                    {
                        $('#harga_per_ekor').empty();
                        for(var i in result){
                            $('#harga_per_ekor').append('<option value="'+result[i].id_ukuran+'">Rp '+result[i].harga_per_ekor+'</option>');
                        }
                    }
                });
            }
        });
    });
</script>    
@endsection