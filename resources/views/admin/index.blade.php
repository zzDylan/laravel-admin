@extends('admin.layouts.base')
@section('content')
<div class="row">
    <div class="col-md-10">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-social-dribbble font-green"></i>
                    <span class="caption-subject font-green bold uppercase">系统信息</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table data-toggle="table">
                        <tbody>
                            <tr>
                                <td>版本</td>
                                <td>1.0.0beta</td>
                            </tr>
                            <tr>
                                <td>laravel版本</td>
                                <td>5.4</td>
                            </tr>
                            <tr>
                                <td>服务器操作系统</td>
                                <td>Linux</td>
                            </tr>
                            <tr>
                                <td>运行环境</td>
                                <td>Apache</td>
                            </tr>
                            <tr>
                                <td>MYSQL版本</td>
                                <td>5.5.49</td>
                            </tr>
                            <tr>
                                <td>PHP版本</td>
                                <td>5.6.21</td>
                            </tr>
                            <tr>
                                <td>上传限制</td>
                                <td>2M</td>
                            </tr>
                            <tr>
                                <td>POST限制</td>
                                <td>8M</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection