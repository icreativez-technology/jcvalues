<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Customer Complaints";
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
							<p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
								<!-- MIGAS DE PAN -->
						</div>

						<div class="col-lg-6">
							<div class="d-flex justify-content-end">
								<a href="/customer_add_complaint.php">
												<button type="button" class="btn btn-light-primary me-3 topbottons">
													New customer complaint
												</button>
											</a>
											<a href="/customer_view_list.php">
												<button type="button" class="btn btn-light-primary me-3 topbottons">
													<i class="bi bi-list-ul"></i> View List
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

							   <div class="col-lg-1">
							   	<label class="filterlabel-j6">From:</label>
							    <input type="date" class="form-control" placeholder="From" name="from-date"/>
							   </div>

							   <div class="col-lg-1">
							    <label class="filterlabel-j6">To:</label>
							    <input type="date" class="form-control" placeholder="From" name="to-date"/>
							   </div>

							   <div class="col-lg-2">
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

							   <div class="col-lg-2">
							   	<label class="filterlabel-j6">Department:</label>
							    <select class="form-control" name="department">
									<option value="">Select</option>
									<option>Department 1</option>
									<option>Department 2</option>
									<option>Department 3</option>
									<option>Department 4</option>
								</select>
							   </div>

							   <div class="col-lg-2">
							   	<label class="filterlabel-j6">Nature of Complains:</label>
							    <select class="form-control" name="nature_of_complains">
									<option value="">Select</option>
									<option>NoC 1</option>
									<option>NoC 2</option>
									<option>NoC 3</option>
									<option>NoC 4</option>
								</select>
							   </div>
							   <div class="col-lg-2">
							   	<label class="filterlabel-j6">Action Category:</label>
							    <select class="form-control" name="action_category">
									<option value="">Select</option>
									<option>AC 1</option>
									<option>AC 2</option>
									<option>AC 3</option>
									<option>AC 4</option>
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
												<span class="card-label fw-bolder fs-3 mb-1">Month Wise</span>
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
												<span class="card-label fw-bolder fs-3 mb-1">Aging (Days)</span>
											</h3>
											<!--begin::Toolbar-->
											<div class="card-toolbar" data-kt-buttons="true">
												<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="before_15" onclick="toggle_before()">0-15</a>
												<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="above_15" onclick="toggle_after()">Above 15</a>
											</div>
											<!--end::Toolbar-->
										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body">
											<!--begin::Chart-->
											<div id="box-before">
												<div id="second_chart_column-a" class="donut-chart-j6"></div>
											</div>
											<div id="box-above">
												<div id="second_chart_column-b" class="donut-chart-j6"></div>
											</div>
											<!--end::Chart-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Charts Widget 3-->
								</div>
							</div>
							<!--end::Row-->
							<!--begin::Row-->
							<div class="row g-5 g-xl-8" style="padding: 20px 0 0 !important;">
								<div class="col-xl-6">
									<!--begin::Charts Widget 3-->
									<div class="card card-xl-stretch mb-xl-8">
										<!--begin::Header-->
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Nature of Complaints</span>
											</h3>
											
										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body">
											<!--begin::Chart-->
											<div id="box-internal-column_fin">
												<div id="third_chart_column" class="donut-chart-j6"></div>
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
												<span class="card-label fw-bolder fs-3 mb-1">Action Category</span>
											</h3>
											
										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body">
											<!--begin::Chart-->
											<div id="box-internal-column_fin">
												<div id="four_chart_column" class="donut-chart-j6"></div>
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
				    function loadCharts()
				    {
					 const myTimeout = setTimeout(ApplyloadCharts, 500);
				    }
				    function ApplyloadCharts()
				    {
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
			      google.charts.load('current', {'packages':['bar']});
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
			      google.charts.load('current', {'packages':['bar']});
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
			      google.charts.load('current', {'packages':['bar']});
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
			      google.charts.load('current', {'packages':['bar']});
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
			      google.charts.load('current', {'packages':['bar']});
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

		<script>var hostUrl = "assets/";</script>
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