<?php

require_once "includes/functions.php";

$consulta = " SELECT * FROM Basic_Product_Group LIMIT 0";
$termino = "";

if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta = "SELECT * FROM Basic_Department WHERE Department LIKE '%" . $termino . "%' OR Status LIKE '%" . $termino . "%'";
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
												<th class="min-w-125px">Name</th>
												<th class="min-w-125px">Plant</th>
												<th class="min-w-125px">Product Group</th>
												<th class="min-w-125px">Status</th>
												<th class="text-end min-w-70px">Actions</th>
												
											</tr>
											<!--end::Table row-->
										</thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
		echo $result_data['Department'];
		echo "	</td>
							<td>";
		/*Select Plants Name*/
		$sql_data_plants = "SELECT Id_plant, Title FROM Basic_Plant WHERE Id_plant LIKE '$result_data[Id_plant]'";
		$connect_data_plants = mysqli_query($con, $sql_data_plants);
		$result_data_plants = mysqli_fetch_assoc($connect_data_plants);

		echo $result_data_plants['Title'];
		echo "	</td>
							<td>";
		/*Select PG Name*/
		$sql_data_pg = "SELECT Id_product_group, Title FROM Basic_Product_Group WHERE Id_product_group LIKE '$result_data[Id_product_group]'";
		$connect_data_pg = mysqli_query($con, $sql_data_pg);
		$result_data_pg = mysqli_fetch_assoc($connect_data_pg);

		echo $result_data_pg['Title'];
		echo " 	</td>";
		if ($result_data['Status'] == 'Active') {
			echo '<td><a href="/includes/basicsettings_department_status.php?pg_id=' . $result_data['Id_department'] . '"><div class="status-active">Active</div></a></td>';
		} else {
			echo '<td><a href="/includes/basicsettings_department_status.php?pg_id=' . $result_data['Id_department'] . '"><div class="status-danger">Suspended</div></a></td>';
		}

		echo '<td class="text-end"><a href="/admin_department-edit.php?pg_id=' . $result_data['Id_department'] . '"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a> ';
		echo '<a href="/admin_department-delete.php?pg_id=' . $result_data['Id_department'] . '"><i class="bi bi-trash" style="padding-right: 4px;"></i></a></td>';

		echo "

						</tr>
				</tbody>
			";
	}
	echo "</table>
		</div>
		</div>";
}
