<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Schedule Audit";
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
								<p><a href="/">Home</a> » <a href="/audit.php">Audit</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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

                         	<form class="form" method="post" action="includes/audit_add_schedule.php" enctype="multipart/form-data">
							 
							 <!-- begin::Form Content -->
							 <div class="card-body">
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Plant</label>
									<select class="form-control" name="plant" required>
										<option value="">Choose plant</option>
										<?php 
											$consulta_plant ="SELECT * FROM Basic_Plant WHERE Status LIKE 'Active'";
											$consulta_general_plant = mysqli_query($con, $consulta_plant);
											while($result_plant = mysqli_fetch_assoc($consulta_general_plant)){
										?>
										<option value="<?php  echo $result_plant['Id_plant']; ?>"><?php  echo $result_plant['Title']; ?></option>
										<?php 
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Auditee</label>
										

										<select class="form-select" name="auditee" data-control="select2" data-placeholder="Select an option" required>
										<option value="">Select option</option>
										<?php 
											$consulta_audit_auditee ="SELECT * FROM Basic_Employee";
											$consulta_general_audit_auditee = mysqli_query($con, $consulta_audit_auditee);
											while($result_audit_auditee = mysqli_fetch_assoc($consulta_general_audit_auditee)){
										?>
										<option value="<?php  echo $result_audit_auditee['Id_employee']; ?>"><?php  echo $result_audit_auditee['First_Name'].' '.$result_audit_auditee['Last_Name']; ?></option>
										<?php 
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
										?>
										<option value="<?php  echo $result_product_group['Id_product_group']; ?>"><?php  echo $result_product_group['Title']; ?></option>
										<?php 
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Audit Schedule Date</label>
							     <input type="date" class="form-control" name="audit_schedule_date"/>
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
										?>
										<option value="<?php  echo $result_type_of_audit['Id_type_of_audit']; ?>"><?php  echo $result_type_of_audit['Title']; ?></option>
										<?php 
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
										?>
										<option value="<?php  echo $result_deparment['Id_department']; ?>"><?php  echo $result_deparment['Department']; ?></option>
										<?php 
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
										?>
										<option value="<?php  echo $result_audit_standard['Id_audit_standard']; ?>"><?php  echo $result_audit_standard['Title']; ?></option>
										<?php 
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							    	<label>Audit Check List Format No</label>
									<input type="text" class="form-control" name="format_no" placeholder="Enter Format No" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Auditor</label>
							    	<select class="form-select" name="auditor" data-control="select2" data-placeholder="Select an option" required>
									
										<option value="">Select option</option>
										<?php 
											$consulta_audit_auditor ="SELECT * FROM Basic_Employee";
											$consulta_general_audit_auditor = mysqli_query($con, $consulta_audit_auditor);
											while($result_audit_auditor = mysqli_fetch_assoc($consulta_general_audit_auditor)){
										?>
										<option value="<?php  echo $result_audit_auditor['Id_employee']; ?>"><?php  echo $result_audit_auditor['First_Name'].' '.$result_audit_auditor['Last_Name']; ?></option>
										<?php 
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							     <label>Revision</label>
									<input type="text" class="form-control" name="Revision_check_list_format_no" placeholder="Enter Revision" required>
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
											?>
											<option value="<?php  echo $result_external_company['Id_name_of_external_company']; ?>"><?php  echo $result_external_company['Title']; ?></option>
										<?php 
												}
											?>
									</select>
							   </div>
							   <div class="col-lg-6">
							   	 <label>Finding Format No</label>
									<input type="text" class="form-control" name="finding_format" placeholder="Enter Format No" required>
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
										?>
										<option value="<?php  echo $result_audit_area['Id_audit_area']; ?>"><?php  echo $result_audit_area['Title']; ?></option>
										<?php 
											}
										?>
									</select>
							   </div>
							   <div class="col-lg-6">
							   <label>Revision</label>
									<input type="text" class="form-control" name="revision_finding_format_no" placeholder="Enter Revision" required>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label><strong>Assign Check List</strong></label>
							    <select class="form-control" name="assign" id="assign">
							    	<option value="Yes">Yes</option>
							    	<option value="No" selected> No</option>
							    </select>
							     
							   </div>
							   <div class="col-lg-6">
							    
							   </div>
							  </div>
							  
							  <!-- checklist-->
							 
							  <div id="assign_check_list" style="display: none;">
							  
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
											 		<th class='min-w-125px'>S.L</th>
											 		<th class='min-w-125px'>Clause</th>
											 		<th class='min-w-125px'>Audit point</th>
											 		<th class='min-w-125px'>Comply level</th>
											 		<th class='min-w-125px'>Evidance / Observation</th>
											 		<th class='min-w-125px'>Finding types</th>
											 		<td></td>
											 		
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="agenda">
											 		
											 	</tbody>
											  
											</table>
							 </div>

							  
							 </div>
							</div>
							 
							 <!-- end::Form Content -->

							 <div class="card-footer">
								<div class="row">
									<div>
										<input type="submit" class="btn btn-sm btn-success m-3" value="Save">
										
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
			$("<td>").load("includes/inputs-dinamicos-audit-assign-check-list.php", function() {
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