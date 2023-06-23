<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Task Management";

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
$empId = $roleInfo['Id_employee'];

$columns = array('id', 'title', 'task_id', 'status', 'priority', 'project', 'progress', 'date');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);

$sorting_status    = isset($_GET['sorting_status']) ? $_GET['sorting_status'] : false;

if ($sorting_status) {
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
} else {

    $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'desc';
}

$columnsQueryItem =    [
    'id' => 'id',
    'title' => 'title',
    'task_id' => 'task_id',
    'status' => 'status',
    'priority' => 'priority',
    'project' => 'project',
    'progress' => 'status',
    'date' => 'updated_at'
]
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<!--begin::Body-->
<style>
.status-green {
    color: #2d9f50 !important;
    font-weight: 500;
}

.status-red {
    color: #f81c1c !important;
    font-weight: 500;
}

.status-yellow {
    color: #f08709 !important;
    font-weight: 500;
}

.status-orange {
    color: #fc7150 !important;
    font-weight: 500;
}

.status-blue {
    color: #004cf9 !important;
    font-weight: 500;
}
</style>

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
                <!-- Breadcrumbs + Actions -->
                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p id="breadcrumbs"><a href="/">Home</a> » Task Management</p>
                    </div>
                </div>
                <!-- End Breadcrumbs + Actions -->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <!--begin::Card-->
                        <div class="card mt-4" id="task-table">
                            <div class="mb-3 pt-5 ps-5">
                                <div class="row">
                                    <!--begin::Search-->
                                    <div class=" col-lg-6 col-sm-12 d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path
                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-filemanager-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-15"
                                            placeholder="Search Task" id="termino" name="termino" />
                                        <input type="hidden" id="role" name="role" value="<?php echo $role ?>">
                                        <input type="hidden" id="empId" name="empId" value="<?php echo $empId ?>">
                                    </div>
                                    <!--end::Search-->
                                    <div class="col-lg-6 col-sm-12 mt-3">
                                        <div class="d-flex justify-content-end me-5">
                                            <button id="btnExport" onclick="fnExcelReport('task.xlsx');"
                                                class="btn btn-sm btn-primary me-2">
                                                Export
                                            </button>
                                            <?php if ($role == 1 || $canEdit == 1) { ?>
                                            <a>
                                                <button type="button" id="add-task" class="btn btn-sm btn-primary">
                                                    Create
                                                </button>
                                            </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive custom-search-nz" id="result-busqueda">
                            </div>

                            <!--begin::Card body-->
                            <div class="card-body pt-0 table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_department_table"
                                    data-cols-width="20,20,20, 10, 20, 10">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                                            <th class="min-w-300px ps-3">
                                                <a
                                                    href="/task-management.php?a=taskManagement&column=title&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Title<i
                                                        class="fas fa-sort<?php echo $column == 'title' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-100px">
                                                <a
                                                    href="/task-management.php?a=taskManagement&column=task_id&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    ID<i
                                                        class="fas fa-sort<?php echo $column == 'task_id' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-100px">
                                                <a
                                                    href="/task-management.php?a=taskManagement&column=status&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Status<i
                                                        class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-100px">
                                                <a
                                                    href="/task-management.php?a=taskManagement&column=priority&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Priority<i
                                                        class="fas fa-sort<?php echo $column == 'priority' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-100px">
                                                <a
                                                    href="/task-management.php?a=taskManagement&column=project&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Project<i
                                                        class="fas fa-sort<?php echo $column == 'project' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-100px">
                                                <a
                                                    href="/task-management.php?a=taskManagement&column=progress&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Progress<i
                                                        class="fas fa-sort<?php echo $column == 'progress' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-100px">
                                                <a
                                                    href="/task-management.php?a=taskManagement&column=date&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Date<i
                                                        class="fas fa-sort<?php echo $column == 'date' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-50px pe-4">Action</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        <?php
                                        $sql_data = null;
                                        if ($role == '1') {
                                            $sql_data = "SELECT * FROM tasks WHERE is_deleted = 0 order by " . $columnsQueryItem[$column] . " " . $sort_order;
                                        } else {
                                            $sql_data = "SELECT tasks.* FROM tasks LEFT JOIN sub_tasks ON 
											sub_tasks.task_id = tasks.id WHERE tasks.is_deleted = 0  AND tasks.assigned_to = '$empId'
											OR tasks.created_by = '$empId'OR sub_tasks.responsible = '$empId' GROUP BY sub_tasks.task_id order by " . $columnsQueryItem[$column] . " " . $sort_order;
                                        }

                                        $connect_data = mysqli_query($con, $sql_data);
                                        /*PAGINACION*/
                                        $pagination_ok = 1;
                                        /*PAGINACION*/
                                        /*Numero total de registros*/
                                        $num_rows = mysqli_num_rows($connect_data);
                                        /*contador*/
                                        $page_register_count = 0;
                                        /*max. registros per pagina*/
                                        $max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 50;
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
                                        <tr>
                                            <td>
                                                <?php echo $result_data['title']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['task_id']; ?>
                                            </td>
                                            <?php
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
                                                ?>
                                            <td>
                                                <span
                                                    class="<?php echo $color; ?>"><?php echo $result_data['status']; ?></span>
                                            </td>
                                            <?php
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
                                                ?>
                                            <td>
                                                <div class="<?php echo $cl; ?>"><?php echo $result_data['priority']; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $result_data['project']; ?>
                                            </td>
                                            <?php
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
                                                ?>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $col; ?>"
                                                        role="progressbar" aria-valuenow="<?php echo $per; ?>"
                                                        aria-valuemin="0" aria-valuemax="100"
                                                        style="width:<?php echo $per; ?>"><?php echo $tex; ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo date("d-m-y", strtotime($result_data['updated_at'])); ?>
                                            </td>
                                            <td>
                                                <?php if ($canView == 1) { ?>
                                                <a class="me-2 cursor-pointer edit-task"
                                                    data-id="<?php echo $result_data['id'] ?>"
                                                    data-unique="<?php echo $result_data['task_id'] ?>"
                                                    data-mode="view"><i class="fa fa-eye"></i></a>
                                                <?php } ?>
                                                <?php if ($result_data['status'] != "Completed") { ?>
                                                <?php if ($canEdit == 1) { ?>
                                                <a class="me-2 cursor-pointer edit-task set-url"
                                                    data-id="<?php echo $result_data['id'] ?>"
                                                    data-unique="<?php echo $result_data['task_id'] ?>"
                                                    data-mode="edit"><i class="bi bi-pencil"></i></a>
                                                <?php } ?>
                                                <?php } ?>
                                                <?php if ($role == 1 || $canDelete == 1) { ?>
                                                <a href="/includes/task-delete.php?id=<?php echo $result_data['id']; ?>"
                                                    class="set-url"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                                <!--start:: PAGINATION-->
                                <div class="d-flex justify-content-between">
                                    <div class="ms-3 pageRange">
                                        <select id="pageRange" name="pageRange" class="form-select">
                                            <option value="10"
                                                <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>10</option>
                                            <option value="25"
                                                <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>25</option>
                                            <option value="50"
                                                <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>50</option>
                                            <option value="100"
                                                <?php echo ($max_registers_page == 100) ? 'selected' : ''; ?>>100
                                            </option>
                                        </select>
                                    </div>
                                    <div class="me-6">
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
                                        <!--end:: PAGINATION-->
                                    </div>
                                </div>
                                <!--end:: PAGINATION-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!-- Finalizar contenido -->

                        <div class="card mt-4 d-none" id="task-content">
                        </div>

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
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <!-- FIN BUSCADOR SEARCH JS -->
    <script src="JS/buscar-task-management.js"></script>
    <!--end::Page Custom Javascript-->
    <script>
    $('body').delegate('#add-task', 'click', function() {
        $("#breadcrumbs").html(
            "<a href='/'>Home</a> » <a href='/task-management.php'>Task Management</a> » Add New Task");
        $("#task-content").empty();
        $.get("task-add.php", function(data) {
            $("#task-content").html(data);
        });
        $('#task-table').addClass('d-none');
        $('#task-content').removeClass('d-none');
    });

    $('body').delegate('.edit-task', 'click', function() {
        let id = $(this).data('id');
        let mode = $(this).data('mode');
        let unique = $(this).data('unique');
        if (mode == "view") {
            $("#breadcrumbs").html(
                `<a href='/'>Home</a> » <a href='/task-management.php'>Task Management</a> » View Task - ${unique}`
            );
        } else {
            $("#breadcrumbs").html(
                `<a href='/'>Home</a> » <a href='/task-management.php'>Task Management</a> » Edit Task - ${unique}`
            );
        }
        $("#task-content").empty();
        $.get(`task-edit.php?id=${id}&mode=${mode}`, function(data) {
            $("#task-content").html(data);
        });
        $('#task-table').addClass('d-none');
        $('#task-content').removeClass('d-none');
    });

    $('body').delegate('#close-task-content', 'click', function() {
        $("#task-content").empty();
        $('#task-table').removeClass('d-none');
        $('#task-content').addClass('d-none');
        $("#breadcrumbs").html("<a href='/'>Home</a> » Task Management");
    });

    const element = document.querySelector(".pagination");
    let totalPages = Number($("#total_pages").val());
    let page = Number($("#current_page").val());

    if (totalPages > 0) {
        element.innerHTML = createPagination(totalPages, page);
    }

    function createPagination(totalPages, page) {
        var pageLimit=document.getElementById("pageRange").value;
        var asc_or_desc = "<?php echo $asc_or_desc; ?>";
        var sorting_status = "<?php echo $sorting_status  ?>"

        if (sorting_status) {
            asc_or_desc = asc_or_desc == 'asc' ? "desc" : 'asc';
        } else {
            asc_or_desc = asc_or_desc == 'asc' ? "asc" : 'desc';
        }

        let liTag = '';
        let active;
        let beforePage = page - 2;
        let afterPage = page + 2;
        let prevLabel = "<";
        let nextLabel = ">";
        let firstPage = "<<";
        let lastPage = ">>";
        liTag +=
            `<li class="page-item m-1"><a href="/task-management.php?a=taskManagement&page=${1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${firstPage}</a></li>`;
        if (page > 1) {
            liTag +=
                `<li class="page-item m-1"><a href="/task-management.php?a=taskManagement&page=${page - 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${prevLabel}</a></li>`;
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
                `<li class="page-item m-1 ${active}"><a href="/task-management.php?a=taskManagement&page=${plength}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${plength}</a></li>`;
        }
        if (page < totalPages) {
            liTag +=
                `<li class="page-item m-1"><a href="/task-management.php?a=taskManagement&page=${page + 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${nextLabel}</a></li>`;
        }
        liTag +=
            `<li class="page-item m-1"><a href="/task-management.php?a=taskManagement&page=${totalPages}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${lastPage}</a></li>`;
        element.innerHTML = liTag;
        return liTag;
    }

    function fnExcelReport(fileName) {
        let table = document.getElementsByTagName("table");
        return TableToExcel.convert(table[0], {
            name: fileName,
            sheet: {
                name: 'Sheet 1'
            }
        });
    }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>