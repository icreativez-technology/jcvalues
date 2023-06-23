<?php
session_start();

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];
?>

<style>
.ver-disabled input {
    background-color: #e9ecef !important;
}

#issuance-form {
    height: 100%;
}

#receipt-form {
    height: 100%;
}
</style>

<!-- Issuance Modal -->
<div class="modal right fade card-body" id="issuanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="form" id="issuance-form" action="/includes/calibration_issuance_update.php" method="post">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title right-modal text-white">Issuance</h5>
                    <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="calibration_id" id="calibration_id"
                        value="<?php echo $_REQUEST['id']; ?>" />
                    <input type="hidden" name="plantId" id="plantId" value="<?php echo $plantId; ?>" />
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <label class="required">Issue Date</label>
                            <input type="date" class="form-control" name="issue_date" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <label class="required">Department</label>
                            <select class="form-control" name="department_id" id="department" required>
                                <option value="">Please Select</option>
                                <?php
                                $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plantId'";
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
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4 ver-disabled">
                            <label class="required">Owner</label>
                            <input type="text" class="form-control" id="owner" name="owner" readonly required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <label class="required">Collected by</label>
                            <input type="text" name="collected_by" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Calibration Out Modal -->
<div class="modal right fade card-body" id="editCalibrationHistory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" id="calibration_history_content">

    </div>
</div>

<script>
$(document).on("change", "#department", function() {
    $.ajax({
        url: "includes/get_department_head.php",
        type: "POST",
        dataType: "html",
        data: {
            plantId: $('#plantId').val(),
            departmentId: $('#department').val(),
        },
    }).done(function(res) {
        $('#owner').val(res);
    });
});
</script>