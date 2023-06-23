<?php
session_start();
include('includes/functions.php');
$sqlData = "SELECT * FROM admin_audit_standard WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$data = mysqli_fetch_assoc($connectData);

$auditorsSqlData = "SELECT * FROM admin_audit_standard_auditors WHERE admin_audit_standard_id = '$data[id]' AND is_deleted = 0";
$auditorsSqlConnect = mysqli_query($con, $auditorsSqlData);
$auditors =  array();
while ($row = mysqli_fetch_assoc($auditorsSqlConnect)) {
    array_push($auditors, $row['member_id']);
}
$_SESSION['Page_Title'] = "Edit Audit Standard";
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>

<!--begin::Body-->
<style>
.required::after {
    content: "*";
    color: #e1261c;
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
                            <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#admin-menu-modal">Admin Panel</a> » <a class="cursor-pointer"
                                    data-bs-toggle="modal" data-bs-target="#admin-menu-modal">Audit</a> » <a
                                    href="/admin_audit_standard.php">Audit
                                    Standard List</a> »
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
                        <div class="card card-custom gutter-b example example-compact">
                            <form class="form" action="includes/admin_audit_standard_update.php" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" class="form-control" name="id" value="<?php echo $data['id']; ?>">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label class="required">Audit Type</label>
                                            <input type="text" class="form-control" name="audit_type" value="Internal"
                                                disabled>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="required">Audit Standard</label>
                                            <input type="text" class="form-control" name="audit_standard" required
                                                value="<?php echo $data['audit_standard']; ?>">
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The audit standard name has already been
                                                taken</small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-12">
                                            <label class="required">Auditor</label>
                                            <select class="form-control form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Auditors" name="auditors[]"
                                                data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true"
                                                required multiple>
                                                <?php
                                                $sql_data = "SELECT * FROM Basic_Employee";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    if ($result_data['Status'] == 'Active') {
                                                ?>
                                                <option value="<?php echo $result_data['Id_employee']; ?>"
                                                    <?php echo (in_array($result_data['Id_employee'], $auditors)) ? 'selected' : ''; ?>>
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
                                <div class="p-4">
                                    <div class="row">
                                        <div style="text-align: right;"><input type="submit"
                                                class="btn btn-sm btn-success m-3" value="Update"><a type="button"
                                                href="/admin_audit_standard.php"
                                                class="btn btn-sm btn-danger">Cancel</a></div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
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