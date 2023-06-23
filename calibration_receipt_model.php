<?php
session_start();
include('includes/functions.php');
$calibration_history_id = $_REQUEST['calibration_history_id'];
$calibration_id = $_REQUEST['calibration_id'];
$sqlData = "SELECT * FROM calibration_receipt WHERE calibration_history_id = '$calibration_history_id' AND is_deleted = 0";
$connectData = mysqli_query($con, $sqlData);
$calibrationReceipt = mysqli_fetch_assoc($connectData);
$historySql = "SELECT * FROM calibration_history WHERE calibration_id = '$_REQUEST[calibration_id]' AND is_deleted = 0";
$historyConnectData = mysqli_query($con, $historySql);
$historyData =  array();
while ($row = mysqli_fetch_assoc($historyConnectData)) {
    array_push($historyData, $row);
}

?>
<form class="form" id="receipt-form" action="/includes/calibration_receipt_update.php" method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title right-modal text-white">Receipt</h5>
                <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="calibration_id" value="<?php echo $calibration_id ?>" />
                <input type="hidden" name="calibration_history_id" value="<?php echo $calibration_history_id ?>" />
                <input type="hidden" name="calibration_receipt_id" value="<?php echo $calibrationReceipt['id'] ?>" />
                <div class="row">
                    <div class="col-md-6">
                        <label class="required">Receipted Date</label>
                        <input type="date" class="form-control" name="receipted_date" value="<?php echo $calibrationReceipt['receipted_date'] ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label class="required">Received from</label>
                        <input class="form-control" type="text" name="received_from" value="<?php echo $calibrationReceipt['received_from'] ?>" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <label class="required">Received For</label>
                        <input class="form-control" type="text" name="received_for" value="<?php echo $calibrationReceipt['received_for'] ?>" required />
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="required">Instrument condition</label>
                        <input class="form-control" type="text" name="instrument_condition" value="<?php echo $calibrationReceipt['instrument_condition'] ?>" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <label class="required">Storage location</label>
                        <input type="text" name="storage_location" class="form-control" value="<?php echo $calibrationReceipt['storage_location'] ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <label class="required">Remarks</label>
                        <input type="text" name="remarks" class="form-control" value="<?php echo $calibrationReceipt['remarks'] ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <label>Attachments <small>Instrument Photo</small></label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
                        </div>
                    </div>
                </div>
                <?php
                $sql_data = "SELECT * FROM calibration_receipt_files WHERE calibration_history_id = '$calibration_history_id' AND is_deleted = 0";
                $connect_data = mysqli_query($con, $sql_data);
                if (mysqli_num_rows($connect_data)) {
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="custom-select mt-6">
                                <div class="tag-wrapper">
                                    <?php
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    ?>
                                        <div class="tags">
                                            <span class="remove-tag"></span>
                                            <a href="<?php echo $result_data['file_path']; ?>" target="_blank"><?php echo $result_data['file_name']; ?></a>
                                            <input type="hidden" class="form-control" name="existingFiles[]" value="<?php echo $result_data['id']; ?>">
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success">Save</button>
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</form>
<script>
    $('.remove-tag').on('click', function() {
        return $(this).closest('div.tags').remove();
    });
</script>