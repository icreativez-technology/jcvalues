<?php

require_once "includes/functions.php";

$consulta = " SELECT * FROM Basic_Product_Group LIMIT 0";
$termino = "";

if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta = "SELECT * FROM Basic_Product_Group WHERE Title LIKE '%" . $termino . "%' OR Status LIKE '%" . $termino . "%'";
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
												<th class="min-w-125px">Title</th>
												<th class="min-w-125px">Created</th>
												<th class="min-w-125px">Modified</th>
												<th class="min-w-125px">Status</th>
												<th class="text-end min-w-70px">Actions</th>
												
											</tr>
											<!--end::Table row-->
										</thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
		echo $result_data['Title'];
		echo "	</td>
							<td>";
		echo date("d-m-y", strtotime($result_data['Created']));
		echo "	</td>
							<td>";
		echo date("d-m-y", strtotime($result_data['Modified']));
		echo " 	</td>";
		if ($result_data['Status'] == 'Active') {
			echo '<td><a href="/includes/basicsettings_productgroup_status.php?pg_id=' . $result_data['Id_product_group'] . '"><div class="status-active">Active</div></a></td>';
		} else {
			echo '<td><a href="/includes/basicsettings_productgroup_status.php?pg_id=' . $result_data['Id_product_group'] . '"><div class="status-danger">Suspended</div></a></td>';
		}

		echo '<td class="text-end"><a href="/admin_productgroup-edit.php?pg_id=' . $result_data['Id_product_group'] . '"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>';
		echo '<a href="/admin_productgroup-delete.php?pg_id=' . $result_data['Id_product_group'] . '"><i class="bi bi-trash" style="padding-right: 4px;"></i></a></td>';

		echo "

						</tr>
				</tbody>
			";
	}
	echo "</table>
		</div>
		</div>";
}
