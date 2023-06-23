<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Objective";

$email = $_SESSION['usuario'];
$sql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$roleInfo = mysqli_fetch_assoc($fetch);
$role = $roleInfo['Id_basic_role'];
$rep = $roleInfo['Management_Representative'];

$columns = array('id', 'year', 'revision', 'revision_date', 'created_by', 'approved_by');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
$sorting_status = isset($_GET['sorting_status']) ? $_GET['sorting_status'] : false;

if ($sorting_status) {
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
} else {
    $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'desc';
}

$columnsQueryItem = [
    'id' => 'id',
    'year' => 'year',
    'revision' => 'revision',
    'revision_date' => 'created_at',
    'created_by' => 'created_by',
    'approved_by' => 'approved_by',
]

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
                <!-- Breadcrumbs + Actions -->
                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="/interested-parties.php?a=1" class="header-bar nav-link ms-6">
                                    Analysis and Expectations of Interested Parties
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="/context-analysis.php?a=1" class="header-bar nav-link">
                                    Internal and External Context Analysis
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="/strategy.php?a=1" class="header-bar nav-link">
                                    Strategy
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="/objective.php?a=1" class="header-bar nav-link active">
                                    Objective
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End Breadcrumbs + Actions -->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid p-0" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <!--begin::Card-->
                        <div class="card ">
                            <div class="row mb-4 ms-2">
                                <div class="col-3">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
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
                                            placeholder="Search Objective" id="termino" name="termino" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <?php if ($role == 1 || $rep == "Yes") { ?>
                                <div class="col-9">
                                    <div class="d-flex justify-content-end mr-2">
                                        <a href="/objective-add.php" class="btn btn-sm btn-primary mt-4 me-3">
                                            Create
                                        </a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="table-responsive custom-search-nz" id="result-busqueda">
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body pt-0 table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5"
                                    id="kt_department_table" data-cols-width="10,10,10, 20, 20">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                                            <th class="min-w-100px">
                                                <!-- <a
                                                    href="/objective.php?a=strategicAnalysis&column=year&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Year<i
                                                        class="fas fa-sort<?php echo $column == 'year' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Year
                                            </th>
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/objective.php?a=strategicAnalysis&column=revision&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Revision<i
                                                        class="fas fa-sort<?php echo $column == 'revision' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Revision
                                            </th>
                                            <!--  <th class="min-w-150px">
                                                Created Date
                                             </th> -->
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/objective.php?a=strategicAnalysis&column=revision_date&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Revision Date<i
                                                        class="fas fa-sort<?php echo $column == 'revision_date' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Revision Date
                                            </th>
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/objective.php?a=strategicAnalysis&column=created_by&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Created By<i
                                                        class="fas fa-sort<?php echo $column == 'created_by' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Created By
                                            </th>
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/objective.php?a=strategicAnalysis&column=approved_by&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Approved By<i
                                                        class="fas fa-sort<?php echo $column == 'approved_by' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Approved By
                                            </th>
                                            <th class="min-w-100px">Action</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        <?php
                                        $sql_data = "SELECT * FROM objective WHERE is_deleted = 0 order by " . $columnsQueryItem[$column] . " " . $sort_order;
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
                                                <?php echo $result_data['year']; ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['revision']; ?>
                                            </td>
                                             <!--  <td>
                                                    <?php echo date("d-m-y", strtotime($result_data['created_at'])); ?>
                                                </td> -->
                                            <td>
                                                <?php echo date("d-m-y", strtotime($result_data['created_at'])); ?>
                                            </td>
                                            <?php
                                                $sql = "SELECT * From Basic_Employee Where Id_employee = $result_data[created_by]";
                                                $fetch = mysqli_query($con, $sql);
                                                $createdInfo = mysqli_fetch_assoc($fetch);
                                                ?>
                                            <td>
                                                <?php echo $createdInfo['First_Name'] . ' ' . $createdInfo['Last_Name']; ?>
                                            </td>
                                            <?php
                                                $sql = "SELECT * From Basic_Employee Where Id_employee = $result_data[approved_by]";
                                                $fetch = mysqli_query($con, $sql);
                                                $approvedInfo = mysqli_fetch_assoc($fetch);
                                                ?>
                                            <td>
                                                <?php echo $approvedInfo['First_Name'] . ' ' . $approvedInfo['Last_Name']; ?>
                                            </td>
                                            <?php if ($result_data['is_editable'] && ($role == 1 || $rep == "Yes")) { ?>
                                            <td>
                                                <a href="objective-edit.php?id=<?php echo $result_data['id']; ?>"
                                                    class="me-3 set-url"><i class="bi bi-pencil"
                                                        aria-hidden="true"></i></a>
                                                <a data-id='<?php echo $result_data['id']; ?>'
                                                    data-year='<?php echo $result_data['year']; ?>'
                                                    data-revision='<?php echo $result_data['revision']; ?>'
                                                    target="_blank" class="print-pdf me-3 cursor-pointer"><i
                                                        class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>
                                            </td>
                                            <?php } else { ?>
                                            <td>
                                                <a href="objective-view.php?id=<?php echo $result_data['id']; ?>"
                                                    class="me-3"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a data-id='<?php echo $result_data['id']; ?>'
                                                    data-year='<?php echo $result_data['year']; ?>'
                                                    data-revision='<?php echo $result_data['revision']; ?>'
                                                    target="_blank" class="print-pdf me-3 cursor-pointer"><i
                                                        class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>
                                            </td>
                                            <?php } ?>
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
    <script src="JS/buscar-objective.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

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
            `<li class="page-item m-1"><a href="/objective.php?a=strategicAnalysis&page=${1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${firstPage}</a></li>`;
        if (page > 1) {
            liTag +=
                `<li class="page-item m-1"><a href="/objective.php?a=strategicAnalysis&page=${page - 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${prevLabel}</a></li>`;
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
                `<li class="page-item m-1 ${active}"><a href="/objective.php?a=strategicAnalysis&page=${plength}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${plength}</a></li>`;
        }
        if (page < totalPages) {
            liTag +=
                `<li class="page-item m-1"><a href="/objective.php?a=strategicAnalysis&page=${page + 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${nextLabel}</a></li>`;
        }
        liTag +=
            `<li class="page-item m-1"><a href="/objective.php?a=strategicAnalysis&page=${totalPages}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${lastPage}</a></li>`;
        element.innerHTML = liTag;
        return liTag;
    }

    $('.print-pdf').on('click', function() {
        let id = $(this).data('id');
        let fileName = $(this).data('year') + "-Revision-" + $(this).data('revision');
        $.get(`/includes/objective_pdf.php?id=${id}`, function(data) {
            let opt = {
                margin: [0, 0.1, 0.1, 0.1],
                image: {
                    type: "jpeg",
                    quality: 1.5,
                },
                html2canvas: {
                    scale: 7,
                    letterRendering: false,
                    dpi: 700,
                    width: 775,
                    scrollY: 0,
                },
                jsPDF: {
                    unit: "in",
                    format: "A4",
                    orientation: "portrait",
                },
            };
            let worker = html2pdf().set(opt).from(data).save(fileName);
        });

    });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>