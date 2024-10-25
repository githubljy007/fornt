<?php
namespace app\ncpAPI\controller;
use think\Controller;
use app\ncpAPI\model\AdressModel;
use think\Db;
use think\Request;
class Adress extends Cross{
	
	public function getAdress(Request $request){
		$username = $request->param('username');
		$admin = new AdressModel();
		$info=$admin->where('user_id',$username)->find();
		$address=$info['address1'].$info['address2'];
		$name=$info['user_id'];
		$tel=$info['tel'];
		$id=$info['id'];
		$isDefault=true;
		$data[]=array("id"=>$id,"name"=>$name,"tel"=>$tel,"address"=>$address,"isDefault"=>$isDefault);
		if(!$info){
		return json(['code'=>0,'msg'=>'账号不存在']);
		}
		return json(['code'=>1,'msg'=>'获取地址成功','list'=>$data]);
	}
	
	public function detail(Request $request){
		$username = $request->param('id');
		$admin = new AdressModel();
		$info=$admin->where('id',$username)->find();
		$address=$info['address1'].$info['address2'];
		$name=$info['user_id'];
		$tel=$info['tel'];
		$id=$info['id'];
		$isDefault=true;
		$data[]=array("id"=>$id,"name"=>$name,"tel"=>$tel,"address"=>$address,"isDefault"=>$isDefault);
		if(!$info){
		return json(['code'=>0,'msg'=>'账号不存在']);
		}
		return json(['code'=>1,'msg'=>'获取地址成功','list'=>$data]);
	}
	
	public function add(Request $request){
		$data=$request->param();
		$db = new AdressModel();
		if(isset($data['id']) && !empty($data['id'])){
			$data['update_time']=time();
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
	
	public function del(Request $request){
		$username = $request->param('id');
		$admin = new AdressModel();
		$info=$admin->where('id',$username)->del();
	}

}