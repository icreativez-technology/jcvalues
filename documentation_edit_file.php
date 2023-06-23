<?php
session_start();
include('includes/functions.php');

$_SESSION['Page_Title'] = "Update File";
$name_file = $_GET['name'];

$sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks, Category, Id_document,language FROM Document WHERE File LIKE '$name_file'";
$conect_datos_document = mysqli_query($con, $sql_datos_document);
$result_datos_document = mysqli_fetch_assoc($conect_datos_document);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->

<!--begin::Body-->
<style>
.required::after {
    content: "*";
    color: #e1261c;
}

.readonly {
    background-color: #e2e3e4 !important;
    border-color: #e2e3e4 !important;
}
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <!-- Includes Top bar and Responsive Menu -->
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <!--begin::Title-->
                        <div>
                            <p><a href="/">Home</a> » <a href="/documentation.php">Documentation</a> » <a
                                    href="/documentation-view-folder.php?name=<?php echo $result_datos_document['Category'] ?>"><?php echo $result_datos_document['Category'] ?></a>
                                »
                                <?php echo $_SESSION['Page_Title']; ?></p>
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

                            <!--begin::Form-->
                            <form class="form" action="includes/update-documentacion.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Title of the document:</label>
                                            <input type="text" oninput="this.value = this.value.toUpperCase()"
                                                class="form-control readonly" name="title_document"
                                                value="<?php echo $result_datos_document['Title_of_the_document']; ?>"
                                                required readonly>
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Document No:</label>
                                            <input type="text" class="form-control readonly" name="formatno"
                                                value="<?php echo $result_datos_document['Format_No']; ?>" required
                                                readonly>
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Rev No:</label>
                                            <input type="number" class="form-control readonly" name="revno"
                                                placeholder="<?php echo $result_datos_document['Rev_No']; ?>"
                                                value="<?php echo $result_datos_document['Rev_No']; ?>" required
                                                readonly>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Prepared by:</label>

                                            <select class="form-control" name="prep" data-control="select2" required>
                                                <option selected="selected" value="">Select an option</option>
                                                <?php
                                                $id_employee = $result_datos_document['Prepared_by'];
                                                $consulta_prepared_by = "SELECT * FROM Basic_Employee ";
                                                $consulta_general_prepared_by = mysqli_query($con, $consulta_prepared_by);
                                                $empArr = array();
                                                while ($result_prepared_by = mysqli_fetch_assoc($consulta_general_prepared_by)) {
                                                    array_push($empArr, $result_prepared_by);
                                                    if ($result_prepared_by['Status'] == 'Active') {
                                                        if ($result_prepared_by['Id_employee'] == $result_datos_document['Prepared_by']) {

                                                ?>
                                                <option value="<?php echo $result_prepared_by['Id_employee']; ?>"
                                                    selected>
                                                    <?php echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name']; ?>
                                                </option>
                                                <?php
                                                        } else {

                                                        ?>
                                                <option value="<?php echo $result_prepared_by['Id_employee']; ?>">
                                                    <?php echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name']; ?>
                                                </option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php if (isset($_GET['notUnique'])) { ?>
                                            <small class="text-danger">Prepared by must not be same as reviewed by
                                                and approved by</small>
                                            <?php } ?>
                                        </div>

                                        <div class="col-lg-4 mb-5">
                                            <input type="hidden" id="empArr" value='<?php echo json_encode($empArr) ?>'>
                                            <label class="required">Reviewd by:</label>
                                            <select class="form-control" name="rev" data-control="select2" required>
                                                <option selected="selected" value="">Select an option</option>
                                                <?php
                                                $id_employee = $result_datos_document['Reviewd_by'];
                                                $consulta_reviewd_by = "SELECT * FROM Basic_Employee ";
                                                $consulta_general_reviewd_by = mysqli_query($con, $consulta_reviewd_by);
                                                while ($result_prepared_by = mysqli_fetch_assoc($consulta_general_reviewd_by)) {
                                                    if ($result_prepared_by['Status'] == 'Active') {
                                                        if ($result_prepared_by['Id_employee'] == $result_datos_document['Reviewd_by']) {

                                                ?>
                                                <option value="<?php echo $result_prepared_by['Id_employee']; ?>"
                                                    selected>
                                                    <?php echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name']; ?>
                                                </option>
                                                <?php
                                                        } else {

                                                        ?>
                                                <option value="<?php echo $result_prepared_by['Id_employee']; ?>">
                                                    <?php echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name']; ?>
                                                </option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php if (isset($_GET['notUnique'])) { ?>
                                            <small class="text-danger">Reviewed by must not be same as Prepared by
                                                and approved by</small>
                                            <?php } ?>
                                        </div>

                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Approved by:</label>


                                            <select class="form-control" name="approv" data-control="select2" required>
                                                <option selected="selected" value="">Select an option</option>
                                                <?php
                                                $id_employee = $result_datos_document['Reviewd_by'];
                                                $consulta_approved_by = "SELECT * FROM Basic_Employee ";
                                                $consulta_general_approved_by = mysqli_query($con, $consulta_approved_by);
                                                while ($result_approved_by = mysqli_fetch_assoc($consulta_general_approved_by)) {
                                                    if ($result_approved_by['Status'] == 'Active') {
                                                        if ($result_approved_by['Id_employee'] == $result_datos_document['Approved_by']) {

                                                ?>
                                                <option value="<?php echo $result_approved_by['Id_employee']; ?>"
                                                    selected>
                                                    <?php echo $result_approved_by['First_Name'] . ' ' . $result_approved_by['Last_Name']; ?>
                                                </option>
                                                <?php

                                                        } else {

                                                        ?>
                                                <option value="<?php echo $result_approved_by['Id_employee']; ?>">
                                                    <?php echo $result_approved_by['First_Name'] . ' ' . $result_approved_by['Last_Name']; ?>
                                                </option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php if (isset($_GET['notUnique'])) { ?>
                                            <small class="text-danger">Approved by must not be same as Prepared by
                                                and Reviewed by</small>
                                            <?php } ?>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Date of preparation:</label>
                                            <input type="date" class="form-control" name="date_prep"
                                                placeholder="<?php echo $result_datos_document['Date_of_preparation']; ?>"
                                                value="<?php echo $result_datos_document['Date_of_preparation']; ?>"
                                                required>
                                        </div>

                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Date of revision:</label>
                                            <input type="date" class="form-control" name="date_rev"
                                                placeholder="<?php echo $result_datos_document['Date_of_revision']; ?>"
                                                value="<?php echo $result_datos_document['Date_of_revision']; ?>"
                                                required>
                                        </div>

                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Date of approval:</label>
                                            <input type="date" class="form-control" name="date_approv"
                                                placeholder="<?php echo $result_datos_document['Date_of_approval']; ?>"
                                                value="<?php echo $result_datos_document['Date_of_approval']; ?>"
                                                required>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Document category:</label>
                                            <input type="text" class="form-control readonly" name="category"
                                                value="<?php echo $result_datos_document['Category']; ?>" id="category"
                                                required readonly>
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <label class="required">Upload file (Max: 10MB) </label>
                                            <input type="file" class="form-control"
                                                accept=".doc, .docx, .xls, .xlsx, .pdf" name="file_docu" id="file_docu"
                                                required>
                                            <?php if (isset($_GET['sizeLarge'])) { ?>
                                            <small class="text-danger">The file size should be with in 10 MB</small>
                                            <?php } ?>
                                            <?php if (isset($_GET['fileExist'])) { ?>
                                            <small class="text-danger">The file Already exist</small>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <label>Language</label>
                                            <input type="hidden" class="form-control readonly" name="language"
                                                value="<?php echo $result_datos_document['language'] ?>" required
                                                readonly>
                                            <input type="text" class="form-control readonly" name="language-text"
                                                value="<?php echo ($result_datos_document['language'] == 0) ? 'English' : "Spanish"; ?>"
                                                required readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mb-1">
                                        <div>
                                            <label for="exampleTextarea">Remarks</label>
                                            <textarea class="form-control" id="exampleTextarea" name="remarks" rows="4"
                                                placeholder="<?php echo $result_datos_document['Remarks']; ?>"
                                                value="<?php echo $result_datos_document['Remarks']; ?>"></textarea required>
														    <input type="hidden" name="Id_document" value="<?php echo $result_datos_document['Id_document']; ?>">
														    <input type="hidden" class="form-control" name="file_old" value="<?php echo $result_datos_document['File']; ?>" id="file_old" required>
														    
														</div>
													</div>
													
													
												</div>
												<div class="card-footer">
                                                <div class="form-group form-group-button" style="float:right">
														
															<input type="submit" class="btn btn-sm btn-success m-3" value="Update">
                                                            <a type="button" href="/documentation-view-folder.php?name=<?php echo $result_datos_document['Category'] ?>" class="btn btn-sm btn-danger">Cancel</a>

														
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
        <script>
                $('[name = "rev"]').on('change', function() {
        const value = $(this).val();
        const prep = $('[name = "prep"]').val();
        const approv = $('[name = "approv"]').val();

        const filterArr = getFilteredArr(value);

        $('[name = "approv"]').empty().append('<option selected="selected" value="">Select an option</option>');
        $('[name = "prep"]').empty().append('<option selected="selected" value="">Select an option</option>');

        filterArr.map((elem) => {
            isAppovSelected = (elem.Id_employee == approv) ? "selected" : "";
            isPrepSelected = (elem.Id_employee == prep) ? "selected" : "";
            if (prep != elem.Id_employee) {
                $('[name = "approv"]').append(
                    `<option value='${elem.Id_employee}' ${isAppovSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
            if (approv != elem.Id_employee) {
                $('[name = "prep"]').append(
                    `<option value='${elem.Id_employee}' ${isPrepSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
        });

    })

    $('[name = "prep"]').on('change', function() {
        const value = $(this).val();
        const approv = $('[name = "approv"]').val();
        const rev = $('[name = "rev"]').val();

        const filterArr = getFilteredArr(value);

        $('[name = "approv"]').empty().append('<option selected="selected" value="">Select an option</option>');
        $('[name = "rev"]').empty().append('<option selected="selected" value="">Select an option</option>');

        filterArr.map((elem) => {
            isAppovSelected = (elem.Id_employee == approv) ? "selected" : "";
            isRevSelected = (elem.Id_employee == rev) ? "selected" : "";
            if (rev != elem.Id_employee) {
                $('[name = "approv"]').append(
                    `<option value='${elem.Id_employee}' ${isAppovSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
            if (approv != elem.Id_employee) {
                $('[name = "rev"]').append(
                    `<option value='${elem.Id_employee}' ${isRevSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
        });

    });

    $('[name = "approv"]').on('change', function() {
        const value = $(this).val();
        const prep = $('[name = "prep"]').val();
        const rev = $('[name = "rev"]').val();

        const filterArr = getFilteredArr(value);

        $('[name = "prep"]').empty().append('<option selected="selected" value="">Select an option</option>');
        $('[name = "rev"]').empty().append('<option selected="selected" value="">Select an option</option>');

        filterArr.map((elem) => {
            isPrepSelected = (elem.Id_employee == prep) ? "selected" : "";
            isRevSelected = (elem.Id_employee == rev) ? "selected" : "";
            if (rev != elem.Id_employee) {
                $('[name = "prep"]').append(
                    `<option value='${elem.Id_employee}' ${isPrepSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
            if (prep != elem.Id_employee) {
                $('[name = "rev"]').append(
                    `<option value='${elem.Id_employee}' ${isRevSelected}>${elem.First_Name} ${elem.Last_Name}</option>`
                );
            }
        });

    })

    function getFilteredArr(value) {
        const dataArr = JSON.parse($('#empArr').val());
        return dataArr?.filter((elem) => elem.Id_employee != value);
    }
        </script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>