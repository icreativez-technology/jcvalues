<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Edit Penetrant Form";
$sqlData = "SELECT title FROM pt_penetrant_form WHERE id LIKE '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$resultData = mysqli_fetch_assoc($connectData);
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags && CSS -->
<?php include('includes/admin_check.php'); ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>

                <div class="breadcrumbs">
                    <div>
                        <div>
                            <p>
                                <a href="/">Home</a> »
                                <a class="cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#admin-menu-modal">Admin Panel</a> »
                                <a class="cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#admin-menu-modal">Non-Destructive Examination</a> »
                                <a class="cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#admin-menu-modal">Penetrant Test</a> »
                                <a href="/pt-penetrant-form.php">Penetrant Form</a> »
                                <?php echo $_SESSION['Page_Title']; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-custom gutter-b example example-compact">
                            <div class="card-header mt-2">
                                <h3 class="card-title"><?php echo $_SESSION['Page_Title']; ?></h3>
                            </div>
                            <form action="includes/pt-penetrant-form-update.php" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" readonly>
                                <div class="row mt-3 ms-6 mb-6">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Penetrant Type</label>
                                            <input type="text" class="form-control" name="title"
                                                value="<?php echo $resultData['title']; ?>" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The penetrant type name has already been
                                                taken</small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex pt-6">
                                        <br />
                                        <button type="submit" class="btn btn-sm btn-success mt-3"> Update</button>
                                        <a href="/pt-penetrant-form.php"
                                            class="btn btn-sm btn-danger mt-3 ms-2">Cancel</a>
                                    </div>
                                </div>
                            </form>
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
    </script>
    <!--Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>

    <!--Page Vendors Javascript(used by this page)-->
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>

    <!--Page Custom Javascript(used by this page)-->
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
</body>

</html>