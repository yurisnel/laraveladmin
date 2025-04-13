@props(['type' => 'text', 'name' => '', 'label' => '','placeholder' => '', 'required' => '', 'class' => '', 'maxlength' => '', 'minlength' => '', ])

@php
$attrs = [
'class' => ["form-control", $required? "required": "", $class],
'placeholder' => "$placeholder",
'id'=>"{$name}FormField",
'required'=> $required? true: false];
if($maxlength){
$attrs['maxlength'] = $maxlength;
}
if($minlength){
$attrs['minlength'] = $minlength;
}

@endphp

<label class="@if($required)required @endif mb-3 form-label @error('{{$name}}') is-invalid @enderror" for="{{$name}}FormField">{{$label}}</label>
@if($type == 'email')
{!! Form::email("$name", null, $attrs) !!}
@elseif($type == 'textarea')
{!! Form::textarea("$name", null, $attrs) !!}
@else
{!! Form::text("$name", null, $attrs) !!}
@endif

@error("$name")
<span class="text-danger">{{ $message }}</span>
@enderror