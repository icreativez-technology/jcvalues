<?php
session_start();
include('includes/functions.php');
$getDataQuery = "SELECT * FROM strategy WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $getDataQuery);
$resultData = mysqli_fetch_assoc($connectData);
$sql = "SELECT * From Basic_Employee Where Id_employee = $resultData[approved_by]";
$fetch = mysqli_query($con, $sql);
$approvedInfo = mysqli_fetch_assoc($fetch);
$sql = "SELECT * From Basic_Employee Where Id_employee = $resultData[created_by]";
$fetch = mysqli_query($con, $sql);
$createdInfo = mysqli_fetch_assoc($fetch);
$listSqlData = "SELECT * FROM strategy_list WHERE is_deleted = 0 AND strategy_id = '$_REQUEST[id]'";
$listData = mysqli_query($con, $listSqlData);
$lists =  array();
while ($row = mysqli_fetch_assoc($listData)) {
    array_push($lists, $row);
}
$publish = ($resultData['revision'] == 0 && $resultData['is_published'] == 0) ? "true" : "false";
$_SESSION['Page_Title'] = "Edit Strategy - " . $resultData['year'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!--begin::Body-->
<style>
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
                            <form class="form" action="includes/strategy-update.php" method="post" enctype="multipart/form-data" id="str-form">
                                <!-- begin::Form Content -->
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        Edit New Strategy
                                    </div>
                                    <div id="custom-section-1">
                                        <div class="form-group row">
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Year</label>
                                                <input type="number" class="form-control" name="year" value="<?php echo $resultData['year'] ?>" required readonly>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Revision</label>
                                                <input type="text" class="form-control" name="revision" value="<?php echo $resultData['revision'] ?>" readonly required>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Created By</label>
                                                <input type="hidden" class="form-control" name="created_by" value="<?php echo $createdInfo['Id_employee'] ?>" readonly required>
                                                <input type="text" class="form-control" value="<?php echo $createdInfo['First_Name'] . ' ' . $createdInfo['Last_Name']; ?>" readonly>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Approved By</label>
                                                <input type="hidden" class="form-control" name="approved_by" value="<?php echo $approvedInfo['Id_employee'] ?>" readonly required>
                                                <input type="text" class="form-control" value="<?php echo $approvedInfo['First_Name'] . ' ' . $approvedInfo['Last_Name']; ?>" readonly>
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
                                                    <input type="hidden" name="dataArr" id="dataArr" value='<?php echo json_encode($lists) ?>'>
                                                    <?php if ($lists && count($lists) > 0) {
                                                        foreach ($lists as $key => $list) { ?>
                                                            <tr id="<?php echo $key  ?>">
                                                                <td><input type="hidden" class="form-control" name="strategy[]" value="<?php echo $list['strategy']; ?>" required>
                                                                    <?php echo $list['strategy']; ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" class="form-control" name="type[]" value="<?php echo $list['type']; ?>" required>
                                                                    <?php if ($list['type'] == "FO") {
                                                                        echo "FO";
                                                                    } else if ($list['type'] == "FA") {
                                                                        echo "FA";
                                                                    } else if ($list['type'] == "DO") {
                                                                        echo "DO";
                                                                    } else if ($list['type'] == "DA") {
                                                                        echo "DA";
                                                                    }
                                                                    ?>

                                                                </td>
                                                                <td>
                                                                    <input type="hidden" class="form-control" name="threats[]" value="<?php echo $list['threats']; ?>" required>
                                                                    <?php
                                                                    switch ($list['threats']) {
                                                                        case 'Low':
                                                                            $cl = 'status-active';
                                                                            break;
                                                                        case 'Medium':
                                                                            $cl = 'status-warning';
                                                                            break;
                                                                        case 'High':
                                                                            $cl = 'status-danger';
                                                                            break;
                                                                    }
                                                                    echo '<div class="' . $cl . '">' . $list['threats'] . '</div>';
                                                                    ?>
                                                                </td>
                                                                <td class="list-row" style="vertical-align:middle">
                                                                    <a class="list-edit cursor-pointer me-2" data-id="<?php echo $list['id'] ?>"><i class="bi bi-pencil"></i></a>
                                                                    <a class="list-remove cursor-pointer" data-id="<?php echo $list['id'] ?></td>"><i class="bi bi-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
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
                                            <?php if ($publish == "true") { ?>
                                                <a type="button" class="btn btn-sm btn-warning ms-2" onclick="publish()">Publish</a>
                                            <?php } ?>
                                            <a type="button" href="/strategy.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="publish" value="<?php echo $publish; ?>">
                                <input type="hidden" name="id" value="<?php echo $resultData['id']; ?>">
                                <input type="hidden" name="action" id="action" value="save">
                                <!--end::Content-->
                            </form>
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->

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
    <!--end::Page Custom Javascript-->
    <script>
        let rowId = JSON.parse($('#dataArr').val()).length;
        let editRowId = "";

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('#strategy-form').submit(function(e) {
            e.preventDefault()
            let strategyModal = $("#strategyModal").val();
            let typeModal = $("#typeModal").val();
            let typeModalContent = $("#typeModal option:selected").text();
            let threatsModal = $("#threatsModal").val();
            let threat = $("#threatsModal option:selected").text();
            let cl = "";
            switch (threat) {
                case 'Low':
                    cl = 'status-active';
                    break;
                case 'Medium':
                    cl = 'status-warning';
                    break;
                case 'High':
                    cl = 'status-danger';
                    break;
            }
            let threatsModalContent = '<div class="' + cl + '">' + threat + '</div>';
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

        function publish() {
            $("#action").val("publish");
            $("#str-form").submit();
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>