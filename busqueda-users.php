<?php

require_once "includes/functions.php";

$consulta = " SELECT * FROM Basic_Product_Group LIMIT 0";
$termino = "";

if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta = "SELECT * FROM Basic_Employee WHERE First_Name LIKE '%" . $termino . "%' OR Status LIKE '%" . $termino . "%' OR Last_Name LIKE '%" . $termino . "%' OR Email LIKE '%" . $termino . "%' OR Admin_User LIKE '%" . $termino . "%' OR Custom_ID LIKE '%" . $termino . "%'";
}

$consultaBD = mysqli_query($con, $consulta);


if ($consultaBD && strlen($termino) > 0) {
	echo '
			<div class="card-body pt-0 table-responsive">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_Product Groups_table">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-muted text-uppercase gs-0">
												<th class="min-w-90px px-0 ps-3">
													Employee
												</th>
												<th class="min-w-50px">
													Email
												</th>
												<th class="min-w-100px">
													ID
												</th>
												<th class="min-w-70px px-0">
													Plant
												</th>
												<th class="min-w-70px px-0">
													Depart
												</th>
												<th class="min-w-50px px-0">
													Role
												</th>
												<th class="min-w-100px px-0">
													Plant Head
												</th>
												<th class="min-w-80px px-0">
													Dep. Head
												</th>
												<th class="min-w-100px px-0">
													Manag. Rep.
												</th>
												<th class="min-w-40px px-0">
													CCR
												</th>
												<th class="min-w-70px px-0">
													Created
												</th>
												<th class="min-w-80px px-0">
													Modified
												</th>
												<th class="min-w-60px px-0">
													Status
												</th>
												<th class="text-end min-w-25px pe-3">Actions</th>
											</tr>
											<!--end::Table row-->
										</thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
			<tr>
				<td class='d-flex align-items-center'>";
		echo $result_data['First_Name'] . ' ' . $result_data['Last_Name'];
		echo "</td>";

		echo "<td>";
		echo $result_data['Email'];
		echo "</td>";

		echo "<td>";
		echo $result_data['Custom_ID'];
		echo "</td>";

		echo "<td>";
		/*Select Plants Name*/
		$sql_data_plants = "SELECT Id_plant, Title FROM Basic_Plant WHERE Id_plant LIKE '$result_data[Id_plant]'";
		$connect_data_plants = mysqli_query($con, $sql_data_plants);
		$result_data_plants = mysqli_fetch_assoc($connect_data_plants);
		echo $result_data_plants['Title'];
		echo "</td>";

		echo "<td>";
		/*Select Department Name*/
		$sql_data_department = "SELECT Id_department, Department FROM Basic_Department WHERE Id_department LIKE '$result_data[Id_department]'";
		$connect_data_department = mysqli_query($con, $sql_data_department);
		$result_data_department = mysqli_fetch_assoc($connect_data_department);
		echo $result_data_department['Department'];
		echo "</td>";

		echo "<td>";
		if ($result_data['Admin_User'] == 'Administrator') {
			$rol_rec = "Admin.";
		} else if ($result_data['Admin_User'] == 'Super Administrator') {
			$rol_rec = "Super.";
		} else {
			$rol_rec = "Employ.";
		}
		echo $rol_rec;
		echo "</td>";

		echo "<td>";
		echo $result_data['Plant_Head'];
		echo "</td>";

		echo "<td>";
		echo $result_data['Department_Head'];
		echo "</td>";

		echo "<td>";
		echo $result_data['Management_Representative'];
		echo "</td>";

		echo "<td>";
		echo $result_data['Customer_Compliants_Representatives'];
		echo "</td>";

		echo "<td>";
		echo date("d-m-y", strtotime($result_data['Created']));
		echo "</td>";

		echo "<td>";
		echo date("d-m-y", strtotime($result_data['Modified']));
		echo "</td>";


		if ($result_data['Status'] == 'Active') {
			echo '<td><a href="/includes/basicsettings_user_status.php?pg_id=' . $result_data['Id_employee'] . '"><div class="status-active">Active</div></a></td>';
		} else {
			echo '<td><a href="/includes/basicsettings_user_status.php?pg_id=' . $result_data['Id_employee'] . '"><div class="status-danger">Susp.</div></a></td>';
		}

		echo '<td class="text-end"><a href="/admin_user-edit.php?pg_id=' . $result_data['Id_employee'] . '"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>';
		echo '<a href="/admin_user-delete.php?pg_id=' . $result_data['Id_employee'] . '"><i class="bi bi-trash" style="padding-right: 4px;"></i></a></td>';

		echo "

						</tr>
				</tbody>
			";
	}
	echo "</table>
		</div>
		</div>";
}
