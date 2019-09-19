@extends('layouts.dashboard')

@section('title')
<title>SITran|Tambah Jenis Pengeluaran</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Tambah Jenis Pengeluaran</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{url('jenis_pengeluaran')}}" method="POST">
                {{ csrf_field() }}
                    <div class="form-group">
                            <label class="col-md-12">Jenis Pengeluaran</label>
                            <div class="col-md-12">
                                <input type="text" name="jenis_pengeluaran" placeholder="" class="form-control form-control-line" required autofocus>
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
