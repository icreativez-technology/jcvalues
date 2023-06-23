<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "NCR List";

$email = $_SESSION['usuario'];
$roleSql = "SELECT Id_basic_role From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];

$columns = array('id', 'no', 'type', 'plant', 'created_by', 'product_group', 'department', 'owner', 'status');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);

$sorting_status = isset($_GET['sorting_status']) ? $_GET['sorting_status'] : false;

if ($sorting_status) {
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
} else {

    $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'desc';
}

$columnsQueryItem = [
    'id' => 'id',
    'no' => 'no',
    'type' => 'type',
    'plant' => 'plant',
    'created_by' => 'created_by',
    'product_group' => 'product_group',
    'department' => 'Department',
    'owner' => 'owner',
    'status' => 'status'
]
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <!-- Includes Top bar and Responsive Menu -->
                <!-- Breadcrumbs + Actions -->
                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> » <a href="/ncr.php">NCR</a> »
                            <?php echo $_SESSION['Page_Title']; ?></p>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-end">
                            <a href="/ncr_detail.php?type=0">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New NCR
                                </button>
                            </a>
                            <a href="/ncr.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    <i class="bi bi-speedometer2"></i> View Dashboard
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Breadcrumbs + Actions -->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <!--begin::Card-->
                        <div class="card mt-4">
                            <div class="row mt-2 mb-4 ms-2">
                                <div class="col-md-3">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search..." id="termino" name="termino" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <div class="col-lg-9">
                                    <div class="d-flex justify-content-end mr-2">
                                        <button id="btnExport" onclick="fnExcelReport('NCR.xlsx');" class="btn btn-sm btn-primary mt-4 me-2">
                                            Export
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive custom-search-nz" id="result-busqueda">
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body pt-0 table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table" data-cols-width="20, 20, 20, 20, 20, 20, 10, 10">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                                            <th class="min-w-135px">NCR No</th>
                                            <th class="min-w-70px">NCR Type</th>
                                            <th class="min-w-100px">Plant</th>
                                            <th class="min-w-100px">Created By</th>
                                            <th class="min-w-100px">Product Group</th>
                                            <th class="min-w-140px">Department</th>
                                            <th class="min-w-130px">Owner</th>
                                            <th class="min-w-140px">Status</th>
                                            <th class="min-w-100px">Action</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td>
                                                PPNCR_22May_0072
                                            </td>
                                            <td>
                                                Process
                                            </td>
                                            <td>
                                                CBR
                                            </td>
                                            <td>
                                                Santhosh G
                                            </td>
                                            <td>
                                                Common
                                            </td>
                                            <td>
                                                Maintenance
                                            </td>
                                            <td>
                                                KKK
                                            </td>
                                            <td>
                                                <div class="badge badge-light-warning">
                                                    Open
                                                </div>
                                            </td>
                                            <td>
                                                <a href="ncr_detail.php?type=1" class="me-3">
                                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="ncr_detail.php?type=2" class="me-3">
                                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a href="/ncr_pdf.php" target="_blank" class="me-3">
                                                    <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                PPNCR_22Jan_0068
                                            </td>
                                            <td>
                                                Product
                                            </td>
                                            <td>
                                                KPM
                                            </td>
                                            <td>
                                                Mashesh K
                                            </td>
                                            <td>
                                                SVG
                                            </td>
                                            <td>
                                                Quality
                                            </td>
                                            <td>
                                                Lucky
                                            </td>
                                            <td>
                                                <div class="badge badge-light-danger">
                                                    Delay
                                                </div>
                                            </td>
                                            <td>
                                                <a href="ncr_detail.php?type=1" class="me-3">
                                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="ncr_detail.php?type=2" class="me-3">
                                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                                </a>
                                                <?php if ($role == 1) { ?>
                                                    <a href="#">
                                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                                <!--start:: PAGINATION-->
                                <div class="d-flex justify-content-between">
                                    <div class="ms-3 pageRange">
                                        <select id="pageRange" name="pageRange" class="form-select">
                                            <option value="10" <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>10</option>
                                            <option value="25" <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>25</option>
                                            <option value="50" <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>50</option>
                                            <option value="100" <?php echo ($max_registers_page == 100) ? 'selected' : ''; ?>>100
                                            </option>
                                        </select>
                                    </div>
                                    <div class="me-6">
                                        <ul class="pagination pagination-circle pagination-outline">
                                            <?php
                                            if ($pagination_ok == 1) {
                                                $num_pages = $num_rows / $max_registers_page;
                                                $total_pages = ceil($num_pages);
                                                if (!$_REQUEST['page']) {
                                                    $_REQUEST['page'] = 1;
                                                }
                                                $current_page = $_REQUEST['page'];
                                            }
                                            ?>
                                            <input type="hidden" id="total_pages" value="<?php echo $total_pages ?>">
                                            <input type="hidden" id="current_page" value="<?php echo $current_page ?>">
                                        </ul>
                                        <!--end:: PAGINATION-->
                                    </div>
                                </div>
                                <!--end:: PAGINATION-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!-- Finalizar contenido -->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <?php include('includes/footer.php'); ?>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <?php include('includes/scrolltop.php'); ?>
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <!-- BUSCADOR SEARCH PARA: Department -->
    <script src="JS/buscar-quality-risk-view-list.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <!-- FIN BUSCADOR SEARCH JS -->
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->

    <script>
        const element = document.querySelector(".pagination");
        let totalPages = Number($("#total_pages").val());
        let page = Number($("#current_page").val());

        if (totalPages > 0) {
            element.innerHTML = createPagination(totalPages, page);
        }

        function createPagination(totalPages, page) {

            var asc_or_desc = "<?php echo $asc_or_desc; ?>";
            var sorting_status = "<?php echo $sorting_status  ?>"

            if (sorting_status) {
                asc_or_desc = asc_or_desc == 'asc' ? "desc" : 'asc';
            } else {
                asc_or_desc = asc_or_desc == 'asc' ? "asc" : 'desc';
            }

            let liTag = '';
            let active;
            let beforePage = page - 2;
            let afterPage = page + 2;
            let prevLabel = "<";
            let nextLabel = ">";
            let firstPage = "<<";
            let lastPage = ">>";
            liTag +=
                `<li class="page-item m-1"><a href="/nc_capa_view_list.php?a=nc&page=${1}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${firstPage}</a></li>`;
            if (page > 1) {
                liTag +=
                    `<li class="page-item m-1"><a href="/nc_capa_view_list.php?a=nc&page=${page - 1}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${prevLabel}</a></li>`;
            }
            if (page == totalPages) {
                beforePage = beforePage - 2;
            } else if (page == totalPages - 1) {
                beforePage = beforePage - 1;
            }
            if (page == 1) {
                afterPage = afterPage + 2;
            } else if (page == 2) {
                afterPage = afterPage + 1;
            }
            beforePage = beforePage > 0 ? beforePage : 1;
            for (var plength = beforePage; plength <= afterPage; plength++) {
                if (plength > totalPages) {
                    continue;
                }
                if (plength == 0) {
                    plength = plength + 1;
                }
                if (page == plength) {
                    active = "active";
                } else {
                    active = "";
                }
                liTag +=
                    `<li class="page-item m-1 ${active}"><a href="/nc_capa_view_list.php?a=nc&page=${plength}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${plength}</a></li>`;
            }
            if (page < totalPages) {
                liTag +=
                    `<li class="page-item m-1"><a href="/nc_capa_view_list.php?a=nc&page=${page + 1}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${nextLabel}</a></li>`;
            }
            liTag +=
                `<li class="page-item m-1"><a href="/nc_capa_view_list.php?a=nc&page=${totalPages}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${lastPage}</a></li>`;
            element.innerHTML = liTag;
            return liTag;
        }

        function fnExcelReport(fileName) {
            let table = document.getElementsByTagName("table");
            return TableToExcel.convert(table[0], {
                name: fileName,
                sheet: {
                    name: 'Sheet 1'
                }
            });
        }
    </script>
</body>
<!--end::Body-->

</html>