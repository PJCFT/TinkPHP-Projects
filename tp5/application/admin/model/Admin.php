<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Admin extends Model 
{	
	//验证登录
	public function login($data){
		//验证码验证
		$captcha = new \think\captcha\Captcha();
		if(!$captcha->check($data['code'])){
			return 4;
		}
		$user = Db::name('admin')->where('username', '=', $data['username'])->find();
		if($user){
			if($user['password'] == md5($data['password'])){
				//写入session
				session('username', $user['username']);
				session('uid', $user['id']);

				return 3;//信息正确。
			}else{
				return 2;//密码错误;
			}

		}else{
			return 1;//用户不存在
		}
	}


}