<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Customer Satisfaction";
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

						
					</div>

					<!-- End Breadcrumbs + Actions -->
					
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
						<!--begin::Container-->
						<div class="container-custom" id="kt_content_container">
                        <!-- AQUI AÑADIR EL CONTENIDO  -->

							<!-- begin:: CHARTS -->
							<!--begin::Row-->
							<div class="row g-5 g-xl-8" style="padding: 20px 0 0 !important;">
								<div class="col-xl-12">
									<!--begin::Charts Widget 3-->
									<div class="card card-xl-stretch mb-xl-8">

										<!--begin::Body-->
										<div class="card-body">
											<!--begin::Chart-->
											<div id="box-internal-column_fin">
												<div id="regions_div" class="donut-chart-j6"></div>
											</div>
											<!--end::Chart-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Charts Widget 3-->
								</div>
							</div>
							<!--end::Row-->
							<!--end::Charts Widget 3-->
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

		<!-- START MAP CHART -->

		 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		 <script type="text/javascript">
		      google.charts.load('current', {
		        'packages':['geochart'],
		      });
		      google.charts.setOnLoadCallback(drawRegionsMap);

		      function drawRegionsMap() {
		        var data = google.visualization.arrayToDataTable([
		          ['Country', 'Popularity'],
		          ['Spain', 900],
		          ['Germany', 200],
		          ['United States', 300],
		          ['Brazil', 400],
		          ['Canada', 500],
		          ['France', 600],
		          ['RU', 700]
		        ]);

		        var options = {};

		        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

		        chart.draw(data, options);
		      }
		    </script>

		 <!-- END CHARTS -->
				
			   

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