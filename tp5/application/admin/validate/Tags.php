<?php
namespace app\admin\validate;
use think\Validate;
//后台验证规则，和验证场景设置。
class Tags extends Validate
{
	protected $rule =   [
        'tagname'  => 'require|max:25|unique:tags',    
    ];
    
    protected $message  =   [
        'tagname.require' => 'Tags标签标题必须填写',
        'tagname.max'     => 'Tags标签标题长度不能大于25个字符',
        'tagname.unique' => 'Tags标签不能重复',
    ];
	
	protected $scene = [
        'add'  =>  ['tagname'],
        'edit'  =>  ['tagname'],
    ];
}