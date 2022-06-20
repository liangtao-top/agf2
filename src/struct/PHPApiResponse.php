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

class PHPApiResponse extends Struct
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
