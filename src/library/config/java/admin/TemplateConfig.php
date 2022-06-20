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
// | Version: 2.0 2021/8/20 9:04
// +----------------------------------------------------------------------
namespace com\agf2\library\config\java\admin;

use com\agf2\abs\ConfAbs;
use com\agf2\library\config\java\admin\template\CssConfig;
use com\agf2\library\config\java\admin\template\HtmlConfig;
use com\agf2\library\config\java\admin\template\JsConfig;
use com\agf2\library\config\java\admin\template\JavaConfig;

/**
 * PHP后台模板配置
 */
class TemplateConfig extends ConfAbs
{

    private JavaConfig $java;

    private HtmlConfig $html;

    private CssConfig $css;

    private JsConfig $js;


    /**
     * @return \com\agf2\library\config\java\admin\template\HtmlConfig
     */
    public function getHtml(): HtmlConfig
    {
        return $this->html;
    }

    /**
     * @param \com\agf2\library\config\java\admin\template\HtmlConfig $html
     */
    public function setHtml(HtmlConfig $html): void
    {
        $this->html = $html;
    }

    /**
     * @return \com\agf2\library\config\java\admin\template\CssConfig
     */
    public function getCss(): CssConfig
    {
        return $this->css;
    }

    /**
     * @param \com\agf2\library\config\java\admin\template\CssConfig $css
     */
    public function setCss(CssConfig $css): void
    {
        $this->css = $css;
    }

    /**
     * @return \com\agf2\library\config\java\admin\template\JsConfig
     */
    public function getJs(): JsConfig
    {
        return $this->js;
    }

    /**
     * @param \com\agf2\library\config\java\admin\template\JsConfig $js
     */
    public function setJs(JsConfig $js): void
    {
        $this->js = $js;
    }

    /**
     * @return \com\agf2\library\config\java\admin\template\JavaConfig
     */
    public function getJava(): JavaConfig
    {
        return $this->java;
    }

    /**
     * @param \com\agf2\library\config\java\admin\template\JavaConfig $java
     */
    public function setJava(JavaConfig $java): void
    {
        $this->java = $java;
    }

}

