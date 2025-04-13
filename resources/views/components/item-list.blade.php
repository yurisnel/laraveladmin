@props(['name' => '', 'class' => '', 'item', 'selected'])
@php
if(!isset($selected)){
$selected = [];
}
@endphp

<li data-name="{{$name}}" data-value="{{$item->id}}" @if(in_array($item->id, $selected)) data-jstree='{"selected":true}' @endif> 
    {{ $item->description }} @if($item->name!='.') ({{$item->name}}) @endif

    @if ($item->children->count() > 0)
    <ul>
        @foreach ($item->children as $item)
        <x-item-list :item="$item" :selected="isset($selected)?$selected:[]" name="{{$name}}"/>
        @endforeach
    </ul>
    @endif
</li>