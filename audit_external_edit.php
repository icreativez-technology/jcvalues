<?php
session_start();
include('includes/functions.php');
$disabled = $_REQUEST['mode'] == "view" ? true : false;

$auditeeSql = "SELECT * FROM Basic_Employee WHERE Status = 'Active';";
$auditeeConnectData = mysqli_query($con, $auditeeSql);
$auditeeData =  array();
while ($row = mysqli_fetch_assoc($auditeeConnectData)) {
    array_push($auditeeData, $row);
}

$sqlAudit = "SELECT * FROM audit_management_list WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connecAudit = mysqli_query($con, $sqlAudit);
$auditDetailsData = mysqli_fetch_assoc($connecAudit);

$sqlExternal = "SELECT * FROM external_and_customer_audits WHERE audit_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectExternal = mysqli_query($con, $sqlExternal);
$externalAuditData = mysqli_fetch_assoc($connectExternal);

$assigneeSqlData = "SELECT member_id, First_Name, Last_Name FROM external_and_customer_audit_assign_auditees LEFT JOIN Basic_Employee ON external_and_customer_audit_assign_auditees.member_id = Basic_Employee.Id_employee WHERE audit_id = '$_REQUEST[id]' AND external_and_customer_audit_assign_auditees.is_deleted = 0";
$assigneeConnectData = mysqli_query($con, $assigneeSqlData);
$assignee =  array();
while ($row = mysqli_fetch_assoc($assigneeConnectData)) {
    array_push($assignee, $row['member_id']);
}
?>

<form class="form" action="includes/audit_management_update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" class="form-control" name="audit_type" value="External">
    <input type="hidden" class="form-control" name="id" value="<?php echo $auditDetailsData['id'] ?>">
    <div class="row">
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Area</label>
                <input type="text" class="form-control" name="audit_area"
                    value="<?php echo $externalAuditData['audit_area'] ?>" required
                    <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Standard</label>
                <input type="text" class="form-control" name="audit_standard"
                    value="<?php echo $externalAuditData['audit_standard'] ?>" required
                    <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Auditor</label>
                <input type="text" class="form-control" name="auditor"
                    value="<?php echo $externalAuditData['auditor'] ?>" required
                    <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <input type="hidden" name="auditeeArr" id="auditeeArr" value='<?php echo json_encode($auditeeData) ?>'>
                <label class="required">Department</label>
                <select class="form-control" name="department_id" id="department" required
                    <?php echo ($disabled) ? "disabled" : "" ?>>
                    <option value="">Please Select</option>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Department";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                    ?>
                    <option value="<?php echo $result_data['Id_department']; ?>"
                        <?php echo ($externalAuditData['department_id'] == $result_data['Id_department']) ? 'selected' : ''; ?>>
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
                    data-hide-search="true" data-placeholder="Select Auditees" name="auditee[]" id="auditee"
                    data-select2-id="select2-data-7-oqcd" tabindex="-1" aria-hidden="true" required multiple
                    <?php echo ($disabled) ? "disabled" : "" ?>>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Employee";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                        if ($result_data['Status'] == 'Active') {
                    ?>
                    <option value="<?php echo $result_data['Id_employee']; ?>"
                        <?php echo (in_array($result_data['Id_employee'], $assignee)) ? 'selected' : ''; ?>>
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
                <label class="required">Name of the External Company</label>
                <input type="text" class="form-control" name="name_of_external_company"
                    value="<?php echo $externalAuditData['name_of_external_company'] ?>" required
                    <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Schedule Start Date</label>
                <input type="date" class="form-control" name="start_date" id="start_date"
                    value="<?php echo $auditDetailsData['start_date'] ?>" required
                    <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Schedule End Date</label>
                <input type="date" class="form-control" name="end_date" id="end_date"
                    value="<?php echo $auditDetailsData['end_date'] ?>" required
                    <?php echo ($disabled) ? "disabled" : "" ?>>
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
</body>
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

$('#department').on('change', function() {
    getAuditee();
});

function getAuditee() {
    let departmentId = $('#department').val();
    let auditeeArr = JSON.parse($('#auditeeArr').val());
    filterArr = new Array();
    const auditee = auditeeArr.map((elem) => {
        if (elem.Id_department == departmentId) {
            return filterArr.push({
                name: `${elem.First_Name} ${elem.Last_Name}`,
                id: elem.Id_employee,
            })

        }
    })
    $("#auditee").empty();
    $("#auditee").append('<option value="">Please Select</option>');
    filterArr.map((elem) => {
        return $('#auditee').append(`<option value="${elem.id}">${elem.name}</option>`)
    })
}
</script>

</html>