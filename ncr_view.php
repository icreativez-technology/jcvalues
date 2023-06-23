<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "View NCR";

 $sql_data = "SELECT * FROM NCR WHERE Id_ncr = '$_REQUEST[pg_id]'";
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
					<!-- Breadcrumbs + Actions -->

					<div class="row breadcrumbs">
						<div class="col-lg-6">
							<p><a href="/">Home</a> » <a href="/ncr.php">NCR</a> » <a href="/ncr_view_list.php">NCR List</a> » <?php echo $_SESSION['Page_Title']; ?></p>
								<!-- MIGAS DE PAN -->
						</div>

						<div class="col-lg-6">
							<div class="d-flex justify-content-end">
								<a href="/ncr_analysis_ca.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">
									<button type="button" class="btn btn-light-primary me-3 topbottons">
										Analysis & CA
									</button>
								</a>
								<a href="/ncr_verification.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">
									<button type="button" class="btn btn-light-primary me-3 topbottons">
										Verification
									</button>
								</a>
								<a href="/ncr_mr_approval.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">
									<button type="button" class="btn btn-light-primary me-3 topbottons">
										MR Approval
									</button>
								</a>	
							</div>
						</div>
					</div>

					<!-- End Breadcrumbs + Actions -->
					
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container-custom" id="kt_content_container">
							<div class="card card-flush">
                         <!-- AQUI AÑADIR EL CONTENIDO  -->

                         	<form class="form" method="post" enctype="multipart/form-data">
					 
							 <!-- begin::Form Content -->
							 <div class="card-body">

							 <!-- begin::Section_1 -->
							 <div id="custom-section-1">
							  
							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Date</label>
									<input type="date" class="form-control" name="date_ncr" value="<?php echo $result_data['Date_date'];?>" readonly>
							   </div>
							   <div class="col-lg-3">
							    <label>Plant</label>
									
									<?php 
										$sql_data_plant = "SELECT Id_plant, Title, Status FROM Basic_Plant";
										$connect_data_plant = mysqli_query($con, $sql_data_plant);
																
										while ($result_data_plant = mysqli_fetch_assoc($connect_data_plant)) {
												if($result_data_plant['Id_plant'] == $result_data['Id_plant'])
												{
															
									?>
											<input type="text" class="form-control" value="<?php echo $result_data_plant['Title']; ?>" readonly>
									<?php 
												}
									}
									?>

							   </div>
							   <div class="col-lg-3">
							    <label>Product Group</label>
									
									<?php 
										$sql_data_pg = "SELECT * FROM Basic_Product_Group";
										$connect_data_pg = mysqli_query($con, $sql_data_pg);
																
										while ($result_data_pg = mysqli_fetch_assoc($connect_data_pg)) {

												if($result_data_pg['Id_product_group'] == $result_data['Id_product_group'])
												{															
												?>											
												<input type="text" class="form-control" value="<?php echo $result_data_pg['Title']; ?>" readonly>
												<?php 
												}
											
										}
										?>

							   </div>
							   <div class="col-lg-3">
							    <label>Department</label>
									<?php 
																	$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
																	$connect_data = mysqli_query($con, $sql_data);
																	$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
																							
																	while ($result_data_dep = mysqli_fetch_assoc($connect_data)) {
																			if($result_data_dep['Id_department'] == $result_data['Id_department'])
																			{
																			$flag_active_selected = 1;

																		?>
																		<input type="text" class="form-control" value="<?php echo $result_data_dep['Department']; ?>" readonly>
																		<?php
																			}
																		}
																		?>
							   </div>
							  </div>


							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Process</label>

									<?php 
											$sql_data = "SELECT * FROM NCR_Process_Type";
											$connect_data = mysqli_query($con, $sql_data);
										
											while ($result_data_process = mysqli_fetch_assoc($connect_data)) 
											{
												if($result_data_process['Id_ncr_process_type'] == $result_data['Id_ncr_process_type']){
											?>
												<input type="text" class="form-control" value="<?php echo $result_data_process['Title']; ?>" readonly>
											<?php	
											}
											}
											?>
							   </div>
							   <div class="col-lg-6">
							    <label>NCR Type</label>
											<?php 
											$sql_data = "SELECT * FROM NCR_Non_Conformance_Type";
											$connect_data = mysqli_query($con, $sql_data);
										
											while ($result_data_ncrtype = mysqli_fetch_assoc($connect_data)) 
											{
												if($result_data_ncrtype['Id_ncr_non_conformance_type'] == $result_data['Id_ncr_non_conformance_type']){
											?>
												<input type="text" class="form-control" value="<?php echo $result_data_ncrtype['Title']; ?>" readonly>
											<?php	
											}
											}
											?>
							   </div>
							  </div>
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Non Conformance Details</label>
									<input type="text" class="form-control" value="<?php echo $result_data['Non_conformance_details'];?>" readonly>
							   </div>
							   <div class="col-lg-6">
							    <label>Evidence Details</label>
									<input type="text" class="form-control" name="evidence" value="<?php echo $result_data['Evidence_details'];?>" readonly>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Similar NC in other process/products</label>

										<?php 
										if ($result_data['Similar_nc'] == "No"){
										?>
											<input type="text" class="form-control" name="" value="No" readonly>
										<?php }else{ ?>
											<input type="text" class="form-control" name="" value="Yes" readonly>
										<?php } ?>

							   </div>
							   <div class="col-lg-6">
							    <label>Background</label>
									<input type="text" class="form-control" name="background" value="<?php echo $result_data['Background'];?>" readonly>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-12">
							    <label>Recommended Solution</label>
									<input type="text" class="form-control" name="recommended_solution" value="<?php echo $result_data['Recommended_solution'];?>" readonly>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Assign to Department</label>

									<?php 
									$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
									$connect_data = mysqli_query($con, $sql_data);
															
									while ($result_data_dep = mysqli_fetch_assoc($connect_data)) {

											if($result_data_dep['Id_department'] == $result_data['Assigned_department'])
											{

										?>
										<input type="text" class="form-control" value="<?php echo $result_data_dep['Department']; ?>" readonly>
										<?php
											}
										}
										?>
									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Assign to Owner</label>
													<?php 
																	$sql_data_user = "SELECT * FROM Basic_Employee";
																	$connect_data_user = mysqli_query($con, $sql_data_user);
																							
																	while ($result_data_user = mysqli_fetch_assoc($connect_data_user)) {

																			if($result_data_user['Id_employee'] == $result_data['Assigned_owner'])
																			{		
																?>
																		
																		<input type="text" class="form-control" value="<?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?>" readonly>
																<?php 
																			}
																		
																}
																?>
															
							   </div>
							   <div class="col-lg-6">
									<?php if($result_data['File_name'] != "No file"){ ?>
											<div class="table-responsive">
													<!--begin::Table-->
													<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
														<!--begin::Table head-->
														<thead>
														<!--begin::Table row-->
															<tr class="text-start text-muted text-uppercase gs-0">
																<th class="min-w-150px">File Name</th>
																<th class="min-w-25px">Uploaded on</th>
																<th class="min-w-25px text-end">Action</th>
															</tr>
														</thead>
														<tbody class="text-gray-600 fw-bold">
															<tr>
																<?php     
																$myfile = substr($result_data['File_name'], strpos($result_data['File_name'], "-") + 1);    
																?>
																<td><?php echo $myfile; ?></td>
																<td><?php echo date("d-m-y", strtotime($result_data['File_date'])); ?></td>
																<td class="text-end"><a href="/NCR/<?php echo $result_data['File_name'];?>" target="_blank"><i class="bi bi-box-arrow-down text-gray"></i></a>
															</td>
															</tr>
														</tbody>
													</table>
											</div>
											<input type="file" class="form-control" id="hiddenfile" style="display: none;" name="file_archivo" placeholder="">
											
												<?php } ?>
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
									<input type="text" class="form-control" name="indicative_cause_nc" value="<?php echo $result_data['Analysis_cause'];?>" readonly>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Correction</label>

									<?php 
											$sql_data = "SELECT * FROM NCR_Correction";
											$connect_data = mysqli_query($con, $sql_data);
										
											while ($result_data_correction = mysqli_fetch_assoc($connect_data)) 
											{
												if($result_data_correction['Id_ncr_correction'] == $result_data['Correction']){
											?>
												<input type="text" class="form-control" value="<?php echo $result_data_correction['Title']; ?>" readonly>
											<?php
											}
											}
											?>

							   </div>
							   <div class="col-lg-9">
							    <label>Details of Correction</label>
									<input type="text" class="form-control" name="details_correction" value="<?php echo $result_data['Details_correction'];?>" readonly>
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

											<?php 
											$sql_data = "SELECT * FROM NCR_Disposition";
											$connect_data = mysqli_query($con, $sql_data);
										
											while ($result_data_disposition = mysqli_fetch_assoc($connect_data)) 
											{
												if($result_data_disposition['Id_ncr_disposition'] == $result_data['Disposition']){
											?>
												<input type="text" class="form-control" value="<?php echo $result_data_disposition['Title']; ?>" readonly>
											<?php
											}
											}
											?>
							   </div>
							   <div class="col-lg-9">
							    <label>Details of Disposition</label>
									<input type="text" class="form-control" name="details_disposition" value="<?php echo $result_data['Details_disposition'];?>" readonly>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Customer Approval readonly</label>
									
									<?php 
										if ($result_data['Customer_approval'] == "No"){
										?>
											<input type="text" class="form-control" name="" value="No" readonly>
										<?php }else{ ?>
											<input type="text" class="form-control" name="" value="Yes" readonly>
										<?php } ?>
							   </div>
							   
							   <div class="col-lg-3">
							    <label>Recommended to Design Head Intervention</label>
									<?php 
										if ($result_data['Head_intervention'] == "No"){
										?>
											<input type="text" class="form-control" name="" value="No" readonly>
										<?php }else{ ?>
											<input type="text" class="form-control" name="" value="Yes" readonly>
										<?php } ?>
							   </div>

							   <div class="col-lg-6">
							    <label>Status</label>
										<?php 
										if ($result_data['Status'] == "Completed"){
										?>
											<input type="text" class="form-control" name="" value="Completed" readonly>
										<?php }else{ ?>
											<input type="text" class="form-control" name="" value="Scheduled" readonly>
										<?php } ?>

							   </div>

							</div>
							</div>
							<!-- end::Section_3 -->
					  
							  

							  
							 </div>
							 <!-- end::Form Content -->
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
		<script type="text/javascript">
			function changefile(){
				var actual = document.getElementById("hiddenfile").style.display;
				if(actual == "none"){
					document.getElementById("hiddenfile").style.display = "block";
				}
				else{
					document.getElementById("hiddenfile").style.display = "none";
				}
			}

		</script>
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>