@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Service Plan</div>

                    <div class="card-body">
                        <form class="form-horizontal" method="post" role="form" action="{{route('plans.pppoe.create')}}" >

                            {{csrf_field()}}

                            <div class="row p-2">
                                <label class="col-md-2 control-label">Plan Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name_plan" name="name">
                                    <input type="hidden" name="type" value="PPPOE">
                                </div>
                            </div>

                            <div class="row p-2">
                                <label class="col-md-2 control-label">Bandwidth</label>
                                <div class="col-md-6">
                                    <select id="id_bw" name="bandwidth_id" class="form-control">
                                        <option value="">Select Bandwidth...</option>
                                        @foreach(\App\BandWidth::all() as $bandWidth)
                                            <option value="{{$bandWidth->id}}">{{$bandWidth->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row p-2">
                                <label class="col-md-2 control-label">Price</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="price" name="price">
                                </div>
                            </div>

                            <div class="row p-2">
                                <label class="col-md-2 control-label">Plan Validity</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="validity" name="validity">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" id="validity_unit" name="validity_unit">
                                        <option value="Days">Days</option>
                                        <option value="Months">Months</option>
                                    </select>
                                </div>
                            </div>
                            <!--
                            <div class="form-group">
                                <label class="col-md-2 control-label">Router Name</label>
                                <div class="col-md-6">
                                    <select id="routers" name="router_id" class="form-control">
                                        <option value=''>Select Routers</option>
                                        <option value="Digital">Digital</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">IP Pool</label>
                                <div class="col-md-6">
                                    <select id="pool_name" name="pool_name" class="form-control">
                                        <option value=''>Select Pool</option>
                                    </select>
                                </div>
                            </div>
                            -->

                            <div class="row p-2">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
