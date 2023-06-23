<?php
session_start();
include('includes/functions.php');
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$empId = $roleInfo['Id_employee'];
$getDataQuery = "SELECT * FROM tasks WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $getDataQuery);
$resultData = mysqli_fetch_assoc($connectData);
$mainAccess = ($role == 1 || $empId == $resultData['created_by']) ? true : false;
$subAccess = ($role == 1 || $empId == $resultData['assigned_to']) ? true : false;
$listSqlData = "SELECT * FROM sub_tasks WHERE is_deleted = 0 AND task_id = '$_REQUEST[id]'";
$listData = mysqli_query($con, $listSqlData);
$lists =  array();
while ($row = mysqli_fetch_assoc($listData)) {
    array_push($lists, $row);
}
$_SESSION['Page_Title'] = "Edit Task - " . $resultData['task_id'];
$disabled = $_REQUEST['mode'] == "view" ? true : false;
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>
<!--begin::Body-->
<style>
    .i_size {
        font-size: 13px !important;
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

    .required::after {
        content: "*";
        color: #e1261c;
    }

    .status-green {
        color: #2d9f50 !important;
        font-weight: 500;
    }

    .status-red {
        color: #f81c1c !important;
        font-weight: 500;
    }

    .status-yellow {
        color: #f08709 !important;
        font-weight: 500;
    }

    .status-orange {
        color: #fc7150 !important;
        font-weight: 500;
    }

    .status-blue {
        color: #004cf9 !important;
        font-weight: 500;
    }

    .custom-row .form-control {
        border-right: none;
        border-left: none;
        border-top: none;
        border-radius: 0%;
    }

    .custom-row .form-select {
        border-right: none;
        border-left: none;
        border-top: none;
        border-radius: 0%;
    }

    #sub-task-form {
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

    <form class="form" action="includes/task-update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="task_id" name="task_id" value="<?php echo $resultData['id']; ?>">
        <div class="card-body">
            <div class="container-full customer-header d-flex justify-content-between">
                Task Details
            </div>
            <div class="row" style="padding:0px 20px;">
                <div class="form-group row custom-row  mt-3">
                    <div class="col-md-2 mt-6">
                        <label class="required">Task Title</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control i_size" name="title" required value="<?php echo $resultData['title'] ?>" <?php echo ($disabled || !$mainAccess) ? "disabled" : "" ?>>
                        <?php if (isset($_GET['exist'])) { ?>
                            <small class="text-danger">The title name has already been taken</small>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row custom-row mt-3">
                    <div class="col-md-2 mt-6">
                        <label>Project (Optional)</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control i_size" name="project" value="<?php echo $resultData['project'] ?>" <?php echo ($disabled || !$mainAccess) ? "disabled" : "" ?>>
                    </div>
                    <div class="col-md-2 mt-6">
                        <label class="required">Priority</label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control i_size" name="priority" required <?php echo ($disabled || !$mainAccess) ? "disabled" : "" ?>>
                            <option value="">Please Select</option>
                            <option value="Low" class="status-green" <?php echo ($resultData['priority'] == "Low") ? 'selected' : ''; ?>>Low</option>
                            <option value="Medium" class="status-blue" <?php echo ($resultData['priority'] == "Medium") ? 'selected' : ''; ?>>Medium</option>
                            <option value="High" class="status-yellow" <?php echo ($resultData['priority'] == "High") ? 'selected' : ''; ?>>High</option>
                            <option value="Critical" class="status-red" <?php echo ($resultData['priority'] == "Critical") ? 'selected' : ''; ?>>Critical
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row custom-row mt-3">
                    <div class="col-md-2 mt-6">
                        <label class="required">Due Date</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control i_size" name="due_date" required value="<?php echo $resultData['due_date'] ?>" <?php echo ($disabled || !$mainAccess) ? "disabled" : "" ?>>
                    </div>
                    <div class="col-md-2 mt-6">
                        <label>Actual Date</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control i_size" name="actual_date" value="<?php echo $resultData['actual_date'] ?>" <?php echo ($disabled || (!$mainAccess && !$subAccess)) ? "disabled" : "" ?>>
                    </div>

                </div>
                <div class="row custom-row mt-3">
                    <div class="col-md-2 mt-6">
                        <label class="required">Assigned To</label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control i_size" name="assigned_to" required <?php echo ($disabled || !$mainAccess) ? "disabled" : "" ?>>
                            <option value="">Please Select</option>
                            <?php
                            $consulta = "SELECT * FROM Basic_Employee Where Status = 'Active' And Id_employee != $empId";
                            $consulta_general = mysqli_query($con, $consulta);
                            while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                            ?>
                                <option value="<?php echo $result_data['Id_employee']; ?>" <?php if ($result_data['Id_employee'] ==  $resultData['assigned_to']) {
                                                                                                echo "selected";
                                                                                            } ?>>
                                    <?php echo $result_data['First_Name'] . ' ' . $result_data['Last_Name']; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mt-6">
                        <label class="required">Status</label>
                    </div>
                    <div class="col-md-4">
                        <Select class="form-control i_size" id="status" name="status" required <?php echo ($disabled || (!$mainAccess && !$subAccess)) ? "disabled" : "" ?>>
                            <option value="">Please Select</option>
                            <option value="Not Started" class="status-orange" <?php echo ($resultData['status'] == "Not Started") ? 'selected' : ''; ?>>Not Started
                            </option>
                            <option value="In Progress" class="status-blue" <?php echo ($resultData['status'] == "In Progress") ? 'selected' : ''; ?>>In Progress
                            </option>
                            <option value="In Review" class="status-yellow" <?php echo ($resultData['status'] == "In Review") ? 'selected' : ''; ?>>In Review
                            </option>
                            <option value="Completed" class="status-green" <?php echo ($resultData['status'] == "Completed") ? 'selected' : ''; ?>>Completed
                            </option>
                            <option value="Cancelled" class="status-red" <?php echo ($resultData['status'] == "Cancelled") ? 'selected' : ''; ?>>Cancelled
                            </option>
                        </Select>
                    </div>
                </div>
                <div class="row custom-row">
                    <div class="col-md-2 mt-6">
                        <label class="required">Description</label>
                    </div>
                    <div class="col-md-10">
                        <textarea type="text" class="form-control i_size" name="description" rows="3" <?php echo ($disabled || !$mainAccess) ? "disabled" : "" ?>><?php echo $resultData['description']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="container-full customer-header d-flex justify-content-between">
                        Sub Tasks
                        <?php if (!$disabled && $subAccess) { ?>
                            <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#sub-task-modal"><i class="fa fa-plus"></i></a>
                        <?php } ?>
                    </div>
                    <div class="row" style="padding:0px 20px">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_subtask_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 text-uppercase gs-0">
                                    <th class="min-w-400px ps-3">Title</th>
                                    <th class="min-w-200px">Date</th>
                                    <th class="min-w-100px">Responsible Person</th>
                                    <th class="min-w-100px" data-column="subtask_status">Status</th>
                                    <?php if (!$disabled && $subAccess) { ?>
                                        <th class="min-w-100px pe-3">Action</th>
                                    <?php } ?>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600" id="list-table">
                                <?php if ($lists && count($lists) > 0) {
                                    foreach ($lists as $key => $list) { ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="dataArr" value='<?php echo json_encode($list) ?>'>
                                                <?php echo $list['title'] ?>
                                            </td>
                                            <td><?php echo date("d-m-y", strtotime($list['date'])); ?></td>
                                            <td>
                                                <?php
                                                $consulta = "SELECT * FROM Basic_Employee Where Status = 'Active'";
                                                $consulta_general = mysqli_query($con, $consulta);
                                                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                                    if ($result_data['Id_employee'] ==  $list['responsible']) {
                                                        echo $result_data['First_Name'] . ' ' . $result_data['Last_Name'];
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php $mode = ($disabled) ? "view" : "edit" ?>
                                                <?php if ($list['status'] == '1') { ?>
                                                    <input class="form-control task-status" type="hidden" name="subtask_status" value="1" required>
                                                    <a class="status-danger cursor-pointer" data-id="<?php echo $list['id'] ?>" data-mode="<?php echo $mode ?>" data-access="<?php echo $subAccess ?>" onclick="changeStatus(this)">Open</a>
                                                <?php } else { ?>
                                                    <input class="form-control task-status" type="hidden" name="subtask_status" value="0" required>
                                                    <a class="status-active cursor-pointer" data-id="<?php echo $list['id'] ?>" data-mode="<?php echo $mode ?>" data-access="<?php echo $subAccess ?>" onclick="changeStatus(this)">Closed</a>
                                                <?php } ?>
                                            </td>
                                            <?php if (!$disabled && $subAccess) { ?>
                                                <td class="list-row" style="vertical-align:middle">
                                                    <a class="list-edit cursor-pointer me-2" data-id="<?php echo $list['id'] ?>"><i class="bi bi-pencil"></i></a>
                                                    <a class="list-remove cursor-pointer" data-id="<?php echo $list['id'] ?></td>"><i class="bi bi-trash"></i></a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="row">
                    <div style="text-align: right;">
                        <?php if ($disabled || (!$mainAccess && !$subAccess)) { ?>
                            <a type="button" href="/task-management.php" class="btn btn-sm btn-danger">Close</a>
                        <?php } else { ?>
                            <input type="submit" class="btn btn-sm btn-success m-3" value="Update">
                            <a type="button" href="/task-management.php" class="btn btn-sm btn-danger">Cancel</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
    </form>
    <!--end::Form-->

    <!-- Mitigation Modal start -->

    <div class="modal right fade" id="sub-task-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="sub-task-form" class="form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header right-modal">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Sub task
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetModalVal()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" id="subtaskId" name="subtaskId" value="">
                                <label class="required">Title</label>
                                <textarea class="form-control" name="subtaskTitle" id="subtaskTitle" required></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 mt-2">
                                <label class="required">Date</label>
                                <input type="date" class="form-control" name="subtaskDate" id="subtaskDate" required>

                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 mt-2">
                                <label class="required">Responsible person</label>
                                <select class="form-control" name="subtaskResponsible" id="subtaskResponsible" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    $consulta = "SELECT * FROM Basic_Employee where Status = 'Active'";
                                    $consulta_general = mysqli_query($con, $consulta);
                                    while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                    ?>
                                        <option value="<?php echo $result_data['Id_employee']; ?>">
                                            <?php echo $result_data['First_Name'] . ' ' . $result_data['Last_Name']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success" id="subTask-submit">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" id="subTask-cancel" data-bs-dismiss="modal" onclick="resetModalVal()">Close</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- Mitigation Modal End -->

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
        $('body').delegate('.list-remove', 'click', function() {
            let task_id = $('#task_id').val();
            let subtaskId = $(this).data('id');
            $.ajax({
                url: "includes/sub-task-delete.php",
                type: "POST",
                dataType: "html",
                data: {
                    task_id,
                    subtaskId,
                },
            }).done(function(resultado) {
                if (resultado) {
                    $('#list-table').empty();
                    return $('#list-table').append(resultado);
                }
                return alert('Try Again');
            });
        });

        $('#sub-task-form').submit(function(e) {
            e.preventDefault();
            // $('#status').val('');
            let task_id = $('#task_id').val();
            let subtaskId = $('#subtaskId').val();
            let subtaskTitle = $('#subtaskTitle').val();
            let subtaskDate = $('#subtaskDate').val();
            let subtaskResponsible = $('#subtaskResponsible').val();
            $.ajax({
                url: "includes/sub-task-update.php",
                type: "POST",
                dataType: "html",
                data: {
                    task_id,
                    subtaskId,
                    subtaskTitle,
                    subtaskDate,
                    subtaskResponsible
                },
            }).done(function(resultado) {
                if (resultado) {
                    $('#list-table').empty();
                    $('#list-table').append(resultado);
                    return $('#subTask-cancel').trigger("click");
                }
                return alert('Try Again');
            });
        });

        function resetModalVal() {
            $("#subtaskId").val("");
            $("#subtaskTitle").val("");
            $("#subtaskTitle").val("");
            $("#subtaskDate").val("");
            return $("#subtaskResponsible").val("");
        }

        $('body').delegate('.list-edit', 'click', function() {
            let getData = getValue($(this).closest('tr'));
            let setData = setValue(getData);
            if (setData) {
                return $('#list-add')[0].click();
            }
        });


        function getValue(row) {
            let subtask = JSON.parse((row).find('input[name="dataArr"]').val());
            return {
                subtaskId: subtask.id,
                subtaskTitle: subtask.title,
                subtaskDate: subtask.date,
                subtaskResponsible: subtask.responsible
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#subtaskId').val(dataArr.subtaskId);
                $('#subtaskTitle').val(dataArr.subtaskTitle);
                $('#subtaskDate').val(dataArr.subtaskDate);
                $('#subtaskResponsible').val(dataArr.subtaskResponsible);
                return true;
            }
            return false;
        }

        function changeStatus(obj) {
            // $('#status').val('');
            let id = $(obj).attr('data-id');
            let mode = $(obj).attr('data-mode');
            let access = $(obj).attr('data-access');
            if (mode == "edit" && access) {
                if ($(obj).text() == "Open") {
                    let update = updateSubtaskStat('0', id);
                    if (update) {
                        $(obj).attr('class', 'status-active cursor-pointer');
                        $(obj).text('Closed');
                        $(obj).parent().find(".task-status").val(0);
                    }
                } else {
                    let update = updateSubtaskStat('1', id);
                    if (update) {
                        $(obj).attr('class', 'status-danger cursor-pointer');
                        $(obj).text('Open');
                        $(obj).parent().find(".task-status").val(1);
                    }
                }
            }
        }


        function updateSubtaskStat(value, id) {
            $.ajax({
                url: "includes/subtask-status-update.php",
                type: "POST",
                dataType: "html",
                data: {
                    status: value,
                    id: id
                },
            })
            return true;
        }



        $('#status').on('change', function() {
            if ($('#status').val() == 'Completed') {
                let statusValid = false;
                $('#list-table tr td:nth-child(4)').each(function(index, elem) {
                    if ($(elem).find('input[name="subtask_status"]')[0].value == '1') {
                        statusValid = true;
                    }
                })
                if (statusValid) {
                    $('#status').val('');
                    return alert('subtasks are still open')
                }
            }
        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>