<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Supplier Certificate";

$supplierSql = "SELECT * FROM Basic_Supplier";
$supplierConnect = mysqli_query($con, $supplierSql);
$suppliers = mysqli_fetch_all($supplierConnect, MYSQLI_ASSOC);

$sizeSql = "SELECT * FROM sizes WHERE is_deleted = 0";
$sizeConnect = mysqli_query($con, $sizeSql);
$sizes = mysqli_fetch_all($sizeConnect, MYSQLI_ASSOC);

$materialSpecificationSql = "SELECT * FROM material_specifications WHERE is_deleted = 0 AND is_editable = 1";
$materialSpecificationConnect = mysqli_query($con, $materialSpecificationSql);
$materialSpecifications = mysqli_fetch_all($materialSpecificationConnect, MYSQLI_ASSOC);

$classSql = "SELECT * FROM classes WHERE is_deleted = 0";
$classConnect = mysqli_query($con, $classSql);
$classes = mysqli_fetch_all($classConnect, MYSQLI_ASSOC);

$componentSql = "SELECT * FROM components WHERE is_deleted = 0";
$componentConnect = mysqli_query($con, $componentSql);
$components = mysqli_fetch_all($componentConnect, MYSQLI_ASSOC);

$certificateTypeSql = "SELECT * FROM certificate_types WHERE is_deleted = 0";
$certificateTypeConnect = mysqli_query($con, $certificateTypeSql);
$certificateTypes = mysqli_fetch_all($certificateTypeConnect, MYSQLI_ASSOC);

$resultData  = null;
if (isset($_REQUEST['id'])) {
    $getDataQuery = "SELECT * FROM supplier_certificates WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
    $connectData = mysqli_query($con, $getDataQuery);
    $resultData = mysqli_fetch_assoc($connectData);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>
<!--begin::Body-->

<style>
    .ver-disabled input {
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
                                    <form class="form" action="includes/supplier-certificate-store.php" method="post" enctype="multipart/form-data" id="newCert">
                                        <input type="hidden" name="supplier_certificate_id" id="supplier_certificate_id" value="<?php echo $resultData != null ? $resultData['id'] : ''  ?>">
                                        <div class="basic">
                                            <div class="row">
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>PO Number*</label>
                                                        <input type="text" class="form-control" name="po_number" value="<?php echo $resultData != null ? $resultData['po_number'] : '' ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Supplier Name*</label>
                                                        <select class="form-control" name="supplier_id" required>
                                                            <option selected="selected" value="">Please Select</option>
                                                            <?php foreach ($suppliers as $supplier) { ?>
                                                                <option value="<?php echo $supplier['Id_Supplier']; ?>" <?php echo $resultData != null && ($supplier['Id_Supplier'] == $resultData['supplier_id']) ? "selected" : '' ?>>
                                                                    <?php echo $supplier['Supplier_Name'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>PO Date*</label>
                                                        <input type="date" class="form-control" name="po_date" value="<?php echo $resultData != null ? $resultData['po_date'] : '' ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>PO Revision*</label>
                                                        <input type="text" class="form-control" name="po_revision" value="<?php echo $resultData != null ? $resultData['po_revision'] : '' ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>MTC Number*</label>
                                                        <input type="text" class="form-control" name="material_certificate_number" required>
                                                        <?php if (isset($_GET['existcert'])) { ?>
                                                            <small class="text-danger">The material certificate number has
                                                                already been taken</small>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group ver-disabled">
                                                        <label>MTC Revision*</label>
                                                        <input type="text" class="form-control" name="mtc_revision" value="0" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>MTC Date*</label>
                                                        <input type="date" class="form-control" value="<?php echo $resultData != null ? $resultData['mtc_date'] : '' ?>" name="mtc_date" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Item Code*</label>
                                                        <input type="text" class="form-control" name="item_code" value="<?php echo $resultData != null ? $resultData['item_code'] : '' ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Size*</label>
                                                        <select class="form-control" data-control="select2" name="size_id" required>
                                                            <option selected="selected" value="">Please Select</option>
                                                            <?php foreach ($sizes as $size) { ?>
                                                                <option value=<?php echo $size['id']; ?> <?php echo $resultData != null && ($size['id'] == $resultData['size_id']) ? "selected" : '' ?>>
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
                                                                <option value=<?php echo $class['id']; ?> <?php echo $resultData != null && ($class['id'] == $resultData['class_id']) ? "selected" : '' ?>>
                                                                    <?php echo $class['class'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Material Specification*</label>
                                                        <select class="form-control" data-control="select2" name="material_specification_id" required id="materialSpec">
                                                            <option selected="selected" value="">Please Select</option>
                                                            <?php foreach ($materialSpecifications as $materialSpecification) { ?>
                                                                <option value=<?php echo $materialSpecification['id']; ?> <?php echo $resultData != null && ($materialSpecification['id'] == $resultData['material_specification_id']) ? "selected" : '' ?>>
                                                                    <?php echo $materialSpecification['material_specification'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
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
                                                        <input type="text" class="form-control" name="drawing_number" value="<?php echo $resultData != null ? $resultData['drawing_number'] : '' ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Component Name*</label>
                                                        <select class="form-control" data-control="select2" name="component_id" required>
                                                            <option selected="selected" value="">Please Select</option>
                                                            <?php foreach ($components as $component) { ?>
                                                                <option value=<?php echo $component['id']; ?> <?php echo $resultData != null && ($component['id'] == $resultData['component_id']) ? "selected" : '' ?>>
                                                                    <?php echo $component['component'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <div class="form-group">
                                                        <label>Material Certification Type*</label>
                                                        <select class="form-control" name="material_certification_type" required id="materialCertType">
                                                            <option selected="selected">
                                                                Please Select</option>
                                                            <option value="BS EN ISO 10204 - 3.1" <?php echo $resultData != null && ($resultData['material_certification_type'] == "BS EN ISO 10204 - 3.1") ? "selected" : '' ?>>
                                                                BS EN ISO 10204 - 3.1
                                                            </option>
                                                            <option value="BS EN ISO 10204 - 2.1" <?php echo $resultData != null && ($resultData['material_certification_type'] == "BS EN ISO 10204 - 2.1") ? "selected" : '' ?>>
                                                                BS EN ISO 10204 - 2.1
                                                            </option>
                                                            <option value="BS EN ISO 10204 - 2.2" <?php echo $resultData != null && ($resultData['material_certification_type'] == "BS EN ISO 10204 - 2.2") ? "selected" : '' ?>>
                                                                BS EN ISO 10204 - 2.2
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <div class="form-group">
                                                        <label>Heat Number*</label>
                                                        <input type="text" class="form-control" name="heat_number" required>
                                                        <!-- < ?php if (isset($_GET['existheat'])) { ?>
                                                        <small class="text-danger">The heat number has already been
                                                            taken</small>
                                                    < ?php } ?> -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <div class="form-group">
                                                        <label>Qty*</label>
                                                        <input type="text" class="form-control" name="qty" value="<?php echo $resultData != null ? $resultData['qty'] : '' ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 mt-5">
                                                    <div class="form-group">
                                                        <label>Certificate Type*</label>
                                                        <select class="form-control" name="certificate_type_id" id="certType" required>
                                                            <option value="">Please Select</option>
                                                            <?php foreach ($certificateTypes as $certificateType) { ?>
                                                                <option value=<?php echo $certificateType['id']; ?> <?php echo ($resultData != null && $resultData['certificate_type_id'] == "2") ? "selected" : '' ?>>
                                                                    <?php echo $certificateType['certificate_type_name'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="original-content">
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
                                                    <div class="tab-content mt-4 specific" id="material-specification-tabs">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-6">
                                            <div class="col-lg-12">
                                                <div class="form-group form-group-button" style="float:right">
                                                    <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Save</button>
                                                    <a type="button" href="/supplier-mtc.php" class="btn btn-sm btn-danger">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
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
    <script>
        $(window).bind('load', function() {
            var certType = $('#certType').val();
            $('#material-specification-tabs').empty();
            $('#original-content').empty();
            $("#transcripted-content").hide();
            $("#original-content").hide();
            if (certType == 2) {
                $("#transcripted-content").show();
                getMaterailSpecTables();
            }
        });

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

        $("#newCert button[type=submit]").click(function() {
            let key = $("#certType").val();
            if (key === "2") {
                var basicInput = "#newCert div.basic input:invalid";
                var basicSelect = "#newCert div.basic select:invalid";
                var specific = "#newCert div.specific input:invalid";
                if ($(basicInput).length == 0 && $(basicSelect).length == 0 && $(specific).length > 0) {
                    $('#fillAlert').modal('show');
                }
            }
        });

        function closeModal() {
            $('#fillAlert').modal('hide');
        }

        $(document).on("change", "#materialCertType", function() {
            let key = $(this).val();
            $("#certType option[value='1']").show();
            $("#certType option[value='2']").show();
            if (key === "BS EN ISO 10204 - 3.1") {
                $("#certType option[value='1']").hide();
            } else if (key === "BS EN ISO 10204 - 2.1" || key === "BS EN ISO 10204 - 2.2") {
                $("#certType option[value='2']").hide();
            }
            return $('#certType').trigger("change");
        });

        $(document).on("change", "#certType", function() {
            let key = $(this).val();
            $('#material-specification-tabs').empty();
            const originalContent =
                ` <div class="col-md-4"><div class="form-group"><input type="file" class="form-control" name="file" accept=".pdf" required></div></div>`;
            $('#original-content').empty();
            $("#transcripted-content").hide();
            $("#original-content").hide();

            if (key === "1") {
                $("#original-content").show()
                return $("#original-content").append(originalContent);
            } else if (key === "2") {
                $("#transcripted-content").show();
                return $('#materialSpec').trigger("change");
            }
            return null;
        });

        $(document).on("change", "#materialSpec", function() {
            let id = $(this).val();
            $("#edition").val("");
            if (id != "") {
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
                let key = $("#certType").val();
                if (key === "2") {
                    $('#material-specification-tabs').empty();
                    $.ajax({
                        url: "supplier-certificate-material-specification.php",
                        type: "POST",
                        dataType: "html",
                        data: {
                            id: id
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
        });

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
            if (actual != "") {
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
            if (actual != 0) {
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
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
    <div class="modal fade" id="fillAlert" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">DQMS - Alert!</h5>
                    <button type="button" class="close custom-danger" aria-label="Close" onclick="closeModal()">
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