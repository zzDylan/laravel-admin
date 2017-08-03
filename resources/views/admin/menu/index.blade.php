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
                <form data-pjax id="addForm" method="post" action="/admin/menu" class="form-horizontal">
                    <div class="form-body">
                        {{ csrf_field() }}
                        <div class="form-group @if($errors->has('parent_id')) has-error  @endif">
                            <label class="col-md-3 control-label">父级菜单</label>
                            <div class="col-md-9">
                                <select name="parent_id" class="form-control">
                                    <option value="0">顶级菜单</option>
                                    @include('admin.menu.menuSelect',['menus'=>$menus,'sign'=>'&nbsp;&nbsp;&nbsp;&nbsp;'])
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
                            <div class="col-md-8">
                                @if($errors->has('roles'))
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$errors->first('roles')}}</label>
                                @endif
                                <select style="width: 100%;" id="roles" name="roles[]" class="form-control select2" multiple>
                                    @foreach($roles as $role)
                                    <option @if(!empty(old('roles')) && in_array($role->id,old('roles'))) selected @endif value="{{$role->id}}">{{$role->name}}</option>
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
<script>
    //$('.icon').iconpicker();
    $('.dd').nestable({/* config options */});
    $('.dd').on('change', function () {
        $("#save").attr('disabled', false);
    });
    $('#save').click(function () {
        var nestable = $('.dd').nestable('serialize');
        console.log(nestable);
        $.post('/admin/menu/nestable', {"nestable": nestable}, function (res) {
            console.log(res);
            if (res.status == 0) {
                toastr.error(res.msg);
            } else {
                $.pjax.reload('#pjax-container');
                toastr.success(res.msg);
            }
        });
    });
    $("#refresh").click(function () {
        $.pjax.reload('#pjax-container');
        toastr.success('刷新成功 !');
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

</script>
@endsection
@section('otherjs')

@endsection