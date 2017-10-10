<?php
namespace app\common\model;

use think\Model;

class Rule extends Model
{
    public function getRuleList(){
        $ruleList = collection($this->where('enabled',PRI)->select())->toArray();
        return $ruleList;
    }
    public function getPubRule($enabled)
    {
        $ruleList = collection($this->where('enabled',$enabled)->select())->toArray();
        $ruleName = array_column($ruleList,'name');
        return $ruleName;
    }
    public function getPriRule($enabled,$userId){
        $userRule = collection($this->alias('r')
            ->join('user_rule ur','r.id=ur.rule_id','right')
            ->where('r.enabled',$enabled)
            ->where('ur.user_id',$userId)
            ->field('r.id,r.name')
            ->select())->toArray();
        $roleRule = collection($this->alias('r')
            ->join('role_rule rr','r.id=rr.rule_id','right')
            ->join('role ro','rr.role_id=ro.id','right')
            ->join('user u','ro.id=u.role_id','right')
            ->where('r.enabled',$enabled)
            ->where('u.id',$userId)
            ->field('r.id,r.name')
            ->select())->toArray();
        $userRuleName = $userRule?array_column($userRule,'name'):array();
        $roleRuleName = $roleRule?array_column($roleRule,'name'):array();
        return array_merge($userRuleName,$roleRuleName);
    }
    public function getRule($input){
        $select = $this;
        if(isset($input['condition'])){
            $select = $select->where('name|enabled','like',$input['condition']);
        }
        $ruleList = $select->order('id asc')->paginate(10);
        return $ruleList;
    }
}
