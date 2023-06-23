<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Meeting Update";
$email_user = $_SESSION['usuario'];

$url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$id_explode_meeting = explode("?", $url);
$id_meeting = $id_explode_meeting[1];

$_SESSION['id_meeting'] = $id_meeting;

$sql_datos_meeting = "SELECT * From Meeting WHERE Id_meeting = $id_meeting";
$conect_datos_meeting = mysqli_query($con, $sql_datos_meeting);
$result_datos_meeting = mysqli_fetch_assoc($conect_datos_meeting);

//User ID
$sql_datos_user = "SELECT * From Basic_Employee WHERE Email LIKE '$email_user'";
$conect_datos_user = mysqli_query($con, $sql_datos_user);
$result_datos_user = mysqli_fetch_assoc($conect_datos_user);
$id_user = $result_datos_user['Id_employee'];
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
					<!--begin::BREADCRUMBS-->
					<div class="row breadcrumbs">
						<!--begin::body-->
						
							<!--begin::Title-->
							<div class="col-lg-6">
								<p><a href="/">Home</a> » <a href="/meeting.php">Meetings</a> » <a href="/meeting_view_list.php">View List</a> » <?php echo $_SESSION['Page_Title']; ?></p>
								<!-- MIGAS DE PAN -->
							</div>
							<div class="col-lg-6">
								<div class="d-flex justify-content-end">
									<a href="/includes/meeting_pdf.php?id_met=<?php echo $id_meeting?>" target="_blank"> 
												<button type="button" class="btn btn-light-primary me-3 topbottons">
													Create PDF
												</button>
											</a>
								</div>
							</div>
						
						<!--end::body-->
					</div>
					<!--end::BREADCRUMBS-->
					<form class="form" method="post" action="includes/meeting_update.php">
						<!--begin::Content-->
						<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
							<!--begin::Container-->
							<div class="container-custom" id="kt_content_container">
								<div class="card card-flush">
			                         <!-- AQUI AÑADIR EL CONTENIDO  -->
										 
										 <!-- begin::Form Content -->
									<div class="card-body">

										<div id="custom-section-1">
										  
										 	<div class="form-group row">
											   <div class="col-lg-3">
											    	<label>Title</label>

													<input type="text" class="form-control" name="title_meeting" Value="<?php echo $result_datos_meeting['Title']; ?>" placeholder="<?php echo $result_datos_meeting['Title']; ?>" >
											   </div>
											   
											   <div class="col-lg-3">
											   		<?php

											   		$id_coodinator = $result_datos_meeting['Coordinator'];
												   	$consulta_general_coordinator ="SELECT * From Meeting_Co_Ordinator as mc CROSS JOIN Basic_Employee as be WHERE mc.Id_employee = be.Id_employee";
												   	$consulta_result_general_coordinator = mysqli_query($con, $consulta_general_coordinator);
													?>
											    	<label>Coordinator </label>
													<select class="form-control" name="coordinator" >
														<option value="">Select option</option>

														<?php while($result_general_coordinator = mysqli_fetch_assoc($consulta_result_general_coordinator)){

												    		if($id_coodinator == $result_general_coordinator['Id_meeting_co_ordinator']){
												    		
												    	?>
														<option value="<?php echo $result_general_coordinator['Id_meeting_co_ordinator']; ?>" selected> <?php echo $result_general_coordinator['First_Name'].' '.$result_general_coordinator['Last_Name'];; ?> </option>
									
													<?php 	}else{ ?>	
														<option value="<?php echo $result_general_coordinator['Id_meeting_co_ordinator']; ?>"><?php echo $result_general_coordinator['First_Name'].' '.$result_general_coordinator['Last_Name']; ?></option>
													<?php 
															} 
														} 
													?>
													</select>
											   </div>
											   
											   <div class="col-lg-3">
											    	<label>Category <strong></strong></label>
													<select class="form-control" name="category" >
														<option value="">Select</option>
														<?php
															$id_meeting_category = $result_datos_meeting['Id_category'];
															$consulta_filter_general_category ="SELECT * FROM Meeting_Category";
											   				$consulta_general_category = mysqli_query($con, $consulta_filter_general_category);
															while($result_filter_category = mysqli_fetch_assoc($consulta_general_category)){ 
																if($id_meeting_category == $result_filter_category['Id_meeting_category'] ){
												    		$id_filter_category = $result_filter_category['Id_meeting_category']; 
												    		
												    	?>
														<option value="<?php echo $id_filter_category; ?>" selected><?php echo  $result_filter_category['Title']; ?></option>
									
														<?php 	}else{ ?>
															<option value="<?php echo $id_filter_category; ?>"><?php echo  $result_filter_category['Title']; ?></option>
														<?php 
																} 
															}
														?>
													</select>
											   </div>
											  
											     <div class="col-lg-3">
											    	<label>Venue</label>
													<select class="form-control" name="venue" >
														<option value="">Select</option>
														<?php
															$id_meeting_venue = $result_datos_meeting['Id_venue'];
															$consulta_general_venue ="SELECT * FROM Meeting_Venue";
											   				$consulta_general_venue = mysqli_query($con, $consulta_general_venue);
															while($result_general_venue = mysqli_fetch_assoc($consulta_general_venue)){ 
																if($id_meeting_venue == $result_general_venue['Id_meeting_venue']){

													    		$id_venue = $result_general_venue['Id_meeting_venue']; 
												    	?>
														<option value="<?php echo $id_venue; ?>" selected><?php echo $result_general_venue['Title']; ?></option>
									
														<?php 	}else{ ?>
														<option value="<?php echo $id_venue; ?>"><?php echo $result_general_venue['Title']; ?></option>
														<?php   
																} 
															} 
														?>
													</select>
											   </div>
										  
										  	</div>

										  <div class="form-group row">
											  	<div class="col-lg-3">
											    	<label>Start Date </label>											 
													<input type="Date" class="form-control" name="start_date" id="start_date" value="<?php echo $result_datos_meeting['Start_Date']; ?>">
											   </div>
											   <div class="col-lg-3">
											    <label>Start Time<strong></strong></label>
													<input type="time" class="form-control" name="start_time" value="<?php echo $result_datos_meeting['Start_Time']; ?>" >
											   </div>
											   <div class="col-lg-3">
											    	<label>End Date <strong></strong></label>											    	
													<input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $result_datos_meeting['End_Date']; ?>" >
											   </div>
											   <div class="col-lg-3">
											    <label>End Time <strong></strong></label>
													<input type="time" class="form-control" name="end_time" value="<?php echo $result_datos_meeting['End_Time']; ?>" >
													<input type="hidden" name="id_meeting" value="<?php echo $id_meeting; ?>">
											   </div>
										 
										  </div>

										  <div class="form-group row">
										
											   <div class="col-lg-3">
											    	<label>Status: </label>
											    	<?php if($result_datos_meeting['Status'] == 'Completed'){ ?>
											    	<div class="badge badge-light-success">Completed</div>
											  		<?php } else{ ?>
											    	
													<div class="badge badge-light-warning">Schedule</div>
												<?php } ?>
											   </div>
										  </div>
										  

										</div>

										  
									</div>
										 <!-- end::Form Content -->

										 <!--<div class="card-footer">
											<div class="row" style="text-align: center;">
												<div>
													<input type="submit" class="btn btn-sm btn-success m-3" value="Add">
												</div>
											</div>
										</div>-->
										


			                         <!-- Finalizar contenido -->
								</div>
							</div>
							<!--end::Container-->
						</div>
						<!--end::Content-->
						<!--begin::Content-->
						<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
							<!--begin::Container-->
							<div class="container-custom" id="kt_content_container">
								<div class="card card-flush">
		                         <!-- AQUI AÑADIR EL CONTENIDO  -->

									 <!-- begin::Form Content -->
									 <div class="card-body">
									 	<h3>Participant</h3>
									 	<!--begin::Card header-->
										

											<!--begin::Card title-->
											<div class="card-title">
												<!--begin::Search-->
													<div class="d-flex align-items-center position-relative my-1">
														<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
														<span class="svg-icon svg-icon-1 position-absolute ms-6">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
																<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Coordinator" id="termino" name="termino"  />
														<input type="hidden" id="id_meeting" name="id_meeting" value="<?php echo $id_meeting; ?>">
													</div>
													<!--end::Search-->
											</div>
											<!--begin::Card title-->
										
										<!--end::Card header-->
										
										 
										 <div id="custom-section-1">
											 <?php
											 	//Usuarios no seleccionados

											 	$sql_datos_employees = "SELECT Id_employee, Email, Password, First_Name,Last_Name, 	Admin_User From Basic_Employee";
												$result_datos_employees = mysqli_query($con, $sql_datos_employees);

											 	//Usuarios Seleccionado	
											 	$sql_datos_meeting_participant = "SELECT * From Meeting_Participant as mp INNER JOIN Basic_Employee as be WHERE mp.Id_employees = be.Id_employee AND mp.Id_meeting = $id_meeting";
												$conect_datos_meeting_participant = mysqli_query($con, $sql_datos_meeting_participant);
												while ($result_datos_meeting_participant = mysqli_fetch_assoc($conect_datos_meeting_participant)) {
													
											 ?>
													
												<p><?php echo $result_datos_meeting_participant['First_Name'].' '.$result_datos_meeting_participant['Last_Name']; ?></p>
											<?php 
													
												}
											?>
										  </div>
										  <!-- Mostrar datos del buscador -->	
										<div class="table-responsive custom-search-nz" id="result-busqueda">
										</div>

									  
									 </div>
									 <!-- end::Form Content -->

		                         <!-- Finalizar contenido -->
								</div>
							</div>
							<!--end::Container-->
						</div>
						<!--end::Content-->
						<!--begin::Content-->
						<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
							<!--begin::Container-->
							<div class="container-custom" id="kt_content_container">
								<div class="card card-flush">
		                         <!-- AQUI AÑADIR EL CONTENIDO  -->

		                         	
									 
									 <!-- begin::Form Content -->
									 <div class="card-body">
									 	<div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Agenda</h3>
											</div>
											<?php 
												//comprobar que es un coordinador
											 	$consulta_general_coordinator ="SELECT * From Meeting_Co_Ordinator WHERE Id_employee = $id_user";
												$consulta_result_general_coordinator = mysqli_query($con, $consulta_general_coordinator);

												$result_general_coordinator = mysqli_fetch_assoc($consulta_result_general_coordinator);

												$id_coordinator = $result_general_coordinator['Id_meeting_co_ordinator'];

											 	//comprobar que es coordinador del meeting
												$sql_datos_meeting_coordi = "SELECT * From Meeting WHERE Id_meeting = $id_meeting AND Coordinator = $id_coordinator";

												$conect_datos_meeting_coordi = mysqli_query($con, $sql_datos_meeting_coordi);

												$rowcount = mysqli_num_rows($conect_datos_meeting_coordi);

												if($result_datos_meeting['Status'] == 'Schedule' && $rowcount == 1){ 
											?>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMas();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistro();" />
											</div>
											<?php } ?>
										</div>
										 <div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		
											 		<th class='min-w-125px'>What</th>
											 		<th class='min-w-125px'>Who</th>
											 		<th class='min-w-125px'>When</th>
											 		<th class='min-w-125px'>Priority</th>
											 		<th class='min-w-125px'>Status</th>
											 		
											 	</thead>


											 	<tbody class='fw-bold text-gray-600' id="agenda">
											 		<?php
											 			$sql_datos_meeting_agenda = "SELECT * From Meeting_Agenda  WHERE Id_meeting = $id_meeting";

														$conect_datos_meeting_agenda = mysqli_query($con, $sql_datos_meeting_agenda);
														while ($result_datos_meeting_agenda = mysqli_fetch_assoc($conect_datos_meeting_agenda))
														{

											 		 ?>
											 		<tr>
											 			
											 			<td><?php echo $result_datos_meeting_agenda['What'] ?></td>
											 				<td>

											 				<?php
											 					$Id_meeting_employee = $result_datos_meeting_agenda['Id_meeting_co_ordinator'];

											 					$consulta_meeting_who ="SELECT * From Basic_Employee WHERE Id_employee = $Id_meeting_employee";

											 					$conect_datos_meeting_who = mysqli_query($con, $consulta_meeting_who);
											 					
											 					$result_datos_meeting_who = mysqli_fetch_assoc($conect_datos_meeting_who);
											 					echo $result_datos_meeting_who['First_Name'].' '.$result_datos_meeting_who['Last_Name'];
											 				?>
											 				
											 			</td>
											 			<td><?php echo $result_datos_meeting_agenda['Whenm'] ?></td>

											 		
													 	<td><p><?php echo $result_datos_meeting_agenda['Priority'] ?></p></td>
													 	<?php
													 		//User ID Agenda
													 		$id_meeting_agenda = $result_datos_meeting_agenda['Id_meeting_agenda'];
															$sql_datos_user_agenda = "SELECT * From Meeting_Agenda WHERE Id_meeting_co_ordinator = $id_user AND Id_meeting = $id_meeting AND Id_meeting_agenda = $id_meeting_agenda";
															$conect_datos_user_agenda = mysqli_query($con, $sql_datos_user_agenda);
															$rowcount = mysqli_num_rows($conect_datos_user_agenda);

													 		if($rowcount == 1 ){
													 			if($result_datos_meeting_agenda['Status'] == 'Completed' ){
													 	?>
															<td><div class="badge badge-light-success">Completed</div></td>
															
														<?php 	}else{ ?>
																<td><a href="/includes/meeting_agenda_status.php?pg_id=<?php echo $result_datos_meeting_agenda['Id_meeting_agenda']; ?>"><div class="badge badge-light-warning">Schedule</div></a></td>
															<?php } ?>
														<?php }else{
																	if($result_datos_meeting_agenda['Status'] == 'Completed' ){
														?>
																	<td><div class="badge badge-light-success">Completed</div></td>
														<?php 		}else{
														?>
																	<td><div class="badge badge-light-warning">Schedule</div></td>
														<?php
																	}			
															 }
														?>	
													</tr>
													<?php 	
														}
													?>
											 	</tbody>											  
											</table>
										  </div>									  
									 </div>
									 <!-- end::Form Content -->
									 <?php
									 	//comprobar que es un coordinador
									 	$consulta_general_coordinator ="SELECT * From Meeting_Co_Ordinator WHERE Id_employee = $id_user";
										$consulta_result_general_coordinator = mysqli_query($con, $consulta_general_coordinator);

										$result_general_coordinator = mysqli_fetch_assoc($consulta_result_general_coordinator);

										$id_coordinator = $result_general_coordinator['Id_meeting_co_ordinator'];

									 	//comprobar que es coordinador del meeting
										$sql_datos_meeting_coordi = "SELECT * From Meeting WHERE Id_meeting = $id_meeting AND Coordinator = $id_coordinator";

										$conect_datos_meeting_coordi = mysqli_query($con, $sql_datos_meeting_coordi);

										$rowcount = mysqli_num_rows($conect_datos_meeting_coordi);

										
										 if($result_datos_meeting['Status'] == 'Schedule' && $rowcount == 1){ 
									 ?>
									 <div class="card-footer">
										<div class="row" style="text-align: center;">
											<div>
												
												<input type="submit" class="btn btn-lg btn-primary mb-5" value="Update">
												<input type="submit" class="btn btn-lg btn-success mb-5" name="submit_completed"value="Submit">
												
												
											</div>
										</div>
									</div>
									<?php } ?>


		                         <!-- Finalizar contenido -->
								</div>
							</div>
							<!--end::Container-->
						</div>
						<!--end::Content-->
					</form>
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
		<script>

		let start = document.getElementById('start_date');
		start.min = new Date().toISOString().split("T")[0];

		let end = document.getElementById('end_date');
		end.min = new Date().toISOString().split("T")[0];

		function AgregarMas() {
			$("<td>").load("includes/inputs-dinamicos-meeting-update.php", function() {
					$("#agenda").append($(this).html());
			});	
		}
		function BorrarRegistro() {
			$('tr.campos_agenda').each(function(index, item){
				jQuery(':checkbox', this).each(function () {
		            if ($(this).is(':checked')) {
						$(item).remove();
		            }
		        });
			});
		}
		</script>
		<!--end::Javascript-->
		<!-- BUSCADOR SEARCH PARA: Add participant -->
		<script src="JS/buscar-meeting-participant.js"></script>
		<!-- FIN BUSCADOR SEARCH JS -->
		
	</body>
	<!--end::Body-->
</html>