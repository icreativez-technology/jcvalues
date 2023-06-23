<?php
session_start();
include('includes/functions.php');
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 3 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$consulta =  "SELECT * FROM audit_nc_capa_ncr_details WHERE is_deleted = 0 order by id DESC";
$termino = "";
if (isset($_POST['productos'])) {
    $termino = mysqli_real_escape_string($con, $_POST['productos']);
    $consulta =  "SELECT audit_nc_capa_ncr_details.id, audit_nc_capa_ncr_details.unique_id, audit_nc_capa_ncr_details.status, audit_nc_capa_ncr_details.audit_id FROM audit_nc_capa_ncr_details LEFT JOIN audit_management_list ON audit_nc_capa_ncr_details.audit_id = audit_management_list.id WHERE audit_nc_capa_ncr_details.is_deleted = 0
	AND (audit_nc_capa_ncr_details.unique_id LIKE '%" . $termino . "%' OR audit_management_list.unique_id LIKE '%" . $termino . "%' OR audit_management_list.audit_type LIKE '%" . $termino . "%' OR audit_nc_capa_ncr_details.status LIKE '%" . $termino . "%') order by audit_nc_capa_ncr_details.id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
    echo ' <div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5"
        id="kt_department_table" data-cols-width="20,10,10, 20, 20, 20, 20">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                <th class="min-w-100px">Finding Id</th>
                <th class="min-w-100px">Audit Id</th>
                <th class="min-w-100px">Audit Type</th>
                <th class="min-w-100px">Audit Area</th>
                <th class="min-w-100px">Audit Standard</th>
                <th class="min-w-100px">Department</th>
                <th class="min-w-100px">Status</th>
                <th class="min-w-100px">Action</th>
            </tr>
        </thead>';
    while ($result_data = mysqli_fetch_assoc($consultaBD)) {
        echo "<tbody class='fw-bold text-gray-600'><tr>";
        echo "<td>";
        echo $result_data['unique_id'];
        echo "</td><td>";
        $sql = "SELECT * FROM audit_management_list WHERE is_deleted = 0 AND id = $result_data[audit_id]";
        $fetch = mysqli_query($con, $sql);
        $audit = mysqli_fetch_assoc($fetch);
        if ($audit['audit_type'] == "Internal") {
            $sql = "SELECT admin_audit_area.audit_area as audit_area, admin_audit_area.department_id as department_id, admin_audit_standard.audit_standard as audit_standard From audit_management_list 
            LEFT JOIN internal_audits ON audit_management_list.id = internal_audits.audit_id
            LEFT JOIN admin_audit_area ON internal_audits.audit_area_id = admin_audit_area.id
            LEFT JOIN admin_audit_standard ON admin_audit_area.audit_standard_id = admin_audit_standard.id
            where audit_management_list.id = '$result_data[audit_id]'";
        } else {
            $sql = "SELECT * From external_and_customer_audits where audit_id = '$result_data[audit_id]'";
        }
        $fetch = mysqli_query($con, $sql);
        $info = mysqli_fetch_assoc($fetch);
        echo $audit['unique_id'];
        echo "</td><td>";
        echo $audit['audit_type'];
        echo "</td><td>";
        echo $info['audit_area'];
        echo "</td><td>";
        echo $info['audit_standard'];
        echo "</td><td>";
        $sql_dept = "SELECT * FROM Basic_Department where Id_department = $info[department_id]";
        $fetch = mysqli_query($con, $sql_dept);
        $dept = mysqli_fetch_assoc($fetch);
        echo $dept['Department'];
        echo "</td><td>";
        $class = ($result_data['status'] == "Open") ? "status-danger" : "status-active";
        echo '<div class="' . $class . '">' . $result_data['status'] . '</div>';
        echo "</td><td>";
        if ($canView == 1) {
            echo '<a href="/audit_nc_capa_edit.php?id=' . $result_data['id'] . '&type=view" class="me-3"><i class="bi bi-eye text-primary" aria-hidden="true"></i></a>';
        }
        if ($result_data['status'] == "Open") {
            if ($canEdit == 1) {
                echo '<a href="/audit_nc_capa_edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
            }
        } else {
            if ($canView == 1) {
                echo '<a href="/audit_nc_capa_pdf.php?id=' . $result_data['id'] . '" class="me-3" target="_blank"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
            }
        }
        if ($role == 1 || $canDelete == 1) {
            echo '<a href="/includes/audit_nc_capa_delete.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-trash" aria-hidden="true"></i></a>';
        }
        echo "</td>";
    }
    echo "</tr></tbody></table></div>";
}
