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
  var $form = dm.customForm.var.form;
  var $submit = dm.customForm.var.submit;

  // 表单验证规则
  dm.customForm.validateConfig.rules = {##filedValidation##};
##pageJsBefore##
  // 页面加载完成后执行
  $(function () {

    // 表单验证
    $form.validate(dm.customForm.validateConfig);
    // 表单提交
    $submit.on(dm.click_event, dm.customForm.callback);
##pageJsAfter##
  });
} )(window, document, jQuery);
