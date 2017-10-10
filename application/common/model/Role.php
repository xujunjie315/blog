<?php
namespace app\common\model;

use think\Model;
class Role extends Model
{
    protected $insert = ['enabled' => 1];
    public function getRoleList(){
        $roleList = collection($this->where('enabled',ENABLED)->select())->toArray();
        return $roleList;
    }
    public function getRole($input){
        $select = $this;
        if(isset($input['condition'])){
            $select = $this->where('name','like',"%{$input['condition']}%");
        }
        $roleList = $select->where('enabled',ENABLED)->order('id asc')->paginate(10);
        return $roleList;
    }
}