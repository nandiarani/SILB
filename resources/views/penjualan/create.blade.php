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
                    <label class="col-md-12">Tanggal penjualan</label>
                    <div class="col-md-12">
                        <input type="date" name="tanggal" placeholder="" id="tanggal"
                            class="form-control form-control-line" required autofocus value="{{$today}}"
                            data-dependent="harga_per_ekor">
                    </div>
                </div>

                <div style="background-color:#f5f5f0;padding:20px;margin-bottom:15px;" id="items">
                    <h4 style="text-align:center">List item</h4>
                    <div id="item">
                        <div class="form-group">
                                <label class="col-md-12">Harga per ekor</label>
                                <div class="col-md-12">
                                    <select name="harga_per_ekor[]" id="harga_per_ekor"
                                        class="bootstrap-select form-control form-control-line">
                                        <option value="0" selected>-</option>
                                        @foreach ($hargas as $harga)
                                        <option value="{{$harga->id_harga}}">Rp {{$harga->harga_per_ekor}} - {{$harga->ukuran}}
                                            ({{$harga->size_from_cm}} cm - {{$harga->size_to_cm}}cm)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Jumlah ikan</label>
                                <div class="col-md-12">
                                    <input type="number" id="jumlah" name="jumlah[]" placeholder="" min="0"
                                        class="form-control form-control-line" required autofocus>
                                </div>
                            </div>
                    </div>
                    <div id="add-item">
                    </div>
                    <div style="text-align:center;">
                        <button type="button" id="btn-add-item" class="btn btn-primary" style="">Add item</button>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-12">Harga total ikan</label>
                    <div class="col-md-12">
                        <input type="number" name="total" id="total" placeholder=""
                            class="form-control form-control-line" readonly>
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
    
    $(document).on('click','#btn-add-item',function(){
        var itemclone=$(this).parents("#items").children("#item").clone().find("input").val('').end();
        $("#add-item").append(itemclone);
    });
    $(document).on('change','select[id="harga_per_ekor"]',function(){
        $.hitungTotal();
    });
    $(document).on('change','input[id="jumlah"]',function(){
        $.hitungTotal();
    });
    $.hitungTotal=function(){
        var total=0;
        $('div[id="item"]').each(function(){
            var id_ukuran=$(this).find('#harga_per_ekor').val();
            var jumlah=$(this).find('#jumlah').val()
            $.ajax({
                url:'/penjualan/getprice/'+id_ukuran,
                type:"GET",
                dataType:"json",
                success:function(result){
                    for(var i in result){
                        var harga_satuan=result[i].harga_per_ekor;
                        total=total+jumlah*harga_satuan;
                                        
                        $('#total').val(total);
                    }
                }
            });
        });
    }
</script>
@endsection
