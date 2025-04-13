@props(['iconClass', 'title', 'id'])

@php
if(empty($id)){
$id = "menu-father-".str_replace(' ', '', strtolower($title));
}
@endphp


<div id="{{$id}}" data-kt-menu-trigger="click" class="menu-item here menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="{{$iconClass}}"></i>
        </span>
        <span class="menu-title">{{$title}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        {{ $slot }}
    </div>
</div>


