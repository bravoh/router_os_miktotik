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
                        <a href="{{route('customers.create')}}" class="btn btn-primary">Add</a><br><br>
                        <table class="table table-sm table-striped table-borderless" id = "table_id">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
{{--                                    <th>Account Number</th>--}}
                                    <th>IP</th>
                                    <th>Action</th>
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
                                <td>
                                    <span>
                                        <a href="{{ url('customers/edit/'.$item->id) }}" class = "btn btn-success btn-sm center-block" style = "display: inline-block;font-size:9px;width:50px;">Edit</a>
                                        <br>
                                        <a class = "btn btn-danger btn-sm center-block" style = "display: inline-block;cursor:pointer;width:50px;font-size:9px;" href="{{ url('customers/delete/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                    </span>
                                   
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
 

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
 
    <script type = "text/javascript">
    
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
        
    </script>
@endsection
