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
// | Version: 2.0 2020/3/28 18:33
// +----------------------------------------------------------------------
declare (strict_types=1);

namespace com\agf2\abs\com\java;

abstract class ViewAbs
{

    public static function baseHtml(array &$value): string
    {
        $d = [];
        $b = 2;
        $a = 10;
        $f = '';
        HtmlAbs::genFormVarAgr($value, $d, $f, $b, $a);
        $v = '[[${info?.' . $f . '}]]';
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$b col-form-label">{$value['title']}</label>
                        <div class="col-sm-$a">
                            <span class="view-content">$v</span>
                        </div>
                    </div>
                </div>
HTML;
    }

    public static function articleHtml(array &$value): string
    {
        $d = [];
        $b = 2;
        $a = 10;
        $f = '';
        HtmlAbs::genFormVarAgr($value, $d, $f, $b, $a);
        $v = 'th:utext="${info?.' . $f . '}"';
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$b col-form-label">{$value['title']}</label>
                        <div class="col-sm-$a">
                            <article class="view-article" $v></article>
                        </div>
                    </div>
                </div>
HTML;
    }

    public static function optionHtml(array &$value, bool $isMultiple = false): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        HtmlAbs::genFormVarAgr($value, $data, $btf, $pit_ib, $pit_ia);
        $ds = 0;    // 数据来源
        $sf = '';   // 保存字段
        $df = '';   // 展示字段
        HtmlAbs::GenTripartiteVarAgr($value, $ds, $sf, $df);
        if ($ds === 1) {
            $val    = '$key';
            $option = '$vo';
        } else {
            $val    = '$vo[\'' . $sf . '\']';
            $option = '$vo.' . $df;
        }
        if ($isMultiple) {
            $if = ' th:if="${info?.' . $btf . ' != \'\' ? #lists.contains(info?.' . $btf . ', vo.key) : vo.key == \'' . ($data['defaultValue'] ?? '') . '\'}"';
        } else {
            $if = ' th:if="${info?.' . $btf . ' != \'\' ? vo.key == info?.' . $btf . '+\'\' : vo.key == \'' . ($data['defaultValue'] ?? '') . '\'}"';
        }
        return '                <div class="form-group col-md-' . $value['row'] . '">
                    <div class="row">
                        <label class="col-sm-' . $pit_ib . ' col-form-label">' . $value['title'] . '</label>
                        <div class="col-sm-' . $pit_ia . '">
                        <th:block th:each="vo:${data?.' . $btf . '}">
                            <span class="view-content" ' . $if . '>[[${vo.value}]]</span>  
                        </th:block>
                        </div>
                    </div>
                </div>';
    }

    public static function fileHtml(array &$value): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        HtmlAbs::genFormVarAgr($value, $data, $btf, $pit_ib, $pit_ia);
        $enclosure_action = '<ul class="attachment-view">
                                <th:block th:each="vo,key:${info?.' . $btf . '}">
                                <li class="item" th:data-key="${key?.index}" th:data-id="${vo?.id}">
                                    <span class="float-left">[[${vo.name}]]</span>
                                    <a th:download="${vo.name}" target="_blank" class="float-right" th:href="@{${vo?.url}}">
                                        <i class="icon wb-download" aria-hidden="true"></i> 下载
                                    </a>
                                    <a target="_blank" class="float-right" th:href="@{${vo?.url}}">
                                        <i class="icon wb-eye" aria-hidden="true"></i> 预览
                                    </a>
                                </li>
                                </th:block>
                            </ul>';
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}</label>
                        <div class="col-sm-$pit_ia">
                            $enclosure_action
                        </div>    
                    </div>
                </div>
HTML;
    }

    public static function pictureHtml(array &$value): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        HtmlAbs::genFormVarAgr($value, $data, $btf, $pit_ib, $pit_ia);
        $enclosureAction = '<ul class="jquery-picture-upload-view">
                                <th:block th:each="vo,key:${info?.' . $btf . '}">
                                <li class="item">
                                    <a target="_blank" class="float-left" th:href="@{${vo?.url}}">
                                        <img th:src="@{${vo?.url}}" alt=""/>
                                    </a>
                                </li>
                                </th:block>
                            </ul>';
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}</label>
                        <div class="col-sm-$pit_ia">
                            $enclosureAction
                        </div>    
                    </div>
                </div>
HTML;
    }
}
