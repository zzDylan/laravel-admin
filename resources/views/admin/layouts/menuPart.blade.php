@foreach($menus as $key=>$menu)
@if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->visible($menu->roles))
<li class="nav-item">
    <a href="@if($menu->hasChildren())javascript:;@else{{url(config('admin.prefix').'/'.$menu->uri)}}@endif" class="nav-link @if($menu->hasChildren())nav-toggle @endif">
        <i class="fa {{$menu->icon}}"></i>
        <span class="title">{{$menu->title}}</span>
        @if($menu->hasChildren())
        <span class="arrow"></span>
        @endif
    </a>
    @if($menu->hasChildren())
        <ul class="sub-menu">
            @include('admin.layouts.menuPart',['menus'=>$menu->childrens()])
        </ul>
    @endif
</li>
@endif
@endforeach