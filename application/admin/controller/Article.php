<?php

namespace app\admin\controller;
use app\common\model\Category;
use think\Controller;

class Article extends Controller
{
    // 实例化模型
    protected $db;
    public function _initialize ()
    {
        parent::_initialize();
        $this->db = new \app\common\model\Article();
    }
    //加载首页
    public function index()
    {
    // 获取首页数据
    $field = $this->db->getAll(2);
        // 将数据传到首页
        $this->assign('field',$field);
        return $this->fetch();
    }
    // 文章的添加
    public function store()
    {
        if(request()->isPost())
        {
        // 将数据交给模型处理
            $res = $this->db->store(input('post.'));
            if($res['valid'])
            {
                // 验证通过
                $this->success($res['msg'],'index');exit;
            }else{
                // 验证失败
                $this->error($res['msg']);exit;
            }
        }
        // 1.获取分类数据
        $cateData=(new Category())->getAll();
        // 将数据分配到页面上
        $this->assign('cateData',$cateData);
        // 2.获取标签数据
        $tagData=db('tag')->select();
        // halt($tagData);
        $this->assign('tagData',$tagData);
        return $this->fetch();   
    }
    // 编辑
     public function edit()
     {
          // 4.实现编辑功能
        if(request()->isPost())
        {
            $res = $this->db->edit(input('post.'));
            if($res['valid'])
            {
                $this->success($res['msg'],'index');exit;
            }
            else{
                $this->error($res['msg']);exit;
            }
        }

        // 
        $arc_id = input('param.arc_id');
          // 1.获取分类数据
        $cateData=(new Category())->getAll();
        // 将数据分配到页面上
        $this->assign('cateData',$cateData);
        // 2.获取标签数据
        $tagData=db('tag')->select();
        // halt($tagData);
        $this->assign('tagData',$tagData);
        // 3.获取文章旧数据
        $oldData = db('article')->find($arc_id);
        // halt($oldData);
        // 将旧数据分配到编辑页面上
        // dump($oldData); //打印数据 更好观看数据
        $this->assign('oldData',$oldData);
        // 获取当前文章的所有的标签id //colum() 返回某一列的值
        $tag_ids = db('arc_tag')->where('arc_id',$arc_id)->column('tag_id');
        // halt($tag_ids);
        $this->assign('tag_ids',$tag_ids);
        return $this->fetch();
     }
    //  移除到回收站
    public function dleRecycle()
    {
        // 1.接收 arc_id
        $arc_id = input('param.arc_id');
        // halt($arc_id);
        // 2.将该数据删除到回收站
        // 将 is_recycle字段修改为 1 即在回收站
        if($this->db->save(['is_recycle'=>1],['arc_id'=>$arc_id]))
        {
            $this->success('操作成功','index');exit;
        }
        else{
            $this->error('操作失败');exit;
        }

    }
    // 回收站管理
    public function recycle()
    {
        // 获取 is_recycle 为1 的数据
        $field = $this->db->getAll(1);
        $this->assign('field',$field);
        return $this->fetch();
    }

    // 恢复数据
    public function huifu()
    {
         // 1.接收 arc_id
         $arc_id = input('param.arc_id');
         // halt($arc_id);
         // 2.将该数据恢复到文章列表
         // 将 is_recycle字段修改为 2 即在文章表
         if($this->db->save(['is_recycle'=>2],['arc_id'=>$arc_id]))
         {
             $this->success('操作成功','index');exit;
         }
         else{
             $this->error('操作失败');exit;
         }
    }
    // 彻底删除文章
    public function Realdle()
    {
        $arc_id = input('param.arc_id');
        // halt($arc_id);
        $res = $this->db->Realdle($arc_id);
        if($res['valid'])
        {
            $this->success($res['msg'],'index');exit;

        }else{
            $this->error($res['msg']);exit;
        }
    }
}

