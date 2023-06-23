<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Supplier NC & CAPA View List";

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 13 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$supplierSql = "SELECT * FROM Basic_Supplier";
$supplierConnect = mysqli_query($con, $supplierSql);
$suppliers = mysqli_fetch_all($supplierConnect, MYSQLI_ASSOC);

$columns = array('id', 'supplier_nc_capa_id', 'supplier_id', 'ncr_classification', 'qty_nc', 'status');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);

$sorting_status = isset($_GET['sorting_status']) ? $_GET['sorting_status'] : false;

if ($sorting_status) {
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
} else {
    $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'desc';
}

$columnsQueryItem =    [
    'id' => 'id',
    'supplier_nc_capa_id' => 'supplier_nc_capa_id',
    'supplier_id' => 'supplier_id',
    'ncr_classification' => 'ncr_classification',
    'qty_nc' => 'qty_nc',
    'status' => 'status',
];

/* for Filter */
$currentURI = $_SERVER['REQUEST_URI'];

  $page = 1;
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    }

    $filterColumns = ['audit_type', 'audit_area', 'uniq_id', 'audit_std', 'audit_id', 'dept', 'create_dt'];

    $resetFilterStatus = true;
    $createDt=$startDt=$endDt=$auditId=$auditArea='';
    $auditType = isset($_GET['audit_type']) ? $_GET['audit_type'] : '';
    $auditStd = isset($_GET['audit_std']) ? $_GET['audit_std'] : '';
    // $auditId = isset($_GET['audit_id']) ? $_GET['audit_id'] : '';
    $uniqID = isset($_GET['uniq_id']) ? $_GET['uniq_id'] : '';
    $deptId = isset($_GET['dept']) ? $_GET['dept'] : '';

    // $createDt = isset($_GET['create_dt']) ? date('Y-m-d', strtotime($_GET['create_dt'])) : '';
    if(isset($_GET['create_dt'])){
    $dates = DateTime::createFromFormat('d-m-y', $_GET['create_dt']);
    $createDt = $dates->format('Y-m-d');
    }

    if(isset($_GET['audit_id'])){
    $sql = "SELECT * FROM audit_management_list WHERE unique_id = '$_GET[audit_id]'";
    $fetch = mysqli_query($con, $sql);
    $search1 = mysqli_fetch_assoc($fetch);
    $auditId=$search1['id'];
    }

    // $ids = array_filter(array_unique(array_map('intval', (array)$ids)));
    // if ($ids) {
    // $query = 'SELECT * FROM `galleries` WHERE `id` IN ('.implode(',', $ids).');';
    // }

    if(isset($_GET['audit_area'])){
    $sql = "SELECT * From external_and_customer_audits where audit_area LIKE '%$_GET[audit_area]%'";
    $fetch = mysqli_query($con, $sql);
    //$search2 = mysqli_fetch_assoc($fetch);
    while ($result_data = mysqli_fetch_assoc($fetch)) {
        echo $result_data;
    }
    //$auditArea=$search2['audit_id'];
    }



  if ($auditType || $uniqID || $auditStd || $auditArea || $deptId || $auditId || $createDt) {
        $resetFilterStatus = false;
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
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
                    <div class="col-6">
                        <p><a href="/">Home</a> » <a href="/supplier_nc_capa.php">Supplier NC & CAPA</a> »
                            <?php echo $_SESSION['Page_Title']; ?></p>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-end">
                            <?php if ($role == 1 || $canEdit == 1) { ?>
                            <a href="/supplier_nc_capa_add.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New Supplier NC & CAPA
                                </button>
                            </a>
                            <?php } ?>
                            <a href="/supplier_nc_capa.php">
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
                                <div class="col-3">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                       <!--  <span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path
                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input type="text" data-kt-filemanager-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-15"
                                            placeholder="Search..." id="termino" name="termino" /> -->
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <div class="col-9">
                                    <div class="d-flex justify-content-end">
                                           <button id="resetFilter" onclick="resetFilter();" class="btn btn-sm btn-primary mt-4 me-2" <?php echo $resetFilterStatus ? 'disabled' : ''; ?>>
                                            Reset Filter
                                        </button>
                                        <button id="btnExport" onclick="fnExcelReport('supplierNCR.xlsx');"
                                            class="btn btn-sm btn-primary mt-4 me-2">
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
                                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5"
                                    id="kt_department_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                                            <th class="min-w-100px">
                                              <!--   <a
                                                    href="/supplier_nc_capa_view_list.php?a=calibration&column=supplier_nc_capa_id&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Id<i
                                                        class="fas fa-sort<?php echo $column == 'supplier_nc_capa_id' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                ID
                                                 <i class="fas fa-sm fa-filter btn" data-toggle="popover_uniq_id" id="uniq_id"></i>
                                            </th>
                                            <th class="min-w-150px">
                                                Created At
                                                  <i class="fas fa-filter fa-sm btn" data-toggle="popover_create_dt" id="create_dt"></i>
                                            </th>
                                            <th class="min-w-200px">
                                               <!--  <a
                                                    href="/supplier_nc_capa_view_list.php?a=calibration&column=supplier_id&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Supplier Name<i
                                                        class="fas fa-sort<?php echo $column == 'supplier_id' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Supplier Name
                                            </th>
                                            <th class="min-w-100px">
                                              <!--   <a
                                                    href="/supplier_nc_capa_view_list.php?a=calibration&column=supplier_id&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Origin<i
                                                        class="fas fa-sort<?php echo $column == 'supplier_id' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Origin
                                            </th>
                                            <th class="min-w-200px">
                                                <!-- <a
                                                    href="/supplier_nc_capa_view_list.php?a=calibration&column=ncr_classification&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    NCR Classification<i
                                                        class="fas fa-sort<?php echo $column == 'ncr_classification' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                NCR Classification
                                            </th>
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/supplier_nc_capa_view_list.php?a=calibration&column=qty_nc&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    QTY NC's<i
                                                        class="fas fa-sort<?php echo $column == 'qty_nc' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                QTY NC's
                                            </th>
                                            <th class="min-w-100px">
                                                <!-- <a
                                                    href="/supplier_nc_capa_view_list.php?a=calibration&column=status&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Status<i
                                                        class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Status
                                            </th>
                                            <th class="min-w-100px">Action</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        <?php
                                        $sql_data = "SELECT * FROM supplier_nc_capa_ncr_details WHERE is_deleted = 0 AND supplier_nc_capa_ncr_details.supplier_nc_capa_id LIKE '%$uniqID%' AND supplier_nc_capa_ncr_details.created_at LIKE '%$createDt%' order by " . $columnsQueryItem[$column] . " " . $sort_order;
                                        $connect_data = mysqli_query($con, $sql_data);
                                        $pagination_ok = 1;
                                        $num_rows = mysqli_num_rows($connect_data);
                                        $page_register_count = 0;
                                        $max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 50;
                                        if ($_REQUEST['page'] && $_REQUEST['page'] != 1) {
                                            $this_page = $_REQUEST['page'] - 1;
                                            $pass_registers = $max_registers_page * $this_page;
                                            $registers_off = 0;
                                        } else {
                                            $this_page = 0;
                                            $pass_registers = 0;
                                            $registers_off = 0;
                                        }
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            if ($pagination_ok == 1) {
                                                if ($registers_off != $pass_registers) {
                                                    $registers_off++;
                                                    continue;
                                                }
                                                if ($page_register_count != $max_registers_page) {
                                                    $page_register_count++;
                                                } else {
                                                    break;
                                                }
                                            }

                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $result_data['supplier_nc_capa_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo date("d-m-y", strtotime($result_data['created_at'])); ?>
                                            </td>
                                            <td>
                                                <?php foreach ($suppliers as $supplier) {
                                                        if ($supplier['Id_Supplier'] == $result_data['supplier_id']) {
                                                            echo $supplier['Supplier_Name'];
                                                        }
                                                    }
                                                    ?>
                                            </td>
                                            <td>
                                                <?php foreach ($suppliers as $supplier) {
                                                        if ($supplier['Id_Supplier'] == $result_data['supplier_id']) {
                                                            echo $supplier['Country_of_Origin'];
                                                        }
                                                    }
                                                    ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['ncr_classification']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['qty_nc']; ?>
                                            </td>
                                            <?php $class = ($result_data['status'] == "Open") ? "status-danger" : "status-active"; ?>
                                            <td>
                                                <div class="<?php echo $class; ?>"><?php echo $result_data['status']; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($canView == 1) { ?>
                                                <a href="/supplier_nc_capa_edit.php?id=<?php echo $result_data['id']; ?>&view"
                                                    class="me-3">
                                                    <i class="bi bi-eye text-primary" aria-hidden="true"></i>
                                                </a>
                                                <?php } ?>
                                                <?php if ($result_data['status'] == "Open") { ?>
                                                <?php if ($canEdit == 1) { ?>
                                                <a href="/supplier_nc_capa_edit.php?id=<?php echo $result_data['id']; ?>"
                                                    class="me-3 set-url"><i class="bi bi-pencil"
                                                        aria-hidden="true"></i></a>
                                                <?php } ?>
                                                <?php } else { ?>
                                                <?php if ($canView == 1) { ?>
                                                <a data-id='<?php echo $result_data['id']; ?>'
                                                    data-unique='<?php echo $result_data['supplier_nc_capa_id']; ?>'
                                                    target="_blank" class="me-3 print-pdf cursor-pointer"><i
                                                        class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>
                                                <?php } ?>
                                                <?php } ?>
                                                <?php if ($role == 1 || $canDelete == 1) { ?>
                                                <a href="/includes/supplier_nc_capa_delete.php?id=<?php echo $result_data['id']; ?>"
                                                    class="set-url"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                                <div class="d-flex justify-content-between">
                                    <div class="ms-3 pageRange">
                                        <select id="pageRange" name="pageRange" class="form-select">
                                            <option value="10"
                                                <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>10</option>
                                            <option value="25"
                                                <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>25</option>
                                            <option value="50"
                                                <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>50</option>
                                            <option value="100"
                                                <?php echo ($max_registers_page == 100) ? 'selected' : ''; ?>>100
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
                                    </div>
                                </div>
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
     <?php foreach ($filterColumns as $value) { ?>
        <div id="<?php echo 'popover_' . $value . '_content_wrapper' ;?>"  style="display: none">
            <div class="form-group mb-2">
                <input type="text" class="form-control" placeholder="Search..." id="<?php echo $value . '_filter'; ?>" value="<?php echo isset($_GET[$value]) ? $_GET[$value] : ''; ?>">
            </div>

            <div class="d-flex justify-content-end mt-4">
                <div class="ms-2" id="<?php echo $value . '_cancel'; ?>">
                   <i class="btn far fa-times-circle fa-2x text-danger"></i>
                </div>
                <div class="ms-2" id="<?php echo $value . '_confirm'; ?>">
                  <i class="btn far fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>
    <?php }  ?>
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
    <script src="JS/buscar_supplier_nc_capa_view_list.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

     <script>

        /* Filter Start */
        let qrCodeId = null;
        let base_url = window.location.origin;
        let id = null;
        let fileName = "";
        const filterColumns = <?php echo json_encode($filterColumns); ?>;


         $(document).ready(function(){
            // console.log('welcome');

            for (let i = filterColumns.length - 1; i >= 0; i--) {

                let popoverVal = "popover_" + filterColumns[i];
                let contentWrapperVal = 'popover_' + filterColumns[i] + '_content_wrapper'
                let filterInput = filterColumns[i] + '_filter';

                $('[data-toggle="' + popoverVal + '"]').popover({
                    sanitize: false,
                    html: true,
                    trigger: 'click',
                    placement: 'bottom',
                    content: function () {
                        return $('#' + contentWrapperVal).html();
                    }
                });

                let filterInputVal = $('#' + filterInput).val();
                let urlFilterValues = (window.location.search).slice(1);

                $(document).on('change', '#' + filterInput, function() {
                    filterInputVal = $(this).val();
                });

                 $(document).on('click', '#' + filterColumns[i] + '_cancel', function() {
                    $('[data-toggle="popover_' + filterColumns[i] + '"]').popover("hide");
                 });

                $(document).on('click', '#' + filterColumns[i] + '_confirm', function() {
                    const urlParams = urlFilterValues.split('&');
                    const pathName = window.location.pathname;
                    let url = base_url + pathName + '?';
                    let status = true;

                    for (let j = 0; j < urlParams.length; j++) {
                        let item = urlParams[j]

                        if ((item.split('='))[0] == filterColumns[i] ) {
                            item = filterColumns[i] + '=' + filterInputVal;
                            status = false;
                        }

                        if (j > 0) {
                            url += '&' + item;
                        } else {
                            url += item;
                        }
                    }

                    if (status) {
                        url += '&' + filterColumns[i] + '=' + filterInputVal;
                    }

                    window.location.href = url;
                });
            }
        });

        function resetFilter() {
            window.location.href = base_url + '/supplier_nc_capa_view_list.php?a=13';
        }

</script>

    <!-- FIN BUSCADOR SEARCH JS -->
    <!--end::Page Custom Javascript-->
    <script type="text/javascript">
    function fnExcelReport(fileName) {
        let table = document.getElementsByTagName("table");
        return TableToExcel.convert(table[0], {
            name: fileName,
            sheet: {
                name: 'Sheet 1'
            }
        });
    }

    const element = document.querySelector(".pagination");
    let totalPages = Number($("#total_pages").val());
    let page = Number($("#current_page").val());
    if (totalPages > 0) {
        element.innerHTML = createPagination(totalPages, page);
    }

    function createPagination(totalPages, page) {
        var pageLimit=document.getElementById("pageRange").value;
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
            `<li class="page-item m-1"><a href="/supplier_nc_capa_view_list.php?a=supplierNcr&page=${1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${firstPage}</a></li>`;
        if (page > 1) {
            liTag +=
                `<li class="page-item m-1"><a href="/supplier_nc_capa_view_list.php?a=supplierNcr&page=${page - 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${prevLabel}</a></li>`;
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
                `<li class="page-item m-1 ${active}"><a href="/supplier_nc_capa_view_list.php?a=supplierNcr&page=${plength}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${plength}</a></li>`;
        }
        if (page < totalPages) {
            liTag +=
                `<li class="page-item m-1"><a href="/supplier_nc_capa_view_list.php?a=supplierNcr&page=${page + 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${nextLabel}</a></li>`;
        }
        liTag +=
            `<li class="page-item m-1"><a href="/supplier_nc_capa_view_list.php?a=supplierNcr&page=${totalPages}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${lastPage}</a></li>`;
        element.innerHTML = liTag;
        return liTag;
    }

    $('.print-pdf').on('click', function() {
        let id = $(this).data('id');
        let unique = $(this).data('unique');
        $.get(`/includes/supplier_nc_capa_pdf.php?id=${id}`, function(data) {
            let opt = {
                margin: [0, 0.1, 0.1, 0.1],
                image: {
                    type: "jpeg",
                    quality: 1.5,
                },
                html2canvas: {
                    scale: 7,
                    letterRendering: false,
                    dpi: 700,
                    width: 775,
                    scrollY: 0,
                },
                jsPDF: {
                    unit: "in",
                    format: "A4",
                    orientation: "portrait",
                },
            };
            let worker = html2pdf().set(opt).from(data).save(unique);
        });
    });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>