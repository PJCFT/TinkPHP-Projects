<?php
namespace app\index\controller;
use app\index\controller\Base;
class Article extends Base
{
    public function index()
    {
    	$arid = input('arid');
    	//查询当前文章
    	$articles = db('article')->find($arid);
    	//设置自增热度，默认为自增加一
    	db('article')->where('id', '=', $arid)->setInc('click');
    	//查询栏目名称
    	$cates = db('cate')->find($articles['cateid']);
    	//查找推荐
    	$recres = db('article')->where(array('cateid'=>$cates['id'],'state'=>1))->limit(8)->select();
    	
    	$ralateres = $this->ralat($articles['keywords'],$articles['id']);

    	//分配到模板中
    	$this->assign(array(
    		'articles' => $articles,
    		'cates' => $cates,
    		'recres'=>$recres,
    		'ralateres'=>$ralateres
    		));
        return $this->fetch('article');
    }
    //相关阅读
    public function ralat($keywords,$id){
    	$arr = explode(',', $keywords);
    	static $ralateres = array();
    	foreach ($arr as $k => $v) {
  			//关键词进行匹配
    		$map['keywords'] = ['like', '%'.$v.'%'];
    		$map['id'] = ['neq', $id];
    		$ratres = db('article')->where($map)->order('id desc')->limit(8)->select();
    		//合并数组
    		$ralateres = array_merge($ralateres, $ratres);
    	}
    	//去重复。
    	if($ralateres){
    		$ralateres = arr_unique($ralateres);
    		return $ralateres;
    	}
    	
    }
}
