@extends('layouts.dashboard')

@section('title')
<title>SILBan|Edit Jenis Pengeluaran</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Edit Jenis Pengeluaran</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" method="POST" action="{{route('jenis_pengeluaran.update',$jenis_pengeluaran->id_jenis_pengeluaran)}}" >
                @csrf
                <input name="_method" type="hidden" value="PATCH">
                    <div class="form-group">
                            <label class="col-md-12">Jenis Pengeluaran</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="" class="form-control form-control-line" value="{{$jenis_pengeluaran->jenis_pengeluaran}}" name="jenis_pengeluaran">
                            </div>
                    </div>
                <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success" type="submit">Save</button>
                            <a href="{{route('jenis_pengeluaran.index')}}" class="btn btn btn-warning hidden-sm-down">Cancel</a>
                        </div>
                </div>
            </form>
    
        </div>
    </div>
</div>

@endsection
