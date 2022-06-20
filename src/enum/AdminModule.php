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
// | Version: 2.0 2022/6/16 16:48
// +----------------------------------------------------------------------
namespace com\agf2\enum;

enum AdminModule: string
{
    case CONTROLLER = 'controller';
    case LOGIC = 'logic';
    case MODEL = 'model';
    case VALIDATE = 'validate';

    case HTML_INDEX = 'indexHtml';
    case HTML_CREATE = 'createHtml';
    case HTML_EDIT = 'editHtml';
    case HTML_VIEW = 'viewHtml';

    case CSS_INDEX = 'indexCss';
    case CSS_FORM = 'formCss';
    case CSS_VIEW = 'viewCss';

    case JS_INDEX = 'indexJs';
    case JS_FORM = 'formJs';
    case JS_VIEW = 'viewJs';
}
