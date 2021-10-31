<?php
$rates = \App\PricingRate::whereType("live")->get();
$recipient_types = [
    'select'=>"Select Customers",
    'all'=>"All Customers",
];
foreach ($rates as $rate){
    $recipient_types["by_".$rate->name] = ucwords($rate->name)." Subscribers";
}
?>
<!-- Nav tabs -->
<style>
    .nav-tabs {
        border-bottom: 1px solid #ddd;
    }
    .nav-tabs > li {
        float: left;
        margin-bottom: -1px;
    }
    .nav-tabs > li > a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .nav-tabs > li > a:hover {
        border-color: #eeeeee #eeeeee #ddd;
    }
    .nav-tabs > li.active > a,
    .nav-tabs > li.active > a:hover,
    .nav-tabs > li.active > a:focus {
        color: #555555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
        border-radius: 4px 4px 0 0;
    }
    .nav-tabs.nav-justified {
        width: 100%;
        border-bottom: 0;
    }
    .nav-tabs.nav-justified > li {
        float: none;
    }
    .nav-tabs.nav-justified > li > a {
        margin-bottom: 5px;
        text-align: center;
    }
    .nav-tabs.nav-justified > .dropdown .dropdown-menu {
        top: auto;
        left: auto;
    }
    @media (min-width: 768px) {
        .nav-tabs.nav-justified > li {
            display: table-cell;
            width: 1%;
        }
        .nav-tabs.nav-justified > li > a {
            margin-bottom: 0;
        }
    }
    .nav-tabs.nav-justified > li > a {
        margin-right: 0;
        border-radius: 4px !important;
    }
    .nav-tabs.nav-justified > .active > a,
    .nav-tabs.nav-justified > .active > a:hover,
    .nav-tabs.nav-justified > .active > a:focus {
        border: 1px solid #ddd;
    }
    @media (min-width: 768px) {
        .nav-tabs.nav-justified > li > a {
            border-bottom: 1px solid #ddd;
            border-radius: 4px 4px 0 0;
        }
        .nav-tabs.nav-justified > .active > a,
        .nav-tabs.nav-justified > .active > a:hover,
        .nav-tabs.nav-justified > .active > a:focus {
            border-bottom-color: #fff;
        }
    }
    .voyager .nav-tabs, .voyager .nav-tabs>li>a:hover{
        background-color: white;
    }
</style>
<ul class="nav nav-tabs" role="tablist">
    <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>
    @foreach($recipient_types as $key => $option)
        <li @if($default == $key && $selected_value === NULL) class="active" @endif @if($selected_value == $key) class="active" @endif >
            <a href="#{{$key}}" role="tab" data-toggle="tab">
                <icon class="fa fa-home"></icon> {{ $option }}
            </a>
        </li>
    @endforeach
</ul>
<?php $selected_value = (isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field}))) ? old($row->field, $dataTypeContent->{$row->field}) : old($row->field); ?>
<select style="visibility: hidden" class="{{ $row->field }}_form_field" name="{{ $row->field }}">
    <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>
    @if(isset($options->options))
        <?php
        //$rates = config("router_os.rates");
        $rates = \App\PricingRate::whereType("live")->get();

        $recipient_types = [
            'select'=>"Select Customers",
            'all'=>"All Customers",
        ];

        foreach ($rates as $rate){
            $recipient_types["by_".$rate->name] = ucwords($rate->name)." Subscribers";
        }
        ?>
        @foreach($recipient_types as $key => $option)
            <option value="{{ $key }}" @if($default == $key && $selected_value === NULL) selected="selected" @endif @if($selected_value == $key) selected="selected" @endif>{{ $option }}</option>
        @endforeach
    @endif
</select>

