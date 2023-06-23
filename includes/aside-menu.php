<?php
if (isset($_GET['a'])) {
    $activeLink = $_GET['a'];
}
$directory = "logo/";
$files = scandir($directory);
$logo = $directory . $files[2];
$email = $_SESSION['usuario'];
$userSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchUser = mysqli_query($con, $userSql);
$userInfo = mysqli_fetch_assoc($fetchUser);

$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole =  mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
?>
<style type="text/css">

#kt_aside_menu {
    overflow-y: auto;
}

.aside {
    width: 225px;
}

.aside-nav {
    padding-bottom: 100px;
}

.gx-sidebar-notifications {
    /*padding: 30px 10px 0px;*/
    /*margin: 0 20px 10px;*/
    border-bottom: 1px solid #e8e8e8;
}

.gx-app-nav {
    list-style: none;
    padding-left: 0;
    display: -ms-flex;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    -ms-align-items: center;
    align-items: center;
    margin: 0 -20px;
    color: #038fde;
}

.gx-app-nav {
    justify-content: space-around;
}

.text-dark {
    color: #757373;
}

.report-imag {
    height: 17px;
    padding-bottom: 3px;
}

#admin-menu-form {
    height: 100%;
}

.modal-header-custom {
    background-color: #fff !important;
    color: #000;
}

.show {
    display: unset !important;
}

.text-dark-sm {
    color: #000 !important;
}

.sub-menu-csm {
    cursor: pointer;
    border-bottom: none;
}

.sub-menu-csm i {
    float: right;
    right: 20%;
    cursor: pointer;
}

.sub-menu-2x {
    border: none;
}

.gx-sidebar-notifications {
    border-bottom: 1px solid #00000026;
}

.admin-link {
    cursor: pointer;
}
</style>

<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">

    <div class="aside-logo d-lg-flex d-sm-flex flex-column flex-column-auto py-3 px-5" id="kt_aside_logo" style="padding-bottom: 0.35rem!important;">
        <div class="gx-sidebar-notifications">
            <a href="/settings.php">
                <div class="d-flex align-items-center cursor-pointer" style="column-gap:20px;">
                    <div class="symbol">
                        <img src="assets/media/avatars/<?php echo $dt['Avatar_img']; ?>"
                            class="h-40px w-40px rounded-square" />
                    </div>
                    <span class="fw-bold text-dark fs-5">
                        <?php echo $dt["First_Name"] . ' ' . $dt["Last_Name"] ?>
                        <div class="fw-bold text-dark d-flex align-items-center fs-7 ">
                            <?php echo $roleInfo['Title'] ?>
                        </div>
                    </span>
                </div>
            </a>
            <!-- <i class="fa-solid fa-user-headset"></i> -->
            <div class="d-flex flex-column pe-5 mb-2">
                <ul class="gx-app-nav mt-3">

                    <li><a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#admin-menu-modal"><i
                                class=" fas fa-cog text-dark" title="Admin Settings"></i></a>
                    </li>
                    <li><a href="/report-bug.php"> <img alt="bug-logo" src="logo/male-telemarketer.png"
                                class="report-imag" title="Report Bug" /></a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out text-dark" title="Log Out"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="aside-nav d-flex flex-column align-lg-center flex-column-fluid w-100 pt-5 pt-lg-0" id="kt_aside_nav">
        <div id="kt_aside_menu"
            class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-bold fs-6"
            data-kt-menu="true" style="justify-content: unset;">

            <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start"
                class="menu-item <?php echo ($activeLink == "dashboard") ? "active-tab" : "" ?>">
                <a href="../../index.php?a=dashboard">
                    <span class="menu-link menu-center">
                        <span class="aside-menu-items d-flex">
                            <span class="menu-icon me-0 ">
                                <i class="bi bi-x-diamond-fill"></i>
                            </span>
                            <span class="ms-3">Dashboard</span>
                        </span>
                    </span>
                </a>
            </div>
            <?php
            $sql_module = "SELECT * FROM modules WHERE is_deleted = 0 order by module_order ASC";
            $connect_module = mysqli_query($con, $sql_module);
            while ($result_module = mysqli_fetch_assoc($connect_module)) {
            ?>
            <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start"
                class="menu-item <?php echo ($activeLink == $result_module['module_order']) ? "active-tab" : "" ?>">
                <a href="<?php echo $result_module['href'] . "?a=" . $result_module['module_order'] ?>">
                    <span class="menu-link menu-center">
                        <span class="aside-menu-items d-flex">
                            <span class="menu-icon me-0 ">
                                <i class="bi bi-x-diamond-fill"></i>
                            </span>
                            <span class="ms-3"><?php echo $result_module['module'] ?></span>
                        </span>
                    </span>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="aside-footer d-flex flex-column align-items-center flex-column-auto" id="kt_aside_footer">
    </div>
</div>

<!-- Admin Menu Modal start -->
<div class="modal right fade" id="admin-menu-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 250px!important;">
        <form id="admin-menu-form" class="form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header right-modal modal-header-custom">
                    <h5 class="modal-title text-dark" id="staticBackdropLabel">Admin Settings
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetModalVal()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body m-0 p-0" style="overflow-y: scroll;">
                    <input type="hidden" id="roleValue" name="roleValue"
                        value="<?php echo $roleInfo['Id_basic_role']; ?>">
                    <ul class="list-group me-0 pe-0" style="border-radius:0;">
                        <li class="list-group-item"><a class="text-dark admin-link"
                                href="/admin_user-panel.php">Employees</a></li>
                        <li class="list-group-item"> <a class="text-dark admin-link"
                                href="/admin_role-panel.php">Roles</a></li>
                        <li class="list-group-item"><a class="text-dark admin-link"
                                href="/admin_plants-panel.php">Plants</a></li>
                        <li class="list-group-item"><a class="text-dark admin-link"
                                href="/admin_productgroup-panel.php">Product
                                Groups</a></li>
                        <li class="list-group-item"><a class="text-dark admin-link"
                                href="/admin_department-panel.php">Departments</a></li>
                        <li class="list-group-item"><a class="text-dark admin-link"
                                href="/admin_suppliers-panel.php">Suppliers</a>
                        </li>
                        <li class="list-group-item"><a class="text-dark admin-link"
                                href="/admin_customers-panel.php">Customers</a>
                        </li>
                        <li role="button" class="list-group-item sub-menu-csm" data-bs-toggle="collapse"
                            data-bs-target="#standard-normative-menu" aria-expanded="false"
                            aria-controls="standard-normative-menu">
                            Standard Normative
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="standard-normative-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/design-standard.php" class="text-dark admin-link">Design Standard</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/testing-standard.php">Testing Standard</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/special-testing-standard.php">Special Testing
                                        Standard</a>
                                </li>
                            </ul>
                        </div>

                        </li>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse"
                            data-bs-target="#product-configuration-menu" aria-expanded="false"
                            aria-controls="product-configuration-menu" role="button">
                            Product Configuration
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="product-configuration-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/model.php" class="text-dark admin-link">Model</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/component.php">Component</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/product-type.php">Product Type</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse"
                            data-bs-target="#basic-valve-menu" aria-expanded="false" aria-controls="basic-valve-menu"
                            role="button">
                            Basic Valve Parameters
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="basic-valve-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/size.php" class="text-dark admin-link">Size</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/bore.php">Bore</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/class.php">Class</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/working-pressure.php">Working Pressure</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/end-connection.php">End Connection</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/operator-type.php">Operator Type</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse" data-bs-target="#nde-menu"
                            aria-expanded="false" aria-controls="nde-menu" role="button">
                            Non-Destructive Examination
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="nde-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item sub-menu-csm sub-menu-2x " data-bs-toggle="collapse"
                                    data-bs-target="#general-nde-menu" aria-expanded="false"
                                    aria-controls="general-nde-menu" role="button">
                                    General NDE Settings
                                    <i class="bi bi-caret-down-fill"></i>
                                </li>
                                <div class="panel-colapse collapse border-0" id="general-nde-menu" role="button">
                                    <ul class="ms-3 p-0">
                                        <li class="list-group-item border-0">
                                            <a href="/nde-component.php" class="text-dark admin-link">Components</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark" href="/nde-standard-referance.php">Standard
                                                Reference</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link"
                                                href="/nde-procedure-referance.php">Procedure
                                                Reference</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link"
                                                href="/nde-acceptance-standard.php">Acceptance
                                                standard</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/nde-test-stage.php">Test Stage</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/nde-surface-condition.php">Surface
                                                Condition</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/nde-pre-cleaning.php">Pre
                                                Cleaning</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/nde-extend-of-examination.php">Extend
                                                of
                                                Examination</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/nde-operator.php">Operator</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link"
                                                href="/nde-qualification.php">Qualification</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/nde-standard-qualified.php">Standard
                                                Qualified</a>
                                        </li>
                                    </ul>
                                </div>
                                <li class="list-group-item sub-menu-csm sub-menu-2x" data-bs-toggle="collapse"
                                    data-bs-target="#ultra-sonic-menu" aria-expanded="false"
                                    aria-controls="ultra-sonic-menu" role="button">
                                    Ultrasonic Test
                                    <i class="bi bi-caret-down-fill"></i>
                                </li>
                                <div class="panel-colapse collapse border-0" id="ultra-sonic-menu" role="button">
                                    <ul class="ms-3 p-0">
                                        <li class="list-group-item border-0">
                                            <a href="/scan-scope.php" class="text-dark admin-link">Scan Scope</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/screen-height.php">Screen Height</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/transfer-correction.php">Transfer
                                                Correction</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/scan-level.php">Scan Level</a>
                                        </li>
                                    </ul>
                                </div>
                                <li class="list-group-item sub-menu-csm sub-menu-2x" data-bs-toggle="collapse"
                                    data-bs-target="#visual-test-menu" aria-expanded="false"
                                    aria-controls="visual-test-menu" role="button">
                                    Visual Test
                                    <i class="bi bi-caret-down-fill"></i>
                                </li>
                                <div class="panel-colapse collapse border-0" id="visual-test-menu" role="button">
                                    <ul class="ms-3 p-0">
                                        <li class="list-group-item border-0">
                                            <a href="/vt-viewing-method.php" class="text-dark admin-link">Viewing
                                                Method</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/vt-technique.php">Technique</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/vt-aids-for-direct.php">Aids For
                                                Direct VT</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link"
                                                href="/vt-equipment-for-remote.php">Equipment for
                                                Remote
                                                VT</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/vt-lighting-type.php">Lighting
                                                Type</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/vt-light-source.php">Light Source</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/vt-light-incidence.php">Light
                                                Incidence</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/vt-diffuser-type.php">Diffuser
                                                Type</a>
                                        </li>
                                    </ul>
                                </div>
                                <li class="list-group-item sub-menu-csm sub-menu-2x" data-bs-toggle="collapse"
                                    data-bs-target="#penetrant-menu" aria-expanded="false"
                                    aria-controls="penetrant-menu" role="button">
                                    Penetrant Test
                                    <i class="bi bi-caret-down-fill"></i>
                                </li>
                                <div class="panel-colapse collapse border-0" id="penetrant-menu" role="button">
                                    <ul class="ms-3 p-0">
                                        <li class="list-group-item border-0">
                                            <a href="/pt-penetrant-type.php" class="text-dark admin-link">Penetrant
                                                Type</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/pt-method.php">Method</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/pt-penetrant-form.php">Penetrant
                                                Form</a>
                                        </li>
                                    </ul>
                                </div>
                                <li class="list-group-item sub-menu-csm sub-menu-2x" data-bs-toggle="collapse"
                                    data-bs-target="#magnetic-menu" aria-expanded="false" aria-controls="magnetic-menu"
                                    role="button">
                                    Magnetic Test
                                    <i class="bi bi-caret-down-fill"></i>
                                </li>
                                <div class="panel-colapse collapse border-0" id="magnetic-menu" role="button">
                                    <ul class="ms-3 p-0">
                                        <li class="list-group-item border-0">
                                            <a href="/mt-magnetization-technique.php"
                                                class="text-dark admin-link">Magnetization
                                                Technique</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link"
                                                href="/mt-magnetization-direction.php">Magnetization
                                                Direction</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/mt-voltage.php">Current Type</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/mt-voltage.php">Voltage</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/mt-media-type.php">Media Type</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/mt-media-application.php">Media
                                                Application</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/mt-particle-color.php">Particle
                                                Color</a>
                                        </li>
                                    </ul>
                                </div>
                                <li class="list-group-item sub-menu-csm sub-menu-2x" data-bs-toggle="collapse"
                                    data-bs-target="#pmi-menu" aria-expanded="false" aria-controls="pmi-menu"
                                    role="button">
                                    Positive Material Identification
                                    <i class="bi bi-caret-down-fill"></i>
                                </li>
                                <div class="panel-colapse collapse border-0" id="pmi-menu" role="button">
                                    <ul class="ms-3 p-0">
                                        <li class="list-group-item border-0">
                                            <a href="/pmi-spectroscopy-technique.php"
                                                class="text-dark admin-link">Spectroscopy
                                                Technique</a>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <a class="text-dark admin-link" href="/pmi-reading-done.php">Reading Done
                                                On</a>
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                        </div>
                        <li class="list-group-item"><a class="text-dark admin-link"
                                href="/material-specification.php">Material
                                Specification</a></li>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse"
                            data-bs-target="#meeting-menu" aria-expanded="false" aria-controls="meeting-menu"
                            role="button">
                            Meeting
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="meeting-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/admin_meeting-coordinators.php"
                                        class="text-dark admin-link">Coordinators</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_meeting-categories.php">Categories</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_meeting-venues.php">Venues</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse"
                            data-bs-target="#risk-moc-menu" aria-expanded="false" aria-controls="risk-moc-menu"
                            role="button">
                            Risk & MoC
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="risk-moc-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/admin_quality-impact.php" class="text-dark admin-link">Impact Area</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_quality-process.php">Process</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_quality-risk-source.php">Risk
                                        Source</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_quality-risk.php">Risk Type</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_quality-moc.php">MoC Type</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse" data-bs-target="#ncr-menu"
                            aria-expanded="false" aria-controls="ncr-menu" role="button">
                            NCR
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="ncr-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/admin_ncr-type.php" class="text-dark admin-link">NCR Type</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_ncr-process.php">ProcessType</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse" data-bs-target="#cm-menu"
                            aria-expanded="false" aria-controls="cm-menu" role="button">
                            Customer Management
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="cm-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/admin_cm-nature.php" class="text-dark admin-link">Nature of Complaints</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse" data-bs-target="#qalert-menu"
                            aria-expanded="false" aria-controls="qalert-menu" role="button">
                            Q-Alert
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="qalert-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/action-category.php" class="text-dark admin-link">Action Category</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/q-alert-nature-of-obs.php">Nature Of
                                        Observation</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/area-process.php">Area/Process</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse"
                            data-bs-target="#suggestion-menu" aria-expanded="false" aria-controls="suggestion-menu"
                            role="button">
                            Suggestion
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="suggestion-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/suggestion-nature-of-obs.php" class="text-dark admin-link">Nature Of
                                        Observation</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse" data-bs-target="#ehs-menu"
                            aria-expanded="false" aria-controls="ehs-menu" role="button">
                            EHS
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="ehs-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/ehs-nature-of-obs.php" class="text-dark admin-link">Nature Of
                                        Observation</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/immediate-action.php">Immediate Action</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/main-cause.php">Main Cause</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/root-cause.php">Root Cause</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse" data-bs-target="#audit-menu"
                            aria-expanded="false" aria-controls="audit-menu" role="button">
                            Audit
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="audit-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/admin_audit_standard.php" class="text-dark admin-link">Audit Standard</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_audit_area.php">Audit Area</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_audit-coordinator.php">Audit
                                        Coordinators</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/admin_audit-finding-type.php">Findings
                                        Type</a>
                                </li>
                            </ul>
                        </div>
                        <li class="list-group-item sub-menu-csm" data-bs-toggle="collapse" data-bs-target="#kaizen-menu"
                            aria-expanded="false" aria-controls="kaizen-menu" role="button">
                            Kaizen
                            <i class="bi bi-caret-down-fill"></i>
                        </li>
                        <div class="panel-colapse collapse border-0" id="kaizen-menu" role="button">
                            <ul class="ms-3 p-0">
                                <li class="list-group-item border-0">
                                    <a href="/kaizen-category.php" class="text-dark admin-link">Category</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/kaizen-focus-area.php">Focus Area</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/kaizen-process.php">Process</a>
                                </li>
                                <li class="list-group-item border-0">
                                    <a class="text-dark admin-link" href="/kaizen-type.php">Kaizen Type</a>
                                </li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="access_invalid_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <h5 style="font-weight: 500;">You are not authorized to access this module</h5>
                </div>
            </div>
            <div class="modal-footer  text-center" style="padding: 1rem;">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Admin Menu Modal End -->

<script>
    $(document).ready(function() {
        let role = $('#roleValue').val();
        if (Number(role) == 3) {
            return $('.admin-link').removeAttr("href");
        }
    });

    $(".admin-link").on('click', function() {
        let role = $('#roleValue').val();
        if (Number(role) == 3) {
            return $('#access_invalid_modal').modal('show');
        }
    });
</script>