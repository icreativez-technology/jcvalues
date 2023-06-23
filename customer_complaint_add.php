<?php
session_start();
include 'includes/functions.php';
$_SESSION['Page_Title'] = "New Customer Complaint";
$email = $_SESSION['usuario'];
$userSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchUser = mysqli_query($con, $userSql);
$userInfo = mysqli_fetch_assoc($fetchUser);
$userId = $userInfo['Id_employee'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<style>
.ver-disabled input {
    background-color: #e9ecef !important;
}
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include 'includes/aside-menu.php'; ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include 'includes/header.php'; ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/complaints.php">Complaints</a> » <a href="/customer_complaint_view_list.php">Customer Complaint List</a> »
                                <?php echo $_SESSION['Page_Title']; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush">
                            <form class="form" action="/includes/customer_complaint_store.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        Complaint Details
                                    </div>
                                    <div id="custom-section-1">
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Customer Name</label>
                                                <select class="form-control" name="customer_id" id="customer_name"
                                                    required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Basic_Customer";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active') {
                                                    ?>
                                                    <option value="<?php echo $result_data['Id_customer']; ?>">
                                                        <?php echo $result_data['Customer_Name']; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Order Ref Number</label>
                                                <input type="text" name="customer_order_ref" class="form-control" required>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Internal Order Ref</label>
                                                <input type="text" name="internal_order_ref" class="form-control" required>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Item No</label>
                                                <input type="text" name="item_no" class="form-control" required>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Product Details</label>
                                                <input type="text" name="product_details" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Nature of Complaint</label>
                                                <select class="form-control" name="nature_of_complaint_id" required>
                                                    <option value="">Please select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Customer_Nature_of_Complaints";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    ?>
                                                    <option
                                                        value="<?php echo $result_data['Id_customer_nature_of_complaints']; ?>">
                                                        <?php echo $result_data['Title']; ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Complaint Recieved On</label>
                                                <input type="date" id="date" class="form-control" name="complaint_date" required>
                                            </div>
                                            <div class="col-lg-3 mt-5 ver-disabled">
                                                <label class="required">Email</label>
                                                <input class="form-control" id="email" readonly>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label>Phone</label>
                                                <input name="phone" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 mt-5">
                                                <label class="required">Complaint Details</label>
                                                <textarea type="text" rows="2" class="form-control"
                                                    name="complaint_details" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 mt-5">
                                                <label>File Upload</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-full customer-header d-flex justify-content-between mt-4">
                                            D1-D2
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 mt-5">
                                                <label class="required">Details of Solution</label>
                                                <input type="text" class="form-control" name="details_of_solution" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 mt-5">
                                                <label class="required">Team members</label>
                                                <select class="form-control form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="true"
                                                    data-placeholder="Select Participants" name="team_members[]"
                                                    data-select2-id="select2-data-7-oqww" tabindex="-1"
                                                    aria-hidden="true" required multiple>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Basic_Employee WHERE status = 'Active'";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active' && $result_data['Id_employee'] != $userId) {
                                                    ?>
                                                    <option value="<?php echo $result_data['Id_employee']; ?>">
                                                        <?php echo $result_data['First_Name']; ?>
                                                        <?php echo $result_data['Last_Name']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row" style="text-align:center; float:right;">
                                            <div class="mb-4">
                                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                                                <a type="button" href="javascript:history.back(-1)" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    </div>
    </div>
    </div>
    <?php include 'includes/scrolltop.php'; ?>
    <script>
    var hostUrl = "assets/";
    $("input").intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
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
    <script>
        $(document).on("change", "#customer_name", function() {
            $.ajax({
                url: "includes/get_email_by_customer_name.php",
                type: "POST",
                dataType: "html",
                data: {
                    id: $('#customer_name').val()
                },
            }).done(function(res) {
                $('#email').val(res);
            });
        });
        $(document).ready(function() {
            // var date = new Date();
            // document.getElementById("date").min = date.getFullYear() +
            //     "-" +
            //     ("0" + (date.getMonth() + 1)).slice(-2) +
            //     "-" +
            //     ("0" + date.getDate()).slice(-2);
        });
    </script>
</body>

</html>