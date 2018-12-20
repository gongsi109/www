<?php


namespace app\admin\validate;

use think\Validate;
class Article extends Validate
{
    protected $rule = [
        ['article_sort', 'number', '必须为数字'],
        ['article_title', 'require', '标题不能为空'],
    ];

    protected $scene = [
        'add'=>['article_sort','article_title'],

    ];
}