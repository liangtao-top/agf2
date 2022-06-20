<html xmlns:th="http://www.thymeleaf.org" th:replace="base/public/layer" lang="zh-CN">
<!-- 字库 -->
<th:block th:fragment="fonts">
</th:block>

<!-- 插件CSS -->
<th:block th:fragment="vendor_css">##vendorCss##
</th:block>

<!-- 页面CSS -->
<th:block th:fragment="page_css">
    <link rel="stylesheet" th:href="@{/assets/css/view.css}">
    <link rel="stylesheet" th:href="@{/assets/css/##region##/##parseClassName##/read.css}">
</th:block>

<!-- 页面内容 -->
<th:block th:fragment="page_content">
    <div class="page animation-fade" data-plugin="mCustomScrollbar">##formTile##
        <div class="page-content container-fluid">
            <form id="myForm" class="page-content-form" data-action="##action##" autocomplete="off">
                <div class="row">##formViewContent##
                </div>
            </form>
        </div>
    </div>
</th:block>

<!-- 页面底部 -->
<th:block th:fragment="page_footer">
    <button type="button" class="btn btn-default layer-close">关闭</button>
</th:block>

<!-- Plugins -->
<th:block th:fragment="plugins">

</th:block>

<!-- 插件JS -->
<th:block th:fragment="vendor_js">
    <script th:src="@{/assets/vendor/matchheight/jquery.matchHeight.min.js}"></script>##vendorJs##
</th:block>

<!-- 页面JS -->
<th:block th:fragment="page_js">
    <script th:src="@{/assets/js/##region##/##parseClassName##/read.js}"></script>
</th:block>
</html>
