<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Edit Plant";
/*$documetancion = scandir('/var/www/vhosts/nivelz.biz/dqms.nivelz.biz/documentacion');
 unset($documetancion[array_search('.', $documetancion, true)]);
 unset($documetancion[array_search('..', $documetancion, true)]);*/

$sql_data = "SELECT Id_plant, Title, Created, Modified, Status FROM Basic_Plant WHERE Id_plant LIKE '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<style>
.required::after {
    content: "*";
    color: #e1261c;
}
</style>

    <?php
    if(isset($_GET['view'])){
    ?>
    <link href="assets/css/form-viewonly.css?ver=4" rel="stylesheet" type="text/css" />
    <?php } ?>

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
                                    href="/admin_plants-panel.php">Plant Management</a> »
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
                            <form class="form" action="includes/basicsettings_plants_update.php" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="pg_id" id="pg_id"
                                    value="<?php echo $result_data['Id_plant']; ?>" readonly>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label class="required">Title</label>
                                            <input type="text" class="form-control" name="title"
                                                value="<?php echo $result_data['Title']; ?>" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The plant name has already been taken</small>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="required">Status</label>
                                            <select class="form-control" name="status" required>
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
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-6">
                                            <label class="required">Departments</label>
                                            <select class="form-control form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Departments" name="Deparment[]"
                                                data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true"
                                                multiple required>
                                                <?php
                                                $sql_data = "SELECT * FROM Basic_Department WHERE Status LIKE 'Active'";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    $flag_em = 0;
                                                    $sql_data_basic_department = "SELECT * FROM Basic_Plant_Deparment WHERE Id_plant = $_REQUEST[pg_id]";

                                                    $connect_data_basic_department = mysqli_query($con, $sql_data_basic_department);

                                                    while ($result_data_basic_department = mysqli_fetch_assoc($connect_data_basic_department)) {

                                                        if ($result_data['Id_department'] == $result_data_basic_department['Id_department']) {
                                                            $flag_em = 1;
                                                        }
                                                    }
                                                    if ($flag_em == 1) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_department']; ?>" selected>
                                                    <?php echo $result_data['Department']; ?></option>
                                                <?php
                                                    } else {
                                                    ?>
                                                <option value="<?php echo $result_data['Id_department']; ?>">
                                                    <?php echo $result_data['Department']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="required">Product Groups</label>
                                            <select class="form-control form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Product Groups" name="product_group[]"
                                                data-select2-id="select2-data-7-oqww-group" tabindex="-1"
                                                aria-hidden="true" multiple required>
                                                <option></option>
                                                <?php
                                                $sql_data = "SELECT * FROM Basic_Product_Group WHERE Status LIKE 'Active'";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    $count_product_group = 0;
                                                    $sql_data_basic_product_group = "SELECT * FROM Basic_Plant_Product_Group WHERE Id_plant = $_REQUEST[pg_id]";

                                                    $connect_data_basic_product_group = mysqli_query($con, $sql_data_basic_product_group);

                                                    while ($result_data_basic_product_group = mysqli_fetch_assoc($connect_data_basic_product_group)) {

                                                        if ($result_data['Id_product_group'] == $result_data_basic_product_group['Id_product_group']) {
                                                            $count_product_group = 1;
                                                        }
                                                    }
                                                    if ($count_product_group == 1) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_product_group']; ?>"
                                                    selected><?php echo $result_data['Title']; ?></option>
                                                <?php
                                                    } else {
                                                    ?>
                                                <option value="<?php echo $result_data['Id_product_group']; ?>">
                                                    <?php echo $result_data['Title']; ?></option>
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
                                                href="/admin_plants-panel.php" class="btn btn-sm btn-danger">Cancel</a>
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
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>