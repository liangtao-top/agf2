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
// | Version: 2.0 2021/8/24 12:12
// +----------------------------------------------------------------------
namespace com\agf2\util;

class ImportPHP
{
    public static function js(string|array $links = ''): string
    {
        if (empty($links)) {
            return '';
        }
        if (is_string($links)) {
            $links = [$links];
        }
        $html = [];
        foreach ($links as $link) {
            $src    = 'src="' . $link . '"';
            $html[] = '    <script ' . $src . '></script>';
        }
        return empty($html) ? '' :  implode(PHP_EOL, $html);
    }

    public static function css(string|array $links = ''): string
    {
        if (empty($links)) {
            return '';
        }
        if (is_string($links)) {
            $links = [$links];
        }
        $html = [];
        foreach ($links as $link) {
            $html[] = '    <link rel="stylesheet" href="' . $link . '">';
        }
        return empty($html) ? '' :  implode(PHP_EOL, $html);
    }
}
