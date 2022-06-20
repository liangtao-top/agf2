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

enum ApiModule: string
{
    case CONTROLLER ='controller';
    case LOGIC ='logic';
    case MODEL ='model';
    case VALIDATE ='validate';
}
