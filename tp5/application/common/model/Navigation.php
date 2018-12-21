<?php


namespace app\common\model;

use think\Model;

class Navigation extends Model {

    public $page_info;
//    获取导航列表
    public function getNavigationList($condition,$page = '',$order = 'nav_sort desc'){
        if($page){
            $nav_list = db('navigation')->where($condition)->order($order)->paginate($page,false,['query'=>request()->param()]);
            $this->page_info = $nav_list;
            return $nav_list->items();
        } else {
            return db('navigation')->where($condition)->order('nav_sort')->select();
        }

    }

    public function addNavigation($data){
        $add_navigation = db('navigation')->insert($data);
        return $add_navigation;
    }

    public function getOneNavigation($condition){
        return db('navigation')->where($condition)->find();
    }

    public function eidtNavigation($data,$condition){
        return db('navigation')->where($condition)->update($data);
    }

    public function delNavigation($condition){
        return db('navigation')->where('nav_id',$condition)->delete();
    }


}