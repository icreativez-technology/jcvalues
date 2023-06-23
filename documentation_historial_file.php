<?php
session_start();
include('includes/functions.php');

$_SESSION['Page_Title'] = "History";

$url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$name_file_explode = explode("?", $url);
$name_file = $name_file_explode[1];

$sql_id_document = "SELECT Id_document, Category From Document WHERE File LIKE '$name_file'";
$conect_id_document = mysqli_query($con, $sql_id_document);
$result_id_document = mysqli_fetch_assoc($conect_id_document);
$Id_document = $result_id_document['Id_document'];

$sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks, Id_document From Document_historial WHERE Id_document = $Id_document ORDER BY `Document_historial`.`Id_Document_historial` DESC";
$conect_datos_document = mysqli_query($con, $sql_datos_document);

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
                                    href="/documentation-view-folder.php?name=<?php echo $result_id_document['Category'] ?>"><?php echo $result_id_document['Category'] ?></a>
                                »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                            <!-- MIGAS DE PAN -->
                        </div>
                    </div>
                    <!--end::body-->
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom ">
                        <div class="card card-flush">
                            <div class='card-body'>
                                <div class='row mt-4'>
                                    <div class="col-md-12">
                                        <table class='table align-middle table-row-dashed fs-6 gy-5'>
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class='text-start text-gray-400 fw-bold text-uppercase gs-0'>
                                                    <th class='min-w-300px hidde-responsive-j6'>Title of the document
                                                    </th>
                                                    <th class="min-w-10px hidde-responsive-j6">Document No</th>
                                                    <th class="min-w-10px hidde-responsive-j6">Rev No</th>
                                                    <th class="min-w-125px hidde-responsive-j6">Prepared by</th>
                                                    <th class="min-w-10px hidde-responsive-j6">Date Prep.</th>
                                                    <th class=" hidde-responsive-j6">Review by</th>
                                                    <th class="min-w-10px hidde-responsive-j6">Date Rev.</th>
                                                    <th class=" hidde-responsive-j6">Approved by</th>
                                                    <th class="min-w-10px hidde-responsive-j6">Date App.</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>

                                            <tbody class='fw-bold text-gray-600'>
                                                <?php while ($result_datos_document = mysqli_fetch_assoc($conect_datos_document)) { ?>
                                                <tr>

                                                    <td class="hidde-responsive-j6">
                                                        <?php echo $result_datos_document['Title_of_the_document']; ?>
                                                    </td>
                                                    <td class="hidde-responsive-j6">
                                                        <?php echo $result_datos_document['Format_No']; ?>
                                                    </td>

                                                    <td class="hidde-responsive-j6">
                                                        <?php echo $result_datos_document['Rev_No']; ?>
                                                    </td>
                                                    <td class="hidde-responsive-j6">

                                                        <?php
                                                            $Id_employee = $result_datos_document['Prepared_by'];
                                                            $consulta_prepared_by = "SELECT * FROM Basic_Employee WHERE Id_employee = '$Id_employee'";
                                                            $consulta_general_prepared_by = mysqli_query($con, $consulta_prepared_by);
                                                            $result_prepared_by = mysqli_fetch_assoc($consulta_general_prepared_by);
                                                            echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name'];
                                                            ?>

                                                    </td>
                                                    <td class="hidde-responsive-j6">
                                                        <?php echo date("d-m-y", strtotime($result_datos_document['Date_of_preparation'])); ?>
                                                    </td>
                                                    <td class="hidde-responsive-j6">
                                                        <?php
                                                            $Id_employee = $result_datos_document['Reviewd_by'];
                                                            $consulta_review_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $Id_employee";
                                                            $consulta_general_review_by = mysqli_query($con, $consulta_review_by);
                                                            $result_review_by = mysqli_fetch_assoc($consulta_general_review_by);
                                                            echo $result_review_by['First_Name'] . ' ' . $result_review_by['Last_Name'];

                                                            ?>

                                                    </td>
                                                    <td class="hidde-responsive-j6">
                                                        <?php echo date("d-m-y", strtotime($result_datos_document['Date_of_revision'])); ?>
                                                    </td>
                                                    <td class="hidde-responsive-j6">
                                                        <?php
                                                            $Id_employee = $result_datos_document['Approved_by'];
                                                            $consulta_approved_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $Id_employee";
                                                            $consulta_general_approved_by = mysqli_query($con, $consulta_approved_by);
                                                            $result_approved_by = mysqli_fetch_assoc($consulta_general_approved_by);
                                                            echo $result_approved_by['First_Name'] . ' ' . $result_approved_by['Last_Name'];
                                                            ?>
                                                    </td>
                                                    <td class="hidde-responsive-j6">
                                                        <?php echo date("d-m-y", strtotime($result_datos_document['Date_of_approval'])); ?>
                                                    </td>

                                                </tr>
                                                <?php } ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/custom/apps/file-manager/list.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>