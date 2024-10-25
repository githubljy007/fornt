<?php
namespace app\ncpAPI\controller;
use think\Request;
use think\Response;
use think\Controller;

class Cross extends Controller
{
	
	protected function initialize(){
		parent::initialize();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, DELETE'); //支持的http 动作
		header("Access-Control-Allow-Headers:x-requested-with, Referer,content-type,token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

	        if(request()->isOptions()) {
	          exit();
			   }
}
}