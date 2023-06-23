<?php
session_start();
include('includes/functions.php');

$email = $_SESSION['usuario'];
$sql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$roleInfo = mysqli_fetch_assoc($fetch);
$role = $roleInfo['Id_basic_role'];
$sql = "SELECT * From audit_co_ordinator Where Id_Employee = '$roleInfo[Id_employee]' AND status = 1";
$fetch = mysqli_query($con, $sql);
$coordinator = $fetch->num_rows == 1 ? "true" : "false";

$consulta =  "SELECT * FROM audit_management_list WHERE is_deleted = 0 order by id DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT * FROM audit_management_list WHERE is_deleted = 0 AND (unique_id LIKE '%" . $termino . "%' OR audit_type LIKE '%" . $termino . "%' OR status LIKE '%" . $termino . "%' OR start_date LIKE '%" . $termino . "%' OR end_date LIKE '%" . $termino . "%') order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '<div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-100px">Unique Id</th>
				<th class="min-w-100px">Audit Type</th>
				<th class="min-w-100px">Audit Area</th>
				<th class="min-w-50px">Schedule Start Date</th>
				<th class="min-w-50px">Schedule End Date</th>
				<th class="min-w-50px">Status</th>
				<th class="min-w-100px">Actions</th>
            </tr>
        </thead><tbody class="fw-bold text-gray-600">';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tr><td>";
		echo $result_data['unique_id'];
		echo "</td><td>";
		echo $result_data['audit_type'];
		echo "</td><td>";
		$sql = "";
		if ($result_data['audit_type'] == "Internal") {
			$sql = "SELECT admin_audit_area.audit_area as audit_area, admin_audit_area.audit_standard_id as standard_id  From audit_management_list 
			LEFT JOIN internal_audits ON audit_management_list.id = internal_audits.audit_id
			LEFT JOIN admin_audit_area ON internal_audits.audit_area_id = admin_audit_area.id
			Where audit_management_list.id = '$result_data[id]'";
		} else if ($result_data['audit_type'] == "External") {
			$sql = "SELECT external_and_customer_audits.audit_area as audit_area From audit_management_list 
			LEFT JOIN external_and_customer_audits ON audit_management_list.id = external_and_customer_audits.audit_id
			Where audit_management_list.id = '$result_data[id]'";
		}
		$fetch = mysqli_query($con, $sql);
		$info = mysqli_fetch_assoc($fetch);

		$auditors =  array();
		if ($result_data['audit_type'] == "Internal") {
			$auditorsSqlData = "SELECT * FROM admin_audit_standard_auditors WHERE admin_audit_standard_id = '$info[standard_id]' AND is_deleted = 0";
			$auditorsSqlConnect = mysqli_query($con, $auditorsSqlData);
			while ($row = mysqli_fetch_assoc($auditorsSqlConnect)) {
				array_push($auditors, $row['member_id']);
			}
		}

		echo $info['audit_area'];
		echo "</td><td>";
		echo date("d-m-y", strtotime($result_data['start_date']));
		echo "</td><td>";
		echo date("d-m-y", strtotime($result_data['end_date']));
		echo "</td>";
		switch ($result_data['status']) {
			case 'Scheduled':
				$class = 'status-info';
				break;
			case 'Audited':
				$class = 'status-active';
				break;
			case 'Delayed':
				$class = 'status-warning';
				break;
			case 'Cancelled':
				$class = 'status-danger';
				break;
		}
		echo '<td><div class="' . $class . '">' . $result_data['status'] . '</div></td>';
		echo "<td>";
		echo '<a href="/audit_management_edit.php?id=' . $result_data['id'] . '&view" class="me-3"><i class="fa fa-eye" aria-hidden="true"></i></a>';
		if ($result_data['status'] == "Audited") {
			echo '<a href="includes/audit_management_pdf.php?id=' . $result_data['id'] . '" target="_blank" class="me-3"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
		}
		if ($result_data['status'] != "Audited" && $result_data['status'] != "Cancelled" && ($role == 1 || $coordinator == "true")) {
			echo '<a href="includes/audit_management_edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
		}
		if ($result_data['status'] != "Audited" && $result_data['status'] != "Cancelled") {
			if ($result_data['audit_type'] == "Internal" && (in_array($roleInfo['Id_employee'], $auditors) || $role == 1 || $coordinator == "true")) {
				echo '<a href="/audit_management_edit.php?id=' . $result_data['id'] . '&view&execute" class="me-3"><i class="fas fa-play" aria-hidden="true"></i></a>';
			} else if ($result_data['audit_type'] == "External" && ($role == 1 || $coordinator == "true")) {
				echo '<a class="me-3 cursor-pointer confirmExeBtn"
				data-id="' . $result_data['id'] . '"><i
					class="fas fa-play"></i></a>';
			}
		}
		if ($result_data['status'] != "Cancelled" && $result_data['status'] != "Audited") {
			echo '<a href="includes/audit_management_cancel.php?id=' . $result_data['id'] . '" class="me-3"><i class="fa fa-remove" aria-hidden="true"></i></a>';
		}
		if ($role == 1) {
			echo '<a href="includes/audit_management_delete.php?id=' . $result_data['id'] . '&type=' . $result_data['audit_type'] . '" class="me-3"><i class="bi bi-trash" aria-hidden="true"></i></a>';
		}
		echo "</td></tr>";
	}
	echo "</tbody></table></div>";
}
