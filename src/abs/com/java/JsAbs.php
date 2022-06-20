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
// | Version: 2.0 2021/7/6 16:09
// +----------------------------------------------------------------------

namespace com\agf2\abs\com\java;


abstract class JsAbs
{

    // 创建帮助提示参数变量
    public static function genPopoverVarAgr(array &$value): string
    {
        $data = $value['formData'] ?? [];
        $js = '';
        if (isset($data['componentHelp']) && !empty($data['componentHelp'])) {
            $js = <<<html
    // 初始化popover插件
    $.components.init('popover');
html;
        }
        return $js;
    }

}
