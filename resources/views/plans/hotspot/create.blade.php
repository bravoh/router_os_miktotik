@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Hotspot Plan</div>

                    <div class="card-body">
                        <form class="form-horizontal" method="post" role="form" action="{{route('plans.hotspot.create')}}">

                            {{csrf_field()}}

                            <div class="form-group">
                                <label>Plan Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <input type="hidden" name="type" value="Hotspot">
                            </div>

                            <div class="form-group">
                                <label>Plan Type</label>
                                <input type="radio" id="Unlimited" name="typebp" value="Unlimited" checked=""> Unlimited
                                <input type="radio" id="Limited" name="typebp" value="Limited"> Limited
                            </div>

                            <div style="display:none;" id="Type">
                                <div class="form-group">
                                    <label>Limit Type</label>
                                    <input type="radio" id="Time_Limit" name="limit_type" value="Time_Limit" checked=""> Time Limit
                                    <input type="radio" id="Data_Limit" name="limit_type" value="Data_Limit"> Data Limit
                                    <input type="radio" id="Both_Limit" name="limit_type" value="Both_Limit"> Both Limit
                                </div>
                            </div>

                            <div style="display:none;" id="TimeLimit">
                                <div class="form-group">
                                    <label>Time Limit</label>
                                    <input type="text" class="form-control" id="time_limit" name="time_limit" value="0">

                                    <select class="form-control" id="time_unit" name="time_limit_unit">
                                        <option value="Hrs">Hrs</option>
                                        <option value="Mins">Mins</option>
                                    </select>
                                </div>
                            </div>

                            <div style="display:none;" id="DataLimit">
                                <div class="form-group">
                                    <label>Data Limit</label>
                                    <input type="text" class="form-control" id="data_limit" name="data_limit" value="0">
                                    <select class="form-control" id="data_unit" name="data_limit_unit">
                                        <option value="MB">MBs</option>
                                        <option value="GB">GBs</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Bandwidth Name</label>
                                <select id="id_bw" name="bandwidth_id" class="form-control">
                                    <option value="">Select Bandwidth...</option>
                                    @foreach(\App\BandWidth::all() as $bandWidth)
                                    <option value="{{$bandWidth->id}}">{{$bandWidth->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Plan Price</label>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>

                            <div class="form-group">
                                <label>Shared Users</label>
                                <input type="text" class="form-control" id="shared_users" name="shared_users" value="1">
                            </div>

                            <div class="form-group">
                                <label>Plan Validity</label>
                                <input type="text" class="form-control" id="validity" name="validity">
                                <select class="form-control" id="validity_unit" name="validity_unit">
                                    <option value="Days">Days</option>
                                    <option value="Months">Months</option>
                                </select>
                            </div>

                            <!--
                            <div class="form-group">
                                <label>Router Name</label>
                                <select id="router_id" name="routers" class="form-control">
                                    <option value="Digital">Digital</option>
                                </select>
                            </div>
                            -->

                            <div class="form-group">
                                <button class="btn btn-success waves-effect waves-light waves-effect" type="submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/plans.js') }}" defer></script>
@endsection
