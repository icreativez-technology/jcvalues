<?php
session_start();
require_once "includes/functions.php";
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 8 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$consulta = "SELECT * FROM tasks WHERE is_deleted = 0 order by id DESC";
$termino = "";

if (isset($_POST['productos'])) {
    $role = $_POST['role'];
    $empId = $_POST['empId'];
    $termino = mysqli_real_escape_string($con, $_POST['productos']);
    if ($role == '1') {
        $consulta = "SELECT * FROM tasks WHERE is_deleted = 0 AND (task_id LIKE '%" . $termino . "%' OR title LIKE '%" . $termino . "%' OR status LIKE '%" . $termino . "%' OR priority LIKE '%" . $termino . "%' OR project LIKE '%" . $termino . "%' OR updated_at LIKE '%" . $termino . "%') order by id DESC";
    } else {
        $consulta = "SELECT tasks.* FROM tasks LEFT JOIN sub_tasks ON sub_tasks.task_id = tasks.id WHERE tasks.is_deleted = 0  AND tasks.assigned_to = '$empId'OR tasks.created_by = '$empId' OR sub_tasks.responsible = '$empId' AND (tasks.task_id LIKE '%" . $termino . "%' OR tasks.title LIKE '%" . $termino . "%' OR tasks.status LIKE '%" . $termino . "%' OR tasks.priority LIKE '%" . $termino . "%' OR project LIKE '%" . $termino . "%' OR tasks.updated_at LIKE '%" . $termino . "%') GROUP BY sub_tasks.task_id order by id DESC ";
    }
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
    echo '
    <div class="card-body pt-0 table-responsive">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <!--begin::Table head-->
        <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 text-uppercase gs-0">
                <th class="min-w-300px">Title</th>
                <th class="min-w-100px">ID</th>
                <th class="min-w-100px">Status</th>
                <th class="min-w-100px">Priority</th>
                <th class="min-w-200px">Project</th>
                <th class="min-w-100px">Progress</th>
                <th class="min-w-100px">Date</th>
                <th class="min-w-50px">Action</th>
            </tr>
            <!--end::Table row-->
        </thead>';
    while ($result_data = mysqli_fetch_assoc($consultaBD)) {
        echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
        echo $result_data['title'];
        echo "	</td>
							<td>";
        echo $result_data['task_id'];
        echo "</td> <td>";
        switch ($result_data['status']) {
            case 'Not Started':
                $color = 'status-warning';
                break;
            case 'In Progress':
                $color = 'status-primary';
                break;
            case 'In Review':
                $color = 'status-info';
                break;
            case 'Completed':
                $color = 'status-active';
                break;
            case 'Cancelled':
                $color = 'status-danger';
                break;
        }
        echo '<span class="' . $color . '">' . $result_data['status'] . '</span>';
        echo "</td><td>";
        switch ($result_data['priority']) {
            case 'Low':
                $cl = 'status-active';
                break;
            case 'Medium':
                $cl = 'status-primary';
                break;
            case 'High':
                $cl = 'status-warning';
                break;
            case 'Critical':
                $cl = 'status-danger';
                break;
        }
        echo '<div class="' . $cl . '">' . $result_data['priority'] . '</div>';
        echo "</td> <td>";
        echo $result_data['project'];
        echo "</td> <td>";
        switch ($result_data['status']) {
            case 'Not Started':
            case 'Cancelled':
                $per = "20%";
                $tex = "0%";
                $col = 'bg-danger';
                break;
            case 'In Progress':
                $per = "35%";
                $tex = "25%";
                $col = 'bg-info';
                break;
            case 'In Review':
                $per = $tex = "50%";
                $col = 'bg-warning';
                break;
            case 'Completed':
                $per = $tex = "100%";
                $col = 'bg-success';
                break;
        }
        echo '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated ' . $col . '" role="progressbar" aria-valuenow="' . $per . '" aria-valuemin="0" aria-valuemax="100" style="width:' . $per . '">' . $tex . '</div></div>';
        echo "</td> <td>";
        echo date("d-m-y", strtotime($result_data['updated_at']));
        echo "</td>";
        echo '<td>';
        if ($canView == 1) {
            echo '<a data-id="' . $result_data['id'] . '" data-mode="view" data-unique="' . $result_data['task_id'] . '" class="me-2 edit-task cursor-pointer"><i class="fa fa-eye"></i></a>';
        }
        if ($result_data['status'] != "Completed") {
            if ($canEdit == 1) {
                echo '<a data-id="' . $result_data['id'] . '" data-mode="edit" data-unique="' . $result_data['task_id'] . '" class="me-2 edit-task cursor-pointer"><i class="bi bi-pencil"></i></a>';
            }
        }
        if ($role == 1 || $canDelete == 1) {
            echo '<a href="/includes/task-delete.php?id=' . $result_data['id'] . '" class="me-2"><i class="bi bi-trash" aria-hidden="true"></i></a>';
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
