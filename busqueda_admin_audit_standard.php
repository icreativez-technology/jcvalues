<?php
include('includes/functions.php');
$consulta =  "SELECT * FROM admin_audit_standard WHERE is_deleted = 0 order by id DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT * FROM admin_audit_standard WHERE is_deleted = 0 AND (audit_type LIKE '%" . $termino . "%' OR audit_standard LIKE '%" . $termino . "%' OR status LIKE '%" . $termino . "%' OR updated_at LIKE '%" . $termino . "%' OR created_at LIKE '%" . $termino . "%') order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '<div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-100px">Audit Type</th>
				<th class="min-w-100px">Audit Standard</th>
				<th class="min-w-100px">Created</th>
				<th class="min-w-100px">Modified</th>
				<th class="min-w-100px">Status</th>
				<th class="text-end min-w-100px">Actions</th>
            </tr>
        </thead><tbody class="fw-bold text-gray-600">';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tr><td>";
		echo $result_data['audit_type'];
		echo "</td><td>";
		echo $result_data['audit_standard'];
		echo "</td><td>";
		echo date("d-m-y", strtotime($result_data['created_at']));
		echo "</td><td>";
		echo $result_data['updated_at'] != null ? date("d-m-y", strtotime($result_data['updated_at'])) : '';
		echo "</td>";
		$class = ($result_data['status'] == "Active") ? "status-active" : "status-danger";
		echo '<td><a href="/includes/admin_audit_standard_status.php?id=' . $result_data['id'] . '"><div class="' . $class . '">' . $result_data['status'] . '</div></a></td>';
		echo '<td class="text-end"><a href="/admin_audit_standard_edit.php?id=' . $result_data['id'] . '" class="me-2"><i class="bi bi-pencil"></i></a></td>';
		echo "</tr>";
	}
	echo "</tbody></table></div>";
}
