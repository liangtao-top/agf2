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
// | Version: 2.0 2021/8/19 17:54
// +----------------------------------------------------------------------
namespace com\agf2\struct;

use com\struct\Struct;

class JavaAdminResponse extends Struct
{

    private string $controller;
    private string $service;
    private string $serviceImpl;
    private string $entity;
    private string $model;
    private string $validate;
    private string $indexHtml;
    private string $createHtml;
    private string $editHtml;
    private string $viewHtml;
    private string $indexCss;
    private string $formCss;
    private string $viewCss;
    private string $indexJs;
    private string $formJs;
    private string $viewJs;

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
    public function getIndexHtml(): string
    {
        return $this->indexHtml;
    }

    /**
     * @param string $indexHtml
     */
    public function setIndexHtml(string $indexHtml): void
    {
        $this->indexHtml = $indexHtml;
    }

    /**
     * @return string
     */
    public function getCreateHtml(): string
    {
        return $this->createHtml;
    }

    /**
     * @param string $createHtml
     */
    public function setCreateHtml(string $createHtml): void
    {
        $this->createHtml = $createHtml;
    }

    /**
     * @return string
     */
    public function getEditHtml(): string
    {
        return $this->editHtml;
    }

    /**
     * @param string $editHtml
     */
    public function setEditHtml(string $editHtml): void
    {
        $this->editHtml = $editHtml;
    }

    /**
     * @return string
     */
    public function getViewHtml(): string
    {
        return $this->viewHtml;
    }

    /**
     * @param string $viewHtml
     */
    public function setViewHtml(string $viewHtml): void
    {
        $this->viewHtml = $viewHtml;
    }

    /**
     * @return string
     */
    public function getIndexCss(): string
    {
        return $this->indexCss;
    }

    /**
     * @param string $indexCss
     */
    public function setIndexCss(string $indexCss): void
    {
        $this->indexCss = $indexCss;
    }

    /**
     * @return string
     */
    public function getFormCss(): string
    {
        return $this->formCss;
    }

    /**
     * @param string $formCss
     */
    public function setFormCss(string $formCss): void
    {
        $this->formCss = $formCss;
    }

    /**
     * @return string
     */
    public function getViewCss(): string
    {
        return $this->viewCss;
    }

    /**
     * @param string $viewCss
     */
    public function setViewCss(string $viewCss): void
    {
        $this->viewCss = $viewCss;
    }

    /**
     * @return string
     */
    public function getIndexJs(): string
    {
        return $this->indexJs;
    }

    /**
     * @param string $indexJs
     */
    public function setIndexJs(string $indexJs): void
    {
        $this->indexJs = $indexJs;
    }

    /**
     * @return string
     */
    public function getFormJs(): string
    {
        return $this->formJs;
    }

    /**
     * @param string $formJs
     */
    public function setFormJs(string $formJs): void
    {
        $this->formJs = $formJs;
    }

    /**
     * @return string
     */
    public function getViewJs(): string
    {
        return $this->viewJs;
    }

    /**
     * @param string $viewJs
     */
    public function setViewJs(string $viewJs): void
    {
        $this->viewJs = $viewJs;
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

}
