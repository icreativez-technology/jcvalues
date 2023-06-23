<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Meetings";

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
							<a href="/meeting_add_new.php">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									New Meeting
								</button>
							</a>
							<a href="/meeting_view_list.php">
								<button type="button" class="btn btn-light-primary me-3 topbottons">
									View List
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
								<form class="form" onsubmit="enviar_ajax(); return false" id="form1">
									<div class="card-body">
										<div class="form-group row mt-3">

											<div class="col-lg-3">
												<label class="filterlabel-j6">From:</label>
												<input type="date" class="form-control" id="fromdata" name="fromdate" required />
											</div>

											<div class="col-lg-3">
												<label class="filterlabel-j6">To:</label>
												<input type="date" class="form-control" id="todata" name="todate" required />
											</div>
											<?php
											$consulta_filter_general_category = "SELECT * FROM Meeting_Category";
											$consulta_general_category = mysqli_query($con, $consulta_filter_general_category);

											?>
											<div class="col-lg-6">
												<label class="filterlabel-j6">Category:</label>
												<select class="form-control" name="category" required>
													<?php while ($result_filter_category = mysqli_fetch_assoc($consulta_general_category)) {

														$id_filter_category = $result_filter_category['Id_meeting_category'];
														$name_category = $result_filter_category['Title'];
													?>
														<option value="<?php echo $id_filter_category; ?>"><?php echo $name_category; ?></option>

													<?php } ?>

												</select>
											</div>
										</div>
										<div class="form-group row mt-3 filterbott">
											<input type="submit" value="Apply Filter"><input type="reset" value="Reset Filter" onClick="window.location.href=window.location.href">
										</div>
										<!--<div id="meeting_resultados"></div>-->
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
											<span class="card-label fw-bolder fs-3 mb-1">Meeting Category</span>
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
											<span class="card-label fw-bolder fs-3 mb-1">MoM Progress</span>
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
											<th class="min-w-50px">Meeting id</th>
											<th class="min-w-50px">Title</th>
											<th class="min-w-50px">Category</th>
											<th class="min-w-50px">Meeting Date</th>
											<th class="min-w-50px">Meeting Time</th>
											<th class="min-w-50px">Venue</th>
											<th class="min-w-50px">Coordinator</th>
											<th class="min-w-50px">Status</th>
											<th class="text-end min-w-50px">Action</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<?php
									$sql_datos_meeting = "SELECT * From Meeting WHERE Start_Date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";
									$conect_datos_meeting = mysqli_query($con, $sql_datos_meeting);

									while ($result_datos_meeting = mysqli_fetch_assoc($conect_datos_meeting)) {
										$id_meeting = $result_datos_meeting['Id_meeting'];
									?>

										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold" id="list_result">
											<tr>
												<!--begin::S No-->
												<td><?php echo $result_datos_meeting['Custom_Id']; ?></td>
												<!--end::S No-->
												<!--begin::Meeting Date=-->
												<td>
													<?php echo $result_datos_meeting['Title']; ?>
												</td>
												<!--begin::Category-->
												<td>
													<?php
													$id_cat = $result_datos_meeting['Id_category'];
													$consulta_id_category = "SELECT * FROM Meeting_Category WHERE Id_meeting_category = $id_cat";
													$consulta_category_name = mysqli_query($con, $consulta_id_category);
													$result_category_name = mysqli_fetch_assoc($consulta_category_name);
													echo $result_category_name['Title'];

													?>

												</td>
												<!--end::Category-->
												<td>
													<?php echo date("d-m-y", strtotime($result_datos_meeting['Start_Date'])); ?>
												</td>
												<!--end::Meeting Date=-->
												<!-- Meeting time -->
												<td>
													<?php echo $result_datos_meeting['Start_Time']; ?>
												</td>
												<!--end::Meeting Date=-->
												<!--begin::Title-->
												<td>

													<?php

													$id_venue = $result_datos_meeting['Id_venue'];
													$consulta_id_venue = "SELECT * FROM Meeting_Venue WHERE Id_meeting_venue = $id_venue";
													$consulta_venue_name = mysqli_query($con, $consulta_id_venue);
													$result_venue_name = mysqli_fetch_assoc($consulta_venue_name);
													echo $result_venue_name['Title'];
													?>
												</td>
												<!--end::Title-->

												<!--begin::Department-->
												<td>
													<?php
													$Id_meeting_co_ordinator = $result_datos_meeting['Coordinator'];

													$consulta_meeting_who = "SELECT * From Meeting_Co_Ordinator as mc CROSS JOIN Basic_Employee as be WHERE mc.Id_employee = be.Id_employee AND mc.Id_meeting_co_ordinator = $Id_meeting_co_ordinator";

													$conect_datos_meeting_who = mysqli_query($con, $consulta_meeting_who);

													$result_datos_meeting_who = mysqli_fetch_assoc($conect_datos_meeting_who);

													?>
													<?php echo $result_datos_meeting_who['First_Name'] . ' ' . $result_datos_meeting_who['Last_Name']; ?>


												</td>
												<!--end::Department-->
												<!--begin::Coordinator-->
												<td>
													<?php if ($result_datos_meeting['Status'] == 'Completed') { ?>
														<div class="badge badge-light-success"><?php echo $result_datos_meeting['Status']; ?></div>
													<?php } else { ?>

														<div class="badge badge-light-warning"><?php echo $result_datos_meeting['Status']; ?></div>
													<?php } ?>

												</td>
												<!--end::Coordinator-->
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
															<a href="/meeting_view.php?<?php echo $id_meeting; ?>" class="menu-link px-3"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i>View</a>
														</div>
														<!--end::Menu item-->

														<!--begin::Menu item-->
														<div class="menu-item px-3">

															<a href="/meeting_update.php?<?php echo $id_meeting; ?>" class="menu-link px-3"><i class="bi bi-pencil" style="padding-right: 4px;"></i>Edit</a>

														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<?php if ($result_datos_meeting['Status'] == 'Schedule') { ?>
															<div class="menu-item px-3">
																<a href="/meeting_delete.php?pg_id=<?php echo $id_meeting; ?>" class="menu-link px-3"><i class="bi bi-trash" style="padding-right: 4px;"></i>Delete</a>
															</div>
														<?php } ?>
														<!--end::Menu item-->
													</div>
													<!--end::Menu-->
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
	<script>
		function enviar_ajax() {

			$.ajax({
					type: 'POST',
					url: 'includes/filter_meeting.php',
					data: $('#form1').serialize(),
				})
				.done(function(resultado) {
					$("#first_chart_column").html(resultado);

				});
		}
	</script>
	<!-- -->
	<!-- CHARTS -->

	<!-- FIRST CHART -->
	<?php
	//Campos generales

	$category = array();

	$consulta_filter_general = "SELECT * FROM Meeting_Category";
	$consulta_category = mysqli_query($con, $consulta_filter_general);
	//print_r($_POST);
	//Filter general

	//$category = array();
	while ($result_datos_category = mysqli_fetch_assoc($consulta_category)) {

		$id_category = $result_datos_category['Id_meeting_category'];

		// Filtro por Completed
		$consulta_count_category_completed = "SELECT COUNT(*) as completed FROM Meeting WHERE Id_category = $id_category AND status LIKE 'Completed' AND Start_Date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

		$result_count_category_completed = mysqli_query($con, $consulta_count_category_completed);
		$count_result_completed = mysqli_fetch_assoc($result_count_category_completed);

		// Filtro por Schedule
		$consulta_count_category_schedule = "SELECT COUNT(*) as Schedule FROM Meeting WHERE Id_category = $id_category AND status LIKE 'Schedule' AND Start_Date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

		$result_count_category_schedule = mysqli_query($con, $consulta_count_category_schedule);
		$count_result_schedule = mysqli_fetch_assoc($result_count_category_schedule);

		// Filtro por Delay
		$consulta_count_category_delay = "SELECT COUNT(*) as delay FROM Meeting WHERE Id_category = $id_category AND status LIKE 'Delay' AND Start_Date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

		$result_count_category_delay = mysqli_query($con, $consulta_count_category_delay);
		$count_result_delay = mysqli_fetch_assoc($result_count_category_delay);

		//mostrar datos al chart
		$category[] = "['" . $result_datos_category['Title'] . "', " . $count_result_completed['completed'] . "," . $count_result_schedule['Schedule'] . ",' color: #b87333'],";
	}

	?>
	<script type="text/javascript">
		google.charts.load('current', {
			packages: ['corechart', 'bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Department', 'Completed', 'Schedule', {
					role: 'style'
				}],
				<?php foreach ($category as $category) {
					echo $category;
				} ?>
			]);
			var view = new google.visualization.DataView(data);

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
	<?php
	$mom_progress = array();
	$email_user_employee = $_SESSION['usuario'];
	$select_user_employee = "SELECT * FROM Basic_Employee WHERE Email LIKE '$email_user_employee'";

	$consulta_user_employee = mysqli_query($con, $select_user_employee);
	$result_user_employee = mysqli_fetch_assoc($consulta_user_employee);
	$Id_meeting_employee = $result_user_employee['Id_employee'];

	$select_user_coordinator = "SELECT * FROM Meeting_Co_Ordinator WHERE Id_employee = $Id_meeting_employee";

	$consulta_user_coordinator = mysqli_query($con, $select_user_coordinator);
	$result_user_coordinator = mysqli_fetch_assoc($consulta_user_coordinator);
	$Id_meeting_co_ordinator = $result_user_coordinator['Id_meeting_co_ordinator'];


	// Filtro por Completed
	$consulta_count_coordinator_completed = "SELECT COUNT(*) as completed FROM Meeting_Agenda WHERE Id_meeting_co_ordinator = $Id_meeting_co_ordinator AND status LIKE 'Completed' AND Whenm BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

	$result_count_coordinator_completed = mysqli_query($con, $consulta_count_coordinator_completed);
	$count_result_coordinator_completed = mysqli_fetch_assoc($result_count_coordinator_completed);

	// Filtro por Schedule
	$consulta_count_coordinator_schedule = "SELECT COUNT(*) as open FROM Meeting_Agenda WHERE Id_meeting_co_ordinator = $Id_meeting_co_ordinator AND status LIKE 'Open' AND Whenm BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

	$result_count_coordinator_schedule = mysqli_query($con, $consulta_count_coordinator_schedule);
	$count_result_coordinator_schedule = mysqli_fetch_assoc($result_count_coordinator_schedule);

	$mom_progress[] = "['" . $email_user_employee . "', " . $count_result_coordinator_completed['completed'] . "," . $count_result_coordinator_schedule['open'] . "],";

	?>

	<script type="text/javascript">
		google.charts.load('current', {
			packages: ['corechart', 'bar']
		});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['User', 'Completed', 'Open'],
				<?php foreach ($mom_progress as $mom_progress) {
					echo $mom_progress;
				} ?>
			]);

			var options = {
				chart: {
					title: '',
					subtitle: '',
					colors: ['red', 'green']
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