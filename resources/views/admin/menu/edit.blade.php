@extends('admin.layouts.base')
@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Form Actions On Bottom </div>
<!--        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            <a href="javascript:;" class="reload"> </a>
            <a href="javascript:;" class="remove"> </a>
        </div>-->
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form data-pjax id="editForm" method="post" action="/admin/menu/{{$targetMenu->id}}" class="form-horizontal">
                    <div class="form-body">
                        {{ method_field('PUT') }}
                        <div class="form-group @if($errors->has('parent_id')) has-error  @endif">
                            <label class="col-md-3 control-label">父级菜单</label>
                            <div class="col-md-8">
                                <select name="parent_id" class="form-control">
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
                                    <input name="title" value="{{$targetMenu->title or old('title')}}" type="text" class="form-control" placeholder="输入标题"> 

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
                                    <input name="icon" value="{{$targetMenu->icon or old('icon')}}" style="height: 34px" class="icon" type="text" class="form-control" placeholder=""> 
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
                                    <input name="uri" value="{{$targetMenu->uri or old('uri')}}" type="text" class="form-control" placeholder="输入路径"> 
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
                                    <option @if(!empty(old('roles')) && in_array($role->id,old('roles'))) selected @elseif(isset($targetMenu) && in_array($role->id,$menuRoles)) selected @endif value="{{$role->id}}">{{$role->name}}</option>
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
</script>
@endsection