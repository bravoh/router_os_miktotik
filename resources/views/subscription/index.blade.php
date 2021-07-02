@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.side')
            </div>
           
            <div class="col-md-8">
                <div class="card">

                    <p class="text-muted m-3">Subscriptions</p>


                    <div class="card-body">
                        
                        <table class="table table-sm table-striped table-borderless" id = "table_id">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Plan</th>
                                    <th>Valid From</th>
                                    <th>Valid Till</th>
                                    <th>Downed On</th>
                                    <th>Renewed On</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0;foreach($subscriptions as $item){ $i++;?>
                            <tr>
                                <td><?= $i;?></td>
                                <td><?php echo $item->name;?></td>
                                <td><?php echo $item->plan;?></td>
                                <td><?php echo $item->valid_from;?></td>
                                <td><?php echo $item->valid_until;?></td>
                                <td><?php echo $item->downed_on;?></td>
                                <td><?php echo $item->renewed_on;?></td>
                                <td><?php echo $item->status;?></td>
                            </tr>
                            <?php }?>
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
