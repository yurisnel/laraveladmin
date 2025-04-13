@props(['active', 'href', 'title', 'id', 'iconClass'])

@php
if(empty($id)){
$id = "menu-link-".str_replace(' ', '', strtolower($title));
}
@endphp


<div class="menu-item">
    <a class="menu-link" href="{{ $href }}" id="{{$id}}">
        <span class="menu-icon">
            @if(!empty($iconClass))
            <i class="{{$iconClass}}"></i>
            @else
            <i class="bullet bullet-dot"></i>
            @endif
        </span>
        <span class="menu-title">{{$title}}</span>
    </a>
</div>