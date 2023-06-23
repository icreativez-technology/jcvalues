<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Add File";

$item = $_POST['item'];
$sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks, Category From Document WHERE File LIKE '$item'";
$conect_datos_document = mysqli_query($con, $sql_datos_document);
print_r($conect_datos_document);
$result_datos_document = mysqli_fetch_assoc($conect_datos_document);
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
								<p><a href="/">Home</a> » <a href="/documentation.php">Documentation111</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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

                         <div class="card card-custom gutter-b example example-compact">
											<div class="card-header">
												<h3 class="card-title">Upload New File1111</h3>
												<div class="card-toolbar">
													<div class="example-tools justify-content-center">
														<span class="example-toggle" data-toggle="tooltip" title="" data-original-title="View code"></span>
														<span class="example-copy" data-toggle="tooltip" title="" data-original-title="Copy code"></span>
													</div>
												</div>
											</div>
											<!--begin::Form-->
											<form class="form" action="includes/anadir-documentacion.php"  method="post" enctype="multipart/form-data">
												<div class="card-body">
													<div class="form-group row">
														<div class="col-lg-4">
															<label>Title of the document111:</label>
															<input type="text" class="form-control" name="title_document" placeholder="<?php echo "adasdas";?> "required>
														</div>
														<div class="col-lg-4">
															<label>Format No:</label>
															<input type="text" class="form-control" name="formatno" required>
														</div>
														<div class="col-lg-4">
															<label>Rev No:</label>
															<input type="text" class="form-control" name="revno" required>
														</div>
														
													</div>
													
													<div class="form-group row">
														<div class="col-lg-4">
															<label>Prepared by:</label>
															<input type="text" class="form-control" name="prep" required>
														</div>
														
														<div class="col-lg-4">
															<label>Reviewd by:</label>
															<input type="text" class="form-control" name="rev" required>
														</div>

														<div class="col-lg-4">
															<label>Approved by:</label>
															<input type="text" class="form-control" name="approv" required>
														</div>
														
													</div>

													<div class="form-group row">
														<div class="col-lg-4">
															<label>Date of preparation:</label>
															<input type="date" class="form-control" name="date_prep" required>
														</div>
														
														<div class="col-lg-4">
															<label>Date of revision:</label>
															<input type="date" class="form-control" name="date_rev" required>
														</div>

														<div class="col-lg-4">
															<label>Date of approval:</label>
															<input type="date" class="form-control" name="date_approv" required>
														</div>
																												
													</div>
													<div class="form-group row">
														<div class="col-lg-6">
															<label>Document category:</label>
															<select class="form-control" name="category" required>
																<?php 
																	foreach ($documetancion as $value) {							 
																?>
																
																	<option><?php  echo $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-lg-6">
															<label>Upload file:</label>
															<input type="file" class="form-control" accept = "application/pdf" name="file_docu" id="file_docu" required>
														</div>
													</div>
													<div class="form-group mb-1">
														<div>
														    <label for="exampleTextarea">Remarks</label>
														    <textarea class="form-control" id="exampleTextarea" name="remarks" rows="4"></textarea required>
														</div>
													</div>
													
													
												</div>
												<div class="card-footer">
													<div class="row">
														
															<input type="submit" class="btn btn-sm btn-success m-3" value="Upload">
														
													</div>
												</div>
											</form>
											<!--end::Form-->
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
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>