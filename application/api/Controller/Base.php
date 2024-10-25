<?php
namespace app\api\controller;
use think\Controller;
use Firebase\JWT\JWT;

class Base extends Cross
{
   protected function initialize(){
	   parent::initialize();
	   //鉴权
	   //获取token 判断token是否存在 是否能够解码token
	   $header = request()->header();
	   if(!isset($header['token']) || empty($header['token'])){
		   return json(['code'=>0,'msg'=>'token不存在'])->send();
	   }
	   $jwt = new JWT();
	   $info=$jwt::decode($header['token'],'api123456',['HS256']);
	   $this->aid=$info->aid;
   }
	
}