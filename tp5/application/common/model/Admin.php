<?php

namespace app\common\model;

use think\Model;

class Admin extends Model{

    public function getOneAdmin($conditions){
        return db('admin')->where($conditions)->find();
    }

    //更新信息
    public function editAdmin($data,$admin_id){
        if(empty($data)){
            return false;
        }
        return db('admin')->where('admin_id',$admin_id)->update($data);
    }

}