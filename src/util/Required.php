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
// | Version: 2.0 2021/8/25 16:05
// +----------------------------------------------------------------------
namespace com\agf2\util;

class Required
{
    /**
     * parse
     * @param int $type_id
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 16:06
     * @noinspection DuplicatedCode
     */
    public static function parse(mixed $type_id): string{
        $html = '';
        switch ((int)$type_id) {
            case 1: // 不能为空！
                $html = '<span class="required">*</span>';
                break;
            case 2: // 必须为数字！
                $html = '<span class="required">*</span>';
                break;
            case 3: // 数字或空！
                break;
            case 4: // 必须为E-mail格式！
                $html = '<span class="required">*</span>';
                break;
            case 5: // E-mail格式或空！
                break;
            case 6: // 必须为字符串！
                $html = '<span class="required">*</span>';
                break;
            case 7: // 字符串或空！
                break;
            case 8: // 必须电话格式！
                $html = '<span class="required">*</span>';
                break;
            case 9: // 电话格式或者空！
                break;
            case 10: // 必须为传真格式！
                $html = '<span class="required">*</span>';
                break;
            case 11: // 传真格式或者空！
                break;
            case 12: // 必须为手机格式！
                $html = '<span class="required">*</span>';
                break;
            case 13: // 手机格式或者空！
                break;
            case 14: // 电话格式或手机格式！
                $html = '<span class="required">*</span>';
                break;
            case 15: // 电话格式或手机格式或空！
                break;
            case 16: // 必须为网址格式！
                $html = '<span class="required">*</span>';
                break;
            case 17: // 网址格式或空！
                break;
            default:
                $html = '';
        }
        return $html;
    }
}
