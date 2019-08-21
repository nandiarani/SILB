@extends('layouts.dashboard')

@section('title')
<title>SITran|Edit Penjualan</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Edit Penjualan</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{route('penjualan.update',$penjualan->id_penjualan)}}" method="POST">
                @csrf
                <input name="_method" type="hidden" value="PATCH">
                <div class="form-group">
                    <label class="col-md-12">Tanggal penjualan</label>
                    <div class="col-md-12">
                        <input type="date" name="tanggal" placeholder="" id="tanggal" class="form-control form-control-line" required autofocus data-dependent="harga_per_ekor" value="{{$tanggal}}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12">Harga per ekor</label>
                    <div class="col-md-12">
                        <select name="harga_per_ekor" id="harga_per_ekor" class="bootstrap-select form-control form-control-line">
                                <option value="0">-</option>
                            @foreach ($hargas as $harga)
                                @if ($harga->harga_per_ekor===$penjualan->harga_per_ekor)
                                    <option selected value="{{$harga->id_ukuran}}">Rp {{$harga->harga_per_ekor}}</option>
                                @else
                                    <option value="{{$harga->id_ukuran}}">Rp {{$harga->harga_per_ekor}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Tahap</label>
                    <div class="col-md-12">
                        <input type="number" name="tahap" placeholder="" min="0" class="form-control form-control-line" required autofocus value="{{$penjualan->tahap}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Penjualan ke</label>
                    <div class="col-md-12">
                        <input type="number" name="penjualan_ke" placeholder="" min="0" class="form-control form-control-line" required autofocus value="{{$penjualan->penjualan_ke}}">
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-md-12">Jumlah ikan</label>
                        <div class="col-md-12">
                            <input type="number" id="jumlah" name="jumlah" placeholder="" min="0" class="form-control form-control-line" required autofocus value="{{$penjualan->jumlah_ikan}}">
                        </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Harga total ikan</label>
                    <div class="col-md-12">
                        <input type="number" name="total" id="total" placeholder="" class="form-control form-control-line" readonly value="{{$penjualan->total}}">
                    </div>
                </div> 
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="number" name="harga_satuan" id="harga_satuan" placeholder="" class="form-control form-control-line" required autofocus hidden value="{{$penjualan->harga_per_ekor}}">
                    </div>
                </div> 
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
        $("option").mouseenter(function(){
            console.log("test hover");
        });
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
                        $('#total').val('');
                        $('#harga_per_ekor').append('<option value="0" selected>-</option>');
                        for(var i in result){
                            $('#harga_per_ekor').append('<option value="'+result[i].id_ukuran+'">Rp '+result[i].harga_per_ekor+'</option>');
                        }
                    }
                });
            }
        });
        $('#harga_per_ekor').change(function(){
            var id_ukuran=$(this).find(":selected").val();
            $.ajax({
                url:'/penjualan/getdata/'+id_ukuran,
                type:"GET",
                dataType:"json",
                success:function(result){
                    for(var i in result){
                        $('#harga_satuan').val(result[i].harga_per_ekor);
                    }
                }
            });
        }); 
        $('#harga_per_ekor').change(function(){
            var jumlah=$('#jumlah').val();
            var harga_satuan=$('#harga_satuan').text();
            $('#total').val(jumlah*harga_satuan);
        });
        $('#jumlah').change(function(){
            var jumlah=$('#jumlah').val();
            var harga_satuan=$('#harga_satuan').val();
            $('#total').val(jumlah*harga_satuan);
        });
        $('#jumlah').keyup(function(){
            var jumlah=$('#jumlah').val();
            var harga_satuan=$('#harga_satuan').val();
            $('#total').val(jumlah*harga_satuan);
        });
    });
</script>    
@endsection