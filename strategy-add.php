<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "New Strategy";
$email = $_SESSION['usuario'];
$sql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$userInfo = mysqli_fetch_assoc($fetch);
?>
<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<!--begin::Body-->
<style>
    .ui-datepicker-calendar {
        display: none;
    }

    .required::after {
        content: "*";
        color: #e1261c;
    }

    .ver-disabled input {
        background-color: #e9ecef !important;
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

    #strategy-form {
        height: 100%;
    }

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        top: 0 !important;
        right: 0 !important;
        margin: auto;
        width: 320px;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Left*/
    .modal.left.fade .modal-dialog {
        left: -320px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog {
        left: 0;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
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
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/strategy.php">Strategy</a> »
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
                        <div class="card card-flush">
                            <form class="form" action="includes/strategy-store.php" method="post" enctype="multipart/form-data">
                                <!-- begin::Form Content -->
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        Add New Strategy
                                    </div>
                                    <div id="custom-section-1">
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Year</label>
                                                <input type="number" class="date-own form-control" name="year" required>
                                                <?php if (isset($_GET['existyear'])) { ?>
                                                    <small class="text-danger">The selected year has
                                                        already been taken</small>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Revision</label>
                                                <input type="text" class="form-control" name="revision" value="0" readonly required>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Created By</label>
                                                <input type="hidden" class="form-control" name="created_by" value="<?php echo $userInfo['Id_employee'] ?>" readonly required>
                                                <input type="text" class="form-control" value="<?php echo $userInfo['First_Name'] . ' ' . $userInfo['Last_Name']; ?>" readonly>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Approved By</label>
                                                <select class="form-control" name="approved_by" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Basic_Employee";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active') {
                                                    ?>
                                                            <option value="<?php echo $result_data['Id_employee']; ?>">
                                                                <?php echo $result_data['First_Name']; ?>
                                                                <?php echo $result_data['Last_Name']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        Strategy Details
                                        <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#strategy-modal"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <table class="table table-row-dashed fs-6 gy-5">
                                                <thead>
                                                    <tr class="text-start text-muted text-uppercase gs-0">
                                                        <th class="min-w-300px ps-3">
                                                            Strategy</th>
                                                        <th class="min-w-100px ">
                                                            Type</th>
                                                        <th class="min-w-100px">
                                                            Priority</th>
                                                        <th class="min-w-50px">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 fw-bold" id="list-table">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end::Form Content -->
                                <div class="card-footer">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Save</button>
                                            <a type="button" href="/strategy.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Content-->
                            </form>
                        </div>
                    </div>
                    <!--end::Container-->
                    <!-- Mitigation Modal start -->

                    <div class="modal right fade" id="strategy-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="strategy-form" class="form" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header right-modal">
                                        <h5 class="modal-title" id="staticBackdropLabel">Add Strategy
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetModalVal()" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="overflow-y: scroll;">
                                        <div class="row mt-2">
                                            <div class="col-md-12 mt-2">
                                                <label class="required">Strategy</label>
                                                <textarea type="text" class="form-control" id="strategyModal" name="strategyModal" rows="4" required></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12 mt-2">
                                                <label class="required">Type</label>
                                                <select class="form-control" id="typeModal" name="typeModal" required>
                                                    <option value="">Select</option>
                                                    </option>
                                                    <option value="FO">FO</option>
                                                    </option>
                                                    <option value="FA">FA</option>
                                                    </option>
                                                    <option value="DO">DO</option>
                                                    </option>
                                                    <option value="DA">DA</option>
                                                    </option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12 mt-2">
                                                <label class="required">Priority</label>
                                                <select class="form-control" name="threatsModal" id="threatsModal" required>
                                                    <option value="">Select</option>
                                                    </option>
                                                    <option value="High">High</option>
                                                    </option>
                                                    <option value="Medium">Medium</option>
                                                    </option>
                                                    <option value="Low">Low</option>
                                                    </option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-sm btn-success" id="strategy-submit">Add</button>
                                        <button type="button" class="btn btn-sm btn-danger" id="strategy-cancel" data-bs-dismiss="modal" onclick="resetModalVal();">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- Mitigation Modal End -->


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

    <!--end::Page Custom Javascript-->
    <script>
        let rowId = 0;
        let editRowId = "";

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('.date-own').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });

        $('#strategy-form').submit(function(e) {
            e.preventDefault()
            let strategyModal = $("#strategyModal").val();
            let typeModal = $("#typeModal").val();
            let typeModalContent = $("#typeModal option:selected").text();
            let threatsModal = $("#threatsModal").val();
            let threatsModalContent = $("#threatsModal option:selected").text();
            return appendTask(strategyModal, typeModal, typeModalContent, threatsModal, threatsModalContent);
        });


        function appendTask(strategyModal, typeModal, typeModalContent, threatsModal, threatsModalContent) {
            if (editRowId != "") {
                let content = `
        <td><input class="form-control" type="hidden" name="strategy[]" value="${strategyModal}" required>${strategyModal}</td>
        <td><input class="form-control" type="hidden" name="type[]" value="${typeModal}" required>${typeModalContent}</td>
        <td><input class="form-control" type="hidden" name="threats[]" value="${threatsModal}" required>${threatsModalContent}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>`
                $('#' + editRowId).empty();
                $('#' + editRowId).append(content);
            } else {
                rowId++;
                let content = `<tr id="${rowId}"> <td><input class="form-control" type="hidden" name="strategy[]" value="${strategyModal}" required>${strategyModal}</td>
        <td><input class="form-control" type="hidden" name="type[]" value="${typeModal}" required>${typeModalContent}</td>
        <td><input class="form-control" type="hidden" name="threats[]" value="${threatsModal}" required>${threatsModalContent}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td></tr>`
                $('#list-table').append(content);
            }
            return $('#strategy-cancel').trigger("click");
        }

        function resetModalVal() {
            editRowId = "";
            $("#strategyModal").val("");
            $("#typeModal").val("");
            return $("#threatsModal").val("");
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
            let strategy = $(row).find('input[name="strategy[]"').val();
            let type = $(row).find('input[name="type[]"').val();
            let threats = $(row).find('input[name="threats[]"').val()
            return {
                strategy,
                type,
                threats,
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#strategyModal').val(dataArr.strategy);
                $('#typeModal').val(dataArr.type);
                $('#threatsModal').val(dataArr.threats);
                return true;
            }
            return false;
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>