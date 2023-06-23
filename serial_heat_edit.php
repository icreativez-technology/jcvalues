<?php
session_start();
include('includes/functions.php');
$id = $_REQUEST['id'];
$mode = "edit";
$_SESSION['Page_Title'] = "Edit Serial vs Heat";
if (isset($_REQUEST['view'])) {
    $mode = "view";
    $_SESSION['Page_Title'] = "View/Edit";
}

$email = $_SESSION['usuario'];
$userSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchUser = mysqli_query($con, $userSql);
$userInfo = mysqli_fetch_assoc($fetchUser);
$userId = $userInfo['Id_employee'];

$sql = "SELECT * FROM product_types WHERE deleted_at is NULL and status = 1";
$connect = mysqli_query($con, $sql);
$productTypes = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM sizes WHERE is_deleted = 0 and status = 1";
$connect = mysqli_query($con, $sql);
$sizes = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM bores WHERE deleted_at is NULL and status = 1";
$connect = mysqli_query($con, $sql);
$bores = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM classes WHERE is_deleted = 0 and status = 1";
$connect = mysqli_query($con, $sql);
$classes = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM end_connections WHERE deleted_at is NULL and status = 1";
$connect = mysqli_query($con, $sql);
$endConnections = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM design_standards WHERE deleted_at is null and status = 1";
$connect = mysqli_query($con, $sql);
$designStandards = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM testing_standards WHERE deleted_at is null and status = 1";
$connect = mysqli_query($con, $sql);
$testingStandards = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM material_specifications WHERE is_deleted = 0 AND is_editable = 1";
$connect = mysqli_query($con, $sql);
$materialSpecifications = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$serialSql = "SELECT * FROM serial_heat_details WHERE is_deleted = 0 AND id = $id";
$connect_serial =  mysqli_query($con, $serialSql);
$serialData =  mysqli_fetch_assoc($connect_serial);

$typeSql = "SELECT * FROM serial_heat_type_material WHERE is_deleted = 0 AND serial_heat_details_id = $id";
$connect_type = mysqli_query($con, $typeSql);
$typeData =  array();
while ($row = mysqli_fetch_assoc($connect_type)) {
    array_push($typeData, $row);
}

$markingSql = "SELECT serial_no, group_concat(component_id separator ',')  AS components, group_concat(heat_no_description separator ',')  AS heat, group_concat(certificate_no_description separator ',')  AS certificate FROM serial_heat_marking WHERE is_deleted =0 AND serial_heat_details_id = $id GROUP BY serial_no";
$connect_marking = mysqli_query($con, $markingSql);
$markingData =  array();
while ($row = mysqli_fetch_assoc($connect_marking)) {
    array_push($markingData, $row);
}

$componentSql = "SELECT * FROM components WHERE is_deleted = 0 AND status = 1";
$componentconnect = mysqli_query($con, $componentSql);
$componentDataArr =  array();
while ($row = mysqli_fetch_assoc($componentconnect)) {
    array_push($componentDataArr, $row);
}

$mtcSql = "SELECT supplier_certificates.material_certificate_number, supplier_certificates.heat_number  FROM supplier_certificates WHERE is_deleted = 0";
$mtcconnect = mysqli_query($con, $mtcSql);
$mtcDataArr =  array();
while ($row = mysqli_fetch_assoc($mtcconnect)) {
    array_push($mtcDataArr, $row);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<style>
#loading_spinner { display:none;
margin: 0 0 auto;
text-align:center; }
.ver-disabled input {
    background-color: #e9ecef !important;
}

.check-size {
    width: 1.25rem !important;
    height: 1.25rem !important;
}

.grid-container {
    display: grid;
    grid-template-columns: auto auto auto;
    padding: 10px;
    column-gap: 10px;
}

.custom-input input {
    margin: 0;
    padding: 2px 2px !important;
    width: 100px
}

table tr td {
    padding: 0px;
}

table tr th {
    padding: 0.25rem o.75rem !important;
}

.table>:not(caption)>*>* {
    padding: 0.35rem .35rem;
}

.excel-dwn-btn {
    padding-top: 7px !important;
    padding-left: 7px !important;
    border-left: 2px solid #fff !important;
    font-weight: bolder !important;
}
</style>


<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include 'includes/aside-menu.php'; ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include 'includes/header.php'; ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/serial_view_list.php">Serial VS Heat View List</a> »
                                <!-- <?php echo $_SESSION['Page_Title']; ?> -->
                                <?php echo $serialData['cert_n'] ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush">
                                      <div id="loading_spinner">
                                        <img src="assets/loader.gif">
                                        <h2>Processing form inputs... Please wait..</h2>
                                        <h4 class='text-danger'>Do Not Refresh / Close</h4>
                                      </div>
                            <form class="form" id="serial_form" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div id="custom-section-1">
                                        <div class="container-full customer-header d-flex justify-content-between">
                                            Purchase Details
                                        </div>
                                        <input type="hidden" name="type_arr" id="type_arr"
                                            value='<?php echo json_encode($typeData) ?>' />
                                        <input type="hidden" name="marking_arr" id="marking_arr"
                                            value='<?php echo json_encode($markingData) ?>' />
                                        <input type="hidden" name="componentDataArr" id="componentDataArr"
                                            value='<?php echo json_encode($componentDataArr) ?>' />
                                        <input type="hidden" name="mtcDataArr" id="mtcDataArr"
                                            value='<?php echo json_encode($mtcDataArr) ?>' />
                                        <div class="form-group row">
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Purchaser</label>
                                                <input type="text" name="purchaser" id="purchaser" class="text-uppercase form-control"
                                                    value="<?php echo $serialData['purchaser'] ?>" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Purchase Date</label>
                                                <input type="date" id="purchase_date" class="form-control"
                                                    name="purchase_date"
                                                    value="<?php echo $serialData['purchase_date'] ?>" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Cert N°</label>
                                                <input type="text" name="cert_n" id="cert_n" class="text-uppercase form-control"
                                                    value="<?php echo $serialData['cert_n'] ?>" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">PO. Number</label>
                                                <input type="text" name="po_no" id="po_no" class="text-uppercase form-control"
                                                    value="<?php echo $serialData['po_no'] ?>" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">JC PO. Ref</label>
                                                <input type="text" name="jc_po_ref" id="jc_po_ref" class="text-uppercase form-control"
                                                    value="<?php echo $serialData['jc_po_ref'] ?>" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Issued Date</label>
                                                <input type="date" id="issued_date" class="form-control"
                                                    name="issued_date" value="<?php echo $serialData['issued_date'] ?>"
                                                    required <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Revision</label>
                                                <input type="text" id="revision" class="form-control" name="revision"
                                                    value="<?php echo $serialData['revision'] ?>" required disabled>
                                            </div>
                                        </div>
                                        <div class="container-full customer-header d-flex justify-content-between mt-4">
                                            Product Description
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Product Type</label>
                                                <select class="form-control" data-control="select2" name="product_type"
                                                    id="product_type" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($productTypes as $productType) { ?>
                                                    <option value=<?php echo $productType['id']; ?>
                                                        <?php echo ($serialData['product_type_id'] == $productType['id']) ? "selected" : "" ?>>
                                                        <?php echo $productType['product_type'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Size</label>
                                                <select class="form-control" data-control="select2" name="size"
                                                    id="size" required <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($sizes as $size) { ?>
                                                    <option value=<?php echo $size['id']; ?>
                                                        <?php echo ($serialData['size_id'] == $size['id']) ? "selected" : "" ?>>
                                                        <?php echo $size['size'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Bore</label>
                                                <select class="form-control" data-control="select2" name="bore"
                                                    id="bore" required <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($bores as $bore) { ?>
                                                    <option value=<?php echo $bore['id']; ?>
                                                        <?php echo ($serialData['bore_id'] == $bore['id']) ? "selected" : "" ?>>
                                                        <?php echo $bore['bore'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Class</label>
                                                <select class="form-control" data-control="select2" name="class"
                                                    id="class" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($classes as $class) { ?>
                                                    <option value=<?php echo $class['id']; ?>
                                                        <?php echo ($serialData['class_id'] == $class['id']) ? "selected" : "" ?>>
                                                        <?php echo $class['class'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">End Connection</label>
                                                <select class="form-control" data-control="select2"
                                                    name="end_connection" id="end_connection" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($endConnections as $end_connection) { ?>
                                                    <option value=<?php echo $end_connection['id']; ?>
                                                        <?php echo ($serialData['end_connection_id'] == $end_connection['id']) ? "selected" : "" ?>>
                                                        <?php echo $end_connection['end_connection'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Item</label>
                                                <input type="text" name="item" id="item" class="text-uppercase form-control"
                                                    maxlength="7" value="<?php echo $serialData['item'] ?>" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                            <div class="col-lg-5 mt-5">
                                                <label class="required">Design Standard</label>
                                                <select class="form-control form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-select2-id="select2-data-7-oqww"
                                                    tabindex="-1" aria-hidden="true" multiple name="design_standard"
                                                    id="design_standard" required disabled>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Article</label>
                                                <input type="text" name="article" id="article" class="text-uppercase form-control"
                                                    value="<?php echo $serialData['article'] ?>" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                            <div class="col-lg-1 mt-5">
                                                <label class="required">Qty</label>
                                                <input type="number" name="qty" class="form-control" id="qty"
                                                    value="<?php echo $serialData['qty'] ?>" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>

                                        </div>
                                        <div class="container-full customer-header d-flex justify-content-between mt-4">
                                            Type Material
                                        </div>
                                        <div class="grid-container" id="component-container">
                                            <p></p>
                                            <p class="text-center"> No Data Found </p>
                                            <p></p>
                                        </div>
                                        <div class="container-full customer-header d-flex justify-content-between mt-4">
                                            Test Description
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Testing Standard</label>
                                                <select class="form-control form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-select2-id="select2-data-7-oqwx"
                                                    tabindex="-1" aria-hidden="true" multiple name="testing_standard"
                                                    id="testing_standard" required disabled>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">JC Standard</label>
                                                <input type="text" name="jc_standard" id="jc_standard"
                                                    value="<?php echo $serialData['jc_standard'] ?>"
                                                    class="text-uppercase form-control" required
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <label>Other</label>
                                                <input type="text" name="other" id="other" class="text-uppercase form-control"
                                                    value="<?php echo $serialData['other'] ?>"
                                                    <?php echo $mode === "view" ? "disabled" : "" ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 mt-5">
                                                <div class="row form-group">
                                                    <label class="required">Hydraulic (barg)</label>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="hydraulic_shell"
                                                            placeholder="Shell" id="hydraulic_shell"
                                                            value="<?php echo $serialData['hydraulic_shell'] ?>"
                                                            required <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="hydraulic_seat"
                                                            placeholder="Seat" id="hydraulic_seat"
                                                            value="<?php echo $serialData['hydraulic_seat'] ?>" required
                                                            <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-5">
                                                <div class="row form-group">
                                                    <label class="required">Pneumatic (barg)</label>

                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="pneumatic_seat"
                                                            id="pneumatic_seat" placeholder="Seat"
                                                            value="<?php echo $serialData['pneumatic_seat'] ?>" required
                                                            <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="pneumatic_shell"
                                                            id="pneumatic_shell" placeholder="Shell"
                                                            value="<?php echo $serialData['pneumatic_shell'] ?>"
                                                            <?php echo $mode === "view" ? "disabled" : "" ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-full customer-header d-flex justify-content-between mt-4">
                                            Marking and traceability of pressure retaining parts
                                        </div>
                                        <?php
                                        if($mode != "view") {
                                        ?>
                                        <div class="d-flex justify-content-end">
                                            <div class="btn-group">
                                                 <button type="button" class="btn btn-sm btn-secondary mt-2"
                                                    id="clearData" onclick="resetData();">Clear Data</button>
                                                <button type="button" class="btn btn-sm btn-primary mt-2"
                                                    id="import-product" data-bs-toggle="modal"
                                                    data-bs-target="#excel-import-modal">Import</button>
                                                <a type="button" title="Format Download"
                                                    href="/serial_heat_template/marking-templates.xlsx"
                                                    class="btn btn-primary excel-dwn-btn mt-2"><i
                                                        class="bi bi-download"></i></a>
                                            </div>
                                        </div>
                                        <?php
                                    } ?>
                                        <div class="row  mt-3 p-3" id="table-container" style="overflow-x: scroll;">

                                        </div>
                                    </div>
                                    <div class="card-footer mt-3">
                                        <div class="row" style="text-align:center; float:right;">
                                            <div class="mb-4">
                                                <?php if ($mode !== "view") { ?>
                                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                <?php
                                                }
                                                ?>
                                                <a type="button" href="javascript:history.back(-1)"
                                                    class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                            </div>
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

    <div class="modal" tabindex="-1" role="dialog" data-bs-backdrop="static" s id="excel-import-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Excel Import</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-9">
                            <input type="file" class="form-control" name="excel-file-import" id="excel-file-import"
                                accept=".xls,.xlsx" />
                            <small id="errorMsg" class="mt-2" style="color:red;visibility:hidden">Heat number and
                                certificate number
                                mismatch in
                                excel or serial number missing</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer  text-center">
                    <button type="button" class="btn btn-sm btn-success" id="excel-import-btn">Import</button>
                    <button type="button" class="btn btn-sm btn-danger" id="excel-import-close"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>
    </div>
    </div>
    </div>
    <?php include 'includes/scrolltop.php'; ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>
    <script>
    const mode = "<?php echo $mode ?>"
    let mandatoryArr = new Array();
    let componentDataArr = JSON.parse($('#componentDataArr').val()) ?? [];
    let mtcDataArr = JSON.parse($('#mtcDataArr').val()) ?? [];

    $("document").ready(function() {
        getTypes();
    });

    function getTypes() {
        let productTypeId = $('#product_type').val();
        let typeData = JSON.parse($('#type_arr').val());
        $.ajax({
            url: "includes/serial_heat_get_products.php",
            type: "POST",
            dataType: "html",
            data: {
                productTypeId: productTypeId,
            },
        }).done(function(resultado) {
            let dataArr = resultado ? JSON.parse(resultado) : [];
            mandatoryArr = dataArr?.mandatory?.map(function(item) {
                return item?.id
            })
            $('#component-container').empty();
            let options = setSelect2Option(dataArr?.specs);
            components = dataArr?.components;
            if (dataArr?.components?.length > 0) {
                dataArr?.components?.map(function(item) {
                    if (mandatoryArr.includes(item.id)) {
                        $('#component-container').append(
                            `<div class="p-2 flex-fill main">
                            <label class="required">${item.component}</label>
                            <input class="form-check-input check-size mt-1 component_check" type="hidden" value="${item.id}">
                            <select class="form-control material_select" required ${mode === "view" ? "disabled" : ""}>
                                <option value="">Please Select</option>
                                ${options.map(function(elem){
                                    return  `<option value="${elem.id}" ${
                                    (typeData.find((spec)=> spec.component_id == item.id)?.material_specification_id == elem.id) ?"selected":""
                                       }>${elem.text}</option>`
                                })}
                            </select>
                        </div>`)
                    } else {
                        $('#component-container').append(
                            `<div class="p-2 flex-fill main">
                        <input class="form-check-input check-size mt-1 component_check" type="hidden" value="${item.id}">
                            <label class="required">${item.component}</label>
                            <input class="text-uppercase form-control material_select" <?php echo $mode === "view" ? "disabled" : "" ?> name="${item.id}" value="${typeData.find((spec)=> spec.component_id == item.id)?.material_specification_id}"/>
                        </div>`)
                    }
                })
            } else {
                $('#component-container').append(
                    `  <p></p><p class="text-center"> No Data Found </p><p></p>`
                )
            }
            $('.main select').select2({
                tags: true
            })
            appendTable()
        });

        const serialData = JSON.parse('<?php echo json_encode($serialData)  ?>');
        $('#design_standard').empty();

        $.ajax({
            url: "includes/serial_heat_get_design_std.php",
            type: "POST",
            dataType: "html",
            data: {
                productTypeId: productTypeId,
            },
        }).done(function(resultado) {

            let data = resultado ? JSON.parse(resultado) : [];
            data?.map(function(item) {
                $('#design_standard').append(
                    `<option value="${item.id}" selected>
                            ${item.name}
                        </option>`
                )
            })

        });

        $('#testing_standard').empty();

        $.ajax({
            url: "includes/serial_heat_get_testing_std.php",
            type: "POST",
            dataType: "html",
            data: {
                productTypeId: productTypeId,
            },
        }).done(function(resultado) {
            let data = resultado ? JSON.parse(resultado) : [];
            data?.map(function(item) {
                $('#testing_standard').append(
                    `<option value="${item.id}" selected>
                            ${item.name}
                        </option>`
                )
            })

        });
    }

    $('#product_type').on('change', function() {
        return getTypes();
    });

    function setSelect2Option(specs) {
        let options = new Array();
        if (specs?.length > 0) {
            specs?.map(function(elem) {
                let newObj = {
                    id: Number(elem.id),
                    text: elem.material_specification
                }
                options.push(newObj);
            });
            return options
        }
        return options
    }


    $('body').delegate('.component_check', 'change', function() {
        return appendTable();
    })

    function appendTable() {
        $('#table-content').empty();
        let qty = $('#qty').val();
        let productTypeId = $('#product_type').val();
        let componentArr = mandatoryArr;
        let markingArr = JSON.parse($('#marking_arr').val()) ?? []
        let filteredArr = new Array();
        if (markingArr.length > 0) {
            markingArr.map(function(ele) {
                let componentArr = ele?.components?.split(",");
                let heatArr = ele?.heat?.split(",");
                let certificateArr = ele?.certificate?.split(",");
                let components = new Array();
                componentArr?.map(function(item, index) {
                    let newObj = {
                        component_id: item,
                        heat_no: heatArr[index],
                        certificate_no: certificateArr[index]
                    }
                    components.push(newObj);
                })

                filteredArr.push({
                    serial_no: ele.serial_no,
                    component: components
                })
            })
        }

        // $('.component_check:checked').each(function() {
        //     componentArr.push($(this).val());
        // });
        $.post(`get-serial-qty-table-edit.php`, {
            qty: qty,
            type: productTypeId,
            component: componentArr,
            mode: mode,
            markingArr: filteredArr
        }, function(data) {
            $('#table-container').html(data);
        });
    }

    $('#qty').on('keyup', function() {
        return appendTable();
    })

    $('#serial_form').on('submit', function(e) {
        $('#loading_spinner').show();
        $('#serial_form').hide();
        $('#table-container').hide();

        setTimeout(function(){},50000);
        e.preventDefault();
        let id = '<?php echo $id ?>';
        let purchaser = ($('#purchaser').val()).toUpperCase();
        let purchase_date = $('#purchase_date').val();
        let cert_n = $('#cert_n').val();
        let po_no = $('#po_no').val();
        let jc_po_ref = $('#jc_po_ref').val();
        let issued_date = $('#issued_date').val();
        let revision = $('#revision').val();
        let product_type_id = $('#product_type').val();
        let size_id = $('#size').val();
        let bore_id = $('#bore').val();
        let class_id = $('#class').val();
        let end_connection_id = $('#end_connection').val();
        let item = $('#item').val();
        let article = $('#article').val();
        let qty = $('#qty').val();
        let jc_standard = $('#jc_standard').val();
        let other = $('#other').val();
        let hydraulic_shell = $('#hydraulic_shell').val();
        let hydraulic_seat = $('#hydraulic_seat').val();
        let pneumatic_shell = $('#pneumatic_shell').val();
        let pneumatic_seat = $('#pneumatic_seat').val();

        let typeArr = new Array();
        $('#component-container').find('div.main').each(function(index, elem) {
            let component_id = $(elem).find('.component_check').val();
            // let is_component_checked = $(elem).find('.component_check:checked').length;
            let is_component_checked = 0;
            let material_specification_id = $(elem).find('.material_select').val();
            typeArr.push({
                component_id,
                is_component_checked,
                material_specification_id
            })
        });

        let markingArr = new Array();
        $('#table-container').find('table tbody tr').each(function(index, elem) {
            let serial_no = $(elem).find('input.serial').val();
            $(elem).find('input.heat').each(function(i, item) {
                let component_id = $(this).attr('id');
                let heat_description = $(this).val();
                let certificate_description = $($($(elem).find('input.certificate'))[i]).val();
                markingArr.push({
                    serial_no,
                    component_id,
                    heat_description,
                    certificate_description
                });
            });
        })

        let data = {
            id,
            purchaser,
            purchase_date,
            cert_n,
            po_no,
            jc_po_ref,
            issued_date,
            revision,
            product_type_id,
            size_id,
            bore_id,
            class_id,
            end_connection_id,
            item,
            article,
            qty,
            jc_standard,
            other,
            hydraulic_shell,
            hydraulic_seat,
            pneumatic_shell,
            pneumatic_seat,
            typeArr,
            markingArr
        }
        $.ajax({
            url: "includes/update_serial_heat.php",
            type: "POST",
            dataType: "html",
            data: data,
        }).done(function(res) {
            if (res) {
                  $('#loading_spinner').hide();
                  $('#serial_form').show();
                  $('#table-container').show();
                console.log(res);
                alert(res);
                if(res == 'Updated Successfully!'){
                console.log('ok');
                 window.location.href = `${window.location.origin}/serial_view_list.php`;
                }
            }
        });

    })

    $('#excel-import-btn').on('click', function() {
        return importProductExcel();
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
                            removeInvalidExlVal(exceljson)
                        } else {
                            alert('Excel is empty');
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

    function removeInvalidExlVal(rawExcel) {
        $('#errorMsg').css('visibility', 'hidden');
        let dataArr = new Array();
        rawExcel?.map((ele) => {
            let filterObj = new Object();
            if (ele?.serial_no) {
                for (const [objkey, objvalue] of Object.entries(ele)) {
                    if (objkey != 'serial_no' && objkey.toString().endsWith('_heat')) {
                        let component_id = findComponentIdByValue(objkey.toString().replace("_heat", ""));
                        filterObj[component_id] = filterObj[component_id] ? filterObj[component_id] : {};
                        filterObj[component_id]['component_id'] = component_id;
                        filterObj[component_id]['heat_no'] = objvalue;
                    }
                    if (objkey != 'serial_no' && objkey.toString().endsWith('_cert')) {
                        let component_id = findComponentIdByValue(objkey.toString().replace("_cert", ""));
                        filterObj[component_id]['certificate_no'] = objvalue;
                    }
                }
                let filterArr = [...Object.values(filterObj)];
                dataArr.push({
                    serial_no: ele?.serial_no,
                    component: filterArr,
                })
            }
        })
        let isValid = validateExcel(dataArr);
        if (isValid) {
            $.post(`get-serial-qty-table-edit.php`, {
                qty: rawExcel?.length,
                type: $('#product_type').val(),
                component: dataArr[0]?.component?.map((item) => item?.component_id),
                markingArr: dataArr
            }, function(data) {
                $('#errorMsg').css('visibility', 'hidden');
                $('#table-container').html(data);
                document.getElementById("excel-file-import").value = null;
                $('#excel-import-close').click();
            });
        } else {
            $('#errorMsg').css('visibility', 'visible');
        }

    }

    function validateExcel(markingData) {
        let isValid = true;
        if (markingData.length == 0) {
            return false;
        }
        markingData?.map((markingItem) => {
            markingItem?.component?.map((markingComponent) => {
                if (isValid) {
                    let certNo = markingComponent?.certificate_no;
                    let heatNo = markingComponent?.heat_no;
                    let mtcArr = mtcDataArr?.find((elem) => elem?.material_certificate_number
                        .toString() ==
                        certNo.toString());
                    if (mtcArr && Object.keys(mtcArr)?.length > 0 && mtcArr?.heat_number
                        .toString() ==
                        heatNo
                        ?.toString()) {
                        isValid = true;
                    } else {
                        isValid = false;
                    }
                } else {
                    return false;
                }
            })
        })
        return isValid;
    }

    function findComponentIdByValue(value) {
        let textValue = value.trim().toString().replace('_', " ").toUpperCase().toString();
        let componentId = componentDataArr?.find((item) => item?.component == textValue)?.id;
        return componentId;
    }

    function areEqual(array1, array2) {
        if (array1.length === array2.length) {
            return array1.every(element => {
                if (array2.includes(element)) {
                    return true;
                }

                return false;
            });
        }

        return false;
    }


    $('#excel-import-close').on('click', function() {
        document.getElementById("excel-file-import").value = null;
        return $('#errorMsg').css('visibility', 'hidden');
    });

   $( 'body' ).on( 'keypress', ':input[pattern]', function( ev ) {
    var regex  = new RegExp( $(this).attr( 'pattern' ) );
    var newVal = $(this).val() + String.fromCharCode(!ev.charCode ? ev.which : ev.charCode);

    if ( regex.test( newVal ) ) {
        return true;
    } else {
        ev.preventDefault();
        return false;
    }
    } );

      function resetData() {
        let els = document.querySelectorAll('.heat');
        els.forEach(function(el) {
            el.value="";
        });
        let els2 = document.querySelectorAll('.certificate');
        els2.forEach(function(el) {
            el.value="";
        });
        let els3 = document.querySelectorAll('.serial');
        els3.forEach(function(el) {
            el.value="";
        });
    }


    </script>
</body>

</html>