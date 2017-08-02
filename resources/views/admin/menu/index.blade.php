@if(!Request::header('X-PJAX')) 
    @extends('admin.layouts.base')
@endif
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <span id="nestable-menu">
                    <button type="button" class="btn green btn-outline sbold uppercase" data-action="expand-all"><i class="fa fa-plus"></i>展开</button>
                    <button type="button" class="btn red btn-outline sbold uppercase" data-action="collapse-all"><i class="fa fa-minus"></i>收起</button>
                </span>
                <button id="save" type="button" class="btn blue btn-outline sbold uppercase" data-action="collapse-all" ><i class="fa fa-save"></i>保存</button>
                <button type="button" onclick="javascript:location.reload()" class="btn yellow btn-outline sbold uppercase" data-action="collapse-all"><i class="fa fa-refresh"></i>刷新</button>
            </div>
            <div class="portlet-body ">
                <div class="dd" id="nestable_list_1">
                    @include('admin.menu.nestablePart',['menus'=>$menus])
                </div>
            </div>
        </div>
    </div>
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
                <form id="addForm" method="post" action="/admin/menu" class="form-horizontal">
                    <div class="form-body">
                        {{ csrf_field() }}
                        <div class="form-group @if($errors->has('parent_id')) has-error  @endif">
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
                        <div class="form-group @if($errors->has('title')) has-error  @endif">
                            <label class="col-md-3 control-label">标题</label>
                            <div class="col-md-8">
                                @if($errors->has('title'))
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$errors->first('title')}}</label>
                                @endif
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                    <input name="title" value="{{old('title')}}" type="text" class="form-control" placeholder="输入标题"> 

                                </div>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('icon')) has-error  @endif">
                            <label class="col-md-3 control-label">图标</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    @if($errors->has('icon'))
                                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$errors->first('icon')}}</label>
                                    @endif
                                    <input name="icon" value="{{old('icon')}}" style="height: 34px" class="icon" type="text" class="form-control" placeholder=""> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('uri')) has-error  @endif">
                            <label class="col-md-3 control-label">路径</label>
                            <div class="col-md-8">
                                @if($errors->has('uri'))
                                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$errors->first('uri')}}</label>
                                @endif
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                    <input name="uri" value="{{old('uri')}}" type="text" class="form-control" placeholder="输入路径"> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('roles')) has-error  @endif">
                            <label class="col-md-3 control-label">角色</label>
                            <div class="col-md-9">
                                @if($errors->has('roles'))
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$errors->first('roles')}}</label>
                                @endif
                                <select name="roles[]" class="form-control select2" multiple>
                                    @php
                                    $roleModel = config('admin.database.roles_model');
                                    @endphp
                                    @foreach($roleModel::all() as $role)
                                    <option @if(!empty(old('roles')) && in_array($role->id,old('roles'))) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green">提交</button>
                                <button type="reset" class="btn btn-circle grey-salsa btn-outline">取消</button>
                            </div>
                        </div>
                    </div>
                </form>
                END FORM
            </div>
        </div>
    </div>
</div>
@endsection
@section('otherjs')
<script>
//    $('.icon').iconpicker();
    $('.dd').nestable({/* config options */});
    $('.dd').on('change', function () {
        $("#save").attr('disabled', false);
    });
    $('#save').click(function () {
        var nestable = $('.dd').nestable('serialize');
        console.log(nestable);
        $.post('/admin/menu/nestable', {"nestable": nestable}, function (res) {
            if (res.status == 0) {
                layer.msg(res.msg, {icon: 5});
            } else {
                layer.msg(res.msg, {icon: 1}, function () {
                    location.href = '/admin/menu';
                });
            }
        });
    });
    $('#nestable-menu').on('click', function (e)
    {
        var target = $(e.target),
                action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
    $('.select2').select2();
    $('#addButton').click(function () {
        $.post('/admin/menu', $('#addForm').serialize(), function (res) {
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