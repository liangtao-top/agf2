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
// | Version: 2.0 2021/8/24 15:10
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\php\admin;

use com\agf\cg\library\Form;
use com\agf\cg\library\UploadPicture;
use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\traits\Search;
use com\agf2\util\FileUtil;
use com\agf2\util\Helper;
use Throwable;

class CssView extends LibPHPAdminAbs
{

    use Search;

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getCss()->getView();
        return $this->setTemplate($path)
                    ->replaceAll(['cssFromBody' => self::style($this->data)])
                    ->getTemplate();
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:12
     */
    public function write(): void
    {
        try {
            $this->setModule(AdminModule::CSS_VIEW);
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
            $this->setModule(AdminModule::CSS_VIEW);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * style
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 15:51
     */
    public static function style(array $data): string
    {
        // 无标题栏的样式高度补偿
        $style[]  = '#myForm {
    min-height: calc(100vh - 79px);
}';
        $is_title = false;
        Helper::each($data, function ($value) use (&$style, &$is_title) {
            $type_id = (int)$value['type_id'];
            if ($type_id === 1) {
                $is_title = true;
            }
            $style[] = match ($type_id) {
                14 => Form::pageCss($value),
                15 => UploadPicture::viewCss($value),
                default => ''
            };
        }
        );
        if ($is_title) {
            unset($style[0]);
        }
        return Helper::format($style);
    }

}
