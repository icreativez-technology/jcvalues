<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Focus Area";
$email = $_SESSION['usuario'];
$sql = "SELECT Id_basic_role From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$roleInfo = mysqli_fetch_assoc($fetch);
$role = $roleInfo['Id_basic_role'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>
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
				<?php include('includes/header.php'); ?>
				<!-- Breadcrumbs + Actions -->
				<div class="row breadcrumbs">
					<div class="col-lg-6">
						<p><a href="/">Home</a> » <a href="/admin-panel.php">Admin Panel</a> » <a href="/kaizen.php">Kaizen</a> » <?php echo $_SESSION['Page_Title']; ?></p>
					</div>
				</div>
				<!-- End Breadcrumbs + Actions -->
				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<!--begin::Container-->
					<div class="container-custom" id="kt_content_container">
						<!--begin::Card-->
						<div class="card">
							<!--begin::Add testing standard form-->
							<form action="includes/focus-area-add.php" method="post" enctype="multipart/form-data">
								<div class="row mt-6 ms-2">
									<div class="col-md-5">
										<div class="form-group">
											<label>Focus Area</label>
											<input type="text" class="form-control" name="title" required>
											<?php if (isset($_GET['exist'])) { ?>
												<small class="text-danger">The focus area name has already been taken</small>
											<?php } ?>
										</div>
									</div>
									<div class="col-md-2">
										<br />
										<button type="submit" class="btn btn-sm btn-success mt-3">Add</button>
									</div>
								</div>
							</form>
							<!--end::Add testing standard form-->
							<div class="row mt-2 mb-4 ms-2">
								<div class="col-md-3">
									<!--begin::Search-->
									<div class="d-flex align-items-center position-relative my-1">
										<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
										<span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
												<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Focus Area" id="termino" name="termino" />
									</div>
									<!--end::Search-->
								</div>
							</div>
							<div class="table-responsive custom-search-nz" id="result-busqueda">
							</div>
							<!--begin::Card body-->
							<div class="card-body pt-0 table-responsive">
								<!--begin::Table-->
								<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
											<th class="min-w-125px">Title</th>
											<th class="min-w-125px">Created</th>
											<th class="min-w-125px">Modified</th>
											<th class="min-w-125px">Status</th>
											<th class="text-end min-w-70px">Action</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody class="fw-bold text-gray-600">
										<?php
										$sql_data = "SELECT * FROM focus_area WHERE is_deleted = 0 order by id DESC";
										$connect_data = mysqli_query($con, $sql_data);
										/*PAGINACION*/
										$pagination_ok = 1;
										/*PAGINACION*/
										/*Numero total de registros*/
										$num_rows = mysqli_num_rows($connect_data);
										/*contador*/
										$page_register_count = 0;
										/*max. registros per pagina*/
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
										while ($result_data = mysqli_fetch_assoc($connect_data)) {
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
										?>
											<tr>
												<td>
													<?php echo $result_data['title']; ?>
												</td>
												<td>
													<?php echo date("d-m-y", strtotime($result_data['created_at'])); ?>
												</td>
												<td>
													<?php echo $result_data['updated_at'] != null ? date("d-m-y", strtotime($result_data['updated_at'])) : ''; ?>
												</td>
												<?php if ($result_data['status'] == "1") { ?>
													<td>
														<a href="/includes/focus-area-status.php?id=<?php echo $result_data['id']; ?>">
															<div class="badge badge-light-success">Active</div>
														</a>
													</td>
												<?php } else { ?>
													<td>
														<a href="/includes/focus-area-status.php?id=<?php echo $result_data['id']; ?>">
															<div class="badge badge-light-danger">Suspended</div>
														</a>
													</td>
												<?php } ?>
												<td class="text-end">
													<a href="/focus-area-edit.php?id=<?php echo $result_data['id']; ?>" class="me-2"><i class="bi bi-pencil"></i></a>
													<?php if (true) { ?>
														<a href="/includes/focus-area-delete.php?id=<?php echo $result_data['id']; ?>"><i class="bi bi-trash"></i></a>
													<?php } ?>
												</td>
											</tr>
										<?php
										}
										?>
									</tbody>
									<!--end::Table body-->
								</table>
								<!--end::Table-->
								<!--start:: PAGINATION-->
								<ul class="pagination pagination-circle pagination-outline">
									<?php
									/*PAGINACION*/
									if ($pagination_ok == 1) {
										$num_pages = $num_rows / $max_registers_page;
										$total_pages = ceil($num_pages);
										//echo '<h2>'.$total_pages.'</h2>';
										for ($actual_page = 1; $actual_page <= $total_pages; $actual_page++) {
									?>
											<?php
											if (!$_REQUEST['page']) {
												$_REQUEST['page'] = 1;
											}
											if ($_REQUEST['page'] == $actual_page) {
											?>
												<li class="page-item m-1 active"><a href="/focus-area.php?page=<?php echo $actual_page; ?>" class="page-link"><?php echo $actual_page; ?></a></li>
											<?php } else { ?>
												<li class="page-item m-1"><a href="/focus-area.php?page=<?php echo $actual_page; ?>" class="page-link"><?php echo $actual_page; ?></a></li>
											<?php } ?>
									<?php
										}
									} ?>
								</ul>
								<!--end:: PAGINATION-->
							</div>
							<!--end::Card body-->
						</div>
						<!--end::Card-->
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
	<!-- BUSCADOR SEARCH PARA: Department -->
	<script src="JS/buscar-focus-area.js"></script>
	<!-- FIN BUSCADOR SEARCH JS -->
	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>