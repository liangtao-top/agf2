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
// | Version: 2.0 2021/8/20 8:59
// +----------------------------------------------------------------------
namespace com\agf2\library\config\php;

use com\agf2\abs\ConfAbs;
use com\agf2\library\config\php\admin\TemplateConfig;

/**
 * PHP后台配置
 */
class AdminConfig extends ConfAbs
{

    private TemplateConfig $template;

    /**
     * @return \com\agf2\library\config\php\admin\TemplateConfig
     */
    public function getTemplate(): TemplateConfig
    {
        return $this->template;
    }

    /**
     * @param \com\agf2\library\config\php\admin\TemplateConfig $template
     */
    public function setTemplate(TemplateConfig $template): void
    {
        $this->template = $template;
    }

}
