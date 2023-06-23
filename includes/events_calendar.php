<?php

session_start();
include('functions.php');
		
		$sql_events = "SELECT * FROM Meeting";
		$result = mysqli_query($con, $sql_events);
		$result_events = mysqli_fetch_assoc($result);
		
		while ($result_events = mysqli_fetch_assoc($result)) {
			$category[] = "
				{
					title: '".$result_events['Title']."',
					url: 	'google.es',
					start: '".$result_events['Start_Date']."'
					
				},";
			
		}
		print_r($category);

?>