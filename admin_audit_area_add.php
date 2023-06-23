<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Audit Area";

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];

$auditeeSql = "SELECT * FROM Basic_Employee WHERE Status = 'Active';";
$auditeeConnectData = mysqli_query($con, $auditeeSql);
$auditeeData =  array();
while ($row = mysqli_fetch_assoc($auditeeConnectData)) {
    array_push($auditeeData, $row);
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>

<!--begin::Body-->
<style>
    .required::after {
        content: "*";
        color: #e1261c;
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

    #audit_checklist_form {
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
                <!-- Includes Top bar and Responsive Menu -->
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <!--begin::Title-->
                        <div>
                            <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#admin-menu-modal">Admin Panel</a> » <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#admin-menu-modal">Audit</a> » <a href="/admin_audit_area.php">Audit Area
                                    List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                            <!-- MIGAS DE PAN -->
                        </div>
                    </div>
                    <!--end::body-->
                </div>
                <!--end::BREADCRUMBS-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-custom gutter-b example example-compact">
                            <form class="form" action="includes/admin_audit_area_store.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="required">Audit Area</label>
                                            <input type="text" class="form-control" name="audit_area" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                                <small class="text-danger">The Audit Area has already been
                                                    taken</small>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Audit Standard</label>
                                            <select class="form-control" name="audit_standard_id" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                $sql_data = "SELECT * FROM admin_audit_standard WHERE status = 'Active' AND is_deleted = 0";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                ?>
                                                    <option value="<?php echo $result_data['id']; ?>">
                                                        <?php echo $result_data['audit_standard']; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Audit Checklist Format No</label>
                                            <input type="text" class="form-control" name="audit_check_list_format_no" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Revision No</label>
                                            <input type="text" class="form-control" name="revision_no" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <input type="hidden" name="auditeeArr" id="auditeeArr" value='<?php echo json_encode($auditeeData) ?>'>
                                        <div class="col-lg-3">
                                            <label class="required">Department</label>
                                            <select class="form-control" name="department_id" id="department" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plantId' AND Basic_Department.Status = 'Active'";
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
                                        <div class="col-lg-9">
                                            <label class="required">Assign Auditee</label>
                                            <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Auditees" name="auditee[]" id="auditee" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" required multiple>
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
                                    <div class="container-full customer-header d-flex justify-content-between mt-4">
                                        Assign Check List
                                        <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#audit_checklist_modal"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_ncr_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                <th class="min-w-100px ps-3">Clause</th>
                                                <th class="min-w-450px">Audit Point</th>
                                                <th class="min-w-50px pe-3">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600" id="list-table">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <div style="text-align: right;"><input type="submit" class="btn btn-sm btn-success m-3" value="Save"><a type="button" href="/admin_audit_area.php" class="btn btn-sm btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->


                <div class="modal right fade" id="audit_checklist_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="audit_checklist_form" class="form" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header right-modal">
                                    <h5 class="modal-title" id="staticBackdropLabel">Assign Check List
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetModalVal()"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="required">Clause</label>
                                            <input type="text" class="form-control" name="clauseModal" id="clauseModal" required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <label class="required">Audit Point</label>
                                            <textarea class="form-control" name="auditPointModal" id="auditPointModal" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" id="audit_checklist_submit">Add</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="audit_checklist_cancel" data-bs-dismiss="modal" onclick="resetModalVal()">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>

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
        $(document).ready(function() {
            getAuditee();
        });

        $('#department').on('change', function() {
            getAuditee();
        });

        function getAuditee() {
            let departmentId = $('#department').val();
            let auditeeArr = JSON.parse($('#auditeeArr').val());
            filterArr = new Array();
            const auditee = auditeeArr.map((elem) => {
                if (elem.Id_department == departmentId) {
                    return filterArr.push({
                        name: `${elem.First_Name} ${elem.Last_Name}`,
                        id: elem.Id_employee,
                    })

                }
            })
            $("#auditee").empty();
            $("#auditee").append('<option value="">Please Select</option>');
            filterArr.map((elem) => {
                return $('#auditee').append(`<option value="${elem.id}">${elem.name}</option>`)
            })
        }

        let rowId = 0;
        let editRowId = "";

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('#audit_checklist_form').submit(function(e) {
            e.preventDefault()
            let clauseModal = $("#clauseModal").val();
            let auditPointModal = $("#auditPointModal").val();
            return appendTask(clauseModal, auditPointModal);
        });


        function appendTask(clauseModal, auditPointModal) {
            if (editRowId != "") {
                let content = `
        <td><input class="form-control" type="hidden" name="clause[]" value="${clauseModal}" required>${clauseModal}</td>
        <td><input class="form-control" type="hidden" name="audit_point[]" value="${auditPointModal}" required>${auditPointModal}</td>
        <td class="list-row">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>`
                $('#' + editRowId).empty();
                $('#' + editRowId).append(content);
            } else {
                rowId++;
                let content = `<tr id="${rowId}"> 
            <td><input class="form-control" type="hidden" name="clause[]" value="${clauseModal}" required>${clauseModal}</td>
        <td><input class="form-control" type="hidden" name="audit_point[]" value="${auditPointModal}" required>${auditPointModal}</td>
        <td class="list-row">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>
        </tr>`
                $('#list-table').append(content);
            }
            return $('#audit_checklist_cancel').trigger("click");
        }

        function resetModalVal() {
            editRowId = "";
            $("#clauseModal").val("");
            return $("#auditPointModal").val("");
        }

        $('body').delegate('.list-edit', 'click', function() {
            editRowId = $(this).closest('tr')[0].id;
            let getData = getValue($(this).closest('tr')[0]);
            let setData = setValue(getData);
            if (setData) {
                return $('#list-add')[0].click();
            }
        });


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
                return true;
            }
            return false;
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>