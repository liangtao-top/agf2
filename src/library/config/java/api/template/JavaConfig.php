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
namespace com\agf2\library\config\java\api\template;

use com\agf2\abs\ConfAbs;

class JavaConfig extends ConfAbs
{

    private string $controller;
    private string $logic;
    private string $model;
    private string $validate;

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
    public function getLogic(): string
    {
        return $this->logic;
    }

    /**
     * @param string $logic
     */
    public function setLogic(string $logic): void
    {
        $this->logic = $logic;
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
}
