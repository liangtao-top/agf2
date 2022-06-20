<?php /** @noinspection SpellCheckingInspection PhpUnnecessaryLocalVariableInspection DuplicatedCode PhpFullyQualifiedNameUsageInspection */
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

namespace app\admin\logic\##region##;

use think\Request;
use app\admin\common\Logic;
use app\admin\model\##region##\##className## as Model;

/**
 * ##functionName##业务类
 * @package app\admin\logic\##region##
 */
class ##className## extends Logic
{

    /**
     * initial
     * @return array
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function initial(): array
    {
        $data   = [];##initialCode##
        return $data;
    }

    /**
     * index
     * @param Request $request
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function index(Request $request): bool
    {
        $search = $request->get('search', '');
        $sort   = $request->get('name', '');
        $order  = $request->get('order', 'asc');
        $offset = $request->get('offset', 0);
        $limit  = $request->get('limit', 1000);
        $where  = [];
        $orders = [];
        if (!empty($search)) {
            foreach ($search as $key => $value) {
                if (is_string($value)) {
                    if (!empty($value)) {
                        $where[] = [$key, 'like', '%' . $value . '%'];
                    }
                } elseif (is_array($value)) {
                    if (isset($value['start']) && isset($value['end']) && !empty($value['start']) && !empty($value['end'])) {
                        $arr     = date_parse_from_format('Y年m月d日', $value['start']);
                        $start   = mktime(0,0,0,$arr['month'],$arr['day'],$arr['year']);
                        $arr2    = date_parse_from_format('Y年m月d日', $value['end']);
                        $end     = mktime(0,0,0,$arr2['month'],$arr2['day'],$arr2['year']);
                        $where[] = [$key, 'BETWEEN', [$start, $end]];
                    }
                }
            }
        }
        if (!empty($sort)) {
            $orders[$sort] = $order;
        } else {
            $orders['id']   = 'desc';
            $orders['sort'] = 'asc';
        }
        $append       = [##append##];
        $model        = new Model;
        $result       = $model->where($where)->append($append)->order($orders)->limit($offset, $limit)->select();
        $this->result = [
            'total'            => $model->where($where)->count(),
            'totalNotFiltered' => $model->count(),
            'rows'             => $result,
        ];
        return true;
    }

    /**
     * read
     * @param Request $request
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function read(Request $request): bool
    {
        $id    = $request->get('id/d', 0);
        $query = Model::where('id', $id);
        if (!$query->count()) {
            $this->error = '参数错误';
            return false;
        }
        $this->result = $query->find();
        return true;
    }

    /**
     * save
     * @param Request $request
     * @return bool
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   ##date##
     */
    public function save(Request $request): bool
    {
        $data  = $request->post();
        $model = new Model;
        return $model->exists(false)->save($data);
    }

    /**
     * update
     * @param Request $request
     * @return bool
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function update(Request $request): bool
    {
        $id    = $request->put('id/d', 0);
        $query = Model::where('id', $id);
        if (!$query->count()) {
            $this->error = '参数错误';
            return false;
        }
        Model::update($request->put());
        return true;
    }

    /**
     * status
     * @param Request $request
     * @return bool
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function status(Request $request): bool
    {
        $ids = [];
        if ($request->has('ids', 'put', true)) {
            $ids = $request->put('ids');
        }
        if ($request->has('id', 'put', true)) {
            $ids [] = $request->put('id/d', 0);
        }
        if (!empty($ids) && is_array($ids)) {
            $model  = new Model;
            $data   = [];
            $status = $request->put('status/d');
            foreach ($ids as $id) {
                $data[] = ['id' => $id, 'status' => $status];
            }
            $model->saveAll($data);
        }
        return true;
    }

    /**
     * delete
     * @param Request $request
     * @return bool
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   ##date##
     */
    public function delete(Request $request): bool
    {
        $ids = [];
        if ($request->has('ids', 'delete', true)) {
            $ids = $request->delete('ids');
        }
        if ($request->has('id', 'delete', true)) {
            $ids [] = $request->delete('id/d', 0);
        }
        Model::destroy($ids);
        return true;
    }

}
