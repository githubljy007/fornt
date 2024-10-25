<?php
namespace app\api\controller;
use think\Controller;
use app\api\model\OrderModel;
use app\api\model\ProductModel;
use app\api\model\CategryModel;
use think\Db;
use think\Request;

class Order extends Base		
 {
	//查询订单列表
	public function index(Request $request)
	{
		$key=$request->param('key');
		$page=$request->param('page');
		$limit=$request->param('limit');
		$db=new OrderModel();
		if(isset($key) && !empty($key)){
			$db=$db->where('user_id','like','%'.$key.'%');
		 }
		 $info=$db->page($page)->limit($limit)->select();
		 $total=$db->count('id');
		return json(['code'=>1,'data'=>$info,'total'=>$total]);
	}
	// 添加与修改
	public function save(Request $request){
		$data=$request->param();
		$db = new OrderModel();
		var_dump($data);
		if(isset($data['id']) && !empty($data['id'])){
			$res=$db->where('id',$data['id'])->update($data);
		}
		if($res){
			return json(['code'=>1,'msg'=>'更新成功']);
		}else{
			return json(['code'=>0,'msg'=>'更新失败']);
		}
	}
	public function ropter(){
		$db1=new ProductModel();
		$id=$db1->field('tid')->select();
		$info1=$db1->field('goodsname,num')->select();
		$db=new CategryModel();
		return $id;
		foreach($id as $k=>$v){
			$info=$db->field('name,id')->where('id',$v)->select();
		}
		return $info;
		return json(['code'=>1,'data'=>$info,'datas'=>$info1]);
		}
}