<?php /** @noinspection PhpMissingFieldTypeInspection */
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

namespace app\api\validate\##terminal##\##version##\##region##;

use app\api\validate\BaseValidate;

/**
 * ##functionDescription##验证类
 * @package app\api\validate\##terminal##\##version##\##region##
 * @OA\Schema(schema="##terminal##.##version##.##region##.##className##")
 */
class ##className## extends BaseValidate
{
    protected $rule = [
        /**
         * @OA\Property(
         *   property="ids",
         *   description="ID数组",
         *   type="array",
         *   @OA\Items(
         *      type="integer",
         *   ),
         *   example={"1","2","3"},
         * )
         */
        'ids|ID' => 'array|requireWithout:id',
        /**
         * @OA\Property(
         *   property="id",
         *   description="ID",
         *   type="integer",
         *   format="int32",
         *   example="1",
         * )
         */
        'id'     => 'number|requireWithout:ids',
    ];

    protected $scene = [
        'index'  => [''],
        'read'   => ['id'],
        /**
         * @OA\Schema(
         *   schema="##terminal##.##version##.##region##.##className##::save",
         *   allOf={},
         *   required={},
         * )
         */
        'save'   => [''],
        /**
         * @OA\Schema(
         *   schema="##terminal##.##version##.##region##.##className##::update",
         *   allOf={
         *     @OA\Schema(
         *       @OA\Property(property="id", ref="#/components/schemas/##terminal##.##version##.##region##.##className##/properties/id"),
         *     )
         *   },
         *   required={"id"},
         * )
         */
        'update' => ['id'],
        /**
         * @OA\Schema(
         *   schema="##terminal##.##version##.##region##.##className##::delete",
         *   allOf={
         *     @OA\Schema(
         *       @OA\Property(property="id", ref="#/components/schemas/##terminal##.##version##.##region##.##className##/properties/id"),
         *       @OA\Property(property="ids", ref="#/components/schemas/##terminal##.##version##.##region##.##className##/properties/ids"),
         *     )
         *   },
         *   required={},
         * )
         */
        'delete' => ['id', 'ids'],
    ];

}
