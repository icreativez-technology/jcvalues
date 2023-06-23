<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Edit Product Type";

$productTypeQuery = "SELECT product_type, status FROM  product_types WHERE id = '$_REQUEST[id]'";
$productTypeConData = mysqli_query($con, $productTypeQuery);
$productTypeResultData = mysqli_fetch_assoc($productTypeConData);

$componentSql = "SELECT * FROM components WHERE Status = '1'";
$componentData = mysqli_query($con, $componentSql);
$componentArr =  array();
while ($row = mysqli_fetch_assoc($componentData)) {
    array_push($componentArr, $row);
}

$componentQuery = "SELECT component_id FROM  product_type_component WHERE mandatory=1 AND product_type_id = '$_REQUEST[id]'";
$componentConData = mysqli_query($con, $componentQuery);
$mandatoryArr = array();
while ($row = mysqli_fetch_assoc($componentConData)) {
    array_push($mandatoryArr, $row);
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
                <div class="breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <!--begin::Title-->
                        <div>
                            <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#admin-menu-modal">Admin Panel</a> » <a class="cursor-pointer"
                                    data-bs-toggle="modal" data-bs-target="#admin-menu-modal">Product Configuration</a>
                                » <a href="/product-type.php">Product Type</a> » <?php echo $_SESSION['Page_Title']; ?>
                            </p>
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
                            <div class="card-header mt-2">
                                <h3 class="card-title"><?php echo $_SESSION['Page_Title']; ?></h3>
                            </div>
                            <!--begin::Form-->
                            <form class="form" action="includes/product-type-update.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" readonly>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Product Type</label>
                                            <input type="text" class="form-control" name="product_type"
                                                value="<?php echo $productTypeResultData['product_type']; ?>" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The product type name has already been
                                                taken</small>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Status:</label>
                                            <select class="form-control" name="status" required>
                                                <?php if ($productTypeResultData['status'] == '1') { ?>
                                                <option value="1" selected="selected">Active</option>
                                                <option value="0">Suspended</option>
                                                <?php } else { ?>
                                                <option value="1">Active</option>
                                                <option value="0" selected="selected">Suspended</option>
                                                <?php } ?>
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
                                                multiple>
                                                <?php
                                                $sql_data = "SELECT * FROM models WHERE Status = '1'";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                $modelIds = array();
                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    $flag_em = 0;
                                                    $modelQuery = "SELECT * FROM  product_type_model WHERE product_type_id = '$_REQUEST[id]'";
                                                    $modelConData = mysqli_query($con, $modelQuery);
                                                    while ($result = mysqli_fetch_assoc($modelConData)) {

                                                        if ($result_data['id'] == $result['model_id']) {
                                                            $flag_em = 1;
                                                        }
                                                    }
                                                    if ($flag_em == 1) {
                                                ?>
                                                <option value="<?php echo $result_data['id']; ?>" selected>
                                                    <?php echo $result_data['model']; ?></option>
                                                <?php
                                                    } else {
                                                    ?>
                                                <option value="<?php echo $result_data['id']; ?>">
                                                    <?php echo $result_data['model']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Components:</label>
                                            <input type="hidden" name="dataArr" id="dataArr"
                                                value='<?php echo json_encode($componentArr) ?>'>
                                            <input type="hidden" name="mandatoryArr" id="mandatoryArr"
                                                value='<?php echo json_encode($mandatoryArr) ?>'>
                                            <select class="form-select form-select-solid select2-hidden-accessible mt-2"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Components" name="components[]"
                                                data-select2-id="select2-data-7-oqww-group1" tabindex="-1"
                                                id="components" aria-hidden="true" Multiple>
                                                <option></option>
                                                <?php

                                                $sql_data_component = "SELECT * FROM components WHERE Status = '1'";
                                                $connect_data_component = mysqli_query($con, $sql_data_component);
                                                while ($result_data = mysqli_fetch_assoc($connect_data_component)) {
                                                    $isComponent = 0;
                                                    $componentQuery = "SELECT component_id FROM  product_type_component WHERE product_type_id = '$_REQUEST[id]'";
                                                    $componentConData = mysqli_query($con, $componentQuery);
                                                    while ($result = mysqli_fetch_assoc($componentConData)) {
                                                        if ($result_data['id'] == $result['component_id']) {
                                                            $isComponent = 1;
                                                        }
                                                    }
                                                    if ($isComponent == 1) {
                                                ?>
                                                <option value="<?php echo $result_data['id']; ?>" selected>
                                                    <?php echo $result_data['component']; ?></option>
                                                <?php
                                                    } else {
                                                    ?>
                                                <option value="<?php echo $result_data['id']; ?>">
                                                    <?php echo $result_data['component']; ?></option>
                                                <?php
                                                    }
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
                                                data-select2-id="select2-data-7-oqww-group2" tabindex="-1"
                                                id="mandatory_components" aria-hidden="true" required="true" Multiple>
                                                <?php

                                                $sql_data_component = "SELECT * FROM components WHERE Status = '1'";
                                                $connect_data_component = mysqli_query($con, $sql_data_component);
                                                while ($result_data = mysqli_fetch_assoc($connect_data_component)) {
                                                    $isComponent = 0;
                                                    $componentQuery = "SELECT component_id FROM  product_type_component WHERE mandatory=1 AND product_type_id = '$_REQUEST[id]'";
                                                    $componentConData = mysqli_query($con, $componentQuery);
                                                    while ($result = mysqli_fetch_assoc($componentConData)) {
                                                        if ($result_data['id'] == $result['component_id']) {
                                                            $isComponent = 1;
                                                        }
                                                    }
                                                    if ($isComponent == 1) {
                                                ?>
                                                <option value="<?php echo $result_data['id']; ?>" selected>
                                                    <?php echo $result_data['component']; ?></option>
                                                <?php
                                                    } else {
                                                    ?>
                                                <option value="<?php echo $result_data['id']; ?>">
                                                    <?php echo $result_data['component']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
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
                                                multiple>
                                                <?php
                                                $sql_designStd_data = "SELECT * FROM design_standards WHERE Status = '1'";
                                                $connect_designStd__data = mysqli_query($con, $sql_designStd_data);
                                                while ($result_data = mysqli_fetch_assoc($connect_designStd__data)) {
                                                    $isDesignStd = 0;
                                                    $designStdQuery = "SELECT * FROM  product_type_design_std WHERE product_type_id = '$_REQUEST[id]'";
                                                    $designStdConData = mysqli_query($con, $designStdQuery);

                                                    while ($result = mysqli_fetch_assoc($designStdConData)) {
                                                        if ($result_data['id'] == $result['design_std_id']) {
                                                            $isDesignStd = 1;
                                                        }
                                                    }
                                                    if ($isDesignStd == 1) {
                                                ?>
                                                <option value="<?php echo $result_data['id']; ?>" selected>
                                                    <?php echo $result_data['design_standard']; ?></option>
                                                <?php
                                                    } else {
                                                    ?>
                                                <option value="<?php echo $result_data['id']; ?>">
                                                    <?php echo $result_data['design_standard']; ?></option>
                                                <?php
                                                    }
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
                                                aria-hidden="true" Multiple>
                                                <?php
                                                $sql_data_testingStd = "SELECT * FROM testing_standards WHERE Status = '1'";
                                                $connect_data_Product_Group = mysqli_query($con, $sql_data_testingStd);

                                                while ($result_data = mysqli_fetch_assoc($connect_data_Product_Group)) {
                                                    $isTestingStd = 0;
                                                    $testingStdQuery = "SELECT * FROM  product_type_testing_std WHERE product_type_id = '$_REQUEST[id]'";
                                                    $testingStdConData = mysqli_query($con, $testingStdQuery);

                                                    while ($result = mysqli_fetch_assoc($testingStdConData)) {
                                                        if ($result_data['id'] == $result['testing_std_id']) {
                                                            $isTestingStd = 1;
                                                        }
                                                    }
                                                    if ($isTestingStd == 1) {
                                                ?>
                                                <option value="<?php echo $result_data['id']; ?>" selected>
                                                    <?php echo $result_data['testing_standard']; ?></option>
                                                <?php
                                                    } else {
                                                    ?>
                                                <option value="<?php echo $result_data['id']; ?>">
                                                    <?php echo $result_data['testing_standard']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="p-2" style="float:right">
                                                <br />
                                                <button type="submit" class="btn btn-sm btn-success m-3">
                                                    Update</button>
                                                <a type="button" href="/product-type.php"
                                                    class="btn btn-sm btn-danger">Cancel</a>

                                            </div>
                                        </div>
                                    </div>
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
        let componentArr = JSON.parse($('#dataArr').val());
        let mandatoryArr = JSON.parse($('#mandatoryArr').val());
        $(document).ready(function() {
            let mandatoryComponents = mandatoryArr.map(function(elem) {
                return elem.component_id
            })
            $('#mandatory_components').empty();
            componentArr.map(function(item) {
                if (mandatoryComponents.includes(item?.id)) {
                    $('#mandatory_components').append(
                        `<option value="${item?.id}" selected>${item?.component}</option>`);
                }
            })
        });

        $('#components').on('change', function() {
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