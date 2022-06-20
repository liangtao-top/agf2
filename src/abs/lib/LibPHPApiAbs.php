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

use com\agf2\enum\ApiModule;
use com\agf2\library\config\php\ApiConfig;

abstract class LibPHPApiAbs extends LibPHPAbs
{

    protected ApiConfig $apiConfig;

    public function __construct()
    {
        parent::__construct();
        $this->apiConfig = $this->config->getApi();
    }

    protected function setTemplate(string $path): self
    {
        parent::setTemplate($path);
        $this->replaceAll([
                              'terminal'            => $this->data[7]['generateTerminal'],
                              'version'             => $this->data[7]['version'],
                              'functionDescription' => $this->functionName,
                          ]);
        return $this;
    }

    /**
     * 设置模块
     * @param ApiModule $module
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/28 10:24
     */
    protected function setModule(ApiModule $module): void
    {
        $path = dirname(app_path()) . DS . 'api' . DS . $module->value . DS . $this->data[7]['generateTerminal'] . DS . $this->data[7]['version'];
        $dir  = empty($this->region) ? $path : $path . DS . $this->region;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $this->fileName = $dir . DS . $this->className . '.php';
        $this->content  = $this->data[5]['php']['api'][$module->value]['value'];
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
