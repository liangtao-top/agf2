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
// | Version: 2.0 2022/6/17 10:42
// +----------------------------------------------------------------------
namespace com\agf2\library\gen;

use com\agf2\abs\lib\LibAbs;
use com\agf2\exception\GenerateException;
use top\liangtao\single\Singleton;
use com\agf2\util\DbUtil;
use com\agf2\util\MenuUtil;
use Exception;

class Database extends LibAbs
{
    use Singleton;

    /**
     * init
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 12:28
     */
    public function init(): void
    {
        DbUtil::createTable();
    }

    /**
     * menu
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 12:27
     */
    public function menu(): int
    {
        try {
            return MenuUtil::save();
        } catch (Exception $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * clean
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 14:59
     */
    public function clean(): void
    {
        try {
            MenuUtil::remove();
            DbUtil::deleteTable();
        } catch (Exception $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }
}
