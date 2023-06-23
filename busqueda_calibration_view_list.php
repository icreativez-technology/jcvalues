<?php
session_start();
include('includes/functions.php');
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$department = $roleInfo['Id_department'];
$eligible = ($role == 1 || $department == 5 || $department == 9) ? true : false;
$consulta =  "SELECT * FROM calibrations WHERE is_deleted = 0 order by id DESC";
$termino = "";

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];

if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT * FROM calibrations WHERE is_deleted = 0
	AND instrument_id LIKE '%" . $termino . "%' OR instrument_name LIKE '%" . $termino . "%' order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '<div class="card-body pt-0 table-responsive" style="overflow-x:unset!important">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-100px">Instrument Id</th>
				<th class="min-w-100px">Instrument Name</th>
				<th class="min-w-100px">Location</th>
				<th class="min-w-100px">Cal Done On</th>
				<th class="min-w-100px">Cal Due On</th>
				<th class="min-w-100px">Movements</th>
				<th class="min-w-100px">Status</th>
				<th class="min-w-100px text-end">Action</th>
            </tr>
        </thead>';

	$i = 0;
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		$i++;
		echo "<tbody class='fw-bold text-gray-600'><tr>";
		echo "<td>";
		echo $result_data['instrument_id'];
		echo "</td><td>";
		echo $result_data['instrument_name'];
		echo "</td><td>";
		echo $result_data['storage_location'];
		echo "</td><td>";
		$calibInSql = "SELECT * FROM calibration_in LEFT JOIN calibration_history ON calibration_history.id = calibration_in.calibration_history_id WHERE calibration_history.calibration_id = '$result_data[id]' ORDER BY calibration_in.id DESC LIMIT 1";
		$calibInConnection = mysqli_query($con, $calibInSql);
		$calibInInfo = mysqli_fetch_assoc($calibInConnection);
		$calibDueOn = $result_data['calibration_due_on'];
		$calibDoneOn = $result_data['calibration_done_on'];
		$filePath = $result_data['file_path'];
		if ($calibInConnection->num_rows != 0) {
			$calibDueOn = $calibInInfo['calibration_due_on'];
			$calibDoneOn = $calibInInfo['calibration_done_on'];
			$filePath = $calibInInfo['file_path'];
		}
		echo date("d-m-y", strtotime($calibDoneOn));
		echo "</td><td>";
		echo date("d-m-y", strtotime($calibDueOn));
		echo "</td>";
		$class = ($result_data['calibration_status'] == "Issuance") ? "status-active" : "status-danger";
		echo '<td><div class="' . $class . '">' . $result_data['calibration_status'] . '</div></td>';
		switch ($result_data['status']) {
			case 'Delay':
				$cl = 'status-info';
				break;
			case 'Due':
				$cl = 'status-warning';
				break;
			case 'Rejected':
				$cl = 'status-danger';
				break;
			case 'Active':
				$cl = 'status-active';
				break;
		}
		echo '<td><div class="' . $cl . '">' . $result_data['status'] . '</div></td>';
		echo "<td>";
		echo '<div
		class="d-flex justify-content-end align-items-center px-3 column-gap">

		<div class="dropdown">
		<button class="btn btn-sm btn-icon btn-light btn-active-light-primary" type="button" id="drp_btn_' . $i . '" data-bs-toggle="dropdown" aria-expanded="false">
		<span class="svg-icon svg-icon-5 m-0">
			<svg xmlns="http://www.w3.org/2000/svg"
				width="24" height="24" viewBox="0 0 24 24"
				fill="none">
				<rect x="10" y="10" width="4" height="4"
					rx="2" fill="currentColor"></rect>
				<rect x="17" y="10" width="4" height="4"
					rx="2" fill="currentColor"></rect>
				<rect x="3" y="10" width="4" height="4"
					rx="2" fill="currentColor"></rect>
			</svg>
		</span>
		</button>
		<ul class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" aria-labelledby="drp_btn_' . $i . '" role="menu" >
		<li>
		<div class="menu-item px-3">
		<a href="/calibration_edit.php?id=' . $result_data['id'] . '&view"
			class="menu-link px-3">
			View
		</a>
	</div>
		   </li>';
		if ($eligible) {
			echo '<li>
		   <div class="menu-item px-3">
		   <a href="calibration_edit.php?id=' . $result_data['id'] . '"
			   class="menu-link px-3">Edit</a>
	   </div>
		  </li>';
		}
		echo '<li>
		  <div class="menu-item px-3">
					<a href="' . $filePath . '" target="_blank"
						class="menu-link px-3">
						PDF
					</a>
				</div>
		  </li>
		  </a>';
		if ($role == 1) {
			echo '<li> <div class="menu-item px-3">
					  <a class="menu-link px-3"
						  href="/includes/calibration_delete.php?id=' . $result_data['id'] . '">Delete</a>
				  </div></li>';
		}
		if ($result_data['status'] != 'Rejected') {
			echo '<li> <div class="menu-item px-3">
					<a class="menu-link px-3"
						href="/includes/calibration_status_update.php?pg_id=' . $result_data['id'] . '">Reject</a>
				</div></li>';
		}
		echo '</ul></div></div></div>';
		echo "</td>";
	}
	echo "</tr></tbody></table></div>";
}
