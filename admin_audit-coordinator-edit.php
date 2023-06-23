<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Edit Audit Coordinator";
$sql = "SELECT * FROM  audit_co_ordinator WHERE Id_audit_co_ordinator = '$_REQUEST[id]'";
$con_data = mysqli_query($con, $sql);
$result_var = mysqli_fetch_assoc($con_data);
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
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <!--begin::Title-->
                        <div>
                            <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#admin-menu-modal">Admin Panel</a> » <a class="cursor-pointer"
                                    data-bs-toggle="modal" data-bs-target="#admin-menu-modal">Audit</a> » <a
                                    href="/admin_audit-coordinator.php">Audit
                                    Standard</a> » <?php echo $_SESSION['Page_Title']; ?></p>
                            <!-- MIGAS DE PAN -->
                        </div>
                    </div>
                    <!--end::body-->
                </div>
                <!--end::BREADCRUMBS-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">



                        <!-- AQUI AÑADIR EL CONTENIDO  -->

                        <div class="card card-custom gutter-b example example-compact">
                            <!-- <div class="card-header">
												<h3 class="card-title">< ?php echo $_SESSION['Page_Title']; ?></h3>
											</div> -->
                            <!--begin::Form-->
                            <form class="form" action="includes/basicsettings_audit-coordinator_edit.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <input type="hidden" name="id"
                                                value="<?php echo $result_var['Id_audit_co_ordinator'] ?>">
                                            <label>Coordinator</label>
                                            <select class="form-select mt-2" name="coordinator" data-control="select2"
                                                data-placeholder="Select an option" required>
                                                <option>Select an option</option>
                                                <?php
                                                $consulta = "SELECT * FROM Basic_Employee WHERE NOT EXISTS (SELECT audit_co_ordinator.Id_Employee FROM audit_co_ordinator WHERE Basic_Employee.Id_employee = audit_co_ordinator.Id_Employee ) OR Basic_Employee.Id_employee = '$result_var[Id_Employee]'";
                                                $consulta_general = mysqli_query($con, $consulta);
                                                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_employee']; ?>"
                                                    <?php echo ($result_var['Id_Employee'] == $result_data['Id_employee']) ? "selected" : ""; ?>>
                                                    <?php echo $result_data['First_Name'] . ' ' . $result_data['Last_Name']; ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The audit coordinator has already exist</small>
                                            <?php } ?>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Status:</label>
                                            <select class="form-control" name="status" required>
                                                <?php if ($result_var['status'] == '1') { ?>
                                                <option value="1" selected="selected">Active</option>
                                                <option value="0">Suspended</option>
                                                <?php } else { ?>
                                                <option value="1">Active</option>
                                                <option value="0" selected="selected">Suspended</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <div style="text-align: right;"><input type="submit"
                                                class="btn btn-sm btn-success m-3" value="Save"><a type="button"
                                                href="/admin_audit-coordinator.php"
                                                class="btn btn-sm btn-danger">Cancel</a></div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>

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
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>