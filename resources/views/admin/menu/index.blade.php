@extends('admin.layouts.base')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <span id="nestable-menu">
                    <button type="button" class="btn green btn-outline sbold uppercase" data-action="expand-all"><i class="fa fa-plus"></i>展开</button>
                    <button type="button" class="btn red btn-outline sbold uppercase" data-action="collapse-all"><i class="fa fa-minus"></i>收起</button>
                </span>
                <button id="save" type="button" class="btn blue btn-outline sbold uppercase" data-action="collapse-all" disabled="disabled"><i class="fa fa-save"></i>保存</button>
                <button id="refresh" type="button" class="btn yellow btn-outline sbold uppercase" data-action="collapse-all"><i class="fa fa-refresh"></i>刷新</button>
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
            </div>
            <div class="portlet-body">
                <form id="addForm" method="post" action="/admin/menu" class="form-horizontal">
                    <div class="form-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-3 control-label">父级菜单</label>
                            <div class="col-md-9">
                                <select name="parent_id" class="form-control" required>
                                    <option value="0">顶级菜单</option>
                                    @include('admin.menu.menuSelect',['menus'=>$menus,'sign'=>'&nbsp;&nbsp;&nbsp;&nbsp;'])
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">标题</label>
                            <div class="col-md-8">
                                <div class="help-block with-errors"></div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                    <input name="title" value="" type="text" class="form-control" placeholder="输入标题" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">图标</label>
                            <div class="col-md-4">
                                <div class="help-block with-errors"></div>
                                <div class="input-group">
                                    <input name="icon" value="" style="height: 34px" class="icon" type="text" class="form-control" placeholder="" required> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">路径</label>
                            <div class="col-md-8">
                                <div class="help-block with-errors"></div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                    <input name="uri" value="" type="text" class="form-control" placeholder="输入路径" required> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">角色</label>
                            <div class="col-md-8">
                                <div class="help-block with-errors"></div>
                                <select id="roles" name="roles[]" class="form-control" multiple required>
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="add_button" type="submit" class="btn btn-circle green">提交</button>
                                <button type="reset" class="btn btn-circle grey-salsa btn-outline">取消</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('otherjs')
<script>
    $('#addForm').validator({focus: false})
    $('#roles').select2();
    $('.icon').iconpicker();
    $('.dd').nestable();
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
                    location.href = "{{asset(config('admin.prefix').'/menu')}}";
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
    $('.menu_delete').click(function () {
        var ele = $(this);
        var id = ele.data('id')
        layer.confirm('确认删除?', {btn: ['是', '否']}, function () {
            layer.load(1, {shade: [0.1, '#fff']});
            $.ajax({
                url: "{{asset(config('admin.prefix').'/menu')}}" + '/' + id,
                type: 'delete',
                dataType: 'json',
                success: function (res) {
                    layer.closeAll();
                    if (res.status == 1) {
                        ele.parents("li")[0].remove();
                        layer.msg(res.msg, {icon: 1});
                    } else {
                        layer.msg(res.msg, {icon: 5});
                    }
                }
            });
        });
    });
    $('#addForm').validator().on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            layer.load(1, {shade: [0.1, '#fff']});
            $.post("{{asset(config('admin.prefix')).'/menu'}}", $('#addForm').serialize(), function (res) {
                layer.closeAll();
                if (res.status == 1) {
                    layer.msg(res.msg, {icon: 1});
                    location.href = "{{asset(config('admin.prefix')).'/menu'}}";
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
            });
        }
        return false;
    })
</script>
@endsection