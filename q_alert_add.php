<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "New Q-Alert";
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
							<p><a href="/">Home</a> » <a href="/q_alert.php">Q-Alert</a> » <a href="/q_alert_view_list.php">Q-Alert List</a> »
								<?php echo $_SESSION['Page_Title']; ?></p>
						</div>
					</div>
					<!--end::body-->
				</div>
				<!--end::BREADCRUMBS-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="container-custom" id="kt_content_container">
						<div class="card card-flush">
							<form class="form" action="includes/q_alert_store.php" method="post" enctype="multipart/form-data">
								<div class="card-body">
									<div id="custom-section-1">
										<div class="container-full customer-header">
											Q-Alert Details
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
													<option value="">Please Select</option>
													<?php
													$sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
													$connect_data = mysqli_query($con, $sql_data);
													while ($result_data = mysqli_fetch_assoc($connect_data)) {
														if ($result_data['Status'] == 'Active') {
													?>
															<option value="<?php echo $result_data['Id_plant']; ?>"><?php echo $result_data['Title']; ?>
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
													<option value="">Please Select</option>
												</select>
											</div>
											<div class="col-lg-3 mt-5">
												<label class="required">Department</label>
												<select class="form-control" id="department" name="department_id" required>
													<option value="">Please Select</option>
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
													?>
														<option value="<?php echo $result_data['id']; ?>"><?php echo $result_data['title']; ?>
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
													?>
														<option value="<?php echo $result_data['id']; ?>"><?php echo $result_data['title']; ?>
														</option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-3 mt-5">
												<label class="required">Date</label>
												<input type="date" class="form-control" name="date" required />
											</div>
											<div class="col-lg-3 mt-5">
												<label>Shift</label>
												<input type="text" class="form-control" name="shift">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-12 mt-5">
												<label class="required">Observation Details</label>
												<textarea type="text" rows="3" class="form-control" name="obs_details" required></textarea>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-3 mt-5">
												<label>File Upload</label>
												<div class="d-flex align-items-center">
													<input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
												</div>
											</div>
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
													?>
														<option value="<?php echo $result_data['id']; ?>"><?php echo $result_data['title']; ?>
														</option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-8 mt-5">
												<label class="required">Detail of Solution</label>
												<input type="text" class="form-control" name="detail_of_solution" required>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<div class="row" style="text-align:center; float:right;">
										<div class="mb-4">
											<button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Save</button>
											<a type="button" href="/q_alert.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
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
</body>
<!--end::Body-->

</html>