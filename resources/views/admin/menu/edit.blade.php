@extends('admin.layouts.base')
@section('content')
<div class="col-md-6">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bubble font-red-mint"></i>
                <span class="caption-subject font-red-mint sbold">添加菜单</span>
            </div>
            <!--                <div class="actions">
                                <div class="btn-group">
                                    <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;"> Option 1</a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a href="javascript:;">Option 2</a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">Option 3</a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">Option 4</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>-->
        </div>
        <div class="portlet-body">
            BEGIN FORM
            <form id="editForm" action="#" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">父级菜单</label>
                        <div class="col-md-9">
                            <select name="parent_id" class="form-control">
                                <option value="0">顶级菜单</option>
                                @php
                                $menuModel = config('admin.database.menu_model');
                                @endphp
                                @include('admin.menu.menuSelect',['menus'=>$menuModel::where('parent_id',0)->get(),'sign'=>'&nbsp;&nbsp;&nbsp;&nbsp;'])
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">标题</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-pencil"></i>
                                </span>
                                <input name="title" type="text" class="form-control" placeholder="输入标题"> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">图标</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input name="icon" style="height: 34px" class="icon" type="text" class="form-control" placeholder=""> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">路径</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-pencil"></i>
                                </span>
                                <input name="uri" type="text" class="form-control" placeholder="输入路径"> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">角色</label>
                        <div class="col-md-9">
                            <select name="roles[]" class="form-control select2" multiple>
                                @php
                                $roleModel = config('admin.database.roles_model');
                                @endphp
                                @foreach($roleModel::all() as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button id="addButton" type="button" class="btn btn-circle green">提交</button>
                            <button type="reset" class="btn btn-circle grey-salsa btn-outline">取消</button>
                        </div>
                    </div>
                </div>
            </form>
            END FORM
        </div>
    </div>
</div>
@endsection
@section('otherjs')
<script>
//    $('.icon').iconpicker();
    $('.select2').select2();
    $('#addButton').click(function () {
        $.post('/admin/menu', $('#editForm').serialize(), function (res) {
            if (res.status == 0) {
                layer.msg(res.msg);
            } else {
                layer.msg(res.msg, {icon: 1}, function () {
                    location.href = '/admin/menu';
                });
            }
        });
    });
</script>
@endsection