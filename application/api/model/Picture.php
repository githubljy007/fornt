<?php
namespace app\api\model;
use think\Model;
use think\Db;

class Picture extends Model	//管理员的登录
{	
	public function getPicture($data){
		if(empty($data)||!is_array($data)){
			return false;
		}
		$data['imgname']=$_POST['imgname'];
		$data['status']=$_POST['status'];
		// $data['upload']=$_POST['upload'];
		$res=Db::table('picture')->insert($data);
		return $res;
	}
	public function Picture_edit($editdata){
		if(empty($editdata)||!is_array($editdata)){
				return false;
			}
			$editdata['imgname']=$_POST['imgname'];
			$editdata['status']=$_POST['status'];
			// $data['upload']=$_POST['upload'];
			$res=Db::table('picture')->where('id',$editdata['id'])->update($editdata);
			return $res;
		}
	}
}
?>