<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Audit View";
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
							<p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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
													<th class="min-w-25px">S No</th>
													<th class="min-w-125px">Audit Area</th>
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
												<tr>
													<!--begin::Number-->
													<td class="hidde-responsive-j6">-</td>
													<!--end::Number-->
													<!--begin::Audit Area=-->
													<td>
														<a href="../../demo4/dist/apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
													</td>
													<!--end::Audit Area=-->
													<!--begin::Auditor-->
													<td>
														<div>Auditor</div>
													</td>
													<!--end::Auditor-->
													<!--begin::Auditee-->
													<td>Auditee</td>
													<!--end::Auditee-->
													<!--begin::Plan Date-->
													<td>Date</td>
													<!--end::Plan Date-->
													<!--begin::Status-->
													<td>
														<div class="badge badge-light-success">Active</div>
													</td>
													<!--end::Status-->
													<!--begin::Action=-->
													<td class="text-end">
														<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
															<span class="svg-icon svg-icon-5 m-0">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon--></a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i>View</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-pencil" style="padding-right: 4px;"></i>Edit</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-trash" style="padding-right: 4px;"></i>Delete</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu-->
													</td>
													<!--end::Action=-->
												</tr>
												<tr>
													<!--begin::Number-->
													<td class="hidde-responsive-j6">-</td>
													<!--end::Number-->
													<!--begin::Audit Area=-->
													<td>
														<a href="../../demo4/dist/apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Melody Macy</a>
													</td>
													<!--end::Audit Area=-->
													<!--begin::Auditor-->
													<td>
														<div>Auditor</div>
													</td>
													<!--end::Auditor-->
													<!--begin::Auditee-->
													<td>Auditee</td>
													<!--end::Auditee-->
													<!--begin::Plan Date-->
													<td>Date</td>
													<!--end::Plan Date-->
													<!--begin::Status-->
													<td>
														<div class="badge badge-light-warning">Expiring</div>
													</td>
													<!--end::Status-->
													<!--begin::Action=-->
													<td class="text-end">
														<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
															<span class="svg-icon svg-icon-5 m-0">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon--></a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i>View</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-pencil" style="padding-right: 4px;"></i>Edit</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-trash" style="padding-right: 4px;"></i>Delete</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu-->
													</td>
													<!--end::Action=-->
												</tr>
												<tr>
													<!--begin::Number-->
													<td class="hidde-responsive-j6">-</td>
													<!--end::Number-->
													<!--begin::Audit Area=-->
													<td>
														<a href="../../demo4/dist/apps/customers/view.html" class="text-gray-800 text-hover-primary mb-1">Max Smith</a>
													</td>
													<!--end::Audit Area=-->
													<!--begin::Auditor-->
													<td>
														<div>Auditor</div>
													</td>
													<!--end::Auditor-->
													<!--begin::Auditee-->
													<td>Auditee</td>
													<!--end::Auditee-->
													<!--begin::Plan Date-->
													<td>Date</td>
													<!--end::Plan Date-->
													<!--begin::Status-->
													<td>
														<div class="badge badge-light-danger">Suspended</div>
													</td>
													<!--end::Status-->
													<!--begin::Action=-->
													<td class="text-end">
														<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
															<span class="svg-icon svg-icon-5 m-0">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon--></a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i>View</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-pencil" style="padding-right: 4px;"></i>Edit</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-trash" style="padding-right: 4px;"></i>Delete</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu-->
													</td>
													<!--end::Action=-->
												</tr>

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