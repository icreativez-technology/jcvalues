<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "User Management";

$columns = array('name', 'email', 'id', 'plant', 'department', 'role', 'plant_head', 'department_head', 'management_rep', 'ccr', 'created_at', 'modified_at', 'status');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

$columnsQueryItem =    [
    'name' => 'year',
    'email' => 'revision',
    'id' => 'created_at',
    'plant' => 'created_by',
    'department' => 'item_code',
    'role' => '',
    'plant_head' => '',
    'department_head' => '',
    'management_rep' => '',
    'ccr' => '',
    'created_at' => '',
    'modified_at' => '',
    'status' => ''
];

$page = 1;

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>


<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <!-- Includes Top bar and Responsive Menu -->
                <!-- Breadcrumbs + Actions -->

                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#admin-menu-modal">Admin
                                Panel</a> »
                            <?php echo $_SESSION['Page_Title']; ?></p>
                        <!-- MIGAS DE PAN -->
                    </div>

                </div>

                <!-- End Breadcrumbs + Actions -->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">

                        <!-- AQUI AÑADIR EL CONTENIDO  -->
                        <!--begin::Card-->
                        <div class="card mt-4">
                            <!--begin::Card header-->

                            <div class="row mt-2 mb-4 ms-2">
                                <div class="col-md-3">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor">
                                                </rect>
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Employee" id="termino" name="termino" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <div class="col-lg-9">
                                    <div class="d-flex justify-content-end mr-2">
                                        <a href="/admin_user-add.php" id="add_mtc" class="btn btn-sm btn-primary mt-4 me-3">
                                            Create
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!-- Mostrar datos del buscador -->
                            <div class="table-responsive custom-search-nz" id="result-busqueda">
                            </div>


                            <!--begin::Card body-->
                            <div class="card-body py-4 table-responsive ">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th class="min-w-90px px-0 ps-3">
                                                Employee
                                            </th>
                                            <th class="min-w-50px">
                                                Email
                                            </th>
                                            <th class="min-w-100px">
                                                ID
                                            </th>
                                            <th class="min-w-70px px-0">
                                                Plant
                                            </th>
                                            <th class="min-w-70px px-0">
                                                Depart
                                            </th>
                                            <th class="min-w-50px px-0">
                                                Role
                                            </th>
                                            <th class="min-w-100px px-0">
                                                Plant Head
                                            </th>
                                            <th class="min-w-80px px-0">
                                                Dep. Head
                                            </th>
                                            <th class="min-w-100px px-0">
                                                Manag. Rep.
                                            </th>
                                            <th class="min-w-40px px-0">
                                                CCR
                                            </th>
                                            <th class="min-w-70px px-0">
                                                Created
                                            </th>
                                            <th class="min-w-80px px-0">
                                                Modified
                                            </th>
                                            <th class="min-w-60px px-0">
                                                Status
                                            </th>
                                            <th class="text-end min-w-25px pe-3">Actions</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->

                                    <?php

                                    $sql_datos_employees = "SELECT Id_employee, First_Name, Last_Name, Email, Id_plant, Id_department, Admin_User, Plant_Head, Department_Head, Management_Representative, Customer_Compliants_Representatives, Password, Title, Created, Modified, Status, Avatar_img, Custom_ID From Basic_Employee";
                                    $connect_data = mysqli_query($con, $sql_datos_employees);


                                    /*PAGINACION*/
                                    $pagination_ok = 1;
                                    /*PAGINACION*/
                                    /*Numero total de registros*/
                                    $num_rows = mysqli_num_rows($connect_data);
                                    /*contador*/
                                    $page_register_count = 0;
                                    /*max. registros per pagina*/
                                    /*Si hay paginación*/
                                    if ($_REQUEST['page'] && $_REQUEST['page'] != 1) {
                                        $this_page = $_REQUEST['page'] - 1;
                                        $pass_registers = $max_registers_page * $this_page;
                                        $registers_off = 0;
                                    } else {
                                        /*Si es la primera página, ponemos esto para que evite el uso del continue - Saltaba el primer registro sin esto-*/
                                        $this_page = 0;
                                        $pass_registers = 0;
                                        $registers_off = 0;
                                    }
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        /*PAGINACION*/
                                        if ($pagination_ok == 1) {
                                            /*codigo para saltar registros de paginas anteriores*/
                                            if ($registers_off != $pass_registers) {
                                                $registers_off++;
                                                continue;
                                            }
                                            /*codigo para mostrar solo los registros de la pagina*/
                                            if ($page_register_count != $max_registers_page) {
                                                $page_register_count++;
                                            } else {
                                                break;
                                            }
                                        }


                                    ?>
                                        <!--begin::Mostrar empleados-->
                                        <tbody class="text-gray-600 fw-bold">
                                            <!--begin::Table row-->
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <?php echo $result_data['First_Name'] . " " . $result_data['Last_Name']; ?>
                                                </td>
                                                <td><?php echo $result_data['Email']; ?></td>
                                                <!--end::User=-->

                                                <!--begin::ID=-->
                                                <td><?php echo $result_data['Custom_ID']; ?>
                                                </td>
                                                <!--end::ID=-->

                                                <!--begin::Plant=-->
                                                <td>
                                                    <?php
                                                    $sql_data_plants = "SELECT Id_plant, Title FROM Basic_Plant WHERE Id_plant = '$result_data[Id_plant]'";
                                                    $connect_data_plants = mysqli_query($con, $sql_data_plants);
                                                    $result_data_plants = mysqli_fetch_assoc($connect_data_plants);
                                                    ?>
                                                    <?php echo $result_data_plants['Title']; ?>
                                                </td>
                                                <!--end::Plant=-->

                                                <!--begin::Department=-->
                                                <td>
                                                    <?php
                                                    $sql_data_dep = "SELECT Id_department, Department FROM Basic_Department WHERE Id_department = '$result_data[Id_department]'";
                                                    $connect_data_dep = mysqli_query($con, $sql_data_dep);
                                                    $result_data_dep = mysqli_fetch_assoc($connect_data_dep);
                                                    ?>
                                                    <?php echo $result_data_dep['Department']; ?>
                                                </td>
                                                <!--end::Department=-->

                                                <!--begin::Rol=-->
                                                <?php if ($result_data['Admin_User'] == 'Employee') { ?>
                                                    <td>Employ.</td>
                                                <?php } else if ($result_data['Admin_User'] == 'Super Administrator') { ?>
                                                    <td>Super.</td>
                                                <?php } else { ?>
                                                    <td>Admin.</td>
                                                <?php } ?>
                                                <!--begin::Rol=-->

                                                <!--begin::PHead=-->
                                                <td><?php echo $result_data['Plant_Head']; ?></td>
                                                <!--begin::PHead=-->

                                                <!--begin::DHead=-->
                                                <td><?php echo $result_data['Department_Head']; ?></td>
                                                <!--begin::DHead=-->

                                                <!--begin::ManagementRepresentative=-->
                                                <td><?php echo $result_data['Management_Representative']; ?></td>
                                                <!--begin::ManagementRepresentative=-->

                                                <!--begin::Customer_Compliants_Representatives=-->
                                                <td><?php echo $result_data['Customer_Compliants_Representatives']; ?></td>
                                                <!--begin::Customer_Compliants_Representatives=-->

                                                <!--begin::Created=-->
                                                <td>
                                                    <?php echo date("d-m-y", strtotime($result_data['Created'])); ?>
                                                </td>
                                                <!--end::Created=-->

                                                <!--begin::Modified=-->
                                                <td>
                                                    <?php echo date("d-m-y", strtotime($result_data['Modified'])); ?>
                                                </td>
                                                <!--end::Modified=-->

                                                <!--begin::Status=-->
                                                <?php if ($result_data['Admin_User'] != 'Super Administrator') { ?>
                                                    <?php if ($result_data['Status'] == 'Active') { ?>
                                                        <td><a href="/includes/basicsettings_user_status.php?pg_id=<?php echo $result_data['Id_employee']; ?>">
                                                                <div class="status-active">Active</div>
                                                            </a></td>
                                                    <?php } else { ?>
                                                        <td><a href="/includes/basicsettings_user_status.php?pg_id=<?php echo $result_data['Id_employee']; ?>">
                                                                <div class="status-danger">Susp.</div>
                                                            </a></td>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <td>
                                                        <div class="status-active">Active</div>
                                                    </td>
                                                <?php } ?>
                                                <!--end::Status=-->

                                                <!--begin::Action=-->
                                                <td class="text-end">
                                                    <?php if ($result_data['Admin_User'] != 'Super Administrator') { ?>
                                                        <a href="/admin_user-edit.php?pg_id=<?php echo $result_data['Id_employee']; ?>&view"><i class="bi bi-eye" style="padding-right: 4px;"></i></a>
                                                         <a href="/admin_user-edit.php?pg_id=<?php echo $result_data['Id_employee']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
                                                        <?php if ($dt['Admin_User'] == 'Super Administrator') { ?>
                                                            <a href="/admin_user-delete.php?pg_id=<?php echo $result_data['Id_employee']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if ($dt['Admin_User'] == 'Super Administrator') { ?>
                                                            <a href="/admin_user-edit.php?pg_id=<?php echo $result_data['Id_employee']; ?>&view"><i class="bi bi-eye" style="padding-right: 4px;"></i></a>
                                                            <a href="/admin_user-edit.php?pg_id=<?php echo $result_data['Id_employee']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
                                                            <a href="/admin_user-delete.php?pg_id=<?php echo $result_data['Id_employee']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                                <!--end::Action=-->

                                            <?php } ?>
                                            </tr>

                                            <!--end::Table row-->
                                        </tbody>
                                        <!--end::Table body-->
                                </table>
                                <!--end::Table-->

                                <!--start:: PAGINATION-->
                                <div class="d-flex justify-content-between">
                                    <div class="ms-3 col-6 pageRange">
                                        <select id="pageRange" name="pageRange" class="form-select">
                                            <option value="10" <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>10</option>
                                            <option value="25" <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>25</option>
                                            <option value="50" <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>50</option>
                                            <option value="100" <?php echo ($max_registers_page == 100) ? 'selected' : ''; ?>>100
                                            </option>
                                        </select>
                                    </div>
                                    <div class="me-6 col-6">
                                        <ul class="pagination pagination-circle pagination-outline">
                                            <?php
                                            if ($pagination_ok == 1) {
                                                $num_pages = $num_rows / $max_registers_page;
                                                $total_pages = ceil($num_pages);
                                                if (!$_REQUEST['page']) {
                                                    $_REQUEST['page'] = 1;
                                                }
                                                $current_page = $_REQUEST['page'];
                                            }
                                            ?>
                                            <input type="hidden" id="total_pages" value="<?php echo $total_pages ?>">
                                            <input type="hidden" id="current_page" value="<?php echo $current_page ?>">
                                        </ul>
                                    </div>
                                </div>
                                <!--end:: PAGINATION-->

                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->

                        <!-- Finalizar contenido -->


                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->

                <?php include('includes/footer.php'); ?>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->


    <?php include('includes/scrolltop.php'); ?>

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>

    <!-- BUSCADOR SEARCH PARA: Department -->
    <script src="JS/buscar-users.js"></script>
    <!-- FIN BUSCADOR SEARCH JS -->

    <!--end::Page Custom Javascript-->
    <script>
        const element = document.querySelector(".pagination");
        let totalPages = Number($("#total_pages").val());
        let page = Number($("#current_page").val());

        if (totalPages > 0) {
            element.innerHTML = createPagination(totalPages, page);
        }

        function createPagination(totalPages, page) {
            var pageLimit=document.getElementById("pageRange").value;
            let liTag = '';
            let active;
            let beforePage = page - 2;
            let afterPage = page + 2;
            let prevLabel = "<";
            let nextLabel = ">";
            let firstPage = "<<";
            let lastPage = ">>";
            liTag +=
                `<li class="page-item m-1"><a href="/admin_user-panel.php?page=${1}&limit=${pageLimit}" class="page-link">${firstPage}</a></li>`;
            if (page > 1) {
                liTag +=
                    `<li class="page-item m-1"><a href="/admin_user-panel.php?page=${page - 1}&limit=${pageLimit}" class="page-link">${prevLabel}</a></li>`;
            }
            if (page == totalPages) {
                beforePage = beforePage - 2;
            } else if (page == totalPages - 1) {
                beforePage = beforePage - 1;
            }
            if (page == 1) {
                afterPage = afterPage + 2;
            } else if (page == 2) {
                afterPage = afterPage + 1;
            }
            beforePage = beforePage > 0 ? beforePage : 1;
            for (var plength = beforePage; plength <= afterPage; plength++) {
                if (plength > totalPages) {
                    continue;
                }
                if (plength == 0) {
                    plength = plength + 1;
                }
                if (page == plength) {
                    active = "active";
                } else {
                    active = "";
                }
                liTag +=
                    `<li class="page-item m-1 ${active}"><a href="/admin_user-panel.php?page=${plength}&limit=${pageLimit}" class="page-link">${plength}</a></li>`;
            }
            if (page < totalPages) {
                liTag +=
                    `<li class="page-item m-1"><a href="/admin_user-panel.php?page=${page + 1}&limit=${pageLimit}" class="page-link">${nextLabel}</a></li>`;
            }
            liTag +=
                `<li class="page-item m-1"><a href="/admin_user-panel.php?page=${totalPages}&limit=${pageLimit}" class="page-link">${lastPage}</a></li>`;
            element.innerHTML = liTag;
            return liTag;
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>