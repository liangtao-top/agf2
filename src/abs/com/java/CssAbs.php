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
// | Version: 2.0 2021/7/6 16:04
// +----------------------------------------------------------------------

namespace com\agf2\abs\com\java;


abstract class CssAbs
{

    // 创建帮助提示参数变量
    public static function genPopoverVarAgr(array &$value): string
    {
        $data  = $value['formData'] ?? [];
        $style = '';
        if (isset($data['componentHelp']) && !empty($data['componentHelp'])) {
            $className = 'popover-' . md5(json_encode($data));
            $style     = <<<css
.$className {
    padding: 0 !important;
}
css;
        }
        return $style;
    }
}
