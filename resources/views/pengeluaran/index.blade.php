@extends('layouts.dashboard') 

@section('title')
<title>SITran|Pengelolaan pengeluaran</title>
@endsection 

@section('preloader')
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Loading pengeluaran</p>
    </div>
</div>
@endsection 

@section('breadcrumb') 
@endsection 

@section('contents')
<div class="card">
    <div class="card-body">
        <div class="col md-12" style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
            <h4 class="card-title">Pengelolaan pengeluaran</h4>
        </div>
        <a href="{{route('pengeluaran.create')}}" class="btn waves-effect waves-light btn btn-success pull-right hidden-sm-down">Tambah</a>
        <div class="table-responsive">
            @if (count($pengeluarans)===0)
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
                        <th>{{'Tanggal'}}</th>
                        <th>{{'Jenis Pengeluaran'}}</th>
                        <th>{{'Jumlah'}}</th>
                        <th>{{'Harga satuan'}}</th>
                        <th>{{'Total'}}</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengeluarans as $pengeluaran)
                    <tr>
                        <td style="vertical-align:middle;">{{$i++}}</td>
                        <td style="vertical-align:middle;">{{date('d-m-Y', strtotime($pengeluaran->tanggal))}}</td>
                        <td style="vertical-align:middle;">{{$pengeluaran->jenis_pengeluaran}}</td>
                        <td style="vertical-align:middle;">{{$pengeluaran->jumlah}}</td>
                        <td style="vertical-align:middle;">Rp. {{number_format($pengeluaran->harga_satuan,0,',','.')}}</td>
                        <td style="vertical-align:middle;">Rp. {{number_format($pengeluaran->total,0,',','.')}}</td>
                        <td style="vertical-align:middle; width:20%; text-align:center;">
                            <a href="{{route('pengeluaran.edit',$pengeluaran->id_pengeluaran)}}" class="btn btn btn-info hidden-sm-down ">Ubah</a>
                            <form action="{{ route('pengeluaran.destroy', $pengeluaran->id_pengeluaran) }}" method="POST" class="btn" style="padding:0px;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn btn-danger hidden-sm-down" value="Hapus">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif


        </div>
        <div>{{$pengeluarans->links()}}</div>
    </div>
</div>

@endsection