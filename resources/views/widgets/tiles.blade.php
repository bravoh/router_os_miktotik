<div class="clearfix container-fluid row">

    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="panel widget center bgimage" style="margin-bottom:0;overflow:hidden;background-image:url('/images/rock-1771916_640.jpg');">
            <div class="dimmer"></div>
            <div class="panel-content">
                <i class="voyager-person"></i>
                <h4>{{$card_data["customer_count"]}} Customers</h4>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="panel widget center bgimage" style="margin-bottom:0;overflow:hidden;background-image:url('/images/money-2212965_640.jpg');">
            <div class="dimmer"></div>
            <div class="panel-content">
                <i class="voyager-dollar"></i>
                <h4>{{$card_data["earnings"]}} Earnings</h4>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="panel widget center bgimage" style="margin-bottom:0;overflow:hidden;background-image:url('images/connection-4885313_640.jpg');">
            <div class="dimmer"></div>
            <div class="panel-content">
                <i class="voyager-tag"></i>
                <h4>{{$card_data["active_subscriptions"]}} Active Devices</h4>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="panel widget center bgimage" style="margin-bottom:0;overflow:hidden;background-image:url('/voyager-assets?path=images%2Fwidget-backgrounds%2F02.jpg');">
            <div class="dimmer"></div>
            <div class="panel-content">
                <i class="voyager-plug"></i>
                <h4>{{$card_data["downed"]}} Downed Devices</h4>
            </div>
        </div>
    </div>
</div>
