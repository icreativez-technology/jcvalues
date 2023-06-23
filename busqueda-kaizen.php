<?php
session_start();
include('includes/functions.php');

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 10 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$consulta =  "SELECT kaizen.*, created.First_Name, created.Last_Name, team_lead.First_Name, team_lead.Last_Name, Basic_Department.Department, Basic_Plant.Title as plant, Basic_Product_Group.Title as product_group FROM kaizen 
LEFT JOIN Basic_Employee as team_lead ON kaizen.team_leader_id = team_lead.Id_employee
LEFT JOIN Basic_Employee as created ON kaizen.created_by = created.Id_employee
LEFT JOIN Basic_Department ON kaizen.department_id = Basic_Department.Id_department
LEFT JOIN Basic_Plant ON kaizen.plant_id = Basic_Plant.Id_plant
LEFT JOIN Basic_Product_Group ON kaizen.product_group_id = Basic_Product_Group.Id_product_group
WHERE kaizen.is_deleted = 0 order by id DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT kaizen.*, created.First_Name, created.Last_Name, team_lead.First_Name, team_lead.Last_Name, Basic_Department.Department, Basic_Plant.Title as plant, Basic_Product_Group.Title as product_group FROM kaizen 
	LEFT JOIN Basic_Employee as team_lead ON kaizen.team_leader_id = team_lead.Id_employee
	LEFT JOIN Basic_Employee as created ON kaizen.created_by = created.Id_employee
	LEFT JOIN Basic_Department ON kaizen.department_id = Basic_Department.Id_department
    LEFT JOIN Basic_Plant ON kaizen.plant_id = Basic_Plant.Id_plant
    LEFT JOIN Basic_Product_Group ON kaizen.product_group_id = Basic_Product_Group.Id_product_group
	WHERE kaizen.is_deleted = 0
	AND kaizen_id LIKE '%" . $termino . "%' OR created.First_Name LIKE '%" . $termino . "%' OR created.Last_Name LIKE '%" . $termino . "%' OR team_lead.First_Name LIKE '%" . $termino . "%' OR team_lead.Last_Name LIKE '%" . $termino . "%' OR Basic_Department.Department LIKE '%" . $termino . "%' OR Basic_Plant.Title LIKE '%" . $termino . "%' OR Basic_Product_Group.Title LIKE '%" . $termino . "%' OR kaizen.status LIKE '%" . $termino . "%' order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '
    <div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-100px">Unique Id</th>
				<th class="min-w-70px">Plant</th>
				<th class="min-w-100px">Team Lead</th>
				<th class="min-w-100px">Created By</th>
				<th class="min-w-100px">Product Group</th>
				<th class="min-w-100px">Department</th>
				<th class="min-w-50px">Score</th>
				<th class="min-w-30px">Status</th>
				<th class="min-w-100px">Action</th>
            </tr>
        </thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
		echo $result_data['kaizen_id'];
		echo "	</td>
							<td>";
		echo $result_data['plant'];
		echo "</td>";
		$sql = "SELECT * From Basic_Employee Where Id_employee = $result_data[team_leader_id]";
		$fetch = mysqli_query($con, $sql);
		$leadInfo = mysqli_fetch_assoc($fetch);
		echo "<td>";
		echo $leadInfo['First_Name'] . ' ' . $leadInfo['Last_Name'];
		echo "</td>";
		$sql = "SELECT * From Basic_Employee Where Id_employee = $result_data[created_by]";
		$fetch = mysqli_query($con, $sql);
		$createdInfo = mysqli_fetch_assoc($fetch);
		echo "<td>";
		echo $createdInfo['First_Name'] . ' ' . $createdInfo['Last_Name'];
		echo "</td>";
		echo "<td>";
		echo $result_data['product_group'];
		echo "</td> <td>";
		echo $result_data['Department'];
		echo "</td> <td>";
		$sql = "SELECT * From kaizen_committee_evaluation Where kaizen_id = $result_data[id]";
		$fetch = mysqli_query($con, $sql);
		$scoreInfo = mysqli_fetch_assoc($fetch);
		echo (isset($scoreInfo['score']) ? $scoreInfo['score'] : "");;
		echo "</td>";
		$class = ($result_data['status'] == "Open") ? "status-danger" : "status-active";
		echo '<td><div class="' . $class . '">' . $result_data['status'] . '</div></td><td>';
		if ($canView == 1) {
			echo '<a href="/kaizen_detail_edit.php?id=' . $result_data['id'] . '&view" class="me-3"><i class="fa fa-eye" aria-hidden="true"></i></a>';
		}
		if ($result_data['status'] == "Evaluated") {
			if ($canView == 1) {
				echo ' <a data-id="' . $result_data['id'] . '" data-unique="' . $result_data['kaizen_id'] . '" target="_blank" class="print-kaizen me-3"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
			}
		} else {
			if ($canEdit == 1) {
				echo '<a href="/kaizen_detail_edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
			}
		}
		if ($role == 1 || $canDelete == 1) {
			echo '<a href="/includes/kaizen_delete.php?id=' . $result_data['id'] . '"><i class="bi bi-trash" aria-hidden="true"></i></a>';
		}
		echo "</td></tr>
				</tbody>
			";
	}
	echo "</table>
		</div>";
}
