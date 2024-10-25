<?php
namespace app\ncpAPI\controller;
use think\Controller;
use app\ncpAPI\model\OrderModel;
use app\ncpAPI\model\GoodsModel;
use app\ncpAPI\model\CategryModel;
use think\Db;
use think\Request;

class Order extends Cross		
 {
	 public function index(Request $request)
	 {
	 	$key=$request->param('id');
	 	$db=new OrderModel();
	 	 $info=$db->where('user_id',$key)->select();
	 	return json(['code'=>1,'data'=>$info]);
	 }
	//查询订单列表
	public function index1(Request $request)
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
		dump($data);
	    $data['order_number'] ='NCP'.mt_rand().time();
		$db = new OrderModel();
		if($data){
				$res=$db->save($data);
			}else{
				return json(['code'=>0,'msg'=>'更新失败']);
			}
		if($res){
			return json(['code'=>1,'msg'=>'更新成功']);
		}else{
			return json(['code'=>0,'msg'=>'更新失败']);
		}
	}
	//多个添加
	public function allsave(Request $request){
		$data=$request->param();
		$db = new OrderModel();
		$db = new GoodsModel();
		$data['order_number'] ='NCP'.mt_rand().time();
		if($data){
			foreach($data as $ke=>$v){
				$datas=['order_number'=>$data['order_number'],
					'shop_price'=>$v['price'],
					'address'=>$v['address'],
					'num'=>$v['count'],
					'user_id'=>$v['user_id'],
					'imagepath'=>$v['imagepath'],
					'goodsname'=>$v['goodsname'],
					'create_time'=>time()];
			}
			$res=$db->insertAll($datas);
			}else{
				return json(['code'=>0,'msg'=>'更新失败']);
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
	// 删除
	public function del(Request $request)
		{
			$key=$request->param();
			return json($key);
			$db=new OrderModel();
			 $info=$db->where('order_number',$key)->delete();
			 if($info){
				return json(['code'=>1]);
			 }
			
		}
		public function savepost(Request $request){
		$data=$request->param();
		$data_c['order_number'] ='NCP'.mt_rand().time();
		$data_c['create_time'] =time();
		$db=new OrderModel();
		// $db=new GoodsModel();
		$datas=[];
		// return json($data);die;
		foreach($data as $k => $v){
			// echo $v;
			$a=[
				'order_number'=>$data_c['order_number'],
				'create_time'=>$data_c['create_time'],
				'goodsname'=>$v['goodsname'],
				'imagepath'=>$v['imagepath'],
				'shop_price'=>$v['price']*$v['count'],
				'address'=>$v['address'],
				'num'=>$v['count'],
				'user_id'=>$v['user_id'],
			];
			array_push($datas,$a);
		}
		// return json($datas);die;
		$res=$db->insertAll($datas);
		// return json($res);
	}
		public function saa(Request $request)
			{
				$data=$request->param();
				// return json(['code'=>0,'data'=>$data]);
				$data['order_number'] ='NCP'.mt_rand().time();
				$data['create_time'] =time();
				$db=new OrderModel();
				$db=new GoodsModel();
				return json($data);
				if($data){
					$datas=[];
					foreach($data as $k => $v){
						
						$datas=[
							'order_number'=>$data['order_number'],
							'shop_price'=>$v['price']*$v['count'],
							'address'=>$v['address'],
							'num'=>$v['count'],
							'user_id'=>$v['user_id'],
							'imagepath'=>$v['imagepath'],
							'goodsname'=>$v['goodsname'],
							'create_time'=>$data['create_time'],
							];
					}
					$res=$db->insertAll($datas);
					if($res){
						return json(['code'=>0,'data'=>$data]);
					}else{
						return json(['code'=>0,'data'=>'失败']);
					}
			}
		}
			public function num(){
				$db=new OrderModel();
				$info1=$db->field('goodsname,num')->select();
			}
}