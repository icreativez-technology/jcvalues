<?php
session_start();
require_once "includes/functions.php";

$email = $_SESSION['usuario'];
$roleSql = "SELECT Id_basic_role, Basic_Employee.Department_Head From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$department_head = $roleInfo['Department_Head'];

$consulta = "SELECT * FROM Document LIMIT 0";
$termino = "";



if (isset($_POST['productos']) && isset($_POST['name'])) {
    $fileName = $_POST['name'];
    $formatNo = $_POST['productos'];
    $lang = $_POST['lang'];

    $sql_datos_document = null;
    if ($lang != "" && $lang != null) {
        $sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks , Category , language FROM Document WHERE Category = '$fileName' AND language = '$lang' AND Format_No LIKE '%" . $formatNo . "%'";
    } else {
        $sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks , Category , language FROM Document WHERE Category = '$fileName' AND Format_No LIKE '%" . $formatNo . "%'";
    }
    $conect_datos_document = mysqli_query($con, $sql_datos_document);
    if ($conect_datos_document->num_rows > 0 && strlen($formatNo) > 0) {
        echo '
    <div class="row mb-4 mt-4">

    <div class="d-flex flex-stack mb-4">
    <!--begin::Folder path-->
    <div class="badge badge-lg badge-light-primary">
        <div class="d-flex align-items-center flex-wrap">
            <span><a href="/documentation.php">Document Managment System</a></span>
            <span class="ms-3 me-3">»</span>
            <span>' . $fileName . '</span>
        </div>
    </div>
</div>

    <!--begin::Item-->
    <div class="col-md-12 d-flex align-items-center mb-n1">
        <!--begin::Bullet-->
        <!--<span class="bullet me-3"></span>-->
        <!--end::Bullet-->
        <!--begin::Label-->
        <!--begin::Table-->
        <!--<table id="kt_file_manager_list" data-kt-filemanager-table="folders" class="table align-middle table-row-dashed fs-6 gy-5 gx-5">-->
        <!-- NOTA: ESTA ID Y DATA HACE LA FUNCIONALIDAD DEL BUSCADOR -->
        <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold text-uppercase gs-0">

                    <th class="min-w-125px hidde-responsive-j6">
                        Document No
                    </th>
                    <th class="min-w-125px hidde-responsive-j6">
                        Rev No</th>
                    <th class="hidde-responsive-j6">
                        Prepared by
                    </th>
                    <th class="hidde-responsive-j6">
                        Date Prep.
                    </th>
                    <th class="hidde-responsive-j6">
                        Review by
                    </th>
                    <th class="hidde-responsive-j6">
                        Date Rev.
                    </th>
                    <th class="hidde-responsive-j6">
                        Approved by
                    </th>
                    <th class="min-w-125px hidde-responsive-j6">
                        Date App.
                    </th>
                    <th class="min-w-125px hidde-responsive-j6">
                   Language
                </th>
                    <th class="min-w-125px hidde-responsive-j6">
                        Actions
                    </th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-bold text-gray-600">';
        while ($result_datos_document = mysqli_fetch_assoc($conect_datos_document)) {
            echo '<td class="hidde-responsive-j6"><a
            href="../document-manager/' . $fileName . '/' . $result_datos_document['File'] . '" style="text-decoration:underline">' . $result_datos_document['Format_No'] . '</a>
            </td>

            <td class="hidde-responsive-j6">
                ' . $result_datos_document['Rev_No'] . '
            </td>
            <td class="hidde-responsive-j6">';

            $id_prepared_by = $result_datos_document['Prepared_by'];
            $consulta_prepared_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_prepared_by";
            $consulta_general_prepared_by = mysqli_query($con, $consulta_prepared_by);
            $result_prepared_by = mysqli_fetch_assoc($consulta_general_prepared_by);
            echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name'];

            echo '</td>
            <td class="hidde-responsive-j6">
                ' . date("d-m-y", strtotime($result_datos_document['Date_of_preparation'])) . '
            </td>
            <td class="hidde-responsive-j6">';


            $id_reviewd_by = $result_datos_document['Reviewd_by'];
            $consulta_reviewd_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_reviewd_by";
            $consulta_general_reviewd_by = mysqli_query($con, $consulta_reviewd_by);
            $result_reviewd_by = mysqli_fetch_assoc($consulta_general_reviewd_by);
            echo  $result_reviewd_by['First_Name'] . ' ' . $result_reviewd_by['Last_Name'];

            echo ' </td>
            <td class="hidde-responsive-j6">
                ' . date("d-m-y", strtotime($result_datos_document['Date_of_revision'])) . '
            </td>
            <td class="hidde-responsive-j6">';

            $id_approved_by = $result_datos_document['Approved_by'];
            $consulta_approved_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_approved_by";
            $consulta_general_approved_by = mysqli_query($con, $consulta_approved_by);
            $result_approved_by = mysqli_fetch_assoc($consulta_general_approved_by);

            echo  $result_approved_by['First_Name'] . ' ' . $result_approved_by['Last_Name'];

            echo '</td>
            <td class="hidde-responsive-j6">
            ' . date("d-m-y", strtotime($result_datos_document['Date_of_approval'])) . '
            </td>';
            echo ' <td class="hidde-responsive-j6">';
            if ($result_datos_document['language'] == '0') {
                echo "English";
            } else if ($result_datos_document['language'] == '1') {
                echo "Spanish";
            }

            echo '</td>';
            echo '<td>
                <a
                    href="/documentation_view_file.php?' . $result_datos_document['File'] . '"><i
                        class="bi bi-eye-fill"
                        style="padding-right: 4px;"></i></a>
                <a
                    href="/documentation_edit_file.php?name=' .  $result_datos_document['File'] . '"><i
                        class="bi bi-pencil"
                        style="padding-right: 4px;"></i></a>';
            if ($role  == 1 || strval($department_head) == "Yes") {
                echo '<a
                    href="/documentation_delete.php?pg_id=' . $result_datos_document['File'] . '"><i
                        class="bi bi-trash"
                        style="padding-right: 4px;"></i></a>';
            }
            echo '<a
                    href="documentation_historial_file.php?' . $result_datos_document['File'] . '"><i
                        class="bi bi-hourglass-split"
                        style="padding-right: 4px;"></i></a>
            </td>
            <!--end::Actions-->

        </tr>';
        }
        echo '</tbody></table></div></div>';
    }
}
