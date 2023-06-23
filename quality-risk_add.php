<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "New Risk";
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!--begin::Body-->
<style>
    .assesment-row {
        display: flex;
        justify-content: space-between;
        align-content: space-around;
        min-height: 110px;
        flex-wrap: inherit;
        border-right: 2px solid #ededed;
    }

    .required::after {
        content: "*";
        color: #e1261c;
    }

    .radio-grid {
        width: 115px;
        padding-top: 10px;
    }
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <!-- Includes Top bar and Responsive Menu -->
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/quality-risk.php">Risk Assesment</a> » <a href="/quality-risk-view-list.php">Risk Assesment List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                    <!--end::body-->
                </div>
                <!--end::BREADCRUMBS-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush">
                            <form class="form" action="includes/quality-risk_add_form.php" method="post" enctype="multipart/form-data">
                                <!-- begin::Form Content -->
                                <div class="card-body">
                                    <div id="custom-section-1">
                                        <div class="container-full customer-header">
                                            Details
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">On Behalf Of</label>
                                                <select class="form-control" name="on_behalf_of" required>
                                                    <option value="">Please Select</option>
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
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Plant</label>
                                                <select class="form-control" name="plant_id" id="plant" onchange="AgregrarPlantRelacionados();" required>
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active') {
                                                    ?>
                                                            <option value="<?php echo $result_data['Id_plant']; ?>">
                                                                <?php echo $result_data['Title']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Product Group</label>
                                                <select class="form-control" id="product_group" name="product_group_id" required>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Department</label>
                                                <select class="form-control" id="department" name="department_id" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Process</label>
                                                <select class="form-control" name="process_id" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Quality_Process";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    ?>
                                                        <option value="<?php echo $result_data['Id_quality_process']; ?>">
                                                            <?php echo $result_data['Title']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Risk Type</label>
                                                <select class="form-control" name="risk_type_id" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Quality_Risk_Type";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    ?>
                                                        <option value="<?php echo $result_data['Id_quality_risk_type']; ?>">
                                                            <?php echo $result_data['Title']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Source of Risk</label>
                                                <select class="form-control" name="source_of_risk_id" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Quality_Risk_Source";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    ?>
                                                        <option value="<?php echo $result_data['Id_quality_risk_source']; ?>">
                                                            <?php echo $result_data['Title']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Impact Area</label>
                                                <select class="form-control" name="impact_area_id" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Quality_Impact_Area";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    ?>
                                                        <option value="<?php echo $result_data['Id_quality_impact_area']; ?>">
                                                            <?php echo $result_data['Title']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 mt-5">
                                                <label class="required">Description</label>
                                                <textarea type="text" rows="3" class="form-control" name="description" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label>File Upload</label>
                                                <input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body mt-2">
                                    <div id="custom-section-1">
                                        <div class="container-full customer-header">
                                            Assessment
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 mt-4">
                                                <label class="required"><b>Severity</b></label>
                                                <div class="row">
                                                    <div class="assesment-row">
                                                        <div class="radio-grid">
                                                            <input type="radio" name="severity" value="1" required>
                                                            <label class="btn btn-custom-level-1">
                                                                No Effect
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="severity" value="2" required>
                                                            <label class="btn btn-custom-level-2">
                                                                Very Minor
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="severity" value="3" required>
                                                            <label class="btn btn-custom-level-3">
                                                                Minor
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="severity" value="4" required>
                                                            <label class="btn btn-custom-level-4">
                                                                Moderate
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="severity" value="5" required>
                                                            <label class="btn btn-custom-level-5">
                                                                High
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="severity" value="6" required>
                                                            <label class="btn btn-custom-level-6">
                                                                Very High
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-4">
                                                <label class="required"><b>Occurance</b></label>
                                                <div class="row">
                                                    <div class="assesment-row">
                                                        <div class="radio-grid">
                                                            <input type="radio" name="occurance" value="1" required>
                                                            <label class="btn btn-custom-level-1">
                                                                No Effect
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="occurance" value="2" required>
                                                            <label class="btn btn-custom-level-2">
                                                                Very Minor
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="occurance" value="3" required>
                                                            <label class="btn btn-custom-level-3">
                                                                Minor
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="occurance" value="4" required>
                                                            <label class="btn btn-custom-level-4">
                                                                Moderate
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="occurance" value="5" required>
                                                            <label class="btn btn-custom-level-5">
                                                                High
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="occurance" value="6" required>
                                                            <label class="btn btn-custom-level-6">
                                                                Very High
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-4">
                                                <label class="required"><b>Detection</b></label>
                                                <div class="row">
                                                    <div class="assesment-row" style="border-right:none">
                                                        <div class="radio-grid">
                                                            <input type="radio" name="detection" value="1" required>
                                                            <label class="btn btn-custom-level-1">
                                                                No Effect
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="detection" value="2" required>
                                                            <label class="btn btn-custom-level-2">
                                                                Very Minor
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="detection" value="3" required>
                                                            <label class="btn btn-custom-level-3">
                                                                Minor
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="detection" value="4" required>
                                                            <label class="btn btn-custom-level-4">
                                                                Moderate
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="detection" value="5" required>
                                                            <label class="btn btn-custom-level-5">
                                                                High
                                                            </label>
                                                        </div>
                                                        <div class="radio-grid">
                                                            <input type="radio" name="detection" value="6" required>
                                                            <label class="btn btn-custom-level-6">
                                                                Very High
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mt-4">
                                            <label class="col-form-label col-md-3 mt-3"><b>Risk Priority Number</b></label>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control text-center" name="rpn_value" id="rpn_value" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end::Form Content -->
                                <div class="card-footer">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Save</button>
                                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Content-->
                            </form>
                            <!-- Finalizar contenido -->
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <?php include('includes/footer.php'); ?>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
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
    <script>
        function AgregrarPlantRelacionados() {
            var result = document.getElementById("plant").value;
            /*Product Group*/
            $("<option>").load('includes/inputs-dinamicos-pg-plant.php?pg_id=' + result, function() {
                $('#product_group option').remove();
                $("#product_group").append($(this).html());
            });

            /*Department*/
            $("<option>").load('includes/inputs-dinamicos-department-plant.php?pg_id=' + result, function() {
                $('#department option').remove();
                $("#department").append($(this).html());
            });
        }

        $(document).ready(function() {
            $("input[name='severity']").click(function() {
                calculateRpn();
            });
            $("input[name='occurance']").click(function() {
                calculateRpn();
            });
            $("input[name='detection']").click(function() {
                calculateRpn();
            });
        });

        function calculateRpn() {
            var severity = $('input[name="severity"]:checked').val();
            var occurance = $('input[name="occurance"]:checked').val();
            var detection = $('input[name="detection"]:checked').val();
            if (severity != undefined && occurance != undefined && detection != undefined) {
                var rpn = Number(severity) * Number(occurance) * Number(detection);
                $("#rpn_value").val(rpn);
            }
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>