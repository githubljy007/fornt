<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use app\api\model\ArticleModel;

class Article extends Base
{
	//显示资源列表
 public function index(){
	 $db= new ArticleModel();
	 $info=$db->select();
	 return json(['code'=>1,'data'=>$info]);
	 
 }
 //显示创建资源列表单页
	public function create(){
		 
	}
	public function delete(Request $request){
		 $id=$request->param('id');
		 $db = new ArticleModel();
		 $res=$db->where('id',$id)->delete();
		 if($res){
		return json(['code'=>1,'data'=>'删除成功']);
		 }else{
		 return json(['code'=>1,'data'=>'删除失败']);
		}
	}
}