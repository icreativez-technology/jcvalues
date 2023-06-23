<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add New Bug Report";

$sql = "SELECT * From report_bug WHERE id = '$_REQUEST[id]'";
$fetch = mysqli_query($con, $sql);
$resultData = mysqli_fetch_assoc($fetch);

$fileSql = "SELECT file_path FROM report_bug_screenshots WHERE report_bug_id = '$_REQUEST[id]' AND is_deleted = 0";
$fileConnectData = mysqli_query($con, $fileSql);
$fileInfo = array();
while ($row = mysqli_fetch_assoc($fileConnectData)) {
    array_push($fileInfo, $row);
}
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
        top: 29px;
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
        top: 29px;
        padding: 9px;
        color: #009ef7;
        border-right: 1px solid #d8d5d5;
        cursor: pointer;
    }

    .icon-delete {
        background-color: #e4e6ef;
        display: inline-block;
        position: absolute;
        right: 65px;
        top: 29px;
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
                            <p><a href="/">Home</a> » <a href="/report-bug.php">Report Bug</a> »
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

                        <div class="card card-custom gutter-b example example-compact mt-5">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo $_SESSION['Page_Title']; ?></h3>
                                <div class="card-toolbar">
                                    <div class="example-tools justify-content-center">
                                        <span class="example-toggle" data-toggle="tooltip" title="" data-original-title="View code"></span>
                                        <span class="example-copy" data-toggle="tooltip" title="" data-original-title="Copy code"></span>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Form-->
                            <form class="form" action="includes/report-bug-update.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" readonly>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Issue Number</label>
                                            <input type="text" class="form-control" value="<?php echo $resultData['issue_number'] ?>" name="issue-number" disabled required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Issue Description</label>
                                            <input type="text" class="form-control" name="issue_description" value="<?php echo $resultData['issue_description'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-lg-6">
                                            <label>Type</label>
                                            <select class="form-control" name="issue-type" required>
                                                <option value="1" <?php echo $resultData['issue_type'] == 1 ? "selected" : ""; ?>>UI
                                                </option>
                                                <option value="2" <?php echo $resultData['issue_type'] == 2 ? "selected" : ""; ?>>
                                                    Functionality</option>
                                                <option value="3" <?php echo $resultData['issue_type'] == 3 ? "selected" : ""; ?>>
                                                    Hotfix</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Priority:</label>
                                            <select class="form-control" name="priority" required>
                                                <option value="1" <?php echo $resultData['priority'] == 1 ? "selected" : ""; ?>>High
                                                </option>
                                                <option value="2" <?php echo $resultData['priority'] == 2 ? "selected" : ""; ?>>Medium
                                                </option>
                                                <option value="3" <?php echo $resultData['priority'] == 3 ? "selected" : ""; ?>>Low
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <input type="hidden" id="deleted-file" name="deleted-file" value="">
                                            <div class="form-group view-pdf" id="screenshots">
                                                <label>Screen Shots</label>
                                                <input type="file" name="files[]" accept="image/*" id="original-file" style="display:none ;" onchange='uploadFile(this)' multiple>
                                                <a class="icon-delete" id="icon-delete"><i class="bi bi-trash" style="color:#009ef7"></i></a>
                                                <label class="icon-upload" for="original-file"><i class="fa fa-upload" style="color:#009ef7"></i></label>
                                                <a class="icon-view" id="icon-view" href="" target="_blank"><i class="fa fa-eye" style="color:#009ef7"></i></a>
                                                <select class="form-control" id="file-view" required>
                                                    <option class="placeholder">Please select </option>
                                                    <?php foreach ($fileInfo as $row => $item) { ?>
                                                        <option value="<?php echo $item['file_path'] ?>">
                                                            <?php echo basename($item['file_path'], ".png, .jpeg, .jpg") . PHP_EOL ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="p-2" style="float:right;">
                                                <button type="submit" class="btn btn-sm btn-success m-3">Save</button>
                                                <a type="button" href="" class="btn btn-sm btn-danger">Cancel</a>
                                            </div>
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
        let deleteArr = new Array();

        $('#file-view').on('change', function() {
            let filePath = $(this).val();
            return $("#icon-view").attr("href", filePath);
        });

        function uploadFile(target) {
            $("#screenshots").find('.temp_option').remove();
            if (target.files.length == 1) {
                $("#file-view").append(`<option class ="temp_option" selected>${target.files[0].name}</option>`);
            } else if (target.files.length > 0) {
                $("#file-view").append(`<option class ="temp_option" selected>${target.files.length} files</option>`);
            }
        }

        $('#icon-delete').on('click', function() {
            sel = document.getElementById('file-view');
            var opt = sel.options[sel.selectedIndex];
            if (opt.className !== 'placeholder') {
                deleteArr.push($('#file-view').val());
                sel.removeChild(opt);
                return $('#deleted-file').val(JSON.stringify(deleteArr));
            }
        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>