@props(['name' => '', 'label' => '','placeholder' => '', 'required' => '', 'class' => '', 'accept' => ''])

<label class="@if($required)required @endif mb-3 form-label @error('{{$name}}') is-invalid @enderror" for="{{$name}}FormField">{{$label}}</label>
{!! Form::file("$name", ['class' => ["form-control btn btn-sm", $required?"required":"", $class], 'placeholder' => "$placeholder", 'id'=>"{$name}FormField" , 'accept' => $accept, 'required'=> $required?true:false]) !!}
@error("$name")
<span class="text-danger">{{ $message }}</span>
@enderror