<?php
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Basic_Employee.Id_employee = '$Id_employee'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
if ($role == 1) {
	//As an admin
	$sql_events = "SELECT * FROM meeting WHERE is_deleted = 0";
	$result = mysqli_query($con, $sql_events);
	while ($result_events = mysqli_fetch_assoc($result)) {
		$category[] = "{
			title: '" . $result_events['meeting_id'] . "',
			url: 	'/meeting_view.php?id=" . $result_events['id'] . "',
			start: '" . $result_events['date'] . "'
		},";
	}
} else {
	//As a participant
	$sql_agenda = "SELECT * FROM meeting_participant WHERE participant_id = '$Id_employee' AND is_deleted = 0";
	$result_datos_agenda = mysqli_query($con, $sql_agenda);
	$meetingIds = array();
	while ($at = mysqli_fetch_assoc($result_datos_agenda)) {
		array_push($meetingIds, $at['meeting_id']);
		$Id_meeting = $at['meeting_id'];
		$sql_events = "SELECT * FROM meeting WHERE id = '$Id_meeting'";
		$result = mysqli_query($con, $sql_events);
		$result_events = mysqli_fetch_assoc($result);
		$category[] = "{
		title: '" . $result_events['meeting_id'] . "',
		url: 	'/meeting_view.php?id=" . $result_events['id'] . "',
		start: '" . $result_events['date'] . "'
	},";
	}

	//As a coordinator
	$sql_events = "SELECT * FROM meeting WHERE coordinator = '$Id_employee' AND is_deleted = 0";
	$result = mysqli_query($con, $sql_events);
	while ($result_events = mysqli_fetch_assoc($result)) {
		if (!in_array($result_events['id'], $meetingIds)) {
			$category[] = "{
			title: '" . $result_events['meeting_id'] . "',
			url: 	'/meeting_view.php?id=" . $result_events['id'] . "',
			start: '" . $result_events['date'] . "'
		},";
		}
	}
}
?>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var calendarEl = document.getElementById('calendar');
		var date = new Date();
		var calendar = new FullCalendar.Calendar(calendarEl, {
			headerToolbar: {
				left: 'prev,next,today',
				center: 'title',
				right: 'dayGridMonth,dayGridWeek,dayGridDay'
			},
			initialDate: date,
			navLinks: true,
			editable: true,
			dayMaxEvents: true,
			//default color red
			eventBackgroundColor:'#008ffb',
			eventBorderColor:'#008ffb',
			//themeSystem: 'bootstrap',
			height: 550,
			events: [
				<?php
				if (isset($category)) {
					foreach ($category as $category) {
						echo $category;
					}
				}
				?>
			]
		});
		calendar.render();
	});
</script>