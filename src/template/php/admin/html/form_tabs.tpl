{extend name="base/public/layer" /}

<!-- Body className -->
{block name="body_class"}{/block}

<!-- 字体图标 CSS -->
{block name="fonts"}{/block}

<!-- 插件 CSS -->
{block name="vendor_css"}##cssFormBody##{/block}

<!-- Page className -->
{block name="page_class"}{/block}

<!-- Page CSS -->
{block name="page_css"}
<link rel="stylesheet" href="/static/assets/css/custom-form.css?v={$version}">
<link rel="stylesheet" href="/static/assets/css/##region##/##parseClassName##/form.css?v={$version}">
{/block}

{block name="body"}
<div class="page animation-fade" data-plugin="mCustomScrollbar">##formTile##
    <div class="page-content container-fluid">
        <form id="myForm" class="page-content-form" data-action="{:request()->action()}" autocomplete="off">
        <div class="nav-tabs-horizontal" data-approve="nav-tabs">##formBody##
        </div>
        </form>
    </div>
</div>
<div hidden>
    <div id="operateEventsSaveUrl" data-url="{:url('##region##.##className##/save')}"></div>
    <div id="operateEventsUpdateUrl" data-url="{:url('##region##.##className##/update')}"></div>
</div>
{/block}

{block name="form-footer"}
<button type="button" class="btn btn-default layer-close">取消</button>
<button type="button" class="btn btn-primary" id="submitForm">保存</button>
{/block}

<!-- 插件 JS -->
{block name="vendor_js"}
<script src="/static/assets/vendor/matchheight/jquery.matchHeight.min.js"></script>
<script src="/static/assets/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/static/assets/vendor/jquery-validation/additional-methods.min.js"></script>
<script src="/static/assets/vendor/jquery-validation/localization/messages_zh.js"></script>
<script src="/static/assets/vendor/jquery-validation/custom-validation-rules.js"></script>##jsFormBody##
{/block}

<!-- Page JS -->
{block name="page_js"}
<script src="/static/assets/js/custom-form.js?v={$version}"></script>
<script src="/static/assets/js/##region##/##parseClassName##/form.js?v={$version}"></script>
{/block}
