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
  "dm" in window || ( window.dm = {} );
  'bootstrapTable' in dm || ( dm.bootstrapTable = {} );
  'operateEvents' in dm.bootstrapTable || ( dm.bootstrapTable.operateEvents = {} );
  var $table = $('#table');
##beforeIndexJs##
##beforeJsBootstrapTableOperating##
  // 页面加载完成后执行
  $(function () {
##afterIndexJs##
##toolbarVarButton##
    // noinspection JSUnresolvedFunction,JSUnusedLocalSymbols
    $table.bootstrapTable('destroy').bootstrapTable(_.assign(dm.bootstrapTable.config, {
      columns: [
        {
          field: 'state',
          checkbox: true,
          rowspan: 1,
          align: 'center',
          valign: 'middle',
          printIgnore:true
        }##bootstrapTableColumns##, {
          field: 'status',
          title: '状态',
          align: 'center',
          valign: 'middle',
          width: '67',
          class: 'text-truncate',
          visible: true,
          sortable: true,
          printIgnore: false,
          formatter: function (data) {
            return data ? '<span class="badge badge-success">正常</span>' : '<span class="badge badge-danger">禁用</span>';
          },
          printFormatter: function (data) {
            return data ? '正常' : '禁用';
          }
        }, {
          field: 'createTime',
          title: '创建时间',
          align: 'left',
          valign: 'middle',
          width: '153',
          class: 'text-truncate',
          visible: true,
          sortable: true,
          printIgnore: false,
          formatter: function (data) {
            return data === 0 ? '-' : dm.helper.date('Y-m-d H:i:s',data * 1000);
          },
          printFormatter: function (data) {
            return data === 0 ? '-' : dm.helper.date('Y-m-d H:i:s',data * 1000);
          }
        }, {
          field: 'updateTime',
          title: '最近修改',
          align: 'left',
          valign: 'middle',
          width: '153',
          class: 'text-truncate',
          visible: true,
          sortable: true,
          printIgnore: false,
          formatter: function (data) {
            return data === 0 ? '-' : dm.helper.date('Y-m-d H:i:s',data * 1000);
          },
          printFormatter: function (data) {
            return data === 0 ? '-' : dm.helper.date('Y-m-d H:i:s',data * 1000);
          }
        }##bootstrapTableOperating##
      ]
    }));
  });
} )(window, document, jQuery);
