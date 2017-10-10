<?php
namespace app\common\model;

use think\Model;
class User extends Model
{
    //指定主键
    protected $pk = 'id';
    //自动完成
    protected $insert = ['enabled' => 1];
    public function getUserList($input)
    {
        $select = $this->alias('u')
            ->join('role r','u.role_id=r.id','left');
        if(isset($input['condition'])){
            $select = $select->where('u.name','like',"%{$input['condition']}%");
        }
        $userList = $select->order('u.id asc')->where('u.enabled',ENABLED)->field('u.id,u.name,u.uname,r.name as role_name')->paginate(10);
        return $userList;
    }
}