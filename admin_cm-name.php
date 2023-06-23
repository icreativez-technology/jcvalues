<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Customer Name";
$email = $_SESSION['usuario'];
$sql = "SELECT Id_basic_role From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$roleInfo = mysqli_fetch_assoc($fetch);
$role = $roleInfo['Id_basic_role'];
$page = 1;

if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}

$max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 10;


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
				<!-- Includes Top bar and Responsive Menu -->
				<!-- Breadcrumbs + Actions -->

				<div class="row breadcrumbs">
					<div class="col-lg-6">
						<p><a href="/">Home</a> » <a href="/admin-panel.php">Admin Panel</a> » <a href="/admin_cm-panel.php">Customer Management Basic Settings</a> »
							<?php echo $_SESSION['Page_Title']; ?></p>
						<!-- MIGAS DE PAN -->
					</div>


				</div>

				<!-- End Breadcrumbs + Actions -->

				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<!--begin::Container-->
					<div class="container-custom" id="kt_content_container">



						<!-- AQUI AÑADIR EL CONTENIDO  -->


						<!--begin::Card-->
						<div class="card">
							<!--begin::Card header-->

							<!--Add form-->
							<form action="includes/basicsettings_cm-name_add.php" method="post" enctype="multipart/form-data">
								<div class="row mt-6 ms-2">
									<div class="col-md-5">
										<div class="form-group">
											<label>Customer:</label>
											<input type="text" class="form-control" name="customer" required>
											<?php if (isset($_GET['exist'])) { ?>
												<small class="text-danger">The customer name has already been
													taken</small>
											<?php } ?>
										</div>
									</div>
									<div class="col-md-2">
										<br />
										<button type="submit" class="btn btn-sm btn-success mt-3">Add</button>
									</div>
								</div>
							</form>

							<div class="pt-6 ms-5 mb-5">
								<!--begin::Card title-->
								<div class="row">
									<!--begin::Search-->
									<div class="col-md-6 d-flex align-items-center position-relative my-1">
										<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
										<span class="svg-icon svg-icon-1 position-absolute ms-5 mt-3">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
												<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Customer Name" id="termino" name="termino" />
									</div>
									<!--end::Search-->

								</div>
								<!--begin::Card title-->

							</div>
							<!--end::Card header-->
							<!-- Mostrar datos del buscador -->
							<div class="table-responsive custom-search-nz" id="result-busqueda">
							</div>

							<!--begin::Card body-->
							<div class="card-body pt-0 table-responsive">
								<!--begin::Table-->
								<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-gray-400  text-uppercase gs-0">
											<th class="min-w-25px">Customer</th>
											<th class="min-w-25px">Created</th>
											<th class="min-w-25px">Modified</th>
											<th class='min-w-25px'>Status</th>
											<th class="text-end min-w-50px">Actions</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody class="fw-bold text-gray-600">
										<?php
										$sql_data = "SELECT * FROM Customer_Name";
										$connect_data = mysqli_query($con, $sql_data);

										/*PAGINACION*/
										$pagination_ok = 1;
										/*PAGINACION*/
										/*Numero total de registros*/
										$num_rows = mysqli_num_rows($connect_data);
										/*contador*/
										$page_register_count = 0;
										/*max. registros per pagina*/
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
												<!--begin::Title=-->
												<td>
													<?php echo $result_data['Customer']; ?>
												</td>
												<!--end::Title=-->

												<!--begin::Created=-->
												<td>
													<?php echo date("d-m-y", strtotime($result_data['Created'])); ?>
												</td>
												<!--end::Created=-->

												<!--begin::Modified=-->
												<td>
													<?php echo date("d-m-y", strtotime($result_data['Modified'])); ?>
												</td>
												<!--end::Modified=-->

												<!--begin::Status=-->
												<?php if ($result_data['Status'] == 'Active') { ?>
													<td><a href="/includes/basicsettings_cm-name_status.php?pg_id=<?php echo $result_data['Id_customer_name']; ?>">
															<div class="status-active">Active</div>
														</a></td>
												<?php } else { ?>
													<td><a href="/includes/basicsettings_cm-name_status.php?pg_id=<?php echo $result_data['Id_customer_name']; ?>">
															<div class="status-danger">Suspended</div>
														</a></td>
												<?php } ?>

												<!--begin::Action=-->
												<td class="text-end">
													<a href="/admin_cm-name-edit.php?pg_id=<?php echo $result_data['Id_customer_name']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
													<?php if ($role == 1) { ?>
														<a href="/admin_cm-name-delete.php?pg_id=<?php echo $result_data['Id_customer_name']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
													<?php } ?>
												</td>
												<!--end::Action=-->
											</tr>
										<?php
										}
										?>
									</tbody>
									<!--end::Table body-->
								</table>
								<!--end::Table-->
								<!--start:: PAGINATION-->
								<div class="d-flex justify-content-between">
									<div class="ms-3 pageRange">
										<select id="pageRange" name="pageRange" class="form-select">
											<option value="10" <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>10</option>
											<option value="25" <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>25</option>
											<option value="50" <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>50</option>
											<option value="100" <?php echo ($max_registers_page == 100) ? 'selected' : ''; ?>>100
											</option>
										</select>
									</div>
									<div class="me-6">
										<ul class="pagination pagination-circle pagination-outline">
											<?php
											if ($pagination_ok == 1) {
												$num_pages = $num_rows / $max_registers_page;
												$total_pages = ceil($num_pages);
												if (!$_REQUEST['page']) {
													$_REQUEST['page'] = 1;
												}
												$current_page = $_REQUEST['page'];
											}
											?>
											<input type="hidden" id="total_pages" value="<?php echo $total_pages ?>">
											<input type="hidden" id="current_page" value="<?php echo $current_page ?>">
										</ul>
									</div>
								</div>
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

	<!-- BUSCADOR SEARCH PARA: Customer Name -->
	<script src="JS/buscar-cm-name.js"></script>
	<!-- FIN BUSCADOR SEARCH JS -->

	<!--end::Page Custom Javascript-->
	<script>
		const element = document.querySelector(".pagination");
		let totalPages = Number($("#total_pages").val());
		let page = Number($("#current_page").val());

		if (totalPages > 0) {
			element.innerHTML = createPagination(totalPages, page);
		}

		function createPagination(totalPages, page) {
			let liTag = '';
			let active;
			let beforePage = page - 2;
			let afterPage = page + 2;
			let prevLabel = "<";
			let nextLabel = ">";
			let firstPage = "<<";
			let lastPage = ">>";
			liTag +=
				`<li class="page-item m-1"><a href="/admin_cm-name.php?page=${1}" class="page-link">${firstPage}</a></li>`;
			if (page > 1) {
				liTag +=
					`<li class="page-item m-1"><a href="/admin_cm-name.php?page=${page - 1}" class="page-link">${prevLabel}</a></li>`;
			}
			if (page == totalPages) {
				beforePage = beforePage - 2;
			} else if (page == totalPages - 1) {
				beforePage = beforePage - 1;
			}
			if (page == 1) {
				afterPage = afterPage + 2;
			} else if (page == 2) {
				afterPage = afterPage + 1;
			}
			beforePage = beforePage > 0 ? beforePage : 1;
			for (var plength = beforePage; plength <= afterPage; plength++) {
				if (plength > totalPages) {
					continue;
				}
				if (plength == 0) {
					plength = plength + 1;
				}
				if (page == plength) {
					active = "active";
				} else {
					active = "";
				}
				liTag +=
					`<li class="page-item m-1 ${active}"><a href="/admin_cm-name.php?page=${plength}" class="page-link">${plength}</a></li>`;
			}
			if (page < totalPages) {
				liTag +=
					`<li class="page-item m-1"><a href="/admin_cm-name.php?page=${page + 1}" class="page-link">${nextLabel}</a></li>`;
			}
			liTag +=
				`<li class="page-item m-1"><a href="/admin_cm-name.php?page=${totalPages}" class="page-link">${lastPage}</a></li>`;
			element.innerHTML = liTag;
			return liTag;
		}
	</script>
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>