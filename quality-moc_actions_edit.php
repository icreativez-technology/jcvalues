<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Edit Action";

 $sql_data = "SELECT * FROM Quality_MoC_Action WHERE Id_quality_moc_action = '$_REQUEST[pg_id]'";
 $connect_data = mysqli_query($con, $sql_data);
 $result_data = mysqli_fetch_assoc($connect_data);

  /*Para comprobar el usuario y que pueda editar o no*/
$email = $_SESSION['usuario'];
$sql_datos_usuario = "SELECT * From Basic_Employee Where Email = '$email'";
$result_datos_usuario = mysqli_query($con, $sql_datos_usuario);
$conectado = mysqli_fetch_assoc($result_datos_usuario);

$thisemployee = $conectado['Id_employee'];
$rol_user_check = $conectado['Admin_User'];

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
						<div>
							<!--begin::Title-->
							<div>
								<p><a href="/">Home</a> » <a href="/quality-moc.php">Quality MoC</a> » <a href="/quality-moc_actions.php?pg_id=<?php echo $_REQUEST['return_id']; ?>">MoC Actions</a> » <?php echo $_SESSION['Page_Title']; ?></p>
								<!-- MIGAS DE PAN -->
							</div>
						</div>
						<!--end::body-->
					</div>
					<!--end::BREADCRUMBS-->
					
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container-custom" id="kt_content_container">
							<div class="card card-flush">
                         <!-- AQUI AÑADIR EL CONTENIDO  -->

                         	<form class="form" action="includes/quality-moc_actions_individual_update.php" method="post" enctype="multipart/form-data">
                         		<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_quality_moc_action']; ?>" readonly>
                         		<input type="hidden" name="return_id" id="return_id" value="<?php echo $_REQUEST['return_id']; ?>" readonly>
                         		<input type="hidden" name="Sno" value="0" readonly>
							 
							 <!-- begin::Form Content -->
							 <div class="card-body">
									 <div id="custom-section-1">
										
									  <div class="form-group row">
									   
									   <div class="col-lg-4">
									    <label>Action Point</label>
											<input type="text" class="form-control" name="Action_point" value="<?php echo $result_data['Action_point'];?>" required>
									   </div>
									   <div class="col-lg-4">
									    <label>Who</label>
											<select class="form-control" name="Id_employee" required>
																<?php 
																	$sql_data_plant = "SELECT * FROM Basic_Employee WHERE Status = 'Active'";
																	$connect_data_plant = mysqli_query($con, $sql_data_plant);
																	$flag_active_selected = 0;
																							
																	while ($result_data_plant = mysqli_fetch_assoc($connect_data_plant)) {
																		
																		/*Seleccionar solo Team Informed members*/
																   		$sql_data2 = "SELECT * FROM Quality_MoC_TeamMembers WHERE Id_quality_moc = '$_REQUEST[return_id]'";
																		$connect_data6 = mysqli_query($con, $sql_data2);

																		$flag_teamaction = 0;
			
																		while ($result_data2_moc_tm = mysqli_fetch_assoc($connect_data6)) 
																		{
																			if($result_data2_moc_tm['Id_employee'] == $result_data_plant['Id_employee'])
																			{
																				$flag_teamaction = 1;
																				$count++;

																			}
																		}
																		


																		if($flag_teamaction == 1)
																		{
																			if($result_data_plant['Id_employee'] == $result_data['Id_employee'])
																			{
																			$flag_active_selected = 1;				
																			?>
																		<option value="<?php echo $result_data_plant['Id_employee']; ?>" selected="selected"><?php echo $result_data_plant['First_Name']; ?> <?php echo $result_data_plant['Last_Name']; ?></option>
																			<?php 
																			}
																			else
																			{
																			?>
																		<option value="<?php echo $result_data_plant['Id_employee']; ?>"><?php echo $result_data_plant['First_Name']; ?> <?php echo $result_data_plant['Last_Name']; ?></option>
																			<?php
																			}
																		}
																}
																?>
															</select>
															<?php if($flag_active_selected == 0){ ?>
															<div class="text-muted fs-7">Original employee is not a Team Member anymore.</div>
															<?php } ?>
									   </div>
									   <div class="col-lg-4">
									    <label>When</label>
											<input type="date" class="form-control" name="Date_date" value="<?php echo $result_data['Date_date'];?>" required>
									   </div>
									  </div>
									  <div class="form-group row">
									   
									   
									   <div class="col-lg-4">
									    <label>Verified</label>
											<select class="form-control" name="Verified" required>
											<?php 
																	$sql_data_verified = "SELECT * FROM Basic_Employee";
																	$connect_data_verified = mysqli_query($con, $sql_data_verified);
																	$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
																							
																	while ($result_data_verified = mysqli_fetch_assoc($connect_data_verified)) {
																		if($result_data_verified['Status'] == 'Active')
																		{
																			if($result_data_verified['Id_employee'] == $result_data['Verified'])
																			{
																			$flag_active_selected = 1;				
																?>
																		<option value="<?php echo $result_data_verified['Id_employee']; ?>" selected="selected"><?php echo $result_data_verified['First_Name']; ?> <?php echo $result_data_verified['Last_Name']; ?></option>
																<?php 
																			}
																			else
																			{
																?>
																		<option value="<?php echo $result_data_verified['Id_employee']; ?>"><?php echo $result_data_verified['First_Name']; ?> <?php echo $result_data_verified['Last_Name']; ?></option>
																<?php
																			}
																		}
																}
																?>
															</select>
									   </div>
									   <div class="col-lg-4">
									    <label>Status</label>
											<input type="number" class="form-control" name="Status" min="0" max="100" value="<?php echo $result_data['Status'];?>" required>
									   </div>
									   
									  </div>


							  	</div>
							 </div>
							 <!-- end::Form Content -->


							 <div class="card-footer">
								<div class="row" style="text-align: center;">
									<div>
										<?php if($result_data['Id_employee'] == $thisemployee OR $rol_user_check == 'Superadministrator'){ ?>
											<button type="submit" class="btn btn-primary mr-2">Update</button>
										<?php } ?>
									</div>
								</div>
							</div>
							</form>


                         <!-- Finalizar contenido -->
						</div>
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