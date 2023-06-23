<?php
session_start();
include('functions.php');	

			$category = array();
			$fromdata =  $_POST['fromdate'];
			$enddata = 	$_POST['todate'];
			$Id_department = $_POST['Id_department'];
			$Id_plant = $_POST['Id_plant'];
			$Id_product_group = $_POST['Id_product_group'];
			$Id_audit_standard = $_POST['audit_standard'];
			
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{ 


					/*FIRST CHART*/
					$audit_statics_internal = array();
		    		$audit_statics_external = array();
		    		$audit_statics_customer = array();

		    		//Department
		    		$consulta_filter_general_department ="SELECT * FROM Basic_Department WHERE Id_department = $Id_department";
					$consulta_general_department = mysqli_query($con, $consulta_filter_general_department);
					$result_filter_department = mysqli_fetch_assoc($consulta_general_department);
					//Internal

					// Filtro por Completed
					$consulta_count_audit_statistics_internal="SELECT COUNT(*) as completed FROM Audit_Management WHERE Id_basic_department = $Id_department AND Id_basic_plant = $Id_plant AND Id_basic_product_group = $Id_product_group AND Id_audit_standard = $Id_audit_standard AND Id_type_of_audit = 1 AND status LIKE 'Completed' AND Audit_schedule_date BETWEEN '$fromdata' AND '$enddata'";
					
					$result_count_audit_statistics_internal = mysqli_query($con, $consulta_count_audit_statistics_internal);
					$count_result_audit_statistics_internal = mysqli_fetch_assoc($result_count_audit_statistics_internal);

					// Filtro por Schedule
					$consulta_count_category_schedule_audit_internal="SELECT COUNT(*) as schedule FROM Audit_Management WHERE Id_basic_department = $Id_department AND Id_basic_plant =  $Id_plant AND Id_basic_product_group = $Id_product_group AND Id_audit_standard = $Id_audit_standard AND Id_type_of_audit = 1 AND status LIKE 'Schedule' AND Audit_schedule_date BETWEEN '$fromdata' AND '$enddata';";

					$result_count_category_schedule_audit_internal = mysqli_query($con, $consulta_count_category_schedule_audit_internal);
					$count_result_schedule_audit_internal = mysqli_fetch_assoc($result_count_category_schedule_audit_internal);

					//mostrar datos al chart
					$audit_statics_internal[] = "['".$result_filter_department['Department']."', ".$count_result_audit_statistics_internal['completed'].",".$count_result_schedule_audit_internal['schedule']."],";
					//print_r($audit_statics_internal);

					// External

					// Filtro por Completed
					$consulta_count_audit_statistics_external="SELECT COUNT(*) as completed FROM Audit_Management WHERE Id_basic_department = $Id_department AND Id_basic_plant =  $Id_plant AND Id_basic_product_group = $Id_product_group AND Id_audit_standard = $Id_audit_standard AND Id_type_of_audit = 2 AND status LIKE 'Completed' AND Audit_schedule_date BETWEEN '$fromdata' AND '$enddata';";
					
					$result_count_audit_statistics_external = mysqli_query($con, $consulta_count_audit_statistics_external);
					$count_result_audit_statistics_external = mysqli_fetch_assoc($result_count_audit_statistics_external);

					// Filtro por Schedule
					$consulta_count_category_schedule_audit_external="SELECT COUNT(*) as schedule FROM Audit_Management WHERE Id_basic_department = $Id_department AND Id_basic_plant =  $Id_plant AND Id_basic_product_group = $Id_product_group AND Id_audit_standard = $Id_audit_standard AND Id_type_of_audit = 2 AND status LIKE 'Schedule' AND Audit_schedule_date BETWEEN '$fromdata' AND '$enddata';";

					$result_count_category_schedule_audit_external = mysqli_query($con, $consulta_count_category_schedule_audit_external);
					$count_result_schedule_audit_external = mysqli_fetch_assoc($result_count_category_schedule_audit_external);

					$audit_statics_external[] = "['".$result_filter_department['Department']."', ".$count_result_audit_statistics_external['completed'].",".$count_result_schedule_audit_external['schedule']."],";
					
					//Customer

					// Filtro por Completed
					$consulta_count_audit_statistics_customer="SELECT COUNT(*) as completed FROM Audit_Management WHERE Id_basic_department = $Id_department AND Id_basic_plant =  $Id_plant AND Id_basic_product_group = $Id_product_group AND Id_audit_standard = $Id_audit_standard AND Id_type_of_audit = 3 AND status LIKE 'Completed' AND Audit_schedule_date BETWEEN '$fromdata' AND '$enddata';";
					
					$result_count_audit_statistics_customer = mysqli_query($con, $consulta_count_audit_statistics_customer);
					$count_result_audit_statistics_customer = mysqli_fetch_assoc($result_count_audit_statistics_customer);

					// Filtro por Schedule
					$consulta_count_category_schedule_audit_customer="SELECT COUNT(*) as schedule FROM Audit_Management WHERE Id_basic_department = $Id_department AND Id_basic_plant =  $Id_plant AND Id_basic_product_group = $Id_product_group AND Id_audit_standard = $Id_audit_standard AND Id_type_of_audit = 3 AND status LIKE 'Schedule' AND Audit_schedule_date BETWEEN '$fromdata' AND '$enddata';";

					$result_count_category_schedule_audit_customer = mysqli_query($con, $consulta_count_category_schedule_audit_customer);
					$count_result_schedule_audit_customer = mysqli_fetch_assoc($result_count_category_schedule_audit_customer);

					$audit_statics_customer[] = "['".$result_filter_department['Department']."', ".$count_result_audit_statistics_customer['completed'].",".$count_result_schedule_audit_customer['schedule']."],";

					
					echo" <script type='text/javascript'>
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChartInternal);

			      function drawChartInternal() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],";
			         foreach ($audit_statics_internal as $audit_statics_internal) { echo $audit_statics_internal; }
			        echo "]);

			        var options = {
			          chart: {
			            title: 'Internal statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('donut-internal-audit'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>";
			     //External Audit Chart 
		    

			echo" <script type='text/javascript'>
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChartExternal);

			      function drawChartExternal() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],";
			           foreach ($audit_statics_external as $audit_statics_external) { echo $audit_statics_external; }
			 echo"      ]);

			        var options = {
			          chart: {
			            title: 'External statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('donut-external-audit'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>";
			
				// CUSTOMER AUDIT CHART
			    echo "<script type='text/javascript'>
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChartCustomer);

			      function drawChartCustomer() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],";
			           foreach ($audit_statics_customer as $audit_statics_customer) { echo $audit_statics_customer; } 
			     echo"   ]);

			        var options = {
			          chart: {
			            title: 'Customer statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('donut-customer-audit'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>";
			    /*SECOND CHART*/
			    	$findings_statics_internal = array();
		    		$findings_statics_external = array();
		    		$findings_statics_customer = array();
			    //Internal

					// Filtro por Completed
					$consulta_count_audit_completed_finding_internal="SELECT COUNT(*) as completed FROM Audit_Management_Findings WHERE Id_department = $Id_department AND Id_type_of_audit = 1 AND Status LIKE 'Completed' AND Finding_created_date BETWEEN '$fromdata' AND '$enddata';";


					$result_count_audit_completed_finding_internal = mysqli_query($con, $consulta_count_audit_completed_finding_internal);
					$count_result_audit_completed_finding_internal = mysqli_fetch_assoc($result_count_audit_completed_finding_internal);

					// Filtro por Schedule
					$consulta_count_audit_schedule_finding_internal="SELECT COUNT(*) as schedule FROM Audit_Management_Findings WHERE Id_department = $Id_department AND Id_type_of_audit = 1 AND Status LIKE 'Schedule' AND Finding_created_date BETWEEN '$fromdata' AND '$enddata';";

					$result_count_audit_schedule_finding_internal = mysqli_query($con, $consulta_count_audit_schedule_finding_internal);
					$count_result_schedule_audit_finding_internal = mysqli_fetch_assoc($result_count_audit_schedule_finding_internal);

					//mostrar datos al chart
					$findings_statics_internal[] = "['".$result_filter_department['Department']."', ".$count_result_audit_completed_finding_internal['completed'].",".$count_result_schedule_audit_finding_internal['schedule']."],";
					//print_r($audit_statics_internal);

						// External

					// Filtro por Completed
					$consulta_count_audit_finding_external="SELECT COUNT(*) as completed FROM Audit_Management_Findings WHERE Id_department = $Id_department AND Id_type_of_audit = 2 AND Status LIKE 'Completed' AND Finding_created_date BETWEEN '$fromdata' AND '$enddata';";
					
					$result_count_audit_finding_external = mysqli_query($con, $consulta_count_audit_finding_external);
					$count_result_audit_finding_external = mysqli_fetch_assoc($result_count_audit_finding_external);

					// Filtro por Schedule
					$consulta_count_category_schedule_finding_external="SELECT COUNT(*) as schedule FROM Audit_Management_Findings WHERE Id_department = $Id_department AND Id_type_of_audit = 2 AND Status LIKE 'Schedule' AND Finding_created_date BETWEEN '$fromdata' AND '$enddata';";

					$result_count_category_schedule_finding_external = mysqli_query($con, $consulta_count_category_schedule_finding_external);

					$count_result_schedule_finding_external = mysqli_fetch_assoc($result_count_category_schedule_finding_external);

					$findings_statics_external[] = "['".$result_filter_department['Department']."', ".$count_result_audit_finding_external['completed'].",".$count_result_schedule_finding_external['schedule']."],";

					//Customer

					// Filtro por Completed
					$consulta_count_audit_finding_statistics_customer ="SELECT COUNT(*) as completed FROM Audit_Management_Findings WHERE Id_department = $Id_department AND Id_type_of_audit = 3 AND status LIKE 'Completed' AND Finding_created_date BETWEEN '$fromdata' AND '$enddata';";
					
					$result_count_audit_finding_statistics_customer = mysqli_query($con, $consulta_count_audit_finding_statistics_customer);

					$count_result_audit_finding_statistics_customer = mysqli_fetch_assoc($result_count_audit_finding_statistics_customer);

					// Filtro por Schedule
					$consulta_count_category_schedule_audit_finding_customer ="SELECT COUNT(*) as schedule FROM Audit_Management_Findings WHERE Id_department = $Id_department AND Id_type_of_audit = 3 AND status LIKE 'Schedule' AND Finding_created_date BETWEEN '$fromdata' AND '$enddata';";

					$result_count_category_schedule_audit_finding_customer = mysqli_query($con, $consulta_count_category_schedule_audit_finding_customer);

					$count_result_schedule_audit_finding_customer = mysqli_fetch_assoc($result_count_category_schedule_audit_finding_customer);

					$findings_statics_customer[] = "['".$result_filter_department['Department']."', ".$count_result_audit_finding_statistics_customer['completed'].",".$count_result_schedule_audit_finding_customer['schedule']."],";
					
				
					
				echo "<script type='text/javascript'>
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChartFindingI);

			      function drawChartFindingI() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],";
			     foreach ($findings_statics_internal as $findings_statics_internal) { echo $findings_statics_internal; } 
			    echo "    ]);

			        var options = {
			          chart: {
			            title: 'Internal statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('columnchart_material_internal_fin'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>";

			    // External Findings Column

				echo"<script type='text/javascript'>
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChartFindingE);

			      function drawChartFindingE() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],";
			           foreach ($findings_statics_external as $findings_statics_external) { echo $findings_statics_external; } 
			    echo"    ]);

			        var options = {
			          chart: {
			            title: 'External statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('columnchart_material_external_fin'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>";

			    // Customer Findings Column

				echo "<script type='text/javascript'>
			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChartFindingC);

			      function drawChartFindingC() {
			        var data = google.visualization.arrayToDataTable([
			          ['Department', 'Completed', 'Scheduled'],";
			           foreach ($findings_statics_customer as $findings_statics_customer) { echo $findings_statics_customer; }
			    echo"    ]);

			        var options = {
			          chart: {
			            title: 'Customer statistics',
			            subtitle: '',
			          }
			        };

			        var chart = new google.charts.Bar(document.getElementById('columnchart_material_customer_fin'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>";

				//Completed
					$consulta_count_audit_finding ="SELECT date_format(Audit_schedule_date, '%M') as Month, COUNT(*) as completed FROM Audit_Management WHERE status LIKE 'Completed' AND Audit_schedule_date BETWEEN '$fromdata' AND '$enddata' group by date_format(Audit_schedule_date, '%M');";

					$consulta_general_count_audit_finding = mysqli_query($con, $consulta_count_audit_finding);

					$count_result_count_audit_finding = mysqli_fetch_assoc($consulta_general_count_audit_finding);

				//Schedule
					$consulta_count_schedule_finding ="SELECT date_format(Audit_schedule_date, '%M') as Month, COUNT(*) as schedule FROM Audit_Management WHERE status LIKE 'Schedule' AND Audit_schedule_date BETWEEN '$fromdata' AND '$enddata' group by date_format(Audit_schedule_date, '%M');";
					$consulta_general_count_schedule_finding = mysqli_query($con, $consulta_count_schedule_finding);
					$count_result_count_schedule_finding = mysqli_fetch_assoc($consulta_general_count_schedule_finding);


						echo "<script>
						document.getElementById('month').innerHTML ='";

						

						foreach ($count_result_count_audit_finding as $count_result_count_audit_finding) { 
							
								echo $count_result_count_audit_finding;
							 
						}
						//print_r($result_datos_meeting);
						echo "'</script>";
			}
			/* consulta por meses
			SELECT date_format(Audit_schedule_date, '%M') as Month, COUNT(*) as completed FROM Audit_Management WHERE status LIKE 'Completed' AND Audit_schedule_date BETWEEN DATE_FORMAT(NOW() ,'%Y-05-01') AND DATE_FORMAT(NOW() ,'%Y-%m-31') group by date_format(Audit_schedule_date, '%M');*/
?>
					
					