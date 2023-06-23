<?php
session_start();
include('includes/functions.php');

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 5 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$consulta = "SELECT quality_risk.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Department.Department, Quality_Process.Title as process ,Basic_Plant.Title as plant FROM quality_risk LEFT JOIN Basic_Employee ON quality_risk.created_by = Basic_Employee.Id_employee
LEFT JOIN Basic_Department ON quality_risk.department_id = Basic_Department.Id_department
LEFT JOIN Quality_Process ON quality_risk.process_id = Quality_Process.Id_quality_process
LEFT JOIN Basic_Plant ON quality_risk.plant_id = Basic_Plant.Id_plant 
WHERE quality_risk.is_deleted = 0 order by created_at DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta = "SELECT quality_risk.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Department.Department, Quality_Process.Title as process, Basic_Plant.Title as plant FROM quality_risk LEFT JOIN Basic_Employee ON quality_risk.created_by = Basic_Employee.Id_employee
	LEFT JOIN Basic_Department ON quality_risk.department_id = Basic_Department.Id_department
	LEFT JOIN Quality_Process ON quality_risk.process_id = Quality_Process.Id_quality_process
	LEFT JOIN Basic_Plant ON quality_risk.plant_id = Basic_Plant.Id_plant 
	WHERE quality_risk.is_deleted = 0 AND (risk_id LIKE '%" . $termino . "%' OR Basic_Employee.First_Name LIKE '%" . $termino . "%' OR Basic_Employee.Last_Name LIKE '%" . $termino . "%' OR Basic_Plant.Title LIKE '%" . $termino . "%' OR Basic_Department.Department LIKE '%" . $termino . "%' OR Quality_Process.Title LIKE '%" . $termino . "%' OR quality_risk.status LIKE '%" . $termino . "%' OR quality_risk.created_at LIKE '%" . $termino . "%') order by created_at DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '
    <div class="card-body pt-0 table-responsive">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <!--begin::Table head-->
        <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-135px">Unique ID</th>
				<th class="min-w-150px">Created By</th>
				<th class="min-w-75px">Created</th>
				<th class="min-w-150px">Plant</th>
				<th class="min-w-100px">Department</th>
				<th class="min-w-135px">Process</th>
				<th class="min-w-100px">Status</th>
				<th class="min-w-100px">Action</th>
            </tr>
            <!--end::Table row-->
        </thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
		echo $result_data['risk_id'];
		echo "	</td>
							<td>";
		echo $result_data['First_Name'] . " " . $result_data['Last_Name'];
		echo "</td> <td>";
		echo date("d-m-y", strtotime($result_data['created_at']));
		echo "</td> <td>";
		echo $result_data['plant'];
		echo "</td> <td>";
		echo $result_data['Department'];
		echo "</td> <td>";
		echo $result_data['process'];
		echo "</td>";
		$class = ($result_data['status'] == "Assessed") ? "status-warning" : (($result_data['status'] == "Approved") ? "status-active" : "status-danger");
		echo '<td><div class="' . $class . '">' . $result_data["status"] . '</div></td>';
		echo '<td>';
		if ($result_data['status'] == "Assessed" || $result_data['status'] == "Rejected") {
			if ($canEdit == 1) {
				echo '<a href="/quality-risk-edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
			}
		} else {
			if ($canView == 1) {
				echo '<a data-id="' . $result_data['id'] . '" data-unique="' . $result_data['risk_id'] . '" class="print-quality-risk me-3" target="_blank"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
			}
		}
		if ($canView == 1) {
			echo '<a href="/quality-risk-edit.php?id=' . $result_data['id'] . '&type=view" class="me-3"><i class="bi bi-eye" aria-hidden="true"></i></a>';
		}
		if ($role == 1 || $canDelete == 1) {
			echo '<a href="/includes/quality-risk-delete.php?id=' . $result_data['id'] . '"><i class="bi bi-trash" aria-hidden="true"></i></a>';
		}
		echo "</td></tr></tbody>";
	}
	echo "</table>
		</div>
		</div>";
}
