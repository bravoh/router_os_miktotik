@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">

                    <p class="text-muted m-3">Customers</p>


                    <div class="card-body">
                        <a href="{{route('customers.create')}}" class="btn btn-primary">Add</a>
                        <table class="table table-sm table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
{{--                                    <th>Account Number</th>--}}
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->email}}</td>
{{--                                <td>{{$item->phone}}</td>--}}
                                <td>{{$item->default_target_ip}}</td>
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
