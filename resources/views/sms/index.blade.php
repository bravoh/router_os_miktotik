@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">

                    <p class="text-muted m-3">SMS</p>


                    <div class="card-body">
                        
                        <table class="table table-sm table-striped table-borderless" id = "table_id">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    
                                    <th>Receipant</th>
                                    <th>Message</th>
                                    <th>Cost</th>
                                    
                                    <th>Status</th>
                                    <th>Message ID</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($sms as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                
                                <td>{{$item->recipient}}</td>
                                <td>{{$item->message}}</td>
                                <td>{{$item->cost}}</td>
                               
                                <td>{{$item->status}}</td>
                                <td>{{$item->messageId}}</td>
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
