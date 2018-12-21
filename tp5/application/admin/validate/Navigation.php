<?php


namespace app\admin\validate;

use think\Validate;
class Navigation extends Validate{

    protected $rule = [
        ['nav_sort', 'number', '只能为数字'],
        ['nav_title', 'require', '标题不能为空'],
    ];

}