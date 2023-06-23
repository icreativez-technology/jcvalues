<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add File";
$documetancion = scandir('./document-manager');
unset($documetancion[array_search('.', $documetancion, true)]);
unset($documetancion[array_search('..', $documetancion, true)]);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->

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
                            <p><a href="/">Home</a> » <a href="/documentation.php">Document Management System
                                </a> » <?php echo $_SESSION['Page_Title']; ?></p>
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

                            <!--begin::Form-->
                            <form class="form" action="includes/anadir-documentacion.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Title of the document:</label>
                                            <input type="text" class="form-control" name="title_document"
                                                oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Document No:</label>
                                            <input type="text" class="form-control" name="formatno"
                                                onkeyup="nospaces(this)" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">This Document number already exists</small>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Rev No:</label>
                                            <input type="number" class="form-control" name="revno" required>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Prepared by:</label>
                                            <select class="form-control" name="prep" data-control="select2" required>
                                                <option selected="selected" value="">Select an option</option>
                                                <?php
                                                $consulta_prepared_by = "SELECT * FROM Basic_Employee";
                                                $consulta_general_prepared_by = mysqli_query($con, $consulta_prepared_by);
                                                $empArr = array();
                                                while ($result_prepared_by = mysqli_fetch_assoc($consulta_general_prepared_by)) {
                                                    if ($result_prepared_by['Status'] == 'Active') {
                                                        array_push($empArr, $result_prepared_by);
                                                ?>

                                                <option value="<?php echo $result_prepared_by['Id_employee']; ?>">
                                                    <?php echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name']; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php if (isset($_GET['notUnique'])) { ?>
                                            <small class="text-danger">Prepared by must not be same as reviewed by
                                                and approved by</small>
                                            <?php } ?>
                                        </div>

                                        <div class="col-lg-4 mb-5">
                                            <input type="hidden" id="empArr" value='<?php echo json_encode($empArr) ?>'>
                                            <label class="required">Reviewed by:</label>
                                            <select class="form-control" name="rev" data-control="select2" required>
                                                <option selected="selected" value="">Select an option</option>
                                                <?php
                                                $consulta_reviewd_by = "SELECT * FROM Basic_Employee";
                                                $consulta_general_reviewd_by = mysqli_query($con, $consulta_reviewd_by);
                                                while ($result_reviewd_by = mysqli_fetch_assoc($consulta_general_reviewd_by)) {
                                                    if ($result_reviewd_by['Status'] == 'Active') {
                                                ?>
                                                <option value="<?php echo $result_reviewd_by['Id_employee']; ?>">
                                                    <?php echo $result_reviewd_by['First_Name'] . ' ' . $result_reviewd_by['Last_Name']; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php if (isset($_GET['notUnique'])) { ?>
                                            <small class="text-danger">Reviewed by must not be same as Prepared by
                                                and approved by</small>
                                            <?php } ?>
                                        </div>

                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Approved by:</label>

                                            <select class="form-control" name="approv" data-control="select2" required>
                                                <option selected="selected" value="">Select an option</option>
                                                <?php
                                                $consulta_approved_by = "SELECT * FROM Basic_Employee";
                                                $consulta_general_approved_by = mysqli_query($con, $consulta_approved_by);
                                                while ($result_audit_approved_by = mysqli_fetch_assoc($consulta_general_approved_by)) {
                                                    if ($result_audit_approved_by['Status'] == 'Active') {
                                                ?>
                                                <option value="<?php echo $result_audit_approved_by['Id_employee']; ?>">
                                                    <?php echo $result_audit_approved_by['First_Name'] . ' ' . $result_audit_approved_by['Last_Name']; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php if (isset($_GET['notUnique'])) { ?>
                                            <small class="text-danger">Approved by must not be same as Prepared by
                                                and Reviewed by</small>
                                            <?php } ?>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Date of preparation:</label>
                                            <input type="date" class="form-control" name="date_prep" required>
                                        </div>

                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Date of revision:</label>
                                            <input type="date" class="form-control" name="date_rev" required>
                                        </div>

                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Date of approval:</label>
                                            <input type="date" class="form-control" name="date_approv" required>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Document category:</label>
                                            <select class="form-control" name="category" data-control="select2"
                                                required>
                                                <option selected="selected" value="">Select an option</option>
                                                <?php
                                                foreach ($documetancion as $value) {
                                                ?>
                                                <option><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                            <?php if (isset($_GET['notFolder'])) { ?>
                                            <small class="text-danger">Please select the document category</small>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Upload file (Max: 10MB) </label>
                                            <input type="file" class="form-control"
                                                accept=".doc, .docx, .xls, .xlsx, .pdf" name="file_docu" id="file_docu"
                                                required>
                                            <?php if (isset($_GET['sizeLarge'])) { ?>
                                            <small class="text-danger">The file size should be with in 10 MB</small>
                                            <?php } ?>
                                            <?php if (isset($_GET['fileExist'])) { ?>
                                            <small class="text-danger">The file Already exist</small>
                                            <?php } ?>
                                        </div>

                                        <div class="col-lg-4  mb-5">
                                            <label>Language</label>
                                            <select class="form-control" name="language" data-control="select2"
                                                required>
                                                <option selected="selected" value="0">English</option>
                                                <option value="1">Spanish</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <div>
                                            <label for="exampleTextarea">Remarks</label>
                                            <textarea class="form-control" id="exampleTextarea" name="remarks"
                                                rows="4"></textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="card-footer">
                                    <div class="form-group form-group-button" style="float:right">

                                        <input type="submit" class="btn btn-sm btn-success m-3" value="Save">
                                        <a type="button" href="documentation.php"
                                            class="btn btn-sm btn-danger">Cancel</a>

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
    $('[name = "rev"]').on('change', function() {
        const value = $(this).val();
        const prep = $('[name = "prep"]').val();
        const approv = $('[name = "approv"]').val();

        const filterArr = getFilteredArr(value);

        $('[name = "approv"]').empty().append('<option selected="selected" value="">Select an option</option>');
        $('[name = "prep"]').empty().append('<option selected="selected" value="">Select an option</option>');

        filterArr.map((elem) => {
            isAppovSelected = (elem.Id_employee == approv) ? "selected" : "";
            isPrepSelected = (elem.Id_employee == prep) ? "selected" : "";
            if (prep != elem.Id_employee) {
                $('[name = "approv"]').append(
                    `<option value='${elem.Id_employee}' ${isAppovSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
            if (approv != elem.Id_employee) {
                $('[name = "prep"]').append(
                    `<option value='${elem.Id_employee}' ${isPrepSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
        });

    })

    $('[name = "prep"]').on('change', function() {
        const value = $(this).val();
        const approv = $('[name = "approv"]').val();
        const rev = $('[name = "rev"]').val();

        const filterArr = getFilteredArr(value);

        $('[name = "approv"]').empty().append('<option selected="selected" value="">Select an option</option>');
        $('[name = "rev"]').empty().append('<option selected="selected" value="">Select an option</option>');

        filterArr.map((elem) => {
            isAppovSelected = (elem.Id_employee == approv) ? "selected" : "";
            isRevSelected = (elem.Id_employee == rev) ? "selected" : "";
            if (rev != elem.Id_employee) {
                $('[name = "approv"]').append(
                    `<option value='${elem.Id_employee}' ${isAppovSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
            if (approv != elem.Id_employee) {
                $('[name = "rev"]').append(
                    `<option value='${elem.Id_employee}' ${isRevSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
        });

    });

    $('[name = "approv"]').on('change', function() {
        const value = $(this).val();
        const prep = $('[name = "prep"]').val();
        const rev = $('[name = "rev"]').val();

        const filterArr = getFilteredArr(value);

        $('[name = "prep"]').empty().append('<option selected="selected" value="">Select an option</option>');
        $('[name = "rev"]').empty().append('<option selected="selected" value="">Select an option</option>');

        filterArr.map((elem) => {
            isPrepSelected = (elem.Id_employee == prep) ? "selected" : "";
            isRevSelected = (elem.Id_employee == rev) ? "selected" : "";
            if (rev != elem.Id_employee) {
                $('[name = "prep"]').append(
                    `<option value='${elem.Id_employee}' ${isPrepSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
            if (prep != elem.Id_employee) {
                $('[name = "rev"]').append(
                    `<option value='${elem.Id_employee}' ${isRevSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
        });

    })

    function getFilteredArr(value) {
        const dataArr = JSON.parse($('#empArr').val());
        return dataArr?.filter((elem) => elem.Id_employee != value);
    }

    function nospaces(t) {
        if (t.value.match(/\s/g)) {
            return t.value = t.value.replace(/\s/g, '');
        }

    }
    </script>

    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>