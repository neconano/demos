<?php
namespace app\common\validate;
use think\Validate;

class Bookin extends Validate
{
    protected $rule = [
        // 令牌
        'name'  =>  'require|max:25|token',
    ];

}