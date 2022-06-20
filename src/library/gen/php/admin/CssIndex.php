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

use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\traits\Search;
use com\agf2\util\FileUtil;
use com\agf2\util\Helper;
use Throwable;

class CssIndex extends LibPHPAdminAbs
{

    use Search;

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getCss()->getIndex();
        return $this->setTemplate($path)
                    ->replaceAll(['indexCss' => self::style($this->data)])
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
            $this->setModule(AdminModule::CSS_INDEX);
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
            $this->setModule(AdminModule::CSS_INDEX);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * 首页Css(搜索用)
     * @param array $data
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/8/24 15:54
     * @noinspection DuplicatedCode
     */
    private static function style(array &$data): string
    {
        $code = [];
        self::each($data, function ($value, $field) use (&$code) {
            switch ((int)$field['type_id']) {
                case 5:
                case 6:
                case 7:
                    $selectType = isset($field['formData']['selectType']) ? (int)$field['formData']['selectType'] : 0;
                    $code[]     = $selectType === 1 ? '
#' . $field['formData']['bindTableFiled'] . '_PC_SEARCH + span.select2 {
    display: inline-block;
}
' : '';
                    break;
            }
        });
        return Helper::format($code);
    }

}
