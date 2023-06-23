<?php
session_start();
include('includes/functions.php');

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 13 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];

$consulta =  "SELECT supplier_nc_capa_ncr_details.*, Basic_Supplier.Supplier_Name, Basic_Supplier.Country_of_Origin FROM supplier_nc_capa_ncr_details 
LEFT JOIN Basic_Supplier ON supplier_nc_capa_ncr_details.supplier_id = Basic_Supplier.Id_Supplier
WHERE supplier_nc_capa_ncr_details.is_deleted = 0 order by id DESC";
$termino = "";
if (isset($_POST['productos'])) {
    $termino = mysqli_real_escape_string($con, $_POST['productos']);
    $consulta =  "SELECT supplier_nc_capa_ncr_details.*, Basic_Supplier.Supplier_Name, Basic_Supplier.Country_of_Origin FROM supplier_nc_capa_ncr_details 
    LEFT JOIN Basic_Supplier ON supplier_nc_capa_ncr_details.supplier_id = Basic_Supplier.Id_Supplier
    WHERE supplier_nc_capa_ncr_details.is_deleted = 0
	AND Basic_Supplier.Supplier_Name LIKE '%" . $termino . "%' OR Basic_Supplier.Country_of_Origin LIKE '%" . $termino . "%' OR supplier_nc_capa_ncr_details.status LIKE '%" . $termino . "%' OR supplier_nc_capa_id LIKE '%" . $termino . "%' OR ncr_classification LIKE '%" . $termino . "%' OR qty_nc LIKE '%" . $termino . "%' order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
    echo "<div class='card-body pt-0 table-responsive'>
    <table class='table align-middle table-row-dashed fs-6 gy-5 gx-5'
        id='kt_department_table' data-cols-width='20,10,10, 20, 20, 20, 20'>
        <thead>
            <tr class='text-start text-gray-400 text-uppercase gs-0' data-height='30'>
                <th class='min-w-135px'>Id</th>
                <th class='min-w-70px'>Supplier Name</th>
                <th class='min-w-100px'>Origin</th>
                <th class='min-w-100px'>NCR Classification</th>
                <th class='min-w-100px'>QTY NC'S</th>
                <th class='min-w-140px'>Status</th>
                <th class='min-w-100px'>Action</th>
            </tr>
        </thead>";
    while ($result_data = mysqli_fetch_assoc($consultaBD)) {
        echo "<tbody class='fw-bold text-gray-600'><tr>";
        echo "<td>";
        echo $result_data['supplier_nc_capa_id'];
        echo "</td><td>";
        echo $result_data['Supplier_Name'];
        echo "</td><td>";
        echo $result_data['Country_of_Origin'];
        echo "</td><td>";
        echo $result_data['ncr_classification'];
        echo "</td><td>";
        echo $result_data['qty_nc'];
        echo "</td>";
        $class = ($result_data['status'] == "Open") ? "status-danger" : "status-active";
        echo '<td><div class="' . $class . '">' . $result_data['status'] . '</div></td>';
        echo "<td>";
        if ($canView == 1) {
            echo '<a href="/supplier_nc_capa_edit.php?id=' . $result_data['id'] . '&view" class="me-3"><i class="bi bi-eye text-primary" aria-hidden="true"></i></a>';
        }
        if ($result_data['status'] == "Open") {
            if ($canEdit == 1) {
                echo '<a href="/supplier_nc_capa_edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
            }
        } else {
            if ($canView == 1) {
                echo ' <a data-id="' . $result_data['id'] . '" data-unique="' . $result_data['supplier_nc_capa_id'] . '" target="_blank" class="me-3 print-pdf cursor-pointer"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
            }
        }
        if ($role == 1 || $canDelete == 1) {
            echo '<a href="/includes/supplier_nc_capa_delete.php?id=' . $result_data['id'] . '"><i class="bi bi-trash" aria-hidden="true"></i></a>';
        }
        echo "</td>";
    }
    echo "</tr></tbody></table></div>";
}
