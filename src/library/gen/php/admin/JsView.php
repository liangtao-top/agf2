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
// | Version: 2.0 2021/8/24 16:14
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\php\admin;

use com\agf\cg\library\Form;
use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\util\FileUtil;
use com\agf2\util\Helper;
use Throwable;

class JsView extends LibPHPAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getJs()->getView();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'pageJsAfter'  => self::afterJs($this->data),
                                     'pageJsBefore' => self::beforeJs($this->data),
                                 ])
                    ->getTemplate();
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:57
     */
    public function write(): void
    {
        try {
            $this->setModule(AdminModule::JS_VIEW);
            FileUtil::write($this->getFileName(), $this->getContent());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * clean
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 15:11
     */
    public function clean(): void
    {
        try {
            $this->setModule(AdminModule::JS_VIEW);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * afterJs
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 17:02
     */
    private static function afterJs(array $data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                14 => Form::pageJsAfter($value),
                default => '',
            };
        });
        return Helper::format($code);
    }

    /**
     * beforeJs
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 17:02
     */
    private static function beforeJs(array $data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                14 => Form::pageJsBefore($value),
                default => '',
            };
        });
        return Helper::format($code);
    }
}
