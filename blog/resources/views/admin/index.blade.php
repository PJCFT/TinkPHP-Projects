@extends('layouts.admin')
@section('content')
		<!--头部 开始-->
<div class="top_box">
	<div class="top_left">
		<div class="logo">后台管理</div>
		<ul>
			<li><a href="{{url('admin/index')}}" class="active">首页</a></li>
			<li><a href="{{url('admin/info')}}" target="main">管理页</a></li>
		</ul>
	</div>
	<div class="top_right">
		<ul>
			<li>管理员：{{session('user')->user_name}}</li>
			@if(session('user')->user_id != 1)
				<li><a href="{{url('admin/admin/'.session('user')->user_id.'/edit')}}" target="main">修改密码</a></li>
				{{--<li><a href="{{url('admin/pass')}}" target="main">修改密码</a></li>--}}
			@endif
			<li><a href="{{url('admin/quit')}}">退出</a></li>
		</ul>
	</div>
</div>
<!--头部 结束-->

<!--左侧导航 开始-->
<div class="menu_box">
	<ul>
		<li>
			<h3><i class="fa fa-fw fa-clipboard"></i>管理员管理</h3>
			<ul class="sub_menu">
				<li><a href="{{url('admin/admin')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>管理员列表</a></li>
				<li><a href="{{url('admin/admin/create')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>添加管理员</a></li>
			</ul>
		</li>
		<li>
			<h3><i class="fa fa-fw fa-clipboard"></i>分类管理</h3>
			<ul class="sub_menu">
				<li><a href="{{url('admin/category')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>分类列表</a></li>
				<li><a href="{{url('admin/category/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加分类</a></li>

			</ul>
		</li>
		<li>
			<h3><i class="fa fa-fw fa-clipboard"></i>文章管理</h3>
			<ul class="sub_menu">
				<li><a href="{{url('admin/article')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>文章列表</a></li>
				<li><a href="{{url('admin/article/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加文章</a></li>

			</ul>
		</li>
		<li>
			<h3><i class="fa fa-fw fa-clipboard"></i>友情链接管理</h3>
			<ul class="sub_menu">
				<li><a href="{{url('admin/links')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>友情链接列表</a></li>
				<li><a href="{{url('admin/links/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加友情链接</a></li>

			</ul>
		</li>
		<li>
			<h3><i class="fa fa-fw fa-clipboard"></i>自定义导航管理</h3>
			<ul class="sub_menu">
				<li><a href="{{url('admin/navs')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>导航列表</a></li>
				<li><a href="{{url('admin/navs/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加自定义导航</a></li>

			</ul>
		</li>
		<li>
			<h3><i class="fa fa-fw fa-cog"></i>网站配置</h3>
			<ul class="sub_menu">
				<li><a href="{{url('admin/config')}}" target="main"><i class="fa fa-fw fa-cubes"></i>网站配置列表</a></li>
				<li><a href="{{url('admin/config/create')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>添加配置项</a></li>
				{{--<li><a href="#" target="main"><i class="fa fa-fw fa-database"></i>备份还原</a></li>--}}
			</ul>
		</li>
	</ul>
</div>
<!--左侧导航 结束-->

<!--主体部分 开始-->
<div class="main_box">
	<iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
</div>
<!--主体部分 结束-->

<!--底部 开始-->
<div class="bottom_box">
	CopyRight © 2015. Powered By PJC.
</div>
<!--底部 结束-->

@endsection


