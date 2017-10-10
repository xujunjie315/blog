<?php
namespace app\common\model;

use think\Model;

class Article extends Model
{
    //自动完成
    protected $insert = ['views'=>0,'enabled'=>1];
    public function getArticleList($input){
        $select = $this->alias('a')
            ->join('category c','a.cate_id=c.id','left');
        if(isset($input['condition'])){
            $select = $select->where('a.title|c.name','like',"%{$input['condition']}%");
        }
        $articleList = $select->order('a.id asc')->where('a.enabled',ENABLED)->field('a.id,a.title,c.name,a.views,FROM_UNIXTIME(a.create_time,"%Y-%m-%d %H:%i:%s")')->paginate(10);
        return $articleList;
    }
}