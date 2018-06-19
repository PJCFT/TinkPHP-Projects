<?php
namespace app\Admin\controller;
use app\admin\controller\Base;
//引入分页类元素
use app\Admin\model\Article as ArticleModel;//使用Article的类别名这样防止类名重复冲突。
//use think\Db;
/**
* 加载Article视图
*/
class Article extends Base
{
	
	public function lst()
	{
		//分页
		//获取数据
		$list = ArticleModel::paginate(5);
		//内容输出
		$this->assign('list',$list);

		return $this->fetch();
	}
	public function add(){
		//判断是否接受到数据
		if(request()->isPost()){
			// dump(input('post.'));//post.:打印所以post提交的数据.
			$data = [
				'title' => input('title'),
				'author' => input('author'),
				'desc'=> input('desc'),
				'keywords'=> str_replace('，', ',', input('keywords')),
				'content'=> input('content'),
				'cateid'=> input('cateid'),
				'time'=>time(),
			];
			//当state为on是，它传过来的数据是字符串'on'，所以用这个来进行判断是否推荐
			if(input('state') == 'on'){
				$data['state'] = 1;
			}else{
                $data['state']=0;
            }
			/**
			 * 上传缩略图。
			 */
			//判断图片是否上传
			if($_FILES['pic']['tmp_name']){
				$file = request()->file('pic');
				// 移动到框架应用根目录/public/uploads/ 目录下
    			$info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
    			$data['pic'] = '/uploads/'.$info->getSaveName();
			}
			/**
			 *后台对数据的验证
			 */
			//实例化验证规则
			$validate = \think\Loader::validate('Article');
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
			// if(Db::name('Article')->insert($data)){
			// 	return $this->success('添加文章成功~！','lst');//显示成功信息并进行跳转到lst页面
			// }else{
			// 	return $this->error('添加文章失败~！');
			// }
			// 这种是通过db助手进行添加的，无须引入类元素,这样方便很多 
			$save = db('Article')->insert($data);                          
			if($save !== false){
				return $this->success('添加文章成功~！','lst');//显示成功信息并进行跳转到lst页面
			}else{
				return $this->error('添加文章失败~！');
			}
			return;
		}
		//所属栏目数据抽取并分配到页面中
		$cateres = db('cate')->select();
		$this->assign('cateres', $cateres);
		return $this->fetch();
	}
	//编辑操作
	public function edit(){
		//在浏览器中显示文章名称。
		$id = input('id');
		$Article = db('Article')->find($id);
		if(request()->isPost()){
			$data = [
				'id'=>input('id'),
				'title' => input('title'),
				'author' => input('author'),
				'desc'=> input('desc'),
				'keywords'=> str_replace('，', ',', input('keywords')),
				'content'=> input('content'),
				'cateid'=> input('cateid'),
			];
			if(input('state') == 'on'){
				$data['state'] = 1;
			}else{
                $data['state']=0;
            }
            /**
			 * 上传缩略图。
			 */
			//判断图片是否上传
			if($_FILES['pic']['tmp_name']){
				//@unlink(SETSIT_URL.'public/static'.$Article['pic']);
				$file = request()->file('pic');
				// 移动到框架应用根目录/public/uploads/ 目录下
    			$info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
    			$data['pic'] = '/uploads/'.$info->getSaveName();
			}
			//对edit进行场景的验证。此刻的验证中可不需要验证密码。
			$validate = \think\Loader::validate('Article');
			if(!$validate->scene('edit')->check($data)){
				$this->error($validate->getError());
				die;
			}
			//对数据进行更新,成功则显示数据。
			if(db('Article')->update($data)){
				$this->success('修改文章成功！', 'lst');
			}else{
				$this->error('修改文章失败！');
			}
			return;
		}
		$cateres = db('cate')->select();
		$this->assign('cateres', $cateres);
		$this->assign('Article', $Article);
		return $this->fetch();
	}

	//删除操作
	public function del(){
		$id = input('id');
		//使用助手删除函数，上面的统一，没加入类元素
		if(db('Article')->delete(input('id'))){
			$this->success('删除文章成功！', 'lst');
		}else{
			$this->error('删除文章失败！');
		}
	}
}