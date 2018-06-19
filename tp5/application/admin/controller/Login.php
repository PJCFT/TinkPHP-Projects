<?php
namespace app\Admin\controller;
use think\Controller;
// 引入验证登录类元素,利用模型来处理验证
use app\admin\model\Admin;
class Login extends Controller
{
	
	public function index()
	{
		if(request()->isPost()){
			// 创建验证类元素的对象，方便调用里面的验证方法
			$admin = new Admin();
			$data = input('post.');
			$num = $admin->login($data);
			//先验证验证码后验证密码
			if($num == 4){
				$this->error('验证码错误');
			}elseif ($num == 3) {
				$this->error('信息正确,正在为你跳转...','index/index');//验证正确，将会跳到后台首页
			}
			else{
				$this->error('用户名或密码错误');
			}
		}
		return $this->fetch('login');
	}
	
}