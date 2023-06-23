<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "CheckLists";
$id_audit = $_REQUEST['audit_id'];
$consulta_audit_Check_List_view = "SELECT * FROM Audit_Management_Check_List WHERE Id_Audit_Management = $id_audit";
$consulta_general_audit_Check_List_view = mysqli_query($con, $consulta_audit_Check_List_view);

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
								<p><a href="/">Home</a> » <a href="/audit.php">Audit</a> » <a href="/audit_view.php">NOMBREAUDIT</a> » <?php echo $_SESSION['Page_Title']; ?></p>
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
                            <!--begin::Content-->
							<div class="content d-flex flex-column flex-column-fluid" style="padding: 30px 0 0 !important;">
								<!--begin::Container-->
								<div class="container-custom">

                         		<!--begin::Card body-->
								<div class="card-body pt-0 table-responsive">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_subscriptions_table">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-muted text-uppercase gs-0">
												<th class="min-w-25px">S No</th>
												<th class="min-w-25px">Clause</th>
												<th class="min-w-150px">Audit point</th>
												<th class="min-w-25px">Comply level</th>
												<th class="min-w-25px">Evidance / Observation</th>
												<th class="min-w-100px">Finding types</th>
												<th class="min-w-100px">File</th>
											</tr>
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold">
											<?php while($result_audit_Check_List_view = mysqli_fetch_assoc($consulta_general_audit_Check_List_view)){?>
												<tr>
													<!--begin::S No-->
														<td><?php echo $result_audit_Check_List_view['sl']?></td>	
													<!--end::S No-->
													<!--begin::Clause=-->
													<td>
														<?php echo $result_audit_Check_List_view['Clause']?>
													</td>
													<!--end::Clause=-->
													<!--begin::Audit Point-->
													<td>
														<?php echo $result_audit_Check_List_view['Audit_point']?>
													</td>
													<!--end::Audit Point-->
													<!--begin::Desired Rating-->
													<td><?php echo $result_audit_Check_List_view['Comply_level']?></td>
													<!--end::Desired Rating-->
													<!--begin::Actual Rating-->
													<td><?php echo $result_audit_Check_List_view['Evidance']?></td>
													<!--end::Actual Rating-->
													<!--begin::Action-->
													<td>
														<?php
															$Id_finding_types = $result_audit_Check_List_view['Id_finding_types'];
															$consulta_finding_types = "SELECT * FROM Finding_Types WHERE Id_finding_types = $Id_finding_types";
															$consulta_general_finding_types = mysqli_query($con, $consulta_finding_types);
															$result_finding_types = mysqli_fetch_assoc($consulta_general_finding_types);
															echo $result_finding_types['Title']
														?>
													</td>
													<!--end::Action-->
													<!--begin::file-->
													<td>
														
															<?php if($result_audit_Check_List_view['file']){ ?>
															<a href="/assets/media/assignchecklist/<?php echo $result_audit_Check_List_view['file'] ?>"><i class="bi bi-file-earmark-image-fill fs-2qx"></i></a>
															<?php } ?>
													
													</td>
													<!--end::Evidence-->
													
												</tr>
											<?php } ?>
											
										</tbody>
										<!--end::Table body-->
									</table>
									<!--end::Table-->
								</div>
								<!--end::Card body-->


                         <!-- Finalizar contenido -->
                     			</div>
		                     </div>
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