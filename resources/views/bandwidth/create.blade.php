@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Bandwidth</div>

                    <div class="card-body">

                        <form class="needs-validation" method="POST" action="{{route('bandwidth.create')}}">

                            {{csrf_field()}}

                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="" value="" required="">
                                </div>

                                <div class="col-sm-6">
                                    <label for="upload_rate" class="form-label">Upload Speed Limit</label>
                                    <input type="text" name="upload_rate" class="form-control" id="upload_rate" placeholder="" value="" required="">
                                    <select class="form-control" id="upload_rate_unit" name="upload_rate_unit">
                                        <option value="Kbps">Kbps</option>
                                        <option value="Mbps">Mbps</option>
                                    </select>
                                </div>

                                <div class="col-6 mt-3">
                                    <label for="download_rate" class="form-label">Download Speed Limit</label>
                                    <input type="text" name="download_rate" class="form-control" id="download_rate" placeholder="">
                                    <select class="form-control" id="download_rate_unit" name="download_rate_unit">
                                        <option value="Kbps">Kbps</option>
                                        <option value="Mbps">Mbps</option>
                                    </select>
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
