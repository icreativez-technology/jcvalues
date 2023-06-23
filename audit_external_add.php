<?php
session_start();
include('includes/functions.php');
$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];

$auditeeSql = "SELECT * FROM Basic_Employee WHERE Status = 'Active';";
$auditeeConnectData = mysqli_query($con, $auditeeSql);
$auditeeData =  array();
while ($row = mysqli_fetch_assoc($auditeeConnectData)) {
    array_push($auditeeData, $row);
}
?>

<form class="form" action="includes/audit_management_store.php" method="post" enctype="multipart/form-data">
    <input type="hidden" class="form-control" value="External" name="audit_type" required>
    <div class="row">
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Area</label>
                <input type="text" class="form-control" name="audit_area" required>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Standard</label>
                <input type="text" class="form-control" name="audit_standard" required>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Auditor</label>
                <input type="text" class="form-control" name="auditor" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <input type="hidden" name="auditeeArr" id="auditeeArr" value='<?php echo json_encode($auditeeData) ?>'>
                <label class="required">Department</label>
                <select class="form-control" name="department_id" id="department" required>
                    <option value="">Please Select</option>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Department";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                    ?>
                    <option value="<?php echo $result_data['Id_department']; ?>">
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
                    data-select2-id="select2-data-7-oqcd" tabindex="-1" aria-hidden="true" required multiple>
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
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <label class="required">Name of the External Company</label>
                <input type="text" class="form-control" name="name_of_external_company" required>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Schedule Start Date</label>
                <input type="date" class="form-control" name="start_date" id="start_date" required>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Schedule End Date</label>
                <input type="date" class="form-control" name="end_date" id="end_date" required>
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
    getAuditee();
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