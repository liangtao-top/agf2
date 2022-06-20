// noinspection DuplicatedCode
/**
 * +----------------------------------------------------------------------
 * | CodeEngine
 * +----------------------------------------------------------------------
 * | Copyright 艾邦
 * +----------------------------------------------------------------------
 * | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * +----------------------------------------------------------------------
 * | Author: TaoGe <liangtao.gz@foxmail.com>
 * +----------------------------------------------------------------------
 * | Date: ##date##
 * +----------------------------------------------------------------------
 */
( function (window, document, $) {
  'use strict';
##pageJsBefore##
  // 页面加载完成后执行
  $(function () {

    // 初始化mCustomScrollbar插件
    $.components.init('mCustomScrollbar');
##pageJsAfter##
  });
} )(window, document, jQuery);
