<?php
session_start();
include('includes/functions.php');

$supplierSql = "SELECT * FROM Basic_Supplier";
$supplierConnect = mysqli_query($con, $supplierSql);
$suppliers = mysqli_fetch_all($supplierConnect, MYSQLI_ASSOC);

$sizeSql = "SELECT * FROM sizes WHERE is_deleted = 0";
$sizeConnect = mysqli_query($con, $sizeSql);
$sizes = mysqli_fetch_all($sizeConnect, MYSQLI_ASSOC);

$classSql = "SELECT * FROM classes WHERE is_deleted = 0";
$classConnect = mysqli_query($con, $classSql);
$classes = mysqli_fetch_all($classConnect, MYSQLI_ASSOC);

$componentSql = "SELECT * FROM components WHERE is_deleted = 0";
$componentConnect = mysqli_query($con, $componentSql);
$components = mysqli_fetch_all($componentConnect, MYSQLI_ASSOC);

$getDataQuery = "SELECT * FROM supplier_certificates WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $getDataQuery);
$resultData = mysqli_fetch_assoc($connectData);

$materialSpecificationSql = "SELECT * FROM material_specifications WHERE id = '$resultData[material_specification_id]' AND is_deleted = 0";
$materialSpecificationConnect = mysqli_query($con, $materialSpecificationSql);
$materialSpecification = mysqli_fetch_all($materialSpecificationConnect, MYSQLI_ASSOC);

$certificateTypeSql = "SELECT * FROM certificate_types WHERE id = '$resultData[certificate_type_id]' AND is_deleted = 0";
$certificateTypeConnect = mysqli_query($con, $certificateTypeSql);
$certificateType = mysqli_fetch_all($certificateTypeConnect, MYSQLI_ASSOC);
$file = null;
if ($resultData['certificate_type_id'] == 1) {
    $getFileQuery = "SELECT file_path FROM original_certificates WHERE is_deleted = 0 AND supplier_certificate_id ='$_REQUEST[id]'";
    $fileData = mysqli_query($con, $getFileQuery);
    $file = mysqli_fetch_assoc($fileData);
}

$_SESSION['Page_Title'] = "Edit Supplier Certificate - " . $resultData['material_certificate_number'];


?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>
<!--begin::Body-->
<style>
    @media(max-width: 350px) {
        .table-text{
        width: 600px; }
        }
    
    .icon-view {
        background-color: #e4e6ef;
        display: inline-block;
        position: absolute;
        right: 0px;
        top: 0px;
        padding: 9px;
        border-bottom-right-radius: 5px;
        border-top-right-radius: 5px;
        color: #009ef7;
    }

    .icon-upload {
        background-color: #e4e6ef;
        display: inline-block;
        position: absolute;
        right: 33px;
        top: 0px;
        padding: 9px;
        color: #009ef7;
        border-right: 1px solid #d8d5d5;
        cursor: pointer;
    }

    .view-pdf {
        position: relative;
    }

    .ver-disabled input,
    .ver-disabled select {
        background-color: #e9ecef !important;
    }

    .tab-parameter .nav-tabs {
        border-bottom: 2px solid #dee2e6;

    }

    .tab-parameter .nav-tabs li {
        list-style: none;
    }

    .tab-parameter .nav-tabs li a {
        color: #333;

        margin-bottom: -2px;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        border-bottom: 2px solid transparent;
        padding-left: 0px;
        padding-right: 0px;
        font-weight: 500;
        margin-right: 20px;
    }

    .tab-parameter .nav-tabs li a:hover {
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: none;
    }

    .tab-parameter .nav-tabs li a.active {
        background-color: transparent;
        color: #009ef7;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 2px solid #009ef7;
    }

    .table-chemical td {
        padding: 8px;
        border: 1px solid #dee2e6;
        text-align: center;
        vertical-align: middle;

    }

    .table-chemical .actual_td {
        width: 15%;
    }

    .table-chemical th {
        text-align: center;
    }

    .table-chemical td:first-child {
        text-align: left;
        padding-left: 8px;
        width: 95px !important;
    }

    .table-chemical .form-control {
        margin: 0px !important;
        padding: 0.5rem 0.5rem !important;
    }

    table.table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-chemical .header-tr {
        background-color: #009ef7;
    }

    .table-chemical .header-tr td {
        /* text-align: center !important; */
        color: #fff;

    }

    .table-chemical thead tr {
        border: 1px solid #d1d2d4;
        vertical-align: middle;
    }

    .std-td {
        width: 15%;
    }

    .add-item i {
        font-size: 10px;
        background-color: #346cb0;
        padding: 5px;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
    }

    .remove-item i {
        font-size: 10px;
        background-color: #009ef7;
        padding: 5px;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        margin-left: 20px;
    }

    #original-content {
        display: none;
    }

    #transcripted-content {
        display: none;
    }

    .custom-padding {
        padding: 20px !important;
    }
</style>

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
                        <p><a href="/">Home</a> » <a href="/supplier-mtc.php">Supplier MTC</a> »
                            <?php echo $_SESSION['Page_Title']; ?></p>
                        <!-- MIGAS DE PAN -->
                    </div>

                </div>
                <!-- End Breadcrumbs + Actions -->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <!--begin::Card-->
                        <div class="card mt-4 p-6">
                            <!--end::Add design standard form-->
                            <div class="row mb-4">
                                <div class="table-responsive custom-search-nz" id="result-busqueda">
                                </div>
                                <!--begin::Card body-->
                                <div class="card-body pt-0 table-responsive">
                                    <!--begin::Table-->
                                    <form class="form" action="includes/supplier-certificate-update.php" method="post" enctype="multipart/form-data" id="editCert">
                                        <div class="basic">
                                            <input type="hidden" id="supplier_certificate_id" name="supplier_certificate_id" value="<?php echo $resultData['id'] ?>">
                                            <div class="row">
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>PO Number*</label>
                                                        <input type="text" class="form-control" value="<?php echo $resultData['po_number'] ?>" name="po_number" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Supplier Name*</label>
                                                        <select class="form-control" name="supplier_id" required>
                                                            <option selected="selected" value="">Please Select</option>
                                                            <?php foreach ($suppliers as $supplier) { ?>
                                                                <option value=<?php echo $supplier['Id_Supplier']; ?> <?php if ($supplier['Id_Supplier'] ==  $resultData['supplier_id']) {
                                                                                                                            echo "selected";
                                                                                                                        } ?>>
                                                                    <?php echo $supplier['Supplier_Name'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>PO Date*</label>
                                                        <input type="date" class="form-control" value="<?php echo $resultData['po_date'] ?>" name="po_date" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>PO Revision*</label>
                                                        <input type="text" class="form-control" name="po_revision" value="<?php echo $resultData['po_revision'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group ver-disabled">
                                                        <label>MTC Number*</label>
                                                        <input type="text" class="form-control" name="material_certificate_number" value="<?php echo $resultData['material_certificate_number'] ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group ver-disabled">
                                                        <label>MTC Revision*</label>
                                                        <input type="text" class="form-control" name="mtc_revision" value="<?php echo $resultData['mtc_revision'] ?> " readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>MTC Date*</label>
                                                        <input type="date" class="form-control" name="mtc_date" value="<?php echo $resultData['mtc_date'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Item Code*</label>
                                                        <input type="text" class="form-control" value="<?php echo $resultData['item_code'] ?>" name="item_code" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Size*</label>
                                                        <select class="form-control" data-control="select2" name="size_id" required>
                                                            <option selected="selected" value="">Please Select</option>
                                                            <?php foreach ($sizes as $size) { ?>
                                                                <option value="<?php echo $size['id']; ?>" <?php if ($size['id'] ==  $resultData['size_id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>>
                                                                    <?php echo $size['size'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Class*</label>
                                                        <select class="form-control" data-control="select2" name="class_id" required>
                                                            <option selected="selected" value="">Please Select</option>
                                                            <?php foreach ($classes as $class) { ?>
                                                                <option value=<?php echo $class['id']; ?> <?php if ($class['id'] ==  $resultData['class_id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>>
                                                                    <?php echo $class['class'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group ver-disabled">
                                                        <label>Material Specification*</label>
                                                        <input type="hidden" class="form-control" name="material_specification_id" value="<?php echo $resultData['material_specification_id'] ?>" readonly required id="materialSpec">
                                                        <input type="text" class="form-control" value="<?php echo $materialSpecification[0]['material_specification'] ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Edition*</label>
                                                        <input type="text" class="form-control" id="edition" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Drawing Number*</label>
                                                        <input type="text" class="form-control" name="drawing_number" value="<?php echo $resultData['drawing_number'] ?> " required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Component Name*</label>
                                                        <select class="form-control" data-control="select2" name="component_id" required>
                                                            <option selected="selected" value="">Please Select</option>
                                                            <?php foreach ($components as $component) { ?>
                                                                <option value=<?php echo $component['id']; ?> <?php if ($component['id'] ==  $resultData['component_id']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>>
                                                                    <?php echo $component['component'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <div class="form-group ver-disabled">
                                                        <label>Material Certification Type*</label>
                                                        <input type="text" class="form-control" name="material_certification_type" value="<?php echo $resultData['material_certification_type'] ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <div class="form-group ver-disabled">
                                                        <label>Heat Number*</label>
                                                        <input type="text" class="form-control" name="heat_number" value="<?php echo $resultData['heat_number'] ?> " readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Qty*</label>
                                                        <input type="text" class="form-control" name="qty" value="<?php echo $resultData['qty'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 mt-5">
                                                    <div class="form-group ver-disabled">
                                                        <label>Certificate Type*</label>
                                                        <input type="hidden" class="form-control" name="certificate_type_id" value="<?php echo $resultData['certificate_type_id'] ?>" readonly required id="certType">
                                                        <input type="text" class="form-control" value="<?php echo $certificateType[0]['certificate_type_name'] ?>" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4" id="original-content">
                                            </div>
                                        </div>
                                        <div class="row" id="transcripted-content">
                                            <div class="col-lg-12 mt-5">
                                                <div class="mt-4 tab-parameter">
                                                    <ul class="nav nav-tabs" id="transcripted-tabs" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link active" id="chemical-tab" data-bs-toggle="tab" data-bs-target="#chemical" type="button" role="tab" aria-controls="home" aria-selected="true">Chemical</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" id="mechanical-tab" data-bs-toggle="tab" data-bs-target="#mechanical" type="button" role="tab" aria-controls="mechanical" aria-selected="false">Mechanical</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" id="heat-treatment-tab" data-bs-toggle="tab" data-bs-target="#heat-treatment" type="button" role="tab" aria-controls="heat-tratment" aria-selected="false">Heat
                                                                Treatment</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" id="special-test-tab" data-bs-toggle="tab" data-bs-target="#special-test" type="button" role="tab" aria-controls="contact" aria-selected="false">Special
                                                                Test</a>
                                                        </li>
                                                    </ul>
                                                    <div  class="tab-content mt-4 specific table-text" id="material-specification-tabs">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-6">
                                            <div class="col-lg-12">
                                                <div class="form-group form-group-button" style="float:right">
                                                    <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Update</button>
                                                    <a type="button" href="/supplier-mtc.php" class="btn btn-sm btn-danger">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="certificate_id" value="<?php echo $resultData['certificate_id'] ?>">
                                        <input type="hidden" name="file_name" value="<?php echo basename($file['file_path'], ".php") . PHP_EOL ?>">
                                    </form>
                                    <!--start:: PAGINATION-->
                                    <ul class="pagination pagination-circle pagination-outline">
                                    </ul>
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
    </div>
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
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
    <script>
        $("#editCert button[type=submit]").click(function() {
            let key = $("#certType").val();
            if (key === "2") {
                var basicInput = "#editCert div.basic input:invalid";
                var basicSelect = "#editCert div.basic select:invalid";
                var specific = "#editCert div.specific input:invalid";
                if ($(basicInput).length == 0 && $(basicSelect).length == 0 && $(specific).length > 0) {
                    $('#fillAlert').modal('show');
                }
            }
        });

        function closeModal() {
            $('#fillAlert').modal('hide');
        }

        $(window).bind('load', function() {
            var certType = $('#certType').val();
            $('#material-specification-tabs').empty();
            $('#original-content').empty();
            $("#transcripted-content").hide();
            $("#original-content").hide();
            $("#edition").val("");
            let id = $("#materialSpec").val();
            $.ajax({
                url: "includes/get-material-specification-edition.php",
                type: "POST",
                data: {
                    id: id
                },
            }).done(function(result) {
                var dataArr = JSON.parse(result);
                $("#edition").val(dataArr.edition);
            });
            if (certType == 2) {
                $("#transcripted-content").show();
                getMaterailSpecTables();
            } else {
                $("#original-content").show();
                const originalContent =
                    `<div class="row">
                        <div class="col-lg-4">
                            <div class="form-group view-pdf">
                                <input type="file" name="file" id="original-file" style="display:none ;" onchange='uploadFile(this)' accept=".pdf">
                                <label class="icon-upload" for="original-file"><i class="fa fa-upload" style="color:#009ef7"></i></label>
                                <a class="icon-view" href="<?php echo $file['file_path'] ?>" target="_blank"><i class="fa fa-eye" style="color:#009ef7"></i></a>
                                <input type="text" class="form-control" id="original-label" value="<?php echo basename($file['file_path'], ".php") . PHP_EOL  ?>" readonly>
                            </div>
                        </div>
                    </div>`;
                $("#original-content").append(originalContent);
            }
        });

        function uploadFile(target) {
            document.getElementById("original-label").value = target.files[0].name;
        }

        function getMaterailSpecTables() {
            let id = $("#materialSpec").val();
            let supplier_certificate_id = $('#supplier_certificate_id').val();
            if (id != "" && supplier_certificate_id != "") {
                $.ajax({
                    url: "supplier-certificate-material-specification-edit.php",
                    type: "POST",
                    dataType: "html",
                    data: {
                        id: id,
                        supplier_certificate_id: supplier_certificate_id
                    },
                    beforeSend: function() {
                        $('#material-specification-tabs').append(
                            '<tr><td colspan="4"><center><div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div></center></td></tr>'
                        )
                    },
                }).done(function(html) {
                    var defaultTab = document.querySelector('#chemical-tab');
                    var tab = new bootstrap.Tab(defaultTab);
                    tab.show();
                    $('#material-specification-tabs').empty();
                    $("#material-specification-tabs").html(html);
                });
            }
        }

        function removeElem(elem) {
            return $(elem).closest(".special-test-elem").remove();
        }

        $(document).on("click", ".special-test-append", function() {
            const newActionElem =
                `<a class="remove-item" onclick="removeElem(this)"><i class="fa fa-minus"></i></a>`;
            const elem = $(".special-test-newelem").clone();
            const cleanElem = $(elem).removeClass("special-test-newelem");
            $(cleanElem).find("input[type='text']").val("");
            $(cleanElem).find(".special-test-actions").append(newActionElem);
            return $("#special-test").append(cleanElem);
        });

        function validateActual(key) {
            var actual = $("#actual_chemical_" + key).val();
            var max = $("#max_chemical_" + key).text();
            var min = $("#min_chemical_" + key).text();
            max = (max == "-" || max == "") ? 0 : max;
            min = (min == "-" || min == "") ? 0 : min;
            actual = (actual == "-") ? 0 : actual;
            if (actual != 0) {
                if (max != 0 && min != 0 && (Number(actual) >= Number(min)) && (Number(actual) <= Number(max))) {
                    $("#actual_chemical_" + key).attr('class', 'form-control text-box is-valid');
                } else if (max == 0 && min != 0 && Number(actual) >= Number(min)) {
                    $("#actual_chemical_" + key).attr('class', 'form-control text-box is-valid');
                } else if (min == 0 && max != 0 && Number(actual) <= Number(max)) {
                    $("#actual_chemical_" + key).attr('class', 'form-control text-box is-valid');
                } else if (min == 0 && max == 0 && Number(actual) >= 0) {
                    $("#actual_chemical_" + key).attr('class', 'form-control text-box is-valid');
                } else {
                    $("#actual_chemical_" + key).attr('class', 'form-control text-box is-invalid');
                }
            } else {
                $("#actual_chemical_" + key).attr('class', 'form-control');
            }
        }

        function validateActualTensile(key) {
            var actual = $("#actual_" + key).val();
            var max = $("#max_" + key).text();
            var min = $("#min_" + key).text();
            max = (max == "-" || max == "") ? 0 : max;
            min = (min == "-" || min == "") ? 0 : min;
            actual = (actual == "-") ? 0 : actual;
            if (actual != "") {
                if (max != 0 && min != 0 && (Number(actual) >= Number(min)) && (Number(actual) <= Number(max))) {
                    $("#actual_" + key).attr('class', 'form-control text-box is-valid');
                } else if (max == 0 && min != 0 && Number(actual) >= Number(min)) {
                    $("#actual_" + key).attr('class', 'form-control text-box is-valid');
                } else if (min == 0 && max != 0 && Number(actual) <= Number(max)) {
                    $("#actual_" + key).attr('class', 'form-control text-box is-valid');
                } else if (min == 0 && max == 0 && Number(actual) >= 0) {
                    $("#actual_" + key).attr('class', 'form-control text-box is-valid');
                } else {
                    $("#actual_" + key).attr('class', 'form-control text-box is-invalid');
                }
            } else {
                $("#actual_" + key).attr('class', 'form-control');
            }
        }

        function validateAverage(field, key, index) {
            var actual = $("#" + field + "_" + index).val();
            var max = $("#max_" + key).text();
            var min = $("#min_" + key).text();
            max = (max == "-" || max == "") ? 0 : max;
            min = (min == "-" || min == "") ? 0 : min;
            actual = (actual == "-") ? 0 : actual;
            if (actual != 0) {
                if (max != 0 && min != 0 && (Number(actual) >= Number(min)) && (Number(actual) <= Number(max))) {
                    $("#" + field + "_" + index).attr('class', 'form-control text-box is-valid');
                } else if (max == 0 && min != 0 && Number(actual) >= Number(min)) {
                    $("#" + field + "_" + index).attr('class', 'form-control text-box is-valid');
                } else if (min == 0 && max != 0 && Number(actual) <= Number(max)) {
                    $("#" + field + "_" + index).attr('class', 'form-control text-box is-valid');
                } else if (min == 0 && max == 0 && Number(actual) >= 0) {
                    $("#" + field + "_" + index).attr('class', 'form-control text-box is-valid');
                } else {
                    $("#" + field + "_" + index).attr('class', 'form-control text-box is-invalid');
                }
            } else {
                $("#" + field + "_" + index).attr('class', 'form-control');
            }
            var sum = Number($("#" + field + "_" + "1").val()) + Number($("#" + field + "_" + "2").val()) + Number($(
                "#" + field + "_" + "3").val());
            var average = (sum / 3).toFixed(2);
            $("#actual_" + key).val(average);
            if (average != 0.00) {
                if (max != 0 && min != 0 && (Number(average) >= Number(min)) && (Number(average) <= Number(max))) {
                    $("#actual_" + key).attr('class', 'form-control text-box is-valid');
                } else if (max == 0 && min != 0 && Number(average) >= Number(min)) {
                    $("#actual_" + key).attr('class', 'form-control text-box is-valid');
                } else if (min == 0 && max != 0 && Number(average) <= Number(max)) {
                    $("#actual_" + key).attr('class', 'form-control text-box is-valid');
                } else if (min == 0 && max == 0 && Number(average) >= 0) {
                    $("#actual_" + key).attr('class', 'form-control text-box is-valid');
                } else {
                    $("#actual_" + key).attr('class', 'form-control text-box is-invalid');
                }
            } else {
                $("#actual_" + key).attr('class', 'form-control');
                $("#actual_" + key).val("");
            }
        }
    </script>
    <div class="modal fade" id="fillAlert" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">DQMS - Alert!</h5>
                    <button type="button" class="custom-danger" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Please fill out all the required fields in all the tabs!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" onclick="closeModal()">Okay</button>
                </div>
            </div>
        </div>
    </div>
</body>
<!--end::Body-->

</html>