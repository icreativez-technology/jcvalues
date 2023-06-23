<?php
session_start();
include('includes/functions.php');

$_SESSION['Page_Title'] = "View File";
$url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

$name_file_explode = explode("?", $url);
$name_file = rawurlencode($name_file_explode[1]);


$sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks, Category From Document WHERE File LIKE '$name_file'";
$conect_datos_document = mysqli_query($con, $sql_datos_document);
$result_datos_document = mysqli_fetch_assoc($conect_datos_document);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->

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
                            <p><a href="/">Home</a> » <a href="/documentation.php">Documentation</a> » <a
                                    href="/documentation-view-folder.php?name=<?php echo $result_datos_document['Category'] ?>"><?php echo $result_datos_document['Category'] ?></a>
                                » <?php echo $_SESSION['Page_Title'];
                                    echo $name_file; ?></p>
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
                            <div class="card-header">
                                <h3 class="card-title"><?php echo $result_datos_document['File']; ?></h3>
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

                            <div class="card-body">
                                <div class="form-group row mt-3">
                                    <div class="col-lg-4">
                                        <label>Title of the document:</label>
                                        <input class="form-control" type="text" name="Title_of_the_document"
                                            value="<?php echo $result_datos_document['Title_of_the_document']; ?>"
                                            disabled>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Document No:</label>
                                        <input class="form-control" type="text" name="Format_No"
                                            value="<?php echo $result_datos_document['Format_No']; ?>" disabled>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Rev No:</label>
                                        <input class="form-control" type="text" name="Rev_No"
                                            value="<?php echo $result_datos_document['Rev_No']; ?>" disabled>
                                        <p></p>
                                    </div>

                                </div>

                                <div class="form-group row mt-3">
                                    <div class="col-lg-4">
                                        <label>Prepared by:</label>
                                        <?php

                                        $id_prepared_by = $result_datos_document['Prepared_by'];
                                        $consulta_prepared_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_prepared_by";
                                        $consulta_general_prepared_by = mysqli_query($con, $consulta_prepared_by);
                                        $result_prepared_by = mysqli_fetch_assoc($consulta_general_prepared_by);
                                        ?>
                                        <input class="form-control" type="text" name="Prepared_by"
                                            value="<?php echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name']; ?>"
                                            disabled>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Reviewd by:</label>
                                        <?php
                                        $id_reviewd_by = $result_datos_document['Reviewd_by'];
                                        $consulta_reviewd_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_reviewd_by";
                                        $consulta_general_reviewd_by = mysqli_query($con, $consulta_reviewd_by);
                                        $result_reviewd_by = mysqli_fetch_assoc($consulta_general_reviewd_by);
                                        ?>
                                        <input class="form-control" type="text" name="Reviewd_by"
                                            value="<?php echo $result_reviewd_by['First_Name'] . ' ' . $result_reviewd_by['Last_Name']; ?>"
                                            disabled>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Approved by:</label>
                                        <?php
                                        $id_approved_by = $result_datos_document['Approved_by'];
                                        $consulta_approved_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_approved_by";
                                        $consulta_general_approved_by = mysqli_query($con, $consulta_approved_by);
                                        $result_approved_by = mysqli_fetch_assoc($consulta_general_approved_by);
                                        ?>
                                        <input class="form-control" type="text" name="Approved_by"
                                            value="<?php echo $result_approved_by['First_Name'] . ' ' . $result_approved_by['Last_Name'] ?>"
                                            disabled>
                                    </div>

                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-lg-4">
                                        <label>Date of preparation:</label>
                                        <input class="form-control" type="text" name="Date_of_preparation"
                                            value="<?php echo date("d-m-y", strtotime($result_datos_document['Date_of_preparation'])); ?>"
                                            disabled>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Date of revision:</label>
                                        <input class="form-control" type="text" name="Date_of_revision"
                                            value="<?php echo date("d-m-y", strtotime($result_datos_document['Date_of_revision'])); ?>"
                                            disabled>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Date of approval:</label>
                                        <input class="form-control" type="text" name="Date_of_approval"
                                            value="<?php echo date("d-m-y", strtotime($result_datos_document['Date_of_approval'])); ?>"
                                            disabled>
                                    </div>

                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-lg-6">
                                        <label>Document category:</label>
                                        <input class="form-control" type="text" name="Category"
                                            value="<?php echo $result_datos_document['Category']; ?>" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="Remarks" rows="2"
                                            disabled><?php echo $result_datos_document['Remarks']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="card-footer">
													<div class="row">
														
															<input type="submit" class="btn btn-sm btn-success m-3" value="Update">
														
													</div>
												</div>-->

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