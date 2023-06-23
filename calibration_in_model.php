<?php
session_start();
include('includes/functions.php');
$calibration_history_id = $_REQUEST['calibration_history_id'];
$calibration_id = $_REQUEST['calibration_id'];
$sqlData = "SELECT * FROM calibration_in WHERE calibration_history_id = '$calibration_history_id' AND is_deleted = 0";
$connectData = mysqli_query($con, $sqlData);
$calibrationIn = mysqli_fetch_assoc($connectData);
?>
<form class="form form-height" action="includes/calibration_in_update.php" method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
        <input type="hidden" name="calibration_id" value="<?php echo $calibration_id ?>" />
        <input type="hidden" name="calibration_history_id" value="<?php echo $calibration_history_id ?>" />
        <input type="hidden" name="calibration_in_id" value="<?php echo $calibrationIn['id'] ?>" />
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title right-modal text-white">Calibration In</h5>
                <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="required">Received on</label>
                        <input type="date" class="form-control" name="received_on" required
                            value="<?php echo $calibrationIn['received_on'] ?>" />
                    </div>
                    <div class="col-md-6">
                        <label class="required">Received from</label>
                        <input type="text" class="form-control" name="received_from" required
                            value="<?php echo $calibrationIn['received_from'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <label class="required">Instrument condition</label>
                        <input type="text" class="form-control" name="instrument_condition" required
                            value="<?php echo $calibrationIn['instrument_condition'] ?>" />
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="required">Calibration result</label>
                        <input type="text" class="form-control" name="calibration_result" required
                            value="<?php echo $calibrationIn['calibration_result'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <label class="required">Calibration done on</label>
                        <input type="date" class="form-control" name="calibration_done_on" required
                            value="<?php echo $calibrationIn['calibration_done_on'] ?>" />
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="required">Calibration due on</label>
                        <input type="date" class="form-control" name="calibration_due_on" required
                            value="<?php echo $calibrationIn['calibration_due_on'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <label>Doc ref <small>(Inv, Delivery note)</small></label>
                        <input type="text" name="doc_ref" class="form-control"
                            value="<?php echo $calibrationIn['doc_ref'] ?>">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="required">Storage location</label>
                        <input type="text" name="storage_location" class="form-control" required
                            value="<?php echo $calibrationIn['storage_location'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <label class="required">Attachments <small>Instrument Photo</small></label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control" name="file" accept=".pdf">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom-select mt-6">
                            <div class="tag-wrapper">
                                <div class="tags">
                                    <a href="<?php echo $calibrationIn['file_path']; ?>"
                                        target="_blank"><?php echo $calibrationIn['file_name']; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success">Update</button>
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