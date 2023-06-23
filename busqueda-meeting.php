<?php
include('includes/functions.php');
$consulta = "SELECT * FROM meeting WHERE is_deleted = 0 order by id DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$role = $_POST['role'];
	$empId = $_POST['empId'];
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	if ($role == 1) {
		$consulta = "SELECT * FROM meeting WHERE is_deleted = 0 AND (meeting_id LIKE '%" . $termino . "%' OR title LIKE '%" . $termino . "%' OR date LIKE '%" . $termino . "%' OR start_time LIKE '%" . $termino . "%' OR end_time LIKE '%" . $termino . "%' OR status LIKE '%" . $termino . "%') order by id DESC";
	} else {
		$consulta = "SELECT meeting.* FROM meeting 
		LEFT JOIN meeting_participant ON meeting_participant.meeting_id = meeting.id 
		WHERE meeting.is_deleted = 0 AND coordinator = '$empId' OR meeting_participant.participant_id = '$empId' AND (meeting_id LIKE '%" . $termino . "%' OR title LIKE '%" . $termino . "%' OR date LIKE '%" . $termino . "%' OR start_time LIKE '%" . $termino . "%' OR end_time LIKE '%" . $termino . "%' OR status LIKE '%" . $termino . "%') GROUP BY meeting_participant.meeting_id order by id DESC";
	}
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '<div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-200px">Title</th>
				<th class="min-w-200px">Unique ID</th>
				<th class="min-w-200px">Date</th>
				<th class="min-w-200px">Time</th>
				<th class="min-w-125px">Status</th>
				<th class="min-w-125px">Action</th>
			</tr>
        </thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
		<tr><td>";
		echo $result_data['title'];
		echo "</td> <td>";
		echo $result_data['meeting_id'];
		echo "</td> <td>";
		echo date("d-m-y", strtotime($result_data['date']));
		echo "</td> <td>";
		echo $result_data['start_time'] . ' ~ ' . $result_data['end_time'];
		echo "</td>";
		switch ($result_data['status']) {
			case 'Scheduled':
				$class = 'status-info';
				break;
			case 'In Review':
				$class = 'status-primary';
				break;
			case 'Overdue':
				$class = 'status-warning';
				break;
			case 'Cancelled':
				$class = 'status-danger';
				break;
			case 'Published':
				$class = 'status-active';
				break;
		}
		echo '<td><div class="' . $class . '">' . $result_data['status'] . '</div></td><td>';
		echo '<a href="/meeting_view.php?id=' . $result_data['id'] . '" class="me-3"><i class="fa fa-eye" aria-hidden="true"></i></a>';
		if ($result_data['status'] != "Cancelled") {
			if ($result_data['status'] != "Published") {
				echo '<a href="/meeting_edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
				if ($result_data['status'] != "In Review" && ($role == 1 || $empId == $result_data['coordinator'])) {
					echo '<a href=""/includes/meeting_status.php?id=' . $result_data['id'] . '&status=cancel" class="me-3"><i class="fa fa-remove" aria-hidden="true"></i></a>';
				}
			}
		}
		echo "</td></tr></tbody>";
	}
	echo "</table></div></div>";
}
