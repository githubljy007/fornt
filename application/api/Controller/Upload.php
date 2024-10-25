<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;
class Upload extends Controller  
 {
  public function uploadApiall(){
	// 获取表单上传文件
	    $files = request()->file('image');
	    foreach($files as $file){
	        // 移动到框架应用根目录/uploads/ 目录下
	        $info = $file->move( '../public/uploads');
	        if($info){
				$pics['image']=array('http://127.0.0.1/thinkphp_5.1.0/public/uploads/'.date('Ymd').'/'
				.$info->getFilename());
				// 
				// echo $info->getFilename();
				// echo json(['data'=>$pics['image']]);
				$data=print_r(str_replace("\/","/",$pics['image']));
				return json(['code'=>200,'data'=>$data]);
	        }else{
	            // 上传失败获取错误信息
	            echo $file->getError();
	        }    
			
	    }
	  }
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
	  // public function uploadApi(){
	  //       // 获取表单上传文件 例如上传了001.jpg
	  //       $file = request()->file('file');
	  //       // 移动到框架应用根目录/uploads/ 目录下
	  //    if(!$file){
	  //    return json(['code'=>1,'msg'=>'操作失败']);
	  //     }
	  //       $info=$file->move('../public/uploads');
	  //    if(!$info){
	  //       return json(['code'=>1,'msg'=>'操作成功']);
	  //        }
	  //       $name=$info->getSaveName();
	  //    //return $name;
	  //    return json(['code'=>200,'data'=>'http://127.0.0.1/thinkphp_5.1.0/public/uploads/'.$name]);
	  //   }
		public function upload()
		{
		    $files = request()->file('file');
		    foreach($files as $file){
		        $pathImg="";
		        $pathurl = "../public/uploads".date('Y-m-d',time())."/";
		        $info = $file->move($pathurl);
		        if ($info) {
		            $pathImg = $pathurl . $info->getFilename();
		        } else {
		            //错误提示用户
		            return $this->error($file->getError());
		        }
		        $pic[]['image'] = $pathImg;
		    }
		    return json($pic);
		}
		
 }