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
// | Date: 2021/7/7 11:49
// +----------------------------------------------------------------------
namespace com\agf2\component\java;

use com\agf2\abs\com\java\ComponentAbs;
use com\agf2\abs\com\java\CssAbs;
use com\agf2\abs\com\java\HtmlAbs;
use com\agf2\abs\com\java\ImportAbs;
use com\agf2\abs\com\java\JsAbs;
use com\agf2\util\Required;

/**
 * 单位组织控件
 * @package com\agf\dp\component
 */
class Organization extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author Lmb
     * @date   2020/4/7 0007 10:28
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data = $value['formData'] ?? [];
        return match ((int)$data['typeSelection']) {
            1 => self::company($value, $isEdit),
            2 => self::dept($value, $isEdit),
            3 => self::member($value, $isEdit),
            default => '',
        };
    }

    /**
     * view
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/17 10:27
     */
    public static function view(array &$value): string
    {
        return match ((int)$value['formData']['typeSelection']) {
            1 => self::companyView($value),
            2 => self::deptView($value),
            3 => self::memberView($value),
            default => '',
        };
    }

    /**
     * 人员
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/1 17:49
     */
    private static function member(array &$value, bool $isEdit = false): string
    {
        $data       = [];   // 表单数据
        $pit_ib     = 2;    // 标题行比
        $pit_ia     = 10;   // 内容行比
        $filed      = '';   // 字段名称
        $class_name = '';   // 样式类名
        $popper     = '';   // 帮助提示
        HtmlAbs::genFormFullVarAgr($value, $data, $filed, $pit_ib, $pit_ia, $class_name, $popper);
        $required = Required::parse($data['filedValidation']);
        return <<<HTML
                <div class="form-group col-md-{$value['row']}$class_name">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label" for="$filed">{$value['title']}$required$popper</label>
                        <div class="col-sm-$pit_ia">
                            <div class="input-group">
                                {php}if(isset(\$info['$filed']) && !empty(\$info['$filed']) && is_array(\$info['$filed'])):\$names = []; foreach(\$info['$filed'] as \$value): \$names[] = \$value['name']; endforeach;\$value = implode(',',\$names);endif;{/php}
                                <input type="hidden" class="form-control empty"  name="$filed" value='{\$info.$filed|raw|default=[]|json_encode=###,JSON_UNESCAPED_UNICODE}' autocomplete="off">
                                <input type="text" class="form-control empty" id="$filed" value='{\$value|raw|default=""}'
                                       data-org-member-tree='{\$data.$filed|raw|default=[]|json_encode}' placeholder="请选择人员" readonly autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default btn-outline"><i class="icon wb-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
HTML;
    }

    /**
     * memberView
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/17 10:56
     */
    private static function memberView(array $value): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $filed  = '';   // 字段名称
        HtmlAbs::genFormVarAgr($value, $data, $filed, $pit_ib, $pit_ia);
        return <<<html
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}</label>
                        <div class="col-sm-$pit_ia">
                            {php}if(isset(\$info['$filed']) && !empty(\$info['$filed']) && is_array(\$info['$filed'])):\$names = []; foreach(\$info['$filed'] as \$value): \$names[] = \$value['name']; endforeach;\$value = implode(',',\$names);endif;{/php}
                            <span class="view-content">{\$value|raw|default=""}</span>
                        </div>
                    </div>
                </div>
html;
    }

    /**
     * 部门
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/1 17:50
     */
    private static function dept(array $value, bool $isEdit = false): string
    {
        $data       = [];   // 表单数据
        $pit_ib     = 2;    // 标题行比
        $pit_ia     = 10;   // 内容行比
        $filed      = '';   // 字段名称
        $class_name = '';   // 样式类名
        $popper     = '';   // 帮助提示
        HtmlAbs::genFormFullVarAgr($value, $data, $filed, $pit_ib, $pit_ia, $class_name, $popper);
        $required = Required::parse($data['filedValidation']);
        return <<<html
                <div class="form-group col-md-{$value['row']} $class_name">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label" for="$filed">{$value['title']}$required$popper</label>
                        <div class="col-sm-$pit_ia">
                            <div class="input-group">
                                {php}if(isset(\$info['$filed']) && !empty(\$info['$filed']) && is_array(\$info['$filed'])):\$dept_names = []; foreach(\$info['$filed'] as \$value): \$dept_names[] = \$value['name']; endforeach;\$dept_value = implode(',',\$dept_names);endif;{/php}
                                <input type="hidden" class="form-control empty"  name="$filed" value='{\$info.$filed|raw|default=[]|json_encode=###,JSON_UNESCAPED_UNICODE}' autocomplete="off">
                                <input type="text" class="form-control empty" id="$filed" value='{\$dept_value|raw|default=""}'
                                       data-org-member-tree='{\$data.$filed|raw|default=[]|json_encode}' placeholder="请选择部门" readonly autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default btn-outline"><i class="icon wb-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
html;
    }

    /**
     * deptView
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/17 10:54
     */
    private static function deptView(array $value): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $filed  = '';   // 字段名称
        HtmlAbs::genFormVarAgr($value, $data, $filed, $pit_ib, $pit_ia);
        return <<<html
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}</label>
                        <div class="col-sm-$pit_ia">
                            {php}if(isset(\$info['$filed']) && !empty(\$info['$filed']) && is_array(\$info['$filed'])):\$dept_names = []; foreach(\$info['$filed'] as \$value): \$dept_names[] = \$value['name']; endforeach;\$dept_value = implode(',',\$dept_names);endif;{/php}
                            <span class="view-content">{\$dept_value|raw|default=""}</span>
                        </div>
                    </div>
                </div>
html;
    }

    /**
     * 公司
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/6/1 17:50
     * @noinspection HtmlUnknownAttribute
     */
    private static function company(array $value, bool $isEdit = false): string
    {
        $data       = [];   // 表单数据
        $pit_ib     = 2;    // 标题行比
        $pit_ia     = 10;   // 内容行比
        $filed      = '';   // 字段名称
        $class_name = '';   // 样式类名
        $popper     = '';   // 帮助提示
        HtmlAbs::genFormFullVarAgr($value, $data, $filed, $pit_ib, $pit_ia, $class_name, $popper);
        $required = Required::parse($data['filedValidation']);
        return '                <div class="form-group col-md-' . $value['row'] . ' ' . $class_name . '">
                    <div class="row">
                        <label class="col-sm-' . $pit_ib . ' col-form-label">' . $value['title'] . $required . $popper . '</label>
                        <div class="col-sm-' . $pit_ia . '">
                            <select id="' . $filed . '" name="' . $filed . '" class="form-control" data-plugin="selectpicker">
                            {if isset($data.' . $filed . ') && !empty($data.' . $filed . ') }
                            {foreach $data.' . $filed . ' as $key=>$vo }
                            {php}$selected=\'\';if(isset($info[\'' . $filed . '\'])):if($info[\'' . $filed . '\'] == $vo[\'id\']):$selected=\'selected\';endif;endif;{/php}
                                <option {$selected} value="{$vo.id}">{$vo.name}</option>
                            {/foreach}
                            {/if}
                            </select>
                        </div>
                    </div>
                </div>';
    }

    /**
     * companyView
     * @param array $value
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/6/17 10:49
     * @noinspection DuplicatedCode
     */
    private static function companyView(array $value): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $filed  = '';   // 字段名称
        HtmlAbs::genFormVarAgr($value, $data, $filed, $pit_ib, $pit_ia);
        return '                <div class="form-group col-md-' . $value['row'] . '">
                    <div class="row">
                        <label class="col-sm-' . $pit_ib . ' col-form-label">' . $value['title'] . '</label>
                        <div class="col-sm-' . $pit_ia . '">
                            {if isset($data.' . $filed . ') && !empty($data.' . $filed . ') }
                            {foreach $data.' . $filed . ' as $key=>$vo }
                            {php}if(isset($info[\'' . $filed . '\'])):if($info[\'' . $filed . '\'] == $vo[\'id\']):{/php}
                            <span class="view-content">{$vo.name}</span>
                            {php}endif;endif;{/php}
                            {/foreach}
                            {/if}
                        </div>
                    </div>
                </div>';
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 12:15
     */
    public static function pageCss(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $className = HtmlAbs::genClassName($value);
        $style     = [];
        switch ((int)$value['formData']['typeSelection']) {
            case 1:
                $style[] = <<<style
.$className > .row li.disabled a{
    cursor: default !important;
    color: #76838f;
}
.$className > .row li a span.icon{
    margin-right: 4px;
}
style;
                break;
            case 2:
            case 3:
                $style[] = <<<style
.$className .input-group-append{
    background-color: white;
}
#$btf {
    background-color: white;
}
.modal .pagetree {
    height: 200px;
    overflow: hidden;
}
.modal .jstree-selected:after {
    display: inline;
    content: "";
    font-family: "Web Icons", sans-serif;
    color: #79b2fc;
    margin-left: 10px;
}
.modal .view-box {
    padding: 10px;
    border: solid 1px #e4eaec;
    border-radius: 0.215rem;
}
.modal .list-group-item {
    padding: 4px 20px 4px 10px;
    border-radius: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    position: relative;
}
.modal .list-group-item .icon {
    color: #ccd5db;
}
.modal .list-group-item .wb-close {
    display: none;
    position: absolute;
    top: 9px;
    right: 0;
    font-size: 12px;
}
.modal .list-group-item .wb-close:hover {
    color: #ff666b;
}
.modal .list-group-item:hover .wb-close {
    display: block;
}
.modal .checkbox-custom.checkbox-inline {
    margin: 0 20px 5px 0;
}
style;
                break;
        }
        $popover = CssAbs::genPopoverVarAgr($value);
        if (!empty($popover)) {
            $style[] = $popover;
        }
        return implode(PHP_EOL, $style);
    }

    /**
     * vendorCss
     * @param array $value
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/7/7 12:03
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public static function vendorCss(array &$value): string
    {
        $import = '';
        switch ((int)$value['formData']['typeSelection']) {
            case 1:
                $import = ImportAbs::css('/assets/vendor/bootstrap-select/bootstrap-select.css');
                break;
            case 2:
            case 3:
                $import = ImportAbs::css(['/assets/vendor/jstree/jstree.css', '/assets/fonts/font-awesome/font-awesome.css']);
                break;
            default:
        }
        return $import;
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/7/7 12:03
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public static function vendorJs(array &$value): string
    {
        $md5    = md5(json_encode($value));
        $import = '';
        switch ((int)$value['formData']['typeSelection']) {
            case 1:
                $import = ImportAbs::js('/assets/vendor/bootstrap-select/bootstrap-select.min.js');
                break;
            case 2:
                $import = <<<html
    <script th:src="@{/assets/vendor/jstree/jstree.min.js}"></script>
    <div class="modal fade" id="inviteModal_{$md5}" data-backdrop="static" data-keyboard="false" aria-hidden="false" aria-labelledby="inviteModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">选择成员</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group btn-group-sm mb-10" id="userTreeType_{$md5}">
                                    <button class="btn btn-default btn-outline active" data-type="pos">按部门</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-search">
                                    <button type="submit" class="input-search-btn btn-sm">
                                        <i class="icon wb-search" aria-hidden="true"></i>
                                    </button>
                                    <input type="text" class="form-control form-control-sm" id="userTreeSearch_{$md5}" name="" placeholder="查找成员">
                                </div>
                            </div>
                        </div>
                        <div id="treeTypeView_{$md5}">
                            <div class="party-tree mt-10 h-250" data-target="pos" data-plugin="mCustomScrollbar">
                                <div class="type-tree" id="posTreeView_{$md5}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="party-selected">
                            <p class="pl-10 mt-3">已选择的部门：</p>
                            <div class="h-250 mt-20" data-plugin="mCustomScrollbar">
                                <div class="list-group list-group-full" id="selectedMember_{$md5}"></div>
                            </div>
                            <script id="selectedMemberTpl_{$md5}" type="text/html">
                                <% for(var i = 0; i < personLists.length; i++){ %>
                                <% var person = personLists[i]; %>
                                <a class="list-group-item" href="javascript:void(0);" id="<%= person.id %>">
                                    <i class="icon fa-building-o"></i><%= person.name %>
                                    <i class="icon wb-close float-right del-selected"></i>
                                </a>
                                <% } %>
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveMember_{$md5}">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
    </div>
html;
                break;
            case 3:
                $import = <<<html
    <script th:src="@{/assets/vendor/jstree/jstree.min.js}"></script>
    <div class="modal fade" id="inviteModal_{$md5}" data-backdrop="static" data-keyboard="false" aria-hidden="false" aria-labelledby="inviteModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">选择成员</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group btn-group-sm mb-10" id="userTreeType_{$md5}">
                                    <button class="btn btn-default btn-outline active" data-type="pos">按部门</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-search">
                                    <button type="submit" class="input-search-btn btn-sm">
                                        <i class="icon wb-search" aria-hidden="true"></i>
                                    </button>
                                    <input type="text" class="form-control form-control-sm" id="userTreeSearch_{$md5}" name="" placeholder="查找成员">
                                </div>
                            </div>
                        </div>
                        <div id="treeTypeView_{$md5}">
                            <div class="party-tree mt-10 h-250" data-target="pos" data-plugin="mCustomScrollbar">
                                <div class="type-tree" id="posTreeView_{$md5}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="party-selected">
                            <p class="pl-10 mt-3">已选择的成员：</p>
                            <div class="h-250 mt-20" data-plugin="mCustomScrollbar">
                                <div class="list-group list-group-full" id="selectedMember_{$md5}"></div>
                            </div>
                            <script id="selectedMemberTpl_{$md5}" type="text/html">
                                <% for(var i = 0; i < personLists.length; i++){ %>
                                <% var person = personLists[i]; %>
                                <a class="list-group-item" href="javascript:void(0);" id="<%= person.id %>">
                                    <i class="icon wb-user"></i><%= person.name %>
                                    <i class="icon wb-close float-right del-selected"></i>
                                </a>
                                <% } %>
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveMember_{$md5}">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
    </div>
html;
                break;
            default:
        }
        return $import;
    }

    /**
     * pageJsBefore
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 12:16
     */
    public static function pageJsBefore(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $md5 = md5(json_encode($value));
        return match ((int)$data['typeSelection']) {
            1 => '',
            2 => <<<TEXT
  // 单位组织[部门]类型控件
  var org_control_{$md5} = function () {
    var \$e = $('#{$btf}');
    var \$button = \$e.next().find('button');
    var \$modal = $('#inviteModal_{$md5}');
    var \$memberTree = \$modal.find('#posTreeView_{$md5}');
    var \$userTreeSearch = \$modal.find('#userTreeSearch_{$md5}');
    var \$selectedMember = \$modal.find('#selectedMember_{$md5}');
    var \$saveMember = \$modal.find('#saveMember_{$md5}');
    var memberDepTree = null;
    // 加壳处理
    var outerSurface = function (value) {
      value.dataIds = null;
      if (typeof value.li_attr === 'undefined') {
        value.li_attr = {nodeId: String(value.id)};
        delete value.id;
        delete value.pid;
      }
      if (_.isArray(value.children)) {
        _.map(value.children, function (v) {
          v.li_attr = {nodeId: value.li_attr.nodeId + '_' + String(v.id)};
          delete v.id;
          delete v.pid;
          if (_.isArray(v.children)) {
            outerSurface(v);
          }
        });
      } else if (_.isObject(value.children)) {
        var data = [];
        _.forEach(value.children, function (v) {
          v.li_attr = {nodeId: value.li_attr.nodeId + '_' + String(v.id)};
          delete v.id;
          delete v.pid;
          if (_.isObject(v.children)) {
            v = outerSurface(v);
          }
          data.push(v);
        });
        value.children = data;
      }
      return value;
    }
    // 选中成员过滤函数
    var memberFilter = function (members, persons) {
      var callback = function fn(m, p) {
        $.each(p, function (i, n) {
          // 当前节点id等于选中成员id时
          if (n.li_attr.nodeId === m.id) {
            n.state = {selected: true};
          }
          // 当前节点有子节点时
          if (n.children) {
            fn(m, n.children);
          }
        });
      };

      // 遍历当前角色下成员
      $.each(members, function (i, n) {
        callback(n, persons);
      });
      return persons;
    };
    // 已选成员UI渲染
    var selectedMemberDraw = function (node) {
      var data;
      var html;
      var result = false;

      // 选中渲染成员
      if (!node.personLists) {
        \$selectedMember.find('a').each(function () {
          if ($(this).attr('id') === node.li_attr.nodeId) {
            result = true;
          }
        });

        if (result) {
          return;
        }

        data = {
          personLists: [
            {
              id: node.li_attr.nodeId,
              name: node.text
            }
          ]
        };
        html = template('selectedMemberTpl_{$md5}', data);
        \$selectedMember.append(html);
      } else {
        // 初次渲染成员
        html = template('selectedMemberTpl_{$md5}', node);
        \$selectedMember.html(html);
      }
    };
    // 改变成员树节点状态
    var changeTreeMember = function (node, type, status) {
      var callback = function (n) {
        var childNode;
        childNode = memberDepTree.get_node(n);
        // 当前节点没有子节点时
        if (childNode.children.length === 0) {
          selectMember(childNode, type, status);
        } else {
          changeTreeMember(childNode, type, status);
        }
      };

      if (node.children.length > 0) {
        // 当前节点有子节点时
        $.each(node.children, function (i, n) {
          callback(n);
        });
      } else if (node.children.length === 0) {
        // 当前节点没有子节点时
        selectMember(node, type, status);
      }
    };
    // 选中一个树节点添加到成员列表
    var selectMember = function (node, type, status) {
      if (status === 'select_node') {
        // 当前选中项不是成员时
        if (node.type !== 'default') {
          return;
        }
        // 渲染选中成员列表
        selectedMemberDraw(node);
        // 选中部门树的成员
        \$memberTree
          .find('[nodeid="' + node.li_attr.nodeId + '"]')
          .each(function () {
            var \$item = $(this);
            memberDepTree.get_node(\$item) &&
            !memberDepTree.is_selected(\$item) &&
            memberDepTree.select_node(\$item);
          });
      } else if (status === 'deselect_node') {
        // 取消部门树的成员选中
        \$memberTree
          .find('[nodeid="' + node.li_attr.nodeId + '"]')
          .each(function () {
            var \$item = $(this);
            memberDepTree.get_node(\$item) &&
            memberDepTree.is_selected(\$item) &&
            memberDepTree.deselect_node(\$item);
          });
        \$selectedMember
          .children('#' + node.li_attr.nodeId)
          .remove();
      }
    };
    // 成员树渲染
    var memberTree = function (membersData) {
      // 按部门渲染树
      \$memberTree
        .jstree('destroy')
        .jstree({
          types: {
            U: {
              icon: 'fa-child'
            },
            D: {
              icon: 'fa-folder-o'
            },
            C: {
              icon: 'fa-building-o'
            }
          },
          checkbox: {
            keep_selected_style: false
          },
          search: {
            show_only_matches: true,
            show_only_matches_children: true
          },
          plugins: ['types', 'wholerow', 'search', 'checkbox'],
          core: {
            data: function (obj, callback) {
              var data = \$e.data('orgMemberTree');
              if (data.length && typeof data[ 0 ].li_attr === "undefined") {
                _.map(data, function (value) {
                  value.type = 'D';
                  outerSurface(value);
                });
              }
              // 将选中项包装到当前树data中
              var json = memberFilter(membersData, data);
              callback.call(this, json);
            }
          }
        })
        .on('ready.jstree', function () {
          memberDepTree = $(this).jstree(true);
          memberDepTree.open_all();
        })
        .on('changed.jstree', function (event, obj) {
          if (obj.action !== 'select_node' && obj.action !== 'deselect_node') {
            return;
          }
          changeTreeMember(obj.node, 'dep', obj.action);
        });
    };
    // 加载角色对应成员
    var memberDraw = function () {
      var data = \$e.prev().val();
      data = JSON.parse(data);
      // 绘制选中成员
      selectedMemberDraw({personLists: data});
      // 加载成员树
      memberTree(data);
    };

    \$button.on(dm.click_event, function () {
      \$modal.modal('show');
    });

    // 成员MODAL显示后 --- 添加成员MODAL
    \$modal.on('show.bs.modal', function () {
      memberDraw();
    });

    // 按角色或部门搜索成员 --- 添加成员MODAL中
    \$userTreeSearch.on('keyup', function () {
      var \$item = $(this);
      \$memberTree.jstree(true).search(\$item.val());
    });

    // 删除选中成员 --- 添加成员MODAL中
    \$selectedMember.on(dm.click_event, '.del-selected', function () {
      var \$item = $(this);
      var memberId = \$item.parent().attr('id');

      \$item.parent().remove();

      // 取消按角色成员树和按部门角色树种的成员选中项
      \$memberTree
        .find('[nodeid="' + memberId + '"]')
        .each(function () {
          memberDepTree.deselect_node($(this));
        });
    });

    // 保存选中成员 --- 添加成员MODAL中
    \$saveMember.on(dm.click_event, function () {
      var names = [];
      var users = [];
      \$selectedMember
        .children('a')
        .each(function () {
          var id = $(this).attr('id');
          var text = $(this).text().replace(/[\\r\\n ]/g, "");
          names.push(text);
          users.push({id: id, name: text});
        });
      names = dm.helper.array_unique(names);
      users = dm.helper.array_unique(users);
      \$e.prev().val(JSON.stringify(users));
      \$e.val(names.join(','));
      \$modal.modal('hide');
    });
  };
TEXT,
            default => <<<TEXT
  // 单位组织[人员]类型控件
  var org_control_{$md5} = function () {
    var \$e = $('#{$btf}');
    var \$button = \$e.next().find('button');
    var \$modal = $('#inviteModal_{$md5}');
    var \$memberTree = \$modal.find('#posTreeView_{$md5}');
    var \$userTreeSearch = \$modal.find('#userTreeSearch_{$md5}');
    var \$selectedMember = \$modal.find('#selectedMember_{$md5}');
    var \$saveMember = \$modal.find('#saveMember_{$md5}');
    var memberDepTree = null;
    // 加壳处理
    var outerSurface = function (value) {
      value.dataIds = null;
      if (typeof value.li_attr === 'undefined') {
        value.li_attr = {nodeId: String(value.id)};
        delete value.id;
        delete value.pid;
      }
      if (_.isArray(value.children)) {
        _.map(value.children, function (v) {
          v.li_attr = {nodeId: value.li_attr.nodeId + '_' + String(v.id)};
          delete v.id;
          delete v.pid;
          if (_.isArray(v.children)) {
            outerSurface(v);
          }
        });
      } else if (_.isObject(value.children)) {
        var data = [];
        _.forEach(value.children, function (v) {
          v.li_attr = {nodeId: value.li_attr.nodeId + '_' + String(v.id)};
          delete v.id;
          delete v.pid;
          if (_.isObject(v.children)) {
            v = outerSurface(v);
          }
          data.push(v);
        });
        value.children = data;
      }
      return value;
    }
    // 选中成员过滤函数
    var memberFilter = function (members, persons) {
      var callback = function fn(m, p) {
        $.each(p, function (i, n) {
          // 当前节点id等于选中成员id时
          if (n.li_attr.nodeId === m.id) {
            n.state = {selected: true};
          }
          // 当前节点有子节点时
          if (n.children) {
            fn(m, n.children);
          }
        });
      };

      // 遍历当前角色下成员
      $.each(members, function (i, n) {
        callback(n, persons);
      });
      return persons;
    };
    // 已选成员UI渲染
    var selectedMemberDraw = function (node) {
      var data;
      var html;
      var result = false;

      // 选中渲染成员
      if (!node.personLists) {
        \$selectedMember.find('a').each(function () {
          if ($(this).attr('id') === node.li_attr.nodeId) {
            result = true;
          }
        });

        if (result) {
          return;
        }

        data = {
          personLists: [
            {
              id: node.li_attr.nodeId,
              name: node.text
            }
          ]
        };
        html = template('selectedMemberTpl_{$md5}', data);
        \$selectedMember.append(html);
      } else {
        // 初次渲染成员
        html = template('selectedMemberTpl_{$md5}', node);
        \$selectedMember.html(html);
      }
    };
    // 改变成员树节点状态
    var changeTreeMember = function (node, type, status) {
      var callback = function (n) {
        var childNode;
        childNode = memberDepTree.get_node(n);
        // 当前节点没有子节点时
        if (childNode.children.length === 0) {
          selectMember(childNode, type, status);
        } else {
          changeTreeMember(childNode, type, status);
        }
      };

      if (node.children.length > 0) {
        // 当前节点有子节点时
        $.each(node.children, function (i, n) {
          callback(n);
        });
      } else if (node.children.length === 0) {
        // 当前节点没有子节点时
        selectMember(node, type, status);
      }
    };
    // 选中一个树节点添加到成员列表
    var selectMember = function (node, type, status) {
      if (status === 'select_node') {
        // 当前选中项不是成员时
        if (node.type !== 'U') {
          return;
        }
        // 渲染选中成员列表
        selectedMemberDraw(node);
        // 选中部门树的成员
        \$memberTree
          .find('[nodeid="' + node.li_attr.nodeId + '"]')
          .each(function () {
            var \$item = $(this);
            memberDepTree.get_node(\$item) &&
            !memberDepTree.is_selected(\$item) &&
            memberDepTree.select_node(\$item);
          });
      } else if (status === 'deselect_node') {
        // 取消部门树的成员选中
        \$memberTree
          .find('[nodeid="' + node.li_attr.nodeId + '"]')
          .each(function () {
            var \$item = $(this);
            memberDepTree.get_node(\$item) &&
            memberDepTree.is_selected(\$item) &&
            memberDepTree.deselect_node(\$item);
          });
        \$selectedMember
          .children('#' + node.li_attr.nodeId)
          .remove();
      }
    };
    // 成员树渲染
    var memberTree = function (membersData) {
      // 按部门渲染树
      \$memberTree
        .jstree('destroy')
        .jstree({
          types: {
            U: {
              icon: 'fa-child'
            },
            D: {
              icon: 'fa-folder-o'
            },
            C: {
              icon: 'fa-building-o'
            }
          },
          checkbox: {
            keep_selected_style: false
          },
          search: {
            show_only_matches: true,
            show_only_matches_children: true
          },
          plugins: ['types', 'wholerow', 'search', 'checkbox'],
          core: {
            data: function (obj, callback) {
              var data = \$e.data('orgMemberTree');
              if (data.length && typeof data[ 0 ].li_attr === "undefined") {
                _.map(data, function (value) {
                  value.type = 'D';
                  outerSurface(value);
                });
              }
              // 将选中项包装到当前树data中
              var json = memberFilter(membersData, data);
              callback.call(this, json);
            }
          }
        })
        .on('ready.jstree', function () {
          memberDepTree = $(this).jstree(true);
          memberDepTree.open_all();
        })
        .on('changed.jstree', function (event, obj) {
          if (obj.action !== 'select_node' && obj.action !== 'deselect_node') {
            return;
          }
          changeTreeMember(obj.node, 'dep', obj.action);
        });
    };
    // 加载角色对应成员
    var memberDraw = function () {
      var data = \$e.prev().val();
      data = JSON.parse(data);
      // 绘制选中成员
      selectedMemberDraw({personLists: data});
      // 加载成员树
      memberTree(data);
    };

    \$button.on(dm.click_event, function () {
      \$modal.modal('show');
    });

    // 成员MODAL显示后 --- 添加成员MODAL
    \$modal.on('show.bs.modal', function () {
      memberDraw();
    });

    // 按角色或部门搜索成员 --- 添加成员MODAL中
    \$userTreeSearch.on('keyup', function () {
      var \$item = $(this);
      \$memberTree.jstree(true).search(\$item.val());
    });

    // 删除选中成员 --- 添加成员MODAL中
    \$selectedMember.on(dm.click_event, '.del-selected', function () {
      var \$item = $(this);
      var memberId = \$item.parent().attr('id');

      \$item.parent().remove();

      // 取消按角色成员树和按部门角色树种的成员选中项
      \$memberTree
        .find('[nodeid="' + memberId + '"]')
        .each(function () {
          memberDepTree.deselect_node($(this));
        });
    });

    // 保存选中成员 --- 添加成员MODAL中
    \$saveMember.on(dm.click_event, function () {
      var names = [];
      var users = [];
      \$selectedMember
        .children('a')
        .each(function () {
          var id = $(this).attr('id');
          var text = $(this).text().replace(/[\\r\\n ]/g, "");
          names.push(text);
          users.push({id: id, name: text});
        });
      names = dm.helper.array_unique(names);
      users = dm.helper.array_unique(users);
      \$e.prev().val(JSON.stringify(users));
      \$e.val(names.join(','));
      \$modal.modal('hide');
    });
  };
TEXT,
        };
    }

    /**
     * pageJsAfter
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 12:11
     */
    public static function pageJsAfter(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $md5 = md5(json_encode($value));
        switch ((int)$data['typeSelection']) {
            case 1:
                $js[] = <<<TEXT
    // 初始化单位组织[公司]类型控件
    $('#$btf').selectpicker($.concatCpt('selectpicker'));
TEXT;
                break;
            case 2:
                $js[] = <<<script
    // 初始化单位组织[部门]类型控件
    org_control_$md5();
script;
                break;
            case 3:
                $js[] = <<<script
    // 初始化单位组织[人员]类型控件
    org_control_$md5();
script;
                break;
            default:
                $js = [];
        }
        $popover = JsAbs::genPopoverVarAgr($value);
        if (!empty($popover)) {
            $js[] = $popover;
        }
        return implode(PHP_EOL, $js);
    }

    /**
     * initialCode
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 12:13
     */
    public static function initialCode(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        return match ((int)$data['typeSelection']) {
            1 => <<<TEXT
        \$logic  = new \app\admin\logic\base\Company;
        if (\$logic->getCompany()) {
            \$data['{$btf}'] = \$logic->getResult();
        }
TEXT,
            2 => <<<TEXT
        \$logic = new \app\admin\logic\base\AuthRole;
        if (\$logic->getOrgTree(request())) {
            \$data['{$btf}'] = \$logic->getResult();
        }
TEXT,
            3 => <<<TEXT
        \$logic = new \app\admin\logic\base\AuthRole;
        if (\$logic->getOrgMemberTree(request())) {
            \$data['{$btf}'] = \$logic->getResult();
        }
TEXT,
            default => '',
        };
    }
}
