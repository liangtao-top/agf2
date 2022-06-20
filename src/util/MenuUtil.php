<?php /** @noinspection PhpDynamicAsStaticMethodCallInspection */
declare(strict_types=1);
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2022/6/17 10:36
// +----------------------------------------------------------------------
namespace com\agf2\util;

use app\admin\model\base\AuthOperation;
use app\admin\model\develop\Menu as MenuModel;
use com\agf2\library\Config;

class MenuUtil
{
    private array $rawData;
    private string $region;
    private string $className;

    /**
     * 操作列表
     * @var string[]
     */
    private array $operation = ['create' => '新增', 'save' => '保存', 'edit' => '编辑', 'read' => '查看', 'update' => '更新', 'status' => '状态', 'delete' => '删除'];

    public function __construct()
    {
        $this->rawData   = Config::instance()->getData();
        $this->region    = strtolower($this->rawData [4]['outputRegion']);
        $this->className = $this->rawData [4]['functionalClassName'];
    }

    /**
     * save
     * @throws \Exception
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 11:21
     */
    public static function save(): int
    {
        $self = new self;
        return empty($self->getRawData()[6]['menuId'] ?? 0) ? $self->insert() : $self->update();
    }

    /**
     * remove
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 14:59
     */
    public static function remove(): void
    {
        $self   = new self;
        $menuId = $self->getRawData()[6]['menuId'] ?? 0;
        if (!empty($menuId)) {
            $self->delete($menuId);
        }
    }

    /**
     * insert
     * @throws \Exception
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/7/24 16:41
     */
    public function insert(): int
    {
        $data = [
            'pid'         => $this->rawData[6]['menuParent'] ?? 0,
            'title'       => $this->rawData[6]['menuName'],
            'icon'        => $this->rawData[6]['menuIcon'] ?? '',
            'sort'        => $this->rawData[6]['menuSort'] ?? 100,
            'tip'         => $this->rawData[6]['description'] ?? '',
            'url'         => empty($this->region) ? $this->className . '/index' : $this->region . '.' . $this->className . '/index',
            'hide'        => 0,
            'target'      => '_self',
            'is_dev'      => 0,
            'status'      => 1,
            'create_time' => time(),
            'update_time' => time()
        ];
        $id   = (int)MenuModel::insertGetId($data);
        $this->operation($id);
        return $id;
    }

    /**
     * update
     * @throws \Exception
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/7/24 16:42
     */
    public function update(): int
    {
        $data = [
            'id'          => $this->rawData[6]['menuId'] ?? 0,
            'pid'         => $this->rawData[6]['menuParent'] ?? 0,
            'title'       => $this->rawData[6]['menuName'],
            'icon'        => $this->rawData[6]['menuIcon'] ?? '',
            'sort'        => $this->rawData[6]['menuSort'] ?? 100,
            'tip'         => $this->rawData[6]['description'] ?? '',
            'url'         => empty($this->region) ? $this->className . '/index' : $this->region . '.' . $this->className . '/index',
            'hide'        => 0,
            'target'      => '_self',
            'is_dev'      => 0,
            'status'      => 1,
            'create_time' => time(),
            'update_time' => time()
        ];
        MenuModel::update($data);
        $this->operation($data['id']);
        return $data['id'];
    }

    /**
     * 操作节点
     * @param int $menuId
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/5/26 12:18
     */
    public function operation(int $menuId): void
    {
        $query = AuthOperation::where('menu_id', $menuId);
        if ($query->count()) {
            $AuthOperation = new AuthOperation;
            $data          = $query->select()->toArray();
            $updateAll     = [];
            $i             = 0;
            foreach ($this->operation as $key => $value) {
                $updateAll[$i] = [
                    'menu_id'     => $menuId,
                    'name'        => $value,
                    'app'         => 'admin',
                    'controller'  => empty($this->region) ? $this->className : $this->region . '.' . $this->className,
                    'action'      => $key,
                    'remark'      => $value,
                    'status'      => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ];
                if (isset($data[$i]) && isset($data[$i]['id'])) {
                    $updateAll[$i]['id'] = $data[$i]['id'];
                }
                $i++;
            }
            $AuthOperation->saveAll($updateAll);
        } else {
            $insertAll = [];
            foreach ($this->operation as $key => $value) {
                $insertAll[] = [
                    'menu_id'     => $menuId,
                    'name'        => $value,
                    'app'         => 'admin',
                    'controller'  => empty($this->region) ? $this->className : $this->region . '.' . $this->className,
                    'action'      => $key,
                    'remark'      => $value,
                    'status'      => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ];
            }
            AuthOperation::insertAll($insertAll);
        }
    }

    /**
     * delete
     * @param int $menuId
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/22 14:35
     */
    public function delete(int $menuId = 0): void
    {
        if ($menuId > 0) {
            MenuModel::where('id|pid', '=', $menuId)->delete();
            AuthOperation::where('menu_id', '=', $menuId)->delete();
        }
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }
}
