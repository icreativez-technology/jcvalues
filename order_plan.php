<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Serial vs Heat";
?>
<style>
    .div-disabled,
    .input-disabled input {
        background-color: #e9ecef !important;
    }
</style>
<script>
    var productGroup = <?php echo $kaizen['product_group_id']; ?>;
    var department = <?php echo $kaizen['department_id']; ?>;
</script>
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
                            <p><a href="/">Home</a> » <a href="/kaizen.php">Serial vs Heat</a> » <a href="/kaizen_view_list.php">Serial vs Heat List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="order-tab" data-bs-toggle="tab" data-bs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="true">Order Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="serial-tab" data-bs-toggle="tab" data-bs-target="#serial" type="button" role="tab" aria-controls="serial" aria-selected="false">Self
                                    Serial vs Heat</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!--Kaizen Details-->
                            <div class="tab-pane fade show active" id="order" role="tabpanel" aria-labelledby="order-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/kaizen_update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div>
                                                <div class="form-group row">
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">Purchaser</label>
                                                        <input type="text" name="purchaser" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">Date</label>
                                                        <input type="date" name="date" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">Certificate Number</label>
                                                        <input type="text" name="certificate_number" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Po Number</label>
                                                        <input type="text" name="po_number" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">JC PO Ref</label>
                                                        <input type="text" name="jc_po_ref" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Certification</label>
                                                        <input type="text" name="certification" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Issue Date</label>
                                                        <input type="date" name="issue_date" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="container-full customer-header mt-4">
                                                    Product Description
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Product Type</label>
                                                        <select class="form-control" name="product_type" required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM product_types WHERE Status = '1' AND deleted_at IS NULL";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>">
                                                                    <?php echo $result_data['product_type']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Model</label>
                                                        <select class="form-control" name="model" required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM models WHERE Status = '1' AND deleted_at IS NULL";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>">
                                                                    <?php echo $result_data['model']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Design Standard</label>
                                                        <select class="form-control" name="design_standard" required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM design_standards WHERE Status = '1' AND deleted_at IS NULL";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>">
                                                                    <?php echo $result_data['design_standard']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Testing Standard</label>
                                                        <select class="form-control" name="testing_standard" required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM testing_standards WHERE Status = '1' AND deleted_at IS NULL";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>">
                                                                    <?php echo $result_data['testing_standard']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">size</label>
                                                        <select class="form-control" name="size" required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM sizes WHERE status = '1' AND is_deleted = '0'";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>">
                                                                    <?php echo $result_data['size']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Bore</label>
                                                        <select class="form-control" name="bore" required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM bores WHERE status = '1' AND deleted_at IS NULL";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>">
                                                                    <?php echo $result_data['bore']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Class</label>
                                                        <select class="form-control" name="class" required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM classes WHERE status = '1' AND is_deleted = '0'";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>">
                                                                    <?php echo $result_data['class']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Ends</label>
                                                        <select class="form-control" name="ends" required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM end_connections WHERE status = '1' AND deleted_at IS NULL";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>">
                                                                    <?php echo $result_data['end_connection']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">Item No</label>
                                                        <input type="text" name="item_no" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">Article</label>
                                                        <input type="text" name="article" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">QTY</label>
                                                        <input type="text" name="qty" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="container-full customer-header mt-4">
                                                    Material Construction
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                                    <a type="button" href="/kaizen.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!--Self Evaluation-->
                            <div class="tab-pane fade" id="serial" role="tabpanel" aria-labelledby="serial-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/kaizen-self-evaluation-update.php" method="post" enctype="multipart/form-data">
                                        <!-- begin::Form Content -->
                                        <div class="card-body">
                                        </div>
                                        <div class="card-footer">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Save
                                                    </button>
                                                    <a type="button" href="/kaizen_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
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
        </div>
    </div>
    <!--end::Container-->
    </div>
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
        $("input").intlTelInput({
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
        });
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
    <script>
        $(".self").on('click', function() {
            var team = $('input[name="self-individual"]:checked').val();
            var time = $('input[name="self-time"]:checked').val();
            var proactive = $('input[name="self-proactive"]:checked').val();
            var creativity = $('input[name="self-creativity"]:checked').val();
            if (team != undefined && time != undefined && proactive != undefined && creativity != undefined) {
                var score = (Number(team) + Number(time) + Number(proactive) + Number(creativity)) * 1.5;
                $("#self-score").val(Math.ceil(score));
                return $(".self-score").html(Math.ceil(score));
            }
        });

        $(".hod").on('click', function() {
            var team = $('input[name="hod-individual"]:checked').val();
            var time = $('input[name="hod-time"]:checked').val();
            var proactive = $('input[name="hod-proactive"]:checked').val();
            var creativity = $('input[name="hod-creativity"]:checked').val();
            if (team != undefined && time != undefined && proactive != undefined && creativity != undefined) {
                var score = (Number(team) + Number(time) + Number(proactive) + Number(creativity)) * 1.5;
                $("#hod-score").val(Math.ceil(score));
                return $(".hod-score").html(Math.ceil(score));
            }
        });

        $(".com").on('click', function() {
            var team = $('input[name="com-individual"]:checked').val();
            var time = $('input[name="com-time"]:checked').val();
            var proactive = $('input[name="com-proactive"]:checked').val();
            var creativity = $('input[name="com-creativity"]:checked').val();
            if (team != undefined && time != undefined && proactive != undefined && creativity != undefined) {
                var score = (Number(team) + Number(time) + Number(proactive) + Number(creativity)) * 1.5;
                $("#com-score").val(Math.ceil(score));
                return $(".com-score").html(Math.ceil(score));
            }
        });

        $(document).ready(function() {
            AgregrarPlantRelacionados();
            $("#total_expenditure").on('input', function() {
                caluculateGain();
            });
            $("#total_direct_savings").on('input', function() {
                caluculateGain();
            });
            $("#total_indirect_savings").on('input', function() {
                caluculateGain();
            });
        });

        function AgregrarPlantRelacionados() {
            var result = document.getElementById("plant").value;
            $("<option>").load('includes/inputs-dinamicos-pg-plant.php?pg_id=' + result + '&key=' + productGroup,
                function() {
                    $('#product_group option').remove();
                    $("#product_group").append($(this).html());
                });

            $("<option>").load('includes/inputs-dinamicos-department-plant.php?pg_id=' + result + '&key=' + department,
                function() {
                    $('#department option').remove();
                    $("#department").append($(this).html());
                });
        }

        function caluculateGain() {
            var total_expenditure = $("#total_expenditure").val();
            var total_direct_savings = $("#total_direct_savings").val();
            var total_indirect_savings = $("#total_indirect_savings").val();
            if (total_expenditure != undefined && total_direct_savings != undefined && total_indirect_savings !=
                undefined) {
                var final_monetary_gain = (Number(total_direct_savings) + Number(total_indirect_savings)) - Number(
                    total_expenditure);
                $("#final_monetary_gain").val(Math.ceil(final_monetary_gain));
            }
        }
    </script>
</body>
<!--end::Body-->

</html>