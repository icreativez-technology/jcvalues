<?php
session_start();
include('includes/functions.php');
$sqlData = "SELECT * FROM q_alert WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$qAlert = mysqli_fetch_assoc($connectData);
$headReviewSqlData = "SELECT * FROM q_alert_head_review WHERE q_alert_id = '$_REQUEST[id]'";
$headReviewSqlConnectData = mysqli_query($con, $headReviewSqlData);
$headReview = mysqli_fetch_assoc($headReviewSqlConnectData);
$hodDisabled = $headReviewSqlConnectData->num_rows == 0 ? true : false;
$headReview['action_category_id'] = (isset($headReview['action_category_id'])) ? $headReview['action_category_id'] : $qAlert['action_category_id'];
$headReview['detail_of_solution'] = (isset($headReview['detail_of_solution'])) ? $headReview['detail_of_solution'] : $qAlert['detail_of_solution'];
$headReview['owner'] = (isset($headReview['owner'])) ? $headReview['owner'] : 0;

$hodReviewSqlData = "SELECT * FROM q_alert_hod_review WHERE q_alert_id = '$_REQUEST[id]'";
$hodReviewSqlConnectData = mysqli_query($con, $hodReviewSqlData);
$hodReview = mysqli_fetch_assoc($hodReviewSqlConnectData);
$correctiveActionDisabled = $hodReviewSqlConnectData->num_rows == 0 ? true : false;
$hodReview['action_category_id'] = (isset($hodReview['action_category_id'])) ? $hodReview['action_category_id'] : $headReview['action_category_id'];
$hodReview['detail_of_solution'] = (isset($hodReview['detail_of_solution'])) ? $hodReview['detail_of_solution'] : $headReview['detail_of_solution'];
$hodReview['owner'] = (isset($hodReview['owner'])) ? $hodReview['owner'] : 0;

$correctiveActionSqlData = "SELECT * FROM q_alert_corrective_action WHERE q_alert_id = '$_REQUEST[id]' AND is_deleted = 0";
$correctiveActionSqlConnectData = mysqli_query($con, $correctiveActionSqlData);
$correctiveAction =  array();
while ($row = mysqli_fetch_assoc($correctiveActionSqlConnectData)) {
	array_push($correctiveAction, $row);
}
$verificationDisabled = true;
if ($correctiveAction && count($correctiveAction) > 0) {
	$sql = "SELECT * FROM q_alert_corrective_action WHERE q_alert_id = '$_REQUEST[id]' AND is_deleted = 0 AND status = '100%'";
	$connectData = mysqli_query($con, $sql);
	$verificationDisabled = count($correctiveAction) != $connectData->num_rows ? true : false;
}

$_SESSION['Page_Title'] = "Edit Q-Alert - " . $qAlert['q_alert_id'];
?>
<script>
	var productGroup = <?php echo $qAlert['product_group_id']; ?>;
	var department = <?php echo $qAlert['department_id']; ?>;
	var headOwner = <?php echo $headReview['owner']; ?>;
	var hodOwner = <?php echo $hodReview['owner']; ?>;
</script>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!--begin::Body-->

<style>
	.custom-tab .nav-link {
		border-radius: 3px;
		padding: 8px 20px;
	}

	.custom-tab .nav-link.active {
		color: #fff !important;
		background-color: #009ef7;
	}

	.custom-tab .nav-link.active:hover {
		color: #fff !important;
	}

	.required::after {
		content: "*";
		color: #e1261c;
	}

	.custom-select {
		background-color: #f5f8fa;
		border: 1px solid #e4e6ef;
		border-radius: 6px;
		width: 100%;
		padding: 3px;
		min-height: 38px;
	}

	.custom-select .tag-wrapper {
		list-style: none;
		display: flex;
		justify-content: flex-start;
		align-content: flex-start;
		flex-wrap: wrap;
	}

	.tag-wrapper .tags {
		position: relative;
		padding: 0px 15px 0px 6px;
		margin: 4px;
		text-align: left;
		background-color: #e1e2e4;
		border-radius: 5px;
	}

	.tag-wrapper .tags span {
		position: absolute;
		right: 4px;
		cursor: pointer;
		color: #002429;
	}

	.tag-wrapper .tags span::after {
		content: "x";
		font-weight: 600;
	}

	.tag-wrapper .tags span:hover {
		color: #e1261c;
	}

	.tag-wrapper .tags a {
		color: #002429;
	}

	.tag-wrapper .tags a:hover {
		color: #e1261c;
	}

	.ver-disabled {
		background-color: #e9ecef !important;
	}

	.modal.left .modal-dialog,
	.modal.right .modal-dialog {
		position: fixed;
		top: 0 !important;
		right: 0 !important;
		margin: auto;
		width: 320px;
		height: 100%;
		-webkit-transform: translate3d(0%, 0, 0);
		-ms-transform: translate3d(0%, 0, 0);
		-o-transform: translate3d(0%, 0, 0);
		transform: translate3d(0%, 0, 0);
	}

	.modal.left .modal-content,
	.modal.right .modal-content {
		height: 100%;
		overflow-y: auto;
	}

	.modal.left .modal-body,
	.modal.right .modal-body {
		padding: 15px 15px 15px;
	}

	/*Left*/
	.modal.left.fade .modal-dialog {
		left: -320px;
		-webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
		-moz-transition: opacity 0.3s linear, left 0.3s ease-out;
		-o-transition: opacity 0.3s linear, left 0.3s ease-out;
		transition: opacity 0.3s linear, left 0.3s ease-out;
	}

	.modal.left.fade.in .modal-dialog {
		left: 0;
	}

	/*Right*/
	.modal.right.fade .modal-dialog {
		right: -320px;
		-webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
		-moz-transition: opacity 0.3s linear, right 0.3s ease-out;
		-o-transition: opacity 0.3s linear, right 0.3s ease-out;
		transition: opacity 0.3s linear, right 0.3s ease-out;
	}

	.modal.right.fade.in .modal-dialog {
		right: 0;
	}
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
	<!--begin::Main-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">
			<?php include('includes/aside-menu.php'); ?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include('includes/header.php'); ?>
				<!--begin::BREADCRUMBS-->
				<div class="row breadcrumbs">
					<!--begin::body-->
					<div>
						<div>
							<p><a href="/">Home</a> » <a href="/q_alert.php">Q-Alert</a> » <a href="/q_alert_view_list.php">Q-Alert List</a> »
								<?php echo $_SESSION['Page_Title']; ?></p>
						</div>
					</div>
					<!--end::body-->
				</div>
				<!--end::BREADCRUMBS-->

				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="container-custom" id="kt_content_container">
						<ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link <?php echo (isset($_GET['head']) || isset($_GET['hod']) || isset($_GET['action']) || isset($_GET['verification'])) ? "" : "active" ?>" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-selected="true">Q-Alert Details</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link <?php echo (isset($_GET['head'])) ? "active" : "" ?>" id="q-head-tab" data-bs-toggle="tab" data-bs-target="#q-head" type="button" role="tab" aria-selected="false">Q-Head Review</button>
							</li>
							<li class="nav-item <?php echo $hodDisabled ? "ver-disabled" : "" ?>" role="presentation">
								<button class="nav-link <?php echo (isset($_GET['hod'])) ? "active" : "" ?>" id="hod-tab" data-bs-toggle="tab" data-bs-target="#hod" type="button" role="tab" aria-selected="false" <?php echo $hodDisabled ? "disabled" : "" ?>>HOD Review</button>
							</li>
							<li class="nav-item <?php echo $correctiveActionDisabled ? "ver-disabled" : "" ?>" role="presentation">
								<button class="nav-link <?php echo (isset($_GET['action'])) ? "active" : "" ?>" id="corrective-action-tab" data-bs-toggle="tab" data-bs-target="#corrective-action" type="button" role="tab" aria-selected="false" <?php echo $correctiveActionDisabled ? "disabled" : "" ?>>Corrective Action</button>
							</li>
							<li class="nav-item <?php echo $verificationDisabled ? "ver-disabled" : "" ?>" role="presentation">
								<button class="nav-link <?php echo (isset($_GET['verification'])) ? "active" : "" ?>" id="verification-tab" data-bs-toggle="tab" data-bs-target="#verification" type="button" role="tab" aria-selected="false" <?php echo $verificationDisabled ? "disabled" : "" ?>>Verification</button>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade <?php echo (isset($_GET['head']) || isset($_GET['hod']) || isset($_GET['action']) || isset($_GET['verification'])) ? "" : "active show" ?>" id="details" role="tabpanel">
								<div class="card card-flush">
									<form class="form" action="includes/q_alert_update.php" method="post" enctype="multipart/form-data">
										<div class="card-body">
											<div id="custom-section-1">
												<div class="form-group row">
													<div class="col-lg-3 mt-5">
														<label class="required">On Behalf Of</label>
														<select class="form-control" name="on_behalf_of" required>
															<option value="">Please Select</option>
															<?php
															$sql_data = "SELECT * FROM Basic_Employee";
															$connect_data = mysqli_query($con, $sql_data);
															while ($result_data = mysqli_fetch_assoc($connect_data)) {
																if ($result_data['Status'] == 'Active') {
																	$selected = $qAlert['on_behalf_of'] == $result_data['Id_employee'] ? 'selected' : '';
															?>
																	<option value="<?php echo $result_data['Id_employee']; ?>" <?= $selected; ?>>
																		<?php echo $result_data['First_Name']; ?>
																		<?php echo $result_data['Last_Name']; ?></option>
															<?php
																}
															}
															?>
														</select>
													</div>
													<div class="col-lg-3 mt-5">
														<label class="required">Plant</label>
														<select class="form-control" name="plant_id" id="plant" onchange="AgregrarPlantRelacionados();" required>
															<option value="">Please Select</option>
															<?php
															$sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
															$connect_data = mysqli_query($con, $sql_data);
															while ($result_data = mysqli_fetch_assoc($connect_data)) {
																if ($result_data['Status'] == 'Active') {
																	$selected = $qAlert['plant_id'] == $result_data['Id_plant'] ? 'selected' : '';
															?>
																	<option value="<?php echo $result_data['Id_plant']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?>
																	</option>
															<?php
																}
															}
															?>
														</select>
													</div>
													<div class="col-lg-3 mt-5">
														<label class="required">Product Group</label>
														<select class="form-control" id="product_group" name="product_group_id" required>
														</select>
													</div>
													<div class="col-lg-3 mt-5">
														<label class="required">Department</label>
														<select class="form-control" id="department" name="department_id" required>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-3 mt-5">
														<label class="required">Area/Process</label>
														<select class="form-control" name="area_process_id" required>
															<option value="">Please Select</option>
															<?php
															$sql_data = "SELECT * FROM area_process WHERE is_deleted = 0";
															$connect_data = mysqli_query($con, $sql_data);
															while ($result_data = mysqli_fetch_assoc($connect_data)) {
																$selected = $qAlert['area_process_id'] == $result_data['id'] ? 'selected' : '';
															?>
																<option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
																</option>
															<?php
															}
															?>
														</select>
													</div>
													<div class="col-lg-3 mt-5">
														<label class="required">Nature of Observation</label>
														<select class="form-control" name="nature_of_obs_id" required>
															<option value="">Please Select</option>
															<?php
															$sql_data = "SELECT * FROM q_alert_nature_of_obs WHERE is_deleted = 0";
															$connect_data = mysqli_query($con, $sql_data);
															while ($result_data = mysqli_fetch_assoc($connect_data)) {
																$selected = $qAlert['nature_of_obs_id'] == $result_data['id'] ? 'selected' : '';
															?>
																<option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
																</option>
															<?php
															}
															?>
														</select>
													</div>
													<div class="col-lg-3 mt-5">
														<label class="required">Date</label>
														<input type="date" class="form-control" name="date" required value="<?php echo $qAlert['date']; ?>" />
													</div>
													<div class="col-lg-3 mt-5">
														<label>Shift</label>
														<input type="text" class="form-control" name="shift" value="<?php echo $qAlert['shift']; ?>">
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-12 mt-5">
														<label class="required">Observation Details</label>
														<textarea type="text" rows="3" class="form-control" name="obs_details" required><?php echo $qAlert['obs_details']; ?></textarea>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-3 mt-5">
														<label>File Upload</label>
														<div class="d-flex align-items-center">
															<input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
														</div>
													</div>
													<?php
													$sql_data = "SELECT * FROM q_alert_files WHERE q_alert_id = '$qAlert[id]' AND is_deleted = 0";
													$connect_data = mysqli_query($con, $sql_data);
													if (mysqli_num_rows($connect_data)) {
													?>
														<div class="col-lg-9 mt-5">
															<label> &nbsp;</label>
															<div class="custom-select mt-3">
																<div class="tag-wrapper">
																	<?php
																	while ($result_data = mysqli_fetch_assoc($connect_data)) {
																	?>
																		<div class="tags">
																			<span class="remove-tag"></span>
																			<a href="<?php echo $result_data['file_path']; ?>" target="_blank"><?php echo $result_data['file_name']; ?></a>
																			<input type="hidden" class="form-control" name="existingFiles[]" value="<?php echo $result_data['id']; ?>">
																		</div>
																	<?php
																	}
																	?>
																</div>
															</div>
														</div>
													<?php
													}
													?>
												</div>
												<div class="form-group row">
													<div class="col-lg-4 mt-5">
														<label class="required">Action Category</label>
														<select class="form-control" name="action_category_id" required>
															<option value="">Please Select</option>
															<?php
															$sql_data = "SELECT * FROM action_category WHERE is_deleted = 0";
															$connect_data = mysqli_query($con, $sql_data);
															while ($result_data = mysqli_fetch_assoc($connect_data)) {
																$selected = $qAlert['action_category_id'] == $result_data['id'] ? 'selected' : '';
															?>
																<option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
																</option>
															<?php
															}
															?>
														</select>
													</div>
													<div class="col-lg-8 mt-5">
														<label class="required">Detail of Solution</label>
														<input type="text" class="form-control" name="detail_of_solution" required value="<?php echo $qAlert['detail_of_solution']; ?>">
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<div class="row" style="text-align:center; float:right;">
												<div class="mb-4">
													<button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Update</button>
													<a type="button" href="/q_alert.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
												</div>
											</div>
										</div>
										<input type="hidden" class="form-control" name="qAlertId" value="<?php echo $qAlert['id']; ?>">
										<input type="hidden" class="form-control" name="q_alert_id" value="<?php echo $qAlert['q_alert_id']; ?>">
									</form>
								</div>
							</div>

							<div class="tab-pane fade <?php echo (isset($_GET['head'])) ? "active show" : "" ?>" id="q-head" role="tabpanel">
								<div class="card card-flush">
									<form class="form" action="includes/q_alert_q_head_review_update.php" method="post" enctype="multipart/form-data">
										<div class="card-body">
											<div class="form-group row">
												<div class="col-lg-4 mt-5">
													<label class="required">Action Category</label>
													<select class="form-control" name="action_category_id" required>
														<option value="">Please Select</option>
														<?php
														$sql_data = "SELECT * FROM action_category WHERE is_deleted = 0";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															$selected = $headReview['action_category_id'] == $result_data['id'] ? 'selected' : '';
														?>
															<option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
															</option>
														<?php
														}
														?>
													</select>
												</div>
												<div class="col-lg-8 mt-5">
													<label class="required">Detail of Solution</label>
													<input class="form-control" name="detail_of_solution" required value="<?php echo $headReview['detail_of_solution']; ?>" />
												</div>
											</div>
											<div class="form-group row">
												<div class="col-lg-4 mt-5">
													<label class="required">Assign to Department</label>
													<select class="form-control" name="department_id" id="q_head_department" onchange="getHeadDepartmentMembers();" required>
														<option value="">Please Select</option>
														<?php
														$sql_data = "SELECT * FROM Basic_Department";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															if ($result_data['Status'] == 'Active') {
																$selected = $headReview['department_id'] == $result_data['Id_department'] ? 'selected' : '';
														?>
																<option value="<?php echo $result_data['Id_department']; ?>" <?= $selected; ?>><?php echo $result_data['Department']; ?>
																</option>
														<?php
															}
														}
														?>
													</select>
												</div>
												<div class="col-lg-8 mt-5">
													<label class="required">Assign to Owner</label>
													<select class="form-control" name="owner" id="q_head_owner" required>
													</select>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<div class="row" style="text-align:center; float:right;">
												<div class="mb-4">
													<button type="submit" class="btn btn-sm btn-success" id="tag-form-submit2">Update</button>
													<a type="button" href="/q_alert.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
												</div>
											</div>
										</div>
										<input type="hidden" class="form-control" name="qAlertId" value="<?php echo $qAlert['id']; ?>">
									</form>
								</div>
							</div>

							<div class="tab-pane fade <?php echo (isset($_GET['hod'])) ? "active show" : "" ?>" id="hod" role="tabpanel">
								<div class="card card-flush">
									<form class="form" action="includes/q_alert_hod_review_update.php" method="post" enctype="multipart/form-data">
										<div class="card-body">
											<div class="form-group row">
												<div class="col-lg-4 mt-5">
													<label class="required">Action Category</label>
													<select class="form-control" name="action_category_id" required>
														<option value="">Please Select</option>
														<?php
														$sql_data = "SELECT * FROM action_category WHERE is_deleted = 0";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															$selected = $hodReview['action_category_id'] == $result_data['id'] ? 'selected' : '';
														?>
															<option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
															</option>
														<?php
														}
														?>
													</select>
												</div>
												<div class="col-lg-8 mt-5">
													<label class="required">Detail of Solution</label>
													<input class="form-control" name="detail_of_solution" required value="<?php echo $hodReview['detail_of_solution']; ?>" />
												</div>
											</div>
											<div class="form-group row">
												<div class="col-lg-4 mt-5">
													<label class="required">Assign to Department</label>
													<select class="form-control" name="department_id" id="q_hod_department" onchange="getHodDepartmentMembers();" required>
														<option value="">Please Select</option>
														<?php
														$sql_data = "SELECT * FROM Basic_Department";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															if ($result_data['Status'] == 'Active') {
																$selected = $hodReview['department_id'] == $result_data['Id_department'] ? 'selected' : '';
														?>
																<option value="<?php echo $result_data['Id_department']; ?>" <?= $selected; ?>><?php echo $result_data['Department']; ?>
																</option>
														<?php
															}
														}
														?>
													</select>
												</div>
												<div class="col-lg-8 mt-5">
													<label class="required">Assign to Owner</label>
													<select class="form-control" name="owner" id="q_hod_owner" required>
													</select>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<div class="row" style="text-align:center; float:right;">
												<div class="mb-4">
													<button type="submit" class="btn btn-sm btn-success" id="tag-form-submit3">Update</button>
													<a type="button" href="/q_alert.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
												</div>
											</div>
										</div>
										<input type="hidden" class="form-control" name="qAlertId" value="<?php echo $qAlert['id']; ?>">
									</form>
								</div>
							</div>

							<div class="tab-pane fade <?php echo (isset($_GET['action'])) ? "active show" : "" ?>" id="corrective-action" role="tabpanel">
								<div class="card card-flush">
									<div class="card-body">
										<div class="d-flex justify-content-between mb-3" style="text-align:center; float:right;">
											<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#corrective-action-modal">
												<i class="fa fa-plus"></i>
												Add Corrective Action
											</button>
										</div>
										<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
											<thead>
												<tr class="text-start text-gray-400 text-uppercase gs-0">
													<th class="min-w-250px">Root Cause</th>
													<th class="min-w-250px">Corrective Action</th>
													<th class="min-w-250px">Who</th>
													<th class="min-w-100px">When</th>
													<th class="min-w-50px">Status</th>
													<th class="min-w-50px">Action</th>
												</tr>
											</thead>
											<tbody class="fw-bold text-gray-600">
												<?php if ($correctiveAction && count($correctiveAction) > 0) {
													foreach ($correctiveAction as $key => $item) { ?>
														<tr>
															<input type="hidden" class="form-control" name="ca_id" value="<?php echo $item['id']; ?>">
															<input type="hidden" class="form-control" name="ca_root_cause" value="<?php echo $item['root_cause']; ?>">
															<input type="hidden" class="form-control" name="ca_corrective_action" value="<?php echo $item['corrective_action']; ?>">
															<input type="hidden" class="form-control" name="ca_who" value="<?php echo $item['who']; ?>">
															<input type="hidden" class="form-control" name="ca_date" value="<?php echo $item['date']; ?>">
															<input type="hidden" class="form-control" name="ca_status" value="<?php echo $item['status']; ?>">
															<input type="hidden" class="form-control" name="ca_how" value="<?php echo $item['how']; ?>">
															<input type="hidden" class="form-control" name="ca_moc" value="<?php echo $item['moc']; ?>">
															<input type="hidden" class="form-control" name="ca_risk_assessment" value="<?php echo $item['risk_assessment']; ?>">
															<td>
																<?php echo $item['root_cause']; ?>
															</td>
															<td>
																<?php echo $item['corrective_action']; ?>
															</td>
															<?php if (isset($item['who'])) {
																$sql = "SELECT * From Basic_Employee Where Id_employee = $item[who]";
																$fetch = mysqli_query($con, $sql);
																$who = mysqli_fetch_assoc($fetch);
															?>
																<td>
																	<?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?>
																</td>
															<?php } else { ?>
																<td>
																	<?php echo ' '; ?>
																</td>
															<?php } ?>
															<td>
																<?php echo date("d-m-y", strtotime($item['date'])) ?>
															</td>
															<td>
																<div class="badge badge-light-success">
																	<?php echo $item['status']; ?>
																</div>
															</td>
															<td>
																<button type="button" class="btn btn-link me-3" onclick="openEditPopup(this);">
																	<i class="bi bi-pencil" aria-hidden="true"></i>
																</button>
																<a href="/includes/q_alert_corrective_action_delete.php?id=<?php echo $item['id']; ?>"><i class="bi bi-trash" aria-hidden="true"></i></a>
															</td>
														</tr>
												<?php }
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane fade <?php echo (isset($_GET['verification'])) ? "active show" : "" ?>" id="verification" role="tabpanel">
								<div class="card card-flush">
									<div class="card-body">
										<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
											<thead>
												<tr class="text-start text-gray-400 text-uppercase gs-0">
													<th class="min-w-250px">Root Cause</th>
													<th class="min-w-250px">Corrective Action</th>
													<th class="min-w-250px">Who</th>
													<th class="min-w-100px">When</th>
													<th class="min-w-50px">Status</th>
													<th class="min-w-50px">Action</th>
												</tr>
											</thead>
											<tbody class="fw-bold text-gray-600">
												<?php if ($correctiveAction && count($correctiveAction) > 0) {
													foreach ($correctiveAction as $key => $item) { ?>
														<tr>
															<td>
																<?php echo $item['root_cause']; ?>
															</td>
															<td>
																<?php echo $item['corrective_action']; ?>
															</td>
															<?php if (isset($item['who'])) {
																$sql = "SELECT * From Basic_Employee Where Id_employee = $item[who]";
																$fetch = mysqli_query($con, $sql);
																$who = mysqli_fetch_assoc($fetch);
															?>
																<td>
																	<?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?>
																</td>
															<?php } else { ?>
																<td>
																	<?php echo ' '; ?>
																</td>
															<?php } ?>
															<td>
																<?php echo date("d-m-y", strtotime($item['date'])) ?>
															</td>
															<td>
																<div class="badge badge-light-success">
																	<?php echo $item['status']; ?>
																</div>
															</td>
															<?php if ($item['verification'] == "1") { ?>
																<td>
																	<a href="/includes/q_alert_corrective_action_verification.php?id=<?php echo $item['id']; ?>">
																		<div class="badge badge-light-success">Approved</div>
																	</a>
																</td>
															<?php } else { ?>
																<td>
																	<a href="/includes/q_alert_corrective_action_verification.php?id=<?php echo $item['id']; ?>">
																		<div class="badge badge-light-danger">Rejected</div>
																	</a>
																</td>
															<?php } ?>
														</tr>
												<?php }
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('includes/footer.php'); ?>
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
	<script>
		function AgregrarPlantRelacionados() {
			var result = document.getElementById("plant").value;
			/*Product Group*/
			$("<option>").load('includes/inputs-dinamicos-pg-plant.php?pg_id=' + result + '&key=' + productGroup,
				function() {
					$('#product_group option').remove();
					$("#product_group").append($(this).html());
				});

			/*Department*/
			$("<option>").load('includes/inputs-dinamicos-department-plant.php?pg_id=' + result + '&key=' + department,
				function() {
					$('#department option').remove();
					$("#department").append($(this).html());
				});
		}

		function getHeadDepartmentMembers() {
			var result = document.getElementById("q_head_department").value;
			$("<option>").load('includes/inputs-dinamicos-department-members.php?id=' + result + '&key=' + headOwner,
				function() {
					$('#q_head_owner option').remove();
					$("#q_head_owner").append($(this).html());
				});
		}

		function getHodDepartmentMembers() {
			var result = document.getElementById("q_hod_department").value;
			$("<option>").load('includes/inputs-dinamicos-department-members.php?id=' + result + '&key=' + hodOwner,
				function() {
					$('#q_hod_owner option').remove();
					$("#q_hod_owner").append($(this).html());
				});
		}

		$(document).ready(function() {
			AgregrarPlantRelacionados();
			getHeadDepartmentMembers();
			getHodDepartmentMembers();
		});

		$('.remove-tag').on('click', function() {
			return $(this).closest('div.tags').remove();
		});

		function openEditPopup(obj) {
			let getData = getValue($(obj).closest('tr'));
			let setData = setValue(getData);
			if (setData) {
				return $('#corrective-action-modal').modal('show');
			}
		}

		function getValue(row) {
			let id = $(row).find('input[name="ca_id"]').val();
			let root_cause = $(row).find('input[name="ca_root_cause"]').val();
			let corrective_action = $(row).find('input[name="ca_corrective_action"]').val();
			let who = $(row).find('input[name="ca_who"]').val();
			let date = $(row).find('input[name="ca_date"]').val();
			let how = $(row).find('input[name="ca_how"]').val();
			let status = $(row).find('input[name="ca_status"]').val();
			let moc = $(row).find('input[name="ca_moc"]').val();
			let risk_assessment = $(row).find('input[name="ca_risk_assessment"]').val();
			return {
				id,
				root_cause,
				corrective_action,
				who,
				date,
				how,
				status,
				moc,
				risk_assessment
			}
		}

		function setValue(dataArr) {
			if (Object.keys(dataArr)?.length > 0) {
				console.log(dataArr.moc);
				console.log(dataArr.risk_assessment);
				$('#id').val(dataArr.id);
				$('#root_cause').val(dataArr.root_cause);
				$('#corrective_action').val(dataArr.corrective_action);
				$('#who').val(dataArr.who);
				$('#date').val(dataArr.date);
				$('#how').val(dataArr.how);
				$('#status').val(dataArr.status);
				let mocCheck = dataArr.moc == 1 ? true : false;
				$('#moc').prop('checked', mocCheck);
				let riskCheck = dataArr.risk_assessment == 1 ? true : false;
				$('#risk_assessment').prop('checked', riskCheck);
				return true;
			}
			return false;
		}

		function resetValues() {
			return setValue({
				id: "",
				root_cause: "",
				corrective_action: "",
				who: "",
				date: "",
				how: "",
				status: "",
				moc: "",
				risk_assessment: "",
			});
		}
	</script>
	<!--Add New Corrective Action Modal-->
	<div class="modal right fade" id="corrective-action-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<form class="form" action="includes/q_alert_corrective_action_update.php" method="post" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header right-modal">
						<h5 class="modal-title" id="staticBackdropLabel">Corrective Action
						</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="overflow-y:scroll">
						<div class="row">
							<div class="col-md-12">
								<label class="required">Root Cause</label>
								<textarea class="form-control" name="root_cause" id="root_cause" required value=""></textarea>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-12">
								<label class="required">Corrective Action</label>
								<textarea class="form-control" name="corrective_action" id="corrective_action" required value=""></textarea>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-12">
								<label class="required">Who</label>
								<select class="form-control" name="who" id="who" required>
									<option value="">Please Select</option>
									<?php
									$sql_data = "SELECT * FROM Basic_Employee";
									$connect_data = mysqli_query($con, $sql_data);
									while ($result_data = mysqli_fetch_assoc($connect_data)) {
										if ($result_data['Status'] == 'Active') {
									?>
											<option value="<?php echo $result_data['Id_employee']; ?>">
												<?php echo $result_data['First_Name']; ?>
												<?php echo $result_data['Last_Name']; ?>
											</option>
									<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-12">
								<label class="required">When</label>
								<input type="date" class="form-control" name="date" id="date" required value="" />
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-12">
								<label class="required">How</label>
								<textarea class="form-control" name="how" id="how" required value=""></textarea>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="moc" name="moc">
									<label class="form-check-label" for="moc">
										MoC
									</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="risk_assessment" name="risk_assessment">
									<label class="form-check-label" for="risk_assessment">
										Risk Assessment
									</label>
								</div>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-12 mt-4">
								<label class="required">Status</label>
								<select class="form-control" name="status" id="status" required>
									<option value="">Please Select</option>
									<option value="25%">25%</option>
									<option value="50%">50%</option>
									<option value="75%">75%</option>
									<option value="100%">100%</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-success">Save</button>
						<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetValues();">Close</button>
					</div>
					<input type="hidden" class="form-control" name="q_alert_id" id="q_alert_id" value="<?php echo $qAlert['id']; ?>">
					<input type="hidden" class="form-control" name="id" id="id" value="">
				</div>
			</form>
		</div>
	</div>
</body>
<!--end::Body-->

</html>