<?php
session_start();
include('includes/functions.php');

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 4 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$consulta = "SELECT quality_moc.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Department.Department, Quality_MoC_Type.Title as moc_type, Basic_Product_Group.Title as product_group, Basic_Plant.Title as plant FROM quality_moc 
LEFT JOIN Basic_Employee ON quality_moc.created_by = Basic_Employee.Id_employee 
LEFT JOIN Basic_Department ON quality_moc.department_id = Basic_Department.Id_department
LEFT JOIN Basic_Product_Group ON quality_moc.product_group_id = Basic_Product_Group.Id_product_group
LEFT JOIN Basic_Plant ON quality_moc.plant_id = Basic_Plant.Id_plant
LEFT JOIN Quality_MoC_Type ON quality_moc.moc_type_id = Quality_MoC_Type.Id_quality_moc_type
WHERE quality_moc.is_deleted = 0 order by created_at DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta = "SELECT quality_moc.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Department.Department, Quality_MoC_Type.Title as moc_type, Basic_Product_Group.Title as product_group, Basic_Plant.Title as plant FROM quality_moc 
	LEFT JOIN Basic_Employee ON quality_moc.created_by = Basic_Employee.Id_employee 
	LEFT JOIN Basic_Department ON quality_moc.department_id = Basic_Department.Id_department
	LEFT JOIN Basic_Product_Group ON quality_moc.product_group_id = Basic_Product_Group.Id_product_group
	LEFT JOIN Basic_Plant ON quality_moc.plant_id = Basic_Plant.Id_plant
	LEFT JOIN Quality_MoC_Type ON quality_moc.moc_type_id = Quality_MoC_Type.Id_quality_moc_type
	WHERE quality_moc.is_deleted = 0
	AND (moc_id LIKE '%" . $termino . "%' OR Basic_Employee.First_Name LIKE '%" . $termino . "%' OR Basic_Employee.Last_Name LIKE '%" . $termino . "%' OR Basic_Plant.Title LIKE '%" . $termino . "%' OR Basic_Product_Group.Title LIKE '%" . $termino . "%' OR Basic_Department.Department LIKE '%" . $termino . "%' OR Quality_MoC_Type.Title LIKE '%" . $termino . "%' OR quality_moc.status LIKE '%" . $termino . "%' OR quality_moc.created_at LIKE '%" . $termino . "%') order by created_at DESC";
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
				<th class="min-w-150px">Unique ID</th>
				<th class="min-w-150px">Created By</th>
				<th class="min-w-100px">Created</th>
				<th class="min-w-125px">Plant</th>
				<th class="min-w-125px">Product Group</th>
				<th class="min-w-125px">Department</th>
				<th class="min-w-125px">MoC Type</th>
				<th class="min-w-100px">Status</th>
				<th class="min-w-100px">Action</th>
			</tr>
            <!--end::Table row-->
        </thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
		echo $result_data['moc_id'];
		echo "	</td>
							<td>";
		echo $result_data['First_Name'] . " " . $result_data['Last_Name'];
		echo "</td> <td>";
		echo date("d-m-y", strtotime($result_data['created_at']));
		echo "</td> <td>";
		echo $result_data['plant'];
		echo "</td> <td>";
		echo $result_data['product_group'];
		echo "</td> <td>";
		echo $result_data['Department'];
		echo "</td> <td>";
		echo $result_data['moc_type'];
		echo "</td>";
		$class = ($result_data['status'] == "Created") ? "status-warning" : (($result_data['status'] == "Approved") ? "status-active" : "status-danger");
		echo '<td><div class="' . $class . '">' . $result_data['status'] . '</div></td><td>';
		if ($result_data['status'] == "Created" || $result_data['status'] == "Rejected") {
			if ($canEdit == 1) {
				echo '<a href="/quality-moc-edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
			}
		} else {
			if ($canView == 1) {
				echo '<a data-id="' . $result_data['id'] . '"" data-unique="' . $result_data['moc_id'] . '" target="_blank" class="print-quality-moc-mtc me-3"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
			}
		}
		if ($canEdit == 1) {
			echo '<a href="/quality-moc-edit.php?id=' . $result_data['id'] . '&type=view" class="me-3"><i class="bi bi-eye" aria-hidden="true"></i></a>';
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
