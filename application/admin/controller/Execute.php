<?php
namespace app\admin\controller;

use think\Controller;
use app\common\Validate\Role;
use think\Db;

class Execute extends Controller
{
    protected $user;
    protected $role;
    protected $category;
    protected $article;
    protected $rule;
    protected $roleRule;
    protected function _initialize(){
        $this->user = model('user');
        $this->role = model('role');
        $this->category = model('category');
        $this->article = model('article');
        $this->rule = model('rule');
        $this->roleRule = model('role_rule');
    }
    public function addUser()
    {
        $roleList = $this->role->getRoleList();
        $this->assign('roleList',$roleList);
        return $this->fetch();
    }
    public function j_addUser(){
//        $input = array('name'=>'徐俊杰','uname'=>'15010817359','role_id'=>1,'password'=>'123456','password_confirm'=>'123456');
        $input = input('param.');
        $validate = Validate('User');
        if(!$validate->scene('addUser')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        $input['password'] = \pass_hash($input['password']);
        //启动事务
        Db::startTrans();
        try {
            $this->user->allowField(['name','uname','role_id','password'])->data($input)->save();
            $code = 200;
            $msg = '添加成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function editUser()
    {
        $id = input('param.id');
        $user = $this->user->where('id',$id)->find();
        $roleList = $this->role->getRoleList();
        $this->assign('user',$user);
        $this->assign('roleList',$roleList);
        return $this->fetch();
    }
    public function j_editUser(){
//        $input = array('name'=>'徐俊杰','uname'=>'15010817359','role_id'=>1,'password'=>'123456','password_confirm'=>'123456');
        $input = input('param.');
        $validate = Validate('User');
        if(!$validate->scene('editUser')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        $input['password'] = \pass_hash($input['password']);
        //启动事务
        Db::startTrans();
        try {
            $this->user->allowField(['id','name','uname','role_id','password'])->data($input)->isUpdate(true)->save();
            $code = 200;
            $msg = '修改成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function addRole()
    {
        $ruleList = $this->rule->getRuleList();
        $this->assign('ruleList',$ruleList);
        return $this->fetch();
    }
    public function j_addRole(){
//        $input = array('name'=>'管理员');
        $input = input('param.');
        $validate = Validate('Role');
        if(!$validate->scene('addRole')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->role->save(['name'=>$input['name']]);
            $roleId = $this->role->id;
            if(isset($input['rule_id'])){
                foreach($input['rule_id'] as $k=>$v){
                    $roleRuleData[$k] =array('role_id'=>$roleId,'rule_id'=>$v);
                }
                $this->roleRule->saveAll($roleRuleData);
            }
            $code = 200;
            $msg = '添加成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function editRole()
    {
        $id = input('param.id');
        $roleRule = collection($this->role->alias('r')->join('role_rule rr','r.id=rr.role_id','left')->where('r.id',$id)->field('r.id,r.name,rr.rule_id')->select())->toArray();
        $ruleList = $this->rule->getRuleList();
        $this->assign('roleRule',$roleRule);
        $this->assign('ruleList',$ruleList);
        return $this->fetch();
    }
    public function j_editRole(){
//        $input = array('name'=>'管理员');
        $input = input('param.');
        $validate = Validate('Role');
        if(!$validate->scene('editRole')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->role->save(['name'=>$input['name']],['id'=>$input['id']]);
            $this->roleRule->where('role_id',$input['id'])->delete();
            if(isset($input['rule_id'])){
                foreach($input['rule_id'] as $k=>$v){
                    $roleRuleData[$k] =array('role_id'=>$input['id'],'rule_id'=>$v);
                }
                $this->roleRule->saveAll($roleRuleData);
            }
            $code = 200;
            $msg = '修改成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function addRule()
    {
        return $this->fetch();
    }
    public function j_addRule()
    {
        $input = input('param.');
        $validate = Validate('Rule');
        if(!$validate->scene('addRule')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->rule->data($input)->save();
            $code = 200;
            $msg = '添加成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function editRule()
    {
        $id = input('param.id');
        $ruleInfo = $this->rule->find($id);
        $this->assign('rule',$ruleInfo);
        return $this->fetch();
    }
    public function j_editRule()
    {
        $input = input('param.');
        $validate = Validate('Rule');
        if(!$validate->scene('editRule')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->rule->data($input)->isUpdate(true)->save($input);
            $code = 200;
            $msg = '编辑成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function addCategory()
    {
        $cateList = $this->category->getCateList();
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }
    public function j_addCategory(){
//        $input = array('p_id'=>1,'name'=>'php语法','address'=>'123');
        $input = input('param.');
        $validate = Validate('Category');
        if(!$validate->scene('addCategory')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->category->data($input)->save();
            $code = 200;
            $msg = '添加成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function editCategory()
    {
        $id = input('param.id');
        $categoryInfo = $this->category->find($id);
        $cateList = $this->category->getCateList($id);
        $this->assign('category',$categoryInfo);
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }
    public function j_editCategory(){
//        $input = array('p_id'=>1,'name'=>'php语法','address'=>'123');
        $input = input('param.');
        $validate = Validate('Category');
        if(!$validate->scene('editCategory')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->category->data($input)->isUpdate(true)->save();
            $code = 200;
            $msg = '编辑成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function addArticle()
    {
        $cateList = $this->category->getCate();
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }
    public function j_addArticle(){
//        $input = array('cate_id'=>3,'title'=>'变量类型','content'=>'8种');
        $input = input('param.');
        $validate = Validate('Article');
        if(!$validate->scene('addArticle')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        $user = session('user');
        $input['user_id'] = $user['id'];
        //启动事务
        Db::startTrans();
        try {
            $this->article->data($input)->save();
            $code = 200;
            $msg = '添加成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function editArticle()
    {
        $id = input('param.id');
        $articleInfo = $this->article->find($id);
        $cateList = $this->category->getCate();
        $this->assign('article',$articleInfo);
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }
    public function j_editArticle(){
//        $input = array('cate_id'=>3,'title'=>'变量类型','content'=>'8种');
        $input = input('param.');
        $validate = Validate('Article');
        if(!$validate->scene('editArticle')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        //启动事务
        Db::startTrans();
        try {
            $this->article->data($input)->isUpdate(true)->save();
            $code = 200;
            $msg = '编辑成功';
            Db::commit();
        } catch (\Exception $e) {
            $code = 500;
            $msg = $e->getMessage();
            Db::rollback();
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
        
}