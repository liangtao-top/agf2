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

use com\agf\cg\Control;
use com\agf\cg\library\Form;
use com\agf\cg\library\UploadPicture;
use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\traits\HtmlFormPHP;
use com\agf2\util\FileUtil;
use com\agf2\util\Helper;
use Throwable;

class HtmlView extends LibPHPAdminAbs
{
    use HtmlFormPHP;

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getHtml()->getView();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'formTile'        => self::tile($this->data),
                                     'formViewContent' => self::content($this->data),
                                     'vendorCss'       => self::vendorCss($this->data),
                                     'vendorJs'        => self::vendorJs($this->data),
                                 ])
                    ->getTemplate();
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:55
     */
    public function write(): void
    {
        try {
            $this->setModule(AdminModule::HTML_VIEW);
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
            $this->setModule(AdminModule::HTML_VIEW);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * content
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 15:06
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    private static function content(array &$data): string
    {
        $html     = [];
        $tabs     = $data[1]['tabs']['data'];
        $controls = $data[1]['controls'];
        foreach ($controls as $key => $value) {
            $html[] = <<<html
                <div class="col-12"><h2 class="content-divider">{$tabs[$key]['name']}</h2></div>
html;
            foreach ($value as $val) {
                $html[] = Control::parseView($val);
            }
        }
        return implode(PHP_EOL, $html);
    }

    /**
     * vendorCss
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 15:06
     */
    private static function vendorCss(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                14 => Form::vendorCss($value),
                15 => UploadPicture::vendorCss($value),
                default => '',
            };
        });
        return Helper::format($code, PHP_EOL, true, true, true, true);
    }

    /**
     * vendorJs
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 15:06
     */
    private static function vendorJs(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                14 => Form::vendorJs($value),
                default => '',
            };
        });
        return Helper::format($code);
    }

}
