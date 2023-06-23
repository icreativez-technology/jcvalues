<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Asset";
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
						<p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
						<!-- MIGAS DE PAN -->
					</div>

					<div class="col-lg-6">
						<div class="d-flex justify-content-end">
							<a href="/asset_add_new.php">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									New Asset
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

						<!--begin::FILTROS-->
						<div class="content d-flex flex-column flex-column-fluid filtros-audit" style="padding: 0;">
							<!--begin::Container-->
							<div class="container-full">
								<form class="form">
									<div class="card-body">
										<div class="form-group row mt-3">

											<div class="col-lg-2">
												<label class="filterlabel-j6">From:</label>
												<input type="date" class="form-control" placeholder="From" name="from-date" />
											</div>

											<div class="col-lg-2">
												<label class="filterlabel-j6">To:</label>
												<input type="date" class="form-control" placeholder="From" name="to-date" />
											</div>

											<div class="col-lg-3">
												<label class="filterlabel-j6">Plant:</label>
												<select class="form-control" name="plant">
													<option value="">Select</option>
													<option>Plant 1</option>
													<option>Plant 2</option>
													<option>Plant 3</option>
													<option>Plant 4</option>
												</select>
											</div>

											<div class="col-lg-2">
												<label class="filterlabel-j6">Product Group:</label>
												<select class="form-control" name="PG">
													<option value="">Select</option>
													<option>PG 1</option>
													<option>PG 2</option>
													<option>PG 3</option>
													<option>PG 4</option>
												</select>
											</div>

											<div class="col-lg-3">
												<label class="filterlabel-j6">Department:</label>
												<select class="form-control" name="department">
													<option value="">Select</option>
													<option>Department 1</option>
													<option>Department 2</option>
													<option>Department 3</option>
													<option>Department 4</option>
												</select>
											</div>
										</div>
										<div class="form-group row mt-3">
											<button class="fullbutton">Apply Filter</button>
										</div>
									</div>


								</form>
							</div>
						</div>
						<!--end::FILTROS-->


						<!-- begin:: CHARTS -->
						<!--begin::Row-->
						<div class="row g-5 g-xl-8" style="padding: 20px 0 0 !important;">
							<div class="col-xl-6">
								<!--begin::Charts Widget 3-->
								<div class="card card-xl-stretch mb-xl-8">
									<!--begin::Header-->
									<div class="card-header border-0 pt-5">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bolder fs-3 mb-1">Product Group Wise</span>
										</h3>

									</div>
									<!--end::Header-->
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Chart-->
										<div id="box-internal-column_fin">
											<div id="first_chart_column" class="donut-chart-j6"></div>
										</div>
										<!--end::Chart-->
									</div>
									<!--end::Body-->
								</div>
								<!--end::Charts Widget 3-->
							</div>
							<div class="col-xl-6">
								<!--begin::Charts Widget 3-->
								<div class="card card-xl-stretch mb-xl-8">
									<!--begin::Header-->
									<div class="card-header border-0 pt-5">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bolder fs-3 mb-1">Month Wise</span>
										</h3>

									</div>
									<!--end::Header-->
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Chart-->
										<div id="box-internal-column_fin">
											<div id="second_chart_column" class="donut-chart-j6"></div>
										</div>
										<!--end::Chart-->
									</div>
									<!--end::Body-->
								</div>
								<!--end::Charts Widget 3-->
							</div>
						</div>
						<!--end::Row-->
						<!-- end:: CHARTS -->

						<!--begin::LISTADO-->
						<!--begin::Card body-->
						<div class="container-custom card">
							<div class="card-body pt-0 table-responsive">
								<!--begin::Table-->
								<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-muted text-uppercase gs-0">
											<th class="min-w-25px">Asset ID</th>
											<th class="min-w-50px">Name</th>
											<th class="min-w-50px">Usage Location</th>
											<th class="min-w-50px">Calibration done on</th>
											<th class="min-w-50px">Calibration due on</th>
											<th class="min-w-50px">Status</th>
											<th class="text-end min-w-50px">Action</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody class="text-gray-600 fw-bold">
										<tr>
											<!--begin::Asset ID-->
											<td>AS-1D</td>
											<!--end::Asset ID-->
											<!--begin::Name=-->
											<td>
												Valvula A20
											</td>
											<!--end::Name=-->
											<!--begin::Usage Location-->
											<td>
												Maquinaria
											</td>
											<!--end::Usage Location-->
											<!--begin::Calibration done on-->
											<td>20/03/2022</td>
											<!--end::Calibration done on-->
											<!--begin::Calibration due on-->
											<td>20/03/2023</td>
											<!--end::Calibration due on-->
											<!--begin::Status-->
											<td>
												Done
											</td>
											<!--end::Status-->
											<!--begin::Action=-->
											<td class="text-end">
												<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
														<a href="#" class="menu-link px-3"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i>View</a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="#" class="menu-link px-3"><i class="bi bi-pencil" style="padding-right: 4px;"></i>Edit</a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="#" class="menu-link px-3"><i class="bi bi-trash" style="padding-right: 4px;"></i>Delete</a>
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
	<!-- CHARTS -->

	<!-- FIRST CHART -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		google.charts.load('current', {
			'packages': ['bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Department', 'Test', 'Test2', 'Test3'],
				['Strategy', 5, 7, 6],
				['Custommer', 2, 5, 8],
				['NCR', 4, 4, 2],
				['Quality', 8, 3, 5]
			]);

			var options = {
				chart: {
					title: '',
					subtitle: '',
				}
			};

			var chart = new google.charts.Bar(document.getElementById('first_chart_column'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		}
	</script>

	<!-- SECOND CHART -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		google.charts.load('current', {
			'packages': ['bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Department', 'Test', 'Test2', 'Test3'],
				['Strategy', 5, 7, 6],
				['Custommer', 2, 5, 8],
				['NCR', 4, 4, 2],
				['Quality', 8, 3, 5]
			]);

			var options = {
				chart: {
					title: '',
					subtitle: '',
				}
			};

			var chart = new google.charts.Bar(document.getElementById('second_chart_column'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		}
	</script>



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