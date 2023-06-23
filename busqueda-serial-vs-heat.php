<?php
session_start();
include('includes/functions.php');

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 17 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$consulta = "SELECT serial_heat_details.*, created.First_Name, created.Last_Name FROM serial_heat_details 
LEFT JOIN Basic_Employee as created ON serial_heat_details.created_by = created.Id_employee
WHERE is_deleted = 0 order by id DESC";

$termino = "";
if (isset($_POST['productos'])) {
    $termino = mysqli_real_escape_string($con, $_POST['productos']);
    $consulta = "SELECT serial_heat_details.*, created.First_Name, created.Last_Name FROM serial_heat_details 
    LEFT JOIN Basic_Employee as created ON serial_heat_details.created_by = created.Id_employee
    WHERE is_deleted = 0 AND (cert_n LIKE '%" . $termino . "%' OR revision LIKE '%" . $termino . "%' OR po_no LIKE '%" . $termino . "%' OR created_at LIKE '%" . $termino . "%' OR created.First_Name LIKE '%" . $termino . "%' OR created.Last_Name LIKE '%" . $termino . "%') order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
    echo '<div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
                <th class="min-w-150px">Certificate No.</th>
                <th class="min-w-70px">Version</th>
                <th class="min-w-150px">PO Number</th>
                <th class="min-w-150px">Created By</th>
                <th class="min-w-150px">Created Date</th>
                <th class="min-w-100px">Action</th>
            </tr>
        </thead>';
    while ($result_data = mysqli_fetch_assoc($consultaBD)) {
        echo "<tbody class='fw-bold text-gray-600'><tr><td>";
        echo $result_data['cert_n'];
        echo "</td><td>";
        echo $result_data['revision'];
        echo "</td><td>";
		echo $result_data['po_no'];
        echo "</td><td>";
        $sql = "SELECT * From Basic_Employee Where Id_employee = $result_data[created_by]";
        $fetch = mysqli_query($con, $sql);
        $createdInfo = mysqli_fetch_assoc($fetch);
        echo $createdInfo['First_Name'] . ' ' . $createdInfo['Last_Name'];
        echo "</td><td>";
		echo date("d-m-y", strtotime($result_data['created_at']));
        echo "</td><td>";
		if ($canView == 1) {
			echo '<a href="/serial_heat_edit.php?id=' . $result_data['id'] . '&view" class="me-3 set-url"><i class="fa fa-eye" aria-hidden="true"></i></a>';
			echo ' <a data-id="' . $result_data['id'] . '" target="_blank" class="print-serial-vs-heat me-3"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
		}
		if ($canEdit == 1) {
			echo '<a href="/serial_heat_edit.php?id=' . $result_data['id'] . '" class="me-3 set-url"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
		}
		if ($role == 1 || $canDelete == 1) {
			echo '<a href="/includes/serial_heat_delete.php?id=' . $result_data['id'] . '" class="set-url"><i class="bi bi-trash" aria-hidden="true"></i></a>';
		}
        echo "</td></tr></tbody>";
    }
    echo "</table>
		</div>
		</div>";
}