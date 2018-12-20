<?php


namespace app\admin\validate;

use think\Validate;
class Articleclass extends Validate
{
    protected $rule = [
        ['ac_name','require','名字不能为空'],
        ['ac_sort','number','排序必须为数字'],
    ];

    protected $scene = [
        'add'=>['ac_name','ac_sort'],
        'edit'=>['ac_name','ac_sort'],
    ];
}