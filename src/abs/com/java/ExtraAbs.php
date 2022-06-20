<?php
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2020/3/28 18:33
// +----------------------------------------------------------------------
declare (strict_types=1);

namespace com\agf2\abs\com\java;

abstract class ExtraAbs
{

    /** @noinspection PhpUnusedParameterInspection */
    public static function empty(array &$value): string
    {
        return '';
    }

    /** @noinspection PhpConditionAlreadyCheckedInspection */
    public static function initial(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $ds = 0;    // 数据来源
        $sf = '';   // 保存字段
        $df = '';   // 展示字段
        HtmlAbs::GenTripartiteVarAgr($value, $ds, $sf, $df);
        if ($ds === 1) {
            $dataCustom = $data['dataCustom'];
            $key_arr    = explode("\r\n", $dataCustom);
            $add        = [];
            foreach ($key_arr as $item) {
                $item  = explode(':', $item);
                $add[] = "            put(\"$item[0]\", \"$item[1]\");";
            }
            $add = implode(PHP_EOL, array_unique($add));
            return <<<TEXT
        map.put("$btf", new HashMap<>(){{
$add
        }});
TEXT;
        } else {
            return <<<TEXT
        map.put("$btf", NativeQuery.extra("{$data['dataOption']}", new String[]{"$sf", "$df"}));
TEXT;
        }
    }
}
