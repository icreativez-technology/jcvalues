<?php
session_start();
require_once "includes/functions.php";
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];

$consulta = "SELECT supplier_certificates.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, material_specifications.material_specification , classes.class, sizes.size FROM supplier_certificates LEFT JOIN material_specifications ON supplier_certificates.material_specification_id = material_specifications.id LEFT JOIN Basic_Employee ON supplier_certificates.created_by = Basic_Employee.Id_employee  LEFT JOIN classes on supplier_certificates.class_id = classes.id LEFT JOIN sizes on supplier_certificates.size_id = sizes.id WHERE supplier_certificates.is_deleted = 0 order by created_at DESC";
$termino = "";
if (isset($_POST['productos'])) {

    $termino = mysqli_real_escape_string($con, $_POST['productos']);
    $consulta = "SELECT supplier_certificates.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, material_specifications.material_specification, classes.class, sizes.size FROM supplier_certificates LEFT JOIN material_specifications ON supplier_certificates.material_specification_id = material_specifications.id LEFT JOIN Basic_Employee ON supplier_certificates.created_by = Basic_Employee.Id_employee  LEFT JOIN classes on supplier_certificates.class_id = classes.id LEFT JOIN sizes on supplier_certificates.size_id = sizes.id WHERE supplier_certificates.is_deleted = 0 AND heat_number LIKE '%" . $termino . "%' OR material_certificate_number LIKE '%" . $termino . "%' OR po_number LIKE '%" . $termino . "%' OR item_code LIKE '%" . $termino . "%' OR material_specification LIKE '%" . $termino . "%' OR heat_number LIKE '%" . $termino . "%' OR class LIKE '%" . $termino . "%'  order by created_at DESC";
}
 $consultaBD = mysqli_query($con, $consulta);

if(isset($_POST['po_search'])){
    $poNumber = mysqli_real_escape_string($con, $_POST['po_search']);
    $keys = array_keys(array_column($consultaBD, 'supplier_certificates.po_number'), $poNumber);
    $consultaBD = array_map(function($k) use ($consultaBD){return $consultaBD[$k];}, $keys);
}

if(isset($_POST['mtc_search'])){
    $mtcNumber = mysqli_real_escape_string($con, $_POST['mtc_search']);
    $keys = array_keys(array_column($consultaBD, 'supplier_certificates.material_certificate_number'), $mtcNumber);
    $consultaBD = array_map(function($k) use ($consultaBD){return $consultaBD[$k];}, $keys);
     echo 'welcome';
}

if(isset($_POST['item_search'])){
    $itemNumber = mysqli_real_escape_string($con, $_POST['item_search']);
    $keys = array_keys(array_column($consultaBD, 'supplier_certificates.item_code'), $itemNumber);
    $consultaBD = array_map(function($k) use ($consultaBD){return $consultaBD[$k];}, $keys);
    print_r($consultaBD);
}

if(isset($_POST['mat_search'])){
    $matNumber = mysqli_real_escape_string($con, $_POST['mat_search']);
    $keys = array_keys(array_column($consultaBD, 'supplier_certificates.material_specification'), $matNumber);
    $consultaBD = array_map(function($k) use ($consultaBD){return $consultaBD[$k];}, $keys);
}

if(isset($_POST['heat_search'])){
    $heatNumber = mysqli_real_escape_string($con, $_POST['heat_search']);
    $keys = array_keys(array_column($consultaBD, 'supplier_certificates.heat_number'), $heatNumber);
    $consultaBD = array_map(function($k) use ($consultaBD){return $consultaBD[$k];}, $keys);
}

if(isset($_POST['class_search'])){
    $classNumber = mysqli_real_escape_string($con, $_POST['class_search']);
    $keys = array_keys(array_column($consultaBD, 'supplier_certificates.class'), $classNumber);
    $consultaBD = array_map(function($k) use ($consultaBD){return $consultaBD[$k];}, $keys);
}
// $consultaBD = mysqli_query($con, $consulta);

if ($consultaBD && strlen($termino) > 0) {
    echo '
    <div class="card-body pt-0 table-responsive">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <!--begin::Table head-->
        <thead>
            <!--begin::Table row-->

            <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                <th class="min-w-100px">PO No.</th>
                <th class="min-w-125px">MTC No.</th>
                <th class="min-w-120px">MTC Version</th>
                <th class="min-w-125px">Item Code</th>
                <th class="min-w-125px">Material Spec</th>
                <th class="min-w-100px">Heat No.</th>
                <th class="min-w-75px">Size</th>
                <th class="min-w-50px">Class</th>
                <th class="min-w-150px">Created By</th>
                <th class="min-w-100px">Created</th>
                <th class="min-w-125px">Action</th>
            </tr>
            <!--end::Table row-->
        </thead>
         ';

    while ($result_data = mysqli_fetch_assoc($consultaBD)) {
        echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
        echo $result_data['po_number'];
        echo "	</td>
							<td>";
        echo $result_data['material_certificate_number'];
        echo "</td> <td>";
        echo "Ver : " . $result_data['mtc_revision'];
        echo "</td> <td>";
        echo $result_data['item_code'];
        echo "</td> <td>";
        echo $result_data['material_specification'];
        echo "</td> <td>";
        echo $result_data['heat_number'];
        echo "</td> <td>";
        echo $result_data['size'];
        echo "</td> <td>";
        echo $result_data['class'];
        echo "</td> <td>";
        echo $result_data['First_Name'];
        echo $result_data['Last_Name'];
        echo "</td> <td>";
        echo date("d-m-y", strtotime($result_data['created_at']));
        echo "</td><td>";
        if ($result_data['is_editable']) {
            echo '<a href="/supplier-certificate-edit.php?id=' . $result_data['id'] . '" class="set-url"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
        } else {
            echo '<a href="supplier-certificate-view.php?id=' . $result_data['id'] . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
        }
        echo '<a class="copy_row ms-2 me-2 copy-text" style="cursor: pointer" data-value="' . $result_data['id'] . '" data-toggle="tooltip" data-placement="top" title="Copy"><i class="fa fa-copy" aria-hidden="true"></i></a>';
        if ($result_data['is_editable']) {
            if ($result_data['certificate_type_id'] === "1") {
                $original_data = "SELECT * FROM original_certificates WHERE supplier_certificate_id = '$result_data[id]' AND is_deleted = 0";
                $original_connect = mysqli_query($con, $original_data);
                $original_result = mysqli_fetch_assoc($original_connect);
                echo '<a class="mtc-download cursor-pointer me-2" href="'. $original_result['file_path'].'" download="'.$original_result['file_path'].'"><i class="fa fa-download" aria-hidden="true"></i></a>';
            } else if ($result_data['certificate_type_id'] === "2") {
                echo '<a class="print-mtc cursor-pointer me-2" data-id="'. $result_data['id'].'" data-value="'.$result_data['material_certificate_number'].'"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
            }
        }
        if ($role == 1) {
            echo '<a href="/includes/supplier_mtc_delete.php?id=' . $result_data['id'] . '" class="set-url"><i class="bi bi-trash" aria-hidden="true"></i></a>';
        }
        echo '</td>';
       
        echo "
						</tr>
				</tbody>
			";
    }
    echo "</table>
		</div>
		</div>";
}
