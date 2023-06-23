<?php
session_start();
include('includes/functions.php');
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$department = $roleInfo['Id_department'];
$eligible = ($role == 1 || $department == 9) ? true : false;
$consulta = "SELECT * FROM inspection LEFT JOIN Basic_Customer ON Basic_Customer.Id_customer = inspection.customer WHERE inspection.is_deleted = 0 order by id desc";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT * FROM inspection LEFT JOIN Basic_Customer ON Basic_Customer.Id_customer = inspection.customer WHERE is_deleted = 0 AND (unique_id LIKE '%" . $termino . "%' OR order_ref LIKE '%" . $termino . "%' OR Customer_Name LIKE '%" . $termino . "%') order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '<div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-100px">Unique Id</th>
				<th class="min-w-100px">Order Ref#</th>
				<th class="min-w-100px">Customer Name</th>
				<th class="min-w-100px">From</th>
				<th class="min-w-100px">To</th>
				<th class="min-w-100px">Stage</th>
				<th class="min-w-100px">Status</th>
				<th class="min-w-100px">Action</th>
            </tr>
        </thead><tbody class="fw-bold text-gray-600">';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tr><td>";
		echo $result_data['unique_id'];
		echo "</td><td>";
		echo $result_data['order_ref'];
		echo "</td><td>";
		echo $result_data['Customer_Name'];
		echo "</td><td>";
		echo date("d-m-y H:i:s", strtotime($result_data['from_date']));
		echo "</td><td>";
		echo date("d-m-y H:i:s", strtotime($result_data['to_date']));
		echo "</td><td>";
		echo $result_data['stage_of_inspection'];
		echo "</td>";
		switch ($result_data['status']) {
			case 'Scheduled':
				$class = 'status-info';
				break;
			case 'Delay':
				$class = 'status-warning';
				break;
			case 'Cancelled':
				$class = 'status-danger';
				break;
			case 'Completed':
				$class = 'status-active';
				break;
		}
		echo '<td><div class="' . $class . '">' . $result_data['status'] . '</div></td>';
		echo "<td>";
		echo '<a href="/inspection_edit.php?id=' . $result_data['id'] . '&view" class="me-3"><i class="fa fa-eye" aria-hidden="true"></i></a>';
		if ($result_data['status'] != "Completed" && $result_data['status'] != "Cancelled" && $eligible) {
			echo '<a href="/inspection_edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
			echo '<a href="includes/inspection_status.php?id=' . $result_data['id'] . '&status=cancel" class="me-3"><i class="fa fa-remove" aria-hidden="true"></i></a>';
		}
		if ($result_data['status'] == "Completed") {
			echo '<a data-id="' . $result_data['id'] . '" data-unique="' . $result_data['unique_id'] . '" class="me-3 print-pdf cursor-pointer" target="_blank"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
		}
		if ($role == 1) {
			echo '<a href="includes/inspection_delete.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-trash" aria-hidden="true"></i></a>';
		}
		echo "</td></tr>";
	}
	echo "</tbody></table></div>";
}
