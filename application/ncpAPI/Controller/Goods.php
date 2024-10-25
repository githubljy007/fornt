<?php
namespace app\ncpAPI\controller;
use think\Controller;
use app\ncpAPI\model\GoodsModel;
use think\Db;
use think\Request;
class Goods extends Cross{
	
	public  function index(Request $request){
		$key=$request->param('key');
		$db=new GoodsModel();
		if(isset($key) && !empty($key)){
			$db=$db->where('tid','like','%'.$key.'%');
		 }
		 $info=$db->select();
		return json(['code'=>1,'data'=>$info]);
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
	public function update(Request $request){
		$id=$request->param('id');
		$nums=$request->param('nums');
		$db=new GoodsModel();
		if(!empty($id)){
			$sub=$db->where('id',$id)->find();
		}else{
			return json(['code'=>0]);
		}
		dump($sub['num']);
		$num=$sub['num']-$nums;
		dump($num);
		$res=$db->where('id',$id)->update(['num'=>$num]);
		
			return json(['code'=>1]);
		
		
	}
	
}