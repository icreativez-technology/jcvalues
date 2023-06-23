<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Customer";
/*$documetancion = scandir('/var/www/vhosts/nivelz.biz/dqms.nivelz.biz/documentacion');
 unset($documetancion[array_search('.', $documetancion, true)]);
 unset($documetancion[array_search('..', $documetancion, true)]);*/

$locationSql = "SELECT * FROM tbl_Countries";
$locationConnect = mysqli_query($con, $locationSql);
$locations = mysqli_fetch_all($locationConnect, MYSQLI_ASSOC);
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
                            <form class="form" action="includes/basicsettings_customers_add.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">

                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="required">Customer Id:</label>
                                            <input type="text" class="form-control capitalCase" name="Customer_Id"
                                                required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Customer Name:</label>
                                            <input type="text" class="form-control capitalCase" name="Customer_Name"
                                                required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Address:</label>
                                            <input type="text" class="form-control capitalCase" name="Address" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Location:</label>
                                            <select class="form-control" name="Country_of_Origin" required>
                                                <option selected="selected" value="">Please Select</option>
                                                <?php foreach ($locations as $location) { ?>
                                                <option value="<?php echo $location['CountryID']; ?>">

                                                    <?php echo $location['CountryName'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label>Parent Company:</label>
                                            <input type="text" class="form-control" name="Parent_Company">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Primary Contact Person:</label>
                                            <input type="text" class="form-control capitalCase"
                                                name="Primary_Contact_Person" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Email:</label>
                                            <input type="email" class="form-control" name="Email" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Secondary Contact Person:</label>
                                            <input type="text" class="form-control capitalCase"
                                                name="Secondary_Contact_Person">
                                        </div>

                                    </div>
                                    <div class="row mt-2 mt-3">
                                        <div class="col-lg-3">
                                            <label class="required">Status:</label>
                                            <select class="form-control" name="Status" required>
                                                <option selected="selected">Active</option>
                                                <option>Suspended</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <div style="text-align: right;"><input type="submit"
                                                class="btn btn-sm btn-success m-3" value="Save"><a type="button"
                                                href="/admin_customers-panel.php"
                                                class="btn btn-sm btn-danger">Cancel</a>
                                        </div>
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
    <script>
    $('.capitalCase').on('keyup', function() {
        console.log("hdj")
        return $(this).val($(this).val().toUpperCase());
    });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>