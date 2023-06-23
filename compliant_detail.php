<?php
session_start();
include 'includes/functions.php';
$_SESSION['Page_Title'] = "Customer Compliants Details";
$type = $_REQUEST['type'];
$disabled = $type == 1 ? true : false;

$email = $_SESSION['usuario'];
$roleSql = "SELECT Id_basic_role From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];

// if compliant_order_id exist, D1, D2, ... 
// if not, create new
if (!isset($_GET['compliant_order_id'])) {
  $queryDelete = "DELETE from compliant_details_temp;";
  mysqli_query($con, $queryDelete);
  $queryCreateNew = "INSERT INTO compliant_details_temp VALUES (0, 'none');";
  mysqli_query($con, $queryCreateNew);
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
  <!--begin::Main-->
  <!--begin::Root-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
      <?php include 'includes/aside-menu.php'; ?>
      <!--begin::Wrapper-->
      <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <?php include 'includes/header.php'; ?>
        <!-- Includes Top bar and Responsive Menu -->
        <!--begin::BREADCRUMBS-->
        <div class="row breadcrumbs">
          <!--begin::body-->
          <div>
            <div>
              <p><a href="/">Home</a> » <a href="/compliants.php">Compliants</a> » <a href="/compliant_view_list.php">Compliants List</a> »
                <?php echo $_SESSION['Page_Title']; ?>
              </p>
            </div>
          </div>
          <!--end::body-->
        </div>
        <!--end::BREADCRUMBS-->
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <!--begin::Container-->
          <div class="container-custom" id="kt_content_container">
            <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Compliant Details</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="d1-d2-tab" data-bs-toggle="tab" data-bs-target="#d1-d2" type="button" role="tab" aria-controls="mitigation" aria-selected="false">D1-D2</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="d3-tab" data-bs-toggle="tab" data-bs-target="#d3" type="button" role="tab" aria-controls="mitigation" aria-selected="false">D3</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="d4-tab" data-bs-toggle="tab" data-bs-target="#d4" type="button" role="tab" aria-controls="mitigation" aria-selected="false">D4</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="d6-d7-tab" data-bs-toggle="tab" data-bs-target="#d6-d7" type="button" role="tab" aria-controls="mitigation" aria-selected="false">D6-D7</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="d8-tab" data-bs-toggle="tab" data-bs-target="#d8" type="button" role="tab" aria-controls="mitigation" aria-selected="false">D8</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <!--Compliant Details-->
              <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <div class="card card-flush">
                  <form class="form" action="/includes/compliants/compliants_details_proc.php" method="post" enctype="multipart/form-data">
                    <!-- begin::Form Content -->
                    <div class="card-body">
                      <div id="custom-section-1">
                        <div class="form-group row mt-2">
                          <div class="col-lg-3 mt-2">
                            <label class="required">On Behalf Of</label>
                            <select class="form-control" name="on_behalf_of" required <?php echo $disabled ? "disabled" : "" ?>>
                              <option>Please Select</option>
                              <?php
                              $results = mysqli_query($con, "SELECT Id_employee, CONCAT(First_Name, Last_Name) as fullname FROM Basic_Employee");
                              while ($row = mysqli_fetch_assoc($results)) {
                                echo "<option value='" . $row['Id_employee'] . "'>" . $row['fullname'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Customer Name</label>
                            <select class="form-control" name="customer_id" id="plant" required <?php echo $disabled ? "disabled" : "" ?>>
                              <option value="">Please select</option>
                              <?php
                              $results = mysqli_query($con, "SELECT Id_customer, customer_name FROM Basic_Customer");
                              while ($row = mysqli_fetch_assoc($results)) {
                                echo "<option value='" . $row['Id_customer'] . "'>" . $row['customer_name'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Order Ref Number</label>
                            <input type="" name="orderrefnumber" class="form-control" <?php echo $disabled ? "disabled" : "" ?>>
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Product Details</label>
                            <input type="" name="productdetails" class="form-control" <?php echo $disabled ? "disabled" : "" ?>>
                          </div>
                        </div>
                        <div class="form-group row mt-2">
                          <div class="col-lg-3 mt-2">
                            <label class="required">Nature of Compliants</label>
                            <select class="form-control" name="id_customer_nature_of_compliants" required <?php echo $disabled ? "disabled" : "" ?>>
                              <option value="">Please select</option>
                              <?php
                              $results = mysqli_query($con, "select Id_customer_nature_of_complaints, Title from Customer_Nature_of_Complaints;");
                              while ($row = mysqli_fetch_assoc($results)) {
                                echo "<option value='" . $row['Id_customer_nature_of_complaints'] . "'>" . $row['Title'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Date</label>
                            <input type="date" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required <?php echo $disabled ? "disabled" : "" ?>>
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Email</label>
                            <input type="" class="form-control" name="email" required <?php echo $disabled ? "disabled" : "" ?>>
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Phone</label>
                            <input type="tel" name="phone" class="form-control" <?php echo $disabled ? "disabled" : "" ?>>
                          </div>
                        </div>
                        <div class="form-group row mt-2">
                          <div class="col-lg-6 mt-2">
                            <label class="required">Compliant Details</label>
                            <textarea type="text" rows="2" class="form-control" name="compliantdetails" required <?php echo $disabled ? "disabled" : "" ?>></textarea>
                          </div>
                        </div>
                        <div class="form-group row mt-2">
                          <div class="col-lg-6 mt-2">
                            <label>File Upload</label>
                            <div class="d-flex align-items-center">
                              <input type="file" class="form-control" name="files" accept=".pdf" multiple <?php echo $disabled ? "disabled"
                                                                                                            : "" ?>>
                              <button class="btn btn-secondary py-2 mt-2">Upload</button>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row mt-2">
                          <div class="col-md-12 mt-2">
                            <table class="table table-row-dashed fs-4 gy-5">
                              <thead>
                                <tr class="text-start text-muted text-uppercase gs-0">
                                  <th class="min-w-500px ps-4">
                                    File Name</th>
                                  <th class="min-w-100px ">
                                    Date</th>
                                  <th class="w-100px">
                                    Action
                                  </th>
                                </tr>
                              </thead>
                              <tbody class="text-gray-600 fw-bold" id="mitigation-table">
                                <tr>
                                  <td>
                                  <td>
                                  <td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <?php
                      if ($type != 1) {
                      ?>
                        <div class="card-footer">
                          <div class="row" style="text-align:center; float:right;">
                            <div class="mb-4">
                              <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">
                                <?php echo $type == 0 ? "Create" : "Update" ?>
                              </button>
                              <a type="button" href="javascript:history.back(-1)" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </form>
                </div>
              </div>

              <!--D1-D2-->
              <div class="tab-pane fade" id="d1-d2" role="tabpanel" aria-labelledby="mitigation-tab">
                <div class="card card-flush">
                  <form class="form" action="/includes/compliants/compliants_d1d2_proc.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="form-group row mt-2">
                        <div class="col-lg-4 mt-2">
                          <label class="required">Action Category</label>
                          <select class="form-control" id="actioncategory" name="actioncategory" required <?php echo $disabled ? "disabled" : "" ?>>
                            <option value="">Please select</option>
                            <?php
                            $results = mysqli_query($con, "select id, Title from cm_action_category;");
                            while ($row = mysqli_fetch_assoc($results)) {
                              echo "<option value='" . $row['id'] . "'>" . $row['Title'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-lg-8 mt-2">
                          <label class="required">Detail of Solution</label>
                          <input class="form-control" name="detailsofsolution" <?php echo $disabled ? "disabled" : "" ?> value="Test" />
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-3 mt-2">
                          <label class="required">Plant</label>
                          <select class="form-control" id="plant" name="plant" required <?php echo $disabled ? "disabled" : "" ?>>
                            <option value="">Please select</option>
                            <?php
                            $results = mysqli_query($con, "select Id_plant, Title from basic_plant;");
                            while ($row = mysqli_fetch_assoc($results)) {
                              echo "<option value='" . $row['Id_plant'] . "'>" . $row['Title'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                          <label class="required">Product Group</label>
                          <select class="form-control" id="productgroup" name="productgroup" required <?php echo $disabled ? "disabled" : "" ?>>
                            <option value="">Please select</option>
                            <?php
                            $results = mysqli_query($con, "select Id_product_group, Title from basic_product_group;");
                            while ($row = mysqli_fetch_assoc($results)) {
                              echo "<option value='" . $row['Id_product_group'] . "'>" . $row['Title'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                          <label class="required">Assign to Department</label>
                          <select class="form-control" id="assigntodepartment" name="assigntodepartment" required <?php echo $disabled ? "disabled" : "" ?>>
                            <option value="">Please select</option>
                            <?php
                            $results = mysqli_query($con, "select Id_department, Department from Basic_Department;");
                            while ($row = mysqli_fetch_assoc($results)) {
                              echo "<option value='" . $row['Id_department'] . "'>" . $row['Department'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                          <label class="required">Assign to Owner</label>
                          <select class="form-control" id="assigntoowner" name="assigntoowner" required <?php echo $disabled ? "disabled" : "" ?>>
                            <option value="">Please Select</option>
                            <option value="Owner1">Owner1</option>
                            <option value="Owener2">Owener2</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row mt-2">
                        <div class="col-lg-6 mt-2">
                          <label class="required">Team Members</label>
                          <input class="form-control" name="teammembers" <?php echo $disabled ?
                                                                            "disabled" : "" ?> />
                        </div>
                      </div>
                    </div>
                    <?php
                    if ($type != 1) {
                    ?>
                      <div class="card-footer m-6">
                        <div class="row" style="text-align:center; float:right;">
                          <div class="mb-4">
                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">
                              <?php echo $type == 0 ? "Create" : "Update" ?>
                            </button>
                            <a type="button" href="javascript:history.back(-1)" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>

              <!--D3-->
              <div class="tab-pane fade" id="d3" role="tabpanel" aria-labelledby="mitigation-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <h5 class="fw-bold text-primary m-0">
                          Preliminary Analysis
                        </h5>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <label class="required">Indicative Cause of Non Conformance</label>
                          <input class="form-control" name="" <?php echo $disabled ? "disabled" : "" ?> value="Test" />
                        </div>
                      </div>
                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <h5 class="fw-bold text-primary m-0">
                          Correction
                        </h5>
                        <?php
                        if ($type == 0) {
                        ?>
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewCorrection">
                            <i class="fa fa-plus"></i>
                            Add New Correction
                          </button>
                        <?php } ?>
                      </div>
                      <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                        <thead>
                          <tr class="text-start text-gray-400 text-uppercase gs-0">
                            <th class="min-w-135px">Correction</th>
                            <th class="min-w-150px">Who</th>
                            <th class="min-w-100px">when</th>
                            <th class="min-w-100px">Review</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-100px">Remarks</th>
                            <?php
                            if ($type != 1) {
                            ?>
                              <th class="min-w-100px">Action</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                          <?php
                          $results = mysqli_query($con, "select * from compliant_d3 INNER JOIN compliant_details_temp on compliant_d3.compliant_details_id=compliant_details_temp.compliant_details_id; 
                            ");
                          while ($row = mysqli_fetch_assoc($results)) {
                          ?>
                            <tr>
                              <td>
                                <?php echo $row['correction']; ?>
                              </td>
                              <td>
                                <?php echo $row['who']; ?>
                              </td>
                              <td>
                                <?php echo $row['when']; ?>
                              </td>
                              <td>
                                <div class="badge badge-light-success">
                                  OK
                                </div>
                              </td>
                              <td>
                                <div class="badge badge-light-success">
                                  <?php echo $row['status']; ?>
                                </div>
                              </td>
                              <td>
                                <?php echo $row['remarks']; ?>
                              </td>
                              <?php
                              if ($type != 1) {
                              ?>
                                <td>
                                  <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#addNewCorrection">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                  </button>
                                  <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                </td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <?php
                    if ($type != 1) {
                    ?>
                      <div class="card-footer m-6">
                        <div class="row" style="text-align:center; float:right;">
                          <div class="mb-4">
                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">
                              <?php
                              echo $type == 0 ? "Create" : "Update";
                              ?>
                            </button>
                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>

              <!--D4-->
              <div class="tab-pane fade" id="d4" role="tabpanel" aria-labelledby="mitigation-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <h5 class="fw-bold text-primary m-0">
                          Cause Analysis Table (4M Analysis)
                        </h5>
                        <?php
                        if ($type == 0) {
                        ?>
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewCauseAnalysis">
                            <i class="fa fa-plus"></i>
                            Add New Cause Analysis
                          </button>
                        <?php } ?>
                      </div>
                      <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                        <thead>
                          <tr class="text-start text-gray-400 text-uppercase gs-0">
                            <th class="min-w-135px">Category</th>
                            <th class="min-w-150px">Cause</th>
                            <th class="min-w-100px">Remark</th>
                            <th class="min-w-100px">Significant</th>
                            <?php
                            if ($type != 1) {
                            ?>
                              <th class="min-w-100px">Action</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                          <?php
                          $results = mysqli_query($con, "select * from compliant_d4_cause_analysis INNER JOIN compliant_details_temp on compliant_d4_cause_analysis.compliant_details_id=compliant_details_temp.compliant_details_id;");
                          while ($row = mysqli_fetch_assoc($results)) {
                          ?>
                            <tr>
                              <td>
                                <?php echo $row['category']; ?>
                              </td>
                              <td>
                                <?php echo $row['cause']; ?>
                              </td>
                              <td>
                                <?php echo $row['remarks']; ?>
                              </td>
                              <td>
                                <?php
                                $ans = $row['significant'] == 1 ?
                                  "<div class='badge badge-light-success'>Yes</div>"
                                  : "<div class='badge badge-light-danger'>No</div>";
                                echo $ans;
                                ?>
                              </td>
                              <?php
                              if ($type != 1) {
                              ?>
                                <td>
                                  <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#addNewCauseAnalysis">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                  </button>
                                  <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                </td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>

                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <h5 class="fw-bold text-primary m-0">
                          Why Analysis
                        </h5>
                        <?php
                        if ($type == 0) {
                        ?>
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewWhyAnalysis">
                            <i class="fa fa-plus"></i>
                            Add New Why Analysis
                          </button>
                        <?php } ?>
                      </div>
                      <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                        <thead>
                          <tr class="text-start text-gray-400 text-uppercase gs-0">
                            <th class="min-w-135px">Signiticant Cause</th>
                            <th class="min-w-100px">1st Why</th>
                            <th class="min-w-100px">2nd Why</th>
                            <th class="min-w-100px">3rd Why</th>
                            <th class="min-w-100px">4th Why</th>
                            <th class="min-w-100px">5th Why</th>
                            <th class="min-w-100px">Boot Cause</th>
                            <?php
                            if ($type != 1) {
                            ?>
                              <th class="min-w-100px">Action</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                          <?php
                          $results = mysqli_query($con, "                        select * from compliant_d4_why_analysis INNER JOIN compliant_details_temp on compliant_d4_why_analysis.compliant_details_id=compliant_details_temp.compliant_details_id;
                          ");
                          while ($row = mysqli_fetch_assoc($results)) {
                          ?>
                            <tr>
                              <td>
                                <?php echo $row['cause']; ?>
                              </td>
                              <td>
                                <?php echo $row['firstwhy']; ?>
                              </td>
                              <td>
                                <?php echo $row['secondwhy']; ?>
                              </td>
                              <td>
                                <?php echo $row['thirdwhy']; ?>
                              </td>
                              <td>
                                <?php echo $row['forthwhy']; ?>
                              </td>
                              <td>
                                <?php echo $row['fifthwhy']; ?>
                              </td>
                              <td>
                                <?php
                                $ans = $row['first_isrootcause'] == 1 ?
                                  "<div class='badge badge-light-success'>Yes</div>"
                                  : "<div class='badge badge-light-danger'>No</div>";
                                echo $ans;
                                ?>
                              </td>
                              <?php
                              if ($type != 1) {
                              ?>
                                <td>
                                  <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#addNewWhyAnalysis">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                  </button>
                                  <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                </td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>

                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <h5 class="fw-bold text-primary m-0">
                          Corrective Action Plan
                        </h5>
                        <?php
                        if ($type == 0) {
                        ?>
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewCorrectiveActionPlan">
                            <i class="fa fa-plus"></i>
                            Add New Corrective Action Plan
                          </button>
                        <?php } ?>
                      </div>
                      <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                        <thead>
                          <tr class="text-start text-gray-400 text-uppercase gs-0">
                            <th class="min-w-135px">Root Cause</th>
                            <th class="min-w-150px">Corrective Action</th>
                            <th class="min-w-100px">Who</th>
                            <th class="min-w-100px">When</th>
                            <th class="min-w-100px">#Review</th>
                            <th class="min-w-100px">Status</th>
                            <?php
                            if ($type != 1) {
                            ?>
                              <th class="min-w-100px">Action</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                          <?php
                          $results = mysqli_query($con, "select * from compliant_d4_corrective_action INNER JOIN compliant_details_temp on compliant_d4_corrective_action.compliant_details_id=compliant_details_temp.compliant_details_id INNER JOIN Basic_Employee on compliant_d4_corrective_action.who=Basic_Employee.Id_employee;");
                          while ($row = mysqli_fetch_assoc($results)) {
                          ?>
                            <tr>
                              <td>
                                <?php echo $row['root_cause']; ?>
                              </td>
                              <td>
                                <?php echo $row['correction_action']; ?>
                              </td>
                              <td>
                                <?php echo $row['Customer_Name']; ?>
                              </td>
                              <td>
                                <?php echo $row['when']; ?>
                              </td>
                              <td>
                                <div class="badge badge-light-success">
                                  OK
                                </div>
                              </td>
                              <td>
                                <div class="badge badge-light-success">
                                  <?php echo $row['status']; ?>
                                </div>
                              </td>
                              <?php
                              if ($type != 1) {
                              ?>
                                <td>
                                  <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#addNewCorrectiveActionPlan">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                  </button>
                                  <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                </td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>

                    </div>
                    <?php
                    if ($type != 1) {
                    ?>
                      <div class="card-footer m-6">
                        <div class="row" style="text-align:center; float:right;">
                          <div class="mb-4">
                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">
                              <?php echo $type == 0 ? "Create" : "Update" ?>
                            </button>

                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>

              <!--D6-D7-->
              <div class="tab-pane fade" id="d6-d7" role="tabpanel" aria-labelledby="mitigation-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <h5 class="fw-bold text-primary m-0">
                          Verification
                        </h5>
                        <?php
                        if ($type == 0) {
                        ?>
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewVerification">
                            <i class="fa fa-plus"></i>
                            Add New Verification
                          </button>
                        <?php } ?>
                      </div>
                      <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                        <thead>
                          <tr class="text-start text-gray-400 text-uppercase gs-0">
                            <th class="min-w-135px">Root Cause</th>
                            <th class="min-w-150px">Corrective Action</th>
                            <th class="min-w-100px">Who</th>
                            <th class="min-w-100px">when</th>
                            <th class="min-w-100px">Verified</th>
                            <?php
                            if ($type != 1) {
                            ?>
                              <th class="min-w-100px">Action</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                          <?php
                          $results = mysqli_query($con, "select * from compliant_d6d7 INNER JOIN compliant_details_temp on compliant_d6d7.compliant_details_id=compliant_details_temp.compliant_details_id INNER JOIN Basic_Customer on compliant_d6d7.who=Basic_Customer.Id_customer;");
                          while ($row = mysqli_fetch_assoc($results)) {
                          ?>
                            <tr>
                              <td>
                                <?php echo $row['root_cause']; ?>
                              </td>
                              <td>
                                <?php echo $row['correction_action']; ?>
                              </td>
                              <td>
                                <?php echo $row['Customer_Name']; ?>
                              </td>
                              <td>
                                <?php echo $row['when']; ?>
                              </td>
                              <td>
                                <div class="badge badge-light-success">
                                  <?php echo $row['verified']; ?>
                                </div>
                              </td>
                              <?php
                              if ($type != 1) {
                              ?>
                                <td>
                                  <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#addNewVerification">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                  </button>
                                  <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                </td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <?php
                    if ($type != 1) {
                    ?>
                      <div class="card-footer m-6">
                        <div class="row" style="text-align:center; float:right;">
                          <div class="mb-4">
                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">
                              <?php echo $type == 0 ? "Create" : "Update" ?>
                            </button>
                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>

              <!--D8-->
              <div class="tab-pane fade" id="d8" role="tabpanel" aria-labelledby="mitigation-tab">
                <div class="card card-flush">

                  <div class="card-body text-center">
                    <img src="https://img.icons8.com/bubbles/200/000000/trophy.png">
                    <h3 class="font-weight-bold text-danger">CONGRATULATIONS!</h3>
                    <p>
                      Appreciate everyone worked in this project and supported customer in
                      their hard time.
                    </p>
                    <p class="fst-italic">
                      Keep it up, build better process & great brand,
                    </p>

                  </div>
                  <?php
                  if ($type != 1) {
                  ?>
                    <div class="card-footer m-6">
                      <div class="row" style="text-align:center; float:right;">
                        <div class="mb-4">
                          <form action='/includes/compliants/compliants_d8.php' method='POST'>
                            <button type="submit" class="btn btn-sm btn-success">
                              <?php echo $type == 0 ? "Create" : "Update" ?>
                            </button>
                            <a type="button" href="/compliants.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </form>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end::Container-->

    <!--Add New correction Modal-->
    <div class="modal right fade" id="addNewCorrection" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title right-modal text-white">Correction</h5>
            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="form" action="/includes/compliants/compliants_d3.php" method="post">
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Correction</label>
                  <textarea class="form-control" name='correction' placeholder="Test CA"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Who</label>
                  <select class="form-control" id="" name="who" required>
                    <option value="">Please Select</option>
                    <?php
                    $results = mysqli_query($con, "SELECT Id_employee, First_Name, Last_Name FROM Basic_Employee WHERE status = 'Active'");
                    while ($row = mysqli_fetch_assoc($results)) {
                      echo "<option value='" . $row['Id_employee'] . "'>" . $row['First_Name'] . ' ' . $row['Last_Name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">When</label>
                  <input type="date" class="form-control" name="when" value="<?php echo date('Y-m-d'); ?>" required />
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">How</label>
                  <textarea name='how' class="form-control" placeholder="Test"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Status</label>
                  <select class="form-control" id="" name="status" required>
                    <option value="">Please Select</option>
                    <option>0%</option>
                    <option>25%</option>
                    <option>50%</option>
                    <option>75%</option>
                    <option>100%</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Remarks</label>
                  <textarea name='remarks' class="form-control" placeholder="Test CA"></textarea>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!--Add New Verification Modal-->
    <div class="modal right fade" id="addNewVerification" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title right-modal text-white">Verification</h5>
            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="form" action="/includes/compliants/compliants_d6d7.php" method="post">

              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Root Cause</label>
                  <textarea name='root_cause' class="form-control" placeholder="Test CA"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Corrective Action</label>
                  <textarea name='correction_action' class="form-control" placeholder="Test"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Who</label>
                  <select class="form-control" id="" name="who" required>
                    <option value="">Please Select</option>
                    <?php
                    $results = mysqli_query($con, "SELECT Id_employee, First_Name, Last_Name FROM Basic_Employee WHERE status = 'Active'");
                    while ($row = mysqli_fetch_assoc($results)) {
                      echo "<option value='" . $row['Id_employee'] . "'>" . $row['First_Name'] . ' ' . $row['Last_Name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">When</label>
                  <input type="date" class="form-control" name="when" value="<?php echo date('Y-m-d'); ?>" required />
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="">How</label>
                  <textarea name='how' class="form-control" placeholder="Test"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <div class="form-check">
                    <input name='moc' class="form-check-input" type="checkbox" value="" id="moc" checked>
                    <label class="form-check-label" for="moc">
                      MoC
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="riskAssessment" checked name='risk_assessment'>
                    <label class="form-check-label" for="riskAssessment">
                      Risk Assessment
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Status</label>
                  <select class="form-control" id="" name="status" required>
                    <option value="">Please Select</option>
                    <option>0%</option>
                    <option>25%</option>
                    <option>50%</option>
                    <option>75%</option>
                    <option>100%</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="">Verified</label>
                  <select class="form-control" id="" name="verified" required>
                    <option value="">Please Select</option>
                    <option value="verified">Verified</option>
                    <option value="Not verified">Not verified</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="">Remarks</label>
                  <input type="" name="remarks" class="form-control">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
        </form>
      </div>
    </div>

    <!--Add New Cause Analysis Modal-->
    <div class="modal right fade" id="addNewCauseAnalysis" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title right-modal text-white">Cause Analysis</h5>
            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form class="form" action="/includes/compliants/compliants_d4_cause_analysis.php" method="post">

            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Category</label>
                  <select class="form-control" id="category" name="category" required>
                    <option value="">Please Select</option>
                    <?php
                    $results = mysqli_query($con, "SELECT id, title FROM category");
                    while ($row = mysqli_fetch_assoc($results)) {
                      echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Cause</label>
                  <textarea name='cause' class="form-control" placeholder="Test" rows="2"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Remarks</label>
                  <textarea name='remarks' class="form-control" rows="3"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="moc" checked name='significant'>
                    <label class="form-check-label" for="moc">
                      Significant
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--Add New Why Why Analysis Modal-->
    <div class="modal right fade" id="addNewWhyAnalysis" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title right-modal text-white">Why Why Analysis</h5>
            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="form" action="/includes/compliants/compliants_d4_why_analysis.php" method="post">
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Significant Cause</label>
                  <select class="form-control" id="" name="cause" required>
                    <option value="">Please Select</option>
                    <option value="Cause1">Cause1</option>
                    <option value="Cause2">Cause2</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="">1st Why</label>
                  <textarea name='firstwhy' class="form-control" placeholder="Test why" rows="2"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="moc" checked name='first_isrootcause'>
                    <label class="form-check-label" for="moc">
                      Is Root Cause?
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="">2nd Why</label>
                  <textarea name='secondwhy' class="form-control" placeholder="" rows="2"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="moc" name='second_isrootcause'>
                    <label class="form-check-label" for="moc">
                      Is Root Cause?
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="">3rd Why</label>
                  <textarea name='thirdwhy' class="form-control" placeholder="" rows="2"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="moc" name='third_isrootcause'>
                    <label class="form-check-label" for="moc">
                      Is Root Cause?
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="">4th Why</label>
                  <textarea name='forthwhy' class="form-control" placeholder="" rows="2"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="moc" name='forth_isrootcause'>
                    <label class="form-check-label" for="moc">
                      Is Root Cause?
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="">5th Why</label>
                  <textarea name='fifthwhy' class="form-control" placeholder="" rows="2"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-check">
                    <input name='fifth_isrootwhy' class="form-check-input" type="checkbox" value="" id="moc">
                    <label class="form-check-label" for="moc">
                      Is Root Cause?
                    </label>
                  </div>
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
        </form>
      </div>
    </div>

    <!--Add New Corrective Action Modal-->
    <div class="modal right fade" id="addNewCorrectiveActionPlan" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title right-modal text-white">Corrective Action</h5>
            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="form" action="/includes/compliants/compliants_d4_corrective_action.php" method="post">

              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Root Cause</label>
                  <textarea name='root_cause' class="form-control" placeholder="Test CA"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Corrective Action</label>
                  <textarea name='correction_action' class="form-control" placeholder="Test"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Who</label>
                  <select class="form-control" id="" name="who" required>
                    <option value="">Please Select</option>
                    <?php
                    $results = mysqli_query($con, "SELECT Id_employee, First_Name, Last_Name FROM Basic_Employee WHERE status = 'Active'");
                    while ($row = mysqli_fetch_assoc($results)) {
                      echo "<option value='" . $row['Id_employee'] . "'>" . $row['First_Name'] . ' ' . $row['Last_Name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">When</label>
                  <input type="date" class="form-control" name="when" value="<?php echo date('Y-m-d'); ?>" required />
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">How</label>
                  <textarea name='how' class="form-control" placeholder="Test"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name='moc' id="moc" checked>
                    <label class="form-check-label" for="moc">
                      MoC
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name='risk_assessment' id="riskAssessment" checked>
                    <label class="form-check-label" for="riskAssessment">
                      Risk Assessment
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-4">
                  <label class="required">Status</label>
                  <select class="form-control" id="" name="status" required>
                    <option value="">Please Select</option>
                    <option value='Active'>Active</option>
                    <option value='Deactive'>Deactive</option>
                  </select>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include 'includes/footer.php'; ?>
  </div>
  <!--end::Wrapper-->
  </div>
  <!--end::Page-->
  </div>
  <!--end::Root-->
  <!--end::Main-->
  <?php include 'includes/scrolltop.php'; ?>
  <!--begin::Javascript-->
  <script>
    var hostUrl = "assets/";
    $("input").intlTelInput({
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
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
</body>
<!--end::Body-->

</html>