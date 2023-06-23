<?php
session_start();
include('includes/functions.php');
$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];
$areaDetailsData = null;
$auditeeMembers =  array();
$auditors =  array();
$lists =  array();
if (isset($_REQUEST['id'])) {
    $sqlArea = "SELECT * FROM admin_audit_area LEFT JOIN admin_audit_standard ON admin_audit_standard.id = admin_audit_area.audit_standard_id WHERE admin_audit_area.id = '$_REQUEST[id]' AND admin_audit_area.is_deleted = 0";
    $connectArea = mysqli_query($con, $sqlArea);
    $areaDetailsData = mysqli_fetch_assoc($connectArea);

    $existingAuditeeSqlData = "SELECT member_id, First_Name, Last_Name FROM admin_audit_area_assign_auditees LEFT JOIN Basic_Employee ON admin_audit_area_assign_auditees.member_id = Basic_Employee.Id_employee WHERE admin_audit_area_id = '$_REQUEST[id]' AND admin_audit_area_assign_auditees.is_deleted = 0";
    $auditeeMembersConnect = mysqli_query($con, $existingAuditeeSqlData);
    while ($row = mysqli_fetch_assoc($auditeeMembersConnect)) {
        array_push($auditeeMembers, $row['member_id']);
    }

    $auditorsSqlData = "SELECT * FROM admin_audit_standard_auditors WHERE admin_audit_standard_id = '$areaDetailsData[audit_standard_id]' AND is_deleted = 0";
    $auditorsSqlConnect = mysqli_query($con, $auditorsSqlData);
    while ($row = mysqli_fetch_assoc($auditorsSqlConnect)) {
        array_push($auditors, $row['member_id']);
    }

    $listSqlData = "SELECT * FROM admin_audit_area_assign_check_list WHERE is_deleted = 0 AND admin_audit_area_id = '$_REQUEST[id]'";
    $listData = mysqli_query($con, $listSqlData);
    while ($row = mysqli_fetch_assoc($listData)) {
        array_push($lists, $row);
    }
}
?>
<form class="form" action="includes/audit_management_store.php" method="post" enctype="multipart/form-data">
    <input type="hidden" class="form-control" value="Internal" name="audit_type" required>
    <div class="row">
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Area</label>
                <select class="form-control" name="audit_area_id" id="audit_area_id" required>
                    <option value="">Please Select</option>
                    <?php
                    $sql_data = "SELECT * FROM admin_audit_area WHERE status = 'Active' AND is_deleted = 0";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                    ?>
                    <option value="<?php echo $result_data['id']; ?>"
                        <?php echo ($areaDetailsData != null && $_REQUEST['id'] == $result_data['id']) ? 'selected' : ''; ?>>
                        <?php echo $result_data['audit_area']; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Checklist Format No</label>
                <input type="text" class="form-control"
                    value="<?php echo $areaDetailsData ? $areaDetailsData['audit_check_list_format_no'] : "" ?>"
                    required disabled>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Checklist Revision No</label>
                <input type="text" class="form-control"
                    value="<?php echo $areaDetailsData ? $areaDetailsData['revision_no'] : "" ?>" required disabled>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Standard</label>
                <input type="text" class="form-control"
                    value="<?php echo $areaDetailsData ? $areaDetailsData['audit_standard'] : "" ?>" disabled required>
            </div>
            <div class="col-lg-8 mt-5">
                <label class="required">Auditor</label>
                <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2"
                    data-hide-search="true" data-placeholder="Select Auditors" data-select2-id="select2-data-7-oqzx"
                    tabindex="-1" aria-hidden="true" required multiple disabled>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Employee";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                        if ($result_data['Status'] == 'Active') {
                    ?>
                    <option value="<?php echo $result_data['Id_employee']; ?>"
                        <?php echo (in_array($result_data['Id_employee'], $auditors)) ? 'selected' : ''; ?>>
                        <?php echo $result_data['First_Name']; ?>
                        <?php echo $result_data['Last_Name']; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <label class="required">Department</label>
                <select class="form-control" required disabled>
                    <option value="">Please Select</option>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Plant_deparment INNER JOIN Basic_Department ON Basic_Plant_deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plantId' AND Basic_Department.Status = 'Active'";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                    ?>
                    <option value="<?php echo $result_data['Id_department']; ?>"
                        <?php echo ($areaDetailsData && $areaDetailsData['department_id'] == $result_data['Id_department']) ? 'selected' : ''; ?>>
                        <?php echo $result_data['Department']; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-8 mt-5">
                <label class="required">Auditee</label>
                <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2"
                    data-hide-search="true" data-placeholder="Select Auditees" data-select2-id="select2-data-7-oqww"
                    tabindex="-1" aria-hidden="true" required multiple disabled>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Employee";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                        if ($result_data['Status'] == 'Active') {
                    ?>
                    <option value="<?php echo $result_data['Id_employee']; ?>"
                        <?php echo (in_array($result_data['Id_employee'], $auditeeMembers)) ? 'selected' : ''; ?>>
                        <?php echo $result_data['First_Name']; ?>
                        <?php echo $result_data['Last_Name']; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-3 mt-5">
                <label class="required">Finding Format No</label>
                <input type="text" class="form-control" name="finding_format_no" required>
            </div>
            <div class="col-lg-3 mt-5">
                <label class="required">Finding Revision No</label>
                <input type="text" class="form-control" name="revision_no" required>
            </div>
            <div class="col-lg-3 mt-5">
                <label class="required">Audit Schedule Start Date</label>
                <input type="date" class="form-control" name="start_date" id="start_date" required>
            </div>
            <div class="col-lg-3 mt-5">
                <label class="required">Audit Schedule End Date</label>
                <input type="date" class="form-control" name="end_date" id="end_date" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="container-full customer-header d-flex justify-content-between">
                Assign Check List
            </div>
            <div class="row" style="padding:0px 20px;">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_ncr_table">
                    <thead>
                        <tr class="text-start text-gray-400 text-uppercase gs-0" >
                            <th class="min-w-50px ps-3">Clause</th>
                            <th class="min-w-200px">Audit Point</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600" id="list-table">
                        <input type="hidden" name="dataArr" id="dataArr" value='<?php echo json_encode($lists) ?>'>
                        <?php if ($lists && count($lists) > 0) {
                            foreach ($lists as $key => $list) { ?>
                        <tr id="<?php echo $key  ?>">
                            <td class="ps-3"><input type="hidden" class="form-control" name="clause[]"
                                    value="<?php echo $list['clause']; ?>" required>
                                <?php echo $list['clause']; ?>
                            </td>
                            <td>
                                <input type="hidden" class="form-control" name="audit_point[]"
                                    value="<?php echo $list['audit_point']; ?>" required>
                                <?php echo $list['audit_point']; ?>
                            </td>
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
            <div style="text-align: right;"><input type="submit" class="btn btn-sm btn-success m-3" value="Save"><a
                    type="button" href="/audit_management.php" class="btn btn-sm btn-danger">Cancel</a></div>
        </div>
    </div>
</form>

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
<!--end::Javascript-->
</body>
<!--end::Body-->
<script>
$(document).ready(function() {
    var date = new Date();
    var min = date.getFullYear() +
        "-" +
        ("0" + (date.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + date.getDate()).slice(-2);
    document.getElementById("start_date").min = min;
    document.getElementById("end_date").min = min;
});
</script>

</html>