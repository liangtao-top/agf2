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
// | Version: 2.0 2022/6/16 15:37
// +----------------------------------------------------------------------
namespace com\agf2\util;

class FileUtil
{

    /**
     * 写入
     * @param string $filename
     * @param mixed  $data
     * @return false|int
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/28 10:24
     */
    public static function write(string $filename, mixed $data): int|false
    {
        return file_put_contents($filename, $data);
    }

    public static function rm(string $filename): bool
    {
        return file_exists($filename) && unlink($filename);
    }

}
