<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Add Finding Capa";
$id_audit_finding = $_REQUEST['id_aduit_find'];
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

                         	<form class="form" method="post" action="includes/audit_add_finding_capa.php">
							 
							 <!-- begin::Form Content -->
							 <div class="card-body">
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Description</label>
									<textarea class="form-control" name="description_capa"></textarea>
									
							   </div>
							   <div class="col-lg-6">
							    <label>Date</label>
									<input type="date" class="form-control" name="date_capa">
							   </div>
							  </div>
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							     <label>Action by </label>
									<select class="form-control" name="action_by_capa" required>
										<?php 
											$consulta_employee ="SELECT * FROM Basic_Employee";
											$consulta_result_employee = mysqli_query($con, $consulta_employee);
											while($result_general_employee = mysqli_fetch_assoc($consulta_result_employee)){
										?>
										<option value="<?php echo $result_general_employee['Id_employee']; ?>"><?php echo $result_general_employee['Email']; ?></option>
										<?php } ?>
									</select>
									<input type="hidden" name="id_audit_finding" value="<?php echo $id_audit_finding ?>">
									
									
							   </div>
							   <div class="col-lg-6">
							    <label>Issued by </label>
							    <select class="form-control" name="issued_by_capa" required>
									<?php 
										$consulta_employee ="SELECT * FROM Basic_Employee";
										$consulta_result_employee = mysqli_query($con, $consulta_employee);
										while($result_general_employee = mysqli_fetch_assoc($consulta_result_employee)){
									?>
									<option value="<?php echo $result_general_employee['Id_employee']; ?>"><?php echo $result_general_employee['Email']; ?></option>
									<?php } ?>
								</select>
							     
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Finding Type</label>
									<select class="form-control" name="ftype_capa" required>
									<?php 
										$consulta_ftype ="SELECT * FROM Finding_Types";
										$consulta_result_ftype = mysqli_query($con, $consulta_ftype);
										while($result_general_ftype = mysqli_fetch_assoc($consulta_result_ftype)){
									?>
									<option value="<?php echo $result_general_ftype['Id_finding_types']; ?>"><?php echo $result_general_ftype['Title']; ?></option>
									<?php } ?>
								</select>
							   </div>
							   <div class="col-lg-6">
							    
							   </div>
							  </div>
							  	
							  	<div class="form-group row">
								   <div class="col-lg-6">
								   	
								   </div>
							   </div>					  
							  <!-- checklist-->

							  <!-- Root Cause Analysis-->
							  <div id="assign_check_list">
								 <div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Root Cause Analysis</h3>
											</div>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMasRoot();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistroRoot();" />
											</div>
								</div>
							 	<div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		<th class='min-w-125px'>Details of Root Cause</th>
											 		<th class='min-w-125px'>Auditee</th>
											 		<th class='min-w-125px'>Date</th>
											 		
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="RootCauseAnalysis">
											 		
											 	</tbody>
											  
											</table>
								 </div>

							  </div>
							 <!-- Correction Immediate-->
							  <div id="assign_check_list">
								 <div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Correction Immediate</h3>
											</div>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMasCorrectionImmediate();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistroCorrectionImmediate();" />
											</div>
								</div>
							 	<div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		<th class='min-w-125px'>Correction</th>
											 		<th class='min-w-125px'>Auditee</th>
											 		<th class='min-w-125px'>Date</th>
											 		
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="correction">
											 		
											 	</tbody>
											  
											</table>
								 </div>

							  </div>
							  <!-- Corrective, Preventive, Action -->
							  <div id="assign_check_list">
								 <div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Corrective, Preventive, Action</h3>
											</div>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMasCorrectivePreventiveAction();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistroCorrectivePreventiveAction();" />
											</div>
								</div>
							 	<div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		<th class='min-w-125px'>Description</th>
											 		<th class='min-w-125px'>Recommended by</th>
											 		<th class='min-w-125px'>Date</th>
											 		<th class='min-w-125px'>Deparment</th>
											 		<th class='min-w-125px'>Due date</th>
											 		<th class='min-w-125px'>Responsible</th>
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="CorrectivePreventiveAction">
											 		
											 	</tbody>
											  
											</table>
								 </div>

							  </div>
							  <!-- Management Of Change -->
							  <div id="assign_check_list">
								 <div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Management Of Change</h3>
											</div>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMasManagementOfChange();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistroManagementOfChange();" />
											</div>
								</div>
							 	<div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		<th class='min-w-125px'>MOC</th>
											 		<th class='min-w-125px'>Description</th>
											 		
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="ManagementOfChange">
											 		
											 	</tbody>
											  
											</table>
								 </div>

							  </div>
							  <!-- Following Up Quality -->
							  <div id="assign_check_list">
								 <div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Following Up Quality</h3>
											</div>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMasFollowingUpQuality();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistroFollowingUpQuality();" />
											</div>
								</div>
							 	<div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		<th class='min-w-125px'>Description</th>
											 		<th class='min-w-125px'>Employees</th>
											 		<th class='min-w-125px'>Date</th>
											 		
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="FollowingUpQuality">
											 		
											 	</tbody>
											  
											</table>
								 </div>

							  </div>
							  <!-- Closing, Corrective, Preventive, Action -->
							  <div id="assign_check_list">
								 <div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Closing, Corrective, Preventive, Action</h3>
											</div>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMasClosingCorrectivePreventiveAction();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistroClosingCorrectivePreventiveAction();" />
											</div>
								</div>
							 	<div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		<th class='min-w-125px'>Description</th>
											 		<th class='min-w-125px'>Closed_by</th>
											 		<th class='min-w-125px'>Date</th>
											 		
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="ClosingCorrectivePreventiveAction">
											 		
											 	</tbody>
											  
											</table>
								 </div>

							  </div>
							   <!-- Distribution -->
							  <div id="assign_check_list">
								 <div class="card-header card-header-stretch pb-0">
										 	<div class="card-title">
												 <h3>Distribution</h3>
											</div>
											<div class="card-toolbar m-4">
											 	<input class="btn btn-success" type="button" name="add" value="Add" onClick="AgregarMasDistribution();" /><input class="btn btn-danger" type="button" name="delete" value="Delete" onClick="BorrarRegistroDistribution();" />
											</div>
								</div>
							 	<div id="custom-section-1">
					
											 <table class='table align-middle table-row-dashed fs-6 gy-5'>
											 	<thead>
											 		<th class='min-w-125px'>Department</th>
											 		
											 	</thead>
											 	<tbody class='fw-bold text-gray-600' id="Distribution">
											 		
											 	</tbody>
											  
											</table>
								 </div>

							  </div>
							</div>
							 
							 <!-- end::Form Content -->

							 <div class="card-footer">
								<div class="row">
								<div class="form-group form-group-button" style="float:right">
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
 		 document.querySelector('#assign_check_list').style.display = this.value == "No" ? "block" : "none";
		});

		function AgregarMasRoot() {
			$("<td>").load("includes/inputs-dinamicos-audit-capa-root.php", function() {
					$("#RootCauseAnalysis").append($(this).html());
			});	
		}
		function BorrarRegistroRoot() {
			$('tr.campos_RootCauseAnalysis').each(function(index, item){
				jQuery(':checkbox', this).each(function () {
		            if ($(this).is(':checked')) {
						$(item).remove();
		            }
		        });
			});
		}

		function AgregarMasCorrectionImmediate() {
			$("<td>").load("includes/inputs-dinamicos-audit-capa-correction-immediate.php", function() {
					$("#correction").append($(this).html());
			});	
		}
		function BorrarRegistroCorrectionImmediate() {
			$('tr.campos_correction').each(function(index, item){
				jQuery(':checkbox', this).each(function () {
		            if ($(this).is(':checked')) {
						$(item).remove();
		            }
		        });
			});
		}

		function AgregarMasCorrectivePreventiveAction() {
			$("<td>").load("includes/inputs-dinamicos-audit-capa-corrective-preventive-action.php", function() {
					$("#CorrectivePreventiveAction").append($(this).html());
			});	
		}
		function BorrarRegistroCorrectivePreventiveAction() {
			$('tr.campos_CorrectivePreventiveAction').each(function(index, item){
				jQuery(':checkbox', this).each(function () {
		            if ($(this).is(':checked')) {
						$(item).remove();
		            }
		        });
			});
		}

		function AgregarMasManagementOfChange() {
			$("<td>").load("includes/inputs-dinamicos-audit-capa-management-of-change.php", function() {
					$("#ManagementOfChange").append($(this).html());
			});	
		}
		function BorrarRegistroManagementOfChange() {
			$('tr.campos_ManagementOfChange').each(function(index, item){
				jQuery(':checkbox', this).each(function () {
		            if ($(this).is(':checked')) {
						$(item).remove();
		            }
		        });
			});
		}

		function AgregarMasFollowingUpQuality() {
			$("<td>").load("includes/inputs-dinamicos-audit-capa-following-up-quality.php", function() {
					$("#FollowingUpQuality").append($(this).html());
			});	
		}
		function BorrarRegistroFollowingUpQuality() {
			$('tr.campos_FollowingUpQuality').each(function(index, item){
				jQuery(':checkbox', this).each(function () {
		            if ($(this).is(':checked')) {
						$(item).remove();
		            }
		        });
			});
		}

		function AgregarMasClosingCorrectivePreventiveAction() {
			$("<td>").load("includes/inputs-dinamicos-audit-capa-closing-corrective-preventive-action.php", function() {
					$("#ClosingCorrectivePreventiveAction").append($(this).html());
			});	
		}
		function BorrarRegistroClosingCorrectivePreventiveAction() {
			$('tr.campos_ClosingCorrectivePreventiveAction').each(function(index, item){
				jQuery(':checkbox', this).each(function () {
		            if ($(this).is(':checked')) {
						$(item).remove();
		            }
		        });
			});
		}

		function AgregarMasDistribution() {
			$("<td>").load("includes/inputs-dinamicos-audit-capa-distribution.php", function() {
					$("#Distribution").append($(this).html());
			});	
		}
		function BorrarRegistroDistribution() {
			$('tr.campos_Distribution').each(function(index, item){
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