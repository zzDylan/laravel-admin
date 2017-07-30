<ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    @include('admin.layouts.menuPart',['menus'=>App\Models\Menu::where('parent_id',0)->get()])
</ul>