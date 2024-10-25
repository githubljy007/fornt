<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;
use app\api\model\Product as ProductModels;
use app\api\model\ProductModel;
use app\api\model\CategryModel;
use think\File;
class Product extends Base
{	
	
	
	//返回父级分类数据列表
	public function product_category_add(Request $request)
	{
		$db=new CategryModel();
		$type=$request->param('type');
		//查询'id' => int 85 | 'name' => string '汽车' (length=6) | 'pid' => int 0 | 'path' => string '0,85' (length=4) | 'level' => int 1 | 'paths' => string '0,85,85' 
		// $data=$db->field(['*','concat(path,",",id)'=>'paths'])
		// ->order('paths')
		// ->where('level','<=',$type)
		// ->where('pid',0)
		// ->select();
		$info=$db->where('pid',0)->select();
		foreach($info as $k=>$v){
			$res=$db->where('level','<=',$type)->where('pid',$v['id'])->select();
			// dump($res);
			$info[$k]['children'] = $res;
			
		}return json(['code'=>1,'data'=>$info]);
	}
	//获取分类数据
	public function product_category_ajax(Request $request){
		$db=new CategryModel();
		$key=$request->param('key');
		$page=$request->param('page');
		$limit=$request->param('limit');
		$total=$db->count('id');
		if(isset($key) && !empty($key)){
			$db=$db->where('pid','like','%'.$key.'%');
		 }
		$info=$db->page($page)->limit($limit)->select();
		
		
		$info=$db->select();
		$arr = array();
		$data = $this->recur($arr, $info);
		// return $data;
		return json(['code'=>1,'data'=>$data,'msg'=>'获取分类成功']);
	}
	
	public function recur($arrs, $info, $parent_id=0)
	{
		foreach($info as $k=>$v){
			if($v['pid'] == $parent_id)
			{
				$arr = array('id' => $v['id'], 'name' => $v['name'], 
				'pid' => $v['pid'],'cat_deleted' => $v['cat_deleted'], 
				'level' => $v['level'],'children' => array());
				$arr['children'] = $this->recur($arr['children'], $info, $v['id']);
				array_push($arrs, $arr);
			}
		}
		return $arrs;
	}
	//编辑分类
	public function categry(Request $request){
		$data=$request->param();
		$db=new CategryModel();
		if(isset($data['id']) && !empty($data['id'])){
			$res=$db->save($data,['id'=>$data['id']]);
			return json(['code'=>1,'data'=>$data,'msg'=>'编辑分类成功']);
		}else{
			if($data){
				$res=$db->save($data);
			}else{
				return json(['code'=>0,'msg'=>'更新失败']);
			}
		}
	}
	//删除分类信息
	public function product_category_del(Request $request){
		$id=$request->param('id');
		$data=Db::name('goods_type')->where('pid',$id)->find();
		if($data){
			return json(['code'=>0,'msg'=>'分类下面还有子分类，不允许删除']);
		}else{
			$re=Db::table('goods_type')->where('id',$id)->delete();
			if($re){
				return json(['code'=>1,'data'=>$data,'msg'=>'删除分类成功']);
			}
		}       
	}
	//产品分类添加
	public function goods_type_add(Request $request){
		$db=new CategryModel();
		$name=$request->param('name');
		$id=$request->param('id');
		$pid=$request->param('pid');
		$level=$request->param('level');
		if($name != "" && !empty($id)){
			$data['name']=$name;
			$path=Db::table('goods_type')->field('path')->find($id);
			$data['path']=$path['path'];
			$data['pid']=$id;
			$data['level']=$level;
			$re=Db::table('goods_type')->insertGetId($data);
			$path['path']=$data['path'].','.$re;
			$re=Db::table('goods_type')->where('pid',$id)->update($path);
			if($re){
				return json(['code'=>1,'data'=>$data,'msg'=>'添加分类成功']);
			}else{
				return json(['code'=>0,'data'=>$data,'msg'=>'添加分类失败']);
			}
		}else if($name != " " && $id == 0){
			$data['path']=$id;
			$data['name']=$name;
			$data['pid']=$id;
			$data['level']=$level;
			$re=Db::table('goods_type')->insertGetId($data);
			$path['path']=$data['path'].','.$re;
			$data=Db::table('goods_type')->where('id',$re)->update($path);
			if($re){
				return json(['code'=>1,'data'=>$data,'msg'=>'添加分类成功']);
			}else{
				return json(['code'=>0,'data'=>$data,'msg'=>'添加分类失败']);
			}
		}else{
			return json(['code'=>0,'data'=>$data,'msg'=>'添加分类失败']);
		}
	}
	//商品管理列表
	public function product_list(Request $request){
		 $key=$request->param('key');
		 $page=$request->param('page');
		 $limit=$request->param('limit');
		 $db=new ProductModel();
		 if(isset($key) && !empty($key)){
			 $db=$db->where('goodsname','like','%'.$key.'%');
		 }
		 $info=$db->page($page)->limit($limit)->select();
		 $total=$db->count('id');
		return json(['code'=>0,'data'=>$info,'total'=>$total]);
		}
	//产品添加页面分类级别显示
	public function product_add(Request $request){
		//查询'id' => int 85 | 'name' => string '汽车' (length=6) | 'pid' => int 0 | 'path' => string '0,85' (length=4) | 'level' => int 1 | 'paths' => string '0,85,85'
		//查询所有，并且组合path和id以逗号分开，最后增加多一个字段paths为字段输出
		$data=Db::name('goods_type')->field(['*','concat(path,",",id)'=>'paths'])->order('paths')->select();
		 //var_dump($data);
		 // $info=$db->where('pid',0)->select();
		foreach($data as $k=>$v){
			//制作等级分隔:|--
			 $data[$k]['name']=str_repeat('|--',$v['level']).$v['name'];
		}
		foreach($data as $k=>$v){
			$res=Db::name('goods_type')->where('pid',$v['id'])->select();
			// dump($res);
			$info[$k]['children'] = $res;
			}
		$this->assign('data',$data);
		return json(['code'=>0,'data'=>$info]);
		// return $this->fetch();
	}
	//添加产品/修改产品
	public function add_goods(Request $request){
		$data=$request->param();
		$data['text']=$request->param('text');
		$data['goodsname']=$request->param('goodsname');
		$data['num']=$request->param('num');
		$data['create_time']=time();
		$db=new ProductModel();
		$product=$db->where('goodsname',$data['goodsname'])->find();
		// return json($product);
		strip_tags($data['text']);
		if(!empty($product)){
			$row=$db->where('goodsname',$data['goodsname'])
			->update(['num'=>$product['num']+$data['num'],
			'nnum'=>$product['nnum']+$data['num']]);
			return json(['code'=>1,'msg'=>'更新成功']);
			}
		else{
			if($data){
				$res=$db->save($data);
				return json(['code'=>1,'msg'=>'更新成功1111']);
			}else{
				return json(['code'=>0,'msg'=>'更新失败']);
			}
		}
	}
	
	//修改
	public function edit(Request $request){
		$data=$request->param();
		$db=new ProductModel();
		if(isset($data['id']) && !empty($data['id'])){
			strip_tags($data['text']);
			$res=$db->save($data,['id'=>$data['id']]);
		}
		if($res){
			return json(['code'=>1,'msg'=>'更新成功']);
		}else{
			return json(['code'=>0,'msg'=>'更新失败']);
		}
	}
		public function product_stop(Request $request){
			$id=$request->param('id');
			$status=$request->param('status');
			$model=new ProductModels();
			$res=$model->product_stop($data);
			if($status == '1'){
				$res=$db->save($data,['status','0']);
				return json(['code'=>1,'msg'=>'下架成功']);
			}else{
				$res=$db->save($data,['status','0']);
				return json(['code'=>0,'msg'=>'上架成功']);
			}
		}
		public function product_delete(Request $request)
		{
			$id=$request->param('id');
			$db=new ProductModel();
			if($id){$res=$db->where('id',$id)->delete();}
			if($res){
				return json(['code'=>1,'msg'=>'删除成功']);
			}else{
				return json(['code'=>0,'msg'=>'删除失败']);
			}
			}
	}
