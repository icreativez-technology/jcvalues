<?php
session_start();
include('functions.php');	

			$category = array();
			$fromdata =  $_POST['fromdate'];
			$enddata = 	$_POST['todate'];
			$Id_category = $_POST['category'];

			$consulta_filter_general_category ="SELECT * FROM Meeting_Category WHERE Id_meeting_category = $Id_category";
			$consulta_general_category = mysqli_query($con, $consulta_filter_general_category);
			$result_filter_category = mysqli_fetch_assoc($consulta_general_category);
			
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{ 
				



					$id_category = $result_datos_category['Id_meeting_category'];

					// Filtro por Completed
					$consulta_count_category_completed="SELECT COUNT(*) as completed FROM Meeting WHERE Id_category = $Id_category AND status LIKE 'Completed'AND Start_Date BETWEEN '$fromdata' AND '$enddata'";
					
					$result_count_category_completed = mysqli_query($con, $consulta_count_category_completed);
					$count_result_completed = mysqli_fetch_assoc($result_count_category_completed);
					

					// Filtro por Schedule
					$consulta_count_category_schedule="SELECT COUNT(*) as schedule FROM Meeting WHERE Id_category = $Id_category AND status LIKE 'Schedule' AND Start_Date BETWEEN '$fromdata' AND '$enddata'";

					$result_count_category_schedule = mysqli_query($con, $consulta_count_category_schedule);
					$count_result_schedule = mysqli_fetch_assoc($result_count_category_schedule);

					// Filtro por Delay
					$consulta_count_category_delay="SELECT COUNT(*) as delay FROM Meeting WHERE Id_category = $Id_category AND status LIKE 'Delay' AND Start_Date BETWEEN '$fromdata' AND '$enddata'" ;

					$result_count_category_delay = mysqli_query($con, $consulta_count_category_delay);
					$count_result_delay = mysqli_fetch_assoc($result_count_category_delay);

					$initial = strlen($result_filter_category['Title']);
					
					if($initial > 8){
					$category_name = substr($result_filter_category['Title'],0,8).'.';
					}else{
						$category_name = $result_filter_category['Title'];
					}
					
					//mostrar datos al chart
					$category= ["['".$category_name."', ".$count_result_completed['completed'].",".$count_result_schedule['schedule']."],"];
					print_r($category);
					
					echo"<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
					<!-- FIRST CHART -->
					<script type='text/javascript'>

			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			        	['', 'Completed', 'Schedule'],";	
			        	foreach ($category as $category) {echo $category; }
			        echo "]);

			        var options = {
			          legend: {position: 'none', maxLines: 3},
			          colors: ['#00d9d9', '#ffc700'],
			          bars: 'horizontal' // Required for Material Bar Charts.
			        };

			        var chart = new google.charts.Bar(document.getElementById('first_chart_column'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>";
						
				//Second Chart
				$mom_progress = array();
				$email_user_employee = $_SESSION['usuario'];
				$select_user_employee ="SELECT * FROM Basic_Employee WHERE Email LIKE '$email_user_employee'";

				$consulta_user_employee = mysqli_query($con, $select_user_employee);
				$result_user_employee = mysqli_fetch_assoc($consulta_user_employee);
				$Id_meeting_employee = $result_user_employee['Id_employee'];

				$select_user_coordinator ="SELECT * FROM Meeting_Co_Ordinator WHERE Id_employee = $Id_meeting_employee";

				$consulta_user_coordinator = mysqli_query($con, $select_user_coordinator);
				$result_user_coordinator = mysqli_fetch_assoc($consulta_user_coordinator);
				$Id_meeting_co_ordinator = $result_user_coordinator['Id_meeting_co_ordinator'];

				// Filtro por Completed
				$consulta_count_coordinator_completed="SELECT COUNT(*) as completed FROM Meeting_Agenda WHERE Id_meeting_co_ordinator = $Id_meeting_employee AND status LIKE 'Completed' AND Whenm BETWEEN '$fromdata' AND '$enddata'";

				$result_count_coordinator_completed = mysqli_query($con, $consulta_count_coordinator_completed);
				$count_result_coordinator_completed = mysqli_fetch_assoc($result_count_coordinator_completed);

				// Filtro por Schedule
				$consulta_count_coordinator_schedule="SELECT COUNT(*) as schedule FROM Meeting_Agenda WHERE Id_meeting_co_ordinator = $Id_meeting_employee AND status LIKE 'Schedule' AND Whenm BETWEEN '$fromdata' AND '$enddata'";

				$result_count_coordinator_schedule = mysqli_query($con, $consulta_count_coordinator_schedule);
				$count_result_coordinator_schedule = mysqli_fetch_assoc($result_count_coordinator_schedule);

				$mom_progress[] = "['".$email_user_employee."', ".$count_result_coordinator_completed['completed'].",".$count_result_coordinator_schedule['schedule']."],";
				

				echo"<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
					<!-- FIRST CHART -->
					<script type='text/javascript'>

			      google.charts.load('current', {'packages':['bar']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			        ['', 'Completed', 'Open'],";	
			        	 foreach ($mom_progress as $mom_progress) { echo $mom_progress; } 
			        echo "]);

			        var options = {
			          legend: {position: 'none', maxLines: 3},
			          colors: ['#00d9d9', '#ffc700'],
			          bars: 'horizontal' // Required for Material Bar Charts.
			        };

			        var chart = new google.charts.Bar(document.getElementById('second_chart_column'));

			        chart.draw(data, google.charts.Bar.convertOptions(options));
			      }
			    </script>";


			   
				
			}

			
?>
					
					