<?php

namespace app\admin\controller;

use think\Controller;
//  标签管理
class Tag extends Controller
{
//   实例化
    protected $db;
    public function _initialize()
    {
        parent::_initialize();
        $this->db= new \app\common\model\Tag();
    }
     // 加载首页
    public function index()
    {
        //  获取首页的数据
        // $list = Db::name('user')->where('status',1)->paginate(10);
       // 查询标签的所有数据 并且每页显示10条数据
        $field= db('tag')->paginate(3);
        $this->assign('field',$field);
        return $this->fetch();
    }
    // 添加标签 和 编辑标签
    public function store()
    {
        if(request()->isPost())
        {
            // halt($_POST);
            $res = $this->db->store(input('post.'));
            if($res['valid'])
            {
                // 返回的valid为1代表 验证成功
                $this->success($res['msg'],'index');exit;
            }else{
                // 返回的valid为0 执行失败
                $this->error($res['msg']);exit;
            }
        }
        // 编辑标签 用是否有tag_id 来判断是编辑请求还是添加请求
        $tag_id = input('param.tag_id');
        // halt($tag_id);
        if($tag_id)
            // 说明是编辑请求
        {
            // 获取旧数据
            $oldData = $this->db->find($tag_id);
            // halt($oldData);
        }
         // 说明是添加
        else{
            $oldData = ['tag_name'=>''];
        }
        // 将旧数据分配到页面上
        $this->assign('oldData', $oldData);
        return $this->fetch();
    }
        //   删除标签
    public function del()
    {
        // 接收post数据
        $tag_id = input('param.tag_id');
        // halt($tag_id);
        if(\app\common\model\Tag::destroy($tag_id))
        {
            // 删除成功
            $this->success('删除成功','index');exit;

        }
        else{
            $this->error('删除失败');exit;
        }
    }
}
