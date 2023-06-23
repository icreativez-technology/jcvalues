<?php
session_start();
include('includes/functions.php');
$disabled = $_REQUEST['mode'] == "view" ? true : false;
$execute = $_REQUEST['execute'] == "true" ? true : false;
$areaDetailsData = null;
$auditeeMembers =  array();
$auditors =  array();
$lists =  array();

$sqlAudit = "SELECT * FROM audit_management_list WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connecAudit = mysqli_query($con, $sqlAudit);
$auditDetailsData = mysqli_fetch_assoc($connecAudit);

$sqlInternal = "SELECT * FROM internal_audits WHERE audit_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectInternal = mysqli_query($con, $sqlInternal);
$internalAuditData = mysqli_fetch_assoc($connectInternal);

$auditAreaId = isset($_REQUEST['area_id']) ? $_REQUEST['area_id'] : $internalAuditData['audit_area_id'];

if ($auditAreaId != null && $auditAreaId != "") {
    $sqlArea = "SELECT * FROM admin_audit_area LEFT JOIN admin_audit_standard ON admin_audit_standard.id = admin_audit_area.audit_standard_id WHERE admin_audit_area.id = '$auditAreaId' AND admin_audit_area.is_deleted = 0";
    $connectArea = mysqli_query($con, $sqlArea);
    $areaDetailsData = mysqli_fetch_assoc($connectArea);

    $existingAuditeeSqlData = "SELECT member_id, First_Name, Last_Name FROM admin_audit_area_assign_auditees LEFT JOIN Basic_Employee ON admin_audit_area_assign_auditees.member_id = Basic_Employee.Id_employee WHERE admin_audit_area_id = '$auditAreaId' AND admin_audit_area_assign_auditees.is_deleted = 0";
    $auditeeMembersConnect = mysqli_query($con, $existingAuditeeSqlData);
    while ($row = mysqli_fetch_assoc($auditeeMembersConnect)) {
        array_push($auditeeMembers, $row['member_id']);
    }

    $auditorsSqlData = "SELECT * FROM admin_audit_standard_auditors WHERE admin_audit_standard_id = '$areaDetailsData[audit_standard_id]' AND is_deleted = 0";
    $auditorsSqlConnect = mysqli_query($con, $auditorsSqlData);
    while ($row = mysqli_fetch_assoc($auditorsSqlConnect)) {
        array_push($auditors, $row['member_id']);
    }

    $listSqlData = "SELECT * FROM admin_audit_area_assign_check_list WHERE is_deleted = 0 AND admin_audit_area_id = '$auditAreaId'";
    $listData = mysqli_query($con, $listSqlData);
    while ($row = mysqli_fetch_assoc($listData)) {
        array_push($lists, $row);
    }
}


$executionSql = "SELECT * FROM audit_management_execute_check_list WHERE is_deleted = 0 AND audit_id = '$_REQUEST[id]'";
$executionData = mysqli_query($con, $executionSql);
$executeArr = array();
while ($row = mysqli_fetch_assoc($executionData)) {
    array_push($executeArr, $row);
}
$isExecutable = count($lists) == count($executeArr) ? true : false;

?>
<style>
    #audit_checklist_form {
        height: 100%;
    }

    .check-size {
        width: 1.25rem !important;
        height: 1.25rem !important;
    }
</style>
<form class="form" action="includes/audit_management_update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" class="form-control" name="audit_type" value="Internal">
    <input type="hidden" class="form-control" name="id" value="<?php echo $auditDetailsData['id'] ?>">
    <div class="row">
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Area</label>
                <select class="form-control" name="audit_area_id" id="audit_area_id" required <?php echo ($disabled) ? "disabled" : "" ?>>
                    <option value="">Please Select</option>
                    <?php
                    $sql_data = "SELECT * FROM admin_audit_area WHERE status = 'Active' AND is_deleted = 0";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                    ?>
                        <option value="<?php echo $result_data['id']; ?>" <?php echo ($areaDetailsData != null && $auditAreaId == $result_data['id']) ? 'selected' : ''; ?>>
                            <?php echo $result_data['audit_area']; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Checklist Format No</label>
                <input type="text" class="form-control" value="<?php echo $areaDetailsData ? $areaDetailsData['audit_check_list_format_no'] : "" ?>" disabled>
            </div>
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Checklist Revision No</label>
                <input type="text" class="form-control" value="<?php echo $areaDetailsData ? $areaDetailsData['revision_no'] : "" ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4 mt-5">
                <label class="required">Audit Standard</label>
                <input type="text" class="form-control" value="<?php echo $areaDetailsData ? $areaDetailsData['audit_standard'] : "" ?>" disabled>
            </div>
            <div class="col-lg-8 mt-5">
                <label class="required">Auditor</label>
                <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Auditors" data-select2-id="select2-data-7-oqzx" tabindex="-1" aria-hidden="true" multiple disabled>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Employee";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                        if ($result_data['Status'] == 'Active') {
                    ?>
                            <option value="<?php echo $result_data['Id_employee']; ?>" <?php echo (in_array($result_data['Id_employee'], $auditors)) ? 'selected' : ''; ?>>
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
                <label class="required">Department</label>
                <select class="form-control" disabled>
                    <option value="">Please Select</option>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Department";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                        if ($result_data['Status'] == 'Active') {
                    ?>
                            <option value="<?php echo $result_data['Id_department']; ?>" <?php echo ($areaDetailsData && $areaDetailsData['department_id'] == $result_data['Id_department']) ? 'selected' : ''; ?>>
                                <?php echo $result_data['Department']; ?>
                            </option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-8 mt-5">
                <label class="required">Auditee</label>
                <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Auditees" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" multiple disabled>
                    <?php
                    $sql_data = "SELECT * FROM Basic_Employee";
                    $connect_data = mysqli_query($con, $sql_data);
                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                        if ($result_data['Status'] == 'Active') {
                    ?>
                            <option value="<?php echo $result_data['Id_employee']; ?>" <?php echo (in_array($result_data['Id_employee'], $auditeeMembers)) ? 'selected' : ''; ?>>
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
            <div class="col-lg-3 mt-5">
                <label class="required">Finding Format No</label>
                <input type="text" class="form-control" name="finding_format_no" value="<?php echo $internalAuditData['finding_format_no'] ?>" required <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
            <div class="col-lg-3 mt-5">
                <label class="required">Finding Revision No</label>
                <input type="text" class="form-control" name="revision_no" value="<?php echo $internalAuditData['revision_no'] ?>" required <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
            <div class="col-lg-3 mt-5">
                <label class="required">Audit Schedule Start Date</label>
                <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $auditDetailsData['start_date'] ?>" required <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
            <div class="col-lg-3 mt-5">
                <label class="required">Audit Schedule End Date</label>
                <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $auditDetailsData['end_date'] ?>" required <?php echo ($disabled) ? "disabled" : "" ?>>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="container-full customer-header d-flex justify-content-between">
                Assign Check List
            </div>
            <div class="row" style="padding:0px 20px;">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_ncr_table">
                    <thead>
                        <tr class="text-start text-gray-400 text-uppercase gs-0">
                            <th class="min-w-100px ps-3">Clause</th>
                            <th class="min-w-200px">Audit Point</th>
                            <?php if ($execute || $disabled) { ?>
                                <th class="min-w-100px">Objective Evidence</th>
                                <th class="min-w-100px">is NCR</th>
                                <th class="min-w-100px">File</th>
                                <?php if ($execute) { ?>
                                    <th class="min-w-100px text-end pe-3">Action</th>
                            <?php }
                            } ?>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600" id="list-table">
                        <input type="hidden" name="dataArr" id="dataArr" value='<?php echo json_encode($lists) ?>'>
                        <?php if ($lists && count($lists) > 0) {
                            foreach ($lists as $key => $list) { ?>
                                <tr id="<?php echo $key  ?>">
                                    <td class="ps-3"><input type="hidden" class="form-control" name="clause[]" value="<?php echo $list['clause']; ?>" required>
                                        <?php echo $list['clause']; ?>
                                    </td>
                                    <td>
                                        <input type="hidden" class="form-control" name="audit_point[]" value="<?php echo $list['audit_point']; ?>" required>
                                        <?php echo $list['audit_point']; ?>
                                    </td>
                                    <?php if ($execute || $disabled) {
                                        $sqlExecutionList = "SELECT * FROM audit_management_execute_check_list WHERE audit_id = '$_REQUEST[id]' AND audit_area_check_list_id = '$list[id]' AND is_deleted = 0";
                                        $connectExe = mysqli_query($con, $sqlExecutionList);
                                        $executionData = mysqli_fetch_assoc($connectExe);
                                    ?>
                                        <td>
                                            <?php echo ($executionData && isset($executionData['objective_evidence'])) ? $executionData['objective_evidence'] : "-"; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $isNcr = "-";
                                            if ($executionData) {
                                                $isNcr =  $executionData['is_ncr'] == '1' ? "Yes" : "No";
                                            }
                                            echo $isNcr;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $ncrPdf = "-";
                                            if ($executionData && $executionData['file_name'] != "") {
                                                $ncrPdf  =  ' <a href="' . $executionData['file_path'] . '" target="_blank"><i
                                                class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
                                            }
                                            echo $ncrPdf;
                                            ?>
                                        </td>
                                        <?php if ($execute) { ?>
                                            <td class="list-row text-end pe-3">
                                                <a class="list-edit cursor-pointer me-2" data-id="<?php echo $list['id'] ?>"><i class="bi bi-pencil"></i></a>
                                            </td>
                                    <?php }
                                    } ?>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="p-4">
        <div class="row">
            <div style="text-align: right;">
                <?php if ($execute && $isExecutable) { ?>
                    <a type="button" href="/includes/audit_external_execute_status_update.php?id=<?php echo $auditDetailsData['id'] ?>" class="btn btn-sm btn-primary">Complete</a>
                <?php } ?>
                <?php if (!$execute && !$disabled) { ?>
                    <input type="submit" class="btn btn-sm btn-success m-3" value="Update">
                <?php } ?>
                <a type="button" href="/audit_management.php" class="btn btn-sm btn-danger"><?php echo ($disabled) ? "Close" : "Cancel" ?></a>
            </div>
        </div>
    </div>
</form>

<div class="modal right fade" id="audit_checklist_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="audit_checklist_form" action="includes/audit_internal_execute_store.php" method="post" class="form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header right-modal">
                    <h5 class="modal-title" id="staticBackdropLabel">Assign Check List
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetModalVal()"></button>
                </div>
                <div class="modal-body" style="overflow-y: scroll">
                    <input type="hidden" name="executeArr" id="executeArr" value='<?php echo json_encode($executeArr) ?>'>
                    <input type="hidden" name="audit_id" id="audit_id" value="<?php echo $_REQUEST['id'] ?>" />
                    <input type="hidden" name="audit_checklist_id" id="audit_checklist_id" value="" />
                    <input type="hidden" name="audit_execute_id" id="audit_execute_id" value="" />
                    <div class="row">
                        <div class="col-md-12">
                            <label class="required">Clause</label>
                            <input type="text" class="form-control" name="clauseModal" id="clauseModal" disabled required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="required">Audit Point</label>
                            <textarea class="form-control" rows="5" name="auditPointModal" id="auditPointModal" required disabled></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="required">Objective Evidence</label>
                            <textarea class="form-control" rows="5" name="objective_evidence" id="objective_evidence" required></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 mt-2">
                            <input class="form-check-input check-size mt-1" type="checkbox" id="isNcr" name="isNcr">
                            <label class="form-check-label mt-1" for="isNcr">
                                Is NCR
                            </label>
                        </div>
                    </div>
                    <div class="row mt-4 d-none hidden-row">
                        <div class="col-md-12">
                            <label class="required" id="files-label">Attachment</label>
                            <input type="file" class="form-control" name="file" id="file" accept=".pdf" required />
                        </div>
                    </div>
                    <div class="row mt-4 d-none hidden-row" id="extFile_row">
                        <div class="col-lg-12 ">
                            <div class="custom-select">
                                <div class="tag-wrapper">
                                    <div class="tags">
                                        <a href="" target="_blank" id="filePath"></a>
                                        <input type="hidden" class="form-control" name="extFilePath" id="extFilePath" value="<?php echo $result_data['id']; ?>">
                                        <input type="hidden" class="form-control" name="extFileName" id="extFileName" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 d-none hidden-row">
                        <div class="col-lg-12">
                            <label class="required" id="id-type">Finding Type</label>
                            <select class="form-control" name="finding_type" id="finding_type" required>
                                <option value="">Please Select</option>
                                <option value="Minor">Minor</option>
                                <option value="Major">Major</option>
                                <option value="Observation">Observation</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2 d-none hidden-row">
                        <div class="col-md-12 mt-2">
                            <label class="required" id="id-details">Finding Details</label>
                            <textarea class="form-control" rows="5" name="finding_details" id="finding_details" required></textarea>
                        </div>
                    </div>
                    <div class="row mt-2 d-none hidden-row">
                        <div class="col-md-12 mt-2">
                            <label class="required" id="id-product">Product / Process Impact </label>
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <input type="radio" value="Yes" name="product_process_impact" class="form-check-input product-process-impact" required />
                                    <label class="form-check-label">
                                        Yes
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" value="No" name="product_process_impact" class="form-check-input product-process-impact" required />
                                    <label class="form-check-label">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                    <button type="button" class="btn btn-sm btn-danger" id="audit_checklist_cancel" data-bs-dismiss="modal" onclick="resetModalVal()">Close</button>
                </div>
            </div>
        </form>
    </div>

</div>


<!-- Mitigation Modal End -->
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
<!--end::Javascript-->
<script>
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

    let checklistId = "";
    let ExistingFile = "";

    function checkAttachmentValid() {
        if (document.getElementById('isNcr').checked && ExistingFile == "") {
            $('.hidden-row').removeClass('d-none');
            $("#files-label").addClass('required');
            $("#id-type").addClass('required');
            $("#id-details").addClass('required');
            $("#id-product").addClass('required');
            return $("#file").attr('required', true);
        }
        $('.hidden-row').addClass('d-none');

        $("#files-label").removeClass('required');
        $("#finding_type").removeClass('required');
        $("#finding_details").removeClass('required');
        $(".product-process-impact").removeClass('required');
        $("#file").removeAttr('required');
        $("#finding_type").removeAttr('required');
        $("#finding_details").removeAttr('required');
        $(".product-process-impact").removeAttr('required');
    }

    $('#isNcr').on('click', function() {
        return checkAttachmentValid();
    })

    function resetModalVal() {
        ExistingFile = "";
        checklistId = "";
        $("#extFile_row").addClass('d-none');
        $("#clauseModal").val("");
        $("#audit_execute_id").val("");
        return $("#auditPointModal").val("");
    }

    $('body').delegate('.list-edit', 'click', function() {
        checklistId = $(this).data('id');
        let getData = getValue($(this).closest('tr')[0]);
        let setData = setValue(getData);
        let setExeData = setExecutionData();
        if (setData && setExeData) {
            return $('#audit_checklist_modal').modal('show');
        }
    });

    function setExecutionData() {
        let executionData = JSON.parse($('#executeArr').val());
        let audit_id = $('#audit_id').val();
        const exeObj = executionData.find((elem) => elem.audit_area_check_list_id == checklistId && elem.audit_id ==
            audit_id);
        $('#objective_evidence').val(exeObj?.objective_evidence);
        $('#isNcr').attr('checked', exeObj?.is_ncr == 1 ? true : false);
        $("#filePath").attr("href", exeObj?.file_path);
        $("#extFilePath").val(exeObj?.file_path);
        $("#extFileName").val(exeObj?.file_name);
        $("#filePath").text(exeObj?.file_name);
        if (exeObj?.file_name) {
            $("#extFile_row").removeClass('d-none');
        }
        $('#finding_type').val(exeObj?.finding_type);
        $('#finding_details').val(exeObj?.finding_details);
        $("input[name='product_process_impact'][value='${exeObj?.product_process_impact}']").prop("checked", true);
        $("#audit_execute_id").val(exeObj?.id);
        ExistingFile = exeObj?.file_path ? exeObj?.file_path : "";
        checkAttachmentValid();
        return true;
    }

    function getValue(row) {
        let clause = $(row).find('input[name="clause[]"').val();
        let auditPoint = $(row).find('input[name="audit_point[]"').val();
        return {
            clause,
            auditPoint,
        }
    }

    function setValue(dataArr) {
        if (Object.keys(dataArr)?.length > 0) {
            $('#clauseModal').val(dataArr.clause);
            $('#auditPointModal').val(dataArr.auditPoint);
            $('#audit_checklist_id').val(checklistId);
            return true;
        }
        return false;
    }
</script>
</body>
<!--end::Body-->

</html>