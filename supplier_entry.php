<?php
include('includes/functions.php');

$token = $_REQUEST['token'];
$tokenSql = "SELECT * From supplier_nc_capa_token Where token = '$token'";
$fetchToken = mysqli_query($con, $tokenSql);
$tokenInfo = mysqli_fetch_assoc($fetchToken);
$supplier_nc_capa_ncr_id = ($tokenInfo != null) ? $tokenInfo['supplier_nc_capa_ncr_details_id'] : "";

$tokenDisabled = ($fetchToken->num_rows == 0) ? true : false;

$supplierSql = "SELECT * FROM Basic_Supplier";
$supplierConnect = mysqli_query($con, $supplierSql);
$suppliers = mysqli_fetch_all($supplierConnect, MYSQLI_ASSOC);

$sqlNcr = "SELECT * FROM supplier_nc_capa_ncr_details WHERE id = '$supplier_nc_capa_ncr_id' AND is_deleted = 0";
$connecNcr = mysqli_query($con, $sqlNcr);
$ncrDetailsData = mysqli_fetch_assoc($connecNcr);

$lists =  array();
if ($supplier_nc_capa_ncr_id != null || $supplier_nc_capa_ncr_id != "") {
    $listSqlData = "SELECT * FROM supplier_nc_capa_analysis_ncr_modal WHERE supplier_nc_capa_ncr_details_id = '$supplier_nc_capa_ncr_id' AND is_deleted = 0";
    $listData = mysqli_query($con, $listSqlData);

    while ($row = mysqli_fetch_assoc($listData)) {
        array_push($lists, $row);
    }
}

$sqlCorrection = "SELECT * FROM supplier_nc_capa_correction WHERE supplier_nc_capa_ncr_details_id = '$supplier_nc_capa_ncr_id' AND is_deleted = 0";
$connectCorrection = mysqli_query($con, $sqlCorrection);
$correctionData = mysqli_fetch_assoc($connectCorrection);

$correctionDisabled = ($connectCorrection->num_rows == 0) ? true : false;

$sqlAnalysis = "SELECT * FROM supplier_nc_capa_analysis_ca WHERE supplier_nc_capa_ncr_details_id = '$supplier_nc_capa_ncr_id' AND is_deleted = 0";
$connectAnalysis = mysqli_query($con, $sqlAnalysis);
$analysisData = mysqli_fetch_assoc($connectAnalysis);

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!--begin::Body-->
<style>
.tab-disabled,
.ver-disabled input {
    background-color: #e9ecef !important;
}

.text-grey {
    color: #7e8293 !important;
    display: flex;
    font-size: 15px;
    /* margin-left: 20px; */
}
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">

    <div class="row">
        <div class="d-flex align-items-center justify-content-between p-4" style="background-color: #fff">
            <div class="d-flex align-items-center justify-content-between" style="width: 100% !important;">
                <img alt="Logo" src="logo/admin-logo.png" class="h-60px w-70px ms-6" />
                <div>
                    <h1 class="dqmstitle">DQMS</h1>
                    <p class="dqmssubtitle">( Digital Quality Management Suite )</p>
                </div>
                <div></div>
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid <?php echo $tokenDisabled ? "d-none" : "" ?>"
            id="kt_content">
            <!--begin::Container-->
            <div class="container-custom" id="kt_content_container">
                <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link <?php echo (isset($_GET['ncr'])) ? "active" : "" ?> <?php echo (sizeof($_GET) == 1 || isset($_GET['view'])) ? "active" : ''; ?>"
                            id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab"
                            aria-controls="details" aria-selected="true">NCR Details</button>
                    </li>
                    <li class="nav-item  <?php echo $ncrDisabled ? "tab-disabled" : "" ?>" role="presentation">
                        <button class="nav-link <?php echo (isset($_GET['correction'])) ? "active" : "" ?>"
                            id="correction-tab" data-bs-toggle="tab" data-bs-target="#correction" type="button"
                            role="tab" aria-controls="mitigation" aria-selected="false">Correction</button>
                    </li>
                    <li class="nav-item <?php echo $correctionDisabled ? "tab-disabled" : "" ?>" role="presentation">
                        <button class="nav-link  <?php echo (isset($_GET['analysisCa'])) ? "active" : "" ?>"
                            id="analysis_capa_tab" data-bs-toggle="tab" data-bs-target="#analysis_capa" type="button"
                            role="tab" aria-controls="analysis_capa" aria-selected="false"
                            <?php echo $correctionDisabled ? "disabled" : "" ?>>Analysis & CAPA</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade <?php echo (isset($_GET['ncr'])) ? "active show" : "" ?> <?php echo (sizeof($_GET) == 1 || isset($_GET['view'])) ? "active show" : ''; ?>"
                        id="details" role="tabpanel" aria-labelledby="details-tab">
                        <div class="card card-flush mt-4">
                            <form class="form" action="includes/supplier_nc_capa_update.php" method="post"
                                enctype="multipart/form-data">
                                <!-- begin::Form Content -->
                                <div class="card-body">
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <label class="required">Supplier Name</label>
                                            <div class="mt-2 text-grey">
                                                <?php
                                                foreach ($suppliers as $supplier) {
                                                    if ($ncrDetailsData['supplier_id'] == $supplier['Id_Supplier']) { ?>
                                                <label><?php echo $supplier['Supplier_Name']; ?></label>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Date</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo date("d-m-y", strtotime($ncrDetailsData['date'])); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Delivery Note</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['delivery_note']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">PO Number</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['po_number']; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="required">Line Item</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['line_item']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Part Number</label>
                                            <div class="mt-2 text-grey">
                                                <?php
                                                $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                    if ($ncrDetailsData['part_number'] == $result_data['Id_department']) {
                                                        echo $result_data['Department'];
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Part Description</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['part_description'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Serial No/Heat No</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['serial_no'] ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label class="required">Material</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['material'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Lot Quantity</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['lot_quantity'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Inspected Quantity</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['inspected_quantity'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Accepted Quantity</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['accepted_quantity'] ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="required">QTY NC's</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo  $ncrDetailsData['qty_nc'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Stock Affected (if Applicable)</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['stock_affected'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>NCR Classification </label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['ncr_classification'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Classification Details</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['classification_details'] ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="required">Action with NC Material</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['action_with_nc_material'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="required">Non conformance Description</label>
                                            <div class="mt-2 text-grey">
                                                <?php echo $ncrDetailsData['non_conformance_description'] ?>
                                            </div>
                                        </div>
                                        <?php
                                        $sql_data = "SELECT * FROM supplier_nc_capa_ncr_details_files WHERE supplier_nc_capa_ncr_details_id = '$ncrDetailsData[id]' AND is_deleted = 0";
                                        $connect_data = mysqli_query($con, $sql_data);
                                        if (mysqli_num_rows($connect_data)) {
                                        ?>
                                        <div class="col-lg-6 ">
                                            <div class="custom-select mt-6">
                                                <div class="tag-wrapper">
                                                    <?php
                                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        ?>
                                                    <div class="tags">
                                                        <a href="<?php echo $result_data['file_path']; ?>"
                                                            target="_blank"><?php echo $result_data['file_name']; ?></a>
                                                        <input type="hidden" class="form-control" name="existingFiles[]"
                                                            value="<?php echo $result_data['id']; ?>">
                                                    </div>
                                                    <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_ncr_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                <th class="min-w-400px ps-3">Description Action Adopted By
                                                    JC</th>
                                                <th class="min-w-100px">Responsible</th>
                                                <th class="min-w-100px">Target Date</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600" id="list-table">
                                            <input type="hidden" name="dataArr" id="dataArr"
                                                value='<?php echo json_encode($lists) ?>'>
                                            <?php if ($lists && count($lists) > 0) {
                                                foreach ($lists as $key => $list) { ?>
                                            <tr id="<?php echo $key  ?>">
                                                <td><input type="hidden" class="form-control"
                                                        name="description_of_action[]"
                                                        value="<?php echo $list['description_of_action']; ?>" required>
                                                    <?php echo $list['description_of_action']; ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" class="form-control" name="responsible[]"
                                                        value="<?php echo $list['responsible']; ?>" required>
                                                    <?php echo $list['responsible']; ?>

                                                </td>
                                                <td>
                                                    <input type="hidden" class="form-control" name="target_date[]"
                                                        value="<?php echo $list['target_date']; ?>" required>
                                                    <?php echo $list['target_date']; ?>
                                                </td>
                                            </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade <?php echo (isset($_GET['correction'])) ? "active show" : "" ?>"
                        id="correction" role="tabpanel" aria-labelledby="mitigation-tab">
                        <div class="card card-flush">
                            <form class="form" action="includes/supplier_nc_capa_correction.update.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row mt-4">
                                        <input type="hidden" class="form-control" name="supplier_nc_capa_ncr_id"
                                            value="<?php echo $ncrDetailsData['id'] ?>">
                                        <input type="hidden" class="form-control" name="id"
                                            value="<?php echo $correctionData['id'] ?>">
                                        <input type="hidden" class="form-control" name="supplier_entry" value="true">
                                        <div class="col-md-12">
                                            <label class="required">Correction</label>
                                            <textarea type="text" class="form-control" name="correction" rows="2"
                                                value="<?php echo $correctionData['correction'] ?>"
                                                required><?php echo $correctionData['correction'] ?></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer m-6">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-6">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade <?php echo (isset($_GET['analysisCa'])) ? "active show" : "" ?>"
                        id="analysis_capa" role="tabpanel" aria-labelledby="analysis_capa-tab">
                        <div class="card card-flush">
                            <form class="form" action="includes/supplier_nc_capa_analysis_ca.update.php" method="post"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row mt-2">
                                        <input type="hidden" class="form-control" name="supplier_nc_capa_ncr_id"
                                            value="<?php echo $ncrDetailsData['id'] ?>">
                                        <input type="hidden" class="form-control" name="id"
                                            value="<?php echo $analysisData['id'] ?>">
                                        <input type="hidden" class="form-control" name="supplier_entry" value="true">
                                        <div class="col-md-12">
                                            <label class="required">Root Cause Analysis</label>
                                            <textarea type="text" class="form-control" name="root_cause_analysis"
                                                rows="2" value="<?php echo $analysisData['root_cause_analysis'] ?>"
                                                required><?php echo $analysisData['root_cause_analysis'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <label class="required">Corrective Action</label>
                                            <textarea type="text" class="form-control" name="corrective_action" rows="2"
                                                value="<?php echo $analysisData['corrective_action'] ?>"
                                                required><?php echo $analysisData['root_cause_analysis'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <label class="required">Preventive Action</label>
                                            <textarea type="text" class="form-control" name="preventive_action" rows="2"
                                                value="<?php echo $analysisData['preventive_action'] ?>"
                                                required><?php echo $analysisData['preventive_action'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="required">Responsible</label>
                                            <input type="text" class="form-control" name="responsible"
                                                value="<?php echo $analysisData['responsible'] ?>" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="required">Date Of Implementation</label>
                                            <input type="date" class="form-control" name="date_of_implementation"
                                                value="<?php echo $analysisData['date_of_implementation'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer m-6">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Save
                                            </button>
                                            <a type="button"
                                                href="includes/supplier_entry_token_update.php?id=<?php echo $tokenInfo['id'] ?>"
                                                class="btn btn-sm btn-primary ms-2">Submit</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid <?php echo $tokenDisabled ? "" : "d-none" ?>">
            <!--begin::Container-->
            <div class="d-flex justify-content-center h-70px">
                <div>
                    <h2 class="mt-6">Token Has Been Expired</h2>
                </div>
            </div>
        </div>
    </div>

    </div>
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
</body>
<!--end::Body-->

</html>