@props(['name' => '', 'label' => '','placeholder' => '', 'required' => '', 'class' => '', 'step' => '1', 'min' => '1', 'max' => ''])

@php
$attrs = [
'class' => ["form-control", $required? "required": "", $class],
'placeholder' => "$placeholder",
'id'=>"{$name}FormField",
'required'=> $required? true: false];
if($max){
$attrs['max'] = $max;
}
if($min){
$attrs['min'] = $min;
}
if($step){
$attrs['step'] = $step;
}
@endphp

<label class="@if($required)required @endif mb-3 form-label @error('{{$name}}') is-invalid @enderror" for="{{$name}}FormField">{{$label}}</label>
{!! Form::number("$name", null, $attrs) !!}
@error("$name")
<span class="text-danger">{{ $message }}</span>
@enderror