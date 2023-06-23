<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Edit Customer";
/*$documetancion = scandir('/var/www/vhosts/nivelz.biz/dqms.nivelz.biz/documentacion');
 unset($documetancion[array_search('.', $documetancion, true)]);
 unset($documetancion[array_search('..', $documetancion, true)]);*/

$sql_data = "SELECT * FROM Basic_Customer WHERE Id_customer = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);

$locationSql = "SELECT * FROM tbl_Countries";
$locationConnect = mysqli_query($con, $locationSql);
$locations = mysqli_fetch_all($locationConnect, MYSQLI_ASSOC);

$disabled = false;
if (isset($_GET['view'])) {
    $disabled = true;
}
?>

<style>
.required::after {
    content: "*";
    color: #e1261c;
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
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <!--begin::Title-->
                        <div>
                            <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#admin-menu-modal">Admin Panel</a> » <a
                                    href="/admin_customers-panel.php">Customer Management</a> »
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
                            <form class="form" action="includes/basicsettings_customers_update.php" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="pg_id" id="pg_id"
                                    value="<?php echo $result_data['Id_customer']; ?>" readonly>
                                <div class="card-body">

                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="required">Customer Id:</label>
                                            <input type="text" class="form-control capitalCase" name="Customer_Id"
                                                value="<?php echo $result_data['Customer_Id']; ?>"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Customer Name:</label>
                                            <input type="text" class="form-control capitalCase" name="Customer_Name"
                                                value="<?php echo $result_data['Customer_Name']; ?>"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Address:</label>
                                            <input type="text" class="form-control capitalCase" name="Address"
                                                value="<?php echo $result_data['Address']; ?>"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Location:</label>
                                            <select class="form-control" name="Country_of_Origin"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                                <option selected="selected" value="">Please Select</option>
                                                <?php foreach ($locations as $location) { ?>
                                                <option value="<?php echo $location['CountryID']; ?>"
                                                    <?php echo $result_data != null && ($location['CountryID'] == $result_data['Country_of_Origin']) ? "selected" : '' ?>>
                                                    <?php echo $location['CountryName'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label>Parent Company:</label>
                                            <input type="text" class="form-control" name="Parent_Company"
                                                value="<?php echo $result_data['Parent_Company']; ?>"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Primary Contact Person:</label>
                                            <input type="text" class="form-control capitalCase"
                                                name="Primary_Contact_Person"
                                                value="<?php echo $result_data['Primary_Contact_Person']; ?>"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Email:</label>
                                            <input type="email" class="form-control" name="Email"
                                                value="<?php echo $result_data['Email']; ?>"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Secondary Contact Person:</label>
                                            <input type="text" class="form-control capitalCase"
                                                name="Secondary_Contact_Person"
                                                value="<?php echo $result_data['Secondary_Contact_Person']; ?>"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                        </div>

                                    </div>
                                    <div class="row mt-2 mt-3">
                                        <div class="col-lg-3">
                                            <label class="required">Status:</label>
                                            <select class="form-control" name="Status"
                                                <?php echo $disabled ? 'disabled' : '' ?> required>
                                                <?php if ($result_data['Status'] == 'Active') { ?>
                                                <option selected="selected">Active</option>
                                                <option>Suspended</option>
                                                <?php } else { ?>
                                                <option>Active</option>
                                                <option selected="selected">Suspended</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <?php if (!$disabled) { ?>
                                    <div class="row">
                                        <div style="text-align: right;"><input type="submit"
                                                class="btn btn-sm btn-success m-3" value="Update"><a type="button"
                                                href="/admin_customers-panel.php"
                                                class="btn btn-sm btn-danger">Cancel</a></div>
                                    </div>
                                    <?php } ?>
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
    <script>
    $('.capitalCase').on('keyup', function() {
        console.log("hdj")
        return $(this).val($(this).val().toUpperCase());
    });
    </script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>