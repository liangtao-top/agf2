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

namespace com\agf2\library\gen\php\admin;

use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\traits\HtmlFormPHP;
use com\agf2\util\FileUtil;
use Throwable;

class HtmlEdit extends LibPHPAdminAbs
{
    use HtmlFormPHP;

    public function build(): string
    {
        $html = $this->adminConfig->getTemplate()->getHtml();
        $path = self::isTabs($this->data) ? $html->getFormTabs() : $html->getForm();
        return $this->setTemplate($path)
                    ->replaceAll(self::form($this->data))
                    ->replaceAll(['formBody' => self::formBody($this->data, true)])
                    ->getTemplate();
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:54
     */
    public function write(): void
    {
        try {
            $this->setModule(AdminModule::HTML_EDIT);
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
            $this->setModule(AdminModule::HTML_EDIT);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

}
