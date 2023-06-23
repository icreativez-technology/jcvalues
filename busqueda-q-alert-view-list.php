<?php
session_start();
include('includes/functions.php');

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 9 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$consulta =  "SELECT q_alert.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Department.Department, Basic_Plant.Title as plant, Basic_Product_Group.Title as product_group FROM q_alert 
LEFT JOIN Basic_Employee ON q_alert.created_by = Basic_Employee.Id_employee
LEFT JOIN Basic_Department ON q_alert.department_id = Basic_Department.Id_department
LEFT JOIN Basic_Plant ON q_alert.plant_id = Basic_Plant.Id_plant
LEFT JOIN Basic_Product_Group ON q_alert.product_group_id = Basic_Product_Group.Id_product_group
WHERE q_alert.is_deleted = 0 order by id DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT q_alert.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Department.Department, Basic_Plant.Title as plant, Basic_Product_Group.Title as product_group FROM q_alert 
	LEFT JOIN Basic_Employee ON q_alert.created_by = Basic_Employee.Id_employee
	LEFT JOIN Basic_Department ON q_alert.department_id = Basic_Department.Id_department
    LEFT JOIN Basic_Plant ON q_alert.plant_id = Basic_Plant.Id_plant
    LEFT JOIN Basic_Product_Group ON q_alert.product_group_id = Basic_Product_Group.Id_product_group
	WHERE q_alert.is_deleted = 0
	AND q_alert_id LIKE '%" . $termino . "%' OR Basic_Employee.First_Name LIKE '%" . $termino . "%' OR Basic_Employee.Last_Name LIKE '%" . $termino . "%' OR Basic_Department.Department LIKE '%" . $termino . "%' OR Basic_Plant.Title LIKE '%" . $termino . "%' OR Basic_Product_Group.Title LIKE '%" . $termino . "%' OR q_alert.status LIKE '%" . $termino . "%' OR q_alert.created_at LIKE '%" . $termino . "%' order by id DESC";
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
				<th class="min-w-125px">Unique Id</th>
				<th class="min-w-150px">Plant</th>
				<th class="min-w-150px">Created By</th>
				<th class="min-w-100px">Created</th>
				<th class="min-w-150px">Product Group</th>
				<th class="min-w-150px">Department</th>
				<th class="min-w-150px">Owner</th>
				<th class="min-w-30px">Status</th>
				<th class="min-w-125x">Action</th>
            </tr>
            <!--end::Table row-->
        </thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
		echo $result_data['q_alert_id'];
		echo "	</td>
							<td>";
		echo $result_data['plant'];
		echo "</td> <td>";
		echo $result_data['First_Name'] . " " . $result_data['Last_Name'];
		echo "</td> <td>";
		echo date("d-m-y", strtotime($result_data['created_at']));
		echo "</td> <td>";
		echo $result_data['product_group'];
		echo "</td> <td>";
		echo $result_data['Department'];
		echo "</td> <td>";
		if (isset($result_data['owner_id'])) {
			$sql = "SELECT * From Basic_Employee Where Id_employee = $result_data[owner_id]";
			$fetch = mysqli_query($con, $sql);
			$ownerInfo = mysqli_fetch_assoc($fetch);
			echo $ownerInfo['First_Name'] . " " . $ownerInfo['Last_Name'];
		} else {
			echo " ";
		}
		echo "</td>";
		$class = ($result_data['status'] == "Open") ? "status-danger" : "status-active";
		echo '<td><div class="' . $class . '">' . $result_data['status'] . '</div></td><td>';
		if ($canView == 1) {
			echo '<a href="/q_alert_view.php?id=' . $result_data['id'] . '" class="me-3"><i class="fa fa-eye" aria-hidden="true"></i></a>';
		}
		if ($result_data['status'] == "Closed") {
			if ($canView == 1) {
				echo '<a data-id="' . $result_data['id'] . '" data-unique="' . $result_data['q_alert_id'] . '" target="_blank" class="print-q-alert me-3"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
			}
		} else {
			if ($canEdit == 1) {
				echo '<a href="/q_alert_edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
			}
		}
		if ($role == 1 || $canDelete == 1) {
			echo '<a href="/includes/q_alert_delete.php?id=' . $result_data['id'] . '"><i class="bi bi-trash" aria-hidden="true"></i></a>';
		}
		echo "
						</td></tr>
				</tbody>
			";
	}
	echo "</table>
		</div>
		</div>";
}
