<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Task";
$email = $_SESSION['usuario'];
$sql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$empInfo = mysqli_fetch_assoc($fetch);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<?php include('includes/admin_check.php'); ?>
<!--begin::Body-->
<style>
    .i_size {
        font-size: 13px !important;
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
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <form class="form" action="includes/task-store.php" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="container-full customer-header d-flex justify-content-between">
                Task Details
            </div>
            <div class="row" style="padding: 0px 20px;">
                <div class="row mt-4 custom-row">
                    <div class="col-md-2 mt-6">
                        <label class="required">Task Title</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control i_size" name="title" required>
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
                        <input type="text" class="form-control i_size" name="project">
                    </div>
                    <div class="col-md-2 mt-6">
                        <label class="required">Priority</label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control i_size" name="priority" required>
                            <option value="">Please Select</option>
                            <option value="Low" class="status-green">Low</option>
                            <option value="Medium" class="status-blue">Medium</option>
                            <option value="High" class="status-yellow">High</option>
                            <option value="Critical" class="status-red">Critical</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row custom-row mt-3">
                    <div class="col-md-2 mt-6">
                        <label class="required">Due Date</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control i_size" name="due_date" required>
                    </div>
                    <div class="col-md-2 mt-6">
                        <label>Actual Date</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control i_size" name="actual_date">
                    </div>
                </div>
                <div class="form-group row custom-row mt-3">
                    <div class="col-md-2 mt-6">
                        <label class="required">Assigned To</label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control i_size" name="assigned_to" required>
                            <option value="">Please Select</option>
                            <?php
                            $consulta = "SELECT * FROM Basic_Employee Where Status = 'Active' And Id_employee != $empInfo[Id_employee]";
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
                    <div class="col-md-2 mt-6">
                        <label class="required">Status</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control i_size" name="status" required readonly value="<?php echo 'Not Started'; ?>">
                    </div>
                </div>
                <div class="form-group row custom-row mt-3">
                    <div class="col-md-2 mt-6">
                        <label class="required">Description</label>
                    </div>
                    <div class="col-md-10">
                        <textarea type="text" class="form-control i_size" name="description" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="row">
                    <div style="text-align: right;"><input type="submit" class="btn btn-sm btn-success m-3" value="Save"><a type="button" href="/task-management.php" class="btn btn-sm btn-danger">Cancel</a></div>
                </div>
            </div>
    </form>
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
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>