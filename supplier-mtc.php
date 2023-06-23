<?php
    //updated file on 21032023
    session_start();
    include('includes/functions.php');
    $_SESSION['Page_Title'] = "Supplier MTC";
    $email = $_SESSION['usuario'];
    $roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
    $fetchRole = mysqli_query($con, $roleSql);
    $roleInfo = mysqli_fetch_assoc($fetchRole);
    $role = $roleInfo['Id_basic_role'];
    $columns = array('id', 'po_number', 'material_certificate_number', 'mtc_revision', 'item_code', 'material_specification', 'heat_number', 'created_by', 'created_at');
    $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
    $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';


    $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
    // $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
    $sort_order = 'ASC' ? 'desc' : 'asc';
    $asc_or_desc = 'desc';

    $currentURI = $_SERVER['REQUEST_URI'];

    $columnsQueryItem =    [
        'id' => 'id',
        'created_at' => 'created_at',
        'po_number' => 'po_number',
        'material_certificate_number' => 'material_certificate_number',
        'mtc_revision' => 'mtc_revision',
        'item_code' => 'item_code',
        'material_specification' => 'material_specification',
        'heat_number' => 'heat_number',
        'size' => 'size',
        'class' => 'class',
        'created_by' => 'First_Name + Last_Name',
        'created_at' => 'created_at',
    ];

    $page = 1;

    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    }

    $filterColumns = ['po_no', 'mtc_no', 'item_code', 'heat_no', 'size', 'class'];

    $resetFilterStatus = true;

    $poNumber = isset($_GET['po_no']) ? $_GET['po_no'] : '';
    $mtcNo = isset($_GET['mtc_no']) ? $_GET['mtc_no'] : '';
    $itemCode = isset($_GET['item_code']) ? $_GET['item_code'] : '';
    $heatNo = isset($_GET['heat_no']) ? $_GET['heat_no'] : '';
    $size = isset($_GET['size']) ? $_GET['size'] : '';
    $class = isset($_GET['class']) ? $_GET['class'] : '';

    if ($poNumber || $mtcNo || $itemCode || $heatNo || $size || $class) {
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
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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
                                <div class="col-lg-3 col-sm-12">
                                    <!--begin::Search-->
                                    
                                </div>
                                <div class="col-lg-9 col-sm-12">
                                    <div class="d-flex justify-content-end mr-2">
                                        <button id="resetFilter" onclick="resetFilter();" class="btn btn-sm btn-primary mt-4 me-2" <?php echo $resetFilterStatus ? 'disabled' : ''; ?>>
                                            Reset Filter
                                        </button>
                                        <button id="btnExport" onclick="fnExcelReport('supplierMTC.xlsx');" class="btn btn-sm btn-primary mt-4 me-2">
                                            Export
                                        </button>
                                        <a href="/supplier-certificate-add.php" id="add_mtc"
                                            class="btn btn-sm btn-primary mt-4"
                                            style="float:right ; margin-right:10px;">
                                            Create
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive custom-search-nz" id="result-busqueda">
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body pt-0 table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="mtc_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                                            <th class="min-w-125px">
                                                <div class="d-flex justify-content-between">
                                                    PO No.
                                                    <i class="fas fa-filter btn" data-toggle="popover_po_no" id="po_no"></i>
                                                </div>
                                            </th>
                                            <th class="min-w-125px">
                                                <div class="d-flex justify-content-between">
                                                    MTC No.
                                                    <i class="fas fa-filter btn" data-toggle="popover_mtc_no" id="mtc_no"></i>
                                                </div>
                                            </th>
                                            <th class="min-w-125px">
                                                MTC Version
                                            </th>
                                            <th class="min-w-150px">
                                                <div class="d-flex justify-content-between">
                                                    Item Code.
                                                    <i class="fas fa-filter btn" data-toggle="popover_item_code" id="item_code"></i>
                                                </div>
                                            </th>
                                            <th class="min-w-125px">
                                                    Material Spec
                                            </th>
                                            <th class="min-w-125px">
                                                <div class="d-flex justify-content-between">
                                                    Heat No.
                                                    <i class="fas fa-filter btn" data-toggle="popover_heat_no" id="heat_no"></i>
                                                </div>
                                            </th>
                                             <th class="min-w-75px">
                                                <div class="d-flex justify-content-between">
                                                    Size
                                                    <i class="fas fa-filter btn" data-toggle="popover_size" id="size"></i>
                                                </div>
                                            </th>
                                             <th class="min-w-50px">
                                                <div class="d-flex justify-content-between">
                                                    Class
                                                    <i class="fas fa-filter btn" data-toggle="popover_class" id="class"></i>
                                                </div>
                                            </th>
                                            <th class="min-w-120px">
                                                Created By
                                            </th>
                                            <th class="min-w-80px">
                                                Created
                                            </th>
                                            <th class="min-w-125px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                        <?php
                                        $sql_data = "SELECT supplier_certificates.*,Basic_Employee.First_Name, Basic_Employee.Last_Name, material_specifications.material_specification, classes.class, sizes.size FROM supplier_certificates LEFT JOIN material_specifications ON supplier_certificates.material_specification_id = material_specifications.id LEFT JOIN Basic_Employee ON supplier_certificates.created_by = Basic_Employee.Id_employee LEFT JOIN classes on supplier_certificates.class_id = classes.id LEFT JOIN sizes on supplier_certificates.size_id = sizes.id WHERE supplier_certificates.is_deleted = 0 AND supplier_certificates.po_number LIKE '%$poNumber%' AND supplier_certificates.material_certificate_number LIKE '%$mtcNo%' AND supplier_certificates.item_code LIKE '%$itemCode%' AND supplier_certificates.heat_number LIKE '%$heatNo%' AND classes.class LIKE '%$class%' AND sizes.size LIKE '%$size%' order by " . $columnsQueryItem[$column] . " " . $sort_order;  
                                        $connect_data = mysqli_query($con, $sql_data);

                                        // if ($result = mysqli_query($con, "SELECT * FROM supplier_certificates")) {
                                        //       echo "Returned rows are: " . mysqli_num_rows($result);
                                        //       // Free result set
                                        //       mysqli_free_result($result);
                                        // }

                                        /*PAGINACION*/
                                        $pagination_ok = 1;
                                        /*PAGINACION*/
                                        /*Numero total de registros*/
                                        $num_rows = mysqli_num_rows($connect_data);
                                         // echo $num_rows;
                                        /*contador*/
                                        $page_register_count = 0;
                                        /*max. registros per pagina*/
                                        $max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 50;
                                        /*Si hay paginación*/
                                        if ($_REQUEST['page'] && $_REQUEST['page'] != 1) {
                                            $this_page = $_REQUEST['page'] - 1;
                                            $pass_registers = $max_registers_page * $this_page;
                                            $registers_off = 0;
                                        } else {
                                            /*Si es la primera página, ponemos esto para que evite el uso del continue - Saltaba el primer registro sin esto-*/

                                            $this_page = 0;
                                            $pass_registers = 0;
                                            $registers_off = 0;
                                        }
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {

                                            /*PAGINACION*/
                                            if ($pagination_ok == 1) {
                                                /*codigo para saltar registros de paginas anteriores*/
                                                if ($registers_off != $pass_registers) {
                                                    $registers_off++;
                                                    continue;
                                                }
                                                /*codigo para mostrar solo los registros de la pagina*/
                                                if ($page_register_count != $max_registers_page) {
                                                    $page_register_count++;
                                                } else {
                                                    break;
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $result_data['po_number']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['material_certificate_number']; ?>
                                            </td>
                                            <td>
                                                <?php echo "Ver : " . $result_data['mtc_revision']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['item_code']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['material_specification']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['heat_number']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['size']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['class']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['First_Name']; ?>
                                                <?php echo $result_data['Last_Name']; ?> </td>
                                            <td>
                                                <?php echo date("d-m-y", strtotime($result_data['created_at'])); ?>
                                            </td>
                                            <?php if ($result_data['is_editable']) { ?>
                                            <td>
                                                <a href="supplier-certificate-edit.php?id=<?php echo $result_data['id']; ?>"
                                                    class="set-url"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                                                <a class="copy_row ms-2 me-2 copy-text" style="cursor: pointer"
                                                    data-value="<?php echo $result_data['id']; ?>" data-toggle="tooltip"
                                                    data-placement="top" title="Copy"><i class="fa fa-copy"
                                                        aria-hidden="true"></i></a>
                                                <?php if ($result_data['certificate_type_id'] === '2') { ?>
                                                <a class="print-mtc cursor-pointer me-2"
                                                    data-id="<?php echo $result_data['id']; ?>"
                                                    data-value="<?php echo $result_data['material_certificate_number']; ?>"><i
                                                        class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>
                                                <?php } else if ($result_data['certificate_type_id'] === '1') {
                                                            $original_data = "SELECT * FROM original_certificates WHERE supplier_certificate_id = '$result_data[id]' AND is_deleted = 0";
                                                            $original_connect = mysqli_query($con, $original_data);
                                                            $original_result = mysqli_fetch_assoc($original_connect)
                                                        ?>
                                                <a class="mtc-download cursor-pointer me-2"
                                                    href="<?php echo $original_result['file_path']; ?>"
                                                    download="<?php echo $original_result['file_path']; ?>"
                                                    data-id="<?php echo $original_result['file_path']; ?>"><i
                                                        class="fa fa-download" aria-hidden="true"></i></a>
                                                <?php  }   ?>
                                                <?php if ($role == 1) { ?>
                                                <a href="/includes/supplier_mtc_delete.php?id=<?php echo $result_data['id']; ?>"
                                                    class="set-url"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                <?php } ?>
                                            </td>
                                            <?php } else { ?>
                                            <td>
                                                <a
                                                    href="supplier-certificate-view.php?id=<?php echo $result_data['id']; ?>"><i
                                                        class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a class="copy_row ms-2 me-2 copy-text"
                                                    data-value="<?php echo $result_data['id']; ?>"
                                                    style="cursor: pointer" data-toggle="tooltip" data-placement="top"
                                                    title="Copy"><i class="fa fa-copy" aria-hidden="true"></i></a>

                                                <!-- <?php if ($result_data['certificate_type_id'] === '2') { ?>
                                                <a class="print-mtc cursor-pointer me-2"
                                                    data-id="<?php echo $result_data['id']; ?>"
                                                    data-value="<?php echo $result_data['material_certificate_number']; ?>"><i
                                                        class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>
                                                <?php } else if ($result_data['certificate_type_id'] === '1') {
                                                            $original_data = "SELECT * FROM original_certificates WHERE supplier_certificate_id = '$result_data[id]' AND is_deleted = 0";
                                                            $original_connect = mysqli_query($con, $original_data);
                                                            $original_result = mysqli_fetch_assoc($original_connect)
                                                        ?>

                                                <a class="mtc-download cursor-pointer me-2"
                                                    href="<?php echo $original_result['file_path']; ?>"
                                                    download="<?php echo $original_result['file_path']; ?>"
                                                    data-id="<?php echo $original_result['file_path']; ?>"><i
                                                        class="fa fa-download" aria-hidden="true"></i></a>
                                                <?php  }   ?> -->
                                                <?php if ($role == 1) { ?>
                                                <a href="/includes/supplier_mtc_delete.php?id=<?php echo $result_data['id']; ?>"
                                                    class="set-url"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                <?php } ?>
                                            </td>
                                            <?php }
                                                ?>
                                            <!-- <td>
                                                <?php if ($result_data['certificate_type_id'] === '2') { ?>
                                                <a type="button" class="qr-code"
                                                    data-flag="<?php echo $result_data['is_qr_created'] ?>"
                                                    data-id="<?php echo $result_data['id']; ?>"><i class="fa fa-qrcode"
                                                        aria-hidden="true"></i></a>
                                            </td> -->
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                                <!--start:: PAGINATION-->
                                <div class="d-flex justify-content-between">
                                    <div style='width: 50%;' class="ms-8 pageRange ">
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
                                    <div style='width: 50%;' class="me-6 col-sm-6">
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

                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!-- Finalizar contenido -->
                    </div>
                    <!--end::Container-->

                    <!-- Mitigation Modal start -->
                    <div class="modal" tabindex="-1" role="dialog" id="confirmQr">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Scan</h5>
                                </div>
                                <div class="modal-body">
                                    <p> Do you want to generate QR Code ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-success getQr">Generate</button>
                                    <button type="button" class="btn  btn-sm btn-danger"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mitigation Modal End -->

                    <div class="modal" tabindex="-1" role="dialog" id="qrModal">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">QR Code</h5>
                                </div>
                                <div class="modal-body">
                                    <div id="qr-canvas" class="text-center">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" tabindex="-1" role="dialog" id="generateMode">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form id="generateMode-form">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Please slelect company </h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input name="company_mode" type="radio" value="1"
                                                    class="form-input-check" required>
                                                <label>JC Valves</label>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <input name="company_mode" type="radio" value="2"
                                                    class="form-input-check" required>
                                                <label>ICP Valves</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit"
                                            class="btn btn-sm btn-success generate-pdf">Generate</button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                    <form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Content-->
                <?php include('includes/footer.php'); ?>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>

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
    <script src="JS/buscar-supplier-mtc.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

    <script>

        let qrCodeId = null;
        let base_url = window.location.origin;
        let id = null;
        let fileName = "";
        const filterColumns = <?php echo json_encode($filterColumns); ?>;

        $(document).ready(function() {

        // let searchParams = new URLSearchParams(window.location.search);
        // console.log(searchParams);
        // if(searchParams.has('mtc_no')){
        //             //$("#mtc_no").addClass("blue");
        // }



            for (let i = filterColumns.length - 1; i >= 0; i--) {

                //for color variation
                let searchParams = new URLSearchParams(window.location.search);
                //console.log(searchParams);
                if(searchParams.has(filterColumns[i])){
                        $("#"+filterColumns[i]).addClass("blue");
                        //$("#mtc_no").addClass("blue");
                }

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
                // console.log(filterInputVal);
                let urlFilterValues = (window.location.search).slice(1);

                $(document).on('change', '#' + filterInput, function() {
                    filterInputVal = $(this).val();
                });

                 $(document).on('click', '#' + filterColumns[i] + '_cancel', function() {
                    //add diff class
                    console.log(filterColumns[i]);
                    $("#" + filterColumns[i]).addClass("blue");
                    $('[data-toggle="popover_' + filterColumns[i] + '"]').popover("hide");
                 });

                $(document).on('click', '#' + filterColumns[i] + '_confirm', function() {
                    console.log(filterColumns[i]);
                    $("#" + filterColumns[i]).addClass("blue");
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
             $("#mtc_no").removeClass("blue");
            window.location.href = base_url + '/supplier-mtc.php?a=supplierMtc';
        }

    

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('body').on('click', '.copy_row', function() {
            let id = $(this).data("value");

            $('#add_mtc').attr("href", `/supplier-certificate-add.php?id=${id}`);
            window.location.href = `/supplier-certificate-add.php?id=${id}`;
            $(this).attr("title", "Copied!").tooltip("_fixTitle").tooltip("show");

            return setTimeout(function() {
                $(".copy_row").attr("title", "Copy").tooltip("_fixTitle");
            }, 500);
        });

        const element = document.querySelector(".pagination");
        let totalPages = Number($("#total_pages").val());
        let page = Number($("#current_page").val());

        if (totalPages > 0) {
            element.innerHTML = createPagination(totalPages, page);
        }

        function createPagination(totalPages, page) {
            const pageLimit=document.getElementById("pageRange").value;
            const urlFilterValues = (window.location.search).slice(1);

            const urlParams = urlFilterValues.split('&');

            let searchVal = '';

            for (let j = 0; j < urlParams.length; j++) {
                let item = urlParams[j]

                if ((item.split('='))[0] !== 'page' && (item.split('='))[0] !== 'a' ) {
                    searchVal += '&' + item;    
                }

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
                `<li class="page-item m-1"><a href="/supplier-mtc.php?a=supplierMtc&page=${1}${searchVal}" class="page-link">${firstPage}</a></li>`;
            if (page > 1) {
                liTag +=
                    `<li class="page-item m-1"><a href="/supplier-mtc.php?a=supplierMtc&page=${page - 1}${searchVal}" class="page-link">${prevLabel}</a></li>`;
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
                    `<li class="page-item m-1 ${active}"><a href="/supplier-mtc.php?a=supplierMtc&page=${plength}${searchVal}" class="page-link">${plength}</a></li>`;
            }
            if (page < totalPages) {
                liTag +=
                    `<li class="page-item m-1"><a href="/supplier-mtc.php?a=supplierMtc&page=${page + 1}${searchVal}" class="page-link">${nextLabel}</a></li>`;
            }
            liTag +=
                `<li class="page-item m-1"><a href="/supplier-mtc.php?a=supplierMtc&page=${totalPages}${searchVal}" class="page-link">${lastPage}</a></li>`;
            element.innerHTML = liTag;
            return liTag;
        }

        $('.getQr').on('click', function() {
            $('#confirmQr').modal('hide');
            return generateQrCode();
        });

        function generateQrCode() {
            $.ajax({
                url: "includes/mtc-update-qr.php",
                type: "POST",
                dataType: "html",
                data: {
                    id: qrCodeId
                },
            }).done(function(resultado) {
                $("td").find("a.qr-code[data-id='" + qrCodeId + "']").parent().empty().append(
                    `<a type="button" class="qr-code" data-flag="1" data-id="${qrCodeId}"><i class="fa fa-qrcode" aria-hidden="true"></i></a>`
                );
                $('#qr-canvas').empty();
                $('#qr-canvas').qrcode({
                    render: 'canvas',
                    width: 150,
                    height: 150,
                    text: `${base_url}/print-mtc.php?id=${qrCodeId}`,
                    qrsize: 50,
                });
                $('#qrModal').modal('show');
            });
        }

        function showQrcode() {
            $('#qr-canvas').empty();
            $('#qr-canvas').qrcode({
                render: 'canvas',
                width: 150,
                height: 150,
                text: `${base_url}/print-mtc.php?id=${qrCodeId}`,
                qrsize: 50,
            });
            $('#qrModal').modal('show');
        }

        $("body").delegate('.print-mtc', 'click', function() {
            id = $(this).data('id');
            fileName = $(this).data('value').replace(/\./g, "");
            return $('#generateMode').modal('show');
        });

        $('#generateMode-form').submit(function(e) {
            e.preventDefault()
            let mode = $("input[name='company_mode']:checked").val();
            $.get(`print-mtc.php?id=${id}&mode=${mode}`, function(data) {
                let opt = {
                    margin: [0.1, 0.1, 0.1, 0.1],
                    image: {
                        type: "jpeg",
                        quality: 1.5,
                    },
                    html2canvas: {
                        // scale: 7,
                        scale: 3,
                        // letterRendering: false,
                        letterRendering: true,
                        dpi: 300,
                        width: 783,
                        scrollY: 0,
                    },
                    jsPDF: {
                        unit: "in",
                        format: "A4",
                        orientation: "portrait",
                        // orientation: "landscape",
                    },
                };
                let worker = html2pdf().set(opt).from(data).save(fileName);
            });
            $('#generateMode').modal('hide');

        });

        $("body").delegate('.qr-code', 'click', function() {
            qrCodeId = $(this).data('id');
            let qrFlag = $(this).data('flag');
            if (qrFlag == '0') {
                return $('#confirmQr').modal('show');
            } else {
                return showQrcode();
            }
        });

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
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>