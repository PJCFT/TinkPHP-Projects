<?php
namespace app\admin\validate;
use think\Validate;
//后台验证规则，和验证场景设置。
class Cate extends Validate
{
	protected $rule =   [
        'catename'  => 'require|max:25|unique:cate', 
    ];
    
    protected $message  =   [
        'catename.require' => '栏目名称必须填写',
        'catename.max'     => '栏目名称长度不能大于25个字符',
        'catename.unique' => '栏目名称不能重复'
    ];
	
	protected $scene = [
        'add'  =>  ['catename' => 'require|unique:cate'],
        'edit'  =>  ['catename' => 'require|unique:cate'],
    ];
}