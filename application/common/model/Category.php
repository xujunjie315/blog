<?php
namespace app\common\model;

use think\Model;
class Category extends Model
{
    //指定主键
    protected $pk = 'id';
    //自动完成
    protected $insert = ['enabled' => 1];
    public function getCateList($id=null){
        $select = $this;
        if($id){
            $select->where('id','<>',$id);
        }
        $cateList = collection($select->where('p_id',0)->where('enabled',ENABLED)->select())->toArray();
        return $cateList;
    }
    public function getCate(){
        $cateList = collection($this->where('enabled',ENABLED)->where('p_id','<>',0)->select())->toArray();
        return $cateList;
    }
    public function getCategory($input){
        $select = $this;
        if(isset($input['condition'])){
            $select = $select->where('name|p_id','like',"%{$input['condition']}%");
        }
        $cateList = $select->where('enabled',ENABLED)->order('id asc')->paginate(10);
        return $cateList;
    }
}
