@extends('admin.layouts.base')
@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>菜单编辑</div>
        <!--        <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                    <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    <a href="javascript:;" class="reload"> </a>
                    <a href="javascript:;" class="remove"> </a>
                </div>-->
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form id="editForm" method="post" action="/admin/menu/{{$targetMenu->id}}" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">父级菜单</label>
                    <div class="col-md-8">
                        <select name="parent_id" class="form-control" required>
                            <option value="0">顶级菜单</option>
                            @php
                            $data = [
                            'menus'=>$menus,
                            'sign'=>'&nbsp;&nbsp;&nbsp;&nbsp;'
                            ];
                            if(isset($targetMenu)){
                            $data['targetMenu'] = $targetMenu;
                            }
                            @endphp
                            @include('admin.menu.menuSelect',$data)
                        </select>
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
                            <input name="title" value="{{$targetMenu->title}}" type="text" class="form-control" placeholder="输入标题" required> 
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">图标</label>
                    <div class="col-md-4">
                        <div class="help-block with-errors"></div>
                        <div class="input-group">
                            <input name="icon" value="{{$targetMenu->icon}}" style="height: 34px" class="icon" type="text" class="form-control" placeholder="" required> 
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
                            <input name="uri" value="{{$targetMenu->uri}}" type="text" class="form-control" placeholder="输入路径" required> 
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">角色</label>
                    <div class="col-md-8">
                        <div class="help-block with-errors"></div>
                        <select style="width: 100%;" id="roles" name="roles[]" class="form-control select2" multiple required>
                            @foreach($roles as $role)
                            <option @if(isset($targetMenu) && in_array($role->id,$menuRoles)) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button id="edit_button" type="submit" class="btn btn-circle green">提交</button>
                        <button type="reset" class="btn btn-circle grey-salsa btn-outline">取消</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
@endsection
@section('otherjs')
<script>
    $('.icon').iconpicker();
    $('.select2').select2();
    $('#editForm').validator({disable:false}).on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            layer.load(1, {shade: [0.1, '#fff']});
            $.ajax({
                url: "{{asset(config('admin.prefix').'/menu').'/'.$targetMenu->id}}",
                type: 'put',
                dataType: "json",
                data: $("#editForm").serialize(),
                success: function (res) {
                    layer.closeAll();
                    if (res.status == 1) {
                        layer.msg(res.msg, {icon: 1});
                        location.href = "{{asset(config('admin.prefix')).'/menu'}}";
                    } else {
                        layer.msg(res.msg, {icon: 5});
                    }
                }
            });
        }
        return false;
    })
</script>
@endsection