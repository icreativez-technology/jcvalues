<?php
session_start();
include('includes/functions.php');
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];

$locationSql = "SELECT * FROM tbl_Countries";
$locationConnect = mysqli_query($con, $locationSql);
$locations = mysqli_fetch_all($locationConnect, MYSQLI_ASSOC);

$_SESSION['Page_Title'] = "Add Inspection";

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
    .custom-tab .nav-link {
        border-radius: 3px;
        padding: 8px 20px;
    }

    .custom-tab .nav-link.active {
        color: #fff !important;
        background-color: #009ef7;
    }

    .custom-tab .nav-link.active:hover {
        color: #fff !important;
    }

    .required::after {
        content: "*";
        color: #e1261c;
    }

    .custom-select {
        background-color: #f5f8fa;
        border: 1px solid #e4e6ef;
        border-radius: 6px;
        width: 100%;
        padding: 6px;
        min-height: 38px;
    }

    .custom-select .tag-wrapper {
        list-style: none;
        display: flex;
        justify-content: flex-start;
        align-content: flex-start;
        flex-wrap: wrap;
    }

    .tag-wrapper .tags {
        position: relative;
        padding: 0px 15px 0px 6px;
        margin: 4px;
        text-align: left;
        background-color: #e1e2e4;
        border-radius: 5px;
    }

    .tag-wrapper .tags span {
        position: absolute;
        right: 4px;
        cursor: pointer;
        color: #002429;
    }

    .tag-wrapper .tags span::after {
        content: "x";
        font-weight: 600;
    }

    .tag-wrapper .tags span:hover {
        color: #e1261c;
    }

    .tag-wrapper .tags a {
        color: #002429;
    }

    .tag-wrapper .tags a:hover {
        color: #e1261c;
    }

    .ver-disabled input {
        background-color: #e9ecef !important;
    }

    #product_details_form {
        height: 100%;
    }

    #inspection_agency_form {
        height: 100%;
    }

    #confirmation_product_details_form {
        height: 100%;
    }

    .list-add {
        background-color: transparent;
        padding: 2px 5px;
        border-radius: 50%;
        font-size: 12px;
        color: #fff !important;
        cursor: pointer;
    }

    .list-add i {
        color: #fff;
    }

    .tab-disabled,
    .ver-disabled input {
        background-color: #e9ecef !important;
    }

    .excel-dwn-btn {
        padding-top: 7px !important;
        padding-left: 7px !important;
        border-left: 2px solid #fff !important;
        font-weight: bolder !important;
    }
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/inspection_management.php">Inspection</a> » <a href="/inspection_view_list.php">Inspection List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush">
                            <form class="form" action="includes/inspection_store.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        Plan
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-2">
                                            <label class="required">From</label>
                                            <input type="datetime-local" class="form-control" name="from_date" id="from_date" min="" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="required">To</label>
                                            <input type="datetime-local" class="form-control" name="to_date" id="to_date" min="" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Customer</label>
                                            <select class="form-control" name="customer" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                $sql_data = "SELECT * FROM Basic_Customer";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    if ($result_data['Status'] == 'Active') {
                                                ?>
                                                        <option value="<?php echo $result_data['Id_customer']; ?>">
                                                            <?php echo $result_data['Customer_Name']; ?>
                                                        </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Customer PO</label>
                                            <input type="text" class="form-control" name="customer_po" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="required">Order Ref</label>
                                            <input type="text" class="form-control" name="order_ref" oninput="this.value = this.value.toUpperCase()" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                                <small class="text-danger">The order ref# has
                                                    already been taken</small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-3 ver-disabled">
                                            <label class="required">Notification Period</label>
                                            <input type="text" class="form-control" name="notification_no" id="notification_no" readonly required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Manufacturer</label>
                                            <input type="text" class="form-control" name="manufacturer" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="required">Stage of Inspection</label>
                                            <input type="text" class="form-control" name="stage_of_inspection" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Location</label>
                                            <select class="form-control" name="location" required>
                                                <option value="">Please Select</option>
                                                <?php foreach ($locations as $location) { ?>
                                                    <option value="<?php echo $location['CountryID']; ?>" <?= $selected; ?>>
                                                        <?php echo $location['CountryName'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-3">
                                            <label>Project Name (Optional)</label>
                                            <input type="text" class="form-control" name="project_name" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                        <div class="col-md-9">
                                            <label class="required">Equipment Description</label>
                                            <input type="text" class="form-control" name="equipment_description" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-3">
                                            <label class="required">ITP Number</label>
                                            <input type="text" class="form-control" name="itp_number" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="required">Revision</label>
                                            <input type="text" class="form-control" name="revision" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="required">ITP Activity</label>
                                            <input type="text" class="form-control" name="itp_activity" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Contact Person</label>
                                            <input type="text" class="form-control" name="contact_person" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Email</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-4">
                                            <label class="required">Place of Inspection</label>
                                            <input type="text" class="form-control" name="location_of_inspection" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>File Upload</label>
                                            <div class="align-items-center">
                                                <input type="file" class="form-control" name="file" accept=".pdf">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container-full customer-header d-flex justify-content-between mt-4">
                                        <span class="required">Product Details</span>
                                        <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#product_details_modal"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <div class="row" style="padding:0px 20px">
                                        <div class="d-flex justify-content-end">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary mt-2" id="import-product" data-bs-toggle="modal" data-bs-target="#excel-import-modal">Import</button>
                                                <a type="button" title="Format Download" href="/inspection_excel_format/product-details-format.xlsx" class="btn btn-primary excel-dwn-btn mt-2"><i class="bi bi-download"></i></a>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3">
                                            <thead>
                                                <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                    <th class="min-w-75px ps-3">Item No</th>
                                                    <th class="min-w-200px">Tag No</th>
                                                    <th class="min-w-100px">HR No</th>
                                                    <th class="min-w-200px pe-3">Type</th>
                                                    <th class="min-w-75px pe-3">Size</th>
                                                    <th class="min-w-100px pe-3">Bore</th>
                                                    <th class="min-w-100px pe-3">Class</th>
                                                    <th class="min-w-100px pe-3">Material</th>
                                                    <th class="min-w-100px pe-3">Qty</th>
                                                    <th class="min-w-50px pe-3">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600" id="list-table">
                                                <!-- Table rows content -->
                                            </tbody>
                                        </table>
                                    </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-4">
                                            <?php if (isset($_GET['product'])) { ?>
                                                <small class="text-danger me-6">Add atleast one product detail</small>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                            <a type="button" href="/inspection_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal right fade" id="product_details_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" style='width: 80%;'>
                <form id="product_details_form" class="form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header right-modal">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Product Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetModalVal()"></button>
                        </div>
                        <div class="modal-body" style="overflow-y: auto">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required">Item No</label>
                                    <input type="text" class="form-control" name="itemNoModal" id="itemNoModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label>Tag No</label>
                                    <input type="text" class="form-control" name="tagNoModal" id="tagNoModal">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">HR No</label>
                                    <input type="text" class="form-control" name="hrNoModal" id="hrNoModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Type</label>
                                    <input type="text" class="form-control" name="typeModal" id="typeModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Size</label>
                                    <input type="text" class="form-control" name="sizeModal" id="sizeModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Bore</label>
                                    <input type="text" class="form-control" name="boreModal" id="boreModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Class</label>
                                    <input type="text" class="form-control" name="classModal" id="classModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Material</label>
                                    <input type="text" class="form-control" name="materialModal" id="materialModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">QTY</label>
                                    <input type="text" class="form-control" name="qtyModal" id="qtyModal" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" id="product_details_cancel" onclick="resetModalVal()">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="excel-import-modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Excel Import</h5>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <div class="col-md-9">
                                <input type="file" class="form-control" name="excel-file-import" id="excel-file-import" accept=".xls,.xlsx" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer  text-center">
                        <button type="button" class="btn btn-sm btn-success" id="excel-import-btn">Import</button>
                        <button type="button" class="btn btn-sm btn-danger" id="excel-import-close" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>
    <?php include('includes/scrolltop.php'); ?>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>
    <script>
        $(document).ready(function() {
            var date = new Date();
            let maxDate = new Date().toISOString().slice(0, 16);
            document.getElementById("from_date").min = maxDate;
            document.getElementById("to_date").min = maxDate;
        });

        let rowId = 0;
        let editRowId = "";

        $('#from_date').on('change', function() {
            let fromDate = new Date($(this).val());
            let currentDate = new Date();
            diffDays = (fromDate.getTime() - currentDate.getTime()) / (1000 * 3600 * 24);
            return $('#notification_no').val((Math.abs(Math.round(diffDays))));
        });

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('#product_details_form').submit(function(e) {
            e.preventDefault()
            let itemNoModal = $("#itemNoModal").val();
            let tagNoModal = $("#tagNoModal").val();
            let hrNoModal = $("#hrNoModal").val();
            let typeModal = $("#typeModal").val();
            let sizeModal = $("#sizeModal").val();
            let boreModal = $("#boreModal").val();
            let classModal = $("#classModal").val();
            let materialModal = $("#materialModal").val();
            let qtyModal = $("#qtyModal").val();
            return appendTask(itemNoModal, tagNoModal, hrNoModal, typeModal, sizeModal, boreModal, classModal,
                materialModal, qtyModal);
        });


        function appendTask(itemNoModal, tagNoModal, hrNoModal, typeModal, sizeModal, boreModal, classModal, materialModal,
            qtyModal) {
            if (editRowId != "") {
                let content = `
        <td><input class="form-control" type="hidden" name="item_no[]" value="${itemNoModal}" required>${itemNoModal}</td>
        <td><input class="form-control" type="hidden" name="tag_no[]" value="${tagNoModal}">${tagNoModal}</td>
        <td><input class="form-control" type="hidden" name="hr_no[]" value="${hrNoModal}" required>${hrNoModal}</td>
        <td><input class="form-control" type="hidden" name="type[]" value="${typeModal}" required>${typeModal}</td>
        <td><input class="form-control" type="hidden" name="size[]" value="${sizeModal}" required>${sizeModal}</td>
        <td><input class="form-control" type="hidden" name="bore[]" value="${boreModal}" required>${boreModal}</td>
        <td><input class="form-control" type="hidden" name="class[]" value="${classModal}" required>${classModal}</td>
        <td><input class="form-control" type="hidden"name="material[]" value="${materialModal}" required>${materialModal}</td>
        <td><input class="form-control" type="hidden"name="qty[]" value="${qtyModal}" required>${qtyModal}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>`
                $('#' + editRowId).empty();
                $('#' + editRowId).append(content);
            } else {
                rowId++;
                let content = `<tr id="${rowId}"> 
            <td><input class="form-control" type="hidden" name="item_no[]" value="${itemNoModal}" required>${itemNoModal}</td>
        <td><input class="form-control" type="hidden" name="tag_no[]" value="${tagNoModal}">${tagNoModal}</td>
        <td><input class="form-control" type="hidden" name="hr_no[]" value="${hrNoModal}" required>${hrNoModal}</td>
        <td><input class="form-control" type="hidden" name="type[]" value="${typeModal}" required>${typeModal}</td>
        <td><input class="form-control" type="hidden" name="size[]" value="${sizeModal}" required>${sizeModal}</td>
        <td><input class="form-control" type="hidden" name="bore[]" value="${boreModal}" required>${boreModal}</td>
        <td><input class="form-control" type="hidden" name="class[]" value="${classModal}" required>${classModal}</td>
        <td><input class="form-control" type="hidden"name="material[]" value="${materialModal}" required>${materialModal}</td>
        <td><input class="form-control" type="hidden"name="qty[]" value="${qtyModal}" required>${qtyModal}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>
        </tr>`
                $('#list-table').append(content);
            }
            return $('#product_details_cancel').trigger("click");
        }

        function resetModalVal() {
            editRowId = "";
            $("#itemNoModal").val("");
            $("#tagNoModal").val("");
            $("#hrNoModal").val("");
            $("#typeModal").val("");
            $("#sizeModal").val("");
            $("#boreModal").val("");
            $("#classModal").val("");
            $("#materialModal").val("");
            return $("#qtyModal").val("");
        }

        $('body').delegate('.list-edit', 'click', function() {
            editRowId = $(this).closest('tr')[0].id;
            let getData = getValue($(this).closest('tr')[0]);
            let setData = setValue(getData);
            if (setData) {
                return $('#list-add')[0].click();
            }
        });


        function getValue(row) {
            let item_no = $(row).find('input[name="item_no[]"').val();
            let tag_no = $(row).find('input[name="tag_no[]"').val();
            let hr_no = $(row).find('input[name="hr_no[]"').val()
            let type = $(row).find('input[name="type[]"').val()
            let size = $(row).find('input[name="size[]"').val()
            let bore = $(row).find('input[name="bore[]"').val()
            let classItem = $(row).find('input[name="class[]"').val()
            let material = $(row).find('input[name="material[]"').val()
            let qty = $(row).find('input[name="qty[]"').val()

            return {
                item_no,
                tag_no,
                hr_no,
                type,
                size,
                bore,
                classItem,
                material,
                qty,
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $("#itemNoModal").val(dataArr.item_no);
                $("#tagNoModal").val(dataArr.tag_no);
                $("#hrNoModal").val(dataArr.hr_no);
                $("#typeModal").val(dataArr.type);
                $("#sizeModal").val(dataArr.size);
                $("#boreModal").val(dataArr.bore);
                $("#classModal").val(dataArr.classItem);
                $("#materialModal").val(dataArr.material);
                $("#qtyModal").val(dataArr.qty);
                return true;
            }
            return false
        }

        $(".date-time").on("change", function() {
            var fromDate = $("#from_date").val();
            var toDate = $("#to_date").val();
            if (fromDate != "") {
                if (toDate != "") {
                    var from = new Date(fromDate).getTime();
                    var to = new Date(toDate).getTime();
                    if (from > to) {
                        $("#to_date").val("");
                    }
                }
            } else {
                $("#to_date").val("");
            }
        });

        $('#excel-import-btn').on('click', function() {
            let isExport = importProductExcel();
            if (isExport) {
                $('#excel-import-close').click()
                return document.getElementById("excel-file-import").value = null;
            }
        });

        function importProductExcel() {
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;
            if (regex.test($("#excel-file-import").val().toLowerCase())) {
                var xlsxflag = false;
                if ($("#excel-file-import").val().toLowerCase().indexOf(".xlsx") > 0) {
                    xlsxflag = true;
                }
                if (typeof(FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var data = e.target.result;
                        if (xlsxflag) {
                            var workbook = XLSX.read(data, {
                                type: 'binary'
                            });
                        } else {
                            var workbook = XLS.read(data, {
                                type: 'binary'
                            });
                        }
                        var sheet_name_list = workbook.SheetNames;
                        var cnt = 0;
                        sheet_name_list.forEach(function(y) {

                            if (xlsxflag) {
                                var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                            } else {
                                var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);
                            }
                            if (exceljson.length > 0) {
                                exceljson?.map(function(elem) {
                                    appendTask(elem.Item_No, elem.Tag_No, elem.HR_No, elem.Type,
                                        elem.Size, elem.Bore, elem.Class, elem.Material, elem.QTY)
                                });
                            }
                        });
                    }
                    if (xlsxflag) {
                        reader.readAsArrayBuffer($("#excel-file-import")[0].files[0]);
                    } else {
                        reader.readAsBinaryString($("#excel-file-import")[0].files[0]);
                    }
                } else {
                    alert("Sorry! Your browser does not support HTML5!");
                }
            } else {
                alert("Please upload a valid Excel file!");
            }
            return true;
        }
    </script>
</body>

</html>

</html>