<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Edit User";
/*$documetancion = scandir('/var/www/vhosts/nivelz.biz/dqms.nivelz.biz/documentacion');
 unset($documetancion[array_search('.', $documetancion, true)]);
 unset($documetancion[array_search('..', $documetancion, true)]);*/

$sql_data = "SELECT Id_employee, First_Name, Last_Name, Email, Id_plant, Id_department, Admin_User, Plant_Head, Department_Head, Management_Representative, Customer_Compliants_Representatives, Password, Title, Created, Modified, Status, Avatar_img, Custom_ID, is_blocked From Basic_Employee WHERE Id_employee LIKE '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);

$departmentSql = "SELECT Id_department, Department, Status FROM Basic_Department";
$departmentConnectData = mysqli_query($con, $departmentSql);
$departmentData =  array();
while ($row = mysqli_fetch_assoc($departmentConnectData)) {
    array_push($departmentData, $row);
}

$departmentPlantSql = "SELECT * FROM Basic_Plant_Deparment";
$departmentPlantConnectData = mysqli_query($con, $departmentPlantSql);
$departmentPlantData =  array();
while ($row = mysqli_fetch_assoc($departmentPlantConnectData)) {
    array_push($departmentPlantData, $row);
}
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
                            <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#admin-menu-modal">Admin Panel</a> » <a href="/admin_user-panel.php">User Management</a> »
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

                        <input type="hidden" name="departmentArr" id="departmentArr" value='<?php echo json_encode($departmentData) ?>'>
                        <input type="hidden" name="departmentPlantArr" id="departmentPlantArr" value='<?php echo json_encode($departmentPlantData) ?>'>

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
                            <form class="form" action="includes/basicsettings_user_update.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_employee']; ?>" readonly>
                                <div class="card-body">

                                    <div class="form-group row mt-2">
                                        <div class="col-lg-4">
                                            <label class="required">First Name</label>
                                            <input type="text" class="form-control" name="first_name" value="<?php echo $result_data['First_Name']; ?>" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="required">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" value="<?php echo $result_data['Last_Name']; ?>" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="required">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $result_data['Email']; ?>" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                                <small class="text-danger">The email has already been taken</small>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-2">
                                        <div class="col-lg-6">
                                            <label class="required">Plant</label>
                                            <select class="form-control" name="plant" id="plant" required>
                                                <?php
                                                $sql_data_plant = "SELECT Id_plant, Title, Status FROM Basic_Plant";
                                                $connect_data_plant = mysqli_query($con, $sql_data_plant);
                                                $flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/

                                                while ($result_data_plant = mysqli_fetch_assoc($connect_data_plant)) {
                                                    if ($result_data_plant['Status'] == 'Active') {
                                                        if ($result_data_plant['Id_plant'] == $result_data['Id_plant']) {
                                                            $flag_active_selected = 1;
                                                ?>
                                                            <option value="<?php echo $result_data_plant['Id_plant']; ?>" selected="selected"><?php echo $result_data_plant['Title']; ?>
                                                            </option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="<?php echo $result_data_plant['Id_plant']; ?>">
                                                                <?php echo $result_data_plant['Title']; ?></option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php if ($flag_active_selected == 0) { ?>
                                                <div class="text-muted fs-7">Original plant is suspended or deleted. Please
                                                    choose a new plant.</div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="required">Department</label>
                                            <select class="form-control" name="department" id="department" required>
                                                <?php
                                                $sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                $flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/

                                                while ($result_data_dep = mysqli_fetch_assoc($connect_data)) {
                                                    if ($result_data_dep['Status'] == 'Active') {
                                                        if ($result_data_dep['Id_department'] == $result_data['Id_department']) {
                                                            $flag_active_selected = 1;

                                                ?>
                                                            <option value="<?php echo $result_data_dep['Id_department']; ?>" selected="selected"><?php echo $result_data_dep['Department']; ?>
                                                            </option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="<?php echo $result_data_dep['Id_department']; ?>">
                                                                <?php echo $result_data_dep['Department']; ?></option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>

                                            </select>
                                            <?php if ($flag_active_selected == 0) { ?>
                                                <div class="text-muted fs-7">Original plant is suspended or deleted. Please
                                                    choose a new plant.</div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                    <div class="form-group row mt-2">
                                        <div class="col-lg-4">
                                            <label class="required">Role</label>
                                            <select class="form-control" name="rol" required>
                                                <option <?php echo $result_data['Admin_User'] == "Super Administrator" ? "selected" : '' ?>>
                                                    Super Administrator</option>
                                                <option <?php echo $result_data['Admin_User'] == "Administrator" ? "selected" : '' ?>>
                                                    Administrator</option>
                                                <option <?php echo $result_data['Admin_User'] == "Employee" ? "selected" : '' ?>>
                                                    Employee</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="required">Plant Head</label>
                                            <select class="form-control" name="plant_head" required>
                                                <?php if ($result_data['Plant_Head'] == 'No') { ?>
                                                    <option selected="selected">No</option>
                                                    <option>Yes</option>
                                                <?php } else { ?>
                                                    <option>No</option>
                                                    <option selected="selected">Yes</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="required">Department Head</label>
                                            <select class="form-control" name="department_head" required>
                                                <?php if ($result_data['Department_Head'] == 'No') { ?>
                                                    <option selected="selected">No</option>
                                                    <option>Yes</option>
                                                <?php } else { ?>
                                                    <option>No</option>
                                                    <option selected="selected">Yes</option>
                                                <?php } ?>
                                            </select>
                                            <?php if (isset($_GET['deptHeadExist'])) { ?>
                                                <small class="text-danger">The Department Head already Exist</small>
                                            <?php } ?>
                                        </div>

                                    </div>

                                    <div class="form-group row mt-2">
                                        <div class="col-lg-4">
                                            <label class="required">Management Representatives</label>
                                            <select class="form-control" name="management_representatives" required>
                                                <?php if ($result_data['Management_Representative'] == 'No') { ?>
                                                    <option selected="selected">No</option>
                                                    <option>Yes</option>
                                                <?php } else { ?>
                                                    <option>No</option>
                                                    <option selected="selected">Yes</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="required">Customer Compliants Representatives</label>
                                            <select class="form-control" name="Customer_Compliants_Representatives" required>
                                                <?php if ($result_data['Customer_Compliants_Representatives'] == 'No') { ?>
                                                    <option selected="selected">No</option>
                                                    <option>Yes</option>
                                                <?php } else { ?>
                                                    <option>No</option>
                                                    <option selected="selected">Yes</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
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
                                        <div class="col-lg-2">
                                            <label class="required">Login Permission</label>
                                            <div class="form-check form-switch mt-5">
                                                <input class="form-check-input" type="checkbox" role="switch" id="loginBlock" name="is_blocked" <?php echo $result_data['is_blocked'] == 1 ? "" : "checked" ?> />
                                                <label class="form-check-label" id="loginBlockLabel" for="loginBlock"><?php echo $result_data['is_blocked'] == 1 ? "Disabled" : "Enabled" ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-lg-12">
                                            <div class="symbol symbol-150px overflow-hidden me-3">
                                                <div class="symbol-label">
                                                    <img src="assets/media/avatars/<?php echo $result_data['Avatar_img']; ?>" class="w-100" />
                                                </div>
                                            </div>
                                            <br>
                                            <label>Select image for avatar (Max: 1MB) / Image name has to be without
                                                space</label>
                                            <input type="file" class="form-control" accept="image/*" name="file_avatar" id="file_avatar">
                                        </div>
                                    </div>

                                    <div class="form-group row mt-2">
                                        <div class="col-lg-12">
                                            <label>Actual Password : <span style="color: black;"><?php echo $result_data['Password']; ?></span></label>
                                            <input type="text" class="form-control" name="password" placeholder="Only enter if you want to change the password">
                                        </div>
                                    </div>

                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <div style="text-align: right;"><input type="submit" class="btn btn-sm btn-success m-3" value="Update"><a type="button" href="/admin_user-panel.php" class="btn btn-sm btn-danger">Cancel</a>
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
    <script>
        $(document).ready(function() {
            getDepartments();
        });

        $('#plant').on('change', function() {
            getDepartments();
        });

        $('#loginBlock').on('change', function() {
            label = ($(this)[0].checked) ? "Enabled" : "Disabled";
            $('#loginBlockLabel').html(label);
        });

        function getDepartments() {
            let plantId = $('#plant').val();
            let departmentId = $('#department').val();
            let deptArr = JSON.parse($('#departmentArr').val());
            let deptPlantArr = JSON.parse($('#departmentPlantArr').val());
            filterArr = new Array();
            const departments = deptPlantArr.map((elem) => {
                if (elem.Id_plant == plantId) {
                    deptArr.map((depts) => {
                        if (depts.Id_department == elem.Id_department) {
                            return filterArr.push({
                                name: depts.Department,
                                id: depts.Id_department,
                                selected: (depts.Id_department == departmentId) ? "selected" : ""
                            })
                        }
                    })
                }
            })
            $("#department").empty();
            $("#department").append('<option value="">Please Select</option>');
            filterArr.map((elem) => {
                return $('#department').append(`<option value="${elem.id}" ${elem.selected}>${elem.name}</option>`)
            })
        }
    </script>
</body>
<!--end::Body-->

</html>