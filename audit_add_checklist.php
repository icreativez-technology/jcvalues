<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Add CheckList";
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

                         	<form class="form">
							 
							 <!-- begin::Form Content -->
							 <div class="card-body">
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Clause</label>
									<input type="text" class="form-control" name="clause" placeholder="Enter Clause" required>
							   </div>
							   <div class="col-lg-6">
							    <label>Audit Point</label>
									<input type="text" class="form-control" name="audit_point" placeholder="Enter Audit Point" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Desired Rating</label>
									<input type="number" class="form-control" name="desired" placeholder="Enter Desired Rating" required>
							   </div>
							   <div class="col-lg-6">
							    <label>Actual Rating</label>
							     <input type="number" class="form-control" name="actual" placeholder="Enter Actual Rating" />
							   </div>
							  </div>
							  
							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Observation</label>
									<input type="text" class="form-control" name="observation" placeholder="Enter Observation" required>
							   </div>
							   <div class="col-lg-6">
							    <label>Evidente</label>
							     <input type="text" class="form-control" name="evidence" placeholder="Enter Evidence" />
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Is NCR?</label>
									<select class="form-control" name="type_audit" required>
										<option value="">Choose YES or NO</option>
										<option>Yes</option>
										<option>No</option>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Add image:</label>
								   <input type="file" class="form-control" name="image" required>
							   </div>
							  </div>

							  
							  <div class="form-group row">
							   <div>
							    <label>Add Another Check List?</label>
									<select class="form-control" name="check_list" required>
										<option value="">Choose YES or NO</option>
										<option>Yes</option>
										<option>No</option>
									</select>
							   </div>
							  </div>


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