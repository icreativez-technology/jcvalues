<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Audit NC & CAPA Add";

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];
?>
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
                            <p><a href="/">Home</a> » <a href="/audit_nc_capa.php">Audit NC & CAPA</a> » <a
                                    href="/audit_nc_capa_view_list.php">Audit NC & CAPA View List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush mt-4">
                            <form class="form" action="includes/audit_nc_capa_store.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="container-full customer-header">
                                        NCR Details
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Audit ID</label>
                                            <select class="form-control" name="audit_id" id="audit_id" onchange="getData();" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                $audit_ids = "SELECT * FROM audit_management_list where is_deleted = 0 AND audit_type = 'External' AND status = 'Audited'";
                                                $fetch_data = mysqli_query($con, $audit_ids);
                                                while ($unique_data = mysqli_fetch_assoc($fetch_data)) {
                                                ?>
                                                <option value="<?php echo $unique_data['id']; ?>">
                                                    <?php echo $unique_data['unique_id']; ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Audit Type</label>
                                            <input type="text" class="form-control" id="audit_type" disabled/>
                                        </div>
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Audit Area</label>
                                            <input type="text" class="form-control" id="audit_area" disabled/>
                                        </div>
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Audit Standard</label>
                                            <input type="text" class="form-control" id="audit_standard" disabled/>
                                        </div>
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Auditor</label>
                                            <input type="text" class="form-control" id="auditor" disabled/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Department</label>
                                            <input type="text" class="form-control" id="department" disabled/>
                                        </div>
                                        <div class="col-md-9 mt-5">
                                            <label class="required">Auditee</label>
                                            <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2"
                                                data-hide-search="true" id="auditee" data-select2-id="select2-data-7-oqcd" 
                                                tabindex="-1" aria-hidden="true" disabled multiple>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-5">
                                            <label class="required">NCR issue Date</label>
                                            <input type="date" class="form-control" name="ncr_issue_date" required />
                                        </div>
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Finding Type</label>
                                            <select class="form-control" name="finding_type" required>
                                                <option value="">Please Select</option>
                                                <option value="Minor">Minor</option>
                                                <option value="Major">Major</option>
                                                <option value="Observation">Observation</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-5">
                                            <label>File Upload</label>
                                            <input type="file" class="form-control" name="file" accept=".pdf" />
                                        </div>
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Product / Process Impact</label>
                                            <div class="row">
                                                <div class="col-md-3 mt-5">
                                                    <input type="radio" value="Yes" name="product_process_impact"
                                                        class="form-check-input" required/>
                                                    <label class="form-check-label">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="col-md-3 mt-5">
                                                    <input type="radio" value="No" name="product_process_impact"
                                                        class="form-check-input" required/>
                                                    <label class="form-check-label">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-5">
                                            <label class="required">Clause</label>
                                            <input type="text" class="form-control" name="clause" required />
                                        </div>
                                        <div class="col-md-9 mt-5">
                                            <label class="required">Audit Point</label>
                                            <textarea type="text" class="form-control" name="audit_point" rows="1"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-5">
                                            <label class="required">Object Evidence Details</label>
                                            <textarea type="text" class="form-control" name="objective_evidence_details"
                                                rows="1" required></textarea>
                                        </div>
                                        <div class="col-md-6 mt-5">
                                            <label class="required">Non conformance Description</label>
                                            <textarea type="text" class="form-control"
                                                name="non_conformance_description" rows="1" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer m-6">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-6">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Save
                                            </button>
                                            <a type="button" href="/audit_nc_capa_view_list.php"
                                                class="btn btn-sm btn-secondary ms-2">Close</a>
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
    <?php include('includes/footer.php'); ?>
    </div>
    </div>
    </div>
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
	    function getData() {
            $("#audit_type").val("");
            $("#audit_area").val("");
            $("#audit_standard").val("");
            $("#auditor").val("");
            $("#department").val("");
            $("#auditee option").remove();
            let audit_id = document.getElementById("audit_id").value;
            if (audit_id != "") {
                const data = {
                    audit_id: audit_id
                }
                $.ajax({
                    type: 'POST',
                    url: 'includes/get_external_audit_management.php',
                    data: data
                })
                .done(function(result) {
                    var dataArr = JSON.parse(result);
                    var auditData = dataArr.auditData;
                    var auditeeData = dataArr.auditeeData;
                    $("#audit_type").val("External");
                    $("#audit_area").val(auditData.audit_area);
                    $("#audit_standard").val(auditData.audit_standard);
                    $("#auditor").val(auditData.auditor);
                    $("#department").val(auditData.department);
                    $.each(auditeeData, function(index, value) {
				        $("#auditee").append(`<option selected>${value.First_Name} ${value.Last_Name}</option>`);
                    });
                });
            }
		}
    </script>
</body>
</html>