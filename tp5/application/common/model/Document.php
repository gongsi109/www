<?php


namespace app\common\model;

use think\Model;
class Document extends Model {

    //查询所有系统文章
    public function getDocumentList(){
        return db('document')->select();
    }
}