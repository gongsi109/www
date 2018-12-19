<?php


namespace app\common\model;

use think\Model;
class Articleclass extends Model {

    public function getArticleClassList(){
        return db('articleclass')->select();
    }

    public function getTreeClassList(){
        $class_list = $this->getArticleClassList();
        if(is_array($class_list)&&!empty($class_list)){
            $result = $this->_getTreeClassList($class_list);
        }
        return $result;
    }

    public function _getTreeClassList($class_list,$parent=0,$deep=0){
        static $show_class = array();
        foreach($class_list as $k=>$v){
            if($v['ac_parent_id']==$parent){
                $v['deep'] = $deep;
                $show_class[]=$v;
                $this->_getTreeClassList($class_list,$v['ac_id'],$v['deep']+1);
            }
        }
        return $show_class;
    }

    //取单个分类的内容
    public function getOneArticleclass($id){
        $value = intval($id);
        if($value > 0){
            $result = db('articleclass')->where(array('ac_id'=>$value))->find();
            return $result;
        }else{
            return false;
        }
    }
    //新增
    public function addArticleclass($data){
        $result = db('articleclass')->insertGetId($data);
        return $result;
    }
    //更新
    public function editArticleclass($data,$ac_id){
        $result = db('articleclass')->where("ac_id",$ac_id)->update($data);
        return $result;
    }

    //取指定分类id下的所有子类
    public function getChildClass($parent_id){
        $all_class = $this->getArticleClassList();
        static $result = array();
        foreach($all_class as $k => $v){
             if($v['ac_parent_id']==$parent_id){
                 $result[] = $v['ac_id'];
                 $this->getChildClass($v['ac_id']);
             }
        }
        return $result;
    }

//    删除
    public function delArticleclass($id){
        return db('articleclass')->where('ac_id', intval($id))->delete();
    }





}