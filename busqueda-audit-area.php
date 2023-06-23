<?php
require_once "includes/functions.php";
$consulta = " SELECT * FROM audit_area LIMIT 0";
$termino = "";
if (isset($_POST['productos'])) {
    $termino = mysqli_real_escape_string($con, $_POST['productos']);
    $consulta = "SELECT * FROM audit_area WHERE is_deleted = 0 AND Title LIKE '%" . $termino . "%'";
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
                <th class="min-w-125px">Title</th>
                <th class="min-w-125px">Created</th>
                <th class="min-w-125px">Modified</th>
                <th class="min-w-125px">Status</th>
                <th class="min-w-70px">Action</th>
            </tr>
            <!--end::Table row-->
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody class="fw-bold text-gray-600">';
    while ($result_data = mysqli_fetch_assoc($consultaBD)) {
        echo '<tr>
        <td>';
        echo $result_data['Title'];
        echo '</td>
        <td>';
        echo date("d-m-y", strtotime($result_data['created_at']));
        echo '</td>
        <td>';
        echo $result_data['updated_at'] != null ? date("d-m-y", strtotime($result_data['updated_at'])) : '';
        echo '</td>';
        if ($result_data['status'] == "1") {
            echo '<td>
            <a>
                <div class="status-active">Active</div>
            </a>
        </td>';
        } else {
            echo '<td>
            <a>
                <div class="status-danger">Suspended</div>
            </a>
        </td>';
        }
        echo '<td>
            <a href="/admin_audit-area-edit.php?id=' . $result_data['Id_audit_area'] . '"
                class="me-2"><i class="bi bi-pencil"></i></a>';

        echo '<a
                href="/includes/basicsettings_audit-area_delete.php?id=' . $result_data['Id_audit_area'] . '"><i
                    class="bi bi-trash"></i></a>
        </td>
    </tr>';
    }
    echo "</tbody></table>
		</div>
		";
}
