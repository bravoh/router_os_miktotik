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
                        Prepaid Clients

                        <a href="{{route('prepaid.create')}}" class="float-right btn btn-primary btn-xs">
                            New
                        </a>
                    </p>

                    <div class="card-body">
                        <table class="table table-sm table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Plan</th>
                                    <th>Target IP</th>
                                    <th>Expiry</th>
                                    <th>Account Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->customer->name}}</td>
                                <td>{{$item->plan->name}}</td>
                                <td>{{$item->target_ip}}</td>
                                <td>{{date("Y-m-d",strtotime($item->expiry_date))}}</td>
                                <td>{{$item->customer->customer_no}}</td>
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
