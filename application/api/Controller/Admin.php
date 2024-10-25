<?php
namespace app\api\controller;
use think\Controller;
use app\api\model\AdminModel;
use think\Db;
use think\Request;

class Admin extends Base		
 {
	//查询管理员列表
	public function index(Request $request)
	{
		$key=$request->param('key');
		$page=$request->param('page');
		$limit=$request->param('limit');
		$db=new AdminModel();
		if(isset($key) && !empty($key)){
			$db=$db->where('username','like','%'.$key.'%');
		 }
		 $info=$db->page($page)->limit($limit)->select();
		 $total=$db->count('id');
		return json(['code'=>0,'data'=>$info,'total'=>$total]);
	}
	//管理员添加/管理员更新
	public function save(Request $request){
		$data=$request->param();
		$db = new AdminModel();
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

	//删除管理员或管理员
	public function del(Request $request)
	{
		$id=$request->param('id');
		$db=new AdminModel();
		if($id){$res=$db->where('id',$id)->delete();}
		if($res){
			return json(['code'=>1,'msg'=>'删除成功']);
		}else{
			return json(['code'=>0,'msg'=>'删除失败']);
		}
		}
		
	}
?>