<?php
session_start();
include('includes/functions.php');
$mode = "edit";
if (isset($_REQUEST['view'])) {
    $mode = "view";
}
$execute = "false";
if (isset($_REQUEST['execute'])) {
    $execute = "true";
}

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];

$sqlAudit = "SELECT * FROM audit_management_list WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connecAudit = mysqli_query($con, $sqlAudit);
$auditDetailsData = mysqli_fetch_assoc($connecAudit);
$_SESSION['Page_Title'] = isset($_REQUEST['view']) ? "View Audit - " . $auditDetailsData['unique_id'] : "Edit Audit - " . $auditDetailsData['unique_id'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/audit_management_dashboard.php?a=auditManagement">Audit
                                    Management Dashboard</a> » <a href="/audit_management.php">Audit Management View
                                    List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush mt-4">
                            <div class="card-body">
                                <div class="container-full customer-header">
                                    Schedule Audit
                                </div>
                                <div class="row">
                                    <input type="hidden" name="audit_id" id="audit_id"
                                        value="<?php echo $auditDetailsData['id'] ?>">
                                    <input type="hidden" id="mode" value="<?php echo $mode ?>">
                                    <input type="hidden" id="execute" value="<?php echo $execute ?>">
                                    <div class="col-md-3 mt-5">
                                        <label class="required">Audit Type</label>
                                        <select class="form-control" name="audit_type" id="audit_type" disabled
                                            required>
                                            <option value="">Please Select</option>
                                            <option value="Internal"
                                                <?php echo ($auditDetailsData['audit_type'] == 'Internal') ? 'selected' : '' ?>>
                                                Internal</option>
                                            <option value="External"
                                                <?php echo ($auditDetailsData['audit_type'] == 'External') ? 'selected' : '' ?>>
                                                External</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="form-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>

    <?php include('includes/scrolltop.php'); ?>
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
    <script>
    var hostUrl = "assets/";

    $(document).ready(function() {
        getAuditPage();
    });

    function getAuditPage() {
        $("#form-content").empty();
        let id = $('#audit_id').val();
        let mode = $('#mode').val();
        let execute = $('#execute').val();
        if ($("#audit_type").val() == 'Internal') {
            $.get(`audit_internal_edit.php?id=${id}&mode=${mode}&execute=${execute}`, function(data) {
                $("#form-content").html(data);
            });
        } else if ($("#audit_type").val() == 'External') {
            $.get(`audit_external_edit.php?id=${id}&mode=${mode}`, function(data) {
                $("#form-content").html(data);
            });
        }
    }

    $('body').delegate('#audit_area_id', 'change', function() {
        let id = $('#audit_id').val();
        let areaId = $('#audit_area_id').val();
        $("#form-content").empty();
        $.get(`audit_internal_edit.php?id=${id}&area_id=${areaId}`, function(data) {
            $("#form-content").html(data);
        });
    });
    </script>
</body>

</html>