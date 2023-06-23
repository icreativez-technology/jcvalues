<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "New Calibration";
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
.ver-disabled input {
    background-color: #e9ecef !important;
}
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/calibration_view_list.php">Calibration List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush">
                            <form class="form" action="includes/calibration_store.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        Master
                                    </div>
                                    <div id="custom-section-1">
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Instrument Id</label>
                                                <input type="text" class="form-control" name="instrument_id" required />
                                                <?php if (isset($_GET['exist'])) { ?>
                                                <small class="text-danger">The intrument id has already been
                                                    taken</small>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Serial Number</label>
                                                <input type="text" class="form-control" name="serial_no" required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Instrument Name</label>
                                                <input class="form-control capitalCase" type="text"
                                                    name="instrument_name" required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Make</label>
                                                <input type="text" class="form-control capitalCase" name="make"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Model No</label>
                                                <input type="text" class="form-control" name="model_no" required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Date of Purchase</label>
                                                <input type="date" class="form-control" name="date_of_purchase"
                                                    required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Supplier Name</label>
                                                <input type="text" class="form-control capitalCase" name="supplier_name"
                                                    required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Specification <small>Range</small>
                                                </label>
                                                <input type="text" class="form-control" name="specification" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Least Count</label>
                                                <input type="text" class="form-control" name="least_count" required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Calibration Done On</label>
                                                <input type="date" class="form-control" name="calibration_done_on"
                                                    id="calibration_done_on" required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Calibration Frequency<small>(in
                                                        Day's)</small> </label>
                                                <input type="number" class="form-control" name="calibration_frequency"
                                                    id="calibration_frequency" required />
                                            </div>
                                            <div class="col-lg-3 mt-5 ver-disabled">
                                                <label class="required">Calibration Due On</label>
                                                <input type="date" class="form-control" name="calibration_due_on"
                                                    id="calibration_due_on" required readonly />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Storage Location</label>
                                                <input type="text" class="form-control capitalCase"
                                                    name="storage_location" required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Usage Condition</label>
                                                <input type="text" class="form-control capitalCase"
                                                    name="usage_condition" required />
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Asset Type</label>
                                                <select class="form-control" name="asset_type" required>
                                                    <option value="">Please Select</option>
                                                    <option value="Machine">Machine</option>
                                                    <option value="Instrument">Instrument</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">File Upload</label>
                                                <div class="align-items-center">
                                                    <input type="file" class="form-control" name="file" accept=".pdf"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer mt-6">
                                        <div class="row" style="text-align:center; float:right;">
                                            <div class="mb-4">
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    id="tag-form-submit1">
                                                    Save
                                                </button>
                                                <a type="button" href="/calibration_view_list.php"
                                                    class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('calibration_detail_modal.php'); ?>

    <?php include('includes/footer.php'); ?>
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
    <script>
    function getFormattedDate(date = new Date()) {
        return (
            date.getFullYear() +
            "-" +
            ("0" + (date.getMonth() + 1)).slice(-2) +
            "-" +
            ("0" + date.getDate()).slice(-2)
        );
    }

    function getRequiredDate() {
        let done = $("#calibration_done_on").val();
        let frequency = Number($("#calibration_frequency").val());
        if (done != "" && frequency != "") {
            date = new Date(done);
            const daysAfter = new Date(date.getTime());
            daysAfter.setDate(date.getDate() + frequency);
            $("#calibration_due_on").val(getFormattedDate(daysAfter));
        }
    }

    $(document).ready(function() {
        $("#calibration_frequency").on('input', function() {
            getRequiredDate();
        });
        $("#calibration_done_on").on('input', function() {
            getRequiredDate();
        });
    });
    $('.capitalCase').on('keyup', function() {
        return $(this).val($(this).val().toUpperCase());
    });
    </script>
</body>

</html>