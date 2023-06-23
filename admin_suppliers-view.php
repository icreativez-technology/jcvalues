<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "View Supplier";
$sql_data = "SELECT Basic_Supplier.*, tbl_Countries.* FROM Basic_Supplier LEFT JOIN tbl_Countries ON Basic_Supplier.Country_of_Origin = tbl_Countries.CountryID WHERE Id_Supplier LIKE '$_REQUEST[pg_id]'";
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
                            <p><a href="/">Home</a> » <a href="/admin-panel.php">Admin Panel</a> » <a
                                    href="/admin_suppliers-panel.php">Supplier Management</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-custom gutter-b example example-compact">
                            <form class="form" action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="pg_id" id="pg_id"
                                    value="<?php echo $result_data['Id_Supplier']; ?>" disabled>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="required">Supplier ID</label>
                                            <input type="text" class="form-control" name="Supplier_Id"
                                                value="<?php echo $result_data['Supplier_Id']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Supplier Name</label>
                                            <input type="text" class="form-control" name="Supplier_Name"
                                                value="<?php echo $result_data['Supplier_Name']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Address</label>
                                            <input type="text" class="form-control" name="Address"
                                                value="<?php echo $result_data['Address']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Country of Origin</label>
                                            <input type="text" class="form-control" name="Country_of_Origin"
                                                value="<?php echo $result_data['CountryName']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label class="required">Primary Contact</label>
                                            <input type="text" class="form-control" name="Primary_Contact_Person"
                                                value="<?php echo $result_data['Primary_Contact_Person']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">E-Mail ID</label>
                                            <input type="email" class="form-control" name="Email_Primary"
                                                value="<?php echo $result_data['Email_Primary']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Secondary Contact</label>
                                            <input type="text" class="form-control" name="Secondary_Contact_Person"
                                                value="<?php echo $result_data['Secondary_Contact_Person']; ?>"
                                                disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>E-Mail ID</label>
                                            <input type="email" class="form-control" name="Email_Secondary"
                                                value="<?php echo $result_data['Email_Secondary']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label>Parent Company (If Applicable)</label>
                                            <input type="text" class="form-control" name="Parent_Company"
                                                value="<?php echo $result_data['Parent_Company']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Classification Type</label>
                                            <input type="text" class="form-control" name="Classification_Type"
                                                value="<?php echo $result_data['Classification_Type']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Scope of Supply</label>
                                            <input type="text" class="form-control" name="Scope_of_Supply"
                                                value="<?php echo $result_data['Scope_of_Supply']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Product Category</label>
                                            <input type="text" class="form-control" name="Product_Category"
                                                value="<?php echo $result_data['Product_Category']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label class="required">Type of Approval</label>
                                            <input type="text" class="form-control" name="Type_of_Approval"
                                                value="<?php echo $result_data['Type_of_Approval']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Expiry Date of Approval</label>
                                            <input type="date" class="form-control" name="Expiry_Date_of_Approval"
                                                value="<?php echo $result_data['Expiry_Date_of_Approval']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Initial Evaluation Date</label>
                                            <input type="date" class="form-control" name="Initial_Evaluation_Date"
                                                value="<?php echo $result_data['Initial_Evaluation_Date']; ?>" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="required">Status</label>
                                            <input type="text" class="form-control" name="Status"
                                                value="<?php echo $result_data['Status']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-3">
                                            <label class="required">Uploaded File</label>
                                            <div class="custom-select mt-3">
                                                <div class="tag-wrapper">
                                                    <div class="tags">
                                                        <a href="<?php echo $result_data['file_path']; ?>"
                                                            target="_blank"><?php echo $result_data['file_name']; ?></a>
                                                        <input type="hidden" class="form-control" name="file"
                                                            value="<?php echo $result_data['id']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <label>Remarks / Observations (If Applicable)</label>
                                            <textarea class="form-control" id="exampleTextarea"
                                                name="Remarks_Observations" rows="2"
                                                disabled><?php echo $result_data['Remarks_Observations']; ?></textarea>
                                        </div>
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
    <script>
    var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
</body>

</html>