<?php
namespace app\ncpAPI\controller;
use think\Controller;
use app\ncpAPI\model\UserModel;
use Firebase\JWT\JWT;
use think\Db;
use think\Request;
class User extends Cross{
	
	public function login(Request $request){
		$username = $request->param('username');
		$password = $request->param('password');
		$admin = new UserModel();
		$info=$admin->where('username',$username)->find();
		if(!$info){
		return json(['code'=>0,'msg'=>'账号不存在']);
		}
		if($info['password']!=$password){
			return json(['code'=>0,'msg'=>'账号或密码错误']);
		}
		$jwt = new JWT();
		$key ='api123456';
		$payload = [
				"iss" => "http://127.0.0.1/thinkphp_5.1.0/public",
			    "aud" => "http://127.0.0.1/thinkphp_5.1.0/public",
			    "iat" => time(),
			    "nbf" => time(),
				'aid' =>$info['id']
		];
		$token = $jwt::encode($payload, $key);
		return json(['code'=>1,'msg'=>'登陆成功','token'=>$token,'username'=>$username,'data'=>$info]);
	}
	
	public function register(Request $request){
		$data=$request->param();
		$db = new UserModel();
		if(isset($data['username']) && !empty($data['uaername'])){
			return json(['code'=>0,'msg'=>'用户已存在']);
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
	
	public function edit(Request $request){
		
	}
	
	public function details(Request $request){
		$key=$request->param('id');
		$db=new AdminModel();
		$db=$db->where('id',$key)->find();
		return json(['code'=>0,'data'=>$db]);
	}

}