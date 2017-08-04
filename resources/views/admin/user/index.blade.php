@extends('admin.layouts.base')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-social-dribbble font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">用户管理</span>
        </div>
    </div>
    <div class="portlet-body">
        <div id="toolbar">
            <button class="btn btn-success">新增</button>
            <button class="btn btn-danger remove">删除</button>
        </div>
        <table id="table"></table>
    </div>
</div>
@endsection
@section('otherjs')
<script>
    $table = $('#table');
    $table.bootstrapTable({
        url: "{{asset(config('admin.prefix').'/user')}}",
        search: true,
        sidePagination: 'server',
        pagination: true,
        showRefresh: true,
        showExport: true,
        advancedSearch: true,
        toolbar: "#toolbar",
        idTable:"table",
        columns: [
            {
                field: 'state',
                checkbox: true,
            }, {
                field: 'id',
                title: 'id'
            }, {
                field: 'username',
                title: '用户名'
            }, {
                field: 'roles',
                title: '角色'
            },
            {
                field: 'created_at',
                title: '创建时间'
            }, {
                field: 'updated_at',
                title: '更新时间'
            },
        ]
    }
    );
    $(".remove").click(function () {
        layer.confirm('确认删除?', {btn: ['是', '否']}, function () {
            layer.load(1, {shade: [0.1, '#fff']});
            var ids = getSelectionIds();
            layer.load(1, {shade: [0.1, '#fff']});
            $.post("{{asset(config('admin.prefix').'/user/batch_destroy')}}", {ids: ids}, function (res) {
                layer.closeAll();
                if (res.status == 0) {
                    layer.msg(res.msg, {icon: 5});
                } else {
                    layer.msg(res.msg, {icon: 1});
                    //移除行
                    $table.bootstrapTable('remove', {field: 'id', values: ids});
                }
            });
        });

    });

    //获取所有选中框的ids
    function getSelectionIds() {
        var selections = $table.bootstrapTable('getSelections');
        return $.map(selections, function (row) {
            return row.id
        });
    }

    function customSearch(Text) {
        console.log(Text);
    }
</script>
@endsection