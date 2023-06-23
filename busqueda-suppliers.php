<?php
session_start();
include('includes/functions.php');

$email = $_SESSION['usuario'];
$sql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$roleInfo = mysqli_fetch_assoc($fetch);
$role = $roleInfo['Id_basic_role'];

$consulta = "SELECT Basic_Supplier.*,  tbl_Countries.CountryName FROM Basic_Supplier LEFT JOIN tbl_Countries ON Basic_Supplier.Country_of_Origin = tbl_Countries.CountryID order by Basic_Supplier.Id_Supplier DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT Basic_Supplier.*,  tbl_Countries.CountryName FROM Basic_Supplier LEFT JOIN tbl_Countries ON Basic_Supplier.Country_of_Origin = tbl_Countries.CountryID WHERE Supplier_Id LIKE '%" . $termino . "%' OR Supplier_Name LIKE '%" . $termino . "%' OR Status LIKE '%" . $termino . "%' OR tbl_Countries.CountryName LIKE '%" . $termino . "%' OR Classification_Type LIKE '%" . $termino . "%' OR Scope_of_Supply LIKE '%" . $termino . "%' order by Basic_Supplier.Id_Supplier DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '<div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
		<tr class="text-start text-gray-400 text-uppercase gs-0">
			<th class="min-w-100px">Supplier Id</th>
			<th class="min-w-100px">Supplier Name</th>
			<th class="min-w-100px">Country Of Origin</th>
			<th class="min-w-100px">Classification Type</th>
			<th class="min-w-100px">Scope Of Supply</th>
			<th class="min-w-50px">Status</th>
			<th class="text-end min-w-100px">Actions</th>
		</tr>
        </thead><tbody class="fw-bold text-gray-600">';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tr><td>";
		echo $result_data['Supplier_Id'];
		echo "</td><td>";
		echo $result_data['Supplier_Name'];
		echo "</td><td>";
		echo $result_data['CountryName'];
		echo "</td><td>";
		echo $result_data['Classification_Type'];
		echo "</td><td>";
		echo $result_data['Scope_of_Supply'];
		echo "</td>";
		switch ($result_data['Status']) {
			case 'Approved':
				$class = 'status-active';
				break;
			case 'Pending':
				$class = 'status-warning';
				break;
			case 'Suspended':
				$class = 'status-danger';
				break;
		}
		echo '<td><div class="' . $class . '">' . $result_data['Status'] . '</div></td>';
		echo "<td class='text-end'>";
		echo '<a href="/admin_suppliers-view.php?pg_id=' . $result_data['Id_Supplier'] . '" class="me-3"><i class="bi bi-eye-fill" aria-hidden="true"></i></a>';
		echo '<a href="/admin_suppliers-edit.php?pg_id=' . $result_data['Id_Supplier'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
		if ($role == 1) {
			echo '<a href="/admin_suppliers-delete.php?pg_id=' . $result_data['Id_Supplier'] . '" class="me-3"><i class="bi bi-trash" aria-hidden="true"></i></a>';
		}
		echo "</td></tr>";
	}
	echo "</tbody></table></div>";
}
