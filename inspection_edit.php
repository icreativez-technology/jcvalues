<?php
session_start();
include('includes/functions.php');

$sqlData = "SELECT * FROM inspection WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$inspection = mysqli_fetch_assoc($connectData);

$sqlData = "SELECT * FROM inspection_product_details WHERE is_deleted = 0 AND inspection_id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$productDetails =  array();
while ($row = mysqli_fetch_assoc($connectData)) {
    array_push($productDetails, $row);
}

$sqlData = "SELECT * FROM inspection_agency WHERE is_deleted = 0 AND inspection_id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$agencies =  array();
while ($row = mysqli_fetch_assoc($connectData)) {
    array_push($agencies, $row);
}

$locationSql = "SELECT * FROM tbl_Countries";
$locationConnect = mysqli_query($con, $locationSql);
$locations = mysqli_fetch_all($locationConnect, MYSQLI_ASSOC);
$disabled = false;
if (isset($_REQUEST['view'])) {
    $disabled = true;
}
$_SESSION['Page_Title'] = ($disabled) ? "View Inspection - " . $inspection['unique_id'] : "Edit Inspection - " . $inspection['unique_id'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
    .custom-tab .nav-link {
        border-radius: 3px;
        padding: 8px 20px;
    }

    .custom-tab .nav-link.active {
        color: #fff !important;
        background-color: #009ef7;
    }

    .custom-tab .nav-link.active:hover {
        color: #fff !important;
    }

    .required::after {
        content: "*";
        color: #e1261c;
    }

    .custom-select {
        background-color: #f5f8fa;
        border: 1px solid #e4e6ef;
        border-radius: 6px;
        width: 100%;
        padding: 6px;
        min-height: 38px;
    }

    .custom-select .tag-wrapper {
        list-style: none;
        display: flex;
        justify-content: flex-start;
        align-content: flex-start;
        flex-wrap: wrap;
    }

    .tag-wrapper .tags {
        position: relative;
        padding: 0px 15px 0px 6px;
        margin: 4px;
        text-align: left;
        background-color: #e1e2e4;
        border-radius: 5px;
    }

    .tag-wrapper .tags span {
        position: absolute;
        right: 4px;
        cursor: pointer;
        color: #002429;
    }

    .tag-wrapper .tags span::after {
        content: "x";
        font-weight: 600;
    }

    .tag-wrapper .tags span:hover {
        color: #e1261c;
    }

    .tag-wrapper .tags a {
        color: #002429;
    }

    .tag-wrapper .tags a:hover {
        color: #e1261c;
    }

    .ver-disabled input {
        background-color: #e9ecef !important;
    }

    #product_details_form {
        height: 100%;
    }

    #inspection_agency_form {
        height: 100%;
    }

    #confirmation_product_details_form {
        height: 100%;
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

    .excel-dwn-btn {
        padding-top: 7px !important;
        padding-left: 7px !important;
        border-left: 2px solid #fff !important;
        font-weight: bolder !important;
    }

    .span-icon {
        background-color: #f5f8fa !important;
        padding: 8px 12px !important;
        border-radius: 5px;
        background-color: #f5f8fa;
        cursor: pointer;
    }

    .span-icon-1 {
        background-color: #f5f8fa !important;
        padding: 10px 12px !important;
        border-radius: 5px;
        background-color: #f5f8fa;
        cursor: pointer;
        height: 38px;
    }
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/inspection_management.php">Inspection</a> » <a href="/inspection_view_list.php">Inspection List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link  <?php echo (isset($_GET['updated'])) ? "" : "active" ?>" id="plan-tab" data-bs-toggle="tab" data-bs-target="#plan" type="button" role="tab" aria-controls="plan" aria-selected="true">Plan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link  <?php echo (isset($_GET['updated'])) ? "active" : "" ?>" id="confirmation-tab" data-bs-toggle="tab" data-bs-target="#confirmation" type="button" role="tab" aria-controls="confirmation" aria-selected="false">Confirmation</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "" : "active show" ?>" id="plan" role="tabpanel" aria-labelledby="plan-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/inspection_update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="form-group row mt-3">
                                                <div class="col-md-2">
                                                    <label class="required">From</label>
                                                    <input type="datetime-local" class="form-control" name="from_date" required value="<?php echo $inspection['from_date']; ?>" <?php echo ($disabled) ? "disabled" : "" ?> id="from_date" min="">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="required">To</label>
                                                    <input type="datetime-local" class="form-control" name="to_date" required value="<?php echo $inspection['to_date']; ?>" <?php echo ($disabled) ? "disabled" : "" ?> id="to_date" min="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="required">Customer</label>
                                                    <select class="form-control" name="customer" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        $sql_data = "SELECT * FROM Basic_Customer";
                                                        $connect_data = mysqli_query($con, $sql_data);
                                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            if ($result_data['Status'] == 'Active') {
                                                                $selected = $inspection['customer'] == $result_data['Id_customer'] ? 'selected' : '';
                                                        ?>
                                                                <option value="<?php echo $result_data['Id_customer']; ?>" <?= $selected; ?>>
                                                                    <?php echo $result_data['Customer_Name']; ?>
                                                                </option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="required">Customer PO</label>
                                                    <input type="text" class="form-control" name="customer_po" oninput="this.value = this.value.toUpperCase()" required value="<?php echo $inspection['customer_po']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="required">Order Ref</label>
                                                    <input type="text" class="form-control" name="order_ref" oninput="this.value = this.value.toUpperCase()" required value="<?php echo $inspection['order_ref']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                    <?php if (isset($_GET['exist'])) { ?>
                                                        <small class="text-danger">The order ref# has
                                                            already been taken</small>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-3">
                                                <div class="col-md-3 ver-disabled">
                                                    <label class="required">Notification Period</label>
                                                    <input type="text" class="form-control" name="notification_no" required value="<?php echo $inspection['notification_no']; ?>" <?php echo ($disabled) ? "disabled" : "" ?> id="notification_no" readonly oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="required">Manufacturer</label>
                                                    <input type="text" class="form-control" name="manufacturer" required value="<?php echo $inspection['manufacturer']; ?>" <?php echo ($disabled) ? "disabled" : "" ?> oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="required">Stage of Inspection</label>
                                                    <input type="text" class="form-control" name="stage_of_inspection" oninput="this.value = this.value.toUpperCase()" required value="<?php echo $inspection['stage_of_inspection']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="required">Location</label>
                                                    <select class="form-control" name="location" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                        <option value="">Please Select</option>
                                                        <?php foreach ($locations as $location) {
                                                            $selected = $inspection['location'] == $location['CountryID'] ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $location['CountryID']; ?>" <?= $selected; ?>>
                                                                <?php echo $location['CountryName'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-3">
                                                <div class="col-md-3">
                                                    <label>Project Name (Optional)</label>
                                                    <input type="text" class="form-control" name="project_name" oninput="this.value = this.value.toUpperCase()" value="<?php echo $inspection['project_name']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="required">Equipment Description</label>
                                                    <input type="text" class="form-control" name="equipment_description" oninput="this.value = this.value.toUpperCase()" value="<?php echo $inspection['equipment_description']; ?>" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-3">
                                                <div class="col-md-3">
                                                    <label class="required">ITP Number</label>
                                                    <input type="text" class="form-control" name="itp_number" oninput="this.value = this.value.toUpperCase()" required value="<?php echo $inspection['itp_number']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="required">Revision</label>
                                                    <input type="text" class="form-control" name="revision" oninput="this.value = this.value.toUpperCase()" required value="<?php echo $inspection['revision']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="required">ITP Activity</label>
                                                    <input type="text" class="form-control" name="itp_activity" oninput="this.value = this.value.toUpperCase()" required value="<?php echo $inspection['itp_activity']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="required">Contact Person</label>
                                                    <input type="text" class="form-control" name="contact_person" oninput="this.value = this.value.toUpperCase()" required value="<?php echo $inspection['contact_person']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="required">Email</label>
                                                    <input type="email" class="form-control" name="email" required value="<?php echo $inspection['email']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-3">
                                                <div class="col-md-4">
                                                    <label class="required">Place of Inspection</label>
                                                    <input type="text" class="form-control" name="location_of_inspection" oninput="this.value = this.value.toUpperCase()" required value="<?php echo $inspection['location_of_inspection']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                </div>
                                                <?php if (!$disabled) { ?>
                                                    <div class="col-md-4">
                                                        <label>File Upload</label>
                                                        <div class="align-items-center">
                                                            <input type="file" class="form-control" name="file" accept=".pdf">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($inspection['file_path'] && $inspection['file_name']) { ?>
                                                    <div class="col-md-4">
                                                        <label class="required">Uploaded File</label>
                                                        <div class="custom-select mt-3">
                                                            <div class="tag-wrapper">
                                                                <div class="tags">
                                                                    <input type="hidden" class="form-control" name="ext_file_path" value="<?php echo $inspection['file_path']; ?>">
                                                                    <a href="<?php echo $inspection['file_path']; ?>" target="_blank"><?php echo $inspection['file_name']; ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="container-full customer-header d-flex justify-content-between mt-4">
                                                <span class="required">Product Details</span>
                                                <?php if (!$disabled) { ?>
                                                    <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#product_details_modal"><i class="fa fa-plus"></i></a>
                                                <?php } ?>
                                            </div>
                                            <div class="row" style="padding:0px 20px">
                                                <div class="d-flex justify-content-end">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary mt-2" id="import-product" data-bs-toggle="modal" data-bs-target="#excel-import-modal">Import</button>
                                                        <a type="button" title="Format Download" href="/inspection_excel_format/product-details-format.xlsx" class="btn btn-primary excel-dwn-btn mt-2"><i class="bi bi-download"></i></a>
                                                    </div>
                                                </div>
                                                <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3">
                                                    <thead>
                                                        <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                            <th class="min-w-75px ps-3">Item No</th>
                                                            <th class="min-w-200px">Tag No</th>
                                                            <th class="min-w-100px">HR No</th>
                                                            <th class="min-w-200px pe-3">Type</th>
                                                            <th class="min-w-75px pe-3">Size</th>
                                                            <th class="min-w-100px pe-3">Bore</th>
                                                            <th class="min-w-100px pe-3">Class</th>
                                                            <th class="min-w-100px pe-3">Material</th>
                                                            <th class="min-w-100px pe-3">Qty</th>
                                                            <?php if (!$disabled) { ?>
                                                                <th class="min-w-50px pe-3">Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-gray-600 fw-bold" id="list-table">
                                                        <input type="hidden" name="dataArr" id="dataArr" value='<?php echo json_encode($productDetails) ?>'>
                                                        <?php if ($productDetails && count($productDetails) > 0) {
                                                            foreach ($productDetails as $key => $value) { ?>
                                                                <tr id="<?php echo $key ?>">
                                                                    <td>
                                                                        <input class="form-control" type="hidden" name="item_no[]" value="<?php echo $value['item_no']; ?>" required>
                                                                        <?php echo $value['item_no']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['tag_no']; ?>
                                                                        <input class="form-control" type="hidden" name="tag_no[]" value="<?php echo $value['tag_no']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['hr_no']; ?>
                                                                        <input class="form-control" type="hidden" name="hr_no[]" value="<?php echo $value['hr_no']; ?>" required>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['type']; ?>
                                                                        <input class="form-control" type="hidden" name="type[]" value="<?php echo $value['type']; ?>" required>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['size']; ?>
                                                                        <input class="form-control" type="hidden" name="size[]" value="<?php echo $value['size']; ?>" required>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['bore']; ?>
                                                                        <input class="form-control" type="hidden" name="bore[]" value="<?php echo $value['bore']; ?>" required>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['class']; ?>
                                                                        <input class="form-control" type="hidden" name="class[]" value="<?php echo $value['class']; ?>" required>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['material']; ?>
                                                                        <input class="form-control" type="hidden" name="material[]" value="<?php echo $value['material']; ?>" required>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['qty']; ?>
                                                                        <input class="form-control" type="hidden" name="qty[]" value="<?php echo $value['qty']; ?>" required>
                                                                    </td>
                                                                    <?php if (!$disabled) { ?>
                                                                        <td class="list-row" style="vertical-align:middle">
                                                                            <a class="list-edit cursor-pointer me-2" data-id="<?php echo $value['id'] ?>"><i class="bi bi-pencil"></i></a>
                                                                            <a class="list-remove cursor-pointer" data-id="<?php echo $value['id'] ?></td>"><i class="bi bi-trash"></i></a>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="mb-4 d-flex justify-content-between align-items-center">
                                                    <button type="button" class="btn btn-sm btn-warning print-pdf" data-id="<?php echo $inspection['id']; ?>" data-unique="<?php echo $inspection['unique_id']; ?>"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>Download</button>
                                                    <div>
                                                        <?php if (!$disabled) { ?>
                                                            <?php if (isset($_GET['product'])) { ?>
                                                                <small class="text-danger me-6">Add atleast one product
                                                                    detail</small>
                                                            <?php } ?>
                                                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                        <?php } ?>
                                                        <a type="button" href="/inspection_view_list.php" class="btn btn-sm btn-secondary ms-2">Close</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="id" value="<?php echo $inspection['id']; ?>">
                                        <input type="hidden" class="form-control" name="unique_id" value="<?php echo $inspection['unique_id']; ?>">
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "active show" : "" ?>" id="confirmation" role="tabpanel" aria-labelledby="confirmation-tab">
                                <div class="card card-flush">
                                    <div class="card-body">
                                        <div class="container-full customer-header d-flex justify-content-between
                                                mt-4">
                                            Inspection Agency/Inspector Details
                                            <?php if (!$disabled) { ?>
                                                <a class="list-add" id="list-add-agency" data-bs-toggle="modal" data-bs-target="#inspection_agency_popup"><i class="fa fa-plus"></i></a>
                                            <?php } ?>
                                        </div>
                                        <div class="row" style="padding:0px 20px">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3">
                                                <thead>
                                                    <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                        <th class="min-w-100px ps-3">On Behalf Of</th>
                                                        <th class="min-w-100px">Inspection Agency</th>
                                                        <th class="min-w-100px">Inspector Name</th>
                                                        <th class="min-w-100px pe-3">Email</th>
                                                        <?php if (!$disabled) { ?>
                                                            <th class="min-w-100px pe-3">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 fw-bold" id="list-table">
                                                    <input type="hidden" name="dataArrAgency" id="dataArrAgency" value='<?php echo json_encode($agencies) ?>'>
                                                    <?php if ($agencies && count($agencies) > 0) {
                                                        foreach ($agencies as $key => $value) { ?>
                                                            <tr id="<?php echo $key ?>">
                                                                <input class="form-control" type="hidden" name="inspection_agency_id" value="<?php echo $value['id']; ?>">
                                                                <input class="form-control" type="hidden" name="on_behalf_of" value="<?php echo $value['on_behalf_of']; ?>">
                                                                <input class="form-control" type="hidden" name="inspection_agency" value="<?php echo $value['inspection_agency']; ?>">
                                                                <input class="form-control" type="hidden" name="inspector_name" value="<?php echo $value['inspector_name']; ?>">
                                                                <input class="form-control" type="hidden" name="email" value="<?php echo $value['email']; ?>">
                                                                <td>
                                                                    <?php echo $value['on_behalf_of']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['inspection_agency']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['inspector_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['email']; ?>
                                                                </td>
                                                                <?php if (!$disabled) { ?>
                                                                    <td class="list-row" style="vertical-align:middle">
                                                                        <a class="list-edit-agency cursor-pointer me-2"><i class="bi bi-pencil"></i></a>
                                                                        <a class="cursor-pointer" href="includes/inspection_agency_delete.php?id=<?php echo $value['id'] ?>"><i class="bi bi-trash"></i></a>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="container-full customer-header d-flex justify-content-between
                                                mt-4">
                                            <span class="required">Product Details</span>
                                        </div>
                                        <div class="row" style="padding:0px 20px">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3">
                                                <thead>
                                                    <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                        <th class="min-w-75px ps-3">Item No</th>
                                                        <th class="min-w-200px">Tag No</th>
                                                        <th class="min-w-100px">HR No</th>
                                                        <th class="min-w-200px pe-3">Type</th>
                                                        <th class="min-w-75px pe-3">Size</th>
                                                        <th class="min-w-100px pe-3">Bore</th>
                                                        <th class="min-w-100px pe-3">Class</th>
                                                        <th class="min-w-100px pe-3">Material</th>
                                                        <th class="min-w-100px pe-3">Qty</th>
                                                        <th class="min-w-50px pe-3">Actual Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 fw-bold" id="list-table-actual">
                                                    <input type="hidden" name="dataArrActual" id="dataArrActual" value='<?php echo json_encode($productDetails) ?>'>
                                                    <?php if ($productDetails && count($productDetails) > 0) {
                                                        foreach ($productDetails as $key => $value) { ?>
                                                            <tr id="<?php echo $key ?>">
                                                                <td>
                                                                    <?php echo $value['item_no']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['tag_no']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['hr_no']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['type']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['size']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['bore']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['class']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['material']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['qty']; ?>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control actual-field" type="text" name="actual_qty" data-id="<?php echo $value['id']; ?>" value="<?php echo $value['actual_qty']; ?>" <?php echo ($disabled) ? "disabled" : "" ?>>
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
                                                <?php
                                                if (!$disabled) {
                                                    if ($inspection['status'] != "Completed") { ?>
                                                        <a type="button" href="/includes/inspection_status.php?id=<?php echo $inspection['id'] ?>&status=complete" class="btn btn-sm btn-warning <?php echo count($agencies) > 0 ? '' : "disabled" ?>">Complete</a>
                                                    <?php } ?>
                                                    <button type="button" class="btn btn-sm btn-success" id="actual-submit">Save</button>
                                                <?php } ?>
                                                <a type="button" href="/inspection_view_list.php" class="btn btn-sm btn-secondary ms-2">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal right fade" id="product_details_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="product_details_form" class="form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header right-modal">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Product Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetModalVal()"></button>
                        </div>
                        <div class="modal-body" style="overflow-y: auto">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required">Item No</label>
                                    <input type="text" class="form-control" name="itemNoModal" id="itemNoModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label>Tag No</label>
                                    <input type="text" class="form-control" name="tagNoModal" id="tagNoModal">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">HR No</label>
                                    <input type="text" class="form-control" name="hrNoModal" id="hrNoModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Type</label>
                                    <input type="text" class="form-control" name="typeModal" id="typeModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Size</label>
                                    <input type="text" class="form-control" name="sizeModal" id="sizeModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Bore</label>
                                    <input type="text" class="form-control" name="boreModal" id="boreModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Class</label>
                                    <input type="text" class="form-control" name="classModal" id="classModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Material</label>
                                    <input type="text" class="form-control" name="materialModal" id="materialModal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">QTY</label>
                                    <input type="text" class="form-control" name="qtyModal" id="qtyModal" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" id="product_details_cancel" onclick="resetModalVal()">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal right fade" id="inspection_agency_popup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="inspection_agency_form" action="includes/inspection_agency_update.php" method="post" class="form" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="inspection_id" value="<?php echo $inspection['id'] ?>">
                    <input type="hidden" class="form-control" name="inspection_agency_id" id="inspection_agency_id">
                    <div class="modal-content">
                        <div class="modal-header right-modal">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Inspection Agency
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetAgencyModalVal()"></button>
                        </div>
                        <div class="modal-body" style="overflow-y: auto">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>On Behalf Of</label>
                                    <input type="text" class="form-control" name="on_behalf_of_modal" id="on_behalf_of_modal">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label>Inspection Agency</label>
                                    <input type="text" class="form-control" name="inspection_agency_modal" id="inspection_agency_modal">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Inspector Name</label>
                                    <input type="text" class="form-control" name="inspector_name_modal" id="inspector_name_modal" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    <label class="required">Email</label>
                                    <input type="email" class="form-control" name="email_modal" id="email_modal" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetAgencyModalVal()">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="excel-import-modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Excel Import</h5>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <div class="col-md-9">
                                <input type="file" class="form-control" name="excel-file-import" id="excel-file-import" accept=".xls,.xlsx" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer  text-center">
                        <button type="button" class="btn btn-sm btn-success" id="excel-import-btn">Import</button>
                        <button type="button" class="btn btn-sm btn-danger" id="excel-import-close" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>
    <?php include('includes/scrolltop.php'); ?>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>
    <script>
        $(document).ready(function() {
            var date = new Date();
            let maxDate = new Date().toISOString().slice(0, 16);
            document.getElementById("from_date").min = maxDate;
            document.getElementById("to_date").min = maxDate;
        });

        let rowId = JSON.parse($('#dataArr').val()).length;
        let editRowId = "";

        $('#from_date').on('change', function() {
            let fromDate = new Date($(this).val());
            let currentDate = new Date();
            diffDays = (fromDate.getTime() - currentDate.getTime()) / (1000 * 3600 * 24);
            return $('#notification_no').val((Math.abs(Math.round(diffDays))));
        });

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('#product_details_form').submit(function(e) {
            e.preventDefault()
            let itemNoModal = $("#itemNoModal").val();
            let tagNoModal = $("#tagNoModal").val();
            let hrNoModal = $("#hrNoModal").val();
            let typeModal = $("#typeModal").val();
            let sizeModal = $("#sizeModal").val();
            let boreModal = $("#boreModal").val();
            let classModal = $("#classModal").val();
            let materialModal = $("#materialModal").val();
            let qtyModal = $("#qtyModal").val();
            return appendTask(itemNoModal, tagNoModal, hrNoModal, typeModal, sizeModal, boreModal, classModal,
                materialModal, qtyModal);
        });


        function appendTask(itemNoModal, tagNoModal, hrNoModal, typeModal, sizeModal, boreModal, classModal, materialModal,
            qtyModal) {
            if (editRowId != "") {
                let content = `
        <td><input class="form-control" type="hidden" name="item_no[]" value="${itemNoModal}" required>${itemNoModal}</td>
        <td><input class="form-control" type="hidden" name="tag_no[]" value="${tagNoModal}">${tagNoModal}</td>
        <td><input class="form-control" type="hidden" name="hr_no[]" value="${hrNoModal}" required>${hrNoModal}</td>
        <td><input class="form-control" type="hidden" name="type[]" value="${typeModal}" required>${typeModal}</td>
        <td><input class="form-control" type="hidden" name="size[]" value="${sizeModal}" required>${sizeModal}</td>
        <td><input class="form-control" type="hidden" name="bore[]" value="${boreModal}" required>${boreModal}</td>
        <td><input class="form-control" type="hidden" name="class[]" value="${classModal}" required>${classModal}</td>
        <td><input class="form-control" type="hidden"name="material[]" value="${materialModal}" required>${materialModal}</td>
        <td><input class="form-control" type="hidden"name="qty[]" value="${qtyModal}" required>${qtyModal}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>`
                $('#' + editRowId).empty();
                $('#' + editRowId).append(content);
            } else {
                rowId++;
                let content = `<tr id="${rowId}"> 
            <td><input class="form-control" type="hidden" name="item_no[]" value="${itemNoModal}" required>${itemNoModal}</td>
        <td><input class="form-control" type="hidden" name="tag_no[]" value="${tagNoModal}">${tagNoModal}</td>
        <td><input class="form-control" type="hidden" name="hr_no[]" value="${hrNoModal}" required>${hrNoModal}</td>
        <td><input class="form-control" type="hidden" name="type[]" value="${typeModal}" required>${typeModal}</td>
        <td><input class="form-control" type="hidden" name="size[]" value="${sizeModal}" required>${sizeModal}</td>
        <td><input class="form-control" type="hidden" name="bore[]" value="${boreModal}" required>${boreModal}</td>
        <td><input class="form-control" type="hidden" name="class[]" value="${classModal}" required>${classModal}</td>
        <td><input class="form-control" type="hidden" name="material[]" value="${materialModal}" required>${materialModal}</td>
        <td><input class="form-control" type="hidden" name="qty[]" value="${qtyModal}" required>${qtyModal}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>
        </tr>`
                $('#list-table').append(content);
            }
            return $('#product_details_cancel').trigger("click");
        }

        function resetModalVal() {
            editRowId = "";
            $("#itemNoModal").val("");
            $("#tagNoModal").val("");
            $("#hrNoModal").val("");
            $("#typeModal").val("");
            $("#sizeModal").val("");
            $("#boreModal").val("");
            $("#classModal").val("");
            $("#materialModal").val("");
            return $("#qtyModal").val("");
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
            let item_no = $(row).find('input[name="item_no[]"').val();
            let tag_no = $(row).find('input[name="tag_no[]"').val();
            let hr_no = $(row).find('input[name="hr_no[]"').val();
            let type = $(row).find('input[name="type[]"').val();
            let size = $(row).find('input[name="size[]"').val();
            let bore = $(row).find('input[name="bore[]"').val();
            let classItem = $(row).find('input[name="class[]"').val();
            let material = $(row).find('input[name="material[]"').val();
            let qty = $(row).find('input[name="qty[]"').val();
            return {
                item_no,
                tag_no,
                hr_no,
                type,
                size,
                bore,
                classItem,
                material,
                qty,
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $("#itemNoModal").val(dataArr.item_no);
                $("#tagNoModal").val(dataArr.tag_no);
                $("#hrNoModal").val(dataArr.hr_no);
                $("#typeModal").val(dataArr.type);
                $("#sizeModal").val(dataArr.size);
                $("#boreModal").val(dataArr.bore);
                $("#classModal").val(dataArr.classItem);
                $("#materialModal").val(dataArr.material);
                $("#qtyModal").val(dataArr.qty);
                return true;
            }
            return false;
        }

        $('body').delegate('.list-edit-agency', 'click', function() {
            resetAgencyModalVal();
            let getData = getAgencyValue($(this).closest('tr')[0]);
            let setData = setAgencyValue(getData);
            if (setData) {
                return $('#list-add-agency')[0].click();
            }
        });

        function getAgencyValue(row) {
            let on_behalf_of = $(row).find('input[name="on_behalf_of"').val();
            let inspection_agency = $(row).find('input[name="inspection_agency"').val();
            let inspector_name = $(row).find('input[name="inspector_name"').val();
            let email = $(row).find('input[name="email"').val();
            let inspection_agency_id = $(row).find('input[name="inspection_agency_id"').val();
            return {
                on_behalf_of,
                inspection_agency,
                inspector_name,
                email,
                inspection_agency_id
            }
        }

        function setAgencyValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $("#on_behalf_of_modal").val(dataArr.on_behalf_of);
                $("#inspection_agency_modal").val(dataArr.inspection_agency);
                $("#inspector_name_modal").val(dataArr.inspector_name);
                $("#email_modal").val(dataArr.email);
                $("#inspection_agency_id").val(dataArr.inspection_agency_id);
                return true;
            }
            return false;
        }

        function resetAgencyModalVal() {
            $("#on_behalf_of_modal").val("");
            $("#inspection_agency_modal").val("");
            $("#inspector_name_modal").val("");
            $("#email_modal").val("");
            $("#inspection_agency_id").val("");
            return;
        }

        $(".date-time").on("change", function() {
            var fromDate = $("#from_date").val();
            var toDate = $("#to_date").val();
            if (fromDate != "") {
                if (toDate != "") {
                    var from = new Date(fromDate).getTime();
                    var to = new Date(toDate).getTime();
                    if (from > to) {
                        $("#to_date").val("");
                    }
                }
            } else {
                $("#to_date").val("");
            }
        });

        $('.print-pdf').on('click', function() {
            let id = $(this).data('id');
            let unique = $(this).data('unique');
            $.get(`/includes/inspection_plan_pdf.php?id=${id}`, function(data) {
                let opt = {
                    margin: [0, 0.1, 0.1, 0.1],
                    image: {
                        type: "jpeg",
                        quality: 1.5,
                    },
                    html2canvas: {
                        scale: 7,
                        letterRendering: false,
                        dpi: 700,
                        width: 775,
                        scrollY: 0,
                    },
                    jsPDF: {
                        unit: "in",
                        format: "A4",
                        orientation: "portrait",
                    },
                };
                let worker = html2pdf().set(opt).from(data).save(unique);
            });
        });

        $('#excel-import-btn').on('click', function() {
            let isExport = importProductExcel();
            if (isExport) {
                $('#excel-import-close').click()
                return document.getElementById("excel-file-import").value = null;
            }
        });

        function importProductExcel() {
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;
            if (regex.test($("#excel-file-import").val().toLowerCase())) {
                var xlsxflag = false;
                if ($("#excel-file-import").val().toLowerCase().indexOf(".xlsx") > 0) {
                    xlsxflag = true;
                }
                if (typeof(FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var data = e.target.result;
                        if (xlsxflag) {
                            var workbook = XLSX.read(data, {
                                type: 'binary'
                            });
                        } else {
                            var workbook = XLS.read(data, {
                                type: 'binary'
                            });
                        }
                        var sheet_name_list = workbook.SheetNames;
                        var cnt = 0;
                        sheet_name_list.forEach(function(y) {

                            if (xlsxflag) {
                                var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                            } else {
                                var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);
                            }
                            if (exceljson.length > 0) {
                                exceljson?.map(function(elem) {
                                    appendTask(elem.Item_No, elem.Tag_No, elem.HR_No, elem.Type,
                                        elem.Size, elem.Bore, elem.Class, elem.Material, elem.QTY)
                                });
                            }
                        });
                    }
                    if (xlsxflag) {
                        reader.readAsArrayBuffer($("#excel-file-import")[0].files[0]);
                    } else {
                        reader.readAsBinaryString($("#excel-file-import")[0].files[0]);
                    }
                } else {
                    alert("Sorry! Your browser does not support HTML5!");
                }
            } else {
                alert("Please upload a valid Excel file!");
            }
            return true;
        }

        function getActualData() {
            let actualElem = $('.actual-field');
            let dataArr = new Array();
            if (actualElem.length > 0) {
                $.each(actualElem, function(key, elem) {
                    dataArr.push({
                        id: $(elem).data('id'),
                        actual_qty: $(elem).val(),
                    })
                });
            }
            return dataArr;
        }

        $('#actual-submit').on('click', function() {
            let actualData = getActualData();
            let agencyData = JSON.parse($('#dataArrAgency').val());

            if (agencyData.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: 'includes/inspection_product_details_update.php',
                    data: {
                        actualArr: actualData
                    }
                }).done(function(result) {
                    if (result) {
                        let origin_url = window.location.href;
                        window.location.href = `${origin_url}&updated`;
                    }

                });
            } else {
                alert('There must be atleast one entry of Inspection Agency/Inspector Details Needed');
            }
        });
    </script>
</body>

</html>

</html>