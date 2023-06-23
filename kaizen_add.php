<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "New Kaizen";
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<style>
	.required::after {
		content: "*";
		color: #e1261c;
	}

	.ver-disabled input {
		background-color: #e9ecef !important;
	}

	/*.label-over-flow {
		white-space: nowrap;
	    text-overflow: ellipsis;
	    overflow: hidden;
	    width: 100%;
	}*/
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
	<div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">
			<?php include('includes/aside-menu.php'); ?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include('includes/header.php'); ?>
				<div class="row breadcrumbs">
					<div>
						<div>
							<p><a href="/">Home</a> » <a href="/kaizen.php">Kaizen</a> » <a href="/kaizen_view_list.php">Kaizen List</a> »
								<?php echo $_SESSION['Page_Title']; ?></p>
						</div>
					</div>
				</div>
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="container-custom" id="kt_content_container">
						<div class="card card-flush">
							<form class="form" action="includes/kaizen_store.php" method="post" enctype="multipart/form-data">
								<div class="card-body">
									<div id="custom-section-1">
										<div class="container-full customer-header">
											Kaizen Details
										</div>
										<div class="form-group row">
											<div class="col-lg-3 mt-5">
												<label class="required">Team Leader</label>
												<select class="form-control" name="team_leader_id" required>
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
												<select class="form-control" id="plant" name="plant_id" onchange="AgregrarPlantRelacionados();" required>
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
													<?php
                                                    $sql_data = "SELECT * FROM Basic_Product_Group";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active') {
                                                    ?>
                                                            <option value="<?php echo $result_data['Id_product_group']; ?>"><?php echo $result_data['Title']; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
												</select>
											</div>
											<div class="col-lg-3 mt-5">
												<label class="required">Department</label>
												<select class="form-control" id="department" name="department_id" required>
													<option value="">Please Select</option>
													<?php
                                                    $sql_data = "SELECT * FROM Basic_Department";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active') {
                                                           
                                                    ?>
                                                            <option value="<?php echo $result_data['Id_department']; ?>"><?php echo $result_data['Department']; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-3 mt-5">
												<label class="required">Category</label>
												<select class="form-control" name="category_id" required>
													<option value="">Please Select</option>
													<?php
													$sql_data = "SELECT * FROM kaizen_category WHERE is_deleted = 0";
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
												<label class="required">Focus Area</label>
												<select class="form-control" name="focus_area_id" required>
													<option value="">Please Select</option>
													<?php
													$sql_data = "SELECT * FROM kaizen_focus_area WHERE is_deleted = 0";
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
												<label class="required">Process</label>
												<select class="form-control" name="process_id" required>
													<option value="">Please Select</option>
													<?php
													$sql_data = "SELECT * FROM kaizen_process WHERE is_deleted = 0";
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
												<label class="required">Kaizen Type</label>
												<select class="form-control" name="kaizen_type_id" required>
													<option value="">Please Select</option>
													<?php
													$sql_data = "SELECT * FROM kaizen_type WHERE is_deleted = 0";
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
										</div>
										<div class="form-group row">
											<div class="col-lg-12 mt-5">
												<label class="required">Team Members</label>
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
												<label class="required">Theme of kaizen</label>
												<textarea class="form-control" name="theme_of_kaizen" required></textarea>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-6 mt-5">
												<label class="required">Before Improvement</label>
												<textarea class="form-control" name="before_improvement" required></textarea>
											</div>
											<div class="col-lg-6 mt-5">
												<label class="required">After Improvement</label>
												<textarea class="form-control" name="after_improvement" required></textarea>
											</div>
										</div>
										<div class="container-full customer-header mt-2">
											Benefits
										</div>
										<div class="form-group row">
											<div class="col-lg-4 mt-5">
												<label title="" class="label-over-flow">
													Expenditure
													<small>(if any) </small>:
													<small class="text-primary"> Please share details of expenditure incurred to implement Kaizan</small>
												</label>
												<textarea class="form-control" name="expenditure"></textarea>
											</div>
											<div class="col-lg-4 mt-5">
												<label title="" class="label-over-flow">
													Direct Savings
													<small>(if any) </small>:
													<small class="text-primary"> Please elaborate direct savings against estimates due to implementation of Kaizan</small>
												</label>
												<textarea class="form-control" name="direct_savings"></textarea>
											</div>
											<div class="col-lg-4 mt-5">
												<label title="Please elaborate indirect savings e.g. man hours, service level improvement energy, NVA revival etc." class="label-over-flow">
													Indirect Savings
													<small>(if any) </small>:
													<small class="text-primary"> Please elaborate indirect savings e.g. man hours, service level improvement energy, NVA revival etc.</small>
												</label>
												<textarea class="form-control" name="indirect_savings"></textarea>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-4 mt-5">
												<label title="" class="required label-over-flow">
													Total Expenditure
													<small>(E)</small>
													<small class="text-primary ms-2">Enter number only</small>
												</label>
												<input type="number" name="total_expenditure" id="total_expenditure" class="form-control" required>
											</div>
											<div class="col-lg-4 mt-5">
												<label title="" class="required label-over-flow">
													Total Direct Savings
													<small>(D)</small>
													<small class="text-primary ms-2">Enter number only</small>
												</label>
												<input type="number" name="total_direct_savings" id="total_direct_savings" class="form-control" required>
											</div>
											<div class="col-lg-4 mt-5">
												<label title="" class="required label-over-flow">
													Total Indirect Savings
													<small>(I)</small>
													<small class="text-primary ms-2">Enter number only</small>
												</label>
												<input type="number" name="total_indirect_savings" id="total_indirect_savings" class="form-control" required>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-4 mt-5 ver-disabled">
												<label class="required">
													Final Monetary Gain
													<small>((D+I)-E)</small>
												</label>
												<input type="number" name="final_monetary_gain" id="final_monetary_gain" class="form-control" required readonly>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<div class="row" style="text-align:center; float:right;">
										<div class="mb-4">
											<button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Save</button>
											<a type="button" href="/kaizen.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
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
	<script>
		function AgregrarPlantRelacionados() {
			var result = document.getElementById("plant").value;
			$("<option>").load('includes/inputs-dinamicos-pg-plant.php?pg_id=' + result, function() {
				$('#product_group option').remove();
				$("#product_group").append($(this).html());
			});

			$("<option>").load('includes/inputs-dinamicos-department-plant.php?pg_id=' + result, function() {
				$('#department option').remove();
				$("#department").append($(this).html());
			});
		}
		$(document).ready(function() {
			$("#total_expenditure").on('input', function() {
				caluculateGain();
			});
			$("#total_direct_savings").on('input', function() {
				caluculateGain();
			});
			$("#total_indirect_savings").on('input', function() {
				caluculateGain();
			});
		});

		function caluculateGain() {
			var total_expenditure = $("#total_expenditure").val();
			var total_direct_savings = $("#total_direct_savings").val();
			var total_indirect_savings = $("#total_indirect_savings").val();
			if (total_expenditure != undefined && total_direct_savings != undefined && total_indirect_savings != undefined) {
				var final_monetary_gain = (Number(total_direct_savings) + Number(total_indirect_savings)) - Number(total_expenditure);
				$("#final_monetary_gain").val(Math.ceil(final_monetary_gain));
			}
		}
	</script>
</body>

</html>