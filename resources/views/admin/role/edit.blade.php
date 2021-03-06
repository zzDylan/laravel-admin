@extends('admin.layouts.base')
@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>编辑角色</div>
        <!--        <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                    <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    <a href="javascript:;" class="reload"> </a>
                    <a href="javascript:;" class="remove"> </a>
                </div>-->
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form id="editForm" method="post" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">名称</label>
                    <div class="col-md-8">
                        <div class="help-block with-errors"></div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil"></i>
                            </span>
                            <input name="name" value="{{$role->name}}" type="text" class="form-control" placeholder="输入名称" required> 
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">标识</label>
                    <div class="col-md-8">
                        <div class="help-block with-errors"></div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil"></i>
                            </span>
                            <input name="slug" value="{{$role->slug}}" type="text" class="form-control" placeholder="输入标识" required> 
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">权限</label>
                    <div class="col-md-8">
                        <div class="help-block with-errors"></div>
                        <select style="width: 100%;" name="permissions[]" class="form-control select2" multiple>
                            @foreach($allPermissions as $permission)
                                @if(!empty($targetPermissions) && in_array($permission->id,$targetPermissions->pluck('id')->toArray()))
                                <option selected value="{{$permission->id}}">{{$permission->name}}</option>
                                @else
                                <option value="{{$permission->id}}">{{$permission->name}}</option>
                                @endif
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
                url: "{{asset(config('admin.prefix').'/role')}}"+'/'+{{$role->id}},
                type: 'put',
                dataType: "json",
                data: $("#editForm").serialize(),
                success: function (res) {
                    layer.closeAll();
                    if (res.status == 1) {
                        layer.msg(res.msg, {icon: 1});
                        location.href = "{{asset(config('admin.prefix')).'/role'}}";
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