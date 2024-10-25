<?php
namespace app\api\model;
use think\Model;
use think\Db;
class Product extends Model
{
    public function get_add($data)
    {
		$path=Db::table('goods_type')->field('path')->find($data['pid']);
		$data['path']=$path['path'];
		$data['level']=substr_count($path['path'],',')+1;
		$re=Db::table('goods_type')->insertGetId($data);
		$path['path']=$data['path'].','.$re;
		$re=Db::table('goods_type')->where('id',$re)->update($path);
        return $re;
    }
	public function product_add_goods($data){
		if(empty($data)||!is_array($data)){
			return false;
		}
		$data['goodsname']=$_POST['goodsname'];
		$tid=explode(",",$_POST['tid']);
		// var_dump($tid);
		// var_dump($tid[1]);
		$data['tid']=$tid[0];
		$data['tpid']=$tid[1];
		$data['unit']=$_POST['unit'];
		$data['number']=$_POST['number'];
		$data['attributes']=$_POST['attributes'];
		$data['barcode']=$_POST['barcode'];
		$data['curprice']=$_POST['curprice'];
		$data['oriprice']=$_POST['oriprice'];
		$data['cosprice']=$_POST['cosprice'];
		$data['inventory']=$_POST['inventory'];
		$data['restrict']=$_POST['restrict'];
		$data['already']=$_POST['already'];
		$data['freight']=$_POST['freight'];
		$data['status']=$_POST['status'];
		$data['reorder']=$_POST['reorder'];
		$data['text']=$_POST['text'];
		//$data['imagepath']=$dat['file'];
		$res=Db::table('goods')->insert($data);
		return $res;
	}
	public function product_edit_goods($data){
		if(empty($data)||!is_array($data)){
			return false;
		}
		$data['goodsname']=$_POST['goodsname'];
		$tid=explode(",",$_POST['tid']);
	
		// var_dump($tid);
		// var_dump($tid[1]);
		$data['id']=$_POST['id'];
		$data['tid']=$tid[0];
		$data['tpid']=$tid[1];
		$data['unit']=$_POST['unit'];
		$data['number']=$_POST['number'];
		$data['attributes']=$_POST['attributes'];
		$data['barcode']=$_POST['barcode'];
		$data['curprice']=$_POST['curprice'];
		$data['oriprice']=$_POST['oriprice'];
		$data['cosprice']=$_POST['cosprice'];
		$data['inventory']=$_POST['inventory'];
		$data['restrict']=$_POST['restrict'];
		$data['already']=$_POST['already'];
		$data['freight']=$_POST['freight'];
		$data['status']=$_POST['status'];
		$data['reorder']=$_POST['reorder'];
		$data['text']=$_POST['text'];
		$res=Db::table('goods')->where('id',$data['id'])->update($data);
		return $res;
	}
	public function product_stop($data){
		$res=Db::table('goods')->where('id',$data['id'])->update($data);
		return $res;
	}
	}
?>