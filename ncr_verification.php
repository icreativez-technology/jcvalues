<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "NCR Verification";

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
								Effectiveness verification
							</div>
							<!-- AQUI AÑADIR EL CONTENIDO  -->



							<form class="form" action="includes/ncr_effectiveness_update.php" method="post" enctype="multipart/form-data">
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
												<th class='min-w-50px'>Verified</th>
												<th class='min-w-25px text-end'>Actions</th>
											</thead>


											<tbody class='fw-bold text-gray-600' id="effectiveness">
												<?php
												$sql_datos_ncr_effectiveness = "SELECT * From NCR_Effectiveness_verification WHERE Id_ncr = '$_REQUEST[pg_id]'";
												$conect_datos_ncr_effectiveness = mysqli_query($con, $sql_datos_ncr_effectiveness);
												$flag_effectiveness = 0;
												while ($result_datos_effectiveness = mysqli_fetch_assoc($conect_datos_ncr_effectiveness)) {
													$flag_effectiveness++;
												?>
													<tr>

														<?php
														//echo $result_datos_effectiveness['Significant_cause']; 
														?>

														<?php
														$sql_datos_ncr_why_why = "SELECT * From NCR_Why_Why WHERE Id_ncr_why_why = '$result_datos_effectiveness[Id_ncr_why_why]'";
														$conect_datos_ncr_why_why = mysqli_query($con, $sql_datos_ncr_why_why);
														$result_data_ncr_why_why = mysqli_fetch_assoc($conect_datos_ncr_why_why);
														?>

														<td><?php echo $result_data_ncr_why_why['Root_cause']; ?></td>

														<td><?php echo $result_datos_effectiveness['Corrective_action']; ?></td>

														<?php
														$sql_data_user = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_datos_effectiveness[Who_emp]'";
														$connect_data_user = mysqli_query($con, $sql_data_user);
														$result_data_user = mysqli_fetch_assoc($connect_data_user);
														?>
														<td><?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?></td>
														<td><?php echo $result_datos_effectiveness['When_date']; ?></td>
														<td><?php echo $result_datos_effectiveness['Verified']; ?></td>

														<td class="text-end">
															<a href="/ncr_effectiveness_edit.php?pg_id=<?php echo $result_datos_effectiveness['Id_ncr_effectiveness']; ?>&return_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
															<a href="/includes/ncr_effectiveness_delete.php?pg_id=<?php echo $result_datos_effectiveness['Id_ncr_effectiveness']; ?>&return_id=<?php echo $_REQUEST['pg_id']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
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
		function AgregarMas3() {
			$("<td>").load("includes/inputs-dinamicos-ncr_effectiveness-update.php", function() {
				$("#effectiveness").append($(this).html());
			});
		}

		function BorrarRegistro3() {
			$('tr.campos_effectiveness').each(function(index, item) {
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