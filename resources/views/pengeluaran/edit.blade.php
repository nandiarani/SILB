@extends('layouts.dashboard')

@section('title')
<title>SITran|Edit Pengeluaran</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Edit Pengeluaran</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" method="POST" action="{{route('pengeluaran.update',$pengeluaran->id_pengeluaran)}}" >
                @csrf
                <input name="_method" type="hidden" value="PATCH">
                <div class="form-group">
                        <label class="col-md-12">Tanggal</label>
                        <div class="col-md-12">
                            <input type="date" name="tanggal" placeholder="" class="form-control form-control-line" required autofocus value="{{$tanggal}}">
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-md-12">Jenis pengeluaran</label>
                        <div class="col-md-12">
                            <select name="jenis_pengeluaran" class="bootstrap-select form-control form-control-line" >
                                @foreach ($jenis_pengeluaran as $jenisPengeluaran)
                                    @if ($pengeluaran->id_jenis_pengeluaran===$jenisPengeluaran->id_jenis_pengeluaran)
                                    <option value="{{$jenisPengeluaran->id_jenis_pengeluaran}}" selected>{{$jenisPengeluaran->jenis_pengeluaran}}</option>                                            
                                    @else
                                    <option value="{{$jenisPengeluaran->id_jenis_pengeluaran}}">{{$jenisPengeluaran->jenis_pengeluaran}}</option>                                                                            
                                    @endif 
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-md-12">Jumlah</label>
                        <div class="col-md-12">
                            <input type="number" name="jumlah" id="jumlah" placeholder="" class="form-control form-control-line" value="{{$pengeluaran->jumlah}}" required>
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-md-12">Harga satuan</label>
                        <div class="col-md-12">
                            <input type="number" name="harga_satuan" id="harga_satuan" placeholder="" class="form-control form-control-line" value="{{$pengeluaran->harga_satuan}}" required>
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-md-12">Total</label>
                        <div class="col-md-12">
                            <input type="number" name="total" id="total" readonly placeholder="" class="form-control form-control-line" value="{{$pengeluaran->total}}" required>
                        </div>
                </div>
                <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success" type="submit">Save</button>
                            <a href="{{route('pengeluaran.index')}}" class="btn btn btn-warning hidden-sm-down">Cancel</a>
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
        $('#harga_satuan').change(function(){
            var jumlah=$('#jumlah').val();
            var harga_satuan=$('#harga_satuan').val();
            $('#total').val(jumlah*harga_satuan);
        });
        $('#jumlah').change(function(){
            var jumlah=$('#jumlah').val();
            var harga_satuan=$('#harga_satuan').val();
            $('#total').val(jumlah*harga_satuan);
        });
        $('#harga_satuan').keyup(function(){
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