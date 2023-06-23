<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "New Context Analysis";
$email = $_SESSION['usuario'];
$sql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$userInfo = mysqli_fetch_assoc($fetch);
?>
<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<!--begin::Body-->
<style>
    .ui-datepicker-calendar {
        display: none;
    }

    .required::after {
        content: "*";
        color: #e1261c;
    }

    .ver-disabled input {
        background-color: #e9ecef !important;
    }

    .list-add {
        background-color: transparent;
        padding: 2px 5px;
        border-radius: 50%;
        font-size: 12px;
        color: #fff !important;
        cursor: pointer;
    }

    .list-add i {
        color: #fff;
    }

    #strength-form {
        height: 100%;
    }

    #weakness-form {
        height: 100%;
    }

    #opportunities-form {
        height: 100%;
    }

    #threats-form {
        height: 100%;
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
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/context-analysis.php">Context Analysis</a> »
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
                            <form class="form" action="includes/context-analysis-store.php" method="post" enctype="multipart/form-data">
                                <!-- begin::Form Content -->
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        New Context Analysis
                                    </div>
                                    <div id="custom-section-1">
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Year</label>
                                                <input type="number" class="date-own form-control" name="year" required>
                                                <?php if (isset($_GET['existyear'])) { ?>
                                                    <small class="text-danger">The selected year has
                                                        already been taken</small>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Revision</label>
                                                <input type="text" class="form-control" name="revision" value="0" readonly required>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Created By</label>
                                                <input type="hidden" class="form-control" name="created_by" value="<?php echo $userInfo['Id_employee'] ?>" readonly required>
                                                <input type="text" class="form-control" value="<?php echo $userInfo['First_Name'] . ' ' . $userInfo['Last_Name']; ?>" readonly>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Approved By</label>
                                                <select class="form-control" name="approved_by" required>
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
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <h5 class="fw-bold text-primary m-0">Strength</h5>
                                        <button type="button" id="strength-create" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#strength-modal">Create</button>
                                    </div>
                                    <ul class="mt-4" id="strength-list">
                                    </ul>

                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <h5 class="fw-bold text-primary m-0">Weakness</h5>
                                        <button type="button" id="weakness-create" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#weakness-modal">Create</button>
                                    </div>
                                    <ul class="mt-4" id="weakness-list">
                                    </ul>

                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <h5 class="fw-bold text-primary m-0">Opportunities</h5>
                                        <button type="button" id="opportunities-create" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#opportunities-modal">Create</button>
                                    </div>
                                    <ul class="mt-4" id="opportunities-list">
                                    </ul>

                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <h5 class="fw-bold text-primary m-0">Threats</h5>
                                        <button type="button" id="threats-create" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#threats-modal">Create</button>
                                    </div>
                                    <ul class="mt-4" id="threats-list">
                                    </ul>

                                </div>
                                <!-- end::Form Content -->
                                <div class="card-footer">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                            <a type="button" href="/context-analysis.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Content-->
                            </form>
                        </div>
                    </div>
                    <!--end::Container-->
                </div>

                <!-- Mitigation Modal start -->

                <div class="modal right fade" id="strength-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="strength-form" class="form" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header right-modal">
                                    <h5 class="modal-title">Add Strength
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetStrengthModalVal()" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-md-12 mt-2">
                                            <label class="required">Description</label>
                                            <textarea type="text" class="form-control" id="strengthModal" name="strengthModal" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" id="strength-submit">Add</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="strength-cancel" data-bs-dismiss="modal" onclick="resetStrengthModalVal();">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal right fade" id="weakness-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="weakness-form" class="form" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header right-modal">
                                    <h5 class="modal-title">Add Weakness
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetWeaknessModalVal()" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-md-12 mt-2">
                                            <label class="required">Description</label>
                                            <textarea type="text" class="form-control" id="weaknessModal" name="weaknessModal" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" id="weakness-submit">Add</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="weakness-cancel" data-bs-dismiss="modal" onclick="resetWeaknessModalVal();">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="modal right fade" id="opportunities-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="opportunities-form" class="form" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header right-modal">
                                    <h5 class="modal-title">Add Opportunities
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetOpportunitiesVal()" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-md-12 mt-2">
                                            <label class="required">Description</label>
                                            <textarea type="text" class="form-control" id="opportunitiesModal" name="opportunitiesModal" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" id="opportunities-submit">Add</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="opportunities-cancel" data-bs-dismiss="modal" onclick="resetOpportunitiesModalVal();">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="modal right fade" id="threats-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="threats-form" class="form" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header right-modal">
                                    <h5 class="modal-title">Add Threats
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetThreatsModalVal()" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-md-12 mt-2">
                                            <label class="required">Description</label>
                                            <textarea type="text" class="form-control" id="threatsModal" name="threatsModal" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" id="threats-submit">Add</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="threats-cancel" data-bs-dismiss="modal" onclick="resetThreatsModalVal();">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Mitigation Modal End -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

    <!--end::Page Custom Javascript-->
    <script>
        let strengthRowId = 0;
        let strengthEditRowId = "";

        let weaknessRowId = 0;
        let weaknessEditRowId = "";

        let opportunitiesRowId = 0;
        let opportunitiesEditRowId = "";

        let threatsRowId = 0;
        let threatsEditRowId = "";

        $(document).ready(function() {
            checkStrengthExist();
        });

        $('.date-own').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });

        $('#strength-form').submit(function(e) {
            e.preventDefault()
            let strengthModal = $("#strengthModal").val();
            return appendStrengthTask(strengthModal);
        });


        function appendStrengthTask(strengthModal) {
            if (strengthEditRowId != "") {
                let content = `<div class="d-flex justify-content-between align-items-center"><div>
        <input type="hidden" name="strength[]" value="${strengthModal}" required/>
        <span class="text-dark d-block fw-bold fs-6">${strengthModal}</span></div><div>
        <a class="list-strength-edit cursor-pointer me-2"><i class="bi bi-pencil"></i></a> <a class="list-strength-remove cursor-pointer">
        <i class="bi bi-trash"></i></a></div></div>`;

                $('#' + strengthEditRowId).empty();
                $('#' + strengthEditRowId).append(content);
            } else {
                strengthRowId++;
                let content = ` <li class="mt-2" id="str${strengthRowId}"><div class="d-flex justify-content-between align-items-center"><div>
        <input type="hidden" name="strength[]" value="${strengthModal}" required/>
        <span class="text-dark d-block fw-bold fs-6">${strengthModal}</span></div><div>
        <a class="list-strength-edit cursor-pointer me-2"><i class="bi bi-pencil"></i></a> <a class="list-strength-remove cursor-pointer">
        <i class="bi bi-trash"></i></a></div></div></li>`
                $('#strength-list').append(content);
                checkStrengthExist();
            }
            return $('#strength-cancel').trigger("click");
        }

        function resetStrengthModalVal() {
            strengthEditRowId = "";
            return $("#strengthModal").val("");
        }

        $('body').delegate('.list-strength-edit', 'click', function() {
            strengthEditRowId = $(this).closest('li')[0].id;
            let getData = getStrengthValue($(this).closest('li')[0]);
            let setData = setStrengthValue(getData);
            if (setData) {
                return $('#strength-modal').modal('show');
            }
        });


        function getStrengthValue(row) {
            let strength = $(row).find('input[name="strength[]"]').val();
            return {
                strength,
            }
        }

        function setStrengthValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#strengthModal').val(dataArr.strength);
                return true;
            }
            return false;
        }

        function checkStrengthExist() {
            let isExist = $('#strength-list').find('li').length > 0 ? false : true;
            $('#weakness-create').attr("disabled", isExist);
            $('#opportunities-create').attr("disabled", isExist);
            $('#threats-create').attr("disabled", isExist);
            checkWeaknessExist();
            return isExist;
        }

        function checkWeaknessExist() {
            let isExist = $('#weakness-list').find('li').length > 0 ? false : true;
            $('#opportunities-create').attr("disabled", isExist);
            $('#threats-create').attr("disabled", isExist);
            checkOpportunitiesExist(isExist);
            return isExist;
        }

        function checkOpportunitiesExist(primeVal) {
            if (primeVal) {
                $('#opportunities-list').empty();
                $('#threats-list').empty()
            }
            let isExist = $('#opportunities-list').find('li').length > 0 ? false : true;
            $('#threats-create').attr("disabled", isExist);
            return isExist;
        }

        $('body').delegate('.list-strength-remove', 'click', function() {
            $(this).closest('li').remove();
            let isValid = checkStrengthExist();
            if (isValid) {
                $('#weakness-list').empty();
                $('#opportunities-list').empty();
                return $('#threats-list').empty();
            }
        });

        $('body').delegate('.list-weakness-remove', 'click', function() {
            $(this).closest('li').remove();
            let isValid = checkWeaknessExist();
            if (isValid) {
                $('#opportunities-list').empty();
                return $('#threats-list').empty();
            }
        });

        $('body').delegate('.list-opportunities-remove', 'click', function() {
            $(this).closest('li').remove();
            let isValid = checkOpportunitiesExist();
            if (isValid) {
                return $('#threats-list').empty();
            }
        });

        $('body').delegate('.list-threats-remove', 'click', function() {
            return $(this).closest('li').remove();;
        });


        $('#weakness-form').submit(function(e) {
            e.preventDefault()
            let weaknessModal = $("#weaknessModal").val();
            return appendWeaknessTask(weaknessModal);
        });


        function appendWeaknessTask(weaknessModal) {
            if (weaknessEditRowId != "") {
                let content = `<div class="d-flex justify-content-between align-items-center"><div>
        <input type="hidden" name="weakness[]" value="${weaknessModal}" required/>
        <span class="text-dark d-block fw-bold fs-6">${weaknessModal}</span></div><div>
        <a class="list-weakness-edit cursor-pointer me-2"><i class="bi bi-pencil"></i></a> <a class="list-weakness-remove cursor-pointer">
        <i class="bi bi-trash"></i></a></div></div>`;

                $('#' + weaknessEditRowId).empty();
                $('#' + weaknessEditRowId).append(content);
            } else {
                weaknessRowId++;
                let content = ` <li class="mt-2" id="weak${weaknessRowId}"><div class="d-flex justify-content-between align-items-center"><div>
        <input type="hidden" name="weakness[]" value="${weaknessModal}" required/>
        <span class="text-dark d-block fw-bold fs-6">${weaknessModal}</span></div><div>
        <a class="list-weakness-edit cursor-pointer me-2"><i class="bi bi-pencil"></i></a> <a class="list-weakness-remove cursor-pointer">
        <i class="bi bi-trash"></i></a></div></div></li>`
                $('#weakness-list').append(content);
                checkWeaknessExist();
            }
            return $('#weakness-cancel').trigger("click");
        }

        function resetWeaknessModalVal() {
            weaknessEditRowId = "";
            return $("#weaknessModal").val("");
        }

        $('body').delegate('.list-weakness-edit', 'click', function() {
            weaknessEditRowId = $(this).closest('li')[0].id;
            let getData = getWeaknessValue($(this).closest('li')[0]);
            let setData = setWeaknessValue(getData);
            if (setData) {
                return $('#weakness-modal').modal('show');
            }
        });


        function getWeaknessValue(row) {
            let weakness = $(row).find('input[name="weakness[]"]').val();
            return {
                weakness,
            }
        }

        function setWeaknessValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#weaknessModal').val(dataArr.weakness);
                return true;
            }
            return false;
        }

        $('#opportunities-form').submit(function(e) {
            e.preventDefault()
            let opportunitiesModal = $("#opportunitiesModal").val();
            return appendOpportunitiesTask(opportunitiesModal);
        });


        function appendOpportunitiesTask(opportunitiesModal) {
            if (opportunitiesEditRowId != "") {
                let content = `<div class="d-flex justify-content-between align-items-center"><div>
        <input type="hidden" name="opportunities[]" value="${opportunitiesModal}" required/>
        <span class="text-dark d-block fw-bold fs-6">${opportunitiesModal}</span></div><div>
        <a class="list-opportunities-edit cursor-pointer me-2"><i class="bi bi-pencil"></i></a> <a class="list-opportunities-remove cursor-pointer">
        <i class="bi bi-trash"></i></a></div></div>`;

                $('#' + opportunitiesEditRowId).empty();
                $('#' + opportunitiesEditRowId).append(content);
            } else {
                opportunitiesRowId++;
                let content = ` <li class="mt-2" id="opp${opportunitiesRowId}"><div class="d-flex justify-content-between align-items-center"><div>
        <input type="hidden" name="opportunities[]" value="${opportunitiesModal}" required/>
        <span class="text-dark d-block fw-bold fs-6">${opportunitiesModal}</span></div><div>
        <a class="list-opportunities-edit cursor-pointer me-2"><i class="bi bi-pencil"></i></a> <a class="list-opportunities-remove cursor-pointer">
        <i class="bi bi-trash"></i></a></div></div></li>`
                $('#opportunities-list').append(content);
                checkOpportunitiesExist();
            }
            return $('#opportunities-cancel').trigger("click");
        }

        function resetOpportunitiesModalVal() {
            opportunitiesEditRowId = "";
            return $("#opportunitiesModal").val("");
        }

        $('body').delegate('.list-opportunities-edit', 'click', function() {
            opportunitiesEditRowId = $(this).closest('li')[0].id;
            let getData = getOpportunitiesValue($(this).closest('li')[0]);
            let setData = setOpportunitiesValue(getData);
            if (setData) {
                return $('#opportunities-modal').modal('show');
            }
        });


        function getOpportunitiesValue(row) {
            let opportunities = $(row).find('input[name="opportunities[]"]').val();
            return {
                opportunities,
            }
        }

        function setOpportunitiesValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#opportunitiesModal').val(dataArr.opportunities);
                return true;
            }
            return false;
        }

        $('#threats-form').submit(function(e) {
            e.preventDefault()
            let threatsModal = $("#threatsModal").val();
            return appendThreatsTask(threatsModal);
        });


        function appendThreatsTask(threatsModal) {
            if (threatsEditRowId != "") {
                let content = `<div class="d-flex justify-content-between align-items-center"><div>
        <input type="hidden" name="threats[]" value="${threatsModal}" required/>
        <span class="text-dark d-block fw-bold fs-6">${threatsModal}</span></div><div>
        <a class="list-threats-edit cursor-pointer me-2"><i class="bi bi-pencil"></i></a> <a class="list-threats-remove cursor-pointer">
        <i class="bi bi-trash"></i></a></div></div>`;

                $('#' + threatsEditRowId).empty();
                $('#' + threatsEditRowId).append(content);
            } else {
                threatsRowId++;
                let content = ` <li class="mt-2" id="thr${threatsRowId}"><div class="d-flex justify-content-between align-items-center"><div>
        <input type="hidden" name="threats[]" value="${threatsModal}" required/>
        <span class="text-dark d-block fw-bold fs-6">${threatsModal}</span></div><div>
        <a class="list-threats-edit cursor-pointer me-2"><i class="bi bi-pencil"></i></a> <a class="list-threats-remove cursor-pointer">
        <i class="bi bi-trash"></i></a></div></div></li>`
                $('#threats-list').append(content);
            }
            return $('#threats-cancel').trigger("click");
        }

        function resetThreatsModalVal() {
            threatsEditRowId = "";
            return $("#threatsModal").val("");
        }

        $('body').delegate('.list-threats-edit', 'click', function() {
            threatsEditRowId = $(this).closest('li')[0].id;
            let getData = getThreatsValue($(this).closest('li')[0]);
            let setData = setThreatsValue(getData);
            if (setData) {
                return $('#threats-modal').modal('show');
            }
        });


        function getThreatsValue(row) {
            let threats = $(row).find('input[name="threats[]"]').val();
            return {
                threats,
            }
        }

        function setThreatsValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#threatsModal').val(dataArr.threats);
                return true;
            }
            return false;
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>