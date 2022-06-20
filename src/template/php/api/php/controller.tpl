<?php /** @noinspection PhpUnused */
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

namespace app\api\controller\##terminal##\##version##\##region##;

use app\api\controller\##terminal##\BaseApp;
use app\api\logic\##terminal##\##version##\##region##\##className## as Logic;
use app\api\validate\##terminal##\##version##\##region##\##className## as Validate;

/**
 * ##functionDescription##控制器类
 * @package app\api\controller\##terminal##\##version##\##region##
 * @OA\Tag(name="##terminal##.##version##.##region##.##className##",description="##functionDescription##")
 */
class ##className## extends BaseApp
{
    /**
     * @OA\Get(
     *     path="/##terminal##.##version##.##region##.##className##/index",
     *     tags={"##terminal##.##version##.##region##.##className##"},
     *     summary="查询",
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="搜索条件",
     *         @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *               property="search",
     *               type="array",
     *               @OA\Items(
     *               ),
     *            ),
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="当前页码",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         ),
     *         example=1,
     *     ),
     *     @OA\Parameter(
     *         name="list_rows",
     *         in="query",
     *         description="每页数量",
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         ),
     *         example=15,
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   ##date##
     */
    public function index()
    {
        $this->standardAction('get', Validate::class, __FUNCTION__, Logic::class);
    }

    /**
     * @OA\Get(
     *     path="/##terminal##.##version##.##region##.##className##/read",
     *     tags={"##terminal##.##version##.##region##.##className##"},
     *     summary="读取",
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *         example="",
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   ##date##
     */
    public function read()
    {
        $this->standardAction('get', Validate::class, __FUNCTION__, Logic::class);
    }

    /**
     * @OA\Post(
     *     path="/##terminal##.##version##.##region##.##className##/save",
     *     tags={"##terminal##.##version##.##region##.##className##"},
     *     summary="新增",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/##terminal##.##version##.##region##.##className##::save")
     *         ),
     *         @OA\JsonContent(ref="#/components/schemas/##terminal##.##version##.##region##.##className##::save"),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   ##date##
     */
    public function save()
    {
        $this->standardAction('post', Validate::class, __FUNCTION__, Logic::class);
    }

    /**
     * @OA\Put(
     *     path="/##terminal##.##version##.##region##.##className##/update",
     *     tags={"##terminal##.##version##.##region##.##className##"},
     *     summary="更新",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/##terminal##.##version##.##region##.##className##::update")
     *         ),
     *         @OA\JsonContent(ref="#/components/schemas/##terminal##.##version##.##region##.##className##::update"),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   ##date##
     */
    public function update()
    {
        $this->standardAction('put', Validate::class, __FUNCTION__, Logic::class);
    }

    /**
     * @OA\Delete(
     *     path="/##terminal##.##version##.##region##.##className##/delete",
     *     tags={"##terminal##.##version##.##region##.##className##"},
     *     summary="删除",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/##terminal##.##version##.##region##.##className##::delete")
     *         ),
     *         @OA\JsonContent(ref="#/components/schemas/##terminal##.##version##.##region##.##className##::delete"),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   ##date##
     */
    public function delete()
    {
        $this->standardAction('delete', Validate::class, __FUNCTION__, Logic::class);
    }

}
