<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Product Type";
/*$documetancion = scandir('/var/www/vhosts/nivelz.biz/dqms.nivelz.biz/documentacion');
 unset($documetancion[array_search('.', $documetancion, true)]);
 unset($documetancion[array_search('..', $documetancion, true)]);*/

$componentSql = "SELECT * FROM components WHERE Status = '1'";
$componentData = mysqli_query($con, $componentSql);
$componentArr =  array();
while ($row = mysqli_fetch_assoc($componentData)) {
	array_push($componentArr, $row);
}
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
                                    href="/product-configuration.php">Product Configuration</a> » <a
                                    href="/product-type.php">Product Type Management</a> »
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
                                        <span class="example-toggle" data-toggle="tooltip" title=""
                                            data-original-title="View code"></span>
                                        <span class="example-copy" data-toggle="tooltip" title=""
                                            data-original-title="Copy code"></span>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Form-->
                            <form class="form" action="includes/basicsettings_product_type_add.php" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="dataArr" id="dataArr"
                                    value='<?php echo json_encode($componentArr) ?>'>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Title:</label>
                                            <input type="text" class="form-control" name="title" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The product type name has already been
                                                taken</small>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Status:</label>
                                            <select class="form-control" name="status" required>
                                                <option value="1" selected="selected">Active</option>
                                                <option value="0">Suspended</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-lg-6">
                                            <label>Models:</label>
                                            <select class="form-select form-select-solid select2-hidden-accessible mt-2"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Models" name="models[]"
                                                data-select2-id="select2-data-7-oqww1" tabindex="-1" aria-hidden="true"
                                                required="true" multiple>
                                                <?php
												$sql_data = "SELECT * FROM models WHERE Status = '1'";
												$connect_data = mysqli_query($con, $sql_data);
												while ($result_data = mysqli_fetch_assoc($connect_data)) {

												?>
                                                <option value="<?php echo $result_data['id']; ?>">
                                                    <?php echo $result_data['model']; ?></option>
                                                <?php
												}
												?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Components:</label>
                                            <select class="form-select form-select-solid select2-hidden-accessible mt-2"
                                                id="components" data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Components" name="components[]"
                                                data-select2-id="select2-data-7-oqww-group1" tabindex="-1"
                                                aria-hidden="true" required="true" Multiple>
                                                <option></option>
                                                <?php
												$sql_data_Product_Group = "SELECT * FROM components WHERE Status = '1'";
												$connect_data_Product_Group = mysqli_query($con, $sql_data_Product_Group);

												while ($result_data_Product_Group = mysqli_fetch_assoc($connect_data_Product_Group)) {

												?>
                                                <option value="<?php echo $result_data_Product_Group['id']; ?>">
                                                    <?php echo $result_data_Product_Group['component']; ?></option>
                                                <?php
												}
												?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-lg-6">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Mandatory Components:</label>
                                            <select class="form-select form-select-solid select2-hidden-accessible mt-2"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Mandatory Components" name="components2[]"
                                                id="mandatory_components" data-select2-id="select2-data-7-oqww-group2"
                                                tabindex="-1" aria-hidden="true" required="true" Multiple>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-2">
                                        <div class="col-lg-6">
                                            <label>Design Standards:</label>
                                            <select class="form-select form-select-solid select2-hidden-accessible mt-2"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Design Standards" name="design_standards[]"
                                                data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true"
                                                required="true" multiple>
                                                <?php
												$sql_data = "SELECT * FROM design_standards WHERE Status = '1'";
												$connect_data = mysqli_query($con, $sql_data);
												while ($result_data = mysqli_fetch_assoc($connect_data)) {

												?>
                                                <option value="<?php echo $result_data['id']; ?>">
                                                    <?php echo $result_data['design_standard']; ?></option>
                                                <?php
												}
												?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Testing Standards:</label>
                                            <select class="form-select form-select-solid select2-hidden-accessible mt-2"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Testing Standards" name="testing_standards[]"
                                                data-select2-id="select2-data-7-oqww-group" tabindex="-1"
                                                aria-hidden="true" required="true" Multiple>
                                                <option></option>
                                                <?php
												$sql_data_Product_Group = "SELECT * FROM testing_standards WHERE Status = '1'";
												$connect_data_Product_Group = mysqli_query($con, $sql_data_Product_Group);

												while ($result_data_Product_Group = mysqli_fetch_assoc($connect_data_Product_Group)) {

												?>
                                                <option value="<?php echo $result_data_Product_Group['id']; ?>">
                                                    <?php echo $result_data_Product_Group['testing_standard']; ?>
                                                </option>
                                                <?php
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--<div class="form-group row">
														<div class="col-lg-6">
															<label>Created:</label>
															<input type="date" class="form-control" name="created">
														</div>	
														<div class="col-lg-6">
															<label>Modified:</label>
															<input type="date" class="form-control" name="modified">
														</div>										
													</div>-->


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
    <script>
    $('#components').on('change', function() {
        let componentArr = JSON.parse($('#dataArr').val());
        let actualComponents = $(this).val();
        $('#mandatory_components').empty();
        componentArr.map(function(item) {
            if (actualComponents.includes(item?.id)) {
                $('#mandatory_components').append(
                    `<option value="${item?.id}">${item?.component}</option>`);
            }
        })
    })
    </script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>