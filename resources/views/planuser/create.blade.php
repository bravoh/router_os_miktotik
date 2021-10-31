@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Prepaid Customer</div>

                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{route('prepaid.create')}}">

                            {{csrf_field()}}

                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">Customer</label>
                                    <select class="form-control" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @foreach(\App\Customer::all() as $customer)
                                            <option value="{{$customer->id}}">{{$customer->first_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="phone" class="form-label">Plan</label>
                                    <select class="form-control" name="plan_id">
                                        <option value="">Select Plan</option>
                                        @foreach(\App\Plan::all() as $plan)
                                            <option value="{{$plan->id}}">{{$plan->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <label for="phone" class="form-label">Target IP(Optional)</label>
                                    <input type="text" name="target_ip" class="form-control">
                                </div>

                            </div>

                            <button class="w-100 btn btn-primary btn-lg" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
