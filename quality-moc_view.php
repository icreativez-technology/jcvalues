<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "MoC Details";

 $sql_data = "SELECT * FROM Quality_MoC WHERE Id_quality_moc = '$_REQUEST[pg_id]'";
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
							<p><a href="/">Home</a> » <a href="/quality-moc.php">Quality MoC</a> » <a href="/quality-moc_view_list.php">Quality MoC List</a> » <?php echo $_SESSION['Page_Title']; ?></p>
								<!-- MIGAS DE PAN -->
						</div>

						<div class="col-lg-6">
							<div class="d-flex justify-content-end">
											<a href="/quality-moc_actions.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">
												<button type="button" class="btn btn-light-primary me-3 topbottons">
													<i class="bi bi-card-checklist"></i> Actions
												</button>
											</a>
											<?php if($result_data['Decision'] == 'Approved'){ ?>

												<?php
															$flag_canseePDF = 0;

															if($result_data['Id_employee'] == $thisemployee){
																$flag_canseePDF = 1;
															}
															else
															{
															/*Comprobar si forma parte de los Team Member O es el On behalf of para ver PDF*/
															$sql_data_TM = "SELECT * FROM Quality_MoC_TeamMembers WHERE Id_quality_moc = '$_REQUEST[pg_id]'";
															$connect_data_TM = mysqli_query($con, $sql_data_TM);
															while ($result_data_moc_tm = mysqli_fetch_assoc($connect_data_TM)) 
																{
																	$sql_user_TM = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_data_moc_tm[Id_employee]'";
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

											<a href="/includes/quality_moc_pdf.php?id_met=<?php echo $_REQUEST['pg_id']; ?>" target="_blank">
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

                         	<form class="form" method="post" enctype="multipart/form-data">
							 <!--<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_quality_moc']; ?>" readonly>-->
							 <!-- begin::Form Content -->
							 <div class="card-body">
							 		<div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h4>MoC <?php echo $_REQUEST['pg_id']; ?></h4>
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
																<input type="text" class="form-control" name="employee" value="<?php echo $result_data_user['First_Name']; ?> <?php echo $result_data_user['Last_Name']; ?>" readonly>
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
															<div class="text-muted fs-7">Original plant is suspended or deleted.</div>
															<?php } ?>
										   </div>
										</div>

									  <div class="form-group row">
									   <div class="col-lg-3">
										    <label>MoC Type</label>
															<?php 
																	$sql_data = "SELECT * FROM Quality_MoC_Type";
																	$connect_data = mysqli_query($con, $sql_data);
																	$flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
																							
																	while ($result_data_moc = mysqli_fetch_assoc($connect_data)) {
																		if($result_data_moc['Status'] == 'Active')
																		{
																			if($result_data_moc['Id_quality_moc_type'] == $result_data['Id_quality_moc_type'])
																			{
																			$flag_active_selected = 1;

																		?>
																		<input type="text" class="form-control" value="<?php echo $result_data_moc['Title']; ?>" readonly>
																		<?php
																			}
																		}
																		}
																		?>
															<?php if($flag_active_selected == 0){ ?>
															<div class="text-muted fs-7">Original MoC Type is suspended or deleted.</div>
															<?php } ?>

										   </div>
									   <div class="col-lg-3">
									    <label>Old MoC Ref#</label>
											<input type="text" class="form-control" name="Old_MoC_Ref" value="<?php echo $result_data['Old_MoC_Ref'];?>" readonly>
									   </div>
									   <div class="col-lg-3">
									    <label>Date</label>
											<input type="date" class="form-control" name="date" value="<?php echo $result_data['Date_date'];?>" readonly>
									   </div>
									   <div class="col-lg-3">
									    <label>Standard / Procedure Reference</label>
											<input type="text" class="form-control" name="reference" value="<?php echo $result_data['Stan_Proc_Ref'];?>" readonly>
									   </div>
									  </div>


									  <div class="form-group row">
									   <div class="col-lg-3">
									    <label>Current State</label>
											<input type="text" class="form-control" name="current_state" value="<?php echo $result_data['Current_State'];?>" readonly>
									   </div>
									   <div class="col-lg-3">
									    <label>Change State</label>
											<input type="text" class="form-control" name="change_state" value="<?php echo $result_data['Change_State'];?>" readonly>
									   </div>
									   <div class="col-lg-3">
										    <label>Risk Assessment</label>

													<?php if ($result_data['Risk_Assessment'] == 'No'){ ?>
																<input type="text" class="form-control" value="Yes" readonly>
																<?php }else{ ?>
																<input type="text" class="form-control" value="No" readonly>													
																<?php } ?>

										</div>
										<div class="col-lg-3">
										    
										    <label>Informed team members:</label>
										    <hr>
										    <?php 
										    		$sql_data = "SELECT * FROM Quality_MoC_TeamMembers WHERE Id_quality_moc = '$_REQUEST[pg_id]'";
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
									  </div>

									  	<div class="form-group row">
										   <div class="col-lg-6">
												<label>Description of Change</label>
													<input type="text" class="form-control" name="description" value="<?php echo $result_data['Description_Change'];?>" readonly>
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
																<td><?php echo date("d-m-y", strtotime($result_data['File_Date'])); ?></td>
																<td class="text-end"><a href="/quality/moc/<?php echo $result_data['File'];?>" target="_blank"><i class="bi bi-box-arrow-down fs-2x text-gray"></i></a></td>
															</tr>
														</tbody>
													</table>
												</div>
										   </div>
										   <?php } ?>
										   
										</div>

										<!--<div class="form-group row">
										   <div class="col-lg-2">
										    <label>Approval Decision</label>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="0" id="kt_modal_update_role_option_0" checked='checked' />
													<label class="form-check-label" for="kt_modal_update_role_option_0">
														Approved
													</label>
												</div>
												<div class="form-check form-check-custom form-check-solid">
													<input class="form-check-input me-3" name="decision" type="radio" value="0" id="kt_modal_update_role_option_1" />
													<label class="form-check-label" for="kt_modal_update_role_option_1">
														Rejected
													</label>
												</div>
											</div>
											<div class="col-lg-10">
										    <label>Decision Remarks</label>
												<input type="text" class="form-control" name="remarks" placeholder="" readonly>
											</div>

										</div>-->

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