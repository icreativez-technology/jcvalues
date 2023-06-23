<?php
require_once "includes/functions.php";
$consulta = " SELECT * FROM end_connections LIMIT 0";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta = "SELECT * FROM end_connections WHERE deleted_at IS NULL AND end_connection LIKE '%" . $termino . "%'";
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
												<th class="min-w-125px">End Connection</th>
												<th class="min-w-125px">Created</th>
												<th class="min-w-125px">Modified</th>
												<th class="min-w-125px">Status</th>
												<th class="text-end min-w-70px">Action</th>
											</tr>
											<!--end::Table row-->
										</thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
		echo $result_data['end_connection'];
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
			echo '<td><a href="/includes/end-connection-status.php?id=' . $result_data['id'] . '"><div class="status-active">Active</div></a></td>';
		} else {
			echo '<td><a href="/includes/end-connection-status.php?id=' . $result_data['id'] . '"><div class="status-danger">Suspended</div></a></td>';
		}
		echo '<td class="text-end"><a href="/end-connection-edit.php?id=' . $result_data['id'] . '" class="me-2"><i class="bi bi-pencil"></i></a>
		<a href="/includes/end-connection-delete.php?id=' . $result_data['id'] . '"><i class="bi bi-trash"></i></a>';
		echo "
						</tr>
				</tbody>
			";
	}
	echo "</table>
		</div>
		</div>";
}
