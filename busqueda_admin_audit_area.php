<?php
include('includes/functions.php');
$consulta =  "SELECT * FROM admin_audit_area WHERE is_deleted = 0 order by id DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT admin_audit_area.*, Basic_Department.Department, admin_audit_standard.audit_standard FROM admin_audit_area 
	LEFT JOIN Basic_Department ON admin_audit_area.department_id = Basic_Department.Id_department
	LEFT JOIN admin_audit_standard ON admin_audit_area.audit_standard_id = admin_audit_standard.id
	WHERE admin_audit_area.is_deleted = 0 AND (audit_area LIKE '%" . $termino . "%' OR admin_audit_standard.audit_standard LIKE '%" . $termino . "%' OR admin_audit_area.status LIKE '%" . $termino . "%' OR audit_check_list_format_no LIKE '%" . $termino . "%' OR revision_no LIKE '%" . $termino . "%' OR Basic_Department.Department LIKE '%" . $termino . "%' OR admin_audit_area.updated_at LIKE '%" . $termino . "%' OR admin_audit_area.created_at LIKE '%" . $termino . "%') order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '<div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-100px">Audit Area</th>
				<th class="min-w-100px">Audit Standard</th>
				<th class="min-w-100px">Audit Checklist Format No</th>
				<th class="min-w-100px">Revision No</th>
				<th class="min-w-100px">Department</th>
				<th class="min-w-50px">Created</th>
                <th class="min-w-50px">Modified</th>
				<th class="min-w-50px">Status</th>
				<th class="text-end min-w-50px">Actions</th>
            </tr>
        </thead><tbody class="fw-bold text-gray-600">';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tr><td>";
		echo $result_data['audit_area'];
		echo "</td><td>";
		echo $result_data['audit_standard'];
		echo "</td><td>";
		echo $result_data['audit_check_list_format_no'];
		echo "</td><td>";
		echo $result_data['revision_no'];
		echo "</td><td>";
		echo $result_data['Department'];
		echo "</td><td>";
		echo date("d-m-y", strtotime($result_data['created_at']));
		echo "</td><td>";
		echo $result_data['updated_at'] != null ? date("d-m-y", strtotime($result_data['updated_at'])) : '';
		echo "</td>";
		$class = ($result_data['status'] == "Active") ? "status-active" : "status-danger";
		echo '<td><a href="/includes/audit_area_status_update.php?pg_id=' . $result_data['id'] . '"><div class="' . $class . '">' . $result_data['status'] . '</div></a></td>';
		echo '<td class="text-end"><a href="/admin_audit_area_edit.php?id=' . $result_data['id'] . '" class="me-2"><i class="bi bi-pencil"></i></a></td>';
		echo "</tr>";
	}
	echo "</tbody></table></div>";
}
