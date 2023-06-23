<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "New MoC";
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!--begin::Body-->
<style>
	.required::after {
		content: "*";
		color: #e1261c;
	}

	.radio-grid {
		width: 115px;
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
				<!--begin::BREADCRUMBS-->
				<div class="row breadcrumbs">
					<!--begin::body-->
					<div>
						<div>
							<p><a href="/">Home</a> » <a href="/quality-moc.php">Quality MoC</a> » <a href="/quality-moc_view_list.php">Quality MoC List</a> »
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
						<div class="card card-flush">
							<form class="form" action="includes/quality-moc_add_form.php" method="post" enctype="multipart/form-data">
								<!-- begin::Form Content -->
								<div class="card-body">
									<div id="custom-section-1">
										<div class="container-full customer-header">
											Details
										</div>
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
											<div class="col-lg-3 mt-5">
												<label class="required">Plant</label>
												<select class="form-control" name="plant_id" id="plant" onchange="AgregrarPlantRelacionados();" required>
													<option value="0">Please Select</option>
													<?php
													$sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
													$connect_data = mysqli_query($con, $sql_data);
													while ($result_data = mysqli_fetch_assoc($connect_data)) {
														if ($result_data['Status'] == 'Active') {
													?>
															<option value="<?php echo $result_data['Id_plant']; ?>">
																<?php echo $result_data['Title']; ?></option>
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
												<label class="required">MoC Type</label>
												<select class="form-control" name="moc_type_id" required>
													<option value="">Please Select</option>
													<?php
													$sql_data = "SELECT * FROM Quality_MoC_Type";
													$connect_data = mysqli_query($con, $sql_data);
													while ($result_data = mysqli_fetch_assoc($connect_data)) {
													?>
														<option value="<?php echo $result_data['Id_quality_moc_type']; ?>">
															<?php echo $result_data['Title']; ?></option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-3 mt-5">
												<label class="required">Old MoC Ref#</label>
												<input class="form-control" name="old_moc_ref_no" required>
											</div>
											<div class="col-lg-3 mt-5">
												<label class="required">Standard / Procedure Reference</label>
												<input class="form-control" name="std_procedure_ref" required>
											</div>
											<div class="col-lg-3 mt-5">
												<label class="required">Risk Assessment</label>
												<select class="form-control" name="risk_assessment" required>
													<option value="">Please Select</option>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-3 mt-5">
												<label class="required">Current State</label>
												<input class="form-control" name="current_state" required>
											</div>
											<div class="col-lg-3 mt-5">
												<label class="required">Change State</label>
												<input class="form-control" name="change_state" required>
											</div>
											<div class="col-lg-6 mt-5">
												<label class="required">Informed Team Members</label>
												<select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Team Members" name="team_members[]" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" required multiple>
													<?php
													$sql_data = "SELECT * FROM Basic_Employee";
													$connect_data = mysqli_query($con, $sql_data);
													while ($result_data = mysqli_fetch_assoc($connect_data)) {
														if ($result_data['Status'] == 'Active') {
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
										<div class="form-group row">
											<div class="col-lg-12 mt-5">
												<label class="required">Description Of Change</label>
												<textarea type="text" rows="3" class="form-control" name="description_of_change" required></textarea>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-3 mt-5">
												<label>File Upload</label>
												<input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
											</div>
										</div>
									</div>
								</div>
								<!-- end::Form Content -->
								<div class="card-footer">
									<div class="row" style="text-align:center; float:right;">
										<div class="mb-4">
											<button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Save</button>
											<a type="button" href="/quality-moc.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
										</div>
									</div>
								</div>
								<!--end::Content-->
							</form>
							<!-- Finalizar contenido -->
						</div>
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
		function AgregrarPlantRelacionados() {
			var result = document.getElementById("plant").value;
			/*Product Group*/
			$("<option>").load('includes/inputs-dinamicos-pg-plant.php?pg_id=' + result, function() {
				$('#product_group option').remove();
				$("#product_group").append($(this).html());
			});

			/*Department*/
			$("<option>").load('includes/inputs-dinamicos-department-plant.php?pg_id=' + result, function() {
				$('#department option').remove();
				$("#department").append($(this).html());
			});
		}
	</script>
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>