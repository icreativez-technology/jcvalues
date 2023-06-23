<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "MoC Details Edit";

$sql_data = "SELECT * FROM Quality_MoC WHERE Id_quality_moc = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);

/*Para comprobar el usuario y que pueda editar o no*/
$email = $_SESSION['usuario'];
$sql_datos_usuario = "SELECT * From Basic_Employee Where Email = '$email'";
$result_datos_usuario = mysqli_query($con, $sql_datos_usuario);
$conectado = mysqli_fetch_assoc($result_datos_usuario);

$thisemployee = $conectado['Id_employee'];
$rol_user_check = $conectado['Admin_User'];
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?> <!-- Meta tags + CSS -->

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
				<?php include('includes/header.php'); ?><!-- Includes Top bar and Responsive Menu -->
				<!--begin::BREADCRUMBS-->
				<div class="row breadcrumbs">
					<!--begin::body-->
					<div>
						<!--begin::Title-->
						<div>
							<p><a href="/">Home</a> » <a href="/quality-moc.php">Quality MoC</a> » <a href="/quality-moc_view_list.php">Quality MoC List</a> » <?php echo $_SESSION['Page_Title']; ?></p>
							<!-- MIGAS DE PAN -->
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
							<!-- AQUI AÑADIR EL CONTENIDO  -->

							<form class="form" action="includes/quality-moc_update_form.php" method="post" enctype="multipart/form-data">
								<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_quality_moc']; ?>" readonly>
								<!-- begin::Form Content -->
								<div class="card-body">
									<div class="card-header card-header-stretch pb-0">
										<div class="card-title">
											<h4>MoC <?php echo $_REQUEST['pg_id']; ?></h4>
										</div>
									</div>
									<div id="custom-section-1">
										<div class="form-group row">
											<div class="col-lg-3">
												<label>On Behalf of</label>
												<select class="form-control" name="On_behalf_of" required>
													<?php
													$sql_data_user = "SELECT * FROM Basic_Employee";
													$connect_data_user = mysqli_query($con, $sql_data_user);
													$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/

													while ($result_data_user = mysqli_fetch_assoc($connect_data_user)) {
														if ($result_data_user['Status'] == 'Active') {
															if ($result_data_user['Id_employee'] == $result_data['Id_employee']) {
																$flag_active_selected = 1;
													?>
																<option value="<?php echo $result_data_user['Id_employee']; ?>" selected="selected"><?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?></option>
															<?php
															} else {
															?>
																<option value="<?php echo $result_data_user['Id_employee']; ?>"><?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?></option>
													<?php
															}
														}
													}
													?>

												</select>
												<?php if ($flag_active_selected == 0) { ?>
													<div class="text-muted fs-7">Original user is suspended or deleted. Please choose a new user.</div>
												<?php } ?>
											</div>
											<div class="col-lg-3">
												<label>Plant</label>
												<select class="form-control" name="plant" id="plant" onchange="AgregrarPlantRelacionados();" required>
													<?php
													$sql_data_plant = "SELECT Id_plant, Title, Status FROM Basic_Plant";
													$connect_data_plant = mysqli_query($con, $sql_data_plant);
													$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/

													while ($result_data_plant = mysqli_fetch_assoc($connect_data_plant)) {
														if ($result_data_plant['Status'] == 'Active') {
															if ($result_data_plant['Id_plant'] == $result_data['Id_plant']) {
																$flag_active_selected = 1;
													?>
																<option value="<?php echo $result_data_plant['Id_plant']; ?>" selected="selected"><?php echo $result_data_plant['Title']; ?></option>
															<?php
															} else {
															?>
																<option value="<?php echo $result_data_plant['Id_plant']; ?>"><?php echo $result_data_plant['Title']; ?></option>
													<?php
															}
														}
													}
													?>

												</select>
												<?php if ($flag_active_selected == 0) { ?>
													<div class="text-muted fs-7">Original plant is suspended or deleted. Please choose a new plant.</div>
												<?php } ?>
											</div>
											<div class="col-lg-3">
												<label>Product Group</label>
												<select class="form-control" id="product_group" name="product_group" required>
													<?php
													$plant_id = $result_data['Id_plant'];
													$flag_active_selected = 0;

													if ($plant_id != 0) {

														$sql_data2 = "SELECT * FROM Basic_Plant_Product_Group";
														$connect_data2 = mysqli_query($con, $sql_data2);
														$count = 0;

														while ($result_data2 = mysqli_fetch_assoc($connect_data2)) {
															if ($result_data2['Id_plant'] == $plant_id) {
																$count++;
																$sql_data3 = "SELECT * FROM Basic_Product_Group WHERE Id_product_group = '$result_data2[Id_product_group]'";
																$connect_data3 = mysqli_query($con, $sql_data3);
																$result_data3 = mysqli_fetch_assoc($connect_data3);

																if ($result_data3['Status'] == 'Active') {
																	if ($result_data3['Id_product_group'] == $result_data['Id_product_group']) {
																		$flag_active_selected = 1;
													?>
																		<option value="<?php echo $result_data3['Id_product_group']; ?>" selected="selected"><?php echo $result_data3['Title']; ?></option>
																	<?php
																	} else {
																	?>
																		<option value="<?php echo $result_data3['Id_product_group']; ?>"><?php echo $result_data3['Title']; ?></option>
															<?php
																	}
																}
															}
														}
														if ($count == 0) {
															?>
															<option value="0">No product group related to this plant</option>
													<?php
														}
													}
													?>
												</select>

												<?php if ($flag_active_selected == 0) { ?>
													<div class="text-muted fs-7">Original product group is suspended or deleted. Please choose a new one.</div>
												<?php } ?>
											</div>

											<div class="col-lg-3">
												<label>Department</label>
												<select class="form-control" id="department" name="department" required>
													<?php
													$plant_id = $result_data['Id_plant'];
													$flag_active_selected = 0;

													if ($plant_id != 0) {

														$sql_data2 = "SELECT * FROM Basic_Plant_Deparment";
														$connect_data2 = mysqli_query($con, $sql_data2);
														$count = 0;

														while ($result_data2 = mysqli_fetch_assoc($connect_data2)) {
															if ($result_data2['Id_plant'] == $plant_id) {
																$count++;
																$sql_data3 = "SELECT * FROM Basic_Department WHERE Id_department = '$result_data2[Id_department]'";
																$connect_data3 = mysqli_query($con, $sql_data3);
																$result_data3 = mysqli_fetch_assoc($connect_data3);

																if ($result_data3['Status'] == 'Active') {
																	if ($result_data3['Id_department'] == $result_data['Id_department']) {
																		$flag_active_selected = 1;
													?>
																		<option value="<?php echo $result_data3['Id_department']; ?>" selected="selected"><?php echo $result_data3['Department']; ?></option>
																	<?php
																	} else {
																	?>
																		<option value="<?php echo $result_data3['Id_department']; ?>"><?php echo $result_data3['Department']; ?></option>
															<?php
																	}
																}
															}
														}
														if ($count == 0) {
															?>
															<option value="0">No product group related to this plant</option>
													<?php
														}
													}
													?>
												</select>

												<?php if ($flag_active_selected == 0) { ?>
													<div class="text-muted fs-7">Original department is suspended or deleted. Please choose a new department.</div>
												<?php } ?>
											</div>

										</div>

										<div class="form-group row">
											<div class="col-lg-3">
												<label>MoC Type</label>
												<select class="form-control" name="MoC_type" required>
													<?php
													$sql_data = "SELECT * FROM Quality_MoC_Type";
													$connect_data = mysqli_query($con, $sql_data);
													$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/

													while ($result_data_moc = mysqli_fetch_assoc($connect_data)) {
														if ($result_data_moc['Status'] == 'Active') {
															if ($result_data_moc['Id_quality_moc_type'] == $result_data['Id_quality_moc_type']) {
																$flag_active_selected = 1;

													?>
																<option value="<?php echo $result_data_moc['Id_quality_moc_type']; ?>" selected="selected"><?php echo $result_data_moc['Title']; ?></option>
															<?php
															} else {
															?>
																<option value="<?php echo $result_data_moc['Id_quality_moc_type']; ?>"><?php echo $result_data_moc['Title']; ?></option>
													<?php
															}
														}
													}
													?>

												</select>
												<?php if ($flag_active_selected == 0) { ?>
													<div class="text-muted fs-7">Original MoC Type is suspended or deleted. Please choose a new one.</div>
												<?php } ?>

											</div>
											<div class="col-lg-3">
												<label>Old MoC Ref#</label>
												<input type="text" class="form-control" name="Old_MoC_Ref" value="<?php echo $result_data['Old_MoC_Ref']; ?>" required>
											</div>
											<div class="col-lg-3">
												<label>Date</label>
												<input type="date" class="form-control" name="date" value="<?php echo $result_data['Date_date']; ?>" required>
											</div>
											<div class="col-lg-3">
												<label>Standard / Procedure Reference</label>
												<input type="text" class="form-control" name="reference" value="<?php echo $result_data['Stan_Proc_Ref']; ?>" required>
											</div>
										</div>


										<div class="form-group row">
											<div class="col-lg-3">
												<label>Current State</label>
												<input type="text" class="form-control" name="current_state" value="<?php echo $result_data['Current_State']; ?>" required>
											</div>
											<div class="col-lg-3">
												<label>Change State</label>
												<input type="text" class="form-control" name="change_state" value="<?php echo $result_data['Change_State']; ?>" required>
											</div>
											<div class="col-lg-3">
												<label>Risk Assessment</label>
												<select class="form-control" name="Risk_Assessment" required>
													<?php if ($result_data['Risk_Assessment'] == 'No') { ?>
														<option>Yes</option>
														<option selected="selected">No</option>
													<?php } else { ?>
														<option selected="selected">Yes</option>
														<option>No</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-lg-3">

												<label>Informed team members:</label>

												<select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Add Team Members" name="TeamMembers[]" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" required="required" multiple="multiple">
													<?php

													$sql_datos_employees = "SELECT Id_employee, Email, Password, First_Name,Last_Name, 	Admin_User From Basic_Employee";
													$result_datos_employees = mysqli_query($con, $sql_datos_employees);


													while ($datos_employees = mysqli_fetch_assoc($result_datos_employees)) {
														$flag_em = 0;

														$sql_datos_teammembers = "SELECT * FROM Quality_MoC_TeamMembers WHERE Id_quality_moc = '$result_data[Id_quality_moc]' ";
														$result_datos_teammembers = mysqli_query($con, $sql_datos_teammembers);
														while ($datos_tm = mysqli_fetch_assoc($result_datos_teammembers)) {
															if ($datos_tm[Id_employee] == $datos_employees[Id_employee]) {
																$flag_em = 1;
															}
														}

													?>

														<?php
														if ($flag_em == 1) {
														?>
															<option value="<?php echo $datos_employees['Id_employee']; ?>" selected="selected"><?php echo $datos_employees['First_Name']; ?> <?php echo $datos_employees['Last_Name']; ?></option>
														<?php
														} else {
														?>
															<option value="<?php echo $datos_employees['Id_employee']; ?>"><?php echo $datos_employees['First_Name']; ?> <?php echo $datos_employees['Last_Name']; ?></option>
														<?php
														}
														?>


													<?php } ?>
												</select>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-6">
												<label>Description of Change</label>
												<input type="text" class="form-control" name="description" value="<?php echo $result_data['Description_Change']; ?>" required>
											</div>
											<div class="col-lg-6">
												<label>File uploaded</label>
												<?php if ($result_data['File'] != "No file") { ?>
													<div class="table-responsive">
														<!--begin::Table-->
														<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
															<!--begin::Table head-->
															<thead>
																<!--begin::Table row-->
																<tr class="text-start text-muted text-uppercase gs-0">
																	<th class="min-w-150px">File Name</th>
																	<th class="min-w-25px">Uploaded on</th>
																	<th class="min-w-25px text-end">Action</th>
																</tr>
															</thead>
															<tbody class="text-gray-600 fw-bold">
																<tr>
																	<?php
																	$myfile = substr($result_data['File'], strpos($result_data['File'], "-") + 1);
																	?>
																	<td><?php echo $myfile; ?></td>
																	<td><?php echo date("d-m-y", strtotime($result_data['File_Date'])); ?></td>
																	<td class="text-end"><a href="/quality/moc/<?php echo $result_data['File']; ?>" target="_blank"><i class="bi bi-box-arrow-down text-gray"></i></a>
																		<a onclick="changefile()" class="changefile"><i class="bi bi-pencil text-gray"></i></a>
																		<a href="includes/quality-moc_delete_file.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-trash text-gray"></i></a>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
													<input type="file" class="form-control" id="hiddenfile" style="display: none;" name="file_archivo" placeholder="">
												<?php } else { ?>
													<input type="file" class="form-control" name="file_archivo" placeholder="">
												<?php } ?>


											</div>


										</div>

										<!--<div class="form-group row">
										   <div class="col-lg-2">
										    <label>Approval Decision</label>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="0" id="kt_modal_update_role_option_0" checked='checked' />
													<label class="form-check-label" for="kt_modal_update_role_option_0">
														Completed
													</label>
												</div>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="0" id="kt_modal_update_role_option_1" />
													<label class="form-check-label" for="kt_modal_update_role_option_1">
														Rejected
													</label>
												</div>
											</div>
											<div class="col-lg-10">
										    <label>Decision Remarks</label>
												<input type="text" class="form-control" name="remarks" placeholder="" required>
											</div>

										</div>-->

									</div>
								</div>
								<!-- end::Form Content -->


								<div class="card-footer">
									<div class="row" style="text-align: center;">
										<div>
											<?php if ($result_data['Id_employee'] == $thisemployee or $rol_user_check == 'Superadministrator') { ?>
												<input type="submit" class="btn btn-lg btn-primary mb-5" value="Save">
											<?php } ?>

										</div>
									</div>
								</div>
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
				//alert('includes/inputs-dinamicos-pg-plant.php?pg_id='+result);
				$("#product_group").append($(this).html());
			});

			/*Department*/
			$("<option>").load('includes/inputs-dinamicos-department-plant.php?pg_id=' + result, function() {
				$('#department option').remove();
				//alert('includes/inputs-dinamicos-pg-plant.php?pg_id='+result);
				$("#department").append($(this).html());
			});
		}
	</script>
	<!--end::Javascript-->
	<script type="text/javascript">
		function changefile() {
			var actual = document.getElementById("hiddenfile").style.display;
			if (actual == "none") {
				document.getElementById("hiddenfile").style.display = "block";
			} else {
				document.getElementById("hiddenfile").style.display = "none";
			}
		}
	</script>
</body>
<!--end::Body-->

</html>