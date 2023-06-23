<?php
session_start();
include('includes/functions.php');
$getDataQuery = "SELECT * FROM context_analysis WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $getDataQuery);
$resultData = mysqli_fetch_assoc($connectData);
$sql = "SELECT * From Basic_Employee Where Id_employee = $resultData[created_by]";
$fetch = mysqli_query($con, $sql);
$createdInfo = mysqli_fetch_assoc($fetch);
$sql = "SELECT * From Basic_Employee Where Id_employee = $resultData[approved_by]";
$fetch = mysqli_query($con, $sql);
$approvedInfo = mysqli_fetch_assoc($fetch);
$listSqlData = "SELECT * FROM context_analysis_list WHERE is_deleted = 0 AND context_analysis_id = '$_REQUEST[id]'";
$listData = mysqli_query($con, $listSqlData);
$lists =  array();
while ($row = mysqli_fetch_assoc($listData)) {
    array_push($lists, $row);
}
$_SESSION['Page_Title'] = "View Context Analysis - " . $resultData['year'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
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
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/context-analysis.php">Context Analysis</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                    <!--end::body-->
                </div>
                <!--end::BREADCRUMBS-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush">
                            <div class="card-body">
                                <div id="custom-section-1">
                                    <div class="form-group row">
                                        <div class="col-lg-3 mt-5">
                                            <label class="required">Year</label>
                                            <input type="number" class="form-control"
                                                value="<?php echo $resultData['year'] ?>" disabled>
                                        </div>
                                        <div class="col-lg-3 mt-5">
                                            <label class="required">Revision</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $resultData['revision'] ?>" disabled>
                                        </div>
                                        <div class="col-lg-3 mt-5">
                                            <label class="required">Created By</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $createdInfo['First_Name'] . ' ' . $createdInfo['Last_Name']; ?>"
                                                disabled>
                                        </div>
                                        <div class="col-lg-3 mt-5">
                                            <label class="required">Approved By</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $approvedInfo['First_Name'] . ' ' . $approvedInfo['Last_Name']; ?>"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <table class="table table-row-dashed fs-6 gy-5">
                                            <thead>
                                                <tr class="text-start text-muted text-uppercase gs-0">
                                                    <th class="min-w-225px">
                                                        Strength</th>
                                                    <th class="min-w-225px ">
                                                        Weakness</th>
                                                    <th class="min-w-225px">
                                                        Opportunities</th>
                                                    <th class="min-w-225px">
                                                        Threats</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600 fw-bold" id="list-table">
                                                <?php if ($lists && count($lists) > 0) {
                                                    foreach ($lists as $key => $list) { ?>
                                                <tr>
                                                    <td><input type="text" class="form-control"
                                                            value="<?php echo $list['strength']; ?>" disabled></td>
                                                    <td><input type="text" class="form-control"
                                                            value="<?php echo $list['weakness']; ?>" disabled></td>
                                                    <td><input type="text" class="form-control"
                                                            value="<?php echo $list['opportunities']; ?>" disabled></td>
                                                    <td><input type="text" class="form-control"
                                                            value="<?php echo $list['threats']; ?>" disabled></td>
                                                </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row" style="text-align:center; float:right;">
                                    <div class="mb-4">
                                        <a type="button" href="/context-analysis.php"
                                            class="btn btn-sm btn-secondary ms-2">Close</a>
                                    </div>
                                </div>
                            </div>
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