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

<div id="delete" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter"
    style="display: none; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" id="deleteForm" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <p class="text-center">Are You Sure Want To Delete ?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger waves-effect" data-dismiss="modal"
                        onclick="deleteSubmit()">Delete</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="editTanggal" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter"
    style="display: none; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{url('penjualan/updateDate')}}" id="editForm">
                {{ csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-12">Tanggal penjualan</label>
                            <div class="col-md-12">
                                <input type="date" name="tanggal" placeholder="" id="tanggal" class="form-control form-control-line" required autofocus>
                            </div>
                        </div>
                        <input type="hidden" name="id_penjualan" placeholder="" id="id_penjualan" class="form-control form-control-line" required autofocus>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="col md-12" style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
            <h4 class="card-title">Pengelolaan Detil Penjualan</h4>
        </div>
        <div class="col md-6">
            <p>
                Id: {{$penjualan->id_penjualan}}
                <br>
                Tanggal : {{$penjualan->tanggal}}
            </p>
        </div>
        <div class="col md-6">
            <a href="{{route('detil.create',$penjualan->id_penjualan)}}"
                class="btn waves-effect waves-light btn btn-success pull-right hidden-sm-down">Tambah Item</a>
            <button type="button" class="btn waves-effect waves-light btn btn-info hidden-sm-down" alt="default" data-toggle="modal" onclick="editTanggal({{$penjualan->id_penjualan}},'{{$penjualan->tanggal}}')" data-target="#editTanggal" id="btn">Ubah tanggal</button>
        </div>
        <div class="table-responsive" style="margin-top:30px;">
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
            <input type="hidden" value="{{$penjualan->id_penjualan}}" id="id_penjualan">
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
                            <button type="button" alt="default" data-toggle="modal"
                                onclick="deleteData({{$detil->id_detil_penjualan}})" data-target="#delete"
                                class="btn btn btn-danger hidden-sm-down dlt">Hapus</button>
                            <a href="{{route('detil.edit',$detil->id_detil_penjualan)}}"
                                class="btn btn btn-info hidden-sm-down ">Ubah</a>
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
    function deleteData(id) {
        var id = id;
        var url = '{{ route("detil.destroy", ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm").attr('action', url);
    }

    function deleteSubmit() {
        $("#deleteForm").submit();
    }
    function editTanggal(id,tanggal){
        var id_penjualan=id;
        var tanggal=tanggal;
        $('#id_penjualan').val(id_penjualan);
        $('#tanggal').val(tanggal);
    }
</script>
@endsection
