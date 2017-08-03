<ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    @php
        $menuModel = config('admin.database.menu_model');
    @endphp
    @include('admin.layouts.menuPart',['menus'=>$menuModel::where('parent_id',0)->orderBy('order')->get()])
</ul>