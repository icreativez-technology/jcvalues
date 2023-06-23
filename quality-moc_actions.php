<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "MoC Actions";

$sql_data = "SELECT * FROM Quality_MoC WHERE Id_quality_moc = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);


/*Para comprobar el usuario conectado forma parte de los Informed*/
$flag_isinfomed = 0;

if ($_SESSION['usuario']) {
	$email = $_SESSION['usuario'];
	$sql_datos_usuario = "SELECT * From Basic_Employee Where Email = '$email'";
	$result_datos_usuario = mysqli_query($con, $sql_datos_usuario);
	$conectado = mysqli_fetch_assoc($result_datos_usuario);

	$thisemployee = $conectado['Id_employee'];
	$rol_user_check = $conectado['Admin_User'];

	/*bucle*/

	$sql_data2 = "SELECT * FROM Quality_MoC_TeamMembers WHERE Id_quality_moc = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data2);


	while ($result_data_moc_tm = mysqli_fetch_assoc($connect_data)) {
		if ($result_data_moc_tm['Id_employee'] == $thisemployee) {
			$flag_isinfomed = 1;
			break;
		}
	}

	/*Comprobación si el usuario es el creador del MoC*/
	$creador = 0;
	if ($result_data['Id_employee'] == $thisemployee or $rol_user_check == 'Superadministrator') {
		$creador = 1;
	}
}





/*Sesion para Action Plan*/
$_SESSION['Action_Plan_ID'] = $_REQUEST['pg_id'];

?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?> <!-- Meta tags + CSS -->

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
				<?php include('includes/header.php'); ?><!-- Includes Top bar and Responsive Menu -->
				<!-- Breadcrumbs + Actions -->

				<div class="row breadcrumbs">
					<div class="col-lg-6">
						<p><a href="/">Home</a> » <a href="/quality-moc.php">Quality MoC</a> » <a href="/quality-moc_view_list.php">Quality MoC List</a> » <?php echo $_SESSION['Page_Title']; ?></p>
						<!-- MIGAS DE PAN -->
					</div>

					<div class="col-lg-6">
						<div class="d-flex justify-content-end">
							<a href="/quality-moc_view.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									<i class="bi bi-eye-fill"></i>Details
								</button>
							</a>
							<?php if ($result_data['Decision'] == 'Approved') { ?>


								<?php
								$flag_canseePDF = 0;

								if ($result_data['Id_employee'] == $thisemployee or $rol_user_check == 'Superadministrator') {
									$flag_canseePDF = 1;
								} else {
									/*Comprobar si forma parte de los Team Member O es el On behalf of para ver PDF*/
									$sql_data_TM = "SELECT * FROM Quality_MoC_TeamMembers WHERE Id_quality_moc = '$_REQUEST[pg_id]'";
									$connect_data_TM = mysqli_query($con, $sql_data_TM);
									while ($result_data_moc_tm = mysqli_fetch_assoc($connect_data_TM)) {
										$sql_user_TM = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_data_moc_tm[Id_employee]'";
										$connect_user_TM = mysqli_query($con, $sql_user_TM);
										$result_user_TM = mysqli_fetch_assoc($connect_user_TM);

										if ($result_user_TM['Id_employee'] == $result_data['Id_employee']) {
											$flag_canseePDF = 1;
										}
									}
								}

								?>
								<?php
								if ($flag_canseePDF == 1) {
								?>
									<a href="/includes/quality_moc_pdf.php?id_met=<?php echo $_REQUEST['pg_id']; ?>" target="_blank">
										<button type="button" class="btn btn-light-primary me-3 topbottons">
											<i class="bi bi-file-earmark-pdf"></i> Create PDF
										</button>
									</a>
								<?php } ?>



							<?php } ?>
						</div>
					</div>
				</div>

				<!-- End Breadcrumbs + Actions -->

				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
					<!--begin::Container-->
					<div class="container-custom" id="kt_content_container">
						<div class="card card-flush">
							<!-- AQUI AÑADIR EL CONTENIDO  -->



							<form class="form" action="includes/quality-moc_update_actions.php" method="post" enctype="multipart/form-data">
								<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_quality_moc']; ?>" readonly>
								<!-- begin::Form Content -->
								<div class="card-body table-responsive">
									<div class="card-header card-header-stretch pb-0">
										<div class="card-title">
											<h4>Action Plan - MoC <?php echo $_REQUEST['pg_id']; ?></h4>
										</div>
										<?php if ($result_data['Decision'] != 'Approved') { ?>
											<?php if ($flag_isinfomed == 1 or $creador == 1) { ?>
												<div class="card-toolbar m-4">
													<input class="btn btn-success" type="button" name="add" value="+" onClick="AgregarMas();" /><input class="btn btn-danger" type="button" name="delete" value="-" onClick="BorrarRegistro();" />
												</div>
											<?php } ?>
										<?php } ?>
									</div>
									<div id="custom-section-1">

										<table class='table align-middle table-row-dashed fs-6 gy-5'>
											<thead>
												<!--<th class='min-w-25px'>SNo</th>-->
												<th class='min-w-500px'>Action Point</th>
												<th class='min-w-125px'>Who</th>
												<th class='min-w-50px'>When</th>
												<th class='min-w-125px'>Verified</th>
												<th class='min-w-75px'>Status</th>
												<?php if ($result_data['Decision'] != 'Approved') { ?>
													<th class='min-w-5px text-end'>Actions</th>
												<?php } ?>

											</thead>


											<tbody class='fw-bold text-gray-600' id="moc-actions">
												<?php
												$sql_datos_moc_actions = "SELECT * From Quality_MoC_Action WHERE Id_quality_moc = '$_REQUEST[pg_id]'";

												$conect_datos_moc_actions = mysqli_query($con, $sql_datos_moc_actions);
												$flag_decision = 0;
												$statusglobal = 0;


												while ($result_datos_moc_actions = mysqli_fetch_assoc($conect_datos_moc_actions)) {
													$flag_decision++;
												?>
													<tr>
														<!--<td><?php echo $result_datos_moc_actions['Sno']; ?></td>-->
														<td><?php echo $result_datos_moc_actions['Action_point']; ?></td>

														<td>
															<?php
															$sql_user = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_datos_moc_actions[Id_employee]'";
															$connect_user = mysqli_query($con, $sql_user);
															$result_user = mysqli_fetch_assoc($connect_user);

															echo $result_user['First_Name'] . ' ' . $result_user['Last_Name'];

															?>
														</td>

														<td><?php echo date("d-m-y", strtotime($result_datos_moc_actions['Date_date'])); ?></td>
														<td>
															<?php
															$sql_user2 = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_datos_moc_actions[Verified]'";
															$connect_user2 = mysqli_query($con, $sql_user2);
															$result_user2 = mysqli_fetch_assoc($connect_user2);

															$letra1 = substr($result_user2['First_Name'], 0, 1);
															$letra2 = substr($result_user2['Last_Name'], 0, 1);
															$nombre = $letra1 . $letra2;

															echo $nombre;

															?>

														</td>
														<td>
															<?php
															/*Check if status is 100% for the complete approval update*/
															if ($result_datos_moc_actions['Status'] == 100) {
																$statusglobal++;
															}

															if ($result_datos_moc_actions['Status'] >= 66) {
																echo '<div class="badge badge-light-success">';
															} else {
																if ($result_datos_moc_actions['Status'] <= 33) {
																	echo '<div class="badge badge-light-danger">';
																} else {
																	echo '<div class="badge badge-light-warning">';
																}
															}
															?>
															<?php echo $result_datos_moc_actions['Status']; ?>%
									</div>
									</td>
									<?php if ($result_data['Decision'] == 'Rejected') { ?>

										<?php
														/*Selecciona los actions que han sido rechazados la primera vez para que no se puedan editar.*/
														$sql_data_r_action = "SELECT * FROM Quality_MoC_Rejected_Action WHERE Id_quality_moc_action = '$result_datos_moc_actions[Id_quality_moc_action]'";
														$connect_data_r_action = mysqli_query($con, $sql_data_r_action);
														$result_data_r_action = mysqli_fetch_assoc($connect_data_r_action);

														if (!$result_data_r_action) {
										?>
											<td class="text-end">
												<?php if ($result_datos_moc_actions['Id_employee'] == $thisemployee or $creador == 1) { ?>
													<a href="/quality-moc_actions_edit.php?pg_id=<?php echo $result_datos_moc_actions['Id_quality_moc_action']; ?>&return_id=<?php echo $result_data['Id_quality_moc']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
													<a href="/includes/quality-moc_delete_actions.php?pg_id=<?php echo $result_datos_moc_actions['Id_quality_moc_action']; ?>&return_id=<?php echo $result_data['Id_quality_moc']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
												<?php } ?>
											</td>
										<?php }
													} else { ?>
										<?php if ($result_data['Decision'] != 'Approved') { ?>
											<td class="text-end">
												<?php if ($result_datos_moc_actions['Id_employee'] == $thisemployee or $creador == 1) { ?>
													<a href="/quality-moc_actions_edit.php?pg_id=<?php echo $result_datos_moc_actions['Id_quality_moc_action']; ?>&return_id=<?php echo $result_data['Id_quality_moc']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
													<a href="/includes/quality-moc_delete_actions.php?pg_id=<?php echo $result_datos_moc_actions['Id_quality_moc_action']; ?>&return_id=<?php echo $result_data['Id_quality_moc']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
												<?php } ?>
											</td>
										<?php } ?>
									<?php } ?>
									</tr>
								<?php
												}
								?>
								</tbody>

								</table>
								</div>


						</div>
						<!-- end::Form Content -->

						<?php if ($result_data['Decision'] != 'Approved') { ?>
							<div class="card-footer">
								<div class="row" style="text-align: center;">
									<div>
										<?php if ($flag_isinfomed == 1 or $creador == 1) { ?>
											<input type="submit" class="btn btn-lg btn-primary mb-5" value="Update">
										<?php } ?>
									</div>
								</div>
							</div>
						<?php } ?>


						</form>
					</div>
					<!-- Finalizar contenido -->
				</div>
				<!--end::Container-->
			</div>
			<!--end::Content-->




			<!--begin::Content-->
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
				<!--begin::Container-->
				<div class="container-custom" id="kt_content_container">
					<!-- AQUI AÑADIR EL CONTENIDO  -->


					<div class="card card-flush">
						<div class="container-full customer-header">
							Approval
						</div>
						<form class="form" action="includes/quality-moc_update_approval.php" method="post" enctype="multipart/form-data">
							<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_quality_moc']; ?>" readonly>
							<input type="hidden" name="actual_decision" id="actual_decision" value="<?php echo $result_data['Decision']; ?>" readonly>

							<!-- begin::Form Content -->
							<div class="card-body">
								<div id="custom-section-1">

									<div class="form-group row">
										<div class="col-lg-2">
											<label>Decision</label>
											<?php if ($result_data['Decision'] == 'Approved') {
											?>

												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Approved" id="kt_modal_update_role_option_0" checked='checked' />
													<label class="form-check-label" for="kt_modal_update_role_option_0">
														Approved
													</label>
												</div>
												<!--<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Open" id="kt_modal_update_role_option_2" />
													<label class="form-check-label" for="kt_modal_update_role_option_2">
														Open
													</label>
												</div>-->
											<?php
											}
											?>

											<?php if ($result_data['Decision'] == 'Open') {
											?>

												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Approved" id="kt_modal_update_role_option_0" />
													<label class="form-check-label" for="kt_modal_update_role_option_0">
														Approved
													</label>
												</div>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Open" id="kt_modal_update_role_option_2" checked='checked' />
													<label class="form-check-label" for="kt_modal_update_role_option_2">
														Open
													</label>
												</div>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Rejected" id="kt_modal_update_role_option_1" />
													<label class="form-check-label" for="kt_modal_update_role_option_1">
														Rejected
													</label>
												</div>
											<?php
											}
											?>

											<?php if ($result_data['Decision'] == 'Rejected') {
											?>

												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Approved" id="kt_modal_update_role_option_0" />
													<label class="form-check-label" for="kt_modal_update_role_option_0">
														Approved
													</label>
												</div>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Rejected" id="kt_modal_update_role_option_1" checked='checked' />
													<label class="form-check-label" for="kt_modal_update_role_option_1">
														Rejected
													</label>
												</div>
											<?php
											}
											?>
										</div>

										<div class="col-lg-10">
											<label>Decision Remarks</label>
											<?php if ($result_data['Decision'] == 'Open') {
											?>
												<input type="text" class="form-control" name="remarks" value="<?php echo $result_data['Decision_Remarks']; ?>">
											<?php
											} else {
											?>
												<input type="text" class="form-control" name="remarks" value="<?php echo $result_data['Decision_Remarks']; ?>" readonly>
											<?php
											}
											?>
										</div>

									</div>

								</div>
							</div>

							<?php if ($result_data['Decision'] != 'Approved') { ?>
								<?php if ($creador == 1) { ?>
									<div class="card-footer">
										<div class="row" style="text-align: center;">

											<?php  /*Solamente se puede hacer update si hay algo en el action plan*/
											if ($flag_decision >= 1 && $statusglobal == $flag_decision) { ?>
												<div>
													<button type="submit" class="btn btn-primary mr-2">Update decision</button>
												</div>
											<?php } else { ?>
												<div>
													<p style="text-align: center;">At least an Action Plan must be set before update the Approval Decision. Also, all the Action Plans must have the status at 100%.</p>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							<?php } ?>

						</form>
					</div>


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
		function AgregarMas() {
			$("<td>").load("includes/inputs-dinamicos-quality-moc-actions-update.php", function() {
				$("#moc-actions").append($(this).html());
			});
		}

		function BorrarRegistro() {
			$('tr.campos_moc-actions').each(function(index, item) {
				jQuery(':checkbox', this).each(function() {
					if ($(this).is(':checked')) {
						$(item).remove();
					}
				});
			});
		}
	</script>
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>