<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Audit";
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
								<a href="/audit_add_schedule.php">
										<button type="button" class="btn btn-light-primary me-3 topbottons">
											Schedule Audit
										</button>
								</a>
								<a href="/audit_add_finding.php">
										<button type="button" class="btn btn-light-primary me-3 topbottons">
											Add Finding
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
                        	<form class="form" id="form1" onsubmit="enviar_ajax(); return false">
							 <div class="card-body">
							  <div class="form-group row mt-3">

							   <div class="col-lg-2">
							   	<label class="filterlabel-j6">From:</label>
							    <input type="date" class="form-control" placeholder="From" name="fromdate" required/>
							   </div>

							   <div class="col-lg-2">
							    <label class="filterlabel-j6">To:</label>
							    <input type="date" class="form-control" placeholder="From" name="todate" required/>
							   </div>

							   <div class="col-lg-2">
							   	<label class="filterlabel-j6">Plant:</label>
							    <select class="form-control" name="Id_plant" required>
									<?php 
									$sql_data = "SELECT * FROM Basic_Plant";
									$connect_data = mysqli_query($con, $sql_data);
									while ($result_data = mysqli_fetch_assoc($connect_data)) {
										if($result_data['Status'] == 'Active')
										{						
										?>
											<option value="<?php echo $result_data['Id_plant']; ?>"><?php echo $result_data['Title']; ?></option>
										<?php
										}
									}
									?>
								</select>
							   </div>

							   <div class="col-lg-2">
							   	<label class="filterlabel-j6">Product Group:</label>
							    <select class="form-control" name="Id_product_group" required>
									<?php 
									$sql_data = "SELECT * FROM Basic_Product_Group";
									$connect_data = mysqli_query($con, $sql_data);
									while ($result_data = mysqli_fetch_assoc($connect_data)) {
										if($result_data['Status'] == 'Active')
										{						
										?>
											<option value="<?php echo $result_data['Id_product_group']; ?>"><?php echo $result_data['Title']; ?></option>
										<?php
										}
									}
									?>
								</select>
							   </div>

							   <div class="col-lg-2">
							   	<label class="filterlabel-j6">Department:</label>
							    <select class="form-control" name="Id_department" required>
									<?php 
									$sql_data = "SELECT * FROM Basic_Department";
									$connect_data = mysqli_query($con, $sql_data);
									while ($result_data = mysqli_fetch_assoc($connect_data)) {
									if($result_data['Status'] == 'Active')
										{						
										?>
											<option value="<?php echo $result_data['Id_department']; ?>"><?php echo $result_data['Department']; ?></option>
										<?php
										}
									}
									?>
								</select>
							   </div>

							   <div class="col-lg-2">
							   	<label class="filterlabel-j6">Audit Standard:</label>
							    <select class="form-control" name="audit_standard" required>
									<?php 
									$sql_data = "SELECT * FROM Audit_Standard";
									$connect_data = mysqli_query($con, $sql_data);
									while ($result_data = mysqli_fetch_assoc($connect_data)) {
									if($result_data['Status'] == 'Active')
										{						
										?>
											<option value="<?php echo $result_data['Id_audit_standard']; ?>"><?php echo $result_data['Title']; ?></option>
										<?php
										}
									}
									?>
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
												<span class="card-label fw-bolder fs-3 mb-1">Audit statistics</span>
											</h3>
											<!--begin::Toolbar-->
											<div class="card-toolbar" data-kt-buttons="true">
												<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="internal_st_audit" onclick="toggle_internal()">Internal</a>
												<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="external_st_audit" onclick="toggle_external()">External</a>
												<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" id="customer_st_audit" onclick="toggle_customer()">Customer</a>
											</div>
											<!--end::Toolbar-->
										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body">
											<!--begin::Chart-->
											<!--<div id="kt_charts_widget_3_chart" style="height: 350px"></div>-->
											<div id="box-internal-pie">
												<div id="donut-internal-audit" class="donut-chart-j6"></div>
												<!--<div id="internal-linechart" class="donut-chart-j6"></div>-->
											</div>
											<div id="box-external-pie">
												<div id="donut-external-audit" class="donut-chart-j6"></div>
											</div>
											<div id="box-customer-pie">
												<div id="donut-customer-audit" class="donut-chart-j6"></div>
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
												<span class="card-label fw-bolder fs-3 mb-1">Findings statistics</span>
											</h3>
											<!--begin::Toolbar-->
											<div class="card-toolbar" data-kt-buttons="true">
												<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="internal_st_audit" onclick="toggle_internal_fin()">Internal</a>
												<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="external_st_audit" onclick="toggle_external_fin()">External</a>
												<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" id="customer_st_audit" onclick="toggle_customer_fin()">Customer</a>
											</div>
											<!--end::Toolbar-->
										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body">
											<!--begin::Chart-->
											<!--<div id="kt_charts_widget_3_chart" style="height: 350px"></div>-->
											<div id="box-internal-column_fin">
												<div id="columnchart_material_internal_fin" class="donut-chart-j6"></div>
											</div>
											<div id="box-external-column_fin">
												<div id="columnchart_material_external_fin" class="donut-chart-j6"></div>
											</div>
											<div id="box-customer-column_fin">
												<div id="columnchart_material_customer_fin" class="donut-chart-j6"></div>
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

							<!--begin::CUADROS AUDIT Y FINDINGS-->
							<div class="row">
							    <div class="col-lg-6">
							        <!--begin::Card-->
							        <div class="card card-custom card-stretch">
							            <div class="card-header">
							                <div class="card-title">
							                    <h3 class="card-label">Audit</h3>
							                </div>
							            </div>
							            <div class="card-body table-responsive">
							            <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table_audit">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-muted text-uppercase gs-0">
												<th class="min-w-125px">Month</th>
												<th class="min-w-125px">Scheduled</th>
												<th class="min-w-125px">Completed</th>
												<th class="text-end min-w-70px">Actions</th>
											</tr>
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<?php
											//Audited
											$consulta_count_audit="SELECT COUNT(*) as completed FROM Audit_Management WHERE status LIKE 'Completed' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";
											$consulta_general_count_audit = mysqli_query($con, $consulta_count_audit);
											$count_result_count_audit = mysqli_fetch_assoc($consulta_general_count_audit);

											//Schedule
											$consulta_count_schedule="SELECT COUNT(*) as schedule FROM Audit_Management WHERE  status LIKE 'Schedule' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";
											$consulta_general_count_schedule = mysqli_query($con, $consulta_count_schedule);
											$count_result_count_schedule = mysqli_fetch_assoc($consulta_general_count_schedule);

											$date = date("F");
											$date_list = date("n");
											$date_year = date("Y");
										?>
										<tbody class="text-gray-600 fw-bold">
											<tr>


												<td>
													<span><?php echo $date; ?></span>
												</td>

												<td>
													<span><?php echo $count_result_count_schedule['schedule']; ?></span>
												</td>

												<td>
													<span><?php echo $count_result_count_audit['completed']; ?></span>
												</td>

												<!--begin::Action=-->
												<td class="text-end">
													
													<!--begin::Menu-->
													<a href="/audit_view.php?date_m=<?php echo $date_list?>&date_y=<?php echo $date_year?>" class="menu-link px-3"><i class="bi bi-eye-fill"></i></a>
																
													<!--end::Menu-->
												</td>
												<!--end::Action=-->
											</tr>
											</tbody>
										<!--end::Table body-->
									</table>
							            </div>
							        </div>
							        <!--end::Card-->
							    </div>
							    <div class="col-lg-6">
							        <!--begin::Card-->
							        <div class="card card-custom card-stretch">
							            <div class="card-header">
							                <div class="card-title">
							                    <h3 class="card-label">Findings</h3>
							                </div>
							            </div>
							            <div class="card-body table-responsive">
							                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-muted text-uppercase gs-0">
												<th class="min-w-125px">Month</th>
												<th class="min-w-125px">Scheduled</th>
												<th class="min-w-125px">Completed</th>
												<th class="text-end min-w-70px">Actions</th>
											</tr>
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<?php
										//Completed
											$consulta_count_audit_finding="SELECT COUNT(*) as completed FROM Audit_Management_Findings WHERE status LIKE 'Completed' AND 	Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

											$consulta_general_count_audit_finding = mysqli_query($con, $consulta_count_audit_finding);

											$count_result_count_audit_finding = mysqli_fetch_assoc($consulta_general_count_audit_finding);

										//Schedule
											$consulta_count_schedule_finding="SELECT COUNT(*) as schedule FROM Audit_Management_Findings WHERE  status LIKE 'Schedule' AND 	Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";
											$consulta_general_count_schedule_finding = mysqli_query($con, $consulta_count_schedule_finding);
											$count_result_count_schedule_finding = mysqli_fetch_assoc($consulta_general_count_schedule_finding);

										// TEST
											$consulta_count_audit_finding ="SELECT date_format(Audit_schedule_date, '%M') as Month, COUNT(*) as completed FROM Audit_Management WHERE status LIKE 'Completed' AND Audit_schedule_date BETWEEN '2022-05-01' AND '2022-07-30' group by date_format(Audit_schedule_date, '%M');";

											$consulta_general_count_audit_finding = mysqli_query($con, $consulta_count_audit_finding);

											$count_result_count_audit_finding[] = mysqli_fetch_assoc($consulta_general_count_audit_finding);

											//print_r($consulta_general_count_audit_finding);

											for($i=0; $i<count($count_result_count_audit_finding['Month']); $i++){

													echo $count_result_count_audit_finding['Month'];
											}
											
										?>
										<tbody class="text-gray-600 fw-bold" id="month">
											<tr>


												<td>
													<span><?php echo $date; ?></span>
												</td>

												<td>
													<span><?php echo $count_result_count_schedule_finding['schedule']; ?></span>
												</td>

												<td>
													<span><?php echo $count_result_count_audit_finding['completed']; ?></span>
												</td>

												<!--begin::Action=-->
												<td class="text-end">
													<!--begin::Menu-->
													
														<!--begin::Menu item-->
														<a href="/audit_findings_view.php?date_m=<?php echo $date_list?>&date_y=<?php echo $date_year?>" class="menu-link px-3"><i class="bi bi-eye-fill"></i></a>
																
														<!--end::Menu item-->
														
													<!--end::Menu-->
												</td>
												<!--end::Action=-->
											</tr>
											</tbody>
										<!--end::Table body-->
									</table>
							            </div>
							        </div>
							        <!--end::Card-->
							    </div>
							</div>
							<!--end::CUADROS AUDIT Y FINDINGS-->


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
			<!-- CUSTOM CHARTS -->

			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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
						var external = document.getElementById("box-external-pie");
						var customer = document.getElementById("box-customer-pie");
						var externalFin = document.getElementById("box-external-column_fin");
						var customerFin = document.getElementById("box-customer-column_fin");
						external.style.display = "none";
						customer.style.display = "none";
						externalFin.style.display = "none";
						customerFin.style.display = "none";
				    }

				    </script>


				<!-- Toggle internal/external/customer -->
				<script type="text/javascript">
					function toggle_internal() {
					  var internal = document.getElementById("box-internal-pie");
					  var external = document.getElementById("box-external-pie");
					  var customer = document.getElementById("box-customer-pie");
					  internal.style.display = "block";
					  external.style.display = "none";
					  customer.style.display = "none";
					  setTimeout(drawChartInternal, 10);
					}
					function toggle_external() {
					  var internal = document.getElementById("box-internal-pie");
					  var external = document.getElementById("box-external-pie");
					  var customer = document.getElementById("box-customer-pie");
					  internal.style.display = "none";
					  external.style.display = "block";
					  customer.style.display = "none";
					  setTimeout(drawChartExternal, 10);
					}
					function toggle_customer() {
					  var internal = document.getElementById("box-internal-pie");
					  var external = document.getElementById("box-external-pie");
					  var customer = document.getElementById("box-customer-pie");
					  internal.style.display = "none";
					  external.style.display = "none";
					  customer.style.display = "block";
					  setTimeout(drawChartCustomer, 10);
					}


				</script>
			
			<!-- Internal Audit Chart -->
			<!--<script type="text/javascript">
		      google.charts.load("current", {packages:["corechart"]});
		      google.charts.setOnLoadCallback(drawChart);
		      function drawChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['Department', 'Created'],
		          ['Almacen',     2],
		          ['Comercial',      5],
		          ['Calidad',  6],
		          ['Tecnico', 1],
		          ['Proyectos',    9]
		        ]);

		        var options = {
		          title: 'Internal statistics',
		          pieHole: 0.3,
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('donut-internal-audit'));
		        chart.draw(data, options);
		      }
		    </script>-->
		    <?php

		    	$audit_statics_internal = array();
		    	$audit_statics_external = array();
		    	$audit_statics_customer = array();
		    	$consulta_filter_basic_department ="SELECT * FROM Basic_Department";
				$consulta_general_basic_department = mysqli_query($con, $consulta_filter_basic_department);
				while($result_basic_department = mysqli_fetch_assoc($consulta_general_basic_department)){

					$id_basic_department = $result_basic_department['Id_department'];
					//Internal

					// Filtro por Completed
					$consulta_count_audit_statistics_internal="SELECT COUNT(*) as completed FROM Audit_Management WHERE Id_basic_department = $id_basic_department AND Id_type_of_audit = 1 AND status LIKE 'Completed' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_audit_statistics_internal = mysqli_query($con, $consulta_count_audit_statistics_internal);
					$count_result_audit_statistics_internal = mysqli_fetch_assoc($result_count_audit_statistics_internal);

					// Filtro por Schedule
					$consulta_count_category_schedule_audit_internal="SELECT COUNT(*) as schedule FROM Audit_Management WHERE Id_basic_department = $id_basic_department AND Id_type_of_audit = 1 AND status LIKE 'Schedule' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_category_schedule_audit_internal = mysqli_query($con, $consulta_count_category_schedule_audit_internal);
					$count_result_schedule_audit_internal = mysqli_fetch_assoc($result_count_category_schedule_audit_internal);

					//mostrar datos al chart
					$audit_statics_internal[] = "['".$result_basic_department['Department']."', ".$count_result_audit_statistics_internal['completed'].",".$count_result_schedule_audit_internal['schedule']."],";
					//print_r($audit_statics_internal);

					// External

					// Filtro por Completed
					$consulta_count_audit_statistics_external="SELECT COUNT(*) as completed FROM Audit_Management WHERE Id_basic_department = $id_basic_department AND Id_type_of_audit = 2 AND status LIKE 'Completed' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";
					
					$result_count_audit_statistics_external = mysqli_query($con, $consulta_count_audit_statistics_external);
					$count_result_audit_statistics_external = mysqli_fetch_assoc($result_count_audit_statistics_external);

					// Filtro por Schedule
					$consulta_count_category_schedule_audit_external="SELECT COUNT(*) as schedule FROM Audit_Management WHERE Id_basic_department = $id_basic_department AND Id_type_of_audit = 2 AND status LIKE 'Schedule' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_category_schedule_audit_external = mysqli_query($con, $consulta_count_category_schedule_audit_external);
					$count_result_schedule_audit_external = mysqli_fetch_assoc($result_count_category_schedule_audit_external);

					$audit_statics_external[] = "['".$result_basic_department['Department']."', ".$count_result_audit_statistics_external['completed'].",".$count_result_schedule_audit_external['schedule']."],";

					//Customer

					// Filtro por Completed
					$consulta_count_audit_statistics_customer="SELECT COUNT(*) as completed FROM Audit_Management WHERE Id_basic_department = $id_basic_department AND Id_type_of_audit = 3 AND status LIKE 'Completed' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";
					
					$result_count_audit_statistics_customer = mysqli_query($con, $consulta_count_audit_statistics_customer);
					$count_result_audit_statistics_customer = mysqli_fetch_assoc($result_count_audit_statistics_customer);

					// Filtro por Schedule
					$consulta_count_category_schedule_audit_customer="SELECT COUNT(*) as schedule FROM Audit_Management WHERE Id_basic_department = $id_basic_department AND Id_type_of_audit = 3 AND status LIKE 'Schedule' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_category_schedule_audit_customer = mysqli_query($con, $consulta_count_category_schedule_audit_customer);
					$count_result_schedule_audit_customer = mysqli_fetch_assoc($result_count_category_schedule_audit_customer);

					$audit_statics_customer[] = "['".$result_basic_department['Department']."', ".$count_result_audit_statistics_customer['completed'].",".$count_result_schedule_audit_customer['schedule']."],";
				}
		    ?>

		    <script type="text/javascript">
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],
			         <?php foreach ($audit_statics_internal as $audit_statics_internal) { echo $audit_statics_internal; } ?>
			        ]);

			        var options = {
			          chart: {
			            title: 'Internal statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('donut-internal-audit'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>

		    <!-- External Audit Chart -->
		    

			<script type="text/javascript">
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],
			          <?php foreach ($audit_statics_external as $audit_statics_external) { echo $audit_statics_external; } ?>
			        ]);

			        var options = {
			          chart: {
			            title: 'External statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('donut-external-audit'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>

			<!-- CUSTOMER AUDIT CHART -->

			<script type="text/javascript">
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],
			          <?php foreach ($audit_statics_customer as $audit_statics_customer) { echo $audit_statics_customer; } ?>
			        ]);

			        var options = {
			          chart: {
			            title: 'Customer statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('donut-customer-audit'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>

		    
			<!-- END AUDIT COLUMN CHART -->
			<!-- START FINDINGS COLUMN CHART -->
				<?php

		    	$findings_statics_internal = array();
		    	$findings_statics_external = array();
		    	$findings_statics_customer = array();

		    	$consulta_filter_basic_department ="SELECT * FROM Basic_Department";
				$consulta_general_basic_department = mysqli_query($con, $consulta_filter_basic_department);

				while($result_basic_department = mysqli_fetch_assoc($consulta_general_basic_department)){

					$id_basic_department = $result_basic_department['Id_department'];
					//Internal

					// Filtro por Completed
					$consulta_count_audit_completed_finding_internal="SELECT COUNT(*) as completed FROM Audit_Management_Findings WHERE Id_department = $id_basic_department AND Id_type_of_audit = 1 AND Status LIKE 'Completed' AND Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";


					$result_count_audit_completed_finding_internal = mysqli_query($con, $consulta_count_audit_completed_finding_internal);
					$count_result_audit_completed_finding_internal = mysqli_fetch_assoc($result_count_audit_completed_finding_internal);

					// Filtro por Schedule
					$consulta_count_audit_schedule_finding_internal="SELECT COUNT(*) as schedule FROM Audit_Management_Findings WHERE Id_department = $id_basic_department AND Id_type_of_audit = 1 AND Status LIKE 'Schedule' AND Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_audit_schedule_finding_internal = mysqli_query($con, $consulta_count_audit_schedule_finding_internal);
					$count_result_schedule_audit_finding_internal = mysqli_fetch_assoc($result_count_audit_schedule_finding_internal);

					//mostrar datos al chart
					$findings_statics_internal[] = "['".$result_basic_department['Department']."', ".$count_result_audit_completed_finding_internal['completed'].",".$count_result_schedule_audit_finding_internal['schedule']."],";
					//print_r($audit_statics_internal);

						// External

					// Filtro por Completed
					$consulta_count_audit_finding_external="SELECT COUNT(*) as completed FROM Audit_Management_Findings WHERE Id_department = $id_basic_department AND Id_type_of_audit = 2 AND Status LIKE 'Completed' AND Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";
					
					$result_count_audit_finding_external = mysqli_query($con, $consulta_count_audit_finding_external);
					$count_result_audit_finding_external = mysqli_fetch_assoc($result_count_audit_finding_external);

					// Filtro por Schedule
					$consulta_count_category_schedule_finding_external="SELECT COUNT(*) as schedule FROM Audit_Management_Findings WHERE Id_department = $id_basic_department AND Id_type_of_audit = 2 AND Status LIKE 'Schedule' AND Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_category_schedule_finding_external = mysqli_query($con, $consulta_count_category_schedule_finding_external);

					$count_result_schedule_finding_external = mysqli_fetch_assoc($result_count_category_schedule_finding_external);

					$findings_statics_external[] = "['".$result_basic_department['Department']."', ".$count_result_audit_finding_external['completed'].",".$count_result_schedule_finding_external['schedule']."],";

					//Customer

					// Filtro por Completed
					$consulta_count_audit_finding_statistics_customer ="SELECT COUNT(*) as completed FROM Audit_Management_Findings WHERE Id_department = $id_basic_department AND Id_type_of_audit = 3 AND status LIKE 'Completed' AND Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";
					
					$result_count_audit_finding_statistics_customer = mysqli_query($con, $consulta_count_audit_finding_statistics_customer);

					$count_result_audit_finding_statistics_customer = mysqli_fetch_assoc($result_count_audit_finding_statistics_customer);

					// Filtro por Schedule
					$consulta_count_category_schedule_audit_finding_customer ="SELECT COUNT(*) as schedule FROM Audit_Management_Findings WHERE Id_department = $id_basic_department AND Id_type_of_audit = 3 AND status LIKE 'Schedule' AND Finding_created_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31');";

					$result_count_category_schedule_audit_finding_customer = mysqli_query($con, $consulta_count_category_schedule_audit_finding_customer);

					$count_result_schedule_audit_finding_customer = mysqli_fetch_assoc($result_count_category_schedule_audit_finding_customer);

					$findings_statics_customer[] = "['".$result_basic_department['Department']."', ".$count_result_audit_finding_statistics_customer['completed'].",".$count_result_schedule_audit_finding_customer['schedule']."],";
				}
		    ?>
				<script type="text/javascript">
					function toggle_internal_fin() {
					  var internal = document.getElementById("box-internal-column_fin");
					  var external = document.getElementById("box-external-column_fin");
					  var customer = document.getElementById("box-customer-column_fin");
					  internal.style.display = "block";
					  external.style.display = "none";
					  customer.style.display = "none";
					  setTimeout(drawChartFindingI, 10);
					}
					function toggle_external_fin() {
					  var internal = document.getElementById("box-internal-column_fin");
					  var external = document.getElementById("box-external-column_fin");
					  var customer = document.getElementById("box-customer-column_fin");
					  internal.style.display = "none";
					  external.style.display = "block";
					  customer.style.display = "none";
					  setTimeout(drawChartFindingE, 10);
					}
					function toggle_customer_fin() {
					  var internal = document.getElementById("box-internal-column_fin");
					  var external = document.getElementById("box-external-column_fin");
					  var customer = document.getElementById("box-customer-column_fin");
					  internal.style.display = "none";
					  external.style.display = "none";
					  customer.style.display = "block";
					  setTimeout(drawChartFindingC, 10);
					}
				</script>
				<!-- filter -->
				<script>
				function enviar_ajax(){	

					$.ajax({
					type: 'POST',
					url: 'includes/filter_audit.php',
					data: $('#form1').serialize(),
					})
					.done(function(resultado){
					$("#donut-internal-audit").html(resultado);

					});
				}
				</script>

				<!-- Internal Findings Column -->

				<script type="text/javascript">
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],
			          <?php foreach ($findings_statics_internal as $findings_statics_internal) { echo $findings_statics_internal; } ?>
			        ]);

			        var options = {
			          chart: {
			            title: 'Internal statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('columnchart_material_internal_fin'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>

			    <!-- External Findings Column -->

				<script type="text/javascript">
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],
			          <?php foreach ($findings_statics_external as $findings_statics_external) { echo $findings_statics_external; } ?>
			        ]);

			        var options = {
			          chart: {
			            title: 'External statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('columnchart_material_external_fin'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>

			    <!-- Customer Findings Column -->

				<script type="text/javascript">
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],
			          <?php foreach ($findings_statics_customer as $findings_statics_customer) { echo $findings_statics_customer; } ?>
			        ]);

			        var options = {
			          chart: {
			            title: 'Customer statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('columnchart_material_customer_fin'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>

			<!-- END FINDINGS COLUMN CHART -->


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