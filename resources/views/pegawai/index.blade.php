@extends('layouts.dashboard')

@section('title')
<title>SITran|Pengelolaan Pegawai</title>
@endsection

@section('preloader')
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Loading Pengelolaan Pegawai</p>
    </div>
</div>
@endsection
@section('breadcrumb')

@endsection

@section('contents')
<div class="card">
    <div class="card-body">
        <div class="col md-12" style="border-bottom:2px solid #d5dae2;margin-bottom:15px;">
            <h4 class="card-title">Pengelolaan Pegawai</h4>
        </div>
        @if ($message = Session::get('info'))
        <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
        </div>
        @endif
            @if (count($pegawais)===0)
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
                        <th>{{'Nama'}}</th>
                        <th>{{'Username'}}</th>
                        <th>{{'Email'}}</th>
                        <th>{{'Status aktif'}}</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawais as $pegawai)
                    <tr>
                        <td style="vertical-align:middle;">{{$i++}}</td>
                        <td style="vertical-align:middle;">{{$pegawai->name}}</td>
                        <td style="vertical-align:middle;">{{$pegawai->username}}</td>
                        <td style="vertical-align:middle;">{{$pegawai->email}}</td>
                        <td style="vertical-align:middle;">
                            @if ($pegawai->flag_active==='1')
                                Aktif
                            @else
                                Tidak aktif
                            @endif
                        </td>
                        <td style="vertical-align:middle; width:20%;text-align:center;">
                            @if ($pegawai->flag_active==='0')
                                <a href="{{route('pegawai.edit',$pegawai->id_user)}}"class="btn btn btn-success hidden-sm-down ">Aktivasi</a>
                            @else
                                <a href="{{route('pegawai.edit',$pegawai->id_user)}}"class="btn btn btn-danger hidden-sm-down ">Deaktivasi</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif


        </div>
        <div>{{$pegawais->links()}}</div>
    </div>
</div>

@endsection
