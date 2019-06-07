@extends('layouts.dashboard')

@section('title')
<title>SILBan|Edit Harga Ikan</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Edit Harga Ikan</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{action('MstTarifByUkuranController@update',$tarif->id_ukuran)}}" method="POST">
                @csrf
                <input name="_method" type="hidden" value="PATCH">
                    <div class="form-group">
                            <label class="col-md-12">Ukuran</label>
                            <div class="col-md-12">
                                <input type="text" name="ukuran" placeholder="" class="form-control form-control-line" value="{{$tarif->ukuran}}" required>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-12">{{ __('Ukuran dari (cm)') }}</label>
                            <div class="col-md-12">
                                <input type="number" name="uk_dari" placeholder="" class="form-control form-control-line" value="{{$tarif->size_from_cm}}" required>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-12">{{ __('Ukuran sampai (cm)') }}</label>
                            <div class="col-md-12">
                                <input type="number" name="uk_sampai" placeholder="" class="form-control form-control-line" value="{{$tarif->size_to_cm}}" required>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-12">Harga per ekor</label>
                            <div class="col-md-12">
                                <input type="number" name="harga" placeholder="" class="form-control form-control-line" value="{{$tarif->harga_per_ekor}}" required>
                            </div>
                    </div>
                <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success" type="submit">Save</button>
                            <a href="{{route('tarif.index')}}" class="btn btn btn-warning hidden-sm-down">Cancel</a>
                        </div>
                </div>
            </form>
    
        </div>
    </div>
</div>

@endsection
