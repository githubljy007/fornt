<?php
namespace app\ncpAPI\controller;
use think\Controller;
use app\ncpAPI\model\CateModel;
use app\ncpAPI\model\GoodsModel;
use think\Db;
use think\Request;
class Cate extends Cross{
	
	public  function index(Request $request){
		
		$key=$request->param('key');
		$page=$request->param('page');
		$limit=$request->param('limit');
		$db=new CateModel();
		$total=$db->count('id');
		if(isset($key) && !empty($key)){
			$db=$db->where('pid','like','%'.$key.'%');
		 }
		$info=$db->page($page)->limit($limit)->select();
		
		
		$info=$db->select();
		$arr = array();
		$data = $this->recur($arr, $info);
		// return $data;
		return json(['code'=>1,'data'=>$data,'msg'=>'获取分类成功']);
	}
	public function recur($arrs, $info, $parent_id=0)
	{
		foreach($info as $k=>$v){
			if($v['pid'] == $parent_id)
			{
				$arr = array('id' => $v['id'], 'name' => $v['name'], 
				'pid' => $v['pid'],'cat_deleted' => $v['cat_deleted'], 
				'level' => $v['level'],'children' => array());
				$arr['children'] = $this->recur($arr['children'], $info, $v['id']);
				array_push($arrs, $arr);
			}
		}
		return $arrs;
	}
	
	public  function detail(Request $request){
		$key=$request->param('id');
		$db=new GoodsModel();
		if(isset($key) && !empty($key)){
			$info=$db->where('id','like','%'.$key.'%')->select();
			return json(['code'=>1,'data'=>$info]);
		 }else{
			 return json(['code'=>0,'data'=>'']);
		 }
	}
	public function add(Request $request){
		$key=$request->param('id');
		$db=new GoodsModel();
	}
	
}