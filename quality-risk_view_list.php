<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Risk Assesment List";

if (isset($_SESSION['update_risk'])) {
	//alert($_SESSION['update_risk']);
	$msg = $_SESSION['update_risk'];
	echo "<script type='text/javascript'>alert('$msg');</script>";
	unset($_SESSION['update_risk']);
}
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

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->

<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled" onload="loadCharts()">
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
				<!-- Breadcrumbs + Actions -->

				<div class="row breadcrumbs">
					<div class="col-lg-6">
						<p><a href="/">Home</a> » <a href="/quality-risk.php">Risk Assesment</a> » <?php echo $_SESSION['Page_Title']; ?></p>
						<!-- MIGAS DE PAN -->
					</div>

					<div class="col-lg-6">
						<div class="d-flex justify-content-end">
							<a href="/quality-risk_add.php">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									New Risk
								</button>
							</a>
							<a href="/quality-risk.php">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									<i class="bi bi-speedometer2"></i> View Dashboard
								</button>
							</a>
						</div>
					</div>
				</div>

				<!-- End Breadcrumbs + Actions -->

				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
					<!--begin::Container-->
					<div class="container-custom" id="kt_content_container">
						<!-- AQUI AÑADIR EL CONTENIDO  -->

						<!--begin::LISTADO-->
						<!--begin::Card body-->
						<div class="container-custom card">

							<!--begin::FILTROS-->
							<div class="content d-flex flex-column flex-column-fluid filtros-audit" style="padding: 0;">
								<!--begin::Container-->
								<div class="container-full">

									<form class="form" action="includes/quality-risk_filter.php" method="post" enctype="multipart/form-data">
										<div class="card-body">
											<div class="form-group row mt-3">

												<div class="col-lg-2">
													<label class="filterlabel-j6">On behalf of:</label>
													<select class="form-control" name="on_behalf">
														<option value="blank_option"></option>
														<?php
														$sql_datos_employees = "SELECT * FROM Basic_Employee";
														$connect_data2 = mysqli_query($con, $sql_datos_employees);

														while ($result_data = mysqli_fetch_assoc($connect_data2)) {
															if ($result_data['Status'] == 'Active') {
														?>
																<option value="<?php echo $result_data['Id_employee']; ?>"><?php echo $result_data['First_Name']; ?> <?php echo $result_data['Last_Name']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>

												<div class="col-lg-2">
													<label class="filterlabel-j6">Plant:</label>
													<select class="form-control" name="Id_plant" id="plant" onchange="AgregrarPlantRelacionados();">
														<option value="blank_option"></option>
														<?php
														$sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															if ($result_data['Status'] == 'Active') {
														?>
																<option value="<?php echo $result_data['Id_plant']; ?>"><?php echo $result_data['Title']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>

												<div class="col-lg-2">
													<label class="filterlabel-j6">Department:</label>
													<select class="form-control" id="department" name="Id_department">
														<option value="blank_option"></option>
														<?php
														$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															if ($result_data['Status'] == 'Active') {
														?>
																<option value="<?php echo $result_data['Id_department']; ?>"><?php echo $result_data['Department']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>

												<div class="col-lg-2">
													<label class="filterlabel-j6">Impact:</label>
													<select class="form-control" name="impact">
														<option value="blank_option"></option>
														<option value="Minor" class="impact-Minor">Minor</option>
														<option value="Moderate" class="impact-Moderate">Moderate</option>
														<option value="Major" class="impact-Major">Major</option>
														<option value="Critical" class="impact-Critical">Critical</option>
													</select>
												</div>

												<div class="col-lg-2">
													<label class="filterlabel-j6">Assessment:</label>
													<select class="form-control" name="assessment">
														<option value="blank_option"></option>
														<option value="0-25">0-25%</option>
														<option value="26-50">26-50%</option>
														<option value="51-75">51-75%</option>
														<option value="76-100">76-100%</option>
													</select>
												</div>


												<div class="col-lg-2">
													<label class="filterlabel-j6">Approval:</label>
													<select class="form-control" name="approval">
														<option value="blank_option"></option>
														<option value="Approved">Approved</option>
														<option value="Open">Open</option>
													</select>
												</div>

											</div>
											<div class="form-group row mt-3 filterbott">
												<div class="col-lg-2">
												</div>
												<div class="col-lg-10 text-end">
													<input type="submit" value="Apply Filter">
													<input type="reset" value="Reset Filter" onClick="window.location = '/quality-risk_view_list.php'">
												</div>
											</div>
										</div>


									</form>
								</div>
							</div>
							<!--end::FILTROS-->


							<div class="card-body pt-0 table-responsive">
								<!--begin::Table-->
								<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-muted text-uppercase gs-0">
											<th class="min-w-25px">U. ID</th>
											<th class="min-w-75px">On Behalf of</th>
											<th class="min-w-75px">Plant</th>
											<th class="min-w-75px">Department</th>
											<th class="min-w-50px">Status</th>
											<th class="min-w-50px">Impact</th>
											<th class="min-w-50px">Assessment</th>
											<th class="min-w-50px">Approval</th>
											<th class="text-end min-w-50px">Action</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<?php

									if ($_REQUEST['impact']) {
										/*Acceso mediante Matrix*/
										if ($_SESSION['matrix_dep']) {
											/*Acceso con filtro*/
											$sql_data = "SELECT * FROM Quality_Risk WHERE Impact = '$_REQUEST[impact]' AND Assessment = '$_REQUEST[assessment]' AND Id_department = '$_SESSION[matrix_dep]' AND Id_plant = '$_SESSION[matrix_plant]' AND Id_product_group = '$_SESSION[matrix_pg]' AND Date_date BETWEEN '$_SESSION[matrix_from]' AND '$_SESSION[matrix_end]'";
											/*PAGINACION*/
											$pagination_ok = 0;
										} else {
											/*Acceso SIN filtro*/
											$sql_data = "SELECT * FROM Quality_Risk WHERE Impact = '$_REQUEST[impact]' AND Assessment = '$_REQUEST[assessment]'";
											/*PAGINACION*/
											$pagination_ok = 0;
										}
									} else {
										/*Acceso a view list normal*/
										if ($_SESSION["risk_data"]) {
											$sql_data = $_SESSION["risk_data"];
											unset($_SESSION['risk_data']);
											/*PAGINACION*/
											$pagination_ok = 0;
										} else {
											$sql_data = "SELECT * FROM Quality_Risk";
											/*PAGINACION*/
											$pagination_ok = 1;
										}
									}

									$connect_data = mysqli_query($con, $sql_data);

									/*PAGINACION*/

									/*Numero total de registros*/
									$num_rows = mysqli_num_rows($connect_data);

									/*contador*/
									$page_register_count = 0;

									/*max. registros por pagina*/
									$max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 10;

									/*Si hay paginación*/
									if ($_REQUEST['page'] && $_REQUEST['page'] != 1) {
										$this_page = $_REQUEST['page'] - 1;
										$pass_registers = $max_registers_page * $this_page;
										$registers_off = 0;
									} else {
										/*Si es la primera página, ponemos esto para que evite el uso del continue - Saltaba el primer registro sin esto-*/
										$this_page = 0;
										$pass_registers = 0;
										$registers_off = 0;
									}



									while ($result_risk = mysqli_fetch_assoc($connect_data)) {

										/*PAGINACION*/
										if ($pagination_ok == 1) {
											/*codigo para saltar registros de paginas anteriores*/
											if ($registers_off != $pass_registers) {
												$registers_off++;
												continue;
											}

											/*codigo para mostrar solo los registros de la pagina*/
											if ($page_register_count != $max_registers_page) {
												$page_register_count++;
											} else {
												break;
											}
										}


										$sql_datos_employees = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_risk[Id_employee]'";
										$connect_data2 = mysqli_query($con, $sql_datos_employees);
										$result_data = mysqli_fetch_assoc($connect_data2);

									?>
										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold">
											<tr>
												<td><?php echo $result_risk['Id_quality_risk']; ?></td>
												<td><?php echo $result_data['First_Name']; ?> <?php echo $result_data['Last_Name']; ?></td>
												<td>
													<?php
													$sql_data_plants = "SELECT Id_plant, Title FROM Basic_Plant WHERE Id_plant = '$result_risk[Id_plant]'";
													$connect_data_plants = mysqli_query($con, $sql_data_plants);
													$result_data_plants = mysqli_fetch_assoc($connect_data_plants);
													?>
													<?php echo $result_data_plants['Title']; ?>
												</td>
												<td>
													<?php
													$sql_data_dep = "SELECT Id_department, Department FROM Basic_Department WHERE Id_department = '$result_risk[Id_department]'";
													$connect_data_dep = mysqli_query($con, $sql_data_dep);
													$result_data_dep = mysqli_fetch_assoc($connect_data_dep);
													?>
													<?php echo $result_data_dep['Department']; ?>
												</td>
												<td><span class="status-<?php echo $result_risk['Status']; ?>"><i class="bi bi-circle-fill status-<?php echo $result_risk['Status']; ?>"></i> <?php echo $result_risk['Status']; ?></span></td>

												<td><span class="impact-<?php echo $result_risk['Impact']; ?>"><i class="bi bi-circle-fill impact-<?php echo $result_risk['Impact']; ?>"></i> <?php echo $result_risk['Impact']; ?></span></td>

												<td><?php echo $result_risk['Assessment']; ?>%</td>


												<!-- DECISION -->
												<?php if ($result_risk['Decision'] == 'Approved') { ?>
													<td>
														<div class="badge badge-light-success">Approved</div>
													</td>
												<?php } ?>
												<?php if ($result_risk['Decision'] == 'Open') { ?>
													<td>
														<div class="badge badge-light-warning">Open</div>
													</td>
												<?php } ?>
												<?php if ($result_risk['Decision'] == 'Rejected') { ?>
													<td>
														<div class="badge badge-light-danger">Rejected</div>
													</td>
												<?php } ?>
												<!-- FIN DECISION -->

												<td class="text-end">
													<a href="/quality-risk_view.php?pg_id=<?php echo $result_risk['Id_quality_risk']; ?>"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i></a>
													<?php if ($result_risk['Decision'] != 'Approved') { ?>
														<?php if ($result_risk['Id_employee'] == $thisemployee or $rol_user_check == 'Superadministrator') { ?>
															<a href="/quality-risk_details.php?pg_id=<?php echo $result_risk['Id_quality_risk']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
														<?php } ?>
														<?php if ($result_risk['Id_employee'] == $thisemployee or $rol_user_check == 'Superadministrator') { ?>
															<?php if ($result_risk['Decision'] != 'Rejected') { ?>
																<a href="/quality-risk_delete.php?pg_id=<?php echo $result_risk['Id_quality_risk']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
															<?php } ?>
														<?php } ?>
													<?php } else { ?>
														<?php if ($result_risk['Decision'] != 'Rejected') { ?>



															<?php
															$flag_canseePDF = 0;

															if ($result_risk['Id_employee'] == $thisemployee or $rol_user_check == 'Superadministrator') {
																$flag_canseePDF = 1;
															} else {
																/*Comprobar si forma parte de los Team Member O es el On behalf of para ver PDF*/
																$sql_data_TM = "SELECT * FROM Quality_Risk_TeamMembers WHERE Id_quality_risk = '$result_risk[Id_quality_risk]'";
																$connect_data_TM = mysqli_query($con, $sql_data_TM);
																while ($result_data_risk_tm = mysqli_fetch_assoc($connect_data_TM)) {
																	$sql_user_TM = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_data_risk_tm[Id_employee]'";
																	$connect_user_TM = mysqli_query($con, $sql_user_TM);
																	$result_user_TM = mysqli_fetch_assoc($connect_user_TM);

																	if ($result_user_TM['Id_employee'] == $thisemployee) {
																		$flag_canseePDF = 1;
																	}
																}
															}

															?>
															<?php
															if ($flag_canseePDF == 1) {
															?>
																<a href="/includes/quality_risk_pdf.php?id_met=<?php echo $result_risk['Id_quality_risk']; ?>"><i class="bi bi-file-earmark-pdf" style="padding-right: 4px;"></i></a>
															<?php } ?>



														<?php } ?>
													<?php } ?>
												</td>
												<!--end::Action=-->
											<?php } ?>

											</tr>


										</tbody>
										<!--end::Table body-->
								</table>
								<!--end::Table-->
							</div>

							<!--start:: PAGINATION-->
							<ul class="pagination pagination-circle pagination-outline">
								<?php
								/*PAGINACION*/
								if ($pagination_ok == 1) {
									$num_pages = $num_rows / $max_registers_page;
									$total_pages = ceil($num_pages);
									$actual_page = 1;

									//echo '<h2>'.$total_pages.'</h2>';

									for ($actual_page = 1; $actual_page <= $total_pages; $actual_page++) {
								?>
										<?php
										if (!$_REQUEST['page']) {
											$_REQUEST['page'] = 1;
										}
										if ($_REQUEST['page'] == $actual_page) {
										?>
											<li class="page-item m-1 active"><a href="/quality-risk_view_list.php?page=<?php echo $actual_page; ?>" class="page-link"><?php echo $actual_page; ?></a></li>
										<?php } else { ?>
											<li class="page-item m-1"><a href="/quality-risk_view_list.php?page=<?php echo $actual_page; ?>" class="page-link"><?php echo $actual_page; ?></a></li>
										<?php } ?>

								<?php
									}
								} ?>
							</ul>
							<!--end:: PAGINATION-->

						</div>
						<!--end::Card body-->
						<!--end::LISTADO-->

						<!-- Finalizar contenido -->
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
			$("<option>").load('includes/inputs-dinamicos-pg-plant_viewlist.php?pg_id=' + result, function() {
				$('#product_group option').remove();
				//alert('includes/inputs-dinamicos-pg-plant.php?pg_id='+result);
				$("#product_group").append($(this).html());
			});

			/*Department*/
			$("<option>").load('includes/inputs-dinamicos-department-plant_viewlist.php?pg_id=' + result, function() {
				$('#department option').remove();
				//alert('includes/inputs-dinamicos-pg-plant.php?pg_id='+result);
				$("#department").append($(this).html());
			});
		}
	</script>
	<!-- BUSCADOR SEARCH PARA: MoC -->
	<script src="JS/buscar-quality-risk-viewlist.js"></script>
	<!-- FIN BUSCADOR SEARCH JS -->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>