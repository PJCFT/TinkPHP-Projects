<?php
namespace app\Admin\controller;
use app\admin\controller\Base;
//引入分页类元素
use app\Admin\model\Tags as TagsModel;//使用Tags的类别名这样防止类名重复冲突。
//use think\Db;
/**
* 加载Tags视图
*/
class Tags extends Base
{
	
	public function lst()
	{
		//分页
		//获取数据
		$list = TagsModel::paginate(5);
		//内容输出
		$this->assign('list',$list);

		return $this->fetch();
	}
	public function add(){
		//判断是否接受到数据
		if(request()->isPost()){
			// dump(input('post.'));//post.:打印所以post提交的数据.
			//通过数组来获取要插入的数据,并进行md5加密
			$data = [
				'tagname' => input('tagname'),
				
			];
			//后台对数据的验证
			//实例化验证规则
			$validate = \think\Loader::validate('Tags');
			// //进行验证判断
			// if (!$validate->check($data)) {
			//     $this->error($validate->getError());
			//     die;
			// }
			//通过场景选择验证,username验证。
			if (!$validate->scene('add')->check($data)) {
			    $this->error($validate->getError());
			    die;
			}
			//连接数据库，并将要插入的数据传进去,这种方式传入的话，要引入Db类即use think\Db;。
			// if(Db::name('Tags')->insert($data)){
			// 	return $this->success('添加Tags标签成功~！','lst');//显示成功信息并进行跳转到lst页面
			// }else{
			// 	return $this->error('添加Tags标签失败~！');
			// }
			// 这种是通过db助手进行添加的，无须引入类元素,这样方便很多                           
			if(db('Tags')->insert($data)){
				return $this->success('添加Tags标签成功~！','lst');//显示成功信息并进行跳转到lst页面
			}else{
				return $this->error('添加Tags标签失败~！');
			}
			return;
		}

		return $this->fetch();
	}
	//编辑操作
	public function edit(){
		//在浏览器中显示Tags标签名称。
		$id = input('id');
		$Tags = db('Tags')->find($id);
		if(request()->isPost()){
			$data = [
				'id' => input('id'),
				'title' => input('title'),
				'url' => input('url'),
				'desc'=> input('desc'),
			];
			//对edit进行场景的验证。此刻的验证中可不需要验证密码。
			$validate = \think\Loader::validate('Tags');
			if(!$validate->scene('edit')->check($data)){
				$this->error($validate->getError());
				die;
			}
			//对数据进行更新,成功则显示数据。
			$save = db('Tags')->update($data);
			if($save !== false){
				$this->success('修改Tags标签成功！', 'lst');
			}else{
				$this->error('修改Tags标签失败！');
			}
			return;
		}
		$this->assign('Tags', $Tags);
		return $this->fetch();
	}

	//删除操作
	public function del(){
		$id = input('id');
		//使用助手删除函数，上面的统一，没加入类元素
		if(db('Tags')->delete(input('id'))){
			$this->success('删除Tags标签成功！', 'lst');
		}else{
			$this->error('删除Tags标签失败！');
		}
	}
}