<?php


namespace app\common\model;

use think\Model;
class Upload extends Model{

    public function getUploadList($condition,$field='*'){
        $result = db('upload')->field($field)->order('upload_id asc')->where($condition)->select();
        return $result;
    }
}