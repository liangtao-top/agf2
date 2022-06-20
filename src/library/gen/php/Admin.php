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
// | Version: 2.0 2021/8/20 14:08
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\php;

use com\agf2\library\gen\php\admin\Controller;
use com\agf2\library\gen\php\admin\CssForm;
use com\agf2\library\gen\php\admin\CssIndex;
use com\agf2\library\gen\php\admin\CssView;
use com\agf2\library\gen\php\admin\HtmlCreate;
use com\agf2\library\gen\php\admin\HtmlEdit;
use com\agf2\library\gen\php\admin\HtmlIndex;
use com\agf2\library\gen\php\admin\HtmlView;
use com\agf2\library\gen\php\admin\JsForm;
use com\agf2\library\gen\php\admin\JsIndex;
use com\agf2\library\gen\php\admin\JsView;
use com\agf2\library\gen\php\admin\Logic;
use com\agf2\library\gen\php\admin\Model;
use com\agf2\library\gen\php\admin\Validate;
use com\agf2\struct\PHPAdminResponse;

class Admin
{

    public static function build(): PHPAdminResponse
    {
        $response = new PHPAdminResponse();
        $response->setController((new Controller)->build());
        $response->setLogic((new Logic)->build());
        $response->setValidate((new Validate)->build());
        $response->setModel((new Model)->build());
        $response->setIndexHtml((new HtmlIndex)->build());
        $response->setCreateHtml((new HtmlCreate)->build());
        $response->setEditHtml((new HtmlEdit)->build());
        $response->setViewHtml((new HtmlView)->build());
        $response->setIndexCss((new CssIndex)->build());
        $response->setFormCss((new CssForm)->build());
        $response->setViewCss((new CssView)->build());
        $response->setIndexJs((new JsIndex)->build());
        $response->setFormJs((new JsForm)->build());
        $response->setViewJs((new JsView)->build());
        return $response;
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:13
     */
    public static function write(): void
    {
        (new Controller)->write();
        (new Logic)->write();
        (new Validate)->write();
        (new Model)->write();
        (new HtmlIndex)->write();
        (new HtmlCreate)->write();
        (new HtmlEdit)->write();
        (new HtmlView)->write();
        (new CssIndex)->write();
        (new CssForm)->write();
        (new CssView)->write();
        (new JsIndex)->write();
        (new JsForm)->write();
        (new JsView)->write();
    }

    /**
     * clean
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 15:16
     */
    public static function clean(): void
    {
        (new Controller)->clean();
        (new Logic)->clean();
        (new Validate)->clean();
        (new Model)->clean();
        (new HtmlIndex)->clean();
        (new HtmlCreate)->clean();
        (new HtmlEdit)->clean();
        (new HtmlView)->clean();
        (new CssIndex)->clean();
        (new CssForm)->clean();
        (new CssView)->clean();
        (new JsIndex)->clean();
        (new JsForm)->clean();
        (new JsView)->clean();
    }
}
