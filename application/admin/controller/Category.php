<?php

namespace app\admin\controller;
use think\Controller;
// 栏目列表
class Category extends Controller
{
    // 实例化
    protected $db;
    protected function _initialize()
    {
        parent::_initialize(); //
        // 将实例化的对象new\app\common\model\Category() 存储到db的属性当中
        $this->db= new \app\common\model\Category();
    }
    //首页
    public function index()
    {
        // 获取栏目的数据 ：手册db
        // $field = db('cate')->select();
        $field = $this->db->getAll();

        // halt($field);
        // 
        $this->assign('field',$field);
        return $this->fetch();
    }
    // 添加
    public function store()
    {
        // 判断是否为post请求
        if(request()->isPost())
        {
            // 是 post请求则交给 common/category模型进行处理
            // halt(input('post.')); //打印post数据
            // 调用模型中的store方法,并将post数据传过去
            $res = $this->db->store(input('post.'));
            if($res['valid'])
            {
                // 操作成功,给出成功的提示
                $this->success($res['msg']);
            }else{
                // 操作失败，给出提示
                $this->error($res['msg']);
            }
        }
        return $this->fetch();
    }
    // 添加子级
    public function addSon()
    {
        $cate_id=input('param.cate_id');
        // 获取父级数据
        $data = $this->db->where('cate_id',$cate_id)->find();
        // halt($date);
        // 将数据分配到页面上
        $this->assign('data',$data);
        // 
        if(request()->isPost())
        {
            $res = $this->db->store(input('post.'));
            if($res['valid'])
            {
                // 操作成功,给出成功的提示
                $this->success($res['msg']);
            }else{
                // 操作失败，给出提示
                $this->error($res['msg']);
            }
        }
        return $this->fetch();
    }
    // 编辑
    public function edit()
    {
         // 修改确认
         if(request()->isPost())
         {
             // 将post数据传给模型处理
            //  halt($_POST);
             $res = $this->db->edit(input('post.'));
             if($res['valid'])
             {
                 //执行成功
                 $this->success($res['msg'],'index');exit;
             }
             else{
                 // 失败
                 $this->error($res['msg']);exit;
             }
         }
        // 接收 cate_id
        $cate_id = input(('param.cate_id'));
        // halt($cate_id);
        // 获取旧数据
        $oldData=$this->db->find($cate_id);
        // halt($oldData);
        // 将数据传到编辑页面上
        $this->assign('oldData',$oldData);
        // 处理所属分类不能包含自己和自己的子集数据 到请求模型中处理
        $cateData =$this->db->getCateData($cate_id); //cate_id就是为自己
        // halt($cateData);
        // 将数据分配到页面上
        $this->assign('cateData',$cateData);
        return $this->fetch();
    }
    // 删除
    public function del()
    {
        // 接收cate_id
        // $cate_id = input('param.cate_id');
        // halt(input('param.cate_id'));
        // 将cate_id传到模型中去处理删除
        $res = $this->db->del(input('param.cate_id'));
        // 接收
        if($res){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error(($res['msg']));exit;
        }

    }
}
