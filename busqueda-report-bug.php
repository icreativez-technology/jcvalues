<?php
session_start();
require_once "includes/functions.php";
$email = $_SESSION['usuario'];
$sql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$userInfo = mysqli_fetch_assoc($fetch);
$role = $userInfo['Id_basic_role'];
$consulta = " SELECT * FROM report_bug LIMIT 0";
$termino = "";
if (isset($_POST['productos'])) {
    $termino = mysqli_real_escape_string($con, $_POST['productos']);
    $consulta = "SELECT * FROM report_bug WHERE is_deleted = 0 AND issue_number LIKE '%" . $termino . "%'";
}
$resultData = mysqli_query($con, $consulta);
if ($resultData && strlen($termino) > 0) {
    echo '
    <div class="card-body pt-0 table-responsive">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <!--begin::Table head-->
        <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 text-uppercase gs-0">
                <th class="min-w-135px">Issue Number</th>
                <th class="min-w-140px">Issue Description</th>
                <th class="min-w-100px">Type</th>
                <th class="min-w-135px">Priority</th>
                <th class="min-w-140px">Created Date</th>';
    if ($role == 1) {
        echo '<th class="min-w-140px">Created By</th>';
    }
    echo '<th class="min-w-140px">Updated Date</th>';
    if ($role == 1) {
        echo '<th class="min-w-140px">Status</th>';
    }
    echo '<th class="min-w-140px">Action</th>
            </tr>
            <!--end::Table row-->
        </thead>';
    while ($result_data = mysqli_fetch_assoc($resultData)) {
        echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
        echo $result_data['issue_number'];
        echo "	</td>
							<td>";
        echo $result_data['issue_description'];
        echo "	</td>
							<td>";
        if ($result_data['issue_type'] == 1) {
            echo "UI";
        } else if ($result_data['issue_type'] == 2) {
            echo "Functionality";
        } else if ($result_data['issue_type'] == 3) {
            echo "Hotfix";
        }
        echo " 	</td> <td>";
        if ($result_data['priority'] == 1) {
            echo "High";
        } else if ($result_data['priority'] == 2) {
            echo "Medium";
        } else if ($result_data['priority'] == 3) {
            echo "Low";
        }
        echo "</td> <td>";
        echo date("d-m-y", strtotime($result_data['created_at']));
        echo "</td>";
        if ($role == 1) {
            echo "<td>";
            echo $userInfo['First_Name'] . $userInfo['Last_Name'];
            echo "</td>";
        }
        echo "<td>";
        echo $result_data['updated_at'] != null ? date("d-m-y", strtotime($result_data['updated_at'])) : '';
        echo "</td>";
        if ($role == 1) {
            if ($result_data['status'] == "Open") {
                echo '<td><a href="/includes/report_bug_status.php?id=' . $result_data['id'] . '"><div class="status-danger">' . $result_data['status'] . '</div></a></td>';
            } else {
                echo '<td><div class="status-active">' . $result_data['status'] . '</div></td>';
            }
        }
        echo "<td><a href='report-bug-edit.php?id=$result_data[id]'><i
        class='bi bi-pencil' aria-hidden='true'></i></a>";
        echo "</td></tr></tbody>";
    }
    echo "</table>
		</div>";
}
