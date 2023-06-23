<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Edit Instrument Condition";
$sqlData = "SELECT title FROM instrument_condition WHERE id LIKE '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$resultData = mysqli_fetch_assoc($connectData);
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
                <!--begin::BREADCRUMBS-->
                <div class="breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <!--begin::Title-->
                        <div>
                            <p><a href="/">Home</a> » <a href="/admin-panel.php">Admin Panel</a> » <a href="/calibrations.php">Calibrations</a> » <a href="/instrument-condition.php">Instrument Condition</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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
                            <div class="card-header mt-2">
                                <h3 class="card-title"><?php echo $_SESSION['Page_Title']; ?></h3>
                            </div>
                            <!--begin::Form-->
                            <form action="includes/instrument-condition-update.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" readonly>
                                <div class="row mt-3 ms-6 mb-6">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Instrument Condition</label>
                                            <input type="text" class="form-control" name="title" value="<?php echo $resultData['title']; ?>" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                                <small class="text-danger">The instrument condition name has already been taken</small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <br />
                                        <button type="submit" class="btn btn-sm btn-success mt-3">Update</button>
                                        <a href="/instrument-condition.php" class="btn btn-sm btn-danger mt-3 ms-2">Cancel</a>
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