<?php
namespace app\admin\validate;
use think\Validate;
//后台验证规则，和验证场景设置。
class Admin extends Validate
{
	protected $rule =   [
        'username'  => 'require|max:25|unique:admin',
        'password' => 'require',    
    ];
    
    protected $message  =   [
        'username.require' => '管理员名称必须填写',
        'username.max'     => '名称长度不能大于25个字符',
        'username.unique' => '管理员名称不能重复',
        'password.require' => '管理员密码必须填写',
    ];
	
	protected $scene = [
        'add'  =>  ['username' => 'require|unique:admin','password'],
        'edit'  =>  ['username' => 'require|unique:admin'],
    ];
}