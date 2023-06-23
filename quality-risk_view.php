<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "View Risk Assesment";

 $sql_data = "SELECT * FROM Quality_Risk WHERE Id_quality_risk = '$_REQUEST[pg_id]'";
 $connect_data = mysqli_query($con, $sql_data);
 $result_data = mysqli_fetch_assoc($connect_data);

   /*Para comprobar el usuario y que pueda editar o no*/
$email = $_SESSION['usuario'];
$sql_datos_usuario = "SELECT * From Basic_Employee Where Email = '$email'";
$result_datos_usuario = mysqli_query($con, $sql_datos_usuario);
$conectado = mysqli_fetch_assoc($result_datos_usuario);

$thisemployee = $conectado['Id_employee'];
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
							<p><a href="/">Home</a> » <a href="/quality-risk.php">Risk Assesment</a> » <a href="/quality-risk_view_list.php">Risk Assesment List</a> » <?php echo $_SESSION['Page_Title']; ?></p>
								<!-- MIGAS DE PAN -->
						</div>

						<div class="col-lg-6">
							<div class="d-flex justify-content-end">
											<?php if($result_data['Decision'] == 'Approved'){ ?>

												<?php
															$flag_canseePDF = 0;

															if($result_data['Id_employee'] == $thisemployee){
																$flag_canseePDF = 1;
															}
															else
															{
															/*Comprobar si forma parte de los Team Member O es el On behalf of para ver PDF*/
															$sql_data_TM = "SELECT * FROM Quality_Risk_TeamMembers WHERE Id_quality_risk = '$_REQUEST[pg_id]'";
															$connect_data_TM = mysqli_query($con, $sql_data_TM);
															while ($result_data_risk_tm = mysqli_fetch_assoc($connect_data_TM)) 
																{
																	$sql_user_TM = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_data_risk_tm[Id_employee]'";
																	$connect_user_TM = mysqli_query($con, $sql_user_TM);
																	$result_user_TM = mysqli_fetch_assoc($connect_user_TM);

																	if($result_user_TM['Id_employee'] == $thisemployee)
																	{
																	$flag_canseePDF = 1;
																	}
																}
															}

															?>
															<?php 
															if($flag_canseePDF == 1)
															{
															?>
														<a href="/includes/quality_risk_pdf.php?id_met=<?php echo $_REQUEST['pg_id']; ?>" target="_blank">
															<button type="button" class="btn btn-light-primary me-3 topbottons">
															  <i class="bi bi-file-earmark-pdf"></i> Create PDF
															</button>
														</a>
													<?php } ?>	



											<?php } ?>			
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

                         	<form class="form">
							 	<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_quality_risk']; ?>" readonly>
							 <!-- begin::Form Content -->
							 <div class="card-body">
							 		<div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h4>Risk <?php echo $_REQUEST['pg_id']; ?></h4>
											</div>
										</div>
									 <div id="custom-section-1">
										<div class="form-group row">
										   <div class="col-lg-3">
										    <label>On Behalf of</label>

													<?php 
																	$sql_data_user = "SELECT * FROM Basic_Employee";
																	$connect_data_user = mysqli_query($con, $sql_data_user);
																	$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
																							
																	while ($result_data_user = mysqli_fetch_assoc($connect_data_user)) {
																		if($result_data_user['Status'] == 'Active')
																		{
																			if($result_data_user['Id_employee'] == $result_data['Id_employee'])
																			{
																			$flag_active_selected = 1;				
																?>
																		<input type="text" class="form-control" value="<?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?>" readonly>
																<?php 
																			}																			
																		}
																}
																?>
												<?php if($flag_active_selected == 0){ ?>
															<div class="text-muted fs-7">Original user is suspended or deleted.</div>
															<?php } ?>
										   </div>
										   <div class="col-lg-3">
										    <label>Plant</label>

																<?php 
																	$sql_data_plant = "SELECT Id_plant, Title, Status FROM Basic_Plant";
																	$connect_data_plant = mysqli_query($con, $sql_data_plant);
																	$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
																							
																	while ($result_data_plant = mysqli_fetch_assoc($connect_data_plant)) {
																		if($result_data_plant['Status'] == 'Active')
																		{
																			if($result_data_plant['Id_plant'] == $result_data['Id_plant'])
																			{
																			$flag_active_selected = 1;				
																?>
																		<input type="text" class="form-control" value="<?php echo $result_data_plant['Title']; ?>" readonly>
																<?php 
																			}
																		}
																}
																?>
															<?php if($flag_active_selected == 0){ ?>
															<div class="text-muted fs-7">Original plant is suspended or deleted.</div>
															<?php } ?>
										   </div>
										   <div class="col-lg-3">
										    <label>Product Group</label>
												
															<?php 
																	$sql_data_pg = "SELECT * FROM Basic_Product_Group";
																	$connect_data_pg = mysqli_query($con, $sql_data_pg);
																	$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
																							
																	while ($result_data_pg = mysqli_fetch_assoc($connect_data_pg)) {
																		if($result_data_pg['Status'] == 'Active')
																		{
																			if($result_data_pg['Id_product_group'] == $result_data['Id_product_group'])
																			{
																			$flag_active_selected = 1;				
																			?>
																			<input type="text" class="form-control" value="<?php echo $result_data_pg['Title']; ?>" readonly>
																			<?php 
																			}

																		}
																}
																?>

															<?php if($flag_active_selected == 0){ ?>
															<div class="text-muted fs-7">Original product group is suspended or deleted.</div>
															<?php } ?>



										   </div>
										   <div class="col-lg-3">
										    <label>Department</label>
																<?php 
																	$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
																	$connect_data = mysqli_query($con, $sql_data);
																	$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
																							
																	while ($result_data_dep = mysqli_fetch_assoc($connect_data)) {
																		if($result_data_dep['Status'] == 'Active')
																		{
																			if($result_data_dep['Id_department'] == $result_data['Id_department'])
																			{
																			$flag_active_selected = 1;

																		?>
																		<input type="text" class="form-control" value="<?php echo $result_data_dep['Department']; ?>" readonly>
																		<?php
																			}
																		}
																		}
																		?>
															<?php if($flag_active_selected == 0){ ?>
															<div class="text-muted fs-7">Original department is suspended or deleted.</div>
															<?php } ?>
										   </div>
										</div>

									  <div class="form-group row">
									   <div class="col-lg-3">
										    <label>Impact</label><br>
													<h5 class="impact-<?php echo $result_data['Impact']; ?>"><i class="bi bi-circle-fill impact-<?php echo $result_data['Impact']; ?>"></i> <?php echo $result_data['Impact']; ?></h5>
										   </div>
									   <div class="col-lg-3">
										    <label>Assessment</label><br>
													<h5><?php echo $result_data['Assessment']; ?> %</h5>	
										   </div>
									   <div class="col-lg-3">
									    <label>Status</label><br>
											<h5 class="status-<?php echo $result_data['Status']; ?>"><i class="bi bi-circle-fill status-<?php echo $result_data['Status']; ?>"></i> <?php echo $result_data['Status']; ?></h5>
									   </div>
									   <div class="col-lg-3">
									    <label>Date</label><br>
											<h5><?php echo date("d-m-y", strtotime($result_data['Date_date'])); ?></h5>
									   </div>
									  </div>

									  <div class="form-group row">
									  	<div class="col-lg-6">
									  	<label>Details</label>
									  		<textarea class="form-control" id="details" name="details" rows="8" readonly><?php echo $result_data['Details'];?></textarea>
									  	</div>
									  	<div class="col-lg-6">
									  	<label>Mitigation Plan</label>
									  		<textarea class="form-control" id="mitigation_plan" name="mitigation_plan" rows="8" readonly><?php echo $result_data['Mitigation_plan'];?></textarea>
									  	</div>
									  </div>


									  <div class="form-group row">
										<div class="col-lg-6">
										    <label>Informed team members:</label>
										    <hr>
										    <?php 
										    		$sql_data = "SELECT * FROM Quality_Risk_TeamMembers WHERE Id_quality_risk = '$_REQUEST[pg_id]'";
													$connect_data = mysqli_query($con, $sql_data);
																							
													while ($result_data_moc_tm = mysqli_fetch_assoc($connect_data)) 
													{
														$sql_user = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_data_moc_tm[Id_employee]'";
														$connect_user = mysqli_query($con, $sql_user);
														$result_user = mysqli_fetch_assoc($connect_user);

														echo $result_user['First_Name'].' '.$result_user['Last_Name'].' - '.$result_user['Email'];
														echo '<br>';
													}
										    ?>
										</div>
										<?php if($result_data['File'] != "No file"){ ?>
										<div class="col-lg-6">
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
																$myfile = substr($result_data['File'], strpos($result_data['File'], "-") + 1);    
																?>
																<td><?php echo $myfile; ?></td>
																<td><?php echo date("d-m-y", strtotime($result_data['File_date'])); ?></td>
																<td class="text-end"><a href="/quality/risk/<?php echo $result_data['File'];?>" target="_blank"><i class="bi bi-box-arrow-down fs-2x text-gray"></i></a></td>
															</tr>
														</tbody>
													</table>
											</div>
										</div>
									  <?php } ?>
									  </div>

							  	</div>
							 </div>
							 <!-- end::Form Content -->

							</form>


                         <!-- Finalizar contenido -->
						</div>
						</div>
						<!--end::Container-->
					</div>
					<!--end::Content-->




									<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
						<!--begin::Container-->
						<div class="container-custom" id="kt_content_container">
                        <!-- AQUI AÑADIR EL CONTENIDO  -->
				
						
							<div class="card card-flush">
                         		<div class="container-full customer-header">
									 		Approval
									 	</div>
                         	<form class="form" action="includes/quality-risk_update_approval.php" method="post" enctype="multipart/form-data">
							 <input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_quality_risk']; ?>" readonly>
							 <!-- begin::Form Content -->
							 <div class="card-body">

									 <div id="custom-section-1">
									 	
										<div class="form-group row">
										   <div class="col-lg-2">
										    <label>Decision</label>
											<?php if($result_data['Decision'] == 'Approved'){ ?>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Approved" id="kt_modal_update_role_option_0" checked='checked' />
													<label class="form-check-label" for="kt_modal_update_role_option_0">
														Approved
													</label>
												</div>
											</div>
											<?php 
											}
											?>

											<?php if($result_data['Decision'] == 'Open'){
											?>

												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Approved" id="kt_modal_update_role_option_0" />
													<label class="form-check-label" for="kt_modal_update_role_option_0">
														Approved
													</label>
												</div>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Open" id="kt_modal_update_role_option_2" checked='checked'/>
													<label class="form-check-label" for="kt_modal_update_role_option_2">
														Open
													</label>
												</div>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Rejected" id="kt_modal_update_role_option_1"/>
													<label class="form-check-label" for="kt_modal_update_role_option_1">
														Rejected
													</label>
												</div>
											</div>
											<?php 
											}
											?>

											<?php if($result_data['Decision'] == 'Rejected'){
											?>

												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Approved" id="kt_modal_update_role_option_0" />
													<label class="form-check-label" for="kt_modal_update_role_option_0">
														Approved
													</label>
												</div>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="Rejected" id="kt_modal_update_role_option_1" checked='checked'/>
													<label class="form-check-label" for="kt_modal_update_role_option_1">
														Rejected
													</label>
												</div>
											</div>
											<?php 
											}
											?>

											<div class="col-lg-10">
										    <label>Decision Remarks</label>
										    <?php if($result_data['Id_employee'] == $thisemployee && $result_data['Decision'] == 'Open'){ ?>
												<input type="text" class="form-control" name="remarks" value="<?php echo $result_data['Decision_Remarks'];?>">
												<?php }else{ ?>
												<input type="text" class="form-control" name="remarks" value="<?php echo $result_data['Decision_Remarks'];?>" readonly>
												<?php }?>
											</div>

										</div>

							  	</div>
							 </div>
							 <?php if($result_data['Decision'] != 'Approved'){ ?>
							 <div class="card-footer">
								<div class="row" style="text-align: center;">
									<div>
										<?php if($result_data['Id_employee'] == $thisemployee){ ?>
										<button type="submit" class="btn btn-primary mr-2">Update decision</button>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php } ?>


							</form>
						</div>


                         <!-- Finalizar contenido -->
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
		<script>
		/*function CalculaRPN() {
			//var TotalRpn = 0;
			var Severity = $("input[type=radio][name=severity]").filter(":checked")[0];
	        if (Severity) {
	        	if(Severity.value != 0)
	        	{
	        	var FirstRpn = Severity.value;
	        	}
	        	else
	        	{
	        	var FirstRpn = 1;
	        	}
	            
	        }

	        var Occurance = $("input[type=radio][name=occurance]").filter(":checked")[0];
	        if (Occurance) {
	        	if(Occurance.value != 0)
	        	{
	        	var SecondRpn = FirstRpn * Occurance.value;
	        	}else{
	        		var SecondRpn = FirstRpn;
	        	}          
	        }


	        var Detection = $("input[type=radio][name=detection]").filter(":checked")[0];
	        if (Detection) {
	        	if(Detection.value != 0)
	        	{
	        	var TotalRpn = SecondRpn * Detection.value;
	        	}else{
	        	var TotalRpn = SecondRpn;
	        	}          
	        }
	        if(TotalRpn == 1){
	        	TotalRpn = 0;
	        }

			document.getElementById("rpn_value").value = TotalRpn;
		
		}*/
		</script>
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>