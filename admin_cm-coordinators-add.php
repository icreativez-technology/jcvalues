<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Inspection Coordinator";
/*$documetancion = scandir('/var/www/vhosts/nivelz.biz/dqms.nivelz.biz/documentacion');
 unset($documetancion[array_search('.', $documetancion, true)]);
 unset($documetancion[array_search('..', $documetancion, true)]);*/
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
                            <p><a href="/">Home</a> » <a href="/admin-panel.php">Admin Panel</a> » <a
                                    href="/admin_cm-panel.php">Customer Management Basic Settings</a> » <a
                                    href="/admin_cm-coordinators.php">Inspection Coordinator</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
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
												<div class="card-toolbar">
													<div class="example-tools justify-content-center">
														<span class="example-toggle" data-toggle="tooltip" title="" data-original-title="View code"></span>
														<span class="example-copy" data-toggle="tooltip" title="" data-original-title="Copy code"></span>
													</div>
												</div>
											</div> -->
                            <!--begin::Form-->
                            <form class="form" action="includes/basicsettings_cm-coordinators_add.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>Employee:</label>
                                            <select class="form-control" name="employee" required>
                                                <?php
												$sql_data = "SELECT * FROM Basic_Employee";
												$connect_data = mysqli_query($con, $sql_data);

												while ($result_data = mysqli_fetch_assoc($connect_data)) {

													$sql_datos_co = "SELECT * FROM Customer_Inspection_Co_Ordinator WHERE Id_employee = '$result_data[Id_employee]'";
													$connect_data2 = mysqli_query($con, $sql_datos_co);
													$result_data2 = mysqli_fetch_assoc($connect_data2);

													/*Check if user is already Inspection Coordinator, then 0. If not, then 1 and is printed in select*/
													if ($result_data2) {
														$iscoord = 0;
													} else {
														$iscoord = 1;
													}

													/*Also, only print active users*/
													if ($result_data['Status'] == 'Active' && $iscoord == 1) {
												?>
                                                <option value="<?php echo $result_data['Id_employee']; ?>">
                                                    <?php echo $result_data['Custom_ID']; ?> ~
                                                    <?php echo $result_data['First_Name']; ?>
                                                    <?php echo $result_data['Last_Name']; ?></option>
                                                <?php
													}
												}
												?>

                                            </select>
                                        </div>

                                    </div>



                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div style="text-align: right;"><input type="submit"
                                                class="btn btn-sm btn-success m-3" value="Save"><a type="button"
                                                href="/admin_cm-coordinators.php"
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