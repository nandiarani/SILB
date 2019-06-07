@extends('layouts.dashboard')

@section('title')
<title>Modal</title>
@endsection

@section('preloader')
<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Loading Modal</p>
        </div>
    </div>
@endsection
@section('breadcrumb')

@endsection

@section('contents')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Pengelolaan Modal</h4>
        <a href="{{route('modal.create')}}" class="btn waves-effect waves-light btn btn-success pull-right hidden-sm-down">Tambah</a>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{'#'}}</th>
                        <th>{{'Tanggal'}}</th>
                        <th>{{'Nominal'}}</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($modals as $modal)
                            <tr >
                                    <td style="vertical-align:middle;">{{$i++}}</td>
                                    <td style="vertical-align:middle;">{{$modal->tanggal}}</td>
                                    <td style="vertical-align:middle;">{{$modal->nominal}}</td>
                                    <td style="vertical-align:middle; width:20%;">
                                            <a href="{{route('modal.edit',$modal->id_modal)}}" class="btn btn btn-info hidden-sm-down ">Edit</a>
                                            <form action="{{ route('modal.destroy', $modal->id_modal) }}" method="POST" class="btn" style="padding:0px;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn btn-danger hidden-sm-down" value="Delete">
                                            </form>
                                    </td>
                                </tr>
                            @endforeach
                </tbody>
            </table>
            
        </div>
        <div >{{$modals->links()}}</div>
    </div>
</div>

@endsection
