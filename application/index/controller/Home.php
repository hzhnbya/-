<?php
namespace app\index\controller;
use app\common\model\Index;
use \app\common\model\Message;
use \app\common\model\UserPl;
class Home extends Common
{
    protected $db;
    public function _initialize()
    {
        parent::_initialize();
    }
    // 实例化
    public function index()
    {
        $headConf = ['title'=>'学码网博客--首页'];
        $this->assign('headConf',$headConf);
        // 获取文章数据
        // 1.关联数据表
        $articleData = db('article')
        ->alias('a')
        ->join('__CATE__ c','a.cate_id=c.cate_id')
        ->where('a.is_recycle',2)
        ->order('sendtime desc')
        ->paginate(2);
        // halt($articleData);
        // 2.关联标签表
        $items = $articleData->items();
        foreach($articleData as $k=>$v)
        {
            $items[$k]['tags']=db('arc_tag')
            ->alias('at')
            ->join('__TAG__ t','at.tag_id=t.tag_id')
            ->where('at.arc_id',$v['arc_id'])
            ->field('t.tag_id,t.tag_name')->select();
        }
        // halt($articleData);
        $this->assign('items',$items);
        $this->assign('articleData',$articleData);
        return $this->fetch();
    }

    // 搜索文章
    public function selectArt()
    {
        $headConf = ['title'=>"学码网博客--搜索结果"];
        $this->assign('headConf',$headConf);
        $keywords=input();
        // halt($keywords['keyWords']);
        $keyword=$keywords['keyWords'];
        session('index.index_keyword',$keyword);
        // dump($_GET);die;
        // 搜索文章
        $articleData = db('article')
        ->alias('a')
        ->join('__CATE__ c','a.cate_id=c.cate_id')
        ->where('a.is_recycle',2)
        ->where('a.arc_title','like',"%$keyword%")
        ->order('sendtime desc')
        ->paginate(2,false,['query'=>request()->param()]);
           
        // halt($articleData);
        // 2.关联标签表
        $items = $articleData->items();
        foreach($articleData as $k=>$v)
        {
            $items[$k]['tags']=db('arc_tag')
            ->alias('at')
            ->join('__TAG__ t','at.tag_id=t.tag_id')
            ->where('at.arc_id',$v['arc_id'])
            ->field('t.tag_id,t.tag_name')->select();
        }
    //    dump($articleData);die;
        $this->assign('items',$items);
        $this->assign('articleData',$articleData);
        
        // $this->assign('kw',$articleData);

        return $this->fetch('index');
    }
    // 修改密码
    public function pass()
    {
        $headConf = ['title'=>'学码网博客--修改密码'];
        $this->assign('headConf',$headConf);
         // 检测是否是post提交
         $user_id = input('param.user_id');
         if(request()->isPost())
         // 是post提交的话 ，将请求转入到模型当中进行处理 ，
         // 调用里面的pass方法 并且同时把post的数据接收过来当做参数传递过去
         {
             $res =(new Index())->pass(input('post.'));
            
             if($res['valid'])
             {
                 $user_name=session('index.index_name');
                 db('pl')->where('user_id',session('index.index_id'))->update(['user_name'=>$user_name]);
                 db('usercomment')->where('user_id',session('index.index_id'))->update(['user_name'=>$user_name]);
                // $res1 = \app\common\model\Message::update('user_name',session('index.index_name'))->where('user_id',session('index.index_id'));
                // $res2 = \app\common\model\UserPl::update('user_name',session('index.index_name'))->where('user_id',session('index.index_id'));
                 // 清除session 中的登录信息
                 session(null);
                 // 执行成功
                 $this->success($res['msg'],'index/home/index');exit;
                 
             }else{
                 // 执行失败
                 $this->error($res['msg']);exit;
             }
         }
        //  $userData = db('user')->where('user_id',$user_id)->find();
        //  $this->assign('userData',$userData);
        return $this->fetch();
    }

    
    

}
