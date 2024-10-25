<?php
namespace app\ncpAPI\controller;
use think\Controller;
use app\ncpAPI\model\GoodscatModel;
use think\Db;
use think\Request;
class Goodscat extends Cross{
	
	public  function index(Request $request){
		$good_id=$request->param('good_id');
		$db=new AdminModel();
		$info=$db->where('username','like','%'.$key.'%')->select();
		if($info){
			return json(['code'=>1,'data'=>$info,'msg'=>'获取数据成功']);
		}else{
			return json(['code'=>1,'data'=>$info,'msg'=>'获取数据失败']);
		}
	}
	public  function add(Request $request){
		$data=$request->param();
		$db=new GoodscatModel();
		if(isset($data['id']) && !empty($data['id']))
		{
			$res=$db->save($data,['id'=>$data['id']]);
		}else{
			if($data){
				$res=$db->save($data);
			}else{
				return json(['code'=>0,'msg'=>'更新失败']);
			}
		}
		if($res){
			return json(['code'=>1,'msg'=>'更新成功']);
		}else{
			return json(['code'=>0,'msg'=>'更新失败']);
		}
	}
}