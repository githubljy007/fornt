<?php
namespace app\ncpAPI\controller;
use think\Controller;
use think\Db;
use think\Request;
class Upload extends Cross  
 {
	  public function uploadApi(){
	        // 获取表单上传文件 例如上传了001.jpg
	        $file = request()->file('file');
	        // 移动到框架应用根目录/uploads/ 目录下
	     if(!$file){
	     return json(['code'=>1,'msg'=>'操作失败']);
	      }
	        $info=$file->move('../public/uploads');
	     if(!$info){
	        return json(['code'=>1,'data'=>$data,'msg'=>'操作失败']);
	         }
	        $name=$info->getSaveName();
	     //return $name;
	     return json(['code'=>200,'data'=>'http://127.0.0.1/thinkphp_5.1.0/public/uploads/'.$name]);
	    }
		
 }