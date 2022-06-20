{extend name="base/public/default" /}

<!-- Body className -->
{block name="body_class"}{/block}

<!-- 字体图标 CSS -->
{block name="fonts"}{/block}

<!-- 插件 CSS -->
{block name="vendor_css"}
<link rel="stylesheet" href="/static/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
<link rel="stylesheet" href="/static/assets/vendor/bootstrap-table/bootstrap-table.min.css">
<link rel="stylesheet" href="/static/assets/vendor/bootstrap-table/extensions/custom/bootstrap-table-custom.css">##vendorCss##
{/block}

<!-- Page className -->
{block name="page_class"}page-full{/block}

<!-- Page CSS -->
{block name="page_css"}
<link rel="stylesheet" href="/static/assets/css/##region##/##parseClassName##/index.css?v={$version}">
{/block}

{block name="body"}
<div class="panel">
    <div class="panel-body">
        <div id="toolbar">
            <form id="ToolbarSearchForm" autocomplete="off">
                <div class="btn-group" role="group">##toolbarButton##
                </div>##toolbarSearch##
                <div class="toolbars-more">
                    <i class="icon wb-more-horizontal" aria-hidden="true"></i>
                </div>
            </form>
        </div>
        <table id="table" data-url="{:url('##region##.##className##/index', [], 'json')}" data-show-pagination-switch="##paging##" data-pagination="##paging##" style="table-layout: fixed;"></table>
    </div>
</div>
<div class="modal fade" id="modalToolbarSearch" tabindex="-1" role="dialog" aria-labelledby="modalToolbarSearch" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">搜索</h4>
            </div>
            <div class="modal-body">
                <form autocomplete="off">##mobileToolbarSearch##
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-event="empty" class="btn btn-default" data-dismiss="modal">清空</button>
                <button type="button" data-event="search" class="btn btn-primary" data-dismiss="modal">搜索</button>
            </div>
        </div>
    </div>
</div>
<div hidden id="operateEventsUrl">
    <div data-id="create" data-url="{:url('##region##.##className##/create')}"></div>
    <div data-id="edit" data-url="{:url('##region##.##className##/edit')}"></div>
    <div data-id="read" data-url="{:url('##region##.##className##/read')}"></div>
    <div data-id="update" data-url="{:url('##region##.##className##/update')}"></div>
    <div data-id="status" data-url="{:url('##region##.##className##/status')}"></div>
    <div data-id="delete" data-url="{:url('##region##.##className##/delete')}"></div>
</div>
{present name="data"}
<div hidden id="AssociatedData">
    {foreach $data as $key=>$vo }
    {if (is_array($vo)) }
    <div data-id="{$key}" data-json='{:json_encode($vo)}'></div>
    {else /}
    <div data-id="{$key}" data-json='{:json_encode($vo->toArray())}'></div>
    {/if}
    {/foreach}
</div>
{/present}
{/block}

<!-- 插件 JS -->
{block name="vendor_js"}
<script src="/static/assets/vendor/bootstrap-table/bootstrap-table.min.js"></script>
<script src="/static/assets/vendor/bootstrap-table/bootstrap-table-locale-all.min.js"></script>
<script src="/static/assets/vendor/bootstrap-table/tableExport/tableExport.min.js"></script>
<script src="/static/assets/vendor/bootstrap-table/extensions/print/bootstrap-table-print.min.js"></script>
<script src="/static/assets/vendor/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
<script src="/static/assets/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="/static/assets/vendor/bootstrap-table/extensions/custom/bootstrap-table-custom.js"></script>
<script src="/static/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/static/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js"></script>##vendorJs##
{/block}

<!-- Page JS -->
{block name="page_js"}
<script src="/static/assets/js/##region##/##parseClassName##/index.js?v={$version}"></script>
{/block}
