<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Edit Why Why Analysis";

 $sql_data = "SELECT * FROM NCR_Why_Why WHERE Id_ncr_why_why = '$_REQUEST[pg_id]'";
 $connect_data = mysqli_query($con, $sql_data);
 $result_data = mysqli_fetch_assoc($connect_data);

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
								<p><a href="/">Home</a> » <a href="/ncr.php">NCR</a> » <a href="/ncr_view_list.php">NCR List</a> » <a href="/ncr_view.php?pg_id=<?php echo $_REQUEST['pg_id']; ?>">View NCR</a> » <a href="/ncr_analysis_ca.php?pg_id=<?php echo $_REQUEST['return_id']; ?>">NCR Analysis & CA</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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

                         	<form class="form" action="includes/ncr_why_why_update_individual.php" method="post" enctype="multipart/form-data">
                         		<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_ncr_why_why']; ?>" readonly>
                         		<input type="hidden" name="return_id" id="return_id" value="<?php echo $_REQUEST['return_id']; ?>" readonly>
							 
							 <!-- begin::Form Content -->
							 <div class="card-body">
									 <div id="custom-section-1">
										
									  <div class="form-group row">
									   
									   <div class="col-lg-4">
									    <label>Significant Cause</label>
											<select class="form-control" name="Id_ncr_analysis" required>	
											<?php
												$sql_datos_ncr_analysis = "SELECT * From NCR_Analysis WHERE Id_ncr = '$_REQUEST[return_id]'";
												$conect_datos_ncr_analysis = mysqli_query($con, $sql_datos_ncr_analysis);

												while ($result_datos_ncr_analysis = mysqli_fetch_assoc($conect_datos_ncr_analysis))
												{
													if($result_datos_ncr_analysis['Id_ncr_analysis'] == $result_data['Id_ncr_analysis']){
											?>
												<option value="<?php echo $result_datos_ncr_analysis['Id_ncr_analysis']; ?>" selected="selected"><?php echo $result_datos_ncr_analysis['Cause']; ?></option>
											<?php
											}else{
										?>
												<option value="<?php echo $result_datos_ncr_analysis['Id_ncr_analysis']; ?>"><?php echo $result_datos_ncr_analysis['Cause']; ?></option>
										<?php
											}
										}
										?>
										</select>
									   </div>
									   
									   <div class="col-lg-4">
									    <label>1<sup>st</sup> Why</label>
											<input type="text" class="form-control" name="First_why" value="<?php echo $result_data['First_why'];?>" required>
									   </div>

									   <div class="col-lg-4">
									    <label>2<sup>nd</sup> Why</label>
											<input type="text" class="form-control" name="Second_why" value="<?php echo $result_data['Second_why'];?>" required>
									   </div>
									   
									  </div>

									  <div class="form-group row">
									   								   
									   <div class="col-lg-4">
									    <label>3<sup>rd</sup> Why</label>
											<input type="text" class="form-control" name="Third_why" value="<?php echo $result_data['Third_why'];?>" required>
									   </div>

									   <div class="col-lg-4">
									    <label>4<sup>th</sup> Why</label>
											<input type="text" class="form-control" name="Fourth_why" value="<?php echo $result_data['Fourth_why'];?>" required>
									   </div>

									   <div class="col-lg-4">
									    <label>5<sup>th</sup> Why</label>
											<input type="text" class="form-control" name="Fifth_why" value="<?php echo $result_data['Fifth_why'];?>" required>
									   </div>

									   <div class="col-lg-4">
									    <label>Root Cause</label>
											<input type="text" class="form-control" name="Root_cause" value="<?php echo $result_data['Root_cause'];?>" required>
									   </div>
									   
									  </div>


							  	</div>
							 </div>
							 <!-- end::Form Content -->


							 <div class="card-footer">
								<div class="row" style="text-align: center;">
									<div>
										<button type="submit" class="btn btn-primary mr-2">Update</button>
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