<?php /** @noinspection PhpMissingFieldTypeInspection SpellCheckingInspection */
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 ##date##
// +----------------------------------------------------------------------

namespace app\admin\validate\##region##;

use app\admin\common\Validate;

/**
 * ##functionName##验证类
 * @package app\admin\validate\##region##;
 */
class ##className## extends Validate
{

    protected $rule = [
        'ids|ID' => 'array|requireWithout:id',
        'id'     => 'number|requireWithout:ids',
        'status' => 'in:0,1',
    ];

    protected $scene = [
        'save'   => [''],
        'update' => ['id', 'status'],
        'status' => ['id', 'ids', 'status'],
        'delete' => ['id', 'ids'],
        'edit'   => ['id'],
        'read'   => ['id'],
    ];
}
