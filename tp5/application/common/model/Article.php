<?php


namespace app\common\model;

use think\Model;

class Article extends Model {

    public $page_info;

    public function getArticleList($condition,$page='',$order='article_sort asc,article_time desc') {
        if($page) {
            $result = db('article')->where($condition)->order($order)->paginate($page,false,['query'=>request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('article')->where($condition)->order($order)->limit(10)->select();
        }
    }

    public function addArticle($data){
        $result = db('article')->insertGetId($data);
        return $result;
    }

    public function getOneArticle($condition) {
        $result = db('article')->where($condition)->find();
        return $result;
    }

    public function editArticle($data,$article_id){
        $result = db('article')->where("article_id=".$article_id)->update($data);
        return $result;
    }

    public function delArticle($id){
        return db('article')->where("article_id=".$id)->delete();
    }






}