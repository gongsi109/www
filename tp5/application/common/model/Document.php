<?php


namespace app\common\model;

use think\Model;
class Document extends Model {

    //查询所有系统文章
    public function getDocumentList(){
        return db('document')->select();
    }

    //根据编号查询一条
    public function getOneDocumentById($id){
        return db('document')->where('document_id',$id)->find();
    }

}