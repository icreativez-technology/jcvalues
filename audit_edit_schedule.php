<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Edit Audit";
$id_audit = $_REQUEST['audit_id'];

$consulta_audit_view = "SELECT * FROM Audit_Management WHERE Id_audit_management = $id_audit";
$consulta_general_audit_view = mysqli_query($con, $consulta_audit_view);
$result_audit_view = mysqli_fetch_assoc($consulta_general_audit_view)
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
								<p><a href="/">Home</a> » <a href="/audit.php">Audit</a> » <?php echo $_SESSION['Page_Title'];?></p>
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

                         	<form class="form" method="post" action="includes/audit_add_schedule_update.php" enctype="multipart/form-data">
							 
							 <!-- begin::Form Content -->
							 <div class="card-body">
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Plant</label>
									<select class="form-control" name="plant" required>
										<option value="">Choose plant</option>
										<?php 

											$id_plant = $result_audit_view['Id_basic_plant'];

											$consulta_plant ="SELECT * FROM Basic_Plant WHERE Status LIKE 'Active'";
											$consulta_general_plant = mysqli_query($con, $consulta_plant);

											while($result_plant = mysqli_fetch_assoc($consulta_general_plant)){

											if($result_plant['Id_plant'] == $id_plant){


										?>
										<option value="<?php  echo $result_plant['Id_plant']; ?>" selected><?php  echo $result_plant['Title']; ?></option>
										<?php 
											}else{
										?>	
										<option value="<?php  echo $result_plant['Id_plant']; ?>" ><?php  echo $result_plant['Title']; ?></option>	
										<?php
											}
										}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Auditee</label>
									<select class="form-control" name="auditee" required>
										<option value="">Choose Auditee</option>
										<?php 
											$consulta_audit_auditee ="SELECT * FROM Basic_Employee WHERE Status LIKE 'Active'";
											$consulta_general_audit_auditee = mysqli_query($con, $consulta_audit_auditee);
											while($result_audit_auditee = mysqli_fetch_assoc($consulta_general_audit_auditee)){
												if($result_audit_auditee['Id_employee'] == $result_audit_view['Id_employee_auditee']){
										?>
										<option value="<?php  echo $result_audit_auditee['Id_employee']; ?>" selected><?php  echo $result_audit_auditee['First_Name'].' '.$result_audit_auditee['Last_Name']; ?></option>
										<?php 
											}else{

										?>
										<option value="<?php  echo $result_audit_auditee['Id_employee']; ?>"><?php  echo $result_audit_auditee['First_Name'].' '.$result_audit_auditee['Last_Name']; ?></option>
										<?php		
											}
										}
										?>
									</select>
							   </div>
							  </div>
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Product Group</label>
									<select class="form-control" name="product_group" required>
										<option value="">Choose Product Group</option>
										<?php 
											$consulta_product_group ="SELECT * FROM Basic_Product_Group WHERE Status LIKE 'Active'";
											$consulta_general_product_group = mysqli_query($con, $consulta_product_group);
											while($result_product_group = mysqli_fetch_assoc($consulta_general_product_group)){
												if($result_product_group['Id_product_group'] == $result_audit_view['Id_basic_product_group']){

										?>
										<option value="<?php  echo $result_product_group['Id_product_group']; ?>" selected><?php  echo $result_product_group['Title']; ?></option>
										<?php
												}else{

										?>
										<option value="<?php  echo $result_product_group['Id_product_group']; ?>"><?php  echo $result_product_group['Title']; ?></option>
										<?php			
												}
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Audit Schedule Date</label>
							     <input type="date" class="form-control" value="<?php echo $result_audit_view['Audit_schedule_date'];?>" name="audit_schedule_date"/>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Type of Audit</label>
									<select class="form-control" name="type_audit" required>
										<option value="">Choose Type of Audit</option>
										<?php 
											$consulta_type_of_audit ="SELECT * FROM Audit_Type_Of WHERE Status LIKE 'Active'";
											$consulta_general_type_of_audit = mysqli_query($con, $consulta_type_of_audit);
											while($result_type_of_audit = mysqli_fetch_assoc($consulta_general_type_of_audit)){
												if($result_type_of_audit['Id_type_of_audit'] == $result_audit_view['Id_type_of_audit']){ 

										?>
										<option value="<?php  echo $result_type_of_audit['Id_type_of_audit']; ?>"selected><?php  echo $result_type_of_audit['Title']; ?></option>
										<?php 
												}else{

										?>
										<option value="<?php  echo $result_type_of_audit['Id_type_of_audit']; ?>"><?php  echo $result_type_of_audit['Title']; ?></option>
										<?php			
												}
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    
								<label>Department</label>
									<select class="form-control" name="department" required>
										<option value="">Choose Department</option>
										<?php 
											$consulta_deparment ="SELECT * FROM Basic_Department WHERE Status LIKE 'Active'";
											$consulta_general_deparment = mysqli_query($con, $consulta_deparment);
											while($result_deparment = mysqli_fetch_assoc($consulta_general_deparment)){
												if($result_deparment['Id_department'] == $result_audit_view['Id_basic_department']){

										?>
										<option value="<?php  echo $result_deparment['Id_department']; ?>" selected><?php  echo $result_deparment['Department']; ?></option>
										<?php
												}else{
										?>
										<option value="<?php  echo $result_deparment['Id_department']; ?>"><?php  echo $result_deparment['Department']; ?></option>
										<?php
												}
											}
										?>
									</select>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Audit Standard</label>
									<select class="form-control" name="audit_standard" required>
										<option value="">Choose Audit Standard</option>
										<?php 
											$consulta_audit_standard ="SELECT * FROM Audit_Standard WHERE Status LIKE 'Active'";
											$consulta_general_audit_standard = mysqli_query($con, $consulta_audit_standard);
											while($result_audit_standard = mysqli_fetch_assoc($consulta_general_audit_standard)){
												if($result_audit_standard['Id_audit_standard'] == $result_audit_view['Id_audit_standard']){

										?>
										<option value="<?php  echo $result_audit_standard['Id_audit_standard']; ?>" selected><?php  echo $result_audit_standard['Title']; ?></option>
										<?php
												}else{
										?>
										<option value="<?php  echo $result_audit_standard['Id_audit_standard']; ?>"><?php  echo $result_audit_standard['Title']; ?></option>
										<?php			
												}
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    
									<label>Audit Check List Format No</label>
									<input type="text" class="form-control" name="format_no" value="<?php echo $result_audit_view['Audit_check_list_format_no'] ?>" placeholder="<?php echo $result_audit_view['Audit_check_list_format_no'] ?>" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Auditor</label>
									<select class="form-control" name="auditor" required>
										<option value="">Choose Auditor</option>
										<?php 
											$consulta_audit_auditor ="SELECT * FROM Basic_Employee WHERE Status LIKE 'Active'";
											$consulta_general_audit_auditor = mysqli_query($con, $consulta_audit_auditor);
											while($result_audit_auditor = mysqli_fetch_assoc($consulta_general_audit_auditor)){
												if($result_audit_auditor['Id_employee'] == $result_audit_view['Id_employee_auditor']){
										?>
										<option value="<?php  echo $result_audit_auditor['Id_employee']; ?>" selected><?php  echo $result_audit_auditor['First_Name'].' '.$result_audit_auditor['Last_Name']; ?></option>
										<?php 
											}else{

										?>
										<option value="<?php  echo $result_audit_auditor['Id_employee']; ?>"><?php  echo $result_audit_auditor['First_Name'].' '.$result_audit_auditor['Last_Name']; ?></option>
										<?php		
											}
										}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    	 <label>Revision</label>
									<input type="text" class="form-control" name="Revision_check_list_format_no" value="<?php echo $result_audit_view['Revision_check_list_format_no'] ?>" placeholder="<?php echo $result_audit_view['Revision_check_list_format_no'] ?>" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Name of External Company</label>
								    <select class="form-control" name="Id_name_of_external_company" required>
								    	<option value="">Choose Name of External Company</option>
								    	<?php 
											$consulta_external_company ="SELECT * FROM Audit_name_of_external_company WHERE Status LIKE 'Active'";
												$consulta_general_external_company = mysqli_query($con, $consulta_external_company);
												while($result_external_company = mysqli_fetch_assoc($consulta_general_external_company)){
													if($result_external_company['Id_name_of_external_company'] == $result_audit_view['Id_audit_name_of_external_company']){


											?>
											<option value="<?php  echo $result_external_company['Id_name_of_external_company']; ?>" selected><?php  echo $result_external_company['Title']; ?></option>
										<?php 
													}else{

										?>
											<option value="<?php  echo $result_external_company['Id_name_of_external_company']; ?>"><?php  echo $result_external_company['Title']; ?></option>
										<?php
													}
												}
											?>
									</select>
							   </div>
							   <div class="col-lg-6">
							   		<label>Finding Format No</label>
									<input type="text" class="form-control" name="finding_format" value="<?php echo $result_audit_view['finding_format_no'] ?>" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Audit Area</label>
									<select class="form-control" name="audit_area" required>
										<option value="">Choose Audit Area</option>
										<?php 
											$consulta_audit_area ="SELECT * FROM Audit_Area WHERE Status LIKE 'Active'";
											$consulta_general_audit_area = mysqli_query($con, $consulta_audit_area);
											while($result_audit_area = mysqli_fetch_assoc($consulta_general_audit_area)){
												if($result_audit_area['Id_audit_area'] == $result_audit_view['Id_audit_area']){
										?>
										<option value="<?php  echo $result_audit_area['Id_audit_area']; ?>" selected><?php  echo $result_audit_area['Title']; ?></option>
										<?php
												}else{
										?>
										<option value="<?php  echo $result_audit_area['Id_audit_area']; ?>"><?php  echo $result_audit_area['Title']; ?></option>
										<?php
												}
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    	<label>Revision</label>
									<input type="text" class="form-control" name="revision_finding_format_no" value="<?php echo $result_audit_view['Revision_finding_format_no'] ?>">
									<input type="hidden" value="<?php echo $result_audit_view['Id_audit_management'] ?>" name="id_audit">
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label><strong>Assign Check List</strong></label>
							    <select class="form-control" name="assign" id="assign">
							    	<?php 
									
												if($result_audit_view['Assig_check_list'] == 'Yes'){
										?>
										<option selected>Yes</option>
										<option >No</option>
										<?php
												}else{
										?>
										<option selected>No</option>
										<option >Yes</option>
										<?php
												}
										?>
							    </select>
							     
							   </div>
							   <div class="col-lg-6">
							    <label>Status: </label>
											    	<?php if($result_audit_view['status'] == 'Completed'){ ?>
											    	<a href="/includes/audit_status.php?ad_id=<?php echo $result_audit_view['Id_audit_management']; ?>"><div class="status-active">Completed</div></a>
											    <?php } else{ ?>
											    	
													<a href="/includes/audit_status.php?ad_id=<?php echo $result_audit_view['Id_audit_management']; ?>"><div class="status-danger">Schedule</div></a>
												<?php } ?>
							  </div>
							  
							  <!-- checklist-->
							  <?php
							  	if($result_audit_view['Assig_check_list'] == 'Yes'){
							  ?>
							  <div id="assign_check_list">
							  <?php
							  	}else{
							  ?>
							  <div id="assign_check_list" style="display: none;">
							  <?php
							  	}
							  ?>
							 <div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Assign Check List</h3>
											</div>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMas();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistro();" />
											</div>
										</div>
							 <div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		<th class='min-w-125px'>Sl</th>
											 		<th class='min-w-125px'>Clause</th>
											 		<th class='min-w-125px'>Audit point</th>
											 		<th class='min-w-125px'>Comply level</th>
											 		<th class='min-w-125px'>Evidance / Observation</th>
											 		<th class='min-w-125px'>Finding types</th>
											 		<th class='min-w-125px'>File</th>
											 		
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="agenda">
											 	<?php


											 	$consulta_assign_check_list ="SELECT * FROM Audit_Management_Check_List WHERE 	Id_Audit_Management = $id_audit";
											 	
											 	
												$consulta_result_assign_check_list = mysqli_query($con, $consulta_assign_check_list);
												//$result_general_assign_check_list = mysqli_fetch_assoc($consulta_result_assign_check_list);

												
  												while($result_general_assign_check_list = mysqli_fetch_assoc($consulta_result_assign_check_list)){
											 	?>
											 	
											 		<tr>
											 			<td><?php echo $result_general_assign_check_list['sl']; ?></td>
											 			<td><?php echo $result_general_assign_check_list['Clause']; ?></td>
											 			<td><?php echo $result_general_assign_check_list['Audit_point']; ?></td>
											 			<td><?php echo $result_general_assign_check_list['Comply_level']; ?></td>
											 			<td><?php echo $result_general_assign_check_list['Evidance']; ?></td>
											 			<td>
											 				<?php
											 					$Id_finding_types = $result_general_assign_check_list['Id_finding_types'];
											 					$consulta_Finding_Types = "SELECT * FROM Finding_Types WHERE 	Id_finding_types = $Id_finding_types";

											 					$consulta_result_finding_types = mysqli_query($con, $consulta_Finding_Types);

											 					$result_general_finding_types = mysqli_fetch_assoc($consulta_result_finding_types);
											 			 		echo $result_general_finding_types['Title']; 
											 				?>
											 			</td>
											 			<td>
											 				<?php if($result_general_assign_check_list['file']){ ?>
											 				<a href="/assets/media/assignchecklist/<?php echo $result_general_assign_check_list['file'] ?>"><i class="bi bi-file-earmark-image-fill fs-2qx"></i></a>
											 			<?php } ?>
											 			</td>
											 		</tr>
											 	
											  	<?php } ?>
											  	</tbody>
											</table>
							 </div>

							  
							 </div>
							</div>
							 
							 <!-- end::Form Content -->

							 <div class="card-footer">
								<div class="row">
									<div>
										<input type="submit" class="btn btn-sm btn-success m-3" value="Update">
										
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
		<script>
		

		document.querySelector("#assign").addEventListener("change", function() {
 		 document.querySelector('#assign_check_list').style.display = this.value == "Yes" ? "block" : "none";

		});

		function AgregarMas() {
			$("<td>").load("includes/inputs-dinamicos-audit-assign-check-list-update.php", function() {
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
	</body>
	<!--end::Body-->
</html>