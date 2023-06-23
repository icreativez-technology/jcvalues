<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Add Complaint";
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
								<p><a href="/">Home</a> » <a href="/customer.php">Customer Complaints</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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

                         	<form class="form">
							 
							 <!-- begin::Form Content -->
							 <div class="card-body">

							 <!-- begin::Section_1 -->
							 <div id="custom-section-1">
							 	<div class="container-full customer-header">
							 		Complaint Details
							 	</div>

							  
							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>On Behalf of</label>
									<input type="text" class="form-control" name="behalf" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Customer Name</label>
									<input type="text" class="form-control" name="customer_name" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Order Ref Number</label>
									<input type="text" class="form-control" name="order_ref_number" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Product Details</label>
									<input type="text" class="form-control" name="product_details" placeholder="" required>
							   </div>
							  </div>


							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Nature of Complaints</label>
									<select class="form-control" name="nature_complaints" required>
										<option value="">Select</option>
										<option>Nature 1</option>
										<option>Nature 2</option>
										<option>Nature 3</option>
										<option>Nature 4</option>
									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Date</label>
									<input type="date" class="form-control" name="date" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Email</label>
									<input type="email" class="form-control" name="email" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Phone</label>
									<input type="tel" class="form-control" name="phone" placeholder="" required>
							   </div>
							  </div>

							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Complaint Details</label>
									<input type="text" class="form-control" name="complaint_details" placeholder="" required>
							   </div>
							   <div class="col-lg-6">
							    <label>Audit Schedule Date</label>
							     <input type="file" class="form-control" name="audit_schedule_date"/>
							   </div>
							  </div>

							  </div>
							  <!-- end::Section_1 -->


							  <!-- begin::Section_2 -->
							 <div id="custom-section-2">
							 	<div class="container-full customer-header margincustom-complaint">
							 		D1-D2
							 	</div>
							  
							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Action Category</label>
									<select class="form-control" name="action_category" required>
										<option value="">Select</option>
										<option>Action Cat. 1</option>
										<option>Action Cat. 2</option>
										<option>Action Cat. 3</option>
										<option>Action Cat. 4</option>
									</select>
							   </div>
							   <div class="col-lg-9">
							    <label>Details of Solution</label>
									<input type="text" class="form-control" name="details_solution" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Plant</label>
									<select class="form-control" name="plant" required>
										<option value="">Select</option>
										<option>Plant 1</option>
										<option>Plant 2</option>
										<option>Plant 3</option>
										<option>Plant 4</option>
									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Product Group</label>
									<select class="form-control" name="product_group" required>
										<option value="">Select</option>
										<option>Product Group 1</option>
										<option>Product Group 2</option>
										<option>Product Group 3</option>
										<option>Product Group 4</option>
									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Assign to Department</label>
									<select class="form-control" name="assign_department" required>
										<option value="">Select</option>
										<option>Department 1</option>
										<option>Department 2</option>
										<option>Department 3</option>
										<option>Department 4</option>
									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Assign to Owner</label>
									<select class="form-control" name="assign_owner" required>
										<option value="">Select</option>
										<option>Owner 1</option>
										<option>Owner 2</option>
										<option>Owner 3</option>
										<option>Owner 4</option>
									</select>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Team Members</label>
									<select class="form-control" name="team_members" required>
										<option value="">Select</option>
										<option>Team 1</option>
										<option>Team 2</option>
										<option>Team 3</option>
										<option>Team 4</option>
									</select>
							   </div>
							  </div>

							  </div>
							  <!-- end::Section_2 -->

							  <!-- begin::Section_3 -->
							 <div id="custom-section-3">
							 	<div class="container-full customer-header margincustom-complaint">
							 		D3
							 	</div>
							  
							  <div class="form-group row">
							   <div class="col-lg-12">
							    <label>Indicative Cause of Non Comformance</label>
									<input type="text" class="form-control" name="indivative" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Correction</label>
									<input type="text" class="form-control" name="correction_name" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Who</label>
									<input type="text" class="form-control" name="correction_who" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>When</label>
									<input type="text" class="form-control" name="correction_when" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Review</label>
									<input type="text" class="form-control" name="correction_review" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Status</label>
									<select class="form-control" name="correction_status" required>
										<option value="">Select</option>
										<option>Status 1</option>
										<option>Status 2</option>
										<option>Status 3</option>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Remarks</label>
									<textarea class="form-control" id="correction_remarks" name="correction_remarks" rows="1"></textarea>
							   </div>
							  </div>

							  </div>

							  <!-- end::Section_3 -->


							  <!-- begin::Section_4 -->
							 <div id="custom-section-4">
							 	<div class="container-full customer-header margincustom-complaint">
							 		D4
							 	</div>

							  <div class="form-group row">
							   <div class="col-lg-4">
							    <label>Category</label>
									<select class="form-control" name="analysis_category" required>
										<option value="">Select</option>
										<option>Cat 1</option>
										<option>Cat 2</option>
										<option>Cat 3</option>
									</select>
							   </div>
							   <div class="col-lg-4">
							    <label>Cause</label>
									<input type="text" class="form-control" name="analysis_cause" placeholder="" required>
							   </div>
							   <div class="col-lg-4">
							    <label>Significant</label>
									<input type="text" class="form-control" name="analysis_significant" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-12">
							    <label>Significant cause</label>
									<select class="form-control" name="significant_cause" required>
										<option value="">Select</option>
										<option>Sig 1</option>
										<option>Sig 2</option>
										<option>Sig 3</option>
									</select>
							   </div>
							   <div class="col-lg-4">
							    <label>1st WHY</label>
									<textarea class="form-control" id="1_why" name="1_why" rows="2"></textarea>
							   </div>
							   <div class="col-lg-4">
							    <label>2nd WHY</label>
									<textarea class="form-control" id="2_why" name="2_why" rows="2"></textarea>
							   </div>
							   <div class="col-lg-4">
							    <label>3rd WHY</label>
									<textarea class="form-control" id="3_why" name="3_why" rows="2"></textarea>
							   </div>
							   <div class="col-lg-4">
							    <label>4th WHY</label>
									<textarea class="form-control" id="4_why" name="4_why" rows="2"></textarea>
							   </div>
							   <div class="col-lg-4">
							    <label>5th WHY</label>
									<textarea class="form-control" id="5_why" name="5_why" rows="2"></textarea>
							   </div>
							   <div class="col-lg-4">
							    <label>Root Cause</label>
									<input type="text" class="form-control" name="root_cause" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-4">
							    <label>Root Cause</label>
									<select class="form-control" name="action_plan_root" required>
										<option value="">Select</option>
										<option>Root 1</option>
										<option>Root 2</option>
										<option>Root 3</option>
									</select>
							   </div>
							   <div class="col-lg-4">
							    <label>Corrective Action</label>
									<input type="text" class="form-control" name="corrective_action" placeholder="" required>
							   </div>
							   <div class="col-lg-4">
							    <label>Who</label>
									<input type="text" class="form-control" name="action_who" placeholder="" required>
							   </div>
							   <div class="col-lg-4">
							    <label>When</label>
									<input type="text" class="form-control" name="action_when" placeholder="" required>
							   </div>
							   <div class="col-lg-4">
							    <label>Review</label>
									<input type="text" class="form-control" name="action_review" placeholder="" required>
							   </div>
							   <div class="col-lg-4">
							    <label>Status</label>
									<input type="text" class="form-control" name="action_status" placeholder="" required>
							   </div>
							  </div>


							  </div>



							  <!-- end::Section_4 -->


							  <!-- begin::Section_5 -->
							 <div id="custom-section-5">
							 	<div class="container-full customer-header margincustom-complaint">
							 		D6-D7
							 	</div>

							 	<div class="form-group row">
							   <div class="col-lg-6">
							    <label>Root Cause</label>
									<select class="form-control" name="verification root" required>
										<option value="">Select</option>
										<option>Root 1</option>
										<option>Root 2</option>
										<option>Root 3</option>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Corrective Action</label>
									<input type="text" class="form-control" name="corrective_verification" placeholder="" required>
							   </div>
							   <div class="col-lg-4">
							    <label>Who</label>
									<input type="text" class="form-control" name="verification_who" placeholder="" required>
							   </div>
							   <div class="col-lg-4">
							    <label>When</label>
									<input type="text" class="form-control" name="verification_when" placeholder="" required>
							   </div>
							   <div class="col-lg-4">
							    <label>Verified</label>
									<input type="text" class="form-control" name="verification_verified" placeholder="" required>
							   </div>
							  </div>
							 

							 </div>
							 <!-- end::Section_5 -->

							  
							  

							  
							 </div>
							 <!-- end::Form Content -->

							 <div class="card-footer">
								<div class="row" style="text-align: center;">
									<div>
										<button type="reset" class="btn btn-primary mr-2">Submit</button>
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