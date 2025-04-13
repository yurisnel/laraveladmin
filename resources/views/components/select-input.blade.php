@props(['name' => '','values' => '','selected' => '' , 'label' => '','placeholder' => '', 'required' => '', 'class' => ''])

<label class="@if($required)required @endif mb-3 form-label @error('{{$name}}') is-invalid @enderror" for="{{$name}}FormField">{{$label}}</label>
{!! Form::select($name, $values, $selected, ["placeholder" => $placeholder, "class" => ["form-select select", $required?"required":"", $class], "id" =>"{$name}FormField"]) !!}
@error("$name")
<span class="text-danger">{{ $message }}</span>
@enderror
