<?php /** @noinspection PhpUnused DuplicatedCode SpellCheckingInspection PhpFullyQualifiedNameUsageInspection */
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

namespace app\admin\controller\##region##;

use app\admin\common\Controller;
use app\admin\logic\##region##\##className## as Logic;
use app\admin\validate\##region##\##className## as Validate;
use think\exception\ValidateException;

/**
 * ##functionName##控制器类
 * @package app\admin\controller\##region##
 */
class ##className## extends Controller
{
    /**
     * 列表页
     * @return string
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function index(): string
    {
        $logic  = new Logic;
        if ($this->request->isAjax()) {
            $result = $logic->index($this->request);
            if (!$result) {
                $this->error($logic->getError());
            }
            $this->success('查询成功', null, $logic->getResult());
        }
        $this->assign('data', $logic->initial());
        $this->webTitle('##menuName##');
        return $this->fetch();
    }

    /**
     * 新增页
     * @return string
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function create(): string
    {
        $logic = new Logic;
        $this->assign('data', $logic->initial());
        $this->webTitle('新增##functionName##');
        return $this->fetch();
    }

    /**
     * 编辑页
     * @return string
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function edit(): string
    {
        try {
            validate(Validate::class)->scene('edit')->check($this->request->get());
        } catch (ValidateException $e) {
            $this->error($e->getError());
        }
        $logic  = new Logic;
        $result = $logic->read($this->request);
        if ($result) {
            $this->assign('info', $logic->getResult());
        }
        $this->assign('data', $logic->initial());
        $this->webTitle('编辑##functionName##');
        return $this->fetch();
    }

    /**
     * 预览页
     * @return string
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function read(): string
    {
        try {
            validate(Validate::class)->scene('edit')->check($this->request->get());
        } catch (ValidateException $e) {
            $this->error($e->getError());
        }
        $logic  = new Logic;
        $result = $logic->read($this->request);
        if ($result) {
            $this->assign('info', $logic->getResult());
        }
        $this->assign('data', $logic->initial());
        $this->webTitle('查看');
        return $this->fetch();
    }

    /**
     * 保存
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   ##date##
     */
    public function save()
    {
        if ($this->request->isPost()) {
            try {
                validate(Validate::class)->scene('save')->check($this->request->post());
            } catch (ValidateException $e) {
                $this->error($e->getError());
            }
            $logic  = new Logic;
            $result = $logic->save($this->request);
            if (!$result) {
                $this->error($logic->getError());
            }
            $this->success('新增成功', 'index', $logic->getResult());
        }
    }

    /**
     * 更新
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function update()
    {
        if ($this->request->isPut()) {
            try {
                validate(Validate::class)->scene('update')->check($this->request->put());
            } catch (ValidateException $e) {
                $this->error($e->getError());
            }
            $logic  = new Logic;
            $result = $logic->update($this->request);
            if (!$result) {
                $this->error($logic->getError());
            }
            $this->success('更新成功', 'index', $logic->getResult());
        }
    }

    /**
     * 状态
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function status()
    {
        if ($this->request->isPut()) {
            try {
                validate(Validate::class)->scene('status')->check($this->request->put());
            } catch (ValidateException $e) {
                $this->error($e->getError());
            }
            $logic  = new Logic;
            $result = $logic->status($this->request);
            if (!$result) {
                $this->error($logic->getError());
            }
            $status = $this->request->put('status/d') ? '启用' : '禁用';
            $this->success($status . '成功', 'index', $logic->getResult());
        }
    }

    /**
     * 删除
     * @throws \Exception
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ##date##
     */
    public function delete()
    {
        if ($this->request->isDelete()) {
            try {
                validate(Validate::class)->scene('delete')->check($this->request->param());
            } catch (ValidateException $e) {
                $this->error($e->getError());
            }
            $logic  = new Logic;
            $result = $logic->delete($this->request);
            if (!$result) {
                $this->error($logic->getError());
            }
            $this->success('删除成功', 'index', $logic->getResult());
        }
    }
}
