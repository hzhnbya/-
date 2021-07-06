<?php

namespace app\common\model;
use think\Db;
use houdunwang\arr\Arr;
use think\Model;
class Category extends Model
{
   
    // 声明 主键
    protected $pk = 'cate_id';
    // 声明 要操作的数据表
    protected $table = 'blog_cate';

    // 添加
    public function store($data)
    {

        // 1.执行验证 到 validate/category 下验证
        // 2.执行添加
        $result = $this->validate(true)->save($data);
        if(false === $result){
            // 验证失败 将返回给控制器
         return ['valid'=>0,'msg'=>$this->getError()];
        }else{
            // 添加成功
            return ['valid'=>1,'msg'=>'添加成功'];
        }
    }
    // 编辑 将旧数据传到编辑页
    public function getCateData($cate_id)
    {
        // 1.首先找到$cate_id的子集
      $cate_ids = $this->getSon(db('cate')->select(),$cate_id);
        // halt(db('cate')->select());
        // halt($cate_ids);
        // 2.将自己追加进去
        $cate_ids[] = $cate_id;
         // dump($cate_ids); //要排除的数据
        // 3.找到除了他们自己之外的数据  树状结构
        $field= db('cate')->whereNotIn('cate_id',$cate_ids)->select();
        return Arr::tree($field,'cate_name','cate_id','cate_pid');
        // halt($field);
    }
    public function getSon($data,$cate_id)
    {
        static $temp=[];
        // 遍历数据
        foreach($data as $k=>$v)
        {
            if($cate_id==$v['cate_pid'])
            {
                $temp[] = $v['cate_id'];
                $this->getSon($data,$v['cate_id']);
            }
        }
        return $temp;
    }
        // 修改
    public function edit($data)
    {
                                            //主键
      $result = $this->validate(true)->save($data,[$this->pk=>$data['cate_id']]);
        if($result)
        {
            // 执行成功
            return ['valid'=>1, 'msg'=>'编辑成功'];
        }else{
            return ['valid'=>0, 'msg'=>$this->getError()];
        }
    }
    // 获取分类数据 【树状结构】
    // 获得树状结构  hd手册
    // Arr::tree($data, $title, $fieldPri = 'cid', $fieldPid = 'pid');
    // 参数                   说明
    // $data                 	数组
    // $title                	字段名称
    // $fieldPri             	主键 id
    // $fieldPid             	父 id
    public function getAll()
    {
       return Arr::tree(db('cate')->order('cate_sort desc,cate_id')->select(),'cate_name',$fieldPri ='cate_id',$fieldPid ='cate_pid');
    }
   
    // 删除
    public function del($cate_id)
    {
        // 删除了一个父级栏目以后 子集往上提一级
        // 1:先找到当前删除数据的pid
        $cate_pid = $this->where('cate_id',$cate_id)->value('cate_pid');
        // halt($cate_pid);
        // 将当前要删除的$cate_id的子集数据的pid修改成$cate_pid
         $this->where('cate_pid',$cate_id)->update(['cate_pid'=>$cate_pid]);
        // 执行删除
       if( Category::destroy($cate_id))
    //    Category::destroy($cate);
    // (db('cate')->where('cate_id',$cate_id)->delete())
       {
        return['valid'=>'1','msg'=>'删除成功'];
       }
       else{
        return['valid'=>'0','msg'=>'删除失败'];
       }
       
        }
}

