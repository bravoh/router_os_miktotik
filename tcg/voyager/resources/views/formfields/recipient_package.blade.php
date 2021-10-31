<?php $selected_value = (isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field}))) ? old($row->field, $dataTypeContent->{$row->field}) : old($row->field); ?>
<?php
$rates = \App\PricingRate::whereType("live")->get();
?>
<select class="form-control select2 {{ $row->field }}_form_field" name="{{ $row->field }}">
    <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>
    @if(isset($options->options))
        @foreach($rates as $key => $option)
            <option value="by_{{$option->name}}" @if($default == $key && $selected_value === NULL) selected="selected" @endif @if($selected_value == $key) selected="selected" @endif>
                {{$option->name}} Subscribers
            </option>
        @endforeach
    @endif
</select>
