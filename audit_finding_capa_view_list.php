<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Audit Finding Capa View List";
$id_audit_finding = $_REQUEST['id_aduit_find'];
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
				<!-- Breadcrumbs + Actions -->

				<div class="row breadcrumbs">
					<div class="col-lg-6">
						<p><a href="/">Home</a> » <a href="/audit.php">Finding</a> » <a href="/audit_finding_edit.php?audit_f_id=<?php echo $id_audit_finding ?>">View Audit Finding </a> » <?php echo $_SESSION['Page_Title']; ?> </p>
						<!-- MIGAS DE PAN -->
					</div>

					<div class="col-lg-6">
						<div class="d-flex justify-content-end">


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
							<div class="card-body pt-0 table-responsive">


								<table class='table align-middle table-row-dashed fs-6 gy-5' id="meet_resultados">
								</table>
								<!--begin::Table-->
								<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-muted text-uppercase gs-0">
											<th class="min-w-50px">S No</th>
											<th class="min-w-50px">Description</th>
											<th class="min-w-50px">Date</th>
											<th class="min-w-50px">Status</th>

										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<?php
									$sql_datos_capa = "SELECT * From Audit_Management_Findings_Capa WHERE 	Id_Audit_Management_Findings = $id_audit_finding";
									$conect_datos_capa = mysqli_query($con, $sql_datos_capa);

									while ($result_datos_capa = mysqli_fetch_assoc($conect_datos_capa)) {
										$Id_Audit_Management_Findings_Capaa = $result_datos_capa['Id_Audit_Management_Findings_Capaa'];
									?>

										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold">
											<tr>
												<!--begin::S No-->
												<td><?php echo $result_datos_capa['Id_Audit_Management_Findings_Capaa']; ?></td>
												<!--end::S No-->
												<!--begin::Meeting Date=-->
												<td>
													<?php echo $result_datos_capa['Description']; ?>
												</td>
												<!--end::Meeting Date=-->

												<!--begin::Title-->
												<td>
													<?php echo date("d-m-y", strtotime($result_datos_capa['Date_capa'])); ?>
												</td>
												<!--end::Title-->

												<!--begin::Coordinator-->
												<td>
													<?php if ($result_datos_capa['Status'] == 'Completed') { ?>
														<div class="status-active"><?php echo $result_datos_capa['Status']; ?></div>
													<?php } else { ?>

														<div class="status-danger"><?php echo $result_datos_capa['Status']; ?></div>
													<?php } ?>

												</td>
												<!--end::Coordinator-->
												<!--begin::Action=-->
												<td class="text-end">
													<a href="/audit_finding_capa_view_list_view.php?findings_capa=<?php echo $Id_Audit_Management_Findings_Capaa; ?>"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i></a>
							</div>
							<a href="/audit_finding_capa_view_list_update.php?findings_capa=<?php echo $Id_Audit_Management_Findings_Capaa; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
							<?php if ($result_datos_meeting['Status'] == 'Schedule') { ?>
								<a href="/meeting_delete.php?pg_id=<?php echo $id_meeting; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
							<?php } ?>
							</td>
							<!--end::Action=-->

							</tr>


							</tbody>
						<?php } ?>
						<!--end::Table body-->
						</table>
						<!--end::Table-->
						</div>
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

	<!-- -->
	<!-- -->

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
</body>
<!--end::Body-->

</html>