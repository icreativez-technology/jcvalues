<?php
session_start();
include 'includes/functions.php';
$_SESSION['Page_Title'] = "Calibration List";

$email = $_SESSION['usuario'];
$roleSql = "SELECT Id_basic_role From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];

$columns = array('id', 'created_by', 'customer_name', 'order_ref_no', 'department', 'owner', 'status');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
$add_class = ' class="highlight"';
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<?php include 'includes/admin_check.php'; ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <!--Menu-->
            <?php include 'includes/aside-menu.php'; ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include 'includes/header.php'; ?>
                <!-- Breadcrumbs + Actions -->
                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> » <a href="/compliants.php">Compliants</a> »
                            <?php echo $_SESSION['Page_Title']; ?>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-end">
                            <a href="/compliant_detail.php?type=0">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New Customer Compliant
                                </button>
                            </a>
                            <a href="/compliants.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    <i class="bi bi-speedometer2"></i> View Dashboard
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="observation-tab" data-bs-toggle="tab" data-bs-target="#observation" type="button" role="tab" aria-controls="details" aria-selected="true">My Observation</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link  active" id="others-tab" data-bs-toggle="tab" data-bs-target="#others" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Others</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" id="observation" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card mt-4">
                                    <div class="row mt-2 mb-4 ms-2">
                                        <div class="col-md-3">
                                            <!--Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search..." id="termino" name="termino" />
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="d-flex justify-content-end">
                                                <a href="/compliant-export.php" class="btn btn-sm btn-primary mt-4 me-3">
                                                    Export
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive custom-search-nz" id="result-busqueda">
                                    </div>
                                    <div class="card-body pt-0 table-responsive">
                                        <!--Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
                                            <!--Table head-->
                                            <thead>
                                                <!--Table row-->
                                                <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=id&order=<?php echo $asc_or_desc; ?>">
                                                            Unique Id<i class="fas fa-sort<?php echo $column == 'id' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=created_by&order=<?php echo $asc_or_desc; ?>">
                                                            Created By<i class="fas fa-sort<?php echo $column == 'created_by' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=customer_name&order=<?php echo $asc_or_desc; ?>">
                                                            Customer Name<i class="fas fa-sort<?php echo $column == 'customer_name' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=order_ref_no&order=<?php echo $asc_or_desc; ?>">
                                                            Order RefNo<i class="fas fa-sort<?php echo $column == 'order_ref_no' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=department&order=<?php echo $asc_or_desc; ?>">
                                                            Department<i class="fas fa-sort<?php echo $column == 'department' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=owner&order=<?php echo $asc_or_desc; ?>">
                                                            Owner<i class="fas fa-sort<?php echo $column == 'owner' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-30px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=status&order=<?php echo $asc_or_desc; ?>">
                                                            Status<i class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-125px">Action</th>
                                                </tr>
                                            </thead>
                                            <!--Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                <?php
                                                $query = "select * from compliant_details INNER JOIN Basic_Employee on compliant_details.on_behalf_of=Basic_Employee.Id_employee
                        INNER JOIN Basic_Customer on compliant_details.customer_id=Basic_Customer.Id_customer
                        ";
                                                $compliant_details = mysqli_query($con, $query);
                                                while ($compliant_detail = mysqli_fetch_assoc($compliant_details)) {
                                                ?>
                                                <?php
                                                }
                                                ?>

                                                <!-- <tr>
													<td>
														CC_21Dec_001
													</td>
													<td>
														User Admin
													</td>
													<td>
														Lunar Spares Ltd
													</td>
													<td>
														Order001
													</td>
													<td>
														Management
													</td>
													<td>
														Lucky Dev
													</td>
													<td>
														<div class="badge badge-light-success">
															Closed
														</div>
													</td>
													<td>
														<a data-id='<?php echo $result_data['id']; ?>' target="_blank" class="print-compliant me-3">
                              <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                            </a>
														<a href="compliant_detail.php?type=2" class="me-3">
															<i class="bi bi-pencil" aria-hidden="true"></i>
														</a>
														<?php if ($role == 1) { ?>
														<a href="#">
															<i class="bi bi-trash" aria-hidden="true"></i>
														</a>
														<?php } ?>
													</td>
												</tr> -->
                                            </tbody>
                                        </table>
                                        <!--pagination-->

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="others" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card mt-4">
                                    <div class="row mt-2 mb-4 ms-2">
                                        <div class="col-md-3">
                                            <!--search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search..." id="termino" name="termino" />
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="d-flex justify-content-end">
                                                <a href="/compliant-export.php" class="btn btn-sm btn-primary mt-4 me-3">
                                                    Export
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive custom-search-nz" id="result-busqueda">
                                    </div>
                                    <div class="card-body pt-0 table-responsive">
                                        <!--table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
                                            <!--Table head-->
                                            <thead>
                                                <!--Table row-->
                                                <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=id&order=<?php echo $asc_or_desc; ?>">
                                                            Unique Id<i class="fas fa-sort<?php echo $column == 'id' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=created_by&order=<?php echo $asc_or_desc; ?>">
                                                            Created By<i class="fas fa-sort<?php echo $column == 'created_by' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=customer_name&order=<?php echo $asc_or_desc; ?>">
                                                            Customer Name<i class="fas fa-sort<?php echo $column == 'customer_name' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=order_ref_no&order=<?php echo $asc_or_desc; ?>">
                                                            Order RefNo<i class="fas fa-sort<?php echo $column == 'order_ref_no' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=department&order=<?php echo $asc_or_desc; ?>">
                                                            Department<i class="fas fa-sort<?php echo $column == 'department' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-100px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=owner&order=<?php echo $asc_or_desc; ?>">
                                                            Owner<i class="fas fa-sort<?php echo $column == 'owner' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-30px">
                                                        <a href="/compliant_view_list.php?a=compliant&column=status&order=<?php echo $asc_or_desc; ?>">
                                                            Status<i class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i>
                                                        </a>
                                                    </th>
                                                    <th class="min-w-125px">Action</th>
                                                </tr>
                                            </thead>
                                            <!--Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                <?php
                                                $query = "select * from compliant_details INNER JOIN Basic_Employee on compliant_details.on_behalf_of=Basic_Employee.Id_employee
                                                INNER JOIN Basic_Customer on compliant_details.customer_id=Basic_Customer.Id_customer
                                                ";
                                                $compliant_details = mysqli_query($con, $query);
                                                while ($compliant_detail = mysqli_fetch_assoc($compliant_details)) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $compliant_detail['id']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $compliant_detail['First_Name'] . " " . $compliant_detail['Last_Name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $compliant_detail['Customer_Name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $compliant_detail['orderrefnumber']; ?>
                                                        </td>
                                                        <td>
                                                            <!-- <?php echo $compliant_detail['orderrefnumber']; ?> -->
                                                        </td>
                                                        <td>
                                                            <?php echo $compliant_detail['owner']; ?>
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-light-warning">
                                                                open
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a data-id='<?php echo $result_data['id']; ?>' target="_blank" class="me-3 print-compliant">
                                                                <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="customer_complaint_edit.php?id=<?php echo $result_data['id']; ?>" class="me-3">
                                                                <i class="bi bi-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="customer_complaint_edit.php?id=<?php echo $result_data['id']; ?>" class="me-3">
                                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                                            </a>
                                                            <?php if ($role == 1) { ?>
                                                                <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'includes/footer.php'; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/scrolltop.php'; ?>
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
    <!--end::Page Custom Javascript-->
    <!-- begin HTML2PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <!-- end HTML2PDF -->
    <script>
        $('.print-compliant').on('click', function() {
            let id = $(this).data('id');

            $.get(`/includes/compliant_pdf.php?id=${id}`, function(data) {
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
                let worker = html2pdf().set(opt).from(data).save(id);
            });

        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->


</html>