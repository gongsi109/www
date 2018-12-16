<?php

namespace app\common\model;

use think\Model;

class Admin extends Model{

    public function getOneAdmin(){
        return db('admin')->find();
    }



}