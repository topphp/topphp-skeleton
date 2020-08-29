<?php

/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

declare(strict_types=1);

namespace app\model\entity;

use app\model\BaseModel;
use think\Model;

/**
 * @property int $id id
 * @property string $user_name 用户名
 * @property string $password 密码
 * @property string $email 邮箱
 * @property string $tel 手机号
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property string $delete_time 删除时间
 */
class Demo extends Model
{
    //use BaseModel;

    protected $pk = 'id';

    protected $table = 'topphp_demo';

    protected $schema = [
        'id' => 'int',
        'user_name' => 'varchar',
        'password' => 'varchar',
        'email' => 'varchar',
        'tel' => 'varchar',
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
        'delete_time' => 'timestamp',
    ];
}
