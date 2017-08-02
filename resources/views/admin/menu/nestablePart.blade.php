<ol class="dd-list">
    @foreach($menus as $menu)
    <li class="dd-item" data-id="{{$menu->id}}">
        <div class="dd-handle"><i class="fa {{$menu->icon}}"></i>{{$menu->title}} </div>
        @if($menu->hasChildren())
        @include('admin.menu.nestablePart',['menus'=>$menu->childrens()])
        @endif
    </li>
    @endforeach
</ol>