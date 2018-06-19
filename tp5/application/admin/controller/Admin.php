<?php
namespace app\admin\controller;
// use think\Controller;
use app\admin\controller\Base;
//引入分页类元素
use app\admin\model\Admin as AdminModel;//使用Admin的类别名这样防止类名重复冲突。
//use think\Db;
/**
* 加载admin视图
*/
class Admin extends Base
{
	public function lst()
	{
		//分页
		//获取数据
		$list = AdminModel::paginate(5);
		//模板分配
		$this->assign('list',$list);

		return $this->fetch();
	}
	public function add(){
		//判断是否接受到数据
		if(request()->isPost()){
			// dump(input('post.'));//post.:打印所以post提交的数据.
			//通过数组来获取要插入的数据,并进行md5加密
			$data = [
				'username' => input('username'),
				'password' => md5(input('password')),
			];
			//后台对数据的验证
			//实例化验证规则
			$validate = \think\Loader::validate('Admin');
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
			// if(Db::name('admin')->insert($data)){
			// 	return $this->success('添加管理员成功~！','lst');//显示成功信息并进行跳转到lst页面
			// }else{
			// 	return $this->error('添加管理员失败~！');
			// }
			// 这种是通过db助手进行添加的，无须引入类元素,这样方便很多                           
			if(db('admin')->insert($data)){
				return $this->success('添加管理员成功~！','lst');//显示成功信息并进行跳转到lst页面
			}else{
				return $this->error('添加管理员失败~！');
			}
			return;
		}

		return $this->fetch();
	}
	//编辑操作
	public function edit(){
		//在浏览器中显示管理员名称。
		$id = input('id');
		$admins = db('admin')->find($id);
		if(request()->isPost()){
			$data = [
				'id' => input('id'),
				'username' => input('username'),
			];
			//当修改密码为空时,保留原密码不变，当不空时，就对输入的数据进行md5加密。
			if(input('password')){
				$data['password'] = md5(input('password'));
			}else{
				$data['password'] = $admins['password'];
			}
			//对edit进行场景的验证。此刻的验证中可不需要验证密码。
			$validate = \think\Loader::validate('Admin');
			if(!$validate->scene('edit')->check($data)){
				$this->error($validate->getError());
				die;
			}
			//对数据进行更新,成功则显示数据。
			$save = db('admin')->update($data);
			if($save !== false){
				$this->success('修改管理员成功！', 'lst');
			}else{
				$this->error('修改管理员失败！');
			}
			return;
		}
		$this->assign('admins', $admins);
		return $this->fetch();
	}

	//删除操作
	public function del(){
		$id = input('id');
		if($id != 1){
			//使用助手删除函数，上面的统一，没加入类元素
			if(db('admin')->delete(input('id'))){
				$this->success('删除管理员成功！', 'lst');
			}else{
				$this->error('删除管理员失败！');
			}
		}else{
			$this->error('初始化管理员不能删除！');
		}
	}

	public function logout(){
		//清楚session即可
		session(null);
		$this->success('退出成功！', 'Login/index');
	}
}