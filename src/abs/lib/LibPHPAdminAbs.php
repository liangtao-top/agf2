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
// | Version: 2.0 2021/8/20 17:36
// +----------------------------------------------------------------------
namespace com\agf2\abs\lib;

use com\agf2\enum\AdminModule;
use com\agf2\library\config\php\AdminConfig;

abstract class LibPHPAdminAbs extends LibPHPAbs
{
    protected AdminConfig $adminConfig;

    public function __construct()
    {
        parent::__construct();
        $this->adminConfig = $this->config->getAdmin();
    }

    /**
     * 设置模块
     * @param AdminModule $module
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/28 10:24
     */
    protected function setModule(AdminModule $module): void
    {
        switch ($module) {
            case AdminModule::CONTROLLER:
            case AdminModule::LOGIC:
            case AdminModule::MODEL:
            case AdminModule::VALIDATE:
                $path           = dirname(app_path()) . DS . 'admin' . DS . $module->value;
                $dir            = empty($this->region) ? $path : $path . DS . $this->region;
                $this->fileName = $dir . DS . $this->className . '.php';
                break;
            case AdminModule::HTML_INDEX:
            case AdminModule::HTML_CREATE:
            case AdminModule::HTML_EDIT:
            case AdminModule::HTML_VIEW:
                $path           = app_path() . config('view.view_dir_name');
                $dir            = empty($this->region) ? $path . DS . parse_name($this->className) : $path . DS . $this->region . DS . parse_name($this->className);
                $this->fileName = $dir . DS . substr($module->value, 0, -4) . '.html';
                break;
            case AdminModule::CSS_INDEX:
            case AdminModule::CSS_FORM:
            case AdminModule::CSS_VIEW:
                $path           = root_path() . 'public' . DS . 'static' . DS . 'assets' . DS . 'css';
                $dir            = empty($this->region) ? $path . DS . parse_name($this->className) : $path . DS . $this->region . DS . parse_name($this->className);
                $this->fileName = $dir . DS . substr($module->value, 0, -3) . '.css';
                break;
            case AdminModule::JS_INDEX:
            case AdminModule::JS_FORM:
            case AdminModule::JS_VIEW:
                $path           = root_path() . 'public' . DS . 'static' . DS . 'assets' . DS . 'js';
                $dir            = empty($this->region) ? $path . DS . parse_name($this->className) : $path . DS . $this->region . DS . parse_name($this->className);
                $this->fileName = $dir . DS . substr($module->value, 0, -2) . '.js';
                break;
        }
        if (isset($dir) && !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $this->content = $this->data[5]['php']['admin'][$module->value]['value'];
    }

    /**
     * getFileName
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/16 15:48
     */
    protected function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * getContent
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/16 16:53
     */
    protected function getContent(): string
    {
        return $this->content;
    }
}
