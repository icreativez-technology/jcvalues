<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "New NCR";
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
								<p><a href="/">Home</a> » <a href="/ncr.php">NCR</a> » <a href="/ncr_view_list.php">NCR List</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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

                         	<form class="form" action="includes/ncr_add_form.php" method="post" enctype="multipart/form-data">

                         		<?php 

                         		
								// Extraer datos del usuario
								if($_SESSION['usuario']){
									$email = $_SESSION['usuario'];
									$sql_datos_usuario = "SELECT * From Basic_Employee Where Email = '$email'";
									$result_datos_usuario = mysqli_query($con, $sql_datos_usuario);
									$dt = mysqli_fetch_assoc($result_datos_usuario);
									
                         		?>
                         			<input type="hidden" name="created_by" id="created_by" value="<?php echo $dt['Id_employee']; ?>" readonly>
                         		<?php 
                         		}
                         		else{
                         			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
                         			echo "<h3 style='color: red;'>".$msg."</h3>";
                         		}

                         		?>

							 
							 <!-- begin::Form Content -->
							 <div class="card-body">

							 <!-- begin::Section_1 -->
							 <div id="custom-section-1">
							  
							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Date</label>
									<input type="date" class="form-control" name="date_ncr" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Plant</label>
									<select class="form-control" name="plant" required>
									<?php 
										$sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
										$connect_data = mysqli_query($con, $sql_data);
																
										while ($result_data = mysqli_fetch_assoc($connect_data)) {
											if($result_data['Status'] == 'Active')
											{						
									?>
											<option value="<?php echo $result_data['Id_plant']; ?>"><?php echo $result_data['Title']; ?></option>
									<?php
											}
									}
									?>

									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Product Group</label>
									<select class="form-control" name="product_group" required>
									<?php 
										$sql_data = "SELECT * FROM Basic_Product_Group";
										$connect_data = mysqli_query($con, $sql_data);
																
										while ($result_data = mysqli_fetch_assoc($connect_data)) {
											if($result_data['Status'] == 'Active')
											{						
									?>
											<option value="<?php echo $result_data['Id_product_group']; ?>"><?php echo $result_data['Title']; ?></option>
									<?php
											}
									}
									?>

									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Department</label>
									<select class="form-control" name="department" required>
									<?php 
										$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
										$connect_data = mysqli_query($con, $sql_data);
																
										while ($result_data = mysqli_fetch_assoc($connect_data)) {
											if($result_data['Status'] == 'Active')
											{						
									?>
											<option value="<?php echo $result_data['Id_department']; ?>"><?php echo $result_data['Department']; ?></option>
									<?php
											}
									}
									?>
									</select>
							   </div>
							  </div>


							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Process</label>
									<select class="form-control" name="process" required>
									<?php 
											$sql_data = "SELECT * FROM NCR_Process_Type";
											$connect_data = mysqli_query($con, $sql_data);
										
											while ($result_data = mysqli_fetch_assoc($connect_data)) 
											{
											?>
												<option value="<?php echo $result_data['Id_ncr_process_type']; ?>"><?php echo $result_data['Title']; ?></option>
											<?php	
											}
											?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>NCR Type</label>
									<select class="form-control" name="type" required>
									<?php 
											$sql_data = "SELECT * FROM NCR_Non_Conformance_Type";
											$connect_data = mysqli_query($con, $sql_data);
										
											while ($result_data = mysqli_fetch_assoc($connect_data)) 
											{
											?>
												<option value="<?php echo $result_data['Id_ncr_non_conformance_type']; ?>"><?php echo $result_data['Title']; ?></option>
											<?php	
											}
											?>
									</select>
							   </div>
							  </div>
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Non Conformance Details</label>
									<input type="text" class="form-control" name="non_conformance_details" placeholder="" required>
							   </div>
							   <div class="col-lg-6">
							    <label>Evidence Details</label>
									<input type="text" class="form-control" name="evidence" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Similar NC in other process/products</label>
									<select class="form-control" name="similarity" required>
										<option>No</option>
										<option>Yes</option>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Background</label>
									<input type="text" class="form-control" name="background" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-12">
							    <label>Recommended Solution</label>
									<input type="text" class="form-control" name="recommended_solution" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Assign to Department</label>
									<select class="form-control" name="department_assigned" required>
									<?php 
										$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
										$connect_data = mysqli_query($con, $sql_data);
																
										while ($result_data = mysqli_fetch_assoc($connect_data)) {
											if($result_data['Status'] == 'Active')
											{						
									?>
											<option value="<?php echo $result_data['Id_department']; ?>"><?php echo $result_data['Department']; ?></option>
									<?php
											}
									}
									?>
									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Assign to Owner</label>
									<select class="form-control" name="owner_assigned" required>
													<?php 
														$sql_data = "SELECT * FROM Basic_Employee";
														$connect_data = mysqli_query($con, $sql_data);
																								
														while($result_data = mysqli_fetch_assoc($connect_data)) 
														{
														/*only print active users*/
														if($result_data['Status'] == 'Active')
														{						
														?>
															<option value="<?php echo $result_data['Id_employee']; ?>"><?php echo $result_data['First_Name']; ?> <?php echo $result_data['Last_Name']; ?></option>
														<?php
														}
														}
													?>
																
												</select>
							   </div>
							   <div class="col-lg-6">
							    <label>File uploaded</label>
									<input type="file" class="form-control" name="file_archivo" placeholder="">
							   </div>
							  </div>
							  

							  </div>
							  <!-- end::Section_1 -->


							  <!-- begin::Section_2 -->
							 <div id="custom-section-2">
							 	<div class="container-full customer-header margincustom-complaint">
							 		Correction
							 	</div>

							  <div class="form-group row">
							   <div class="col-lg-12">
							    <label>Indicative Cause of Non Conformance</label>
									<input type="text" class="form-control" name="indicative_cause_nc" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Correction</label>
									<select class="form-control" name="correction" required>
									<?php 
											$sql_data = "SELECT * FROM NCR_Correction";
											$connect_data = mysqli_query($con, $sql_data);
										
											while ($result_data = mysqli_fetch_assoc($connect_data)) 
											{
											?>
												<option value="<?php echo $result_data['Id_ncr_correction']; ?>"><?php echo $result_data['Title']; ?></option>
											<?php	
											}
											?>
									</select>
							   </div>
							   <div class="col-lg-9">
							    <label>Details of Correction</label>
									<input type="text" class="form-control" name="details_correction" placeholder="" required>
							   </div>
							  </div>
							  
							  
							  </div>
							  <!-- end::Section_2 -->


							  <!-- begin::Section_3 -->
							 <div id="custom-section-3">
							 	<div class="container-full customer-header margincustom-complaint">
							 		Disposition
							 	</div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Disposition</label>
									<select class="form-control" name="disposition" required>
									<?php 
											$sql_data = "SELECT * FROM NCR_Disposition";
											$connect_data = mysqli_query($con, $sql_data);
										
											while ($result_data = mysqli_fetch_assoc($connect_data)) 
											{
											?>
												<option value="<?php echo $result_data['Id_ncr_disposition']; ?>"><?php echo $result_data['Title']; ?></option>
											<?php	
											}
											?>
									</select>
							   </div>
							   <div class="col-lg-9">
							    <label>Details of Disposition</label>
									<input type="text" class="form-control" name="details_disposition" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Customer Approval Required</label>
									<select class="form-control" name="customer_approval" required>
										<option>No</option>
										<option>Yes</option>
									</select>
							   </div>
							   
							   <div class="col-lg-3">
							    <label>Recommended to Design Head Intervention</label>
									<select class="form-control" name="head_intervention" required>
										<option>No</option>
										<option>Yes</option>
									</select>
							   </div>

							</div>
							</div>
							<!-- end::Section_3 -->
					  
							  

							  
							 </div>
							 <!-- end::Form Content -->

							 <div class="card-footer">
								<div class="row" style="text-align: center;">
									<div>
										<button type="submit" class="btn btn-primary mr-2">Submit</button>
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