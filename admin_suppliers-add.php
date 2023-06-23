<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Supplier";
$locationSql = "SELECT * FROM tbl_Countries";
$locationConnect = mysqli_query($con, $locationSql);
$locations = mysqli_fetch_all($locationConnect, MYSQLI_ASSOC);
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
<?php include('includes/admin_check.php'); ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a class="cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#admin-menu-modal">Admin Panel</a> » <a
                                    href="/admin_suppliers-panel.php">Supplier Management</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-custom gutter-b example example-compact">
                            <form class="form" action="includes/basicsettings_supplier_add.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="required">Supplier ID</label>
                                            <input type="text" class="form-control" name="Supplier_Id" required>
                                            <?php if (isset($_GET['exist'])) { ?>
                                            <small class="text-danger">The supplier id has already been
                                                taken</small>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Supplier Name</label>
                                            <input type="text" class="form-control" name="Supplier_Name"
                                                oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Address</label>
                                            <input type="text" class="form-control" name="Address"
                                                oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Country of Origin</label>
                                            <select class="form-control" name="Country_of_Origin" required>
                                                <option value="">Please Select</option>
                                                <?php foreach ($locations as $location) { ?>
                                                <option value="<?php echo $location['CountryID']; ?>">
                                                    <?php echo $location['CountryName'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label class="required">Primary Contact</label>
                                            <input type="text" class="form-control" name="Primary_Contact_Person"
                                                oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">E-Mail ID</label>
                                            <input type="email" class="form-control" name="Email_Primary" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Secondary Contact</label>
                                            <input type="text" class="form-control" name="Secondary_Contact_Person"
                                                oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                        <div class="col-lg-3">
                                            <label>E-Mail ID</label>
                                            <input type="email" class="form-control" name="Email_Secondary">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label>Parent Company (If Applicable)</label>
                                            <input type="text" class="form-control" name="Parent_Company"
                                                oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Classification Type</label>
                                            <select class="form-control" name="Classification_Type" required>
                                                <option value="">Please Select</option>
                                                <option value="Critical">Critical</option>
                                                <option value="Non-Critical">Non-Critical</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Scope of Supply</label>
                                            <input type="text" class="form-control" name="Scope_of_Supply"
                                                oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Product Category</label>
                                            <input type="text" class="form-control" name="Product_Category"
                                                oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label class="required">Type of Approval</label>
                                            <input type="text" class="form-control" name="Type_of_Approval"
                                                oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Expiry Date of Approval</label>
                                            <input type="date" class="form-control" name="Expiry_Date_of_Approval"
                                                required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Initial Evaluation Date</label>
                                            <input type="date" class="form-control" name="Initial_Evaluation_Date"
                                                required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Status</label>
                                            <select class="form-control" name="Status" required>
                                                <option value="">Please Select</option>
                                                <option value="Approved">Approved</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Suspended">Suspended</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label class="required">File Upload</label>
                                            <input type="file" class="form-control" name="file" accept=".pdf"
                                                required />
                                        </div>
                                        <div class="col-lg-9">
                                            <label>Remarks / Observations (If Applicable)</label>
                                            <textarea class="form-control" name="Remarks_Observations"
                                                rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <div style="text-align: right;"><input type="submit"
                                                class="btn btn-sm btn-success m-3" value="Save"><a type="button"
                                                href="/admin_suppliers-panel.php"
                                                class="btn btn-sm btn-danger">Cancel</a></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>
    </div>
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

</html>