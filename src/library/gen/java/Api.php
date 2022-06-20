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

use com\agf2\struct\JavaApiResponse;

class Api
{

    public static function build(): JavaApiResponse
    {
        return new JavaApiResponse();
    }

    public static function write(): void
    {
    }

    public static function clean(): void
    {
    }
}

