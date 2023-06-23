<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Audit Finding View";

$date_m = $_GET["date_m"];
$date_y = $_GET["date_y"];

$consulta_audit_finding_view = "SELECT * FROM Audit_Management_Findings WHERE 	Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'$date_y-$date_m-01') AND DATE_FORMAT(NOW() ,'$date_y-$date_m-31');";
$consulta_general_audit_finding_view = mysqli_query($con, $consulta_audit_finding_view);

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
							<p><a href="/">Home</a> » <a href="/audit.php">Finding</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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
							<!--begin::Content-->
							<div class="content d-flex flex-column flex-column-fluid" style="padding: 30px 0 0 !important;">
								<!--begin::Container-->
								<div class="container-custom">

									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
											<!--begin::Table head-->
											<thead>
												<!--begin::Table row-->
												<tr class="text-start text-muted text-uppercase gs-0">
													<th class="min-w-25px">U. ID</th>
													<th class="min-w-125px">Finding Type</th>
													<th class="min-w-125px">Auditor</th>
													<th class="min-w-125px">Auditee</th>
													<th class="min-w-125px">Plan Date</th>
													<th class="min-w-125px">Status</th>
													<th class="text-end min-w-70px">Actions</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="text-gray-600 fw-bold">
												<?php
												while ($result_audit_finding = mysqli_fetch_assoc($consulta_general_audit_finding_view)) {
												?>
													<tr>
														<!--begin::Number-->
														<td class="hidde-responsive-j6"><?php echo $result_audit_finding['Custom_Id']; ?></td>
														<!--end::Number-->
														<!--begin::Audit Area=-->
														<td>
															<?php
															$id_finding_area = $result_audit_finding['Id_finding_types'];
															$consulta_audit_area = "SELECT * FROM Finding_Types WHERE Id_finding_types = $id_finding_area";
															$consulta_general_finding_area = mysqli_query($con, $consulta_audit_area);
															$result_finding_area = mysqli_fetch_assoc($consulta_general_finding_area);
															echo $result_finding_area['Title'];
															?>

														</td>
														<!--end::Audit Area=-->
														<!--begin::Auditor-->
														<td>
															<div>
																<?php
																$id_auditor = $result_audit_finding['Id_audit_auditor'];
																$consulta_audit_auditor = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_auditor";
																$consulta_general_audit_auditor = mysqli_query($con, $consulta_audit_auditor);
																$result_audit_auditor = mysqli_fetch_assoc($consulta_general_audit_auditor);
																echo $result_audit_auditor['First_Name'] . ' ' . $result_audit_auditor['Last_Name'];
																?>
															</div>
														</td>
														<!--end::Auditor-->
														<!--begin::Auditee-->
														<td><?php
															$id_auditee = $result_audit_finding['Id_audit_auditee'];
															$consulta_audit_auditee = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_auditee";
															$consulta_general_audit_auditee = mysqli_query($con, $consulta_audit_auditee);
															$result_audit_auditee = mysqli_fetch_assoc($consulta_general_audit_auditee);
															echo $result_audit_auditee['First_Name'] . ' ' . $result_audit_auditee['Last_Name'];
															?></td>
														<!--end::Auditee-->
														<!--begin::Plan Date-->
														<td><?php echo date("d-m-y", strtotime($result_audit_finding['Finding_created_date'])); ?></td>
														<!--end::Plan Date-->
														<!--begin::Status-->
														<td>
															<?php if ($result_audit_finding['Status'] == 'Completed') { ?>
																<div class="status-active"><?php echo $result_audit_finding['Status']; ?></div>
															<?php } else { ?>

																<div class="status-danger"><?php echo $result_audit_finding['Status']; ?></div>
															<?php } ?>
														</td>
														<!--end::Status-->
														<!--begin::Action=-->
														<td class="text-end">
															<!--end::Svg Icon-->
															<!--begin::Menu-->

															<a href="audit_finding_view_schedule.php?audit_f_id=<?php echo $result_audit_finding['Id_Audit_Management_Findings']; ?>"><i class="bi bi-eye-fill"></i></a>

															<!--end::Menu item-->
															<!--begin::Menu item-->

															<a href="/audit_finding_edit.php?audit_f_id=<?php echo $result_audit_finding['Id_Audit_Management_Findings']; ?>"><i class="bi bi-pencil"></i></a>

															<!--end::Menu item-->
															<!--begin::Menu item-->
															<a href="/finding_delete.php?audit_f_id=<?php echo $result_audit_finding['Id_Audit_Management_Findings']; ?>"><i class="bi bi-trash"></i></a>

															<!--end::Menu item-->
									</div>
									<!--end::Menu-->
									</td>
									<!--end::Action=-->
									</tr>
								<?php } ?>
								</tbody>
								<!--end::Table body-->
								</table>
								<!--end::Table-->
								</div>
								<!--end::Card body-->


								<!-- Finalizar contenido -->
							</div>
						</div>
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
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>