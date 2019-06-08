@extends('layouts.dashboard')

@section('title')
<title>SILBan|Edit Modal</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Edit Modal</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" method="POST" action="{{route('modal.update',$modal->id_modal)}}" >
                @csrf
                <input name="_method" type="hidden" value="PATCH">
                    <div class="form-group">
                            <label class="col-md-12">Tanggal</label>
                            <div class="col-md-12">
                                <input type="date" placeholder="" class="form-control form-control-line" value="{{$modal->tanggal}}" name="tanggal">
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-12">Nominal</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="" class="form-control form-control-line" value="{{$modal->nominal}}" name="nominal">
                            </div>
                    </div>
                <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success" type="submit">Save</button>
                            <a href="{{route('modal.index')}}" class="btn btn btn-warning hidden-sm-down">Cancel</a>
                        </div>
                </div>
            </form>
    
        </div>
    </div>
</div>

@endsection
