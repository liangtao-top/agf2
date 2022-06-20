{extend name="base/public/layer" /}

<!-- Body className -->
{block name="body_class"}{/block}

<!-- 字体图标 CSS -->
{block name="fonts"}{/block}

<!-- 插件 CSS -->
{block name="vendor_css"}##vendorCss##{/block}

<!-- Page className -->
{block name="page_class"}{/block}

<!-- Page CSS -->
{block name="page_css"}
<link rel="stylesheet" href="/static/assets/css/view.css">
<link rel="stylesheet" href="/static/assets/css/##region##/##parseClassName##/read.css?v={$version}">
{/block}

{block name="body"}
<div class="page animation-fade" data-plugin="mCustomScrollbar">##formTile##
    <div class="page-content container-fluid">
        <form id="myForm" class="page-content-form" data-action="{:request()->action()}" autocomplete="off">
            <div class="row">##formViewContent##
            </div>
        </form>
    </div>
</div>
{/block}

{block name="form-footer"}
<button type="button" class="btn btn-default layer-close">关闭</button>
{/block}

<!-- 插件 JS -->
{block name="vendor_js"}
<script src="/static/assets/vendor/matchheight/jquery.matchHeight.min.js"></script>##vendorJs##
{/block}

<!-- Page JS -->
{block name="page_js"}
<script src="/static/assets/js/##region##/##parseClassName##/read.js?v={$version}"></script>
{/block}
