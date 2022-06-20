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
namespace com\agf2\library\gen\java;

use com\agf2\library\gen\java\admin\Controller;
use com\agf2\library\gen\java\admin\CssForm;
use com\agf2\library\gen\java\admin\CssIndex;
use com\agf2\library\gen\java\admin\CssView;
use com\agf2\library\gen\java\admin\Entity;
use com\agf2\library\gen\java\admin\HtmlCreate;
use com\agf2\library\gen\java\admin\HtmlEdit;
use com\agf2\library\gen\java\admin\HtmlIndex;
use com\agf2\library\gen\java\admin\HtmlView;
use com\agf2\library\gen\java\admin\JsForm;
use com\agf2\library\gen\java\admin\JsIndex;
use com\agf2\library\gen\java\admin\JsView;
use com\agf2\library\gen\java\admin\Model;
use com\agf2\library\gen\java\admin\Service;
use com\agf2\library\gen\java\admin\ServiceImpl;
use com\agf2\library\gen\java\admin\Validate;
use com\agf2\struct\JavaAdminResponse;

class Admin
{
    public static function build(): JavaAdminResponse
    {
        $response = new JavaAdminResponse();
        $response->setController((new Controller)->build());
        $response->setEntity((new Entity)->build());
        $response->setModel((new Model)->build());
        $response->setValidate((new Validate)->build());
        $response->setService((new Service)->build());
        $response->setServiceImpl((new ServiceImpl)->build());
        $response->setIndexHtml((new HtmlIndex)->build());
        $response->setCreateHtml((new HtmlCreate)->build());
        $response->setEditHtml((new HtmlEdit)->build());
        $response->setViewHtml((new HtmlView)->build());
        $response->setIndexJs((new JsIndex)->build());
        $response->setFormJs((new JsForm)->build());
        $response->setViewJs((new JsView)->build());
        $response->setIndexCss((new CssIndex)->build());
        $response->setFormCss((new CssForm)->build());
        $response->setViewCss((new CssView)->build());
        return $response;
    }

    public static function write(): void
    {
    }


    public static function clean(): void
    {
    }
}
