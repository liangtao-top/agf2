<?php
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
// | Version: 2.0 2021/8/20 14:38
// +----------------------------------------------------------------------
namespace com\agf2\util;

use com\agf2\enum\Scene;
use com\agf2\exception\ValidateException;

class Validate
{
    private array $data;

    private Scene $scene;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @throws \com\agf2\exception\ValidateException
     */
    public function check(array $data = []): void
    {
        if (empty($data)) {
            $data =& $this->data;
        }
        if (empty($data)) {
            throw new ValidateException('数据不能为空');
        }
        if (!isset($data[0]) || !isset($data[0]['selected']) || count($data[0]['selected']) === 0) {
            throw new ValidateException('请完善数据库信息');
        }
        if (!isset($data[4]) || empty($data[4])) {
            throw new ValidateException('请完善信息配置');
        }
        if (!isset($data[4]['creators']) || empty($data[4]['creators'])) {
            throw new ValidateException('请完善创建人员信息');
        }
        if (!isset($data[4]['functionalClassName']) || empty($data[4]['functionalClassName'])) {
            throw new ValidateException('请完善功能类名信息');
        }
        if (!isset($data[5]) || empty($data[5])) {
            throw new ValidateException('请构建代码');
        }
        if (!$this->getScene()->equals(Scene::BUILD())) {
            if (!isset($data[6]) || empty($data[6])) {
                throw new ValidateException('请完善发布配置');
            }
            if (empty($data[6]['menuName'])) {
                throw new ValidateException('请完善菜单名称信息');
            }
        }
        if (!isset($data[1]) || empty($data[1])) {
            throw new ValidateException('请完善表单设计');
        }
        if (!isset($data[1]['controls']) || empty($data[1]['controls'])) {
            throw new ValidateException('请完善控件信息');
        }
        if (!is_array($data[1]['controls'])) {
            throw new ValidateException('控件数据异常');
        }
        foreach ($data[1]['controls'] as $value) {
            if (!is_array($value)) {
                throw new ValidateException('表单选项卡数据异常');
            }
        }
        $bingTableName  = [];
        $bindTableFiled = [];
        Helper::each($data, function ($value) use (&$bingTableName, &$bindTableFiled) {
            if (empty($value) || !is_array($value) || !isset($value['type_id'])) {
                throw new ValidateException($value['title'] . '控件数据异常');
            }
            if (isset($value['formData']) && (int)$value['type_id'] !== 1) {
                if (!is_array($value['formData'])) {
                    throw new ValidateException($value['title'] . '控件属性异常');
                }
                if (!isset($value['formData']['bingTableName']) || empty($value['formData']['bingTableName'])) {
                    throw new ValidateException($value['title'] . '控件未绑定表');
                }
                if (!isset($value['formData']['bindTableFiled']) || empty($value['formData']['bindTableFiled'])) {
                    throw new ValidateException($value['title'] . '控件未绑定字段');
                }
                if (in_array($value['formData']['bindTableFiled'], $bindTableFiled) && in_array($value['formData']['bingTableName'], $bingTableName)) {
                    throw new ValidateException($value['title'] . '控件绑定字段重复');
                } else {
                    $bingTableName []  = $value['formData']['bingTableName'];
                    $bindTableFiled [] = $value['formData']['bindTableFiled'];
                }
            }
        });
    }

    /**
     * getScene
     * @return \com\agf2\enum\Scene
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 15:42
     */
    public function getScene(): Scene
    {
        return $this->scene;
    }

    /**
     * setScene
     * @param \com\agf2\enum\Scene $scene
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 15:42
     */
    public function setScene(Scene $scene): self
    {
        $this->scene = $scene;
        return $this;
    }
}
