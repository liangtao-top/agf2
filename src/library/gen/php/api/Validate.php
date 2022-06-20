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
// | Version: 2.0 2020/3/27 18:38
// +----------------------------------------------------------------------

namespace com\agf2\library\gen\php\api;

use com\agf2\abs\lib\LibPHPApiAbs;
use com\agf2\enum\ApiModule;
use com\agf2\exception\GenerateException;
use com\agf2\util\FileUtil;
use Throwable;

class Validate extends LibPHPApiAbs
{

    public function build(): string
    {
        $path = $this->apiConfig->getTemplate()->getPhp()->getValidate();
        return $this->setTemplate($path)->getTemplate();
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/16 15:56
     */
    public function write(): void
    {
        try {
            $this->setModule(ApiModule::VALIDATE);
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
            $this->setModule(ApiModule::VALIDATE);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }
}
