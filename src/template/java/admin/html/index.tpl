<html xmlns:th="http://www.thymeleaf.org" th:replace="base/public/default" lang="zh-CN">
<!-- 字库 -->
<th:block th:fragment="fonts">
</th:block>

<!-- 插件CSS -->
<th:block th:fragment="vendor_css">
    <link rel="stylesheet" th:href="@{/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.css}">
    <link rel="stylesheet" th:href="@{/assets/vendor/bootstrap-table/bootstrap-table.min.css}">
    <link rel="stylesheet" th:href="@{/assets/vendor/bootstrap-table/extensions/custom/bootstrap-table-custom.css}">##vendorCss##
</th:block>

<!-- 页面CSS -->
<th:block th:fragment="page_css">
    <link rel="stylesheet" th:href="@{/assets/css/##region##/##parseClassName##/index.css}">
</th:block>

<!-- 页面内容 -->
<th:block th:fragment="page-content">
    <div class="panel">
        <div class="panel-body">
            <div id="toolbar">
                <form id="ToolbarSearchForm" autocomplete="off">
                    <div class="btn-group" role="group">
##toolbarButton##
                    </div>
##toolbarSearch##
                    <div class="toolbars-more">
                        <i class="icon wb-more-horizontal" aria-hidden="true"></i>
                    </div>
                </form>
            </div>
            <table id="table" th:data-url="${'/admin/##region##/##className##/index'}" data-show-pagination-switch="true" data-pagination="true" style="table-layout: fixed;"></table>
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
                    <form autocomplete="off">
                        <div class="form-group">
                            <label class="col-form-label" for="name_MOBILE_SEARCH">名称</label>
                            <input type="text" id="name_MOBILE_SEARCH" class="form-control" name="name" placeholder="请输入名称" autocomplete="off">
                        </div>
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
        <div data-id="create" th:data-url="${'/admin/##region##/##className##/create'}"></div>
        <div data-id="edit" th:data-url="${'/admin/##region##/##className##/edit'}"></div>
        <div data-id="read" th:data-url="${'/admin/##region##/##className##/read'}"></div>
        <div data-id="update" th:data-url="${'/admin/##region##/##className##/update'}"></div>
        <div data-id="status" th:data-url="${'/admin/##region##/##className##/status'}"></div>
        <div data-id="delete" th:data-url="${'/admin/##region##/##className##/delete'}"></div>
    </div>
</th:block>

<!-- Plugins -->
<th:block th:fragment="plugins">
    <script th:inline="javascript">
      /*<![CDATA[*/
      var associatedData = /*[[${data}]]*/ {};
      /*]]>*/
    </script>
</th:block>

<!-- 插件JS -->
<th:block th:fragment="vendor_js">
    <script th:src="@{/assets/vendor/bootstrap-table/bootstrap-table.min.js}"></script>
    <script th:src="@{/assets/vendor/bootstrap-table/bootstrap-table-locale-all.min.js}"></script>
    <script th:src="@{/assets/vendor/bootstrap-table/tableExport/tableExport.min.js}"></script>
    <script th:src="@{/assets/vendor/bootstrap-table/extensions/print/bootstrap-table-print.min.js}"></script>
    <script th:src="@{/assets/vendor/bootstrap-table/extensions/export/bootstrap-table-export.min.js}"></script>
    <script th:src="@{/assets/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js}"></script>
    <script th:src="@{/assets/vendor/bootstrap-table/extensions/custom/bootstrap-table-custom.js}"></script>
    <script th:src="@{/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js}"></script>
    <script th:src="@{/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js}"></script>##vendorJs##
</th:block>

<!-- 页面JS -->
<th:block th:fragment="page_js">
    <script th:src="@{/assets/js/##region##/##parseClassName##/index.js}"></script>
</th:block>
</html>
