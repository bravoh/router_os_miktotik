@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Customers</div>

                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{route('customers.create')}}">

                            {{csrf_field()}}

                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">Names</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="" value="" required="">
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="" value="" required="">
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                                    <div class="invalid-feedback">
                                        Please enter a valid email address for shipping updates.
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <label for="email" class="form-label">Default Target IP</label>
                                    <input type="text" name="default_target_ip" class="form-control" id="default_target_ip" placeholder="192.168.57.81">
                                    <div class="invalid-feedback">
                                        Please enter a valid IP Address.
                                    </div>
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
