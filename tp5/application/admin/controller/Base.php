<?php
namespace app\admin\controller;
use think\Controller;
//引入分页类元素
use app\admin\model\Admin as AdminModel;//使用Admin的类别名这样防止类名重复冲突。

class Base extends Controller
{
	//初始化。进行权限认证
	public function _initialize(){
		if (!session('username')) {
			# code..
			$this->error('请先登录系统！', 'Login/index');
		}
	}
}