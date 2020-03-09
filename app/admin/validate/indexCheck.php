<?php
/**
 * Description - indexCheck.php
 *
 * Index 验证器
 */


namespace app\admin\validate;


use think\Validate;

class indexCheck extends Validate
{

    // 注意：全部Topphp验证器文件名统一以Check结尾，否则不会生效

    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [

    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [

    ];

    /**
     * 定义验证场景【key全小写，单独验证某个字段的写法：操作方法名(actionName)@字段名 => ['字段验证规则key']，注意 @ 后字段名区分大小写】
     * 格式：【非多层级控制器】1、'操作方法名(actionName)'    =>    ['字段1','字段2'...]
     *       【多层级控制器】2、'层级名(layered).操作方法名(actionName)'    =>    ['字段1','字段2'...]
     *
     * @var array
     */
    protected $scene = [

    ];
}