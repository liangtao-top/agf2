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
// | Version: 2.0 2021/8/20 17:36
// +----------------------------------------------------------------------
namespace com\agf2\abs\lib;

use com\agf2\library\Config;
use RuntimeException;

abstract class LibAbs
{

    /**
     * 待编译的原始数据
     * @var array
     */
    protected array $data;


    protected string $region;
    protected string $functionName;
    protected string $dir;
    protected string $className;
    protected string $tableName;
    protected string $output;
    protected string $functionClassName;
    protected string $fileName;
    protected string $content;

    /**
     * 模板
     * @var string
     */
    private string $template;

    protected function __construct()
    {
        $this->data              = Config::instance()->getData();
        $this->tableName         = $this->data[0]['selected'][0]['name'];
        $this->className         = $this->data[4]['functionalClassName'];
        $this->functionClassName = parse_name($this->data[4]['functionalClassName']);
        $this->region            = strtolower($this->data[4]['outputRegion']);
        $this->functionName      = $this->data[4]['functionDescription'];
        $this->tableName         = config('core.prefix') . $this->tableName;
        $this->className         = parse_name($this->className, 1, true);
    }

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * setTemplate
     * @param string $path
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 9:39
     */
    protected function setTemplate(string $path): self
    {
        if (empty($path)) {
            throw new  RuntimeException('模板路径不能为空！');
        }
        if (!file_exists($path)) {
            throw new  RuntimeException($path . ' 模板文件不存在！');
        }
        $this->template = file_get_contents($path);
        $this->replaceAll([
                              'date'           => date('Y-m-d H:i:s'),
                              'region'         => $this->region,
                              'className'      => $this->className,
                              'tableName'      => $this->tableName,
                              'functionName'   => $this->functionName,
                              'parseClassName' => parse_name($this->className),
                          ]);
        return $this;
    }

    /**
     * 批量替换
     * @param array $array
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 10:14
     */
    protected function replaceAll(array $array): self
    {
        foreach ($array as $key => $value) {
            if (is_string($key) && !empty($key)) {
                $this->template = str_replace('##' . $key . '##', $value, $this->template);
            }
        }
        return $this;
    }

}
