<?php


namespace app\common\model;

use think\Model;

class Adminlog extends Model {

    //增加
    public function addAdminlog($data) {
        return db('adminlog')->insertGetId($data);
    }
}
