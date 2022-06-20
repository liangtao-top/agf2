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
namespace com\agf2\library\gen\php;

use com\agf2\library\gen\php\api\Controller;
use com\agf2\library\gen\php\api\Logic;
use com\agf2\library\gen\php\api\Model;
use com\agf2\library\gen\php\api\Validate;
use com\agf2\struct\PHPApiResponse;

class Api
{

    public static function build(): PHPApiResponse
    {
        $response = new PHPApiResponse();
        $response->setController((new Controller)->build());
        $response->setLogic((new Logic)->build());
        $response->setModel((new Model)->build());
        $response->setValidate((new Validate)->build());
        return $response;
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/16 16:21
     */
    public static function write(): void
    {
        (new Controller)->write();
        (new Logic)->write();
        (new Model)->write();
        (new Validate)->write();
    }

    /**
     * clean
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 15:16
     */
    public static function clean(): void
    {
        (new Controller)->clean();
        (new Logic)->clean();
        (new Model)->clean();
        (new Validate)->clean();
    }

}
