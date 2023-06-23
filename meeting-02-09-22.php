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
							    <input type="date" class="form-control" id="fromdata" name="fromdate" required/>
							   </div>

							   <div class="col-lg-3">
							    <label class="filterlabel-j6">To:</label>
							    <input type="date" class="form-control" id="todata" name="todate" required/>
							   </div>
							   <?php 
							   	$consulta_filter_general_category ="SELECT * FROM Meeting_Category";
							   	$consulta_general_category = mysqli_query($con, $consulta_filter_general_category);
								
							   ?>
							   <div class="col-lg-6">
							   	<label class="filterlabel-j6">Category:</label>
							    <select class="form-control" name="category" required>
							    	<?php while($result_filter_category = mysqli_fetch_assoc($consulta_general_category)){ 

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
								<div class="col-xl-9">
									<div id="calendar"></div>
								</div>
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

											<div class="legend-box"><span class="badge badge-light-success">Completed</span> <span class="badge badge-light-warning">Schedule</span></div>

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
									<div id="calendar"></div>
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

											<div class="legend-box"><span class="badge badge-light-success">Completed</span> <span class="badge badge-light-warning">Schedule</span></div>

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
		function enviar_ajax(){	

			$.ajax({
			type: 'POST',
			url: 'includes/filter_meeting.php',
			data: $('#form1').serialize(),
			})
			.done(function(resultado){
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

			$consulta_filter_general ="SELECT * FROM Meeting_Category";
			$consulta_category = mysqli_query($con, $consulta_filter_general);
			 //print_r($_POST);
			//Filter general
			
				//$category = array();
				while($result_datos_category = mysqli_fetch_assoc($consulta_category)){

					$id_category = $result_datos_category['Id_meeting_category'];

					// Filtro por Completed
					$consulta_count_category_completed="SELECT COUNT(*) as completed FROM Meeting WHERE Id_category = $id_category AND status LIKE 'Completed' AND Start_Date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_category_completed = mysqli_query($con, $consulta_count_category_completed);
					$count_result_completed = mysqli_fetch_assoc($result_count_category_completed);

					// Filtro por Schedule
					$consulta_count_category_schedule="SELECT COUNT(*) as Schedule FROM Meeting WHERE Id_category = $id_category AND status LIKE 'Schedule' AND Start_Date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_category_schedule = mysqli_query($con, $consulta_count_category_schedule);
					$count_result_schedule = mysqli_fetch_assoc($result_count_category_schedule);

					// Filtro por Delay
					$consulta_count_category_delay="SELECT COUNT(*) as delay FROM Meeting WHERE Id_category = $id_category AND status LIKE 'Delay' AND Start_Date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_category_delay = mysqli_query($con, $consulta_count_category_delay);
					$count_result_delay = mysqli_fetch_assoc($result_count_category_delay);

					
					$initial = strlen($result_datos_category['Title']);
					
					if($initial > 8){
					$category_name = substr($result_datos_category['Title'],0,8).'.';
					}else{
						$category_name = $result_datos_category['Title'];
					}


					//mostrar datos al chart
					$category[] = "['".$category_name."', ".$count_result_completed['completed'].",".$count_result_schedule['Schedule']."],";

				}
			
		?>
				<script type="text/javascript">

			      google.charts.load('current', {packages: ['corechart', 'bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			        	['', 'Completed', 'Schedule'],	
			        	<?php foreach ($category as $category) { echo $category; } ?>
			        ]);
			         var view = new google.visualization.DataView(data);
      
			        var options = {
			          legend: {position: 'none', maxLines: 3},
			          colors: ['#00d9d9', '#ffc700'],
			          bars: 'horizontal' // Required for Material Bar Charts.
			        };

			        var chart = new google.charts.Bar(document.getElementById('first_chart_column'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));

			      }

				    
			    </script>

		<!-- SECOND CHART -->
				<?php
				$mom_progress = array();
				$email_user_employee = $_SESSION['usuario'];
				$select_user_employee ="SELECT * FROM Basic_Employee WHERE Email LIKE '$email_user_employee'";

				$consulta_user_employee = mysqli_query($con, $select_user_employee);
				$result_user_employee = mysqli_fetch_assoc($consulta_user_employee);
				$Id_meeting_employee = $result_user_employee['Id_employee'];

				$select_user_coordinator ="SELECT * FROM Meeting_Co_Ordinator WHERE Id_employee = $Id_meeting_employee";

				

				// Filtro por Completed
				$consulta_count_coordinator_completed="SELECT COUNT(*) as completed FROM Meeting_Agenda WHERE Id_meeting_co_ordinator = $Id_meeting_employee AND status LIKE 'Completed' AND Whenm BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

				$result_count_coordinator_completed = mysqli_query($con, $consulta_count_coordinator_completed);
				$count_result_coordinator_completed = mysqli_fetch_assoc($result_count_coordinator_completed);

				// Filtro por Schedule
				$consulta_count_coordinator_schedule="SELECT COUNT(*) as schedule FROM Meeting_Agenda WHERE Id_meeting_co_ordinator = $Id_meeting_employee AND status LIKE 'Schedule' AND Whenm BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

				$result_count_coordinator_schedule = mysqli_query($con, $consulta_count_coordinator_schedule);
				$count_result_coordinator_schedule = mysqli_fetch_assoc($result_count_coordinator_schedule);

				$mom_progress[] = "['".$email_user_employee."', ".$count_result_coordinator_completed['completed'].",".$count_result_coordinator_schedule['schedule']."],";
				
				?>

				<script type="text/javascript">
			      google.charts.load('current', {packages: ['corechart', 'bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['', 'Completed', 'Schedule'],
			          <?php foreach ($mom_progress as $mom_progress) { echo $mom_progress; } ?>
			        ]);

			        var options = {
			          legend: {position: 'none', maxLines: 3},
			          colors: ['#00d9d9', '#ffc700'],
			          bars: 'horizontal' // Required for Material Bar Charts.
			        };

			        var chart = new google.charts.Bar(document.getElementById('second_chart_column'));

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