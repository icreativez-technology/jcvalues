<?php
session_start();
include('includes/functions.php');
$calibration_history_id = $_REQUEST['calibration_history_id'];
$calibration_id = $_REQUEST['calibration_id'];
$sqlData = "SELECT * FROM calibration_out WHERE calibration_history_id = '$calibration_history_id' AND is_deleted = 0";
$connectData = mysqli_query($con, $sqlData);
$calibrationOut = mysqli_fetch_assoc($connectData);
?>
<form class="form form-height" action="includes/calibration_out_update.php" method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
        <input type="hidden" name="calibration_id" value="<?php echo $calibration_id ?>" />
        <input type="hidden" name="calibration_history_id" value="<?php echo $calibration_history_id ?>" />
        <input type="hidden" name="calibration_out_id" value="<?php echo $calibrationOut['id'] ?>" />
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title right-modal text-white">Calibration Out</h5>
                <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="required">Send on</label>
                        <input type="date" class="form-control" name="send_on" required
                            value="<?php echo $calibrationOut['send_on'] ?>" />
                    </div>
                    <div class="col-md-6">
                        <label class="required">Send to (Supplier)</label>
                        <input type="text" class="form-control" name="send_to" required
                            value="<?php echo $calibrationOut['send_to'] ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <label>Doc ref<small>(Delivery note)</small></label>
                        <input type="text" name="doc_ref" class="form-control"
                            value="<?php echo $calibrationOut['doc_ref'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <label class="required">Send For</label>
                        <input type="text" name="send_for" class="form-control" required
                            value="<?php echo $calibrationOut['send_for'] ?>">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="required">Instrument condition</label>
                        <input type="text" name="instrument_condition" class="form-control" required
                            value="<?php echo $calibrationOut['instrument_condition'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <label class="required">Collected by</label>
                        <input type="text" name="collected_by" class="form-control" required
                            value="<?php echo $calibrationOut['collected_by'] ?>">
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
                $sql_data = "SELECT * FROM calibration_out_files WHERE calibration_history_id = '$calibration_history_id' AND is_deleted = 0";
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
                                    <a href="<?php echo $result_data['file_path']; ?>"
                                        target="_blank"><?php echo $result_data['file_name']; ?></a>
                                    <input type="hidden" class="form-control" name="existingFiles[]"
                                        value="<?php echo $result_data['id']; ?>">
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