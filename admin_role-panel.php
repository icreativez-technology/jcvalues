<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Roles Management";
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];

$sql_datos_super_admins = "SELECT * From Basic_Employee WHERE Admin_User = 'Super Administrator'";
$result_datos_super_admins = mysqli_query($con, $sql_datos_super_admins);
$num_rows_super_admins = mysqli_num_rows($result_datos_super_admins);

$sql_datos_employees = "SELECT * From Basic_Employee WHERE Admin_User = 'Administrator'";
$result_datos_employees = mysqli_query($con, $sql_datos_employees);
$num_rows_admins = mysqli_num_rows($result_datos_employees);

$sql_datos_employees = "SELECT * From Basic_Employee WHERE Admin_User = 'Employee'";
$result_datos_employees = mysqli_query($con, $sql_datos_employees);
$num_rows_employs = mysqli_num_rows($result_datos_employees);

$columns = array('id', 'module', 'module_order');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);

$sorting_status = isset($_GET['sorting_status']) ? $_GET['sorting_status'] : false;

if ($sorting_status) {
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
} else {
    $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'desc';
}

$columnsQueryItem =    [
    'id' => 'id',
    'module' => 'module',
    'module_order' => 'module_order',
];
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#admin-menu-modal">Admin Panel</a> »
                            <?php echo $_SESSION['Page_Title']; ?></p>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-end">
                            <a href="/add_module.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New Module
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="row mt-2">
                            <div class="col-lg-4 col-md-6 mt-2">
                                <div class="card border-0 border-top border-3 border-success shadow">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-pencil text-success fs-4"></i>
                                            </div>
                                            <div>
                                                <h2 class="m-0">Super Administrator</h2>
                                                <p class="m-0 text-end"><?php echo $num_rows_super_admins ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center text-gray-600">
                                            <div>
                                                <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>All Admin Controls
                                                </div>
                                                <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>Edit module entries even
                                                    if
                                                    not assigned
                                                </div>
                                            </div>
                                            <?php if ($role == 1) { ?>
                                                <div style="margin-top:35px;">
                                                    <button data-role="1" type="button" class="btn btn-link" onclick="openEditPopup(this);"><i class="bi bi-pencil cursor-pointer fs-4"></i></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mt-2">
                                <div class="card border-0 border-top border-3 border-danger shadow">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-envelope-open text-danger fs-4"></i>
                                            </div>
                                            <div>
                                                <h2 class="m-0">Administrator</h2>
                                                <p class="m-0 text-end"><?php echo $num_rows_admins ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center text-gray-600">
                                            <div>
                                                <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>Some Admin Controls
                                                </div>
                                                <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>Only edit entries where
                                                    it's
                                                    assigned
                                                </div>
                                            </div>
                                            <?php if ($role == 1) { ?>
                                                <div style="margin-top:35px;">
                                                    <button data-role="2" type="button" class="btn btn-link" onclick="openEditPopup(this);"><i class="bi bi-pencil cursor-pointer fs-4"></i></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mt-2">
                                <div class="card border-0 border-top border-3 border-info shadow">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-check-circle text-info fs-4"></i>
                                            </div>
                                            <div>
                                                <h2 class="m-0">Employee</h2>
                                                <p class="m-0 text-end"><?php echo $num_rows_employs ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center text-gray-600">
                                            <div>
                                                <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>No Admin Controls
                                                </div>
                                                <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>Only edit entries where
                                                    it's
                                                    assigned
                                                </div>
                                            </div>
                                            <?php if ($role == 1) { ?>
                                                <div style="margin-top:35px;">
                                                    <button data-role="3" type="button" class="btn btn-link" onclick="openEditPopup(this);"><i class="bi bi-pencil cursor-pointer fs-4"></i></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-body pt-3 table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                                            <th class="min-w-300px">
                                                <a href="/admin_role-panel.php?column=module_name&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Module Name<i class="fas fa-sort<?php echo $column == 'module' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-50px">
                                                <a href="/admin_role-panel.php?column=module_order&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Module Order<i class="fas fa-sort<?php echo $column == 'module_order' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th class="min-w-100px text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                        <?php
                                        $sql_data = "SELECT * FROM modules WHERE is_deleted = 0 order by " . $columnsQueryItem[$column] . " " . $sort_order;
                                        $connect_data = mysqli_query($con, $sql_data);
                                        $pagination_ok = 1;
                                        $num_rows = mysqli_num_rows($connect_data);
                                        $page_register_count = 0;
                                        $max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
                                        if ($_REQUEST['page'] && $_REQUEST['page'] != 1) {
                                            $this_page = $_REQUEST['page'] - 1;
                                            $pass_registers = $max_registers_page * $this_page;
                                            $registers_off = 0;
                                        } else {
                                            $this_page = 0;
                                            $pass_registers = 0;
                                            $registers_off = 0;
                                        }
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            if ($pagination_ok == 1) {
                                                if ($registers_off != $pass_registers) {
                                                    $registers_off++;
                                                    continue;
                                                }
                                                if ($page_register_count != $max_registers_page) {
                                                    $page_register_count++;
                                                } else {
                                                    break;
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $result_data['module']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $result_data['module_order']; ?>
                                                </td>
                                                <td class="text-end">
                                                    <a href="edit_module.php?id=<?php echo $result_data['id']; ?>" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                                                    <a href="/includes/module_delete.php?id=<?php echo $result_data['id']; ?>"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between">
                                    <div class="ms-3 pageRange">
                                        <select id="pageRange" name="pageRange" class="form-select">
                                            <option value="10" <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>
                                                10</option>
                                            <option value="25" <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>
                                                25</option>
                                            <option value="50" <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>
                                                50</option>
                                            <option value="100" <?php echo ($max_registers_page == 100) ? 'selected' : ''; ?>>100
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>
    </div>

    <?php include('includes/scrolltop.php'); ?>
    <script>
        var hostUrl = "assets/";

        function openEditPopup(obj) {
            let role = $(obj).data('role');
            $("<form>").load('/role_edit_modal.php?role=' + role,
                function() {
                    $('#role_edit_modal').empty();
                    $("#role_edit_modal").append($(this).html());
                    return $('#role_edit_modal').modal('show');
                });
        }

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
                `<li class="page-item m-1"><a href="/admin_role-panel.php?page=${1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${firstPage}</a></li>`;
            if (page > 1) {
                liTag +=
                    `<li class="page-item m-1"><a href="/admin_role-panel.php?page=${page - 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${prevLabel}</a></li>`;
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
                    `<li class="page-item m-1 ${active}"><a href="/admin_role-panel.php?page=${plength}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${plength}</a></li>`;
            }
            if (page < totalPages) {
                liTag +=
                    `<li class="page-item m-1"><a href="/admin_role-panel.php?page=${page + 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${nextLabel}</a></li>`;
            }
            liTag +=
                `<li class="page-item m-1"><a href="/admin_role-panel.php?page=${totalPages}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${lastPage}</a></li>`;
            element.innerHTML = liTag;
            return liTag;
        }
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <div class="modal" id="role_edit_modal" tabindex="-1" aria-hidden="true"></div>
</body>

</html>