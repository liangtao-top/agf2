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
// | Version: 2.0 2021/8/20 9:20
// +----------------------------------------------------------------------
namespace com\agf2\library\config\java\admin\template;

use com\agf2\abs\ConfAbs;

class JavaConfig extends ConfAbs
{

    private string $controller;
    private string $service;
    private string $serviceImpl;
    private string $model;
    private string $validate;
    private string $entity;

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService(string $service): void
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getServiceImpl(): string
    {
        return $this->serviceImpl;
    }

    /**
     * @param string $serviceImpl
     */
    public function setServiceImpl(string $serviceImpl): void
    {
        $this->serviceImpl = $serviceImpl;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getValidate(): string
    {
        return $this->validate;
    }

    /**
     * @param string $validate
     */
    public function setValidate(string $validate): void
    {
        $this->validate = $validate;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

}
