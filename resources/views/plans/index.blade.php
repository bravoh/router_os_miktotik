@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">
                    <p class="text-muted m-3">
                        Service Plans
                        <a href="{{route('plans.hotspot.create')}}" class="float-right btn btn-xs btn-info">
                            New Hotspot Plan
                        </a>

                        <a href="{{route('plans.pppoe.create')}}" class="float-right btn btn-xs btn-info mr-3">
                            New PPPOE Plan
                        </a>
                    </p>

                    <div class="card-body">
                        <table class="table table-sm table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Bandwidth</th>
                                    <th>Time Limit</th>
                                    <th>Data Limit</th>
                                    <th>Validity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->type}}</td>
                                <td></td>
                                <td>{{$item->time_limit}}</td>
                                <td></td>
                                <td></td>
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
