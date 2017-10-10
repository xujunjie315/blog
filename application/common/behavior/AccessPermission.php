<?php
namespace app\common\behavior;

use think\Request;
use think\Session;
use think\Controller;

class AccessPermission extends Controller
{
    protected $key = false;
    public function run(&$params)
    {
        $request = Request::instance();
        $module = $request->module();
        $controller = $request->controller();
        $action = $request->action();
        $currentRule = [$module, "$module-$controller", "$module-$controller-$action",];
        //是否在公共路由中
        $isPub = $this->check($currentRule,1);
        $user = Session::has('user')?Session::get('user'):false;
        $isPri = $this->check($currentRule,0,$user['id']);
        if((!$isPub)&&(!$user)){
            $msg = '您还没有登陆，请先登陆';
            $this->error($msg, '/index/index/login', $data = '', 3);
        }
        if((!$isPub)&&$user&&(!$isPri)){
            $msg = '您没有权限';
                    $this->error($msg, '/index/index/login', $data = '', 3);
        }
    }
    public function check($currentRule,$enabled,$userId=null)
    {
        $rule = model('rule');
        if($userId){
            $ruleName = $rule->getPriRule($enabled,$userId);
        }else{
            $ruleName = $rule->getPubRule($enabled);
        }
        foreach($currentRule as $v){
            if(in_array($v,$ruleName)){
                $this->key = true;
                break;
            }
        }
        return $this->key;
    }
}

