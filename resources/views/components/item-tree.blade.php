@props(['name' => '', 'class' => '', 'item', 'selected'])
@php
if(!isset($selected)){
$selected = [];
}
@endphp

<li>
    <input type="checkbox" class="{{$class}}" name="{{$name}}" value="{{$item->id}}" {{ in_array($item->id, $selected) ? 'checked' : '' }}>
    <label class="form-label">
        &nbsp;{{ $item->description }} @if($item->name!='.') ({{$item->name}}) @endif
    </label>

    @if ($item->children->count() > 0)
    <ul style="display: none;">
        @foreach ($item->children as $item)
        <x-item-tree :item="$item" class="child" :selected="isset($selected)?$selected:[]" name="{{$name}}"/>
        @endforeach
    </ul>
    @endif
</li>