<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Query extends Controller
{
    protected $user;
    protected $role;
    protected $category;
    protected $article;
    protected $rule;
    protected function _initialize(){
        $this->user = model('user');
        $this->role = model('role');
        $this->category = model('category');
        $this->article = model('article');
        $this->rule = model('rule');
    }
    public function userList()
    {
        $input = input('param.');
        $userList = $this->user->getUserList($input);
        $this->assign('userList',$userList);
        return $this->fetch();
    }
    public function ruleList()
    {
        $input = input('param.');
        $ruleList =$this->rule->getRule($input);
        $this->assign('ruleList',$ruleList);
        return $this->fetch();
    }
    public function roleList()
    {
        $input = input('param.');
        $roleList = $this->role->getRole($input);
        $this->assign('roleList',$roleList);
        return $this->fetch();
    }
    public function categoryList()
    {
        $input = input('param.');
        $cateList = $this->category->getCategory($input);
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }
    public function articleList()
    {
        $input = input('param.');
        $user = session('user');
        $select = $this->article;
        if($user['role_id']==2){
            $select->where('user_id',$user['id']);
        }
        $articleList = $select->getArticleList($input);
        $this->assign('articleList',$articleList);
        return $this->fetch();
    }
     public function j_delUser(){
        $input = input('param.');
        $validate = Validate('User');
        if(!$validate->scene('delUser')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->user->where('id',$input['id'])->update(['enabled'=>DISABLED]);
            $code = 200;
            $msg = '删除成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
     }
      public function j_delRole(){
        $input = input('param.');
        $validate = Validate('Role');
        if(!$validate->scene('delRole')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->role->where('id',$input['id'])->update(['enabled'=>DISABLED]);
            $code = 200;
            $msg = '删除成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
     }
     public function j_delCategory(){
        $input = input('param.');
        $validate = Validate('Category');
        if(!$validate->scene('delCategory')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->category->where('id',$input['id'])->update(['enabled'=>DISABLED]);
            $code = 200;
            $msg = '删除成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
     }
     public function j_delArticle(){
        $input = input('param.');
        $validate = Validate('Article');
        if(!$validate->scene('delArticle')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->article->where('id',$input['id'])->update(['enabled'=>DISABLED]);
            $code = 200;
            $msg = '删除成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
     }
     public function detail(){
         $id = input('param.id');
         $articleInfo = $this->article->find($id);
         $cateList = $this->category->getCate();
         $this->assign('cateList',$cateList);
         $this->assign('article',$articleInfo);
         return $this->fetch();
     }
    
}

