@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 管理员管理
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>编辑管理员</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/admin/create')}}"><i class="fa fa-plus"></i>新增管理员</a>
                <a href="{{url('admin/admin')}}"><i class="fa fa-recycle"></i>全部管理员</a>

            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/admin/'.$data->user_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>管理员名称：</th>
                    <td>
                        <input type="text" name="user_name" value="{{$data->user_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>管理员名称必须填写</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>管理员密码：</th>
                    <td>
                        <input type="password" name="user_pass">
                        <span><i class="fa fa-exclamation-circle yellow"></i>管理员密码必须填写</span>
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection
