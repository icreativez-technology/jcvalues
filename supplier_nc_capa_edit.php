<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Supplier NC & CAPA Edit";

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];

$tokenSql = "SELECT * From supplier_nc_capa_token Where supplier_nc_capa_ncr_details_id = '$_REQUEST[id]'";
$fetchToken = mysqli_query($con, $tokenSql);
$tokenDisabled = ($fetchToken->num_rows == 0) ? true : false;

$supplierSql = "SELECT * FROM Basic_Supplier";
$supplierConnect = mysqli_query($con, $supplierSql);
$suppliers = mysqli_fetch_all($supplierConnect, MYSQLI_ASSOC);

$sqlNcr = "SELECT * FROM supplier_nc_capa_ncr_details WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connecNcr = mysqli_query($con, $sqlNcr);
$ncrDetailsData = mysqli_fetch_assoc($connecNcr);

$listSqlData = "SELECT * FROM supplier_nc_capa_analysis_ncr_modal WHERE is_deleted = 0 AND supplier_nc_capa_ncr_details_id = '$_REQUEST[id]'";
$listData = mysqli_query($con, $listSqlData);
$lists =  array();
while ($row = mysqli_fetch_assoc($listData)) {
    array_push($lists, $row);
}

$sqlCorrection = "SELECT * FROM supplier_nc_capa_correction WHERE supplier_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectCorrection = mysqli_query($con, $sqlCorrection);
$correctionData = mysqli_fetch_assoc($connectCorrection);

$correctionDisabled = ($connectCorrection->num_rows == 0) ? true : false;

$sqlAnalysis = "SELECT * FROM supplier_nc_capa_analysis_ca WHERE supplier_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectAnalysis = mysqli_query($con, $sqlAnalysis);
$analysisData = mysqli_fetch_assoc($connectAnalysis);

$analysisDisabled = ($connectAnalysis->num_rows == 0) ? true : false;

$sqlVerification = "SELECT * FROM supplier_nc_capa_verification WHERE supplier_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectVerification = mysqli_query($con, $sqlVerification);
$verificationData = mysqli_fetch_assoc($connectVerification);

/*
//css implemented for this
$enable="";
if(isset($_GET['view'])){
  $enable = 'disabled';
}*/

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

    .list-add {
        background-color: transparent;
        padding: 2px 5px;
        border-radius: 50%;
        font-size: 12px;
        color: #fff !important;
        cursor: pointer;
    }

    .list-add i {
        color: #fff;
    }

    #ncr_detail_form {
        height: 100%;
    }
</style>
    <?php
    if(isset($_GET['view'])){
    ?>
    <link href="assets/css/form-viewonly.css" rel="stylesheet" type="text/css" />
    <?php } ?>

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
                        <div>
                            <p><a href="/">Home</a> » <a href="/supplier_nc_capa.php">Supplier NC & CAPA</a> » <a href="/supplier_nc_capa_view_list.php">Supplier NC & CAPA View List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                    <!--end::body-->
                </div>
                <!--end::BREADCRUMBS-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['ncr'])) ? "active" : "" ?> <?php echo (sizeof($_GET) == 1 || isset($_GET['view'])) ? "active" : ''; ?>" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">NCR Details</button>
                            </li>
                            <li class="nav-item  <?php echo $tokenDisabled ? "" : "tab-disabled" ?>" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['correction'])) ? "active" : "" ?>" id="correction-tab" data-bs-toggle="tab" data-bs-target="#correction" type="button" role="tab" aria-controls="mitigation" aria-selected="false" <?php echo $tokenDisabled ? "" : "disabled" ?>>Correction</button>
                            </li>
                            <li class="nav-item <?php echo $tokenDisabled ? "" : "tab-disabled" ?>" role="presentation">
                                <button class="nav-link  <?php echo (isset($_GET['analysisCa'])) ? "active" : "" ?>" id="analysis_capa_tab" data-bs-toggle="tab" data-bs-target="#analysis_capa" type="button" role="tab" aria-controls="analysis_capa" aria-selected="false" <?php echo $tokenDisabled ? "" : "disabled" ?>>Analysis & CAPA</button>
                            </li>
                            <li class="nav-item <?php echo $tokenDisabled ? "" : "tab-disabled" ?>" role="presentation">
                                <button class="nav-link  <?php echo (isset($_GET['verification'])) ? "active" : "" ?>" id="verification-tab" data-bs-toggle="tab" data-bs-target="#verification" type="button" role="tab" aria-controls="verification" aria-selected="false" <?php echo $tokenDisabled ? "" : "disabled" ?>>Verification</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?php echo (isset($_GET['ncr'])) ? "active show" : "" ?> <?php echo (sizeof($_GET) == 1 || isset($_GET['view'])) ? "active show" : ''; ?>" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card card-flush mt-4">
                                    <form class="form" <?php echo $enable; ?> action="includes/supplier_nc_capa_update.php" method="post" enctype="multipart/form-data">
                                        <!-- begin::Form Content -->
                                        <div class="card-body">
                                            <div class="row">
                                                <input type="hidden" class="form-control" name="supplier_nc_capa_ncr_id" value="<?php echo $ncrDetailsData['id'] ?>">
                                                <input type="hidden" class="form-control" name="supplier_nc_capa_id" value="<?php echo $ncrDetailsData['supplier_nc_capa_id'] ?>">
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Supplier Name</label>
                                                    <select class="form-control" name="supplier_id" required >
                                                        <option value="">Please Select</option>
                                                        <?php foreach ($suppliers as $supplier) { ?>
                                                            <option value="<?php echo $supplier['Id_Supplier']; ?>" <?php echo ($ncrDetailsData['supplier_id'] == $supplier['Id_Supplier']) ? 'selected' : ''; ?>>
                                                                <?php echo $supplier['Supplier_Name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <label class="required">Date</label>
                                                    <input type="date" class="form-control" name="date" value="<?php echo $ncrDetailsData['date'] ?>" required />
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Delivery Note</label>
                                                    <input type="text" class="form-control" name="delivery_note" value="<?php echo $ncrDetailsData['delivery_note'] ?>" required />
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <label class="required">PO Number</label>
                                                    <input type="text" class="form-control" name="po_number" value="<?php echo $ncrDetailsData['po_number'] ?>" required />
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <label class="required">Line Item</label>
                                                    <input type="text" class="form-control" name="line_item" value="<?php echo $ncrDetailsData['line_item'] ?>" required />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Part Number</label>
                                                    <input type="text" class="form-control" name="part_number" value="<?php echo $ncrDetailsData['part_number'] ?>" required />
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Part Description</label>
                                                    <input type="text" class="form-control" name="part_description" value="<?php echo $ncrDetailsData['part_description'] ?>" required />
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Serial No/Heat No</label>
                                                    <input type="text" class="form-control" name="serial_no" value="<?php echo $ncrDetailsData['serial_no'] ?>" required />
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Material</label>
                                                    <input type="text" class="form-control" name="material" value="<?php echo $ncrDetailsData['material'] ?>" required />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2 mt-5">
                                                    <label class="required">Lot Quantity</label>
                                                    <input type="text" class="form-control" name="lot_quantity" value="<?php echo $ncrDetailsData['lot_quantity'] ?>" required />
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <label class="required">Inspected Quantity</label>
                                                    <input type="text" class="form-control" name="inspected_quantity" value="<?php echo $ncrDetailsData['inspected_quantity'] ?>" required />
                                                </div>
                                                <div class="col-lg-2 mt-5">
                                                    <label class="required">Accepted Quantity</label>
                                                    <input type="text" class="form-control" name="accepted_quantity" value="<?php echo $ncrDetailsData['accepted_quantity'] ?>" required />
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">QTY NC's</label>
                                                    <input type="text" class="form-control" name="qty_nc" value="<?php echo $ncrDetailsData['qty_nc'] ?>" required />
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label>Stock Affected (if Applicable)</label>
                                                    <input type="text" class="form-control" name="stock_affected" value="<?php echo $ncrDetailsData['stock_affected'] ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 mt-5">
                                                    <label>NCR Classification </label>
                                                    <select class="form-control" name="ncr_classification">
                                                        <option value="">Please Select</option>
                                                        <option value="Minor" <?php echo ($ncrDetailsData['ncr_classification'] == 'Minor') ? 'selected' : ''; ?>>
                                                            Minor</option>
                                                        <option value="Major" <?php echo ($ncrDetailsData['ncr_classification'] == 'Major') ? 'selected' : ''; ?>>
                                                            Major</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Classification Details</label>
                                                    <input type="text" class="form-control" name="classification_details" value="<?php echo $ncrDetailsData['classification_details'] ?>" required />
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Action with NC Material</label>
                                                    <select class="form-control" name="action_with_nc_material" required>
                                                        <option value="">Please Select</option>
                                                        <option value="Accept" <?php echo ($ncrDetailsData['action_with_nc_material'] == 'Accept') ? 'selected' : ''; ?>>
                                                            Accept</option>
                                                        <option value="Reject" <?php echo ($ncrDetailsData['action_with_nc_material'] == 'Reject') ? 'selected' : ''; ?>>
                                                            Reject</option>
                                                        <option value="Repair" <?php echo ($ncrDetailsData['action_with_nc_material'] == 'Repair') ? 'selected' : ''; ?>>
                                                            Repair</option>
                                                        <option value="Concession" <?php echo ($ncrDetailsData['action_with_nc_material'] == 'Concession') ? 'selected' : ''; ?>>
                                                            Concession</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 mt-5">
                                                    <label class="required">Upload Evidence</label>
                                                    <input type="file" class="form-control" name="files[]" accept=".pdf" multiple required />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 mt-5">
                                                    <label class="required">Non conformance Description</label>
                                                    <textarea type="text" class="form-control" name="non_conformance_description" rows="1" value="<?php echo $ncrDetailsData['non_conformance_description'] ?>" required><?php echo $ncrDetailsData['non_conformance_description'] ?></textarea>
                                                </div>
                                                <?php
                                                $sql_data = "SELECT * FROM supplier_nc_capa_ncr_details_files WHERE supplier_nc_capa_ncr_details_id = '$ncrDetailsData[id]' AND is_deleted = 0";
                                                $connect_data = mysqli_query($con, $sql_data);
                                                if (mysqli_num_rows($connect_data)) {
                                                ?>
                                                    <div class="col-lg-6 mt-6">
                                                        <label></label>
                                                        <div class="custom-select mt-1">
                                                            <div class="tag-wrapper">
                                                                <?php
                                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                ?>
                                                                    <div class="tags">
                                                                        <span class="remove-tag"></span>
                                                                        <a href="<?php echo $result_data['file_path']; ?>" target="_blank"><?php echo $result_data['file_name']; ?></a>
                                                                        <input type="hidden" class="form-control" name="existingFiles[]" value="<?php echo $result_data['id']; ?>">
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
                                            <div class="container-full customer-header d-flex justify-content-between mt-4">
                                                NCR Details
                                                <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#ncr_detail_modal"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="row" style="padding:0px 20px">
                                                <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_ncr_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                            <th class="min-w-400px ps-3">Description Action Adopted By
                                                                JC</th>
                                                            <th class="min-w-100px">Responsible</th>
                                                            <th class="min-w-100px">Target Date</th>
                                                            <th class="min-w-100px pe-3">Action</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600" id="list-table">
                                                        <input type="hidden" name="dataArr" id="dataArr" value='<?php echo json_encode($lists) ?>'>
                                                        <?php if ($lists && count($lists) > 0) {
                                                            foreach ($lists as $key => $list) { ?>
                                                                <tr id="<?php echo $key  ?>">
                                                                    <td><input type="hidden" class="form-control" name="description_of_action[]" value="<?php echo $list['description_of_action']; ?>" required>
                                                                        <?php echo $list['description_of_action']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" class="form-control" name="responsible[]" value="<?php echo $list['responsible']; ?>" required>
                                                                        <?php echo $list['responsible']; ?>

                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" class="form-control" name="target_date[]" value="<?php echo $list['target_date']; ?>" required>
                                                                        <?php echo $list['target_date']; ?>
                                                                    </td>
                                                                    <td class="list-row" style="vertical-align:middle">
                                                                        <a class="list-edit cursor-pointer me-2" data-id="<?php echo $list['id'] ?>"><i class="bi bi-pencil"></i></a>
                                                                        <a class="list-remove cursor-pointer" data-id="<?php echo $list['id'] ?></td>"><i class="bi bi-trash"></i></a>
                                                                    </td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer m-6">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-6">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Save
                                                    </button>
                                                    <a type="button" href="/supplier_nc_capa_view_list.php" class="btn btn-sm btn-secondary ms-2">Close</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade <?php echo (isset($_GET['correction'])) ? "active show" : "" ?>" id="correction" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/supplier_nc_capa_correction.update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row mt-5">
                                                <input type="hidden" class="form-control" name="supplier_nc_capa_ncr_id" value="<?php echo $ncrDetailsData['id'] ?>">
                                                <input type="hidden" class="form-control" name="id" value="<?php echo $correctionData['id'] ?>">
                                                <input type="hidden" class="form-control" name="supplier_entry" value="false">
                                                <div class="col-md-12">
                                                    <label class="required">Correction</label>
                                                    <textarea type="text" class="form-control" name="correction" rows="2" value="<?php echo $correctionData['correction'] ?>" required><?php echo $correctionData['correction'] ?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer m-6">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-6">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Save
                                                    </button>
                                                    <a type="button" href="/supplier_nc_capa_view_list.php" class="btn btn-sm btn-secondary ms-2">Close</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade <?php echo (isset($_GET['analysisCa'])) ? "active show" : "" ?>" id="analysis_capa" role="tabpanel" aria-labelledby="analysis_capa-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/supplier_nc_capa_analysis_ca.update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row mt-5">
                                                <input type="hidden" class="form-control" name="supplier_nc_capa_ncr_id" value="<?php echo $ncrDetailsData['id'] ?>">
                                                <input type="hidden" class="form-control" name="id" value="<?php echo $analysisData['id'] ?>">
                                                <input type="hidden" class="form-control" name="supplier_entry" value="false">
                                                <div class="col-md-12">
                                                    <label class="required">Root Cause Analysis</label>
                                                    <textarea type="text" class="form-control" name="root_cause_analysis" rows="2" value="<?php echo $analysisData['root_cause_analysis'] ?>" required><?php echo $analysisData['root_cause_analysis'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-5">
                                                    <label class="required">Corrective Action</label>
                                                    <textarea type="text" class="form-control" name="corrective_action" rows="2" value="<?php echo $analysisData['corrective_action'] ?>" required><?php echo $analysisData['corrective_action'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-5">
                                                    <label class="required">Preventive Action</label>
                                                    <textarea type="text" class="form-control" name="preventive_action" rows="2" value="<?php echo $analysisData['preventive_action'] ?>" required><?php echo $analysisData['preventive_action'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 mt-5">
                                                    <label class="required">Responsible</label>
                                                    <input type="text" class="form-control" name="responsible" value="<?php echo $analysisData['responsible'] ?>" required>
                                                </div>

                                                <div class="col-lg-6 mt-5">
                                                    <label class="required">Date Of Implementation</label>
                                                    <input type="date" class="form-control" name="date_of_implementation" value="<?php echo $analysisData['date_of_implementation'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer m-6">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Save
                                                    </button>
                                                    <a type="button" href="/supplier_nc_capa_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade <?php echo (isset($_GET['verification'])) ? "active show" : "" ?>" id="verification" role="tabpanel" aria-labelledby="verification-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/supplier_nc_capa_verification_update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row mt-5">
                                                <input type="hidden" class="form-control" name="supplier_nc_capa_ncr_id" value="<?php echo $ncrDetailsData['id'] ?>">
                                                <input type="hidden" class="form-control" name="id" value="<?php echo $verificationData['id'] ?>">
                                                <div class="col-lg-6 ver-disabled">
                                                    <label class="required">Corrective Action</label>
                                                    <input type="text" class="form-control" name="corrective_action" value="<?php echo $analysisData['corrective_action'] ?>" disabled>
                                                </div>
                                                <div class="col-lg-6 ver-disabled">
                                                    <label class="required">Preventive Action</label>
                                                    <input type="text" class="form-control" name="preventive_action" value="<?php echo $analysisData['preventive_action'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 mt-5">
                                                    <label class="required">Verified & Closed By</label>
                                                    <select class="form-control" name="closed_by" required>
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        $sql_data = "SELECT * FROM Basic_Employee";
                                                        $connect_data = mysqli_query($con, $sql_data);
                                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            if ($result_data['Status'] == 'Active') {
                                                        ?>
                                                                <option value="<?php echo $result_data['Id_employee']; ?>" <?php echo ($verificationData['closed_by'] == $result_data['Id_employee']) ? 'selected' : ''; ?>>
                                                                    <?php echo $result_data['First_Name']; ?>
                                                                    <?php echo $result_data['Last_Name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 mt-5">
                                                    <label class="required">date</label>
                                                    <input type="date" class="form-control" name="date" value="<?php echo $verificationData['date'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer m-6">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                                    <a type="button" href="/supplier_nc_capa_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->

        <div class="modal right fade" id="ncr_detail_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="ncr_detail_form" class="form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header right-modal">
                            <h5 class="modal-title" id="staticBackdropLabel">Add NCR Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetModalVal()"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required">Description of Action Adopted by JC</label>
                                    <textarea class="form-control" name="descriptionOfActionModal" id="descriptionOfActionModal" required></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Responsible</label>
                                    <input type="text" class="form-control" name="responsibleModal" id="responsibleModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Target Date</label>
                                    <input type="date" class="form-control" name="targetDate" id="targetDate" required>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success" id="ncr_detail_submit">Add</button>
                            <button type="button" class="btn btn-sm btn-danger" id="ncr_detail_cancel" data-bs-dismiss="modal" onclick="resetModalVal()">Close</button>
                        </div>
                    </div>
                </form>
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
    <script>
        $('.remove-tag').on('click', function() {
            return $(this).closest('div.tags').remove();
        });

        let rowId = JSON.parse($('#dataArr').val()).length;
        let editRowId = "";

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('#ncr_detail_form').submit(function(e) {
            e.preventDefault()
            let descriptionOfActionModal = $("#descriptionOfActionModal").val();
            let responsibleModal = $("#responsibleModal").val();
            let targetDate = $("#targetDate").val();
            return appendTask(descriptionOfActionModal, responsibleModal, targetDate);
        });


        function appendTask(descriptionOfActionModal, responsibleModal, targetDate) {
            if (editRowId != "") {
                let content = `
        <td><input class="form-control" type="hidden" name="description_of_action[]" value="${descriptionOfActionModal}" required>${descriptionOfActionModal}</td>
        <td><input class="form-control" type="hidden" name="responsible[]" value="${responsibleModal}" required>${responsibleModal}</td>
        <td><input class="form-control" type="hidden" name="target_date[]" value="${targetDate}" required>${targetDate}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>`
                $('#' + editRowId).empty();
                $('#' + editRowId).append(content);
            } else {
                rowId++;
                let content = `<tr id="${rowId}"> 
            <td><input class="form-control" type="hidden" name="description_of_action[]" value="${descriptionOfActionModal}" required>${descriptionOfActionModal}</td>
        <td><input class="form-control" type="hidden" name="responsible[]" value="${responsibleModal}" required>${responsibleModal}</td>
        <td><input class="form-control" type="hidden" name="target_date[]" value="${targetDate}" required>${targetDate}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>
        </tr>`
                $('#list-table').append(content);
            }
            return $('#ncr_detail_cancel').trigger("click");
        }

        function resetModalVal() {
            editRowId = "";
            $("#descriptionOfActionModal").val("");
            $("#responsibleModal").val("");
            return $("#targetDate").val("");
        }

        $('body').delegate('.list-edit', 'click', function() {
            editRowId = $(this).closest('tr')[0].id;
            let getData = getValue($(this).closest('tr')[0]);
            let setData = setValue(getData);
            if (setData) {
                return $('#list-add')[0].click();
            }
        });


        function getValue(row) {
            let description_of_action = $(row).find('input[name="description_of_action[]"').val();
            let responsible = $(row).find('input[name="responsible[]"').val();
            let target_date = $(row).find('input[name="target_date[]"').val()
            return {
                description_of_action,
                responsible,
                target_date,
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#descriptionOfActionModal').val(dataArr.description_of_action);
                $('#responsibleModal').val(dataArr.responsible);
                $('#targetDate').val(dataArr.target_date);
                return true;
            }
            return false;
        }
    </script>
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