<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Delete MoC";

 $sql_data = "SELECT * FROM Quality_MoC WHERE Id_quality_moc = '$_REQUEST[pg_id]'";
 $connect_data = mysqli_query($con, $sql_data);
 $result_data = mysqli_fetch_assoc($connect_data);

   /*Para comprobar el usuario y que pueda editar o no*/
$email = $_SESSION['usuario'];
$sql_datos_usuario = "SELECT * From Basic_Employee Where Email = '$email'";
$result_datos_usuario = mysqli_query($con, $sql_datos_usuario);
$conectado = mysqli_fetch_assoc($result_datos_usuario);

$thisemployee = $conectado['Id_employee'];
$rol_user_check = $conectado['Admin_User'];
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
								<p><a href="/">Home</a> » <a href="/quality-moc.php">Quality MoC</a> » <a href="/quality-moc_view_list.php">Quality MoC List</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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
											<!-- <div class="card-header">
												<h3 class="card-title">< ?php echo $_SESSION['Page_Title']; ?></h3>
											</div> -->
											<!--begin::Form-->
											<form class="form" action="includes/quality-moc_delete_complete.php"  method="post" enctype="multipart/form-data">
												<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $result_data['Id_quality_moc']; ?>" readonly>
												<div class="card-body">
													
													<div class="form-group row">
														<div class="col-lg-12" style="text-align: center;">
															<label>¿Are you sure you want to delete MoC ID: <?php echo $result_data['Id_quality_moc'];?> data?</label><br>
															<label><b>This action can't be reversed. File and actions related to it will be also deleted.</b></label>
														</div>												
													</div>									
													
												</div>
												<div class="card-footer">
													<div class="row">
														<?php if($result_data['Id_employee'] == $thisemployee OR $rol_user_check == 'Superadministrator'){ ?>
															<input type="submit" class="btn btn-lg btn-primary mb-5" value="DELETE">
														<?php } ?>
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