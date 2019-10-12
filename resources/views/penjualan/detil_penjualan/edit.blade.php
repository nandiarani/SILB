@extends('layouts.dashboard')

@section('title')
<title>SITran|Edit Detil Penjualan</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Edit Detil Penjualan</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{route('detil.update')}}" method="POST">
                @method('PATCH')
                
                <div class="form-group">
                    <label class="col-md-12">Harga per ekor</label>
                    <div class="col-md-12">
                        <select name="harga_per_ekor" id="harga_per_ekor" class="bootstrap-select form-control form-control-line">
                                <option value="0">-</option>
                            @foreach ($hargas as $harga)
                                @if ($harga->id_harga===$detil->id_harga)
                                    <option selected value="{{$harga->id_harga}}">Rp {{$harga->harga_per_ekor}} - {{$harga->ukuran}} ({{$harga->size_from_cm}} cm - {{$harga->size_to_cm}}cm)</option>
                                @else
                                    <option value="{{$harga->id_harga}}">Rp {{$harga->harga_per_ekor}} - {{$harga->ukuran}} ({{$harga->size_from_cm}} cm - {{$harga->size_to_cm}}cm)</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12">Jumlah ikan</label>
                    <div class="col-md-12">
                        <input type="number" id="jumlah" name="jumlah" placeholder="" min="0" class="form-control form-control-line" required autofocus value="{{$detil->jumlah_ikan}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Subtotal</label>
                    <div class="col-md-12">
                        <input type="number" name="total" id="total" placeholder="" class="form-control form-control-line" readonly value="{{$detil->subtotal}}">
                    </div>
                </div> 
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="number" name="harga_satuan" id="harga_satuan" placeholder="" class="form-control form-control-line" required autofocus hidden value="{{$harga_per_ekor}}">
                    </div>
                </div> 
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="number" name="id_detil_penjualan" id="id_detil_penjualan" placeholder="" class="form-control form-control-line" required autofocus hidden value="{{$detil->id_detil_penjualan}}">
                    </div>
                </div> 
                <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success" type="submit">Save</button>
                            <a href="{{route('detil.index',$detil->id_penjualan)}}" class="btn btn btn-warning hidden-sm-down">Cancel</a>
                        </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#harga_per_ekor').change(function(){
            var id_ukuran=$(this).find(":selected").val();
            $.ajax({
                url:'/penjualan/getprice/'+id_ukuran,
                type:"GET",
                dataType:"json",
                success:function(result){
                    for(var i in result){
                        $('#harga_satuan').val(result[i].harga_per_ekor);
                        var jumlah=$('#jumlah').val();
                        var harga_satuan=result[i].harga_per_ekor;
                        $('#total').val(jumlah*harga_satuan);
                    }
                }
            });
        });
        $('#jumlah').keyup(function(){
            var jumlah=$('#jumlah').val();
            var harga_satuan=$('#harga_satuan').val();
            $('#total').val(jumlah*harga_satuan);
        });
    });
</script>    
@endsection