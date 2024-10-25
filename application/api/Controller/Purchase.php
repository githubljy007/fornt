<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use app\api\model\ProductModel;
use app\api\model\CategryModel;

class Purchase extends Base
{
	public function listApi(Request $request)
	       {
			   
			   
			   $data = $request -> param();
			   // return json($data);
			   $db=new ProductModel();
			   $typedb = new CategryModel();
			   //时间搜索空都为空搜索全部
			     if(empty($data['create_time']) && empty($data['end_time'])){
			      $dat = $db->select();
			     }
			     //有开始，没结束 
			       elseif(!empty($data['create_time']) && empty($data['end_time'])){
			        $dat= $db->whereTime('create_time', '>=', $data['create_time'])->select();
			       }
			     //没开始，有结束 
			     elseif(empty($data['create_time']) && !empty($data['end_time'])){
			      $end_time = $data['end_time'];
			      $data['end_time'] = date('Y-m-d', strtotime("$end_time + 1 day"));
			      $dat= $db->whereTime('create_time', '<=', $data['end_time'])->select();
			     }
			     // 获取某天的时间
			     elseif($data['create_time'] == $data['end_time']){
			      $dat=$db->whereBetweenTime('create_time',$data['create_time'])->select();
			     }
			     //查询某段时间之前的时间
			     elseif(!empty($data['create_time']) && !empty($data['end_time'])){
			      $end_time = $data['end_time'];
			      $data['end_time'] = date('Y-m-d', strtotime("$end_time + 1 day"));
			      $dat=$db->whereTime('create_time', 'between', [$data['create_time'],$data['end_time']])->select();
			     }
			     //前后的时间不对
			     elseif(strtotime($data['create_time']) > strtotime($data['end_time'])){
			      return json(['code'=>0,'data'=>'1111111111']);
			     }
			     
			     elseif(!empty($data['create_time']) && !empty($data['end_time'])){
			   	$end_time = $data['end_time'];
			   	$data['end_time'] = date('Y-m-d', strtotime("$end_time + 1 day"));
			   	$dat=$db->whereTime('create_time', 'between', [$data['create_time'],$data['end_time']]);
			   }
			    $goods = [];
			      foreach ($dat as $a => $b){
			       $b['create_time'] = $b['create_time'];
			   	   $b['create_time']= date('Y-m-d H:i:s',$b['create_time']);
			   	   array_push($goods,$b);
			      }
			      return json(['data'=>$goods]);
			   
			   
			  
	}
 
}