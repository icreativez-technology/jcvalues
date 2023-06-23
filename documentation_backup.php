<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Documentation";
$documetancion = scandir('/var/www/vhosts/nivelz.biz/dqms.nivelz.biz/documentacion');
unset($documetancion[array_search('.', $documetancion, true)]);
unset($documetancion[array_search('..', $documetancion, true)]);

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
							<p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
							<!-- MIGAS DE PAN -->
						</div>
					</div>
					<!--end::body-->
				</div>
				<!--end::BREADCRUMBS-->

				<!--begin::Content-->




				<!-- AQUI AÑADIR EL CONTENIDO  -->



				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" style="padding: 30px 0 0 !important;">
					<!--begin::Container-->
					<div class="container-custom">
						<!--begin::Row-->
						<div class="row g-5 g-xl-8">
							<div class="col-xl-3">
								<!--begin::Statistics Widget 5-->
								<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->

										<!--end::Svg Icon-->
										<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5-custom">500M$</div>
										<div class="fw-bold text-gray-400">SAP UI Progress</div>
									</div>
									<!--end::Body-->
								</a>
								<!--end::Statistics Widget 5-->
							</div>
							<div class="col-xl-3">
								<!--begin::Statistics Widget 5-->
								<a href="#" class="card bg-dark hoverable card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class="card-body">

										<!--end::Svg Icon-->
										<div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5-custom">+3000</div>
										<div class="fw-bold text-gray-100">New Customers</div>
									</div>
									<!--end::Body-->
								</a>
								<!--end::Statistics Widget 5-->
							</div>
							<div class="col-xl-3">
								<!--begin::Statistics Widget 5-->
								<a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->

										<!--end::Svg Icon-->
										<div class="text-white fw-bolder fs-2 mb-2 mt-5-custom">$50,000</div>
										<div class="fw-bold text-white">Milestone Reached</div>
									</div>
									<!--end::Body-->
								</a>
								<!--end::Statistics Widget 5-->
							</div>
							<div class="col-xl-3">
								<!--begin::Statistics Widget 5-->
								<a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->

										<!--end::Svg Icon-->
										<div class="text-white fw-bolder fs-2 mb-2 mt-5-custom">$50,000</div>
										<div class="fw-bold text-white">Milestone Reached</div>
									</div>
									<!--end::Body-->
								</a>
								<!--end::Statistics Widget 5-->
							</div>
						</div>
						<!--end::Row-->
					</div>
				</div>




				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<!--begin::Container-->
					<div class="container-custom" id="kt_content_container">

						<!--begin::Card-->
						<div class="card card-flush">
							<!--begin::Card header-->
							<div class="card-header pt-8">
								<div class="card-title">
									<!--begin::Search-->
									<div class="d-flex align-items-center position-relative my-1">
										<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
										<span class="svg-icon svg-icon-1 position-absolute ms-6">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
												<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Files &amp; Folders" />
									</div>
									<!--end::Search-->
								</div>
								<!--begin::Card toolbar-->
								<div class="card-toolbar">
									<!--begin::Toolbar-->
									<div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
										<!--begin::Export-->
										<a href="/documentation_add_folder.php">
											<button type="button" class="btn btn-light-primary me-3">
												<!--begin::Svg Icon | path: icons/duotune/files/fil013.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
														<path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="currentColor" />
														<path opacity="0.3" d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="currentColor" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												New Folder</button>
										</a>
										<!--end::Export-->
										<!--begin::Add customer-->
										<a href="/documentation_add_file.php">
											<button type="button" class="btn btn-primary" data-bs-toggle="modal">
												<!--begin::Svg Icon | path: icons/duotune/files/fil018.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
														<path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM16 11.6L12.7 8.29999C12.3 7.89999 11.7 7.89999 11.3 8.29999L8 11.6H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H16Z" fill="currentColor" />
														<path opacity="0.3" d="M11 11.6V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H11Z" fill="currentColor" />
													</svg>
												</span>
												<!--end::Svg Icon-->Upload Files</button>
										</a>
										<!--end::Add customer-->
									</div>
									<!--end::Toolbar-->
									<!--begin::Group actions-->
									<div class="d-flex justify-content-end align-items-center d-none" data-kt-filemanager-table-toolbar="selected">
										<div class="fw-bolder me-5">
											<span class="me-2" data-kt-filemanager-table-select="selected_count"></span>Selected
										</div>
										<button type="button" class="btn btn-danger" data-kt-filemanager-table-select="delete_selected">Delete Selected</button>
									</div>
									<!--end::Group actions-->
								</div>
								<!--end::Card toolbar-->
							</div>
							<!--end::Card header-->
							<!--begin::Card body-->
							<div class="card-body">
								<!--begin::Table header-->
								<div class="d-flex flex-stack">
									<!--begin::Folder path-->
									<div class="badge badge-lg badge-light-primary">
										<div class="d-flex align-items-center flex-wrap">
											<span><a href="/documentation.php">Document Managment System</a></span>
										</div>
									</div>
									<!--end::Folder path-->
									<!--begin::Folder Stats-->
									<!--<div class="badge badge-lg badge-primary">
											<span id="kt_file_manager_items_counter">Loading items</span>
										</div>-->
									<!--end::Folder Stats-->
								</div>
								<!--end::Table header-->
								<!--begin::Table-->
								<!--<table id="kt_file_manager_list" data-kt-filemanager-table="folders" class="table align-middle table-row-dashed fs-6 gy-5 gx-5">-->
								<!-- NOTA: ESTA ID Y DATA HACE LA FUNCIONALIDAD DEL BUSCADOR -->
								<?php

								foreach ($documetancion as $value) {
								?>
									<div class="d-flex align-items-center">
										<!--begin::Svg Icon | path: icons/duotune/files/fil012.svg-->
										<span class="svg-icon svg-icon-2x svg-icon-primary me-4">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
												<path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<a href="/documentation_backup.php#<?php echo $value; ?>" class="text-gray-800 text-hover-primary"> <?php echo $value; ?></a>
									</div>
								<?php
								}
								?>

								<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
											<th class="w-10px pe-2">
												<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
													<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_file_manager_list .form-check-input" value="1" />
												</div>
											</th>
											<th class="min-w-250px">Name</th>
											<th class="min-w-10px hidde-responsive-j6">Format No</th>
											<th class="min-w-125px hidde-responsive-j6">Rev No</th>
											<th class="min-w-125px hidde-responsive-j6">Date of approval</th>
											<th class="min-w-125px hidde-responsive-j6">Date of rev</th>
											<th class="min-w-125px hidde-responsive-j6">Prepared by</th>
											<th class="min-w-125px hidde-responsive-j6">Approved by</th>
											<th class="min-w-125px" style="text-align: right;">Actions</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody class="fw-bold text-gray-600">
										<?php

										foreach ($documetancion as $value) {

										?>
											<tr>
												<!--begin::Checkbox-->
												<td>
													<div class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="1" />
													</div>
												</td>
												<!--end::Checkbox-->
												<!--begin::Name=-->
												<td data-order="account">
													<div class="d-flex align-items-center">
														<!--begin::Svg Icon | path: icons/duotune/files/fil012.svg-->
														<span class="svg-icon svg-icon-2x svg-icon-primary me-4">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
																<path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<a href="/documentacion/<?php echo $value; ?>" class="text-gray-800 text-hover-primary"> <?php echo $value; ?></a>
													</div>
												</td>

												<td class="hidde-responsive-j6">-</td>
												<td class="hidde-responsive-j6">-</td>
												<td class="hidde-responsive-j6">-</td>

												<td class="hidde-responsive-j6">-</td>
												<td class="hidde-responsive-j6">-</td>
												<td class="hidde-responsive-j6">-</td>

												<td class="text-end" data-kt-filemanager-table="action_dropdown">
													<div class="d-flex justify-content-end">

														<!--begin::More-->
														<div class="ms-2">
															<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																<!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
																<span class="svg-icon svg-icon-5 m-0">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
																		<rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor" />
																		<rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</button>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">

																<div class="menu-item px-3">
																	<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i>View</a>
																</div>
																<div class="menu-item px-3">
																	<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-pencil" style="padding-right: 4px;"></i>Edit</a>
																</div>
																<div class="menu-item px-3">
																	<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-trash" style="padding-right: 4px;"></i>Delete</a>
																</div>
																<div class="menu-item px-3">
																	<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-hourglass-split" style="padding-right: 4px;"></i>History</a>
																</div>
															</div>
															<!--end::Menu-->
															<!--end::More-->
														</div>
													</div>
												</td>
												<!--end::Actions-->
											</tr>
										<?php } ?>






										<tr>
											<!--begin::Checkbox-->
											<td>
												<div class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="1" />
												</div>
											</td>
											<!--end::Checkbox-->
											<!--begin::Name=-->
											<td data-order="index.html">
												<div class="d-flex align-items-center">
													<!--begin::Svg Icon | path: icons/duotune/files/fil003.svg-->
													<span class="svg-icon svg-icon-2x svg-icon-primary me-4">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor" />
															<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<a href="../../demo4/dist/apps/file-manager/files/.html" class="text-gray-800 text-hover-primary">index.html</a>
												</div>
											</td>

											<td class="hidde-responsive-j6">583 KB</td>

											<td class="hidde-responsive-j6">20 Dec 2022, 6:43 am</td>
											<td class="hidde-responsive-j6">Data1</td>
											<td class="hidde-responsive-j6">Data2</td>
											<td class="hidde-responsive-j6">Data3</td>
											<td class="hidde-responsive-j6">Data4</td>

											<td class="text-end" data-kt-filemanager-table="action_dropdown">
												<div class="d-flex justify-content-end">

													<!--begin::More-->
													<div class="ms-2">
														<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
															<!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
															<span class="svg-icon svg-icon-5 m-0">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
																	<rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor" />
																	<rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</button>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">

															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i>View</a>
															</div>
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-pencil" style="padding-right: 4px;"></i>Edit</a>
															</div>
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-trash" style="padding-right: 4px;"></i>Delete</a>
															</div>
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-hourglass-split" style="padding-right: 4px;"></i>History</a>
															</div>
														</div>
														<!--end::Menu-->
														<!--end::More-->
													</div>
												</div>
											</td>
											<!--end::Actions-->
										</tr>
										<tr>
											<!--begin::Checkbox-->
											<td>
												<div class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="1" />
												</div>
											</td>
											<!--end::Checkbox-->
											<!--begin::Name=-->
											<td data-order="landing.html">
												<div class="d-flex align-items-center">
													<!--begin::Svg Icon | path: icons/duotune/files/fil003.svg-->
													<span class="svg-icon svg-icon-2x svg-icon-primary me-4">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor" />
															<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<a href="../../demo4/dist/apps/file-manager/files/.html" class="text-gray-800 text-hover-primary">landing.html</a>
												</div>
											</td>

											<td class="hidde-responsive-j6">87 KB</td>

											<td class="hidde-responsive-j6">19 Aug 2022, 10:10 pm</td>
											<td class="hidde-responsive-j6">Data1</td>
											<td class="hidde-responsive-j6">Data2</td>
											<td class="hidde-responsive-j6">Data3</td>
											<td class="hidde-responsive-j6">Data4</td>

											<td class="text-end" data-kt-filemanager-table="action_dropdown">
												<div class="d-flex justify-content-end">

													<!--begin::More-->
													<div class="ms-2">
														<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
															<!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
															<span class="svg-icon svg-icon-5 m-0">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
																	<rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor" />
																	<rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</button>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">

															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i>View</a>
															</div>
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-pencil" style="padding-right: 4px;"></i>Edit</a>
															</div>
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-trash" style="padding-right: 4px;"></i>Delete</a>
															</div>
															<div class="menu-item px-3">
																<a href="../../demo4/dist/apps/file-manager/files.html" class="menu-link px-3"><i class="bi bi-hourglass-split" style="padding-right: 4px;"></i>History</a>
															</div>
														</div>
														<!--end::Menu-->
														<!--end::More-->
													</div>
												</div>
											</td>
											<!--end::Actions-->
										</tr>
									</tbody>
									<!--end::Table body-->
								</table>
								<!--end::Table-->

							</div>
							<!--end::Card body-->
						</div>
						<!--end::Card-->


					</div>
					<!--end::Container-->
				</div>
				<!--end::Content-->

				<!-- FINAL CONTENIDO PERSONALIZADO -->

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
	<script>
		var hostUrl = "assets/";
	</script>
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Page Vendors Javascript(used by this page)-->
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<!--end::Page Vendors Javascript-->
	<!--begin::Page Custom Javascript(used by this page)-->
	<script src="assets/js/custom/apps/file-manager/list.js"></script>
	<script src="assets/js/widgets.bundle.js"></script>
	<script src="assets/js/custom/widgets.js"></script>
	<script src="assets/js/custom/apps/chat/chat.js"></script>
	<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
	<script src="assets/js/custom/utilities/modals/users-search.js"></script>
	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>