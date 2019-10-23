@extends('layouts.dashboard')

@section('title')
<title>SITran|Pengelolaan Harga Ikan</title>
@endsection

@section('preloader')
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Loading Atur Harga</p>
    </div>
</div>
@endsection
@section('breadcrumb')

@endsection

@section('contents')
<div id="delete" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" style="display: none; padding-right: 17px;" aria-modal="true">
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
                                <button type="submit" class="btn btn-danger waves-effect" data-dismiss="modal" onclick="formSubmit()">Delete</button>
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

<div class="card">
    <div class="card-body">
        <div class="col md-12" style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
            <h4 class="card-title">Pengelolaan Harga Ikan</h4>
        </div>
        <a href="{{route('tarif.create')}}"
            class="btn waves-effect waves-light btn btn-success pull-right hidden-sm-down">Tambah</a>
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
            @if (count($tarifs)===0)
                <div class="col md-12" style="text-align:center; ">
                    <img src="{{asset('assets/icon/empty.png')}}" height="350" width="350" style="margin-top:5%;">
                </div>
                <div class="col md-12" style="text-align:center;margin-bottom:5%;">
                    <p class="text-muted" style="font-size:200%;">Data kosong :(</p>
                </div>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>{{'#'}}</th>
                        <th>{{'Ukuran'}}</th>
                        <th>{{'Panjang dari (cm)'}}</th>
                        <th>{{'Panjang sampai (cm)'}}</th>
                        <th>{{'Harga per ekor'}}</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifs as $tarif)
                    <tr>
                        <td style="vertical-align:middle;">{{$i++}}</td>
                        <td style="vertical-align:middle;">{{$tarif->ukuran}}</td>
                        <td style="vertical-align:middle;">{{$tarif->size_from_cm}}</td>
                        <td style="vertical-align:middle;">{{$tarif->size_to_cm}}</td>
                        <td style="vertical-align:middle;">Rp. {{number_format($tarif->harga_per_ekor,0,',','.')}}</td>
                        <td style="vertical-align:middle; width:20%; text-align:center;">
                            <a href="{{route('tarif.edit',$tarif->id_harga)}}" class="btn btn btn-info hidden-sm-down ">Edit</a>
                            <button type="button" alt="default" data-toggle="modal" onclick="deleteData({{$tarif->id_harga}})" data-target="#delete" class="btn btn btn-danger hidden-sm-down dlt">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif


        </div>
        <div>{{$tarifs->links()}}</div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
    function deleteData(id)
    {
        var id = id;
        var url = '{{ route("tarif.destroy", ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm").attr('action', url);
    }

    function formSubmit()
    {
        $("#deleteForm").submit();
    }

</script>
@endsection