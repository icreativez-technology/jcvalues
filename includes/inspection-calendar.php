<?php
$sql_events = "SELECT * FROM inspection WHERE is_deleted = 0";
$result = mysqli_query($con, $sql_events);
while ($result_events = mysqli_fetch_assoc($result)) {
	$category[] = "{
			title: '" . $result_events['unique_id'] . "',
			url: 	'/inspection_edit.php?id=" . $result_events['id'] . "&view',
			start: '" . date("Y-m-d", strtotime($result_events['from_date'])) . "',
			end: '" . date("Y-m-d", strtotime('+1 day', strtotime($result_events['to_date']))) . "'
		},";
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
			height: 550,
			//default color red
			eventBackgroundColor:'#008ffb',
			eventBorderColor:'#008ffb',
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