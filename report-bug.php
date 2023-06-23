<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Report Bug";
if ($_SESSION['usuario']) {
    $email = $_SESSION['usuario'];
    $sql = "SELECT Id_basic_role From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
    $fetch = mysqli_query($con, $sql);
    $roleInfo = mysqli_fetch_assoc($fetch);
    $role = $roleInfo['Id_basic_role'];

    $employeeSql = "SELECT * From Basic_Employee Where Email = '$email'";
    $fetch = mysqli_query($con, $employeeSql);
    $userInfo = mysqli_fetch_assoc($fetch);
    $userId = $userInfo['Id_employee'];
    $firstName = $userInfo['First_Name'];
    $LastName = $userInfo['Last_Name'];
}


$columns = array('issue_number', 'issue_description', 'type', 'priority', 'created_date', 'created_by', 'updated_date', 'closed_date', 'status');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);

$sorting_status    = isset($_GET['sorting_status']) ? $_GET['sorting_status'] : false;

if ($sorting_status) {
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
} else {
    $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'desc';
}

$columnsQueryItem = [
    'issue_number' => 'issue_number',
    'issue_description' => 'issue_description',
    'type' => 'issue_type',
    'priority' => 'priority',
    'created_date' => 'created_at',
    'created_by' => 'created_by',
    'updated_date' => 'updated_at',
    'closed_date' => 'closed_date',
    'status' => 'status',
]
?>
<style>
    @media (max-width: 330px) {
        .table-text {
            font-size: 8px;
            font-weight: bold;	
        }
        .table-width {
            width: 100px;
        }
    }

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        top: 0 !important;
        right: 0 !important;
        margin: auto;
        width: 320px !important;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Left*/
    .modal.left.fade .modal-dialog {
        left: -320px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog {
        left: 0;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    #add-bug-form {
        height: 100%;
    }

    #edit-bug-form {
        height: 100%;
    }

    .icon-view {
        background-color: #e4e6ef;
        display: inline-block;
        position: absolute;
        right: 0px;
        top: 29px;
        padding: 11px;
        border-bottom-right-radius: 5px;
        border-top-right-radius: 5px;
        color: #009ef7;
    }

    .icon-upload {
        background-color: #e4e6ef;
        display: inline-block;
        position: absolute;
        right: 33px;
        top: 29px;
        padding: 11px;
        color: #009ef7;
        border-right: 1px solid #d8d5d5;
        cursor: pointer;
    }

    .icon-delete {
        background-color: #e4e6ef;
        display: inline-block;
        position: absolute;
        right: 65px;
        top: 29px;
        padding: 11px;
        color: #009ef7;
        border-right: 1px solid #d8d5d5;
        cursor: pointer;
    }

    .view-pdf {
        position: relative;
    }
</style>

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
                        <p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
                    </div>
                </div>
                <!-- End Breadcrumbs + Actions -->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <!--begin::Card-->
                        <div class="card mt-4">
                            <div class="row mt-2 mb-4 ms-2">
                                <div class="col-md-3">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Issue" id="termino" name="termino" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <div class="col-lg-9">
                                    <div class="d-flex justify-content-end mr-2">
                                        <a class=" btn btn-sm btn-primary mt-4" style="float:right ; margin-right:10px;" data-bs-toggle="modal" data-bs-target="#add-bug-modal">
                                            Create
                                        </a>
                                        <button id="btnExport" onclick="fnExcelReport('Report Bug.xlsx');" class="btn btn-sm btn-primary mt-4 me-2">
                                            Export
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive custom-search-nz" id="result-busqueda">
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body pt-0 table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 text-uppercase gs-0">
                                            <th >
                                                <a class='table-width' href="/report-bug.php?column=issue_number&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                   <span class='table-text'>Issue Number</span> <i class="fas fa-sort<?php echo $column == 'issue_number' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th >
                                                <a class='table-width'    href="/report-bug.php?column=issue_description&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                <span class='table-text'>Issue Description</span> <i class="fas fa-sort<?php echo $column == 'issue_description' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th >
                                                <a class='table-width' href="/report-bug.php?column=type&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                <span class='table-text'> Type</span> <i class="fas fa-sort<?php echo $column == 'type' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th >
                                                <a class='table-width' href="/report-bug.php?column=priority&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                <span class='table-text'> Priority</span> <i class="fas fa-sort<?php echo $column == 'priority' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th>
                                                <a class='table-width' href="/report-bug.php?column=created_date&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                <span class='table-text'> Created Date</span> <i class="fas fa-sort<?php echo $column == 'created_date' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <?php if ($role == 1) { ?>
                                                <th class='table-width' ><span class='table-text'>Created By</span> </th>
                                            <?php } ?>
                                            <th >
                                                <a class='table-width' href="/report-bug.php?column=updated_date&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                <span class='table-text'> Updated Date</span> <i class="fas fa-sort<?php echo $column == 'updated_date' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <th>
                                                <a class='table-width' href="/report-bug.php?column=closed_date&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                <span class='table-text'>Closed Date</span> <i class="fas fa-sort<?php echo $column == 'closed_date' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a>
                                            </th>
                                            <?php if ($role == 1) { ?>
                                                <th >
                                                    <a class='table-width' href="/report-bug.php?column=status&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    <span class='table-text'>Status</span> <i class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i>
                                                    </a>
                                                </th>
                                            <?php } ?>
                                            <th class='table-width' ><span class='table-text'>Action</span> </th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        <?php
                                        $sql_data = "SELECT * FROM report_bug WHERE is_deleted = 0 AND created_by = '$userId' order by " . $columnsQueryItem[$column] . " " . $sort_order;;
                                        if ($role == 1) {
                                            $sql_data = "SELECT * FROM report_bug WHERE is_deleted = 0 order by " . $columnsQueryItem[$column] . " " . $sort_order;
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
                                        $max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
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
                                                    <?php echo $result_data['issue_number']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $result_data['issue_description']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($result_data['issue_type'] == 1) {
                                                        echo "UI";
                                                    } else if ($result_data['issue_type'] == 2) {
                                                        echo "Functionality";
                                                    } else if ($result_data['issue_type'] == 3) {
                                                        echo "Hotfix";
                                                    }

                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($result_data['priority'] == 1) {
                                                        echo "High";
                                                    } else if ($result_data['priority'] == 2) {
                                                        echo "Medium";
                                                    } else if ($result_data['priority'] == 3) {
                                                        echo "Low";
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php echo date("d-m-y", strtotime($result_data['created_at'])); ?>
                                                </td>
                                                <?php if ($role == 1) { ?>
                                                    <td><?php echo $userInfo['First_Name'] . $userInfo['Last_Name'] ?></td>
                                                <?php } ?>
                                                <td>
                                                    <?php echo $result_data['updated_at'] != null ? date("d-m-y", strtotime($result_data['updated_at'])) : ''; ?>
                                                </td>
                                                <td>
                                                    <?php echo $result_data['closed_at'] != null ? date("d-m-y", strtotime($result_data['closed_at'])) : ''; ?>
                                                </td>
                                                <?php if ($role == 1) {  ?>
                                                    <td>
                                                        <?php if ($result_data['status'] == "Open") { ?>
                                                            <a href="/includes/report_bug_status.php?id=<?php echo $result_data['id']; ?>">
                                                                <div class="status-danger">
                                                                    <?php echo $result_data['status']; ?>
                                                                </div>
                                                            </a>
                                                        <?php } else { ?>
                                                            <div class="status-active">
                                                                <?php echo $result_data['status']; ?>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>
                                                <td>
                                                    <a class="edit-bug" data-id="<?php echo $result_data['id']; ?>"><i class="bi bi-pencil" aria-hidden="true"></i></a>
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
                                            <option value="10" <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>10</option>
                                            <option value="25" <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>25</option>
                                            <option value="50" <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>50</option>
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
                                        <!--end:: PAGINATION-->
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

    <div class="modal right fade" id="add-bug-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="add-bug-form" method="post" class="form" action="includes/report-bug-store.php" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header right-modal">
                        <h5 class="modal-title" id="staticBackdropLabel">Report new Bug
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="overflow-y: scroll;">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Your Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $firstName . " " . $lastName ?>" required disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label>Your Email</label>
                                <input type="text" class="form-control" name="Email" value="<?php echo $email ?>" required disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label>Describe your issue / Request</label>
                                <textarea type="text" class="form-control" rows="3" name="issue_description" required></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label>Type</label>
                                <select class="form-control" name="issue-type" required>
                                    <option value="">Please Select </option>
                                    <option value="1">UI</option>
                                    <option value="2">Functionality</option>
                                    <option value="3">Hotfix</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label>Priority</label>
                                <select class="form-control" name="priority" required>
                                    <option value="">Please Select </option>
                                    <option value="1">High</option>
                                    <option value="2">Medium</option>
                                    <option value="3">Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label>Screen Shots</label>
                                <input type="file" class="form-control" name="files[]" accept="image/*" multiple>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success" id="subTask-submit">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" id="subTask-cancel" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="modal right fade" id="edit-bug-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="edit-bug-form" action="includes/report-bug-update.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header right-modal">
                        <h5 class="modal-title" id="staticBackdropLabel">Report new Bug
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="edit-bug-content" style="overflow-y: scroll;">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success" id="subTask-submit">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" id="subTask-cancel" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>

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
    <!-- BUSCADOR SEARCH PARA: Department -->
    <script src="JS/buscar-report-bug.js"></script>
    <!-- FIN BUSCADOR SEARCH JS -->
    <!--end::Page Custom Javascript-->
    <script>
        $('.edit-bug').on('click', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "includes/report-bug-edit-modal.php",
                type: "POST",
                dataType: "html",
                data: {
                    id: id
                },
            }).done(function(resultado) {
                $("#edit-bug-content").empty();
                $("#edit-bug-content").html(resultado);
                return $('#edit-bug-modal').modal('show');
            });
        })

        let deleteArr = new Array();

        $('body').delegate('#file-view', 'change', function() {
            let filePath = $(this).val();
            return $("#icon-view").attr("href", filePath);
        });

        function uploadFile(target) {
            $("#screenshots").find('.temp_option').remove();
            if (target.files.length == 1) {
                $("#file-view").append(`<option class ="temp_option" selected>${target.files[0].name}</option>`);
            } else if (target.files.length > 0) {
                $("#file-view").append(`<option class ="temp_option" selected>${target.files.length} files</option>`);
            }
        }

        $('body').delegate('#icon-delete', 'click', function() {
            sel = document.getElementById('file-view');
            var opt = sel.options[sel.selectedIndex];
            if (opt.className !== 'placeholder') {
                deleteArr.push($('#file-view').val());
                sel.removeChild(opt);
                return $('#deleted-file').val(JSON.stringify(deleteArr));
            }
        });

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
                `<li class="page-item m-1"><a href="/report-bug.php?page=${1}" class="page-link">${firstPage}</a></li>`;
            if (page > 1) {
                liTag +=
                    `<li class="page-item m-1"><a href="/report-bug.php?page=${page - 1}" class="page-link">${prevLabel}</a></li>`;
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
                    `<li class="page-item m-1 ${active}"><a href="/report-bug.php?page=${plength}" class="page-link">${plength}</a></li>`;
            }
            if (page < totalPages) {
                liTag +=
                    `<li class="page-item m-1"><a href="/report-bug.php?page=${page + 1}" class="page-link">${nextLabel}</a></li>`;
            }
            liTag +=
                `<li class="page-item m-1"><a href="/report-bug.php?page=${totalPages}" class="page-link">${lastPage}</a></li>`;
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