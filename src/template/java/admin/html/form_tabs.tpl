<html xmlns:th="http://www.thymeleaf.org" th:replace="base/public/layer" lang="zh-CN">
<!-- 字库 -->
<th:block th:fragment="fonts">
</th:block>

<!-- 插件CSS -->
<th:block th:fragment="vendor_css">##cssFormBody##
</th:block>

<!-- 页面CSS -->
<th:block th:fragment="page_css">
    <link rel="stylesheet" th:href="@{/assets/css/custom-form.css}">
    <link rel="stylesheet" th:href="@{/assets/css/##region##/##parseClassName##/form.css}">
</th:block>

<!-- 页面内容 -->
<th:block th:fragment="page_content">
    <div class="page animation-fade" data-plugin="mCustomScrollbar">##formTile##
        <div class="page-content container-fluid">
            <form id="myForm" class="page-content-form" data-action="##action##" autocomplete="off">
                <div class="nav-tabs-horizontal" data-approve="nav-tabs">##formBody##
                </div>
            </form>
        </div>
    </div>
    <div hidden>
        <div id="operateEventsSaveUrl" th:data-url="${'/admin/##region##/##className##/save'}"></div>
        <div id="operateEventsUpdateUrl" th:data-url="${'/admin/##region##/##className##/update'}"></div>
    </div>
</th:block>

<!-- 页面底部 -->
<th:block th:fragment="page_footer">
    <button type="button" class="btn btn-default layer-close">取消</button>
    <button type="button" class="btn btn-primary" id="submitForm">保存</button>
</th:block>

<!-- Plugins -->
<th:block th:fragment="plugins">
</th:block>

<!-- 插件JS -->
<th:block th:fragment="vendor_js">
    <script th:src="@{/assets/vendor/matchheight/jquery.matchHeight.min.js}"></script>
    <script th:src="@{/assets/vendor/jquery-validation/jquery.validate.min.js}"></script>
    <script th:src="@{/assets/vendor/jquery-validation/additional-methods.min.js}"></script>
    <script th:src="@{/assets/vendor/jquery-validation/localization/messages_zh.js}"></script>
    <script th:src="@{/assets/vendor/jquery-validation/custom-validation-rules.js}"></script>##jsFormBody##
</th:block>

<!-- 页面JS -->
<th:block th:fragment="page_js">
    <script th:src="@{/assets/js/custom-form.js}"></script>
    <script th:src="@{/assets/js/##region##/##parseClassName##/form.js}"></script>
</th:block>
</html>
