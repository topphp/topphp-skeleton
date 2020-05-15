<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - indexCheck.php
 *
 * Index 验证器
 */


namespace app\admin\validate;

use think\Validate;

class IndexCheck extends Validate
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
     * 定义错误信息【1、使用TopPHP自带的Check验证器中间件支持数组定义（骨架已自动集成）；2、使用Tp6的注解验证器不支持数组形式定义】
     * 格式：'字段名.规则名'    =>    '错误信息'
     * 数组定义示例："username" => ['code' => 40000, 'message' => '请填写用户名'] 返回 {"code":40000,"message":"请填写用户名","data":[]}
     *
     * 注意：因为是严格模式，错误信息内容被限定为字符串，传int型会报错，数组形式的code码允许是int型
     *
     * @var array
     */
    protected $message = [

    ];

    /**
     * 定义验证场景【key全小写，单独验证某个字段的写法：操作方法名(actionName)@字段名 => ['字段验证规则key']，注意 @ 后字段名区分大小写】
     * 格式：【非多层级控制器】1、'操作方法名(actionName)'    =>    ['字段1','字段2'...]
     *       【多层级控制器】2、'层级名(layered).操作方法名(actionName)'    =>    ['字段1','字段2'...]
     * 单独验证：配置好单独验证的场景【"index@username"=>['username']】后，直接在控制器调用 checkOneRequestParam("username","post"); 方法即可
     *
     * @var array
     */
    protected $scene = [

    ];
}
