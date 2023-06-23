<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "NCR Details";
$type = $_REQUEST['type'];
$disabled = $type == 1 ? true : false;
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
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
                        <div>
                            <p><a href="/">Home</a> » <a href="/ncr.php">NCR</a> » <a href="/ncr_view_list.php">NCR
                                    List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
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
                                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">NCR Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="correction-tab" data-bs-toggle="tab" data-bs-target="#correction" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Correction</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="disposition_tab" data-bs-toggle="tab" data-bs-target="#disposition" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Disposition</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="analysis-tab" data-bs-toggle="tab" data-bs-target="#analysis" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Analysis & CA</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="verification-tab" data-bs-toggle="tab" data-bs-target="#verification" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Verification</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="approval-tab" data-bs-toggle="tab" data-bs-target="#approval" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Approval</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card card-flush">
                                    <form class="form" action="" method="post" enctype="multipart/form-data">
                                        <!-- begin::Form Content -->
                                        <div class="card-body">
                                            <div id="custom-section-1">
                                                <!-- 
													<div class="form-group row mt-2">
														<div class="col-lg-3 mt-2">
				                      <label class="required">Date</label>
				                      <input type="date" class="form-control" name="date"
				                        id="date" value="<?php echo date('Y-m-d'); ?>" required <?php echo $disabled ? "disabled" : ""  ?> />
				                    </div>
														<div class="col-lg-3 mt-2">
															<label class="required">Plant</label>
															<select class="form-control" name="plant_id" id="plant" required <?php echo $disabled ? "disabled" : ""  ?>>
																<option value="0">Please Select</option>
																<?php
                                                                $sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
                                                                $connect_data = mysqli_query($con, $sql_data);
                                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                    if ($result_data['Status'] == 'Active') {
                                                                        $selected = $risk['plant_id'] == $result_data['Id_plant'] ? 'selected' : '';
                                                                ?>
																		<option value="<?php echo $result_data['Id_plant']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?>
																		</option>
																<?php
                                                                    }
                                                                }
                                                                ?>
															</select>
														</div>
														<div class="col-lg-3 mt-2">
															<label class="required">Product Group</label>
															<select class="form-control" id="product_group" name="product_group_id" required <?php echo $disabled ? "disabled" : ""  ?>>
																<option value="">Please Select</option>
															</select>
														</div>
														<div class="col-lg-3 mt-2">
															<label class="required">Department</label>
															<select class="form-control" id="department" name="department_id" required <?php echo $disabled ? "disabled" : ""  ?>>
																<option value="">Please Select</option>
															</select>
														</div>
													</div>
 												-->
                                                <div class="form-group row mt-2">
                                                    <div class="col-lg-3 mt-2">
                                                        <label class="required">Process</label>
                                                        <select class="form-control" name="process_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Quality_Process";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $risk['process_id'] == $result_data['Id_quality_process'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['Id_quality_process']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-2">
                                                        <label class="required">NCR Type</label>

                                                        <select class="form-control" id="" name="" required <?php echo $disabled ? "disabled" : ""  ?> onchange="handleChangeType(this);">
                                                            <option value="both">Both</option>
                                                            <option value="prodc">Product</option>
                                                            <option value="process">Process</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-2" id="component_name">
                                                        <label class="required">Component Name</label>
                                                        <input class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-2" id="component_quantity">
                                                        <label class="required">Component Quantity</label>

                                                        <input type="number" class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                                                    </div>
                                                </div>

                                                <div class="form-group row mt-2">
                                                    <div class="col-lg-6 mt-2">
                                                        <label class="required">Non conformance Details</label>
                                                        <input type="number" class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                                                    </div>
                                                    <div class="col-lg-6 mt-2">
                                                        <label class="required">Evidence Details</label>
                                                        <input type="number" class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                                                    </div>
                                                </div>

                                                <div class="form-group row mt-2">
                                                    <div class="col-lg-6 mt-2">
                                                        <label class="required">Similar NCR in other process/products
                                                            (Mention Yes/No)</label>
                                                        <input type="number" class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                                                    </div>
                                                    <div class="col-lg-6 mt-2">
                                                        <label class="required">Background</label>
                                                        <input type="number" class="form-control" name="" id="" value="Test Background" <?php echo $disabled ? "disabled" : ""  ?> />
                                                    </div>
                                                </div>

                                                <div class="form-group row mt-2">
                                                    <div class="col-lg-12 mt-2">
                                                        <label class="required">Recommended Solution</label>
                                                        <input type="number" class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                                                    </div>
                                                </div>

                                                <div class="form-group row mt-2">
                                                    <div class="col-lg-3 mt-2">
                                                        <label class="required">Assign to Department</label>
                                                        <select class="form-control" id="department" name="department_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-2">
                                                        <label class="required">Assign to Owner</label>
                                                        <select class="form-control" id="department" name="department_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 mt-2">
                                                        <label>File Upload</label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="file" class="form-control" name="files[]" accept=".pdf" multiple <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <button class="btn btn-secondary py-2 mt-2">Upload</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-2">
                                                    <div class="col-md-12 mt-2">
                                                        <table class="table table-row-dashed fs-4 gy-5">
                                                            <thead>
                                                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-500px ps-4">
                                                                        File Name</th>
                                                                    <th class="min-w-100px ">
                                                                        Uploaded On</th>
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
                                                                <?php echo $type == 0 ? "Create" : "Update"  ?>
                                                            </button>
                                                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="correction" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <!-- <div class="d-flex mt-4">
								  			<h5 class="fw-bold text-primary m-0">
									  			Indicative cause Analysis
									  		</h5>
								  		</div> -->

                                            <div class="form-group row mt-2">
                                                <div class="col-lg-12 mt-2">
                                                    <label class="required">Inidicative cause Analysis</label>
                                                    <input class="form-control" name="" <?php echo $disabled ? "disabled" : ""  ?> />
                                                </div>
                                            </div>
                                            <!-- <div class="d-flex mt-4">
								  			<h5 class="fw-bold text-primary m-0">
									  			Correction
									  		</h5>
								  		</div> -->

                                            <div class="form-group row mt-2">
                                                <div class="col-lg-4 mt-2">
                                                    <label class="required">Correction</label>
                                                    <select class="form-control" id="" name="" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        <option value="">Please Select</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-8 mt-2">
                                                    <label class="required">Details of Correction</label>
                                                    <input class="form-control" name="" <?php echo $disabled ? "disabled" : ""  ?> />
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
                                                        <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="disposition" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="form-group row mt-2">
                                                <div class="col-lg-4 mt-2">
                                                    <label class="required">Disposition</label>
                                                    <select class="form-control" id="" name="" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        <option value="">Please Select</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-8 mt-2">
                                                    <label class="required">Detail of Disposition</label>
                                                    <input class="form-control" name="" <?php echo $disabled ? "disabled" : ""  ?> />
                                                </div>
                                            </div>

                                            <div class="form-group row mt-2">
                                                <div class="col-lg-3 mt-2">
                                                    <label class="required">Customer Approval Required</label>
                                                    <select class="form-control" id="" name="" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        <option value="">Yes</option>
                                                        <option value="">No</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 mt-2">
                                                    <label class="required">Recommend to Design Head
                                                        intervention</label>
                                                    <select class="form-control" id="" name="" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        <option value="">Yes</option>
                                                        <option value="">No</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 mt-2">
                                                    <label class="required">Design Head Department</label>
                                                    <select class="form-control" id="" name="" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        <option value="">Please Select</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 mt-2">
                                                    <label class="required">Design Head</label>
                                                    <select class="form-control" id="" name="" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        <option value="">Please Select</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mt-2">
                                                <div class="col-lg-4 mt-2">
                                                    <label class="required">Disposition</label>
                                                    <select class="form-control" id="" name="" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        <option value="">Please Select</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-8 mt-2">
                                                    <label class="required">Details of Disposition</label>
                                                    <input class="form-control" name="" <?php echo $disabled ? "disabled" : ""  ?> />
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

                            <div class="tab-pane fade" id="analysis" role="tabpanel" aria-labelledby="mitigation-tab">
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
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-135px">Category</th>
                                                        <th class="min-w-150px">Cause</th>
                                                        <th class="min-w-100px">Remark</th>
                                                        <th class="min-w-100px">Significant</th>
                                                        <?php
                                                        if ($type != 1) {
                                                        ?>
                                                            <th class="min-w-100px">Action</th>
                                                        <?php }  ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">
                                                    <tr>
                                                        <td>
                                                            Man
                                                        </td>
                                                        <td>
                                                            Test
                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>
                                                            Yes
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
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
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
                                                        <?php }  ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">
                                                    <tr>
                                                        <td>
                                                            Test
                                                        </td>
                                                        <td>
                                                            Test Why
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Test Why</td>
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
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
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
                                                        <?php }  ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">
                                                    <tr>
                                                        <td>
                                                            Test Why
                                                        </td>
                                                        <td>
                                                            Test CA
                                                        </td>
                                                        <td>
                                                            Santhosh G
                                                        </td>
                                                        <td>
                                                            14/10/2022
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-light-success">
                                                                OK
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-light-success">
                                                                100%
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
                                                </tbody>
                                            </table>

                                        </div>
                                        <?php
                                        if ($type != 1) {
                                        ?>
                                            <div class="card-footer m-6">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-4">
                                                        <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1"><?php echo $type == 0 ? "Create" : "Update"  ?></button>

                                                        <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="verification" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mt-4">
                                                <h5 class="fw-bold text-primary m-0">
                                                    Effectiveness Verification
                                                </h5>
                                                <?php
                                                if ($type == 0) {
                                                ?>
                                                    <!-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewVerification">
									  			<i class="fa fa-plus"></i>
									  			Add New Verification
									  		</button> -->
                                                <?php } ?>
                                            </div>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
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
                                                    <tr>
                                                        <td>
                                                            Test CA
                                                        </td>
                                                        <td>
                                                            Test
                                                        </td>
                                                        <td>
                                                            Mahesh K
                                                        </td>
                                                        <td>
                                                            02/12/2021
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-light-success">
                                                                OK
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
                                                        <?php }  ?>
                                                    </tr>
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
                                                            <?php echo $type == 0 ? "Create" : "Update"  ?>
                                                        </button>
                                                        <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="approval" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mt-4">
                                                <h5 class="fw-bold text-primary m-0">
                                                    MR Approval
                                                </h5>
                                                <?php
                                                if ($type == 0) {
                                                ?>
                                                    <!-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewApproval">
									  			<i class="fa fa-plus"></i>
									  			Add New MR Approval
									  		</button> -->
                                                <?php } ?>
                                            </div>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-135px">Root Cause</th>
                                                        <th class="min-w-150px">Corrective Action</th>
                                                        <th class="min-w-100px">Who</th>
                                                        <th class="min-w-100px">when</th>
                                                        <th class="min-w-100px">MR Approved</th>
                                                        <?php
                                                        if ($type != 1) {
                                                        ?>
                                                            <th class="min-w-100px">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">
                                                    <tr>
                                                        <td>
                                                            Test CA
                                                        </td>
                                                        <td>
                                                            Test
                                                        </td>
                                                        <td>
                                                            Mahesh K
                                                        </td>
                                                        <td>
                                                            02/12/2021
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-light-success">
                                                                OK
                                                            </div>
                                                        </td>
                                                        <?php
                                                        if ($type != 1) {
                                                        ?>
                                                            <td>
                                                                <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#addNewApproval">
                                                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                </button>
                                                                <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        <?php }  ?>
                                                    </tr>
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
                                                            <?php echo $type == 0 ? "Create" : "Update"  ?>
                                                        </button>
                                                        <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->

        <!--Add New Cause Analysis Modal-->
        <div class="modal right fade" id="addNewCauseAnalysis" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title right-modal text-white">Cause Analysis</h5>
                        <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Category</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Cause</label>
                                <textarea class="form-control" placeholder="Test" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Remarks</label>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc" checked>
                                    <label class="form-check-label" for="moc">
                                        Significant
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    </div>
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
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Significant Cause</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">1st Why</label>
                                <textarea class="form-control" placeholder="Test why" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc" checked>
                                    <label class="form-check-label" for="moc">
                                        Is Root Cause?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">2nd Why</label>
                                <textarea class="form-control" placeholder="" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc">
                                    <label class="form-check-label" for="moc">
                                        Is Root Cause?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">3rd Why</label>
                                <textarea class="form-control" placeholder="" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc">
                                    <label class="form-check-label" for="moc">
                                        Is Root Cause?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">4th Why</label>
                                <textarea class="form-control" placeholder="" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc">
                                    <label class="form-check-label" for="moc">
                                        Is Root Cause?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">5th Why</label>
                                <textarea class="form-control" placeholder="" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc">
                                    <label class="form-check-label" for="moc">
                                        Is Root Cause?
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    </div>
                </div>
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
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Root Cause</label>
                                <textarea class="form-control" placeholder="Test CA"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Corrective Action</label>
                                <textarea class="form-control" placeholder="Test"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Who</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
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
                                <textarea class="form-control" placeholder="Test"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc" checked>
                                    <label class="form-check-label" for="moc">
                                        MoC
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="riskAssessment" checked>
                                    <label class="form-check-label" for="riskAssessment">
                                        Risk Assessment
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Status</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    </div>
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
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Root Cause</label>
                                <textarea class="form-control" placeholder="Test CA"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Corrective Action</label>
                                <textarea class="form-control" placeholder="Test"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Who</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
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
                                <textarea class="form-control" placeholder="Test"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc" checked>
                                    <label class="form-check-label" for="moc">
                                        MoC
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="riskAssessment" checked>
                                    <label class="form-check-label" for="riskAssessment">
                                        Risk Assessment
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Status</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">Verified</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">Remarks</label>
                                <input type="" name="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Add New MR Approval Modal-->
        <div class="modal right fade" id="addNewApproval" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title right-modal text-white">MR Approval</h5>
                        <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Root Cause</label>
                                <textarea class="form-control" placeholder="Test CA"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Corrective Action</label>
                                <textarea class="form-control" placeholder="Test"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Who</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
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
                                <textarea class="form-control" placeholder="Test"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="moc" checked>
                                    <label class="form-check-label" for="moc">
                                        MoC
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="riskAssessment" checked>
                                    <label class="form-check-label" for="riskAssessment">
                                        Risk Assessment
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Status</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">Verified</label>
                                <select class="form-control" id="" name="" required>
                                    <option value="">Please Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="">Remarks</label>
                                <input type="" name="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
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
        const handleChangeType = (selectObj) => {
            const selectedIndex = selectObj.selectedIndex;
            const componentNameEl = document.getElementById('component_name');
            const componentQuantityEl = document.getElementById('component_quantity');
            const dispositionTabEl = document.getElementById('disposition_tab');
            if (selectedIndex === 2) {
                componentNameEl.classList.remove('d-block');
                componentNameEl.classList.add('d-none');
                componentQuantityEl.classList.remove('d-block');
                componentQuantityEl.classList.add('d-none');
                dispositionTabEl.classList.remove('d-block');
                dispositionTabEl.classList.add('d-none');
            } else {
                componentNameEl.classList.remove('d-none');
                componentNameEl.classList.add('d-block');
                componentQuantityEl.classList.remove('d-none');
                componentQuantityEl.classList.add('d-block');
                dispositionTabEl.classList.remove('d-none');
                dispositionTabEl.classList.add('d-block');
            }
            //0: both
            //1: product
            //2: process
        }
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