<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "New Asset";
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
								<p><a href="/">Home</a> » <a href="/asset.php">Asset</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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

							 <div id="custom-section-1">
							  
							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Asset Name</label>
									<input type="text" class="form-control" name="name" placeholder="" required>
							   </div>
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
							    <label>Make</label>
									<input type="text" class="form-control" name="make" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Model No</label>
									<input type="date" class="form-control" name="model_no" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Date of Purchase</label>
									<input type="date" class="form-control" name="date_purchase" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Supplier Name</label>
									<input type="text" class="form-control" name="supplier" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Specification (Range)</label>
									<input type="text" class="form-control" name="specification" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Least Count</label>
									<input type="text" class="form-control" name="count" placeholder="" required>
							   </div>

							  </div>

							  <div class="form-group row">
							   <div class="col-lg-3">
							    <label>Calibration frequency (Max. in months)</label>
									<select class="form-control" name="frequency" required>
										<option value="">Select</option>
										<option>3</option>
										<option>6</option>
										<option>9</option>
										<option>12</option>
									</select>
							   </div>
							   <div class="col-lg-3">
							    <label>Calibration done on</label>
									<input type="date" class="form-control" name="done_on" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Calibration due on</label>
									<input type="date" class="form-control" name="due_on" placeholder="" required>
							   </div>
							   <div class="col-lg-3">
							    <label>Storage location</label>
									<input type="text" class="form-control" name="location" placeholder="" required>
							   </div>
							  </div>

							  <div class="form-group row">
							   <div class="col-lg-6">
							    <label>Usage Condition</label>
									<select class="form-control" name="usage" required>
										<option value="">Select</option>
										<option>Usg 1</option>
										<option>Usg 2</option>
										<option>Usg 3</option>
										<option>Usg 4</option>
									</select>
							   </div>
							   <div class="col-lg-6">
							    <label>Attachment (Certificate/Photo)</label>
									<input type="file" class="form-control" name="attachment" placeholder="" required>
							   </div>
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