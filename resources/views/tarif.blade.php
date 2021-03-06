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
<div class="card">
    <div class="card-body">
        <div class="col md-12" style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
            <h4 class="card-title">Pengelolaan Harga Ikan</h4>
        </div>
        <a href="{{route('tarif.create')}}"
            class="btn waves-effect waves-light btn btn-success pull-right hidden-sm-down">Tambah</a>
        <div class="table-responsive">
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
                        <th>Action</th>
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
                        <td style="vertical-align:middle; width:20%;">
                            <a href="{{route('tarif.edit',$tarif->id_ukuran)}}"
                                class="btn btn btn-info hidden-sm-down ">Edit</a>
                            <form action="{{ route('tarif.destroy', $tarif->id_ukuran) }}" method="POST" class="btn"
                                style="padding:0px;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn btn-danger hidden-sm-down" value="Delete">
                            </form>
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
