@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 管理员管理
</div>
<!--面包屑导航 结束-->

{{--<!--结果页快捷搜索框 开始-->--}}
{{--<div class="search_wrap">--}}
    {{--<form action="" method="post">--}}
        {{--<table class="search_tab">--}}
            {{--<tr>--}}
                {{--<th width="120">选择分类:</th>--}}
                {{--<td>--}}
                    {{--<select onchange="javascript:location.href=this.value;">--}}
                        {{--<option value="">全部</option>--}}
                        {{--<option value="http://www.baidu.com">百度</option>--}}
                        {{--<option value="http://www.sina.com">新浪</option>--}}
                    {{--</select>--}}
                {{--</td>--}}
                {{--<th width="70">关键字:</th>--}}
                {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                {{--<td><input type="submit" name="sub" value="查询"></td>--}}
            {{--</tr>--}}
        {{--</table>--}}
    {{--</form>--}}
{{--</div>--}}
{{--<!--结果页快捷搜索框 结束-->--}}

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>管理员列表</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/admin/create')}}"><i class="fa fa-plus"></i>新增管理员</a>
                <a href="{{url('admin/admin')}}"><i class="fa fa-recycle"></i>全部管理员</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">ID</th>
                    <th>管理员名称</th>
                    <th>操作</th>
                </tr>

                @foreach($data as $v)
                <tr>
                    <td class="tc">{{$v->user_id}}</td>
                    <td>
                        <a href="#">{{$v->user_name}}</a>
                    </td>
                    <td>
                        @if($v->user_id != 1)
                        <a href="{{url('admin/admin/'.$v->user_id.'/edit')}}">修改</a>
                        <a href="javascript:;" onclick="delCate({{$v->user_id}})">删除</a>
                        {{--<a href="javascript:;" onclick="delCate({{$v->cate_id}})">删除</a>--}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="page_nav">
            {!! $data->render() !!}
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->

<script>
    //删除分类
    function delCate(user_id) {
        layer.confirm('你确定要删除这个管理员吗？',{
            btn:['确定','取消']//按钮
        },function (){
            $.post("{{url('admin/admin/')}}/"+user_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                if(data.status == 0){
                    location.href = location.href;
                    layer.msg(data.msg,{icon:6});
                }else {
                    layer.msg(data.msg,{icon:5});
                }
            });
        },function (){

        });
    }
</script>

@endsection
