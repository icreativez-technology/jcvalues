<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Supplier NC & CAPA Add";

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];

$supplierSql = "SELECT * FROM Basic_Supplier";
$supplierConnect = mysqli_query($con, $supplierSql);
$suppliers = mysqli_fetch_all($supplierConnect, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!--begin::Body-->
<style>
    .list-add {
       
        padding: 2px 5px;
        border-radius: 50%;
        font-size: 12px;
        color: #fff !important;
        cursor: pointer;
    }

    .list-add i {
        color: #fff;
    }

    #ncr_detail_form {
        height: 100%;
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
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/supplier_nc_capa.php">Supplier NC & CAPA</a> » <a href="/supplier_nc_capa_view_list.php">Supplier NC & CAPA View List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                    <!--end::body-->
                </div>
                <!--end::BREADCRUMBS-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush mt-4">
                            <form class="form" action="includes/supplier_nc_capa_store.php" method="post" enctype="multipart/form-data">
                                <!-- begin::Form Content -->
                                <div class="card-body">
                                    <div class="container-full customer-header">
                                        NCR Details
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 mt-5">
                                            <label class="required">Supplier Name</label>
                                            <select class="form-control" name="supplier_id" required>
                                                <option value="">Please Select</option>
                                                <?php foreach ($suppliers as $supplier) { ?>
                                                    <option value="<?php echo $supplier['Id_Supplier']; ?>">
                                                        <?php echo $supplier['Supplier_Name'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 mt-5">
                                            <label class="required">Date</label>
                                            <input type="date" class="form-control" name="date" required />
                                        </div>
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label class="required">Delivery Note</label>
                                            <input type="text" class="form-control" name="delivery_note" required />
                                        </div>
                                        <div class="col-lg-2  col-sm-12mt-5">
                                            <label class="required">PO Number</label>
                                            <input type="text" class="form-control" name="po_number" required />
                                        </div>
                                        <div class="col-lg-2 col-sm-12 mt-5">
                                            <label class="required">Line Item</label>
                                            <input type="text" class="form-control" name="line_item" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label class="required">Part Number</label>
                                            <input type="text" class="form-control" name="part_number" required />
                                        </div>
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label class="required">Part Description</label>
                                            <input type="text" class="form-control" name="part_description" required />
                                        </div>
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label class="required">Serial No/Heat No</label>
                                            <input type="text" class="form-control" name="serial_no" required />
                                        </div>
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label class="required">Material</label>
                                            <input type="text" class="form-control" name="material" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-sm-12 mt-5">
                                            <label class="required">Lot Quantity</label>
                                            <input type="text" class="form-control" name="lot_quantity" required />
                                        </div>
                                        <div class="col-lg-2 col-sm-12 mt-5">
                                            <label class="required">Inspected Quantity</label>
                                            <input type="text" class="form-control" name="inspected_quantity" required />
                                        </div>
                                        <div class="col-lg-2 col-sm-12 mt-5">
                                            <label class="required">Accepted Quantity</label>
                                            <input type="text" class="form-control" name="accepted_quantity" required />
                                        </div>
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label class="required">QTY NC's</label>
                                            <input type="text" class="form-control" name="qty_nc" required />
                                        </div>
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label>Stock Affected (if Applicable)</label>
                                            <input type="text" class="form-control" name="stock_affected" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label>NCR Classification </label>
                                            <select class="form-control" name="ncr_classification">
                                                <option value="">Please Select</option>
                                                <option value="Minor">Minor</option>
                                                <option value="Major">Major</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 mt-5">
                                            <label class="required">Classification Details</label>
                                            <input type="text" class="form-control" name="classification_details" required />
                                        </div>
                                        <div class="col-lg-3  col-sm-12 mt-5">
                                            <label class="required">Action with NC Material</label>
                                            <select class="form-control" name="action_with_nc_material" required>
                                                <option value="">Please Select</option>
                                                <option value="Accept">Accept</option>
                                                <option value="Reject">Reject</option>
                                                <option value="Repair">Repair</option>
                                                <option value="Concession">Concession</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3  col-sm-12 mt-5">
                                            <label class="required">Upload Evidence</label>
                                            <input type="file" class="form-control" name="files[]" accept=".pdf" multiple required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12  col-sm-12 mt-5">
                                            <label class="required">Non conformance Description</label>
                                            <textarea type="text" class="form-control" name="non_conformance_description" rows="2" required></textarea>
                                        </div>
                                    </div>
                                    <div class="container-full customer-header d-flex justify-content-between mt-4">
                                        NCR Details
                                        <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#ncr_detail_modal"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <div class="row">
                                                        
                                    <table class="table table-responsive align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_ncr_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                <th style='font-size: 8px; font-weight: bold;'>Description Action Adopted By JC</th>
                                                <th style='font-size: 8px; font-weight: bold;'>Responsible</th>
                                                <th style='font-size: 8px; font-weight: bold;'>Target Date</th>
                                                <th style='font-size: 8px; font-weight: bold;'>Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody  class="fw-bold text-gray-600" id="list-table">

                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="card-footer m-6">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-6">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Save
                                            </button>
                                            <a type="button" href="/supplier_nc_capa_view_list.php" class="btn btn-sm btn-secondary ms-2">Close</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->


        <div  width="20%" class="modal right fade modal-sm" id="ncr_detail_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" style="width: 80%;">
                <form id="ncr_detail_form" class="form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header right-modal">
                            <h5 class="modal-title" id="staticBackdropLabel">Add NCR Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetModalVal()"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required">Description of Action Adopted by JC</label>
                                    <textarea class="form-control" name="descriptionOfActionModal" id="descriptionOfActionModal" required></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Responsible</label>
                                    <input type="text" class="form-control" name="responsibleModal" id="responsibleModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Target Date</label>
                                    <input type="date" class="form-control" name="targetDate" id="targetDate" required>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success" id="ncr_detail_submit">Add</button>
                            <button type="button" class="btn btn-sm btn-danger" id="ncr_detail_cancel" data-bs-dismiss="modal" onclick="resetModalVal()">Close</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
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

        let rowId = 0;
        let editRowId = "";

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('#ncr_detail_form').submit(function(e) {
            e.preventDefault()
            let descriptionOfActionModal = $("#descriptionOfActionModal").val();
            let responsibleModal = $("#responsibleModal").val();
            let targetDate = $("#targetDate").val();
            return appendTask(descriptionOfActionModal, responsibleModal, targetDate);
        });


        function appendTask(descriptionOfActionModal, responsibleModal, targetDate) {
            if (editRowId != "") {
                let content = `
        <td><input class="form-control" type="hidden" name="description_of_action[]" value="${descriptionOfActionModal}" required>${descriptionOfActionModal}</td>
        <td><input class="form-control" type="hidden" name="responsible[]" value="${responsibleModal}" required>${responsibleModal}</td>
        <td><input class="form-control" type="hidden" name="target_date[]" value="${targetDate}" required>${targetDate}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>`
                $('#' + editRowId).empty();
                $('#' + editRowId).append(content);
            } else {
                rowId++;
                let content = `<tr id="${rowId}"> 
            <td><input class="form-control" type="hidden" name="description_of_action[]" value="${descriptionOfActionModal}" required>${descriptionOfActionModal}</td>
        <td><input class="form-control" type="hidden" name="responsible[]" value="${responsibleModal}" required>${responsibleModal}</td>
        <td><input class="form-control" type="hidden" name="target_date[]" value="${targetDate}" required>${targetDate}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>
        </tr>`
                $('#list-table').append(content);
            }
            return $('#ncr_detail_cancel').trigger("click");
        }

        function resetModalVal() {
            editRowId = "";
            $("#descriptionOfActionModal").val("");
            $("#responsibleModal").val("");
            return $("#targetDate").val("");
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
            let description_of_action = $(row).find('input[name="description_of_action[]"').val();
            let responsible = $(row).find('input[name="responsible[]"').val();
            let target_date = $(row).find('input[name="target_date[]"').val()
            return {
                description_of_action,
                responsible,
                target_date,
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#descriptionOfActionModal').val(dataArr.description_of_action);
                $('#responsibleModal').val(dataArr.responsible);
                $('#targetDate').val(dataArr.target_date);
                return true;
            }
            return false;
        }
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
</body>
<!--end::Body-->

</html>