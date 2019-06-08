@extends('layouts.dashboard')

@section('title')
<title>SILBan|Tambah Modal</title>
@endsection

@section('breadcrumb')

@endsection

@section('contents')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Tambah Modal</h3>
    </div>
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{url('modal')}}" method="POST">
                {{ csrf_field() }}
                    <div class="form-group">
                            <label class="col-md-12">Tanggal</label>
                            <div class="col-md-12">
                                <input type="date" name="tanggal" placeholder="" class="form-control form-control-line" required autofocus>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-12">Nominal</label>
                            <div class="col-md-12">
                                <input type="number" maxlength="20" name="nominal" placeholder="" class="form-control form-control-line uang" required>
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
@section('js')
     {{-- <script type="text/javascript">
        $(document).ready(function(){
                $( '.uang' ).mask('000.000.000');
        });
    </script>  --}}
@endsection