<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Asset Basic Settings";
?>

<!DOCTYPE html>
<html lang="en">

	<?php include('includes/head.php'); ?> <!-- Meta tags + CSS -->
	<?php include('includes/admin_check.php'); ?>
	
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
								<p><a href="/">Home</a> » <a href="/admin-panel.php">Admin Panel</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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
                         <!-- AQUI AÑADIR EL CONTENIDO  -->
                         	
							<!--begin::Row-->
							<div class="row g-5 g-xl-8 mt-1">
								
								<div class="col-xl-3">
									<!--begin::Engage widget 1-->
									<div class="card h-md-100">
										<!--begin::Body-->
										<div class="card-body d-flex flex-column flex-center">
											<!--begin::Heading-->
											<div class="mb-2">
												<!--begin::Title-->
												<h1 class="fw-bold text-gray-800 text-center lh-lg">Instrument Condition</h1>
												<!--end::Title-->
											</div>
											<!--end::Heading-->
											<!--begin::Links-->
											<div class="text-center mb-1">
												<!--begin::Link-->
												<a class="btn btn-sm btn-primary" href="/admin_asset-instrument-condition.php">Select</a>
												<!--end::Link-->
											</div>
											<!--end::Links-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Engage widget 1-->
								</div>

								<div class="col-xl-3">
									<!--begin::Engage widget 1-->
									<div class="card h-md-100">
										<!--begin::Body-->
										<div class="card-body d-flex flex-column flex-center">
											<!--begin::Heading-->
											<div class="mb-2">
												<!--begin::Title-->
												<h1 class="fw-bold text-gray-800 text-center lh-lg">Machine Location</h1>
												<!--end::Title-->
											</div>
											<!--end::Heading-->
											<!--begin::Links-->
											<div class="text-center mb-1">
												<!--begin::Link-->
												<a class="btn btn-sm btn-primary" href="/admin_asset-machine-location.php">Select</a>
												<!--end::Link-->
											</div>
											<!--end::Links-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Engage widget 1-->
								</div>

								<div class="col-xl-3">
									<!--begin::Engage widget 1-->
									<div class="card h-md-100">
										<!--begin::Body-->
										<div class="card-body d-flex flex-column flex-center">
											<!--begin::Heading-->
											<div class="mb-2">
												<!--begin::Title-->
												<h1 class="fw-bold text-gray-800 text-center lh-lg">Send For</h1>
												<!--end::Title-->
											</div>
											<!--end::Heading-->
											<!--begin::Links-->
											<div class="text-center mb-1">
												<!--begin::Link-->
												<a class="btn btn-sm btn-primary" href="/admin_asset-sendfor.php">Select</a>
												<!--end::Link-->
											</div>
											<!--end::Links-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Engage widget 1-->
								</div>

								<div class="col-xl-3">
									<!--begin::Engage widget 1-->
									<div class="card h-md-100">
										<!--begin::Body-->
										<div class="card-body d-flex flex-column flex-center">
											<!--begin::Heading-->
											<div class="mb-2">
												<!--begin::Title-->
												<h1 class="fw-bold text-gray-800 text-center lh-lg">Type of Maintenance</h1>
												<!--end::Title-->
											</div>
											<!--end::Heading-->
											<!--begin::Links-->
											<div class="text-center mb-1">
												<!--begin::Link-->
												<a class="btn btn-sm btn-primary" href="/admin_asset-maintenance.php">Select</a>
												<!--end::Link-->
											</div>
											<!--end::Links-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Engage widget 1-->
								</div>

								<div class="col-xl-3">
									<!--begin::Engage widget 1-->
									<div class="card h-md-100">
										<!--begin::Body-->
										<div class="card-body d-flex flex-column flex-center">
											<!--begin::Heading-->
											<div class="mb-2">
												<!--begin::Title-->
												<h1 class="fw-bold text-gray-800 text-center lh-lg">Usage Condition</h1>
												<!--end::Title-->
											</div>
											<!--end::Heading-->
											<!--begin::Links-->
											<div class="text-center mb-1">
												<!--begin::Link-->
												<a class="btn btn-sm btn-primary" href="/admin_asset-usage.php">Select</a>
												<!--end::Link-->
											</div>
											<!--end::Links-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Engage widget 1-->
								</div>


							</div>
							<!--end::Row-->




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
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>