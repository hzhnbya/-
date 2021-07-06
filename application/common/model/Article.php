<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    // 设置主键
    protected $pk = 'arc_id';
    protected $table = 'blog_article';
    //  自动完成 手册
    protected $auto = ['admin_id'];
    protected $insert= ['sendtime'];
    protected $update=['updatetime'];
    protected function setAdminIdAttr($value)
    {
        // 获取用户登录的id
        return session('admin.admin_id');
    }
    protected function setSendTimeAttr($value)
    {
        // 获取时间戳
        return time();
    }
    protected function setUpdateTimeAttr($value)
    {
        // 
        return time();
    }

    // 添加文章
    public function store($data)
    {
          //halt($data); //如果没选标签则数据中不会有标签
         //   判断是否选择标签
        if(!isset($data['tag']))
    {
        // 未选择
        return ['valid'=>'0','msg'=>'请选择标签'];
    }
       
    
    // 1.验证
        //                              手册 新增 过滤非数据表字段的数据
      $result =  $this->validate(true)->allowField(true)->save($data);
      if($result)
      {
        //   文章标签的添加
        foreach($data['tag'] as $v)
        {
            $arcTagData= [ 
                // 手册 获取自增id
                'arc_id'=>$this->arc_id,
                'tag_id'=>$v
            ];
            // 实例化 ArcTag 模型
            (new ArcTag())->save($arcTagData);
        }
        // 验证通过
        return ['valid'=>1, 'msg'=>'添加成功'];
      }else{
        // 验证失败
        return ['valid'=>0,'msg'=>$this->getError()];
      }
    }


    //   获取文章首页  
    public function getAll($isrecycle)
    {
        // 将文章表和分类表进行关联 手册 join
     return db('article')->alias('a')
       ->join('__CATE__ c','a.cate_id=c.cate_id')->where('a.is_recycle',$isrecycle)
       ->field('a.arc_id,a.arc_title,a.arc_author,a.arc_sort,a.sendtime,c.cate_name')
       ->order('a.arc_sort desc,a.sendtime desc,a.arc_id desc')->paginate(8);
        // halt($data);
    }
  
    // 文章编辑功能
    public function edit($data)
    {
        // halt($data);
        // 1.执行验证  save($data,要验证的数据) allowField 过滤非数据表的字段
        $res = $this->validate(true)->allowField(true)->save($data,[$this->pk=>$data['arc_id']]);
        if($res)
        {
            // 3.执行标签处理（将原有的标签删除，再重新添加）
            // 实例化文章标签中间表arc_tag
            (new ArcTag())->where('arc_id',$data['arc_id'])->delete();
            // 重新执行添加
            foreach($data['tag'] as $v)
        {
            $arcTagData= [ 
                // 手册 获取自增id
                'arc_id'=>$this->arc_id,
                'tag_id'=>$v
            ];
            // 实例化 ArcTag 模型
            (new ArcTag())->save($arcTagData);
        }
            // 2.验证通过
            return ['valid'=>1,'msg'=>'操作成功'];
        }
        else{
            return ['valid'=>0,$this->getError()];
        }
    }

    //  获取回收站的首页数据
    public function recyle()
    {
        // 将文章表和分类表进行关联 手册 join
     return db('article')->alias('a')
       ->join('__CATE__ c','a.cate_id=c.cate_id')->where('a.is_recycle')
       ->field('a.arc_id,a.arc_title,a.arc_author,a.arc_sort,a.sendtime,c.cate_name')
       ->order('a.arc_sort desc,a.sendtime desc,a.arc_id desc')->paginate(3);
        // halt($data);
    }

    //  彻底删除回收站数据
    public function Realdle($arc_id)
    {
        if(Article::destroy($arc_id))
        {
            // 文章标签中间表也要删除 arc_tag
            (new ArcTag())->where('arc_id',$arc_id)->delete();
            // 删除成功
            return ['valid'=>0,'msg'=>'删除成功'];
        }   
        else{
            // 删除失败
            return ['valid'=>1,'msg'=>'删除失败'];

        }
    }

} 