<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use Firebase\JWT\JWT;
use app\api\model\AdminModel;
use think\Db;
class Login extends Cross{
	public function login(Request $request){
		$username = $request->param('username');
		$password = $request->param('password');
		$admin = new AdminModel();
		$info=$admin->where('username',$username)->find();
		if(!$info){
		return json(['code'=>0,'msg'=>'账号不存在']);
		}
		if($info['password']!=$password){
			return json(['code'=>0,'msg'=>'账号或密码错误']);
		}
		//jwt json web token
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
		return json(['code'=>1,'msg'=>'登陆成功','token'=>$token,'username'=>$username]);
	}
	public function add(Request $request){
		$data = $request->param();
		$data['password']=md5($data['password']);
		$admin = new AdminModel();
		$info=$admin->save($data);
	}
}
?>