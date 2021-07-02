<div class="card">
{{--    <div class="card-header">Menu</div>--}}
    <div class="card-body">
        <ul>
{{--            <li><a href="#">Customers</a></li>--}}
            <li><a href="{{route('customers.index')}}">Customers</a></li>
{{--            <li><a href="{{route('customers.create')}}" class="ml-3">Add</a></li>--}}
{{--            <li><a href="{{route('prepaid.index')}}" class="ml-3">Prepaid</a></li>--}}
            <li><a href="{{route('transactions.index')}}">Transactions</a></li>
            <li><a href="{{route('subscriptions.index')}}">Subscriptions</a></li>
            <li><a href="{{route('sms.index')}}">SMS</a></li>
{{--            <li><a href="{{route('plans.index')}}">Service Plans (coming soon)</a></li>--}}
{{--            <li><a href="{{route('bandwidth.index')}}">Bandwidth (coming soon)</a></li>--}}
        </ul>
    </div>
</div>
