<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Edit Audit Standard";
$auditStandardQuery = "SELECT * FROM  audit_standard WHERE Id_audit_standard = '$_REQUEST[id]'";
$auditStandardConData = mysqli_query($con, $auditStandardQuery);
$auditStandardResultData = mysqli_fetch_assoc($auditStandardConData);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>

<!--begin::Body-->
<style>
.icon-view {
    background-color: #e4e6ef;
    display: inline-block;
    position: absolute;
    right: 0px;
    top: 0px;
    padding: 9px;
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
    color: #009ef7;
}

.icon-upload {
    background-color: #e4e6ef;
    display: inline-block;
    position: absolute;
    right: 33px;
    top: 0px;
    padding: 9px;
    color: #009ef7;
    border-right: 1px solid #d8d5d5;
    cursor: pointer;
}

.view-pdf {
    position: relative;
}
</style>

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
                                    href="/admin_audit-panel.php">Audit</a> » <a href="/admin_audit-standard.php">Audit
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
                            <form class="form" action="includes/basicsettings_audit-standard_edit.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <input type="hidden" name="id"
                                            value="<?php echo $auditStandardResultData['Id_audit_standard'] ?>">
                                        <div class="col-md-6">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="title"
                                                value="<?php echo $auditStandardResultData['Title'] ?>" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The audit standard name has already been
                                                taken</small>
                                            <?php } ?>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="hidden" name="oldFile"
                                                value="<?php echo $auditStandardResultData['Attachment'] ?>">
                                            <label>Attachement</label>
                                            <div class="form-group view-pdf">
                                                <input type="file" name="file" id="original-file" style="display:none ;"
                                                    onchange='uploadFile(this)' accept=".pdf, .jpg, .jpeg">
                                                <label class="icon-upload" for="original-file"><i class="fa fa-upload"
                                                        style="color:#009ef7"></i></label>
                                                <a class="icon-view"
                                                    href="./audit-standard-attachments/<?php echo $auditStandardResultData['Attachment'] ?>"
                                                    target="_blank"><i class="fa fa-eye" style="color:#009ef7"></i></a>
                                                <input type="text" class="form-control" id="original-label"
                                                    value="<?php echo basename($auditStandardResultData['Attachment'], ".php") . PHP_EOL  ?>"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>Status:</label>
                                            <select class="form-control" name="status" required>
                                                <?php if ($auditStandardResultData['Status'] == '1') { ?>
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
                                                href="/admin_audit-standard.php"
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
    <script>
    function uploadFile(target) {
        document.getElementById("original-label").value = target.files[0].name;
    }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>