<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Serial vs Heat";
$email = $_SESSION['usuario'];


$sql_data = "SELECT supplier_certificates.heat_number, supplier_certificates.material_certificate_number FROM supplier_certificates";
$connect_data = mysqli_query($con, $sql_data);
$data = mysqli_fetch_all($connect_data, MYSQLI_ASSOC);
$heatNumbers = array_unique(array_column($data, 'heat_number'));
$certificateNumbers = array_unique(array_column($data, 'material_certificate_number'));

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
                                <?php echo $_SESSION['Page_Title']; ?>
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
                                        <input type="hidden" name="componentDataArr" id="componentDataArr"
                                            value='<?php echo json_encode($componentDataArr) ?>' />
                                        <input type="hidden" name="mtcDataArr" id="mtcDataArr"
                                            value='<?php echo json_encode($mtcDataArr) ?>' />
                                        <div class="form-group row">
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Purchaser</label>
                                                <input type="text" name="purchaser" id="purchaser" class="text-uppercase form-control" required>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Purchase Date</label>
                                                <input type="date" id="purchase_date" class="form-control"
                                                    name="purchase_date" required>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Cert N°</label>
                                                <input type="text" name="cert_n" id="cert_n" class="text-uppercase form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">PO. Number</label>
                                                <input type="text" name="po_no" id="po_no" class="text-uppercase form-control"
                                                    required>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">JC PO. Ref</label>
                                                <input type="text" name="jc_po_ref" id="jc_po_ref" class="text-uppercase form-control"
                                                    required>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Issued Date</label>
                                                <input type="date" id="issued_date" class="form-control"
                                                    name="issued_date" required>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Revision</label>
                                                <input type="text" id="revision" class="form-control" name="revision"
                                                    value="0" required disabled>
                                            </div>
                                        </div>
                                        <div class="container-full customer-header d-flex justify-content-between mt-4">
                                            Product Description
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 mt-5">
                                                <label class="required">Product Type</label>
                                                <select class="form-control" data-control="select2" name="product_type"
                                                    id="product_type" required>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($productTypes as $productType) { ?>
                                                    <option value=<?php echo $productType['id']; ?>>
                                                        <?php echo $productType['product_type'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Size</label>
                                                <select class="form-control" data-control="select2" name="size"
                                                    id="size" required>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($sizes as $size) { ?>
                                                    <option value=<?php echo $size['id']; ?>>
                                                        <?php echo $size['size'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Bore</label>
                                                <select class="form-control" data-control="select2" name="bore"
                                                    id="bore" required>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($bores as $bore) { ?>
                                                    <option value=<?php echo $bore['id']; ?>>
                                                        <?php echo $bore['bore'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Class</label>
                                                <select class="form-control" data-control="select2" name="class"
                                                    id="class" required>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($classes as $class) { ?>
                                                    <option value=<?php echo $class['id']; ?>>
                                                        <?php echo $class['class'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">End Connection</label>
                                                <select class="form-control" data-control="select2"
                                                    name="end_connection" id="end_connection" required>
                                                    <option selected="selected" value="">Please Select</option>
                                                    <?php foreach ($endConnections as $end_connection) { ?>
                                                    <option value=<?php echo $end_connection['id']; ?>>
                                                        <?php echo $end_connection['end_connection'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-2 mt-5">
                                                <label class="required">Item</label>
                                                <input type="text" name="item"
                                                    id="item" maxlength="7" class="text-uppercase form-control" required>
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
                                                <input type="text" name="article"
                                                    id="article" class="text-uppercase form-control" required>
                                            </div>
                                            <div class="col-lg-1 mt-5">
                                                <label class="required">Qty</label>
                                                <input type="number" name="qty" class="form-control" id="qty" required>
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
                                                    class="text-uppercase form-control"  required>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <label>Other</label>
                                                <input type="text" name="other" id="other" class="text-uppercase form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 mt-5">
                                                <div class="row form-group">
                                                    <label class="required">Hydraulic (barg)</label>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="hydraulic_shell"
                                                            placeholder="Shell" id="hydraulic_shell" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="hydraulic_seat"
                                                            placeholder="Seat" id="hydraulic_seat" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-5">
                                                <div class="row form-group">
                                                    <label class="required">Pneumatic (barg)</label>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="pneumatic_seat"
                                                            id="pneumatic_seat" placeholder="Seat" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="pneumatic_shell"
                                                            id="pneumatic_shell" placeholder="Shell" >
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-full customer-header d-flex justify-content-between mt-4">
                                            Marking and traceability of pressure retaining parts
                                        </div>
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
                                        <div class="row  mt-3 p-3" id="table-container" style="overflow-x: scroll;">

                                        </div>
                                    </div>
                                    <div class="card-footer mt-3">
                                        <div class="row" style="text-align:center; float:right;">
                                            <div class="mb-4">
                                                <button type="submit" class="btn btn-sm btn-success">Save</button>
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

    <div class="modal" tabindex="-1" data-bs-backdrop="static" role="dialog" id="excel-import-modal">
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
                                excel or seial number missing</small>
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
    let mandatoryArr = new Array();
    let componentDataArr = JSON.parse($('#componentDataArr').val()) ?? [];
    let mtcDataArr = JSON.parse($('#mtcDataArr').val()) ?? [];

    var count = 0;

    $('#product_type').on('change', function() {
        let productTypeId = $(this).val();
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
                            <input class="form-check-input check-size mt-1 component_check" type="hidden" value="${item.id}">
                            <label class="required">${item.component}</label>
                            <select class="text-uppercase form-control material_select" required>
                                <option selected="selected" value="">Please Select</option>
                                ${options.map(function(elem){
                                    return  `<option value="${elem.id}">${elem.text}</option>`
                                })}
                            </select>
                        </div>`
                        );
                    } else {
                        $('#component-container').append(
                            `<div class="p-2 flex-fill main">
                                <input class="form-check-input check-size mt-1 component_check" type="hidden" value="${item.id}">
                            <label class="required">${item.component}</label>
                            <input class="text-uppercase form-control material_select" name="${item.id}"/>
                        </div>`
                        );
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
        let componentArr = new Array();
        $.post(`get-serial-qty-table.php`, {
            qty: qty,
            type: productTypeId,
            component: mandatoryArr
        }, function(data) {
            $('#table-container').html(data);
        });
    }

    // $('#qty').on('keyup', function() {
    //     return appendTable();
    // })
    //the previous method made the system hangs for large qty
    $('#qty').on('blur', function() {
        return appendTable();
    })

    $('#serial_form').on('submit', function(e) {
        count=0;
        
        e.preventDefault();
        
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

        let markingArr = [];
        $('#table-container').find('table tbody tr').each(function(index, elem) {
        let serial_no = $(elem).find('input.serial').val();
        
        $(elem).find('input.heat').each(function(i, item) {
            let component_id = $(item).attr('id');
            let heat_description = $(item).val();
            let certificate_description = $(elem).find('input.certificate').eq(i).val();
            var heatNumbers = <?php echo json_encode($heatNumbers); ?>;
            var certificateNumbers = <?php echo json_encode($certificateNumbers); ?>;
            var foundHeat = false;
            var foundCertificate = false;
            count++;
            
         
            for (var key in heatNumbers) {
                if (heatNumbers.hasOwnProperty(key) && heatNumbers[key] === heat_description) {
                    foundHeat = true;
                    break;
                }
            }

            for (var key in certificateNumbers) {
                if (certificateNumbers.hasOwnProperty(key) && certificateNumbers[key] === certificate_description) {
                    foundCertificate = true;
                    break;
                }
            }

            if (foundHeat && foundCertificate) {
                markingArr.push({
                    serial_no,
                    component_id,
                    heat_description,
                    certificate_description
                });
            } else {
                
                if (!foundHeat) {
                    errorMessage = 'Invalid heat value: ' + heat_description + '\n';
                }
                if (!foundCertificate) {
                    errorMessage += 'Invalid certificate value: ' + certificate_description;
                }
                alert(errorMessage);
            }
        });
      });
    
      if (markingArr.length == count) {

        $('#loading_spinner').show();
        $('#serial_form').hide();
        $('#table-container').hide();
        setTimeout(function(){},50000);
       
        
        let data = {
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
            url: "includes/store_serial_heat.php",
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
                if(res == 'Created Successfully!'){
                console.log('ok');
                 window.location.href = `${window.location.origin}/serial_view_list.php`;
                }
            }
        });
       }
    })

    $('#excel-import-btn').on('click', function() {
        return importProductExcel();
    });

    function importProductExcel() {
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls|.csv)$/;
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
            console.log(rawExcel?.length);
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