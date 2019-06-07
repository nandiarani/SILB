@extends('layouts.dashboard')

@section('title')
<title>Modal</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Tambah harga baru ikan</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{url('tarif')}}" method="POST">
                {{ csrf_field() }}
                    <div class="form-group">
                            <label class="col-md-12">Ukuran</label>
                            <div class="col-md-12">
                                <input type="text" name="ukuran" placeholder="" class="form-control form-control-line" required>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-12">{{ __('Ukuran dari (cm)') }}</label>
                            <div class="col-md-12">
                                <input type="number" name="uk_dari" placeholder="" class="form-control form-control-line" required>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-12">{{ __('Ukuran sampai (cm)') }}</label>
                            <div class="col-md-12">
                                <input type="number" name="uk_sampai" placeholder="" class="form-control form-control-line" required>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-12">Harga per ekor</label>
                            <div class="col-md-12">
                                <input type="number" name="harga" placeholder="" class="form-control form-control-line" required>
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
