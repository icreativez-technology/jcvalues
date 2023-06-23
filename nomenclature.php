<?php 
session_start();
include('includes/functions.php');	
$_SESSION['Page_Title'] = "Nomenclature";


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
					<!--begin::Search form-->
					<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover banner-inicio">
						<!--begin::body-->
						<div class="card-body container-fluid pt-10 pb-8">
							<!--begin::Title-->
							<div class="d-flex align-items-center">
								<h1 class="fw-bold me-3 text-white text-center">Nomenclature</h1>
							</div>
							<!--end::Title-->
							<!--begin::Wrapper-->
							<!--end::Wrapper-->
						</div>
						<!--end::body-->
					</div>
					<!--end::Search form-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container-xxl" id="kt_content_container">


							<!--begin::FAQ card-->
							<div class="card">
								<!--begin::Body-->
								<div class="card-body p-lg-15">
									<!--begin::Layout-->
									<div class="d-flex flex-column flex-lg-row">
										<!--begin::Sidebar-->
										<div class="flex-column flex-lg-row-auto w-100 w-lg-275px mb-10 me-lg-20">
											<!--begin::Catigories-->
											<div class="mb-15">
												<h4 class="text-black mb-7">Modules</h4>
												<!--begin::Menu-->
												<div class="menu menu-rounded menu-column menu-title-gray-700 menu-state-title-primary menu-active-bg-light-primary fw-bold">
													<!--begin::Item-->
													<div class="menu-item mb-1">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu active" id="audit-link">Audit Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item mb-1">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="supplier-link">Supplier Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item mb-1">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="nc-link">Non-conformance Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item mb-1">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="kaizen-link">Kaizen Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item mb-1">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="sugg-link">Suggestion Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="nm-link">Near Miss Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="quality-link">Quality Deviation Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="doc-link">Document Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="calibration-link">Calibration Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="kpi-link">KPI / OKR Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="meeting-link">Meeting Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->

													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="complaint-link">Customer Complaint</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->

													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="inspection-link">Customer Inspection</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->

													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="moc-link">Management of Change</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->

													<!--begin::Item-->
													<div class="menu-item">
														<!--begin::Link-->
														<a href="#pointerofnomen" class="menu-link py-3 nomenmenu" id="risk-link">Risk Assesment Management</a>
														<!--end::Link-->
													</div>
													<!--end::Item-->
												</div>
												<!--end::Menu-->
											</div>
											<!--end::Catigories-->
										</div>
										<!--end::Sidebar-->
										<!--begin::Content-->
										<div class="flex-lg-row-fluid" id="pointerofnomen">
											<!--begin::Extended content-->
											<div class="mb-13">
												<div style="text-align: right;">
													<i class="bi bi-question-diamond-fill fs-5tx text-gray-200"></i>
												</div>
												<!--begin::Content-->
												<div class="mb-15 nom-card active-nom-card" id="audit-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">AUDIT MANAGEMENT (INTERNAL AND EXTERNAL)</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">An audit is a process of examining the process that is followed in the business as per the standards, Regulations, Rules, Procedures, etc. It is majorly done to impart the sustenance of the practice/improvement & also the level of understanding & implementation of the requirements.</p>

													<p class="py-3" style="text-align: justify;">Paperless Audit module help organizations to conduct various types of audits (ISO, TPM, TQM, 5S, etc.) without files, storage space & with fewer employee effort. This makes the process simpler & more user-friendly.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="supplier-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">SUPPLIER MANAGEMENT (AUDIT, SUPPLIER PERFORMANCE, APPROVED MATRIX)</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Suppliers are the inherent part of the business & play a vital role in the business performance in terms of products as well as services. Supplier identification, managing them with right support at right time & improve them will help the organizations to achieve better results.</p>

													<p class="py-3" style="text-align: justify;">Considering the importance of them, Organizations need to follow a robust mechanism to manage at less cost. Supplier Management module helps in monitoring their performance with the Audit & NCR process.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="nc-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">NON-CONFORMANCE MANAGEMENT (PROCESS, PRODUCT)</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Quality & Stability of the process ensures the delivery of the right product to the customers. Organizations have to implement a system to raise the alarm when the quality & stability of the process is not as per the specification.</p>

													<p class="py-3" style="text-align: justify;">This module gives employees options to raise the Non-Conformance found and assign to the respective departments directly and the analyse with problem-solving tools, identify Root Cause followed by Implementation of Corrective Action, Preventive action with verification at last.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="kaizen-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">KAIZEN MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Employees are the real asset of an organization, Other than the regular routine job, organizations have to give a right platform for them to engage with the growth of the organization. Many small improvements make a big change.</p>

													<p class="py-3" style="text-align: justify;">Digital Kaizen module gives the features to register the improvement done at their workplace & announce it to others build confidence in themselves and gets motivated to do many more.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="sugg-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">SUGGESTION MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Idea or Suggestion arises in the mind when an employee is keen on observing the activities or a process and thinking for the betterment. It is important to get it captured for validation & implementation. A small idea results in a BIG impact.</p>

													<p class="py-3" style="text-align: justify;">Digital Suggestion scheme modules get the idea & send it to the respective team for validation followed by deriving the actions to implement.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="nm-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">EHS INCIDENT / NEAR MISS MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">The cost of human life is priceless. Employees in an organization work with risks & hazards. There are standards that impose on organizations to improve the Safety level to safeguard the employees.</p>

													<p class="py-3" style="text-align: justify;">Identifying the RISK, HAZARDS, NEAR MISS & INCIDENT in the work place is a mandatory requirement & necessary actions have to be taken to take care of the employees.</p>

													<p class="py-3" style="text-align: justify;">EHS software module has the option to register the risk identified & notify the concerned team to take the actions to improve the safety level.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="quality-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">QUALITY DEVIATION MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">.</p>

													<p class="py-3" style="text-align: justify;">.</p>

													<p class="py-3" style="text-align: justify;">.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="doc-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">DOCUMENT MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Documents in an organization are much important to an extent we can call them ASSET.</p>

													<p class="py-3" style="text-align: justify;">Document available in different forms like Standards, Manual, SOPs, Procedures, Formats, Reports, Registers, etc, traditionally these were in the physical format which consumes more space, storage is tedious, tend to lose & retrieval is not easy.</p>

													<p class="py-3" style="text-align: justify;">Communication of latest revised documents to employees or team involves more resources in terms of paper copy circulation. Referring to the old version of the document impacts the quality of the deliverable.</p>

													<p class="py-3" style="text-align: justify;">Digital Document Management system, storage, security, circulation, authentication & approval is well-taken care of with technology without physical space.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="calibration-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">CALIBRATION MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Calibration refers to the comparison of the output against the specific range. Calibration of the Instruments used in the workplace is highly important because the output of the product is measured with these instruments.</p>

													<p class="py-3" style="text-align: justify;">The organization has to calibrate the instruments on regular basis to ensure the precision & accuracy are within the international standards.</p>

													<p class="py-3" style="text-align: justify;">Digital Calibration Management software helps the organization to manage the instruments right from Calibration due, tracking of the usage, rejection & history of the instrument.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="kpi-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">KPI / OKR MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Initial step for the growth of an organization is determined with the VISION & Strategy built by the Leaders followed by defining the right Key Performance Indicator (KPI) with Target & timeline for right people or team. Achievement of the KPI happens only when the action points get completed ON TIME with desired outcome.</p>

													<p class="py-3" style="text-align: justify;">We found huge GAP in many organizations among Vision, Strategy, KPIs & Action points in terms of setting up or alignment of each other or monitoring the progress.</p>

													<p class="py-3" style="text-align: justify;">Goal Management software module bridges the gap & make the alignment to achieve the VISION of an organization.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="meeting-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">MEETING MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Meeting is an integral part of the business; Day starts with the meeting & ends with the meeting. It is important to run a meeting efficiently & it is more important to monitor the closure of the action points (Minutes of Meeting – MoM) raised.</p>

													<p class="py-3" style="text-align: justify;">This is the major gap or lacuna in a business, if this gets fixed up next meeting on the same subject runs very efficiently with less time & highly focused.</p>

													<p class="py-3" style="text-align: justify;">Meeting Management module have the features from scheduling the meeting to monitor the closure of the MOM raised to save the time & efforts of employees to work in another deliverables.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="complaint-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">CUSTOMER COMPLAINT MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Voice of the customer is engaged in two stages of a business one during the product design & another after the delivery of our product or services.</p>

													<p class="py-3" style="text-align: justify;">The second stage is the important stage where the organizations brand get affected directly in the market. Hearing the customer & attending to the need in a structured way makes the customer feel confident in the process.</p>

													<p class="py-3" style="text-align: justify;">Customer Complaint Management software allows the customers to raise their voice & send to customers for the further course of action in a detailed structured way as per the problem-solving methodology.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="inspection-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">CUSTOMER INSPECTION MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Products or Services will be done based on the customer specification and it has to be confirmed before handover to the customer with the Final Inspection.</p>

													<p class="py-3" style="text-align: justify;">Based on the importance of the product or service customer will be involved in inspection at the final stage or at different stages of operations.</p>

													<p class="py-3" style="text-align: justify;">Visibility of the customer inspection plan & monitoring the closure in a single page not available is the current problem.</p>
													<p class="py-3" style="text-align: justify;">Customer Inspection module makes life easier in creating the customer inspection plan and sharing the visibility of the status to everyone in the organization which will help the team to organize the activities accordingly.</p>
													<p class="py-3" style="text-align: justify;">We could able to know the number of inspectors/customers available in the organization.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="moc-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">CHANGE MANAGEMENT / MANAGEMENT OF CHANGE</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Change in the process, key employees, policy or addition of new process impacts the existing system.</p>

													<p class="py-3" style="text-align: justify;">The same has to be assessed, documented & communicated in the organization. Managing the process with paper is not effective.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->

												<!--begin::Content-->
												<div class="mb-15 nom-card" id="risk-card">
													<!--begin::Title-->
													<h4 class="fs-2 text-gray-800 w-bolder mb-7">RISK ASSESMENET MANAGEMENT</h4>
													<!--end::Title-->
													<!--begin::Text-->
													<p class="py-3" style="text-align: justify;">Any process will have risk associated and impact of it determines the level of attention given to eliminate it. Risk Assessment is a major task in any organization at all levels with mitigation plan, reassessment & approval.</p>

													<p class="py-3" style="text-align: justify;">Organization follows the traditional process to implement it where Excel, paper is used. Risk assessment module makes the process robust and efficient.</p>
													<!--end::Text-->
												</div>
												<!--end::Content-->


											</div>
											<!--end::Extended content-->
										</div>
										<!--end::Content-->
									</div>
									<!--end::Layout-->
									
								</div>
								<!--end::Body-->
							</div>
							<!--end::FAQ card-->
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

		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->

		<!-- custom links -->

		<script>
		$(document).ready(function(){
			
		    $(function(){
			   $('.nomenmenu').click(function(){
			      /*remove active*/
			      $(".active-nom-card").removeClass("active-nom-card");
			      $(".active").removeClass("active");
			      /*add actual active*/

			      var thisId = '#'+$(this).attr('id');
			      $( thisId ).addClass("active");
			      
			      var thisId2 = $(this).attr('id');
			      var before = thisId2.substring(0, thisId2.indexOf('-'));
			      var card = '#'+before+"-card";
			      $( card ).addClass("active-nom-card");
			   });
			});
		    

		    //nomenmenu

		    /*$(function(){
			   $('.nomenmenu').click(function(){
			      //alert( $(this).attr('id') );
			      var thisId = '#'+$(this).attr('id');
			       $(".active").removeClass("active");
			       $("#audit-link").addClass("active");
			       $(".active-nom-card").removeClass("active-nom-card");
			       $("#audit-card").addClass("active-nom-card");
			   });
			});*/

		    /*$("#audit-link").click(function(){
		       $(".active").removeClass("active");
		       $("#audit-link").addClass("active");
		       $(".active-nom-card").removeClass("active-nom-card");
		       $("#audit-card").addClass("active-nom-card");
		    });
			
			$("#supplier-link").click(function(){
		       $(".active").removeClass("active");
		       $("#supplier-link").addClass("active");
		       $(".active-nom-card").removeClass("active-nom-card");
		       $("#supplier-card").addClass("active-nom-card");
		    });


			$("#nc-link").click(function(){
		        $(".active").removeClass("active");
		       $("#nc-link").addClass("active");
		       $(".active-nom-card").removeClass("active-nom-card");
		       $("#nc-card").addClass("active-nom-card");
		    });*/


		});
		</script>


	</body>
	<!--end::Body-->
</html>