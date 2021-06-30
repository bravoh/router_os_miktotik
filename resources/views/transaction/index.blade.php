@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>

            <div class="col-md-8">
                <div class="card">

                    <p class="text-muted m-3">Transactions</p>


                    <div class="card-body">
                        
                        <table class="table table-sm table-striped table-borderless" id = "table_id">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Amount</th>
                                    <th>Transaction Code</th>
                                    <th>Time Paid</th>
                                    <th>Status</th>
                                    <th>Mode</th>
                                    <!--<th>Reference</th>-->
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->customer_name}}</td>
                                <td>{{$item->amount}}</td>
                                <td>{{$item->trx_code}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->status}}</td>
                                <td>{{$item->mode}}</td>
                               <!-- <td>{{$item->ref}}</td>-->
                                
                                
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
