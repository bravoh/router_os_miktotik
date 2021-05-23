@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p class="text-muted">
                            Bandwidth
                            <a href="{{route('bandwidth.create')}}" class="float-right btn btn-xs btn-info">Add</a>
                        </p>
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Download Rate</th>
                                    <th>Upload Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->download_rate}} {{$item->download_rate_unit}}</td>
                                <td>{{$item->upload_rate}} {{$item->upload_rate_unit}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
