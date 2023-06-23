<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Customer List";
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
						<p><a href="/">Home</a> » <a href="/customer.php">Customer Complaints</a> » <?php echo $_SESSION['Page_Title']; ?></p>
						<!-- MIGAS DE PAN -->
					</div>

					<div class="col-lg-6">
						<div class="d-flex justify-content-end">
							<a href="/customer_add_complaint.php">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									New customer complaint
								</button>
							</a>
							<a href="/customer.php">
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
							<div class="card-body pt-0 table-responsive">
								<!--begin::Table-->
								<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-muted text-uppercase gs-0">
											<th class="min-w-50px">Unique ID</th>
											<th class="min-w-50px">Created by</th>
											<th class="min-w-50px">Customer name</th>
											<th class="min-w-50px">Order RefNo</th>
											<th class="min-w-50px">Department</th>
											<th class="min-w-50px">Owner</th>
											<th class="min-w-50px">Status</th>
											<th class="text-end min-w-50px">Action</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody class="text-gray-600 fw-bold">
										<tr>
											<!--begin::Unique ID-->
											<td>50</td>
											<!--end::Unique ID-->
											<!--begin::Created by=-->
											<td>
												Pepe
											</td>
											<!--end::Created by=-->
											<!--begin::Customer name-->
											<td>
												Manolo
											</td>
											<!--end::Customer name-->
											<!--begin::Order RefNo-->
											<td>B11464</td>
											<!--end::Order RefNo-->
											<!--begin::Department-->
											<td>Departamento tecnico</td>
											<!--end::Department-->
											<!--begin::Owner-->
											<td>
												Propietario
											</td>
											<!--end::Owner-->
											<!--begin::Status-->
											<td>
												Approved
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

	<!-- START AUDIT CHARTS -->
	<!-- ON LOAD EVENT TO DISPLAY CORRECTLY SIZED CHARTS -->
	<script type="text/javascript">
		/**
		 * Why a TimeOut: 
		 * Charts get wrongly displayed if they autoload by cache.
		 * With this timeout, they load with the correct style, and hide inmediatly after.
		 * TLDR: DONT DELETE THE TIMEOUT.
		 * */
		function loadCharts() {
			const myTimeout = setTimeout(ApplyloadCharts, 500);
		}

		function ApplyloadCharts() {
			var above = document.getElementById("box-above");
			above.style.display = "none";
		}
	</script>
	<!-- Toggle before/after 15 -->
	<script type="text/javascript">
		function toggle_before() {
			var before = document.getElementById("box-before");
			var above = document.getElementById("box-above");
			before.style.display = "block";
			above.style.display = "none";
		}

		function toggle_after() {
			var before = document.getElementById("box-before");
			var above = document.getElementById("box-above");
			before.style.display = "none";
			above.style.display = "block";
		}
	</script>

	<!-- FIRST CHART -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		google.charts.load('current', {
			'packages': ['bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Department', 'Open', 'Closed'],
				['Strategy', 3, 7],
				['Custommer', 8, 5],
				['NCR', 11, 12],
				['Quality', 8, 9]
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

	<!-- SECOND CHART A -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		google.charts.load('current', {
			'packages': ['bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Department', 'Open', 'Closed'],
				['Strategy', 1, 3],
				['Custommer', 4, 7],
				['NCR', 6, 0],
				['Quality', 5, 4]
			]);

			var options = {
				chart: {
					title: '0-15',
					subtitle: '',
				}
			};

			var chart = new google.charts.Bar(document.getElementById('second_chart_column-a'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		}
	</script>
	<!-- SECOND CHART B -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		google.charts.load('current', {
			'packages': ['bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Department', 'Open', 'Closed'],
				['Strategy', 9, 8],
				['Custommer', 2, 7],
				['NCR', 1, 4],
				['Quality', 10, 7]
			]);

			var options = {
				chart: {
					title: 'Above 15',
					subtitle: '',
				}
			};

			var chart = new google.charts.Bar(document.getElementById('second_chart_column-b'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		}
	</script>

	<!-- THIRD CHART -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		google.charts.load('current', {
			'packages': ['bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Department', 'Open', 'Closed'],
				['Strategy', 8, 6],
				['Custommer', 5, 3],
				['NCR', 2, 7],
				['Quality', 9, 4]
			]);

			var options = {
				chart: {
					title: '',
					subtitle: '',
				}
			};

			var chart = new google.charts.Bar(document.getElementById('third_chart_column'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		}
	</script>

	<!-- FOUR CHART -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		google.charts.load('current', {
			'packages': ['bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Department', 'Open', 'Closed'],
				['Strategy', 1, 5],
				['Custommer', 9, 7],
				['NCR', 6, 4],
				['Quality', 8, 3]
			]);

			var options = {
				chart: {
					title: '',
					subtitle: '',
				}
			};

			var chart = new google.charts.Bar(document.getElementById('four_chart_column'));

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