<div class="col-lg-6 col-md-6 col-sm-12">
    <div class="panel-heading dropup">
        <i class="fa fa-server fa-fw"></i>
        Customers
    </div>
    <div class="bs-example" data-example-id="simple-list-group">
        <ul class="list-group">
            <li class="list-group-item">Total<span class="pull-right" id="admin_dashboard_panels_customers_total" style="">{{@count($data['customers']['all'])}}</span></li>
{{--            <li class="list-group-item">New<span class="pull-right" id="admin_dashboard_panels_customers_new">0</span></li>--}}
            <li class="list-group-item">Active<span class="pull-right" id="admin_dashboard_panels_customers_active">{{@count($data['customers']['active'])}}</span></li>
            <li class="list-group-item">Online<span class="pull-right" id="admin_dashboard_panels_customers_online" style="">{{@count($data['connections']['online'])}}</span></li>
            <li class="list-group-item">Online Sessions today<span class="pull-right" id="admin_dashboard_panels_customers_onlineToday" style="">{{@count($data['connections']['online_today'])}}</span></li>
{{--            <li class="list-group-item">Blocked<span class="pull-right" id="admin_dashboard_panels_customers_blocked">0</span></li>--}}
            <li class="list-group-item">Inactive<span class="pull-right" id="admin_dashboard_panels_customers_disabled">{{@count($data['customers']['downed'])}}</span></li>
{{--            <li class="list-group-item">Added last month<span class="pull-right" id="admin_dashboard_panels_customers_forMonth">3</span></li>--}}
{{--            <li class="list-group-item">Added last year<span class="pull-right" id="admin_dashboard_panels_customers_forYear">3</span></li>--}}
        </ul>
    </div>
</div>
