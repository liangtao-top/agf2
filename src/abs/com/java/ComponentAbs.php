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
// | Version: 2.0 2021/7/5 14:56
// +----------------------------------------------------------------------

namespace com\agf2\abs\com\java;


abstract class ComponentAbs
{

    /**
     * html抽象方法
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/31 16:26
     */
    abstract static public function html(array &$value, bool $isEdit = false): string;

    /**
     * 预览查看页的抽象方法
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/31 16:26
     */
    abstract static public function view(array &$value): string;


    /**
     * 业务类代码抽象方法
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/31 16:26
     */
    abstract static public function initialCode(array &$value): string;

    /**
     * css抽象方法(css引入)
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/31 16:26
     */
    abstract static public function vendorCss(array &$value): string;

    /**
     * css抽象方法(当前文件css)
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/31 16:26
     */
    abstract static public function pageCss(array &$value): string;

    /**
     * js抽象方法(js引入)
     * vendor_js
     * @param array $value
     * @return string
     * @author Lmb
     * @date   2020/4/1 0001 16:53
     */
    abstract static public function vendorJs(array &$value): string;

    /**
     * js抽象方法()
     * page_js_front
     * @param array $value
     * @return string
     * @author Lmb
     * @date   2020/4/1 0001 16:54
     */
    abstract static public function pageJsBefore(array &$value): string;

    /**
     * js抽象方法(页面加载完成后执行)
     * page_js_after
     * @param array $value
     * @return string
     * @author Lmb
     * @date   2020/4/1 0001 16:54
     */
    abstract static public function pageJsAfter(array &$value): string;
}
