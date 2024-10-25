<?php
namespace app\api\controller;
use think\Controller;
use app\api\model\AdminModel;
use think\Db;
use think\Request;
use app\api\model\ProductModel;
use app\api\model\CategryModel;
class Sale extends Base		
 {

	public function getSale(Request $request)
	{
		
		$db=new CategryModel();
		$cate=$db->field('name,id')->where('level',2)->select();
		$db1=new ProductModel();
		foreach($cate as $k=>$v){
			$shop=$db1->field('num,nnum,tid')->where('tid',$v['id'])->select();
			$cate[$k]['num']=0;
			$cate[$k]['nnum']=0;
			foreach($shop as $a=>$b){
				$cate[$k]['num']+=$b['num'];
				$cate[$k]['nnum']+=$b['nnum'];
			}
		}
		return json(['code'=>0,'data'=>$cate,]);
		
	}
	}