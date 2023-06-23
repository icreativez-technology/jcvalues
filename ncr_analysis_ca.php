<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "NCR Analysis & CA";

$sql_data = "SELECT * FROM NCR WHERE Id_ncr = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);

$_SESSION['ncr_id_inp_din'] = $_REQUEST['pg_id'];

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
						<p><a href="/">Home</a> » <a href="/ncr.php">NCR</a> » <a href="/ncr_view_list.php">NCR List</a> » <a href="/ncr_view.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">View NCR</a> » <?php echo $_SESSION['Page_Title']; ?></p>
						<!-- MIGAS DE PAN -->
					</div>

					<div class="col-lg-6">
						<div class="d-flex justify-content-end">
							<a href="/ncr_analysis_ca.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									Analysis & CA
								</button>
							</a>
							<a href="/ncr_verification.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									Verification
								</button>
							</a>
							<a href="/ncr_mr_approval.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									MR Approval
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
						<div class="card card-flush">
							<div class="container-full customer-header">
								Cause Analysis Table (4M Analysis)
							</div>
							<!-- AQUI AÑADIR EL CONTENIDO  -->



							<form class="form" action="includes/ncr_analysis_update_cause.php" method="post" enctype="multipart/form-data">
								<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_ncr']; ?>" readonly>
								<!-- begin::Form Content -->
								<div class="card-body table-responsive">
									<div class="card-header card-header-stretch pb-0">
										<div class="card-title">
										</div>
										<div class="card-toolbar m-4">
											<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMas();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistro();" />
										</div>
									</div>
									<div id="custom-section-1">

										<table class='table align-middle table-row-dashed fs-6 gy-5'>
											<thead>
												<th class='min-w-150px'>Category</th>
												<th class='min-w-150px'>Cause</th>
												<th class='min-w-150px'>Significant</th>
												<th class='min-w-25px text-end'>Actions</th>

											</thead>


											<tbody class='fw-bold text-gray-600' id="analysis-cause">
												<?php
												$sql_datos_ncr_analysis = "SELECT * From NCR_Analysis WHERE Id_ncr = '$_REQUEST[pg_id]'";
												$conect_datos_ncr_analysis = mysqli_query($con, $sql_datos_ncr_analysis);
												$flag_analysis = 0;
												while ($result_datos_ncr_analysis = mysqli_fetch_assoc($conect_datos_ncr_analysis)) {
													$flag_analysis++;
												?>
													<tr>
														<td><?php echo $result_datos_ncr_analysis['Category']; ?></td>
														<td><?php echo $result_datos_ncr_analysis['Cause']; ?></td>
														<td><?php echo $result_datos_ncr_analysis['Significant']; ?></td>
														<td class="text-end">
															<a href="/ncr_analysis_edit_cause.php?pg_id=<?php echo $result_datos_ncr_analysis['Id_ncr_analysis']; ?>&return_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
															<a href="/includes/ncr_analysis_delete_cause.php?pg_id=<?php echo $result_datos_ncr_analysis['Id_ncr_analysis']; ?>&return_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
														</td>
													</tr>
												<?php
												}
												?>
											</tbody>

										</table>
									</div>


								</div>
								<!-- end::Form Content -->

								<div class="card-footer">
									<div class="row" style="text-align: center;">
										<div>
											<input type="submit" class="btn btn-sm btn-success m-3" value="Update">
										</div>
									</div>
								</div>


							</form>
						</div>
						<!-- Finalizar contenido -->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Content-->




				<!--



						WHY WHY ANALYSIS






					-->


				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
					<!--begin::Container-->
					<div class="container-custom" id="kt_content_container">
						<div class="card card-flush">
							<div class="container-full customer-header">
								Why Why Analysis
							</div>
							<!-- AQUI AÑADIR EL CONTENIDO  -->



							<form class="form" action="includes/ncr_why_why_update.php" method="post" enctype="multipart/form-data">
								<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_ncr']; ?>" readonly>
								<!-- begin::Form Content -->
								<div class="card-body table-responsive">
									<div class="card-header card-header-stretch pb-0">
										<div class="card-title">
										</div>
										<div class="card-toolbar m-4">
											<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMas2();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistro2();" />
										</div>
									</div>
									<div id="custom-section-2">

										<table class='table align-middle table-row-dashed fs-6 gy-5'>
											<thead>
												<th class='min-w-150px'>Significant Cause</th>
												<th class='min-w-50px'>1<sup>st</sup> Why</th>
												<th class='min-w-50px'>2<sup>nd</sup> Why</th>
												<th class='min-w-50px'>3<sup>rd</sup> Why</th>
												<th class='min-w-50px'>4<sup>th</sup> Why</th>
												<th class='min-w-50px'>5<sup>th</sup> Why</th>
												<th class='min-w-50px'>Root Cause</th>

												<th class='min-w-25px text-end'>Actions</th>

											</thead>


											<tbody class='fw-bold text-gray-600' id="why-why">
												<?php
												$sql_datos_ncr_why_why = "SELECT * From NCR_Why_Why WHERE Id_ncr = '$_REQUEST[pg_id]'";
												$conect_datos_ncr_why_why = mysqli_query($con, $sql_datos_ncr_why_why);
												$flag_why_why = 0;
												while ($result_datos_ncr_why_why = mysqli_fetch_assoc($conect_datos_ncr_why_why)) {
													$flag_why_why++;
												?>
													<tr>

														<?php
														//echo $result_datos_ncr_why_why['Significant_cause']; 
														?>

														<?php
														$sql_datos_ncr_analysis = "SELECT * From NCR_Analysis WHERE Id_ncr_analysis = '$result_datos_ncr_why_why[Id_ncr_analysis]'";
														$conect_datos_ncr_analysis = mysqli_query($con, $sql_datos_ncr_analysis);
														$result_data_ncr_analysis = mysqli_fetch_assoc($conect_datos_ncr_analysis);
														?>

														<td><?php echo $result_data_ncr_analysis['Cause']; ?></td>

														<td><?php echo $result_datos_ncr_why_why['First_why']; ?></td>
														<td><?php echo $result_datos_ncr_why_why['Second_why']; ?></td>
														<td><?php echo $result_datos_ncr_why_why['Third_why']; ?></td>
														<td><?php echo $result_datos_ncr_why_why['Fourth_why']; ?></td>
														<td><?php echo $result_datos_ncr_why_why['Fifth_why']; ?></td>
														<td><?php echo $result_datos_ncr_why_why['Root_cause']; ?></td>
														<td class="text-end">
															<a href="/ncr_why_why_edit.php?pg_id=<?php echo $result_datos_ncr_why_why['Id_ncr_why_why']; ?>&return_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
															<a href="/includes/ncr_why_why_delete.php?pg_id=<?php echo $result_datos_ncr_why_why['Id_ncr_why_why']; ?>&return_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
														</td>
													</tr>
												<?php
												}
												?>
											</tbody>

										</table>
									</div>


								</div>
								<!-- end::Form Content -->

								<div class="card-footer">
									<div class="row" style="text-align: center;">
										<div>
											<input type="submit" class="btn btn-sm btn-success m-3" value="Update">
										</div>
									</div>
								</div>


							</form>
						</div>
						<!-- Finalizar contenido -->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Content-->




				<!--



						CORRECTIVE ACTION PLAN






					-->


				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
					<!--begin::Container-->
					<div class="container-custom" id="kt_content_container">
						<div class="card card-flush">
							<div class="container-full customer-header">
								Corrective Action Plan
							</div>
							<!-- AQUI AÑADIR EL CONTENIDO  -->



							<form class="form" action="includes/ncr_corrective_update.php" method="post" enctype="multipart/form-data">
								<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_ncr']; ?>" readonly>
								<!-- begin::Form Content -->
								<div class="card-body table-responsive">
									<div class="card-header card-header-stretch pb-0">
										<div class="card-title">
										</div>
										<div class="card-toolbar m-4">
											<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMas3();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistro3();" />
										</div>
									</div>
									<div id="custom-section-2">

										<table class='table align-middle table-row-dashed fs-6 gy-5'>
											<thead>
												<th class='min-w-125px'>Root Cause</th>
												<th class='min-w-125px'>Corrective action</th>
												<th class='min-w-125px'>Who</th>
												<th class='min-w-50px'>When</th>
												<th class='min-w-50px'>#Review</th>
												<th class='min-w-25px'>Status</th>
												<th class='min-w-25px text-end'>Actions</th>
											</thead>


											<tbody class='fw-bold text-gray-600' id="corrective">
												<?php
												$sql_datos_ncr_corrective = "SELECT * From NCR_Corrective_Action_Plan WHERE Id_ncr = '$_REQUEST[pg_id]'";
												$conect_datos_ncr_corrective = mysqli_query($con, $sql_datos_ncr_corrective);
												$flag_corrective = 0;
												while ($result_datos_corrective = mysqli_fetch_assoc($conect_datos_ncr_corrective)) {
													$flag_corrective++;
												?>
													<tr>

														<?php
														//echo $result_datos_corrective['Significant_cause']; 
														?>

														<?php
														$sql_datos_ncr_why_why = "SELECT * From NCR_Why_Why WHERE Id_ncr_why_why = '$result_datos_corrective[Id_ncr_why_why]'";
														$conect_datos_ncr_why_why = mysqli_query($con, $sql_datos_ncr_why_why);
														$result_data_ncr_why_why = mysqli_fetch_assoc($conect_datos_ncr_why_why);
														?>

														<td><?php echo $result_data_ncr_why_why['Root_cause']; ?></td>

														<td><?php echo $result_datos_corrective['Corrective_action']; ?></td>

														<?php
														$sql_data_user = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_datos_corrective[Who_emp]'";
														$connect_data_user = mysqli_query($con, $sql_data_user);
														$result_data_user = mysqli_fetch_assoc($connect_data_user);
														?>
														<td><?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?></td>
														<td><?php echo $result_datos_corrective['When_date']; ?></td>
														<td><?php echo $result_datos_corrective['Review']; ?></td>

														<td>
															<?php
															if ($result_datos_corrective['Status'] >= 66) {
																echo '<div class="badge badge-light-success">';
															} else {
																if ($result_datos_corrective['Status'] <= 33) {
																	echo '<div class="badge badge-light-danger">';
																} else {
																	echo '<div class="badge badge-light-warning">';
																}
															}
															?>
															<?php echo $result_datos_corrective['Status']; ?>%
									</div>
									</td>

									<td class="text-end">
										<a href="/ncr_corrective_edit.php?pg_id=<?php echo $result_datos_corrective['Id_ncr_corrective']; ?>&return_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
										<a href="/includes/ncr_corrective_delete.php?pg_id=<?php echo $result_datos_corrective['Id_ncr_corrective']; ?>&return_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
									</td>
									</tr>
								<?php
												}
								?>
								</tbody>

								</table>
								</div>


						</div>
						<!-- end::Form Content -->

						<div class="card-footer">
							<div class="row" style="text-align: center;">
								<div>
									<input type="submit" class="btn btn-sm btn-success m-3" value="Update">
								</div>
							</div>
						</div>


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
			$("<td>").load("includes/inputs-dinamicos-ncr_analysis_cause-update.php", function() {
				$("#analysis-cause").append($(this).html());
			});
		}

		function BorrarRegistro() {
			$('tr.campos_analysis-cause').each(function(index, item) {
				jQuery(':checkbox', this).each(function() {
					if ($(this).is(':checked')) {
						$(item).remove();
					}
				});
			});
		}

		function AgregarMas2() {
			$("<td>").load("includes/inputs-dinamicos-ncr_why-why-update.php", function() {
				$("#why-why").append($(this).html());
			});
		}

		function BorrarRegistro2() {
			$('tr.campos_why-why').each(function(index, item) {
				jQuery(':checkbox', this).each(function() {
					if ($(this).is(':checked')) {
						$(item).remove();
					}
				});
			});
		}

		function AgregarMas3() {
			$("<td>").load("includes/inputs-dinamicos-ncr_corrective-update.php", function() {
				$("#corrective").append($(this).html());
			});
		}

		function BorrarRegistro3() {
			$('tr.campos_corrective').each(function(index, item) {
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