<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Audit Area";


?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>

<!--begin::Body-->

<style>
.add-item i {
    font-size: 10px;
    background-color: #adaeb1;
    padding: 5px;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
}

.remove-item i {
    font-size: 10px;
    background-color: #adaeb1;
    padding: 5px;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    margin-left: 20px;
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
                                    href="/admin_audit-panel.php">Audit</a> » <a href="/admin_audit-area.php">Audit
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
                            <form class="form" action="includes/basicsettings_audit-standard_area-add.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row mt-2">
                                        <div class="col-md-4">
                                            <label class="required">Title</label>
                                            <input type="text" class="form-control" name="title" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The audit area name has already been
                                                taken</small>
                                            <?php } ?>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="required">Audit Standard</label>
                                            <select class="form-select" name="audit_standard" data-control="select2"
                                                data-placeholder="Select an option" required>
                                                <option>Select an option</option>
                                                <?php
                                                $consulta = "SELECT * FROM audit_standard WHERE Status = '1' AND deleted_at IS NULL";
                                                $consulta_general = mysqli_query($con, $consulta);
                                                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_audit_standard']; ?>">
                                                    <?php echo $result_data['Title'] ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="required">Plant</label>
                                            <select class="form-select" name="plant" data-control="select2"
                                                data-placeholder="Select an option" required>
                                                <option>Select an option</option>
                                                <?php
                                                $consulta = "SELECT * FROM basic_plant WHERE status = 'Active'";
                                                $consulta_general = mysqli_query($con, $consulta);
                                                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_plant']; ?>">
                                                    <?php echo $result_data['Title'] ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-md-4">
                                            <label class="required">Product Group</label>
                                            <select class="form-select" name="product_group" data-control="select2"
                                                data-placeholder="Select an option" required>
                                                <option>Select an option</option>
                                                <?php
                                                $consulta = "SELECT * FROM basic_product_group WHERE status = 'Active'";
                                                $consulta_general = mysqli_query($con, $consulta);
                                                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_product_group']; ?>">
                                                    <?php echo $result_data['Title'] ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="required">Department</label>
                                            <select class="form-select" name="department" data-control="select2"
                                                data-placeholder="Select an option" required>
                                                <option>Select an option</option>
                                                <?php
                                                $consulta = "SELECT * FROM Basic_Department WHERE Status = 'Active'";
                                                $consulta_general = mysqli_query($con, $consulta);
                                                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_department']; ?>">
                                                    <?php echo $result_data['Department'] ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="required">Audit checklist Format No</label>
                                            <input type="text" class="form-control" name="audit_checklist_format_no"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-md-4">
                                            <label class="required">Revision Number</label>
                                            <input type="text" class="form-control" name="revision_number" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="required">Finding Format No</label>
                                            <input type="text" class="form-control" name="finding_format_no" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="required">Finding Revision No</label>
                                            <input type="text" class="form-control" name="finding_revision_no" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-md-4">
                                            <label class="required">Auditor</label>
                                            <select class="form-select" name="auditor" data-control="select2"
                                                data-placeholder="Select an option" required>
                                                <option>Select an option</option>
                                                <?php
                                                $consulta = "SELECT * FROM Basic_Employee";
                                                $consulta_general = mysqli_query($con, $consulta);
                                                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_employee']; ?>">
                                                    <?php echo $result_data['First_Name'] . ' ' . $result_data['Last_Name']; ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="required">Auditee</label>
                                            <select class="form-select form-select-solid select2-hidden-accessible mt-2"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Select Option" name="auditee[]"
                                                data-select2-id="select2-data-7-oqww-group" tabindex="-1"
                                                aria-hidden="true" required="true" Multiple>
                                                <option>Select an option</option>
                                                <?php
                                                $consulta = "SELECT * FROM Basic_Employee";
                                                $consulta_general = mysqli_query($con, $consulta);
                                                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                                                ?>
                                                <option value="<?php echo $result_data['Id_employee']; ?>">
                                                    <?php echo $result_data['First_Name'] . ' ' . $result_data['Last_Name']; ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-4">
                                        <div class="col-md-12">
                                            <div class="breadcrumbs">
                                                Assign Checklist
                                            </div>
                                            <div>
                                                <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3"
                                                    id="kt_department_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr
                                                            class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-400px">Clause</th>
                                                            <th class="min-w-400px">Audit Point</th>
                                                            <th class="min-w-100px">Action</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600" id="checklist-body">
                                                        <tr class="checklist-newelem checklist-elem">
                                                            <td><input class="form-control" type="text" name="clause[]"
                                                                    required>
                                                            </td>
                                                            <td><input class="form-control" type="text"
                                                                    name="audit_point[]" required></td>
                                                            <td>
                                                                <div class="checkList-actions"><a
                                                                        class="add-item checklist-append"><i
                                                                            class="fa fa-plus"></i></a>
                                                            </td>
                                            </div>
                                            </tr>
                                            </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                        </div>
                        <div class="p-4">
                            <div class="row">
                                <div style="text-align: right;"><input type="submit" class="btn btn-sm btn-success m-3"
                                        value="Save"><a type="button" href="/admin_audit-area.php"
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
    function removeElem(elem) {
        return $(elem).closest(".checklist-elem").remove();
    }

    $(document).on("click", ".checklist-append", function() {
        const newActionElem =
            `<a class="remove-item" onclick="removeElem(this)"><i class="fa fa-minus"></i></a>`;
        const elem = $(".checklist-newelem").clone();
        const cleanElem = $(elem).removeClass("checklist-newelem");
        $(cleanElem).find("input[type='text']").val("");
        $(cleanElem).find(".checkList-actions").append(newActionElem);
        return $("#checklist-body").append(cleanElem);
    });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>