<?php
session_start();
include('includes/functions.php');
$sqlData = "SELECT * FROM meeting WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$meeting = mysqli_fetch_assoc($connectData);
$sql = "SELECT * FROM Basic_Employee where Id_employee = '$meeting[coordinator]'";
$fetch = mysqli_query($con, $sql);
$coordinatorInfo = mysqli_fetch_assoc($fetch);
$participantSqlData = "SELECT participant_id, First_Name, Last_Name FROM meeting_participant LEFT JOIN Basic_Employee ON meeting_participant.participant_id = Basic_Employee.Id_employee WHERE meeting_id = '$meeting[id]' AND meeting_participant.is_deleted = 0";
$participantData = mysqli_query($con, $participantSqlData);
$participants =  array();
$participantsData =  array();
while ($row = mysqli_fetch_assoc($participantData)) {
	array_push($participants, $row['participant_id']);
	array_push($participantsData, $row);
}
$agendaSqlData = "SELECT * FROM meeting_agenda WHERE meeting_id = '$_REQUEST[id]' AND is_deleted = 0";
$agendaSqlConnectData = mysqli_query($con, $agendaSqlData);
$agenda =  array();
while ($row = mysqli_fetch_assoc($agendaSqlConnectData)) {
	array_push($agenda, $row);
}
$notesSqlData = "SELECT * FROM meeting_notes WHERE meeting_id = '$_REQUEST[id]' AND is_deleted = 0";
$notesSqlConnectData = mysqli_query($con, $notesSqlData);
$notes =  array();
while ($row = mysqli_fetch_assoc($notesSqlConnectData)) {
	array_push($notes, $row);
}
$actionsSqlData = "SELECT * FROM meeting_actions WHERE meeting_id = '$_REQUEST[id]' AND is_deleted = 0";
$actionsSqlConnectData = mysqli_query($con, $actionsSqlData);
$actions =  array();
while ($row = mysqli_fetch_assoc($actionsSqlConnectData)) {
	array_push($actions, $row);
}
$decisionsSqlData = "SELECT * FROM meeting_decisions WHERE meeting_id = '$_REQUEST[id]' AND is_deleted = 0";
$decisionsSqlConnectData = mysqli_query($con, $decisionsSqlData);
$decisions =  array();
while ($row = mysqli_fetch_assoc($decisionsSqlConnectData)) {
	array_push($decisions, $row);
}
$_SESSION['Page_Title'] = "View Meeting - " . $meeting['meeting_id'];

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
	.custom-tab .nav-link {
		border-radius: 3px;
		padding: 8px 20px;
	}

	.custom-tab .nav-link.active {
		color: #fff !important;
		background-color: #009ef7;
	}

	.custom-tab .nav-link.active:hover {
		color: #fff !important;
	}

	.required::after {
		content: "*";
		color: #e1261c;
	}

	.custom-select {
		background-color: #f5f8fa;
		border: 1px solid #e4e6ef;
		border-radius: 6px;
		width: 100%;
		padding: 6px;
		min-height: 38px;
	}

	.custom-select .tag-wrapper {
		list-style: none;
		display: flex;
		justify-content: flex-start;
		align-content: flex-start;
		flex-wrap: wrap;
	}

	.tag-wrapper .tags {
		position: relative;
		padding: 0px 15px 0px 6px;
		margin: 4px;
		text-align: left;
		background-color: #e1e2e4;
		border-radius: 5px;
	}

	.tag-wrapper .tags span {
		position: absolute;
		right: 4px;
		cursor: pointer;
		color: #002429;
	}

	.tag-wrapper .tags span::after {
		content: "x";
		font-weight: 600;
	}

	.tag-wrapper .tags span:hover {
		color: #e1261c;
	}

	.tag-wrapper .tags a {
		color: #002429;
	}

	.tag-wrapper .tags a:hover {
		color: #e1261c;
	}

	.ver-disabled input {
		background-color: #e9ecef !important;
	}

	.modal.left .modal-dialog,
	.modal.right .modal-dialog {
		position: fixed;
		top: 0 !important;
		right: 0 !important;
		margin: auto;
		width: 320px;
		height: 100%;
		-webkit-transform: translate3d(0%, 0, 0);
		-ms-transform: translate3d(0%, 0, 0);
		-o-transform: translate3d(0%, 0, 0);
		transform: translate3d(0%, 0, 0);
	}

	.modal.left .modal-content,
	.modal.right .modal-content {
		height: 100%;
		overflow-y: auto;
	}

	.modal.left .modal-body,
	.modal.right .modal-body {
		padding: 15px 15px 15px;
	}

	.modal.left.fade .modal-dialog {
		left: -320px;
		-webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
		-moz-transition: opacity 0.3s linear, left 0.3s ease-out;
		-o-transition: opacity 0.3s linear, left 0.3s ease-out;
		transition: opacity 0.3s linear, left 0.3s ease-out;
	}

	.modal.left.fade.in .modal-dialog {
		left: 0;
	}

	.modal.right.fade .modal-dialog {
		right: -320px;
		-webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
		-moz-transition: opacity 0.3s linear, right 0.3s ease-out;
		-o-transition: opacity 0.3s linear, right 0.3s ease-out;
		transition: opacity 0.3s linear, right 0.3s ease-out;
	}

	.modal.right.fade.in .modal-dialog {
		right: 0;
	}
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
	<div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">
			<?php include('includes/aside-menu.php'); ?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include('includes/header.php'); ?>
				<div class="row breadcrumbs">
					<div>
						<div>
							<p><a href="/">Home</a> » <a href="/meeting.php">Meetings</a> » <a href="/meeting_view_list.php">Meeting List</a> »
								<?php echo $_SESSION['Page_Title']; ?></p>
						</div>
					</div>
				</div>
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="container-custom" id="kt_content_container">
						<ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="true">Schedule</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="mom-tab" data-bs-toggle="tab" data-bs-target="#mom" type="button" role="tab" aria-controls="mom" aria-selected="false">MOM</button>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade active show" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
								<div class="card card-flush">
									<div class="card-body">
										<div id="custom-section-1">
											<div class="form-group row">
												<div class="col-lg-3 mt-5">
													<label class="required">Title</label>
													<input class="form-control" name="title" required value="<?php echo $meeting['title']; ?>" disabled>
												</div>
												<div class="col-lg-3 mt-5">
													<label class="required">Coordinator</label>
													<input type="text" class="form-control" value="<?php echo $coordinatorInfo['First_Name'] . ' ' . $coordinatorInfo['Last_Name']; ?>" disabled>
												</div>
												<div class="col-lg-3 mt-5">
													<label class="required">Category</label>
													<select class="form-control" name="category" required disabled>
														<option value="">Please Select</option>
														<?php
														$sql_data = "SELECT * FROM Meeting_Category";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															if ($result_data['Status'] == 'Active') {
																$selected = $meeting['category'] == $result_data['Id_meeting_category'] ? 'selected' : '';
														?>
																<option value="<?php echo $result_data['Id_meeting_category']; ?>" <?= $selected; ?>>
																	<?php echo $result_data['Title']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
												<div class="col-lg-3 mt-5">
													<label class="required">Venue</label>
													<select class="form-control" name="venue" required disabled>
														<option value="">Please Select</option>
														<?php
														$sql_data = "SELECT * FROM Meeting_Venue";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															if ($result_data['Status'] == 'Active') {
																$selected = $meeting['venue'] == $result_data['Id_meeting_venue'] ? 'selected' : '';
														?>
																<option value="<?php echo $result_data['Id_meeting_venue']; ?>" <?= $selected; ?>>
																	<?php echo $result_data['Title']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-lg-3 mt-5">
													<label class="required">Date</label>
													<input type="date" class="form-control" name="date" min="" id="date" required disabled value="<?php echo $meeting['date']; ?>">
												</div>
												<div class="col-lg-3 mt-5">
													<label class="required">Start Time</label>
													<input type="time" class="form-control set-time" name="start_time" id="start_time" required disabled value="<?php echo $meeting['start_time']; ?>">
												</div>
												<div class="col-lg-3 mt-5">
													<label class="required">End Time</label>
													<input type="time" class="form-control set-time" name="end_time" id="end_time" required disabled value="<?php echo $meeting['end_time']; ?>">
												</div>
												<div class="col-lg-3 mt-5 ver-disabled">
													<label class="required">Duration</label>
													<input type="time" class="form-control" name="duration" id="duration" required disabled value="<?php echo $meeting['duration']; ?>" readonly>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-lg-9 mt-5">
													<label class="required">Participants</label>
													<select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Participants" name="participants[]" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" required disabled multiple>
														<?php
														$sql_data = "SELECT * FROM Basic_Employee";
														$connect_data = mysqli_query($con, $sql_data);
														while ($result_data = mysqli_fetch_assoc($connect_data)) {
															if ($result_data['Status'] == 'Active') {
														?>
																<option value="<?php echo $result_data['Id_employee']; ?>" <?php echo (in_array($result_data['Id_employee'], $participants)) ? 'selected' : ''; ?>>
																	<?php echo $result_data['First_Name']; ?>
																	<?php echo $result_data['Last_Name']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
												<div class="col-lg-3 mt-5">
													<label class="required">Status</label>
													<input class="form-control" name="status" required value="<?php echo $meeting['status']; ?>" disabled>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer">
										<div class="row" style="text-align:center; float:right;">
											<div class="mb-4">
												<a type="button" href="/meeting.php" class="btn btn-sm btn-secondary ms-2">Close</a>
											</div>
										</div>
									</div>
									<input type="hidden" class="form-control" name="meetingId" value="<?php echo $meeting['id']; ?>">
								</div>
							</div>
							<div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "active show" : "" ?>" id="mom" role="tabpanel" aria-labelledby="mom-tab">
								<div class="card card-flush">
									<div class="card-body">
										<div class="d-flex justify-content-between align-items-center mt-4">
											<h5 class="fw-bold text-primary m-0">Meeting Agenda</h5>
										</div>
										<ul class="mt-4">
											<?php if ($agenda && count($agenda) > 0) {
												foreach ($agenda as $key => $item) { ?>
													<li class="mt-2">
														<span class="text-dark d-block fw-bold fs-6"><?php echo $item['description']; ?></span>
													</li>
											<?php }
											}
											?>
										</ul>
										<div class="d-flex justify-content-between align-items-center">
											<h5 class="fw-bold text-primary m-0">Discussion Notes</h5>
										</div>
										<ul class="mt-4">
											<?php if ($notes && count($notes) > 0) {
												foreach ($notes as $key => $item) { ?>
													<li class="mt-2">
														<span class="text-dark d-block fw-bold fs-6"><?php echo $item['description']; ?></span>
														<?php
														$sql = "SELECT * From Basic_Employee Where Id_employee = $item[speaker]";
														$fetch = mysqli_query($con, $sql);
														$who = mysqli_fetch_assoc($fetch);
														?>
														<span class="text-muted fw-bold me-2"><?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?></span>
														<span class="text-muted fw-bold me-2"><?php echo date("d-m-y", strtotime($item['updated_at'])); ?></span>
														<span class="text-muted fw-bold"><?php echo date("h:i:s", strtotime($item['updated_at'])); ?></span>
													</li>
											<?php }
											}
											?>
										</ul>
										<div class="d-flex justify-content-between align-items-center">
											<h5 class="fw-bold text-primary m-0">Follow Up Actions</h5>
										</div>
										<ul class="mt-4">
											<?php if ($actions && count($actions) > 0) {
												foreach ($actions as $key => $item) { ?>
													<li class="mt-2">
														<span class="text-dark d-block fw-bold fs-6"><?php echo $item['description']; ?></span>
														<?php
														$sql = "SELECT * From Basic_Employee Where Id_employee = $item[speaker]";
														$fetch = mysqli_query($con, $sql);
														$who = mysqli_fetch_assoc($fetch);
														?>
														<span class="text-muted fw-bold me-2"><?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?></span>
														<span class="text-muted fw-bold me-2"><?php echo date("d-m-y", strtotime($item['updated_at'])); ?></span>
														<span class="text-muted fw-bold"><?php echo date("h:i:s", strtotime($item['updated_at'])); ?></span>
													</li>
											<?php }
											}
											?>
										</ul>
										<div class="d-flex justify-content-between align-items-center">
											<h5 class="fw-bold text-primary m-0">Key Decisions</h5>
										</div>
										<ul class="mt-4">
											<?php if ($decisions && count($decisions) > 0) {
												foreach ($decisions as $key => $item) { ?>
													<li class="mt-2">
														<span class="text-dark d-block fw-bold fs-6"><?php echo $item['description']; ?></span>
														<?php
														$sql = "SELECT * From Basic_Employee Where Id_employee = $item[speaker]";
														$fetch = mysqli_query($con, $sql);
														$who = mysqli_fetch_assoc($fetch);
														?>
														<span class="text-muted fw-bold me-2"><?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?></span>
														<span class="text-muted fw-bold me-2"><?php echo date("d-m-y", strtotime($item['updated_at'])); ?></span>
														<span class="text-muted fw-bold"><?php echo date("h:i:s", strtotime($item['updated_at'])); ?></span>
													</li>
											<?php }
											}
											?>
										</ul>
									</div>
									<div class="card-footer">
										<div class="row" style="text-align:center; float:right;">
											<div class="mb-2">
												<a type="button" href="/meeting_view_list.php" class="btn btn-sm btn-secondary">Close</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include('includes/footer.php'); ?>
	</div>
	<?php include('includes/scrolltop.php'); ?>
	<script>
		var hostUrl = "assets/";
	</script>
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
	<script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="assets/js/widgets.bundle.js"></script>
	<script src="assets/js/custom/widgets.js"></script>
	<script src="assets/js/custom/apps/chat/chat.js"></script>
	<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
	<script src="assets/js/custom/utilities/modals/select-location.js"></script>
	<script src="assets/js/custom/utilities/modals/users-search.js"></script>
</body>

</html>