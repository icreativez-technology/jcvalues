<?php
session_start();
require_once "includes/functions.php";
$email = $_SESSION['usuario'];
$sql = "SELECT Id_basic_role From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$roleInfo = mysqli_fetch_assoc($fetch);
$role = $roleInfo['Id_basic_role'];
$consulta = " SELECT * FROM material_specifications WHERE is_deleted = 0 order by id desc";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta = "SELECT * FROM material_specifications WHERE is_deleted = 0 AND (material_specification LIKE '%" . $termino . "%' OR nom_comp LIKE '%" . $termino . "%' OR created_at LIKE '%" . $termino . "%' OR updated_at LIKE '%" . $termino . "%') order by id desc";
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
											<tr class="text-start text-gray-400 text-uppercase gs-0">
												<th class="min-w-250px">Material Specification</th>
												<th class="min-w-250px">Edition</th>
												<th class="min-w-50px">Created</th>
												<th class="min-w-50px">Modified</th>
												<th class="min-w-50px">Status</th>
												<th class="text-end min-w-50px">Action</th>
											</tr>
											<!--end::Table row-->
										</thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
		echo $result_data['material_specification'];
		echo "	</td>
							<td>";
		echo $result_data['nom_comp'];
		echo "	</td>
							<td>";
		echo date("d-m-y", strtotime($result_data['created_at']));
		echo "	</td>
							<td>";
		if ($result_data['updated_at'] != null) {
			echo date("d-m-y", strtotime($result_data['updated_at']));
		} else {
			echo '';
		}
		echo " 	</td>";
		if ($result_data['status'] == '1') {
			echo '<td><a href="/includes/material-specification-status.php?id=' . $result_data['id'] . '"><div class="status-active">Active</div></a></td>';
		} else {
			echo '<td><a href="/includes/material-specification-status.php?id=' . $result_data['id'] . '"><div class="status-danger">Suspended</div></a></td>';
		}
		echo '<td class="text-end"><a href="/material-specification-edit.php?id=' . $result_data['id'] . '&view" class="me-3"><i class="fa fa-eye"></i></a>';
		if ($result_data['is_editable'] == 1) {
			echo '<a href="/material-specification-edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil"></i></a>';
		}
		if ($role == 1) {
			echo '<a href="includes/material-specification-delete.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-trash" aria-hidden="true"></i></a>';
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
