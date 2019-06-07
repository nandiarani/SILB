@extends('layouts.dashboard')

@section('title')
<title>SILBan|Jenis Pengeluaran</title>
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
        <h4 class="card-title">Pengelolaan Jenis Pengeluaran</h4>
        <a href="{{route('jenis_pengeluaran.create')}}" class="btn waves-effect waves-light btn btn-success pull-right hidden-sm-down">Tambah</a>
        <div class="table-responsive">
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($jenis_pengeluarans as $jenis_pengeluaran)
                                <tr >
                                        <td style="vertical-align:middle;">{{$i++}}</td>
                                        <td style="vertical-align:middle;">{{$jenis_pengeluaran->jenis_pengeluaran}}</td>
                                        <td style="vertical-align:middle; width:20%;">
                                                <a href="{{route('jenis_pengeluaran.edit',$jenis_pengeluaran->id_jenis_pengeluaran)}}" class="btn btn btn-info hidden-sm-down ">Edit</a>
                                                <form action="{{ route('jenis_pengeluaran.destroy', $jenis_pengeluaran->id_jenis_pengeluaran) }}" method="POST" class="btn" style="padding:0px;">
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
        <div >{{$jenis_pengeluarans->links()}}</div>
    </div>
</div>

@endsection
