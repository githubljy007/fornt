<?php
namespace app\api\model;
use think\Model;
use think\Db;
class Admin extends Model	
{	
	
	//查询管理员列表
	public function getAdmin()
	{
		$data=Db::name('admin')->select();
		return $data;
	}
	
	//管理员添加
		public function addAdmin($data)
	{
		if(empty($data)||!is_array($data)){
			return false;
		}
		$addData=array();
		$addData['nickname'] = $data['nickname'];
		$addData['username']= $data['username'];
		$addData['password']=md5($data['password']);
		$addData['phone']= $data['phone'];
		$addData['email']=$data['email'];
			$flag=Db::name('admin')->data($addData)->insert();
			if($flag==true){
				return true;
			}else{
				return "添加失败!";
		}
		}
	
	//管理员更新
	public function editAdmin($data)
	{
		$editData=array();
		$editData['id'] = $data['id'];
		$editData['nickname'] = $data['nickname'];
		$editData['username']= $data['username'];
		$editData['password']=md5($data['password']);
		$editData['phone']= $data['phone'];
		$editData['email']=$data['email'];
		$editData['status']=$data['status'];
		$editData['power']=$data['power'];
		$flag=Db::name('admin')->where('id',$editData['id'])->update($editData);
		if($flag==true){
			return true;
		}else{
			return "修改失败！";
		}
	}
	
	//删除管理员
	public function delAdmin($id)
	{
		$flag = Db::name('admin')->where('id',$id)->delete();
		if($flag==true){
			return true;
		}else{
			return "删除失败！";
		}
	}
}	
?>