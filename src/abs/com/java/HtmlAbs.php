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
// | Version: 2.0 2021/7/6 15:09
// +----------------------------------------------------------------------

namespace com\agf2\abs\com\java;


abstract class HtmlAbs
{
    // 创建基础参数变量
    public static function genBaseVarAgr(array &$value, array &$data, string &$btf): void
    {
        if (isset($value['formData'])) {
            $data = $value['formData'];
        }
        if (isset($data['bindTableFiled'])) {
            $btf = parse_name($data['bindTableFiled'], 1, false);
        }
    }

    // 创建通用表单+className参数变量
    public static function genFormClassNameVarAgr(array &$value, array &$data, string &$btf, int &$pit_ib, int &$pit_ia, string &$class_name): void
    {
        self::genFormVarAgr($value, $data, $btf, $pit_ib, $pit_ia);
        $class_name = self::genClassName($value);
    }


    // 创建通用表单+Popover参数变量
    public static function genFormPopoverVarAgr(array &$value, array &$data, string &$btf, int &$pit_ib, int &$pit_ia, string &$popper): void
    {
        self::genFormVarAgr($value, $data, $btf, $pit_ib, $pit_ia);
        self::genPopoverVarAgr($value, $popper);
    }

    // 创建通用表单全量参数变量
    public static function genFormFullVarAgr(array &$value, array &$data, string &$btf, int &$pit_ib, int &$pit_ia, string &$class_name, string &$popper): void
    {
        self::genFormVarAgr($value, $data, $btf, $pit_ib, $pit_ia);
        $class_name = self::genClassName($value);
        self::genPopoverVarAgr($value, $popper);
    }

    //  创建通用表单参数变量
    public static function genFormVarAgr(array &$value, array &$data, string &$btf, int &$pit_ib, int &$pit_ia): void
    {
        if (isset($value['formData'])) {
            $data = $value['formData'];
        }
        if (isset($data['proportion_in_the_industry_before'])) {
            $pit_ib = $data['proportion_in_the_industry_before'];
        }
        if (isset($data['proportion_in_the_industry_after'])) {
            $pit_ia = $data['proportion_in_the_industry_after'];
        }
        if (isset($data['bindTableFiled'])) {
            $btf = parse_name($data['bindTableFiled'], 1, false);
        }
    }

    // 创建帮助提示参数变量
    public static function genPopoverVarAgr(array &$value, string &$popper): void
    {
        $data = $value['formData'] ?? [];
        if (isset($data['componentHelp']) && !empty($data['componentHelp'])) {
            $className = 'popover-' . md5(json_encode($data));
            $popper    = <<<html
 <button type="button" class="btn btn-pure btn-primary icon wb-help-circle {$className}" data-content="{$data['componentHelp']}" data-trigger="focus" data-toggle="popover"></button>
html;
        }
    }

    // 创建第三方数据源参数变量
    public static function genTripartiteVarAgr(array &$value, int &$data_sources, string &$save_field, string &$display_field): void
    {
        $data = $value['formData'] ?? [];
        if (isset($data['dataSources'])) {
            $data_sources = (int)$data['dataSources'];
        }
        if (isset($data['saveField'])) {
            $save_field = $data['saveField'];
        }
        if (isset($data['displayField'])) {
            $display_field = $data['displayField'];
        }
    }

    // 创建ClassName
    public static function genClassName(array &$value): string
    {
        return 'class-' . strtolower(md5(json_encode($value)));
    }

    // 创建基础参数变量
    public static function genBindFiled(array &$value): string
    {
        $data = $value['formData'] ?? [];
        return parse_name($data['bindTableFiled'] ?? '', 1, false);
    }
}
