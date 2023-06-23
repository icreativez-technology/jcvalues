<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Edit Effectiveness verification";

 $sql_data = "SELECT * FROM NCR_Effectiveness_verification WHERE Id_ncr_effectiveness = '$_REQUEST[pg_id]'";
 $connect_data = mysqli_query($con, $sql_data);
 $result_data = mysqli_fetch_assoc($connect_data);

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
								<p><a href="/">Home</a> » <a href="/ncr.php">NCR</a> » <a href="/ncr_view_list.php">NCR List</a> » <a href="/ncr_view.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">View NCR</a> » <a href="/ncr_verification.php?pg_id=<?php echo $_REQUEST['return_id']; ?>">NCR Effectiveness verification</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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

                         	<form class="form" action="includes/ncr_effectiveness_update_individual.php" method="post" enctype="multipart/form-data">
                         		<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_ncr_effectiveness']; ?>" readonly>
                         		<input type="hidden" name="return_id" id="return_id" value="<?php echo $_REQUEST['return_id']; ?>" readonly>
							 
							 <!-- begin::Form Content -->
							 <div class="card-body">
									 <div id="custom-section-1">
										
									  <div class="form-group row">
									   
									   <div class="col-lg-4">
									    <label>Root cause</label>
											<select class="form-control" name="Id_ncr_why_why" required>	
											<?php
												$sql_datos_ncr_why_why = "SELECT * From NCR_Why_Why WHERE Id_ncr = '$_REQUEST[return_id]'";
												$conect_datos_ncr_why_why = mysqli_query($con, $sql_datos_ncr_why_why);

												while ($result_datos_ncr_why_why = mysqli_fetch_assoc($conect_datos_ncr_why_why))
												{
													if($result_datos_ncr_why_why['Id_ncr_why_why'] == $result_data['Id_ncr_why_why']){
											?>
												<option value="<?php echo $result_datos_ncr_why_why['Id_ncr_why_why']; ?>" selected="selected"><?php echo $result_datos_ncr_why_why['Root_cause']; ?></option>
											<?php
											}else{
										?>
												<option value="<?php echo $result_datos_ncr_why_why['Id_ncr_why_why']; ?>"><?php echo $result_datos_ncr_why_why['Root_cause']; ?></option>
										<?php
											}
										}
										?>
										</select>
									   </div>
									   
									   <div class="col-lg-4">
									    <label>Corrective action</label>
											<input type="text" class="form-control" name="Corrective_action" value="<?php echo $result_data['Corrective_action'];?>" required>
									   </div>

									   <div class="col-lg-4">
									    <label>Who</label>
											<select class="form-control" name="Who_emp" required>
													<?php 
																	$sql_data_user = "SELECT * FROM Basic_Employee";
																	$connect_data_user = mysqli_query($con, $sql_data_user);
																	$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
																							
																	while ($result_data_user = mysqli_fetch_assoc($connect_data_user)) {
																		if($result_data_user['Status'] == 'Active')
																		{
																			if($result_data_user['Id_employee'] == $result_data['Who_emp'])
																			{
																			$flag_active_selected = 1;				
																?>
																		<option value="<?php echo $result_data_user['Id_employee']; ?>" selected="selected"><?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?></option>
																<?php 
																			}
																			else
																			{
																?>
																		<option value="<?php echo $result_data_user['Id_employee']; ?>"><?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?></option>
																<?php
																			}
																		}
																}
																?>
																
												</select>
									   </div>
									   
									  </div>

									  <div class="form-group row">
									   								   
									   <div class="col-lg-4">
									    <label>When</label>
											<input type="date" class="form-control" name="When_date" value="<?php echo $result_data['When_date'];?>" required>
									   </div>

									   <div class="col-lg-4">
									    <label>Verified</label>
											<input type="text" class="form-control" name="Verified" value="<?php echo $result_data['Verified'];?>" required>
									   </div>
									   
									  </div>


							  	</div>
							 </div>
							 <!-- end::Form Content -->


							 <div class="card-footer">
								<div class="row" style="text-align: center;">
									<div>
										<button type="submit" class="btn btn-primary mr-2">Update</button>
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