<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Calibration Details";
$type = $_REQUEST['type'];
$disabled = $type == 1 ? true : false;
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
      <?php include('includes/aside-menu.php'); ?>
      <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <?php include('includes/header.php'); ?>
        <div class="row breadcrumbs">
          <div>
            <div>
              <p><a href="/">Home</a> » <a href="/calibration_view_list.php">Calibration List</a> »
                <?php echo $_SESSION['Page_Title']; ?></p>
            </div>
          </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

          <!--Tab-->
          <div class="container-custom" id="kt_content_container">
            <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="master-tab" data-bs-toggle="tab" data-bs-target="#master" type="button" role="tab" aria-controls="details" aria-selected="true">Master</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="mitigation" aria-selected="false">History</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="master" role="tabpanel" aria-labelledby="details-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <div id="custom-section-1">
                        <div class="form-group row mt-2">
                          <div class="col-lg-3 mt-2">
                            <label class="required">Instrument ID</label>
                            <input type="" name="" class="form-control" placeholder="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Serial Number</label>
                            <input type="" name="" class="form-control" placeholder="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Instrument Name</label>
                            <input class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Make</label>
                            <input type="number" class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                        </div>

                        <div class="form-group row mt-2">
                          <div class="col-lg-3 mt-2">
                            <label class="required">Model No</label>
                            <input type="" name="" class="form-control" placeholder="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Date of Purchase</label>
                            <input type="date" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Supplier Name</label>
                            <input class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Specification <small>Range</small> </label>
                            <input type="number" class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                        </div>

                        <div class="form-group row mt-2">
                          <div class="col-lg-3 mt-2">
                            <label class="required">Least Count</label>
                            <input type="" name="" class="form-control" placeholder="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Calibration Frequency<small>(in Day's)</small> </label>
                            <input class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Calibration due on</label>
                            <input type="date" class="form-control" name="" id="date" value="<?php echo date('Y-m-d'); ?>" required <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Calibration duo on</label>
                            <input type="date" class="form-control" name="" id="date" value="<?php echo date('Y-m-d'); ?>" required <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                        </div>

                        <div class="form-group row mt-2">
                          <div class="col-lg-3 mt-2">
                            <label class="required">Storage location</label>
                            <input class="form-control" name="" id="" value="" <?php echo $disabled ? "disabled" : ""  ?> />
                          </div>
                          <div class="col-lg-3 mt-2">
                            <label class="required">Usage Condition</label>
                            <select class="form-control" id="department" name="department_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                              <option value="">Please Select</option>
                            </select>
                          </div>
                          <div class="col-lg-6 mt-2">
                            <label>File Upload</label>
                            <div class="d-flex align-items-center">
                              <input type="file" class="form-control" name="files[]" accept=".pdf" multiple <?php echo $disabled ? "disabled" : ""  ?>>
                              <button class="btn btn-secondary py-2 mt-2">Upload</button>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row mt-2">
                          <div class="col-md-12 mt-2">
                            <table class="table table-row-dashed fs-4 gy-5">
                              <thead>
                                <tr class="text-start text-muted text-uppercase gs-0">
                                  <th class="min-w-500px ps-4">
                                    File Name</th>
                                  <th class="min-w-100px ">
                                    Date</th>
                                  <th class="w-100px">
                                    Action
                                  </th>
                                </tr>
                              </thead>
                              <tbody class="text-gray-600 fw-bold" id="mitigation-table">
                                <tr>
                                  <td>
                                  <td>
                                  <td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <?php
                      if ($type != 1) {
                      ?>
                        <div class="card-footer">
                          <div class="row" style="text-align:center; float:right;">
                            <div class="mb-4">
                              <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">
                                <?php echo $type == 0 ? "Create" : "Update"  ?>
                              </button>
                              <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </form>
                </div>
              </div>

              <!-- History tab -->
              <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="mitigation-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="d-flex justify-content-end mt-4">

                        <button type="button" class="btn btn btn-secondary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#issuanceModal">
                          Issuance
                        </button>
                        <button type="button" class="btn btn btn-secondary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#receiptModal">
                          Receipt
                        </button>
                        <button type="button" class="btn btn btn-secondary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#calibrationInModal">
                          Calibration In
                        </button>
                        <button type="button" class="btn btn btn-secondary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#calibrationOutModal">
                          Calibration Out
                        </button>
                      </div>
                      <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                        <thead>
                          <tr class="text-start text-gray-400 text-uppercase gs-0">
                            <th class="min-w-135px">Type</th>
                            <th class="min-w-150px">Issued to/Send to</th>
                            <th class="min-w-100px">Issued on/Send on</th>
                            <th class="min-w-100px">Received On</th>
                            <?php
                            if ($type != 1) {
                            ?>
                              <th class="min-w-100px">Action</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                          <tr>
                            <td>
                              Calibration In
                            </td>
                            <td>
                              Sherta lab
                            </td>
                            <td>
                              30/09/2022
                            </td>
                            <td>
                              30/09/2022
                            </td>
                            <?php
                            if ($type != 1) {
                            ?>
                              <td>
                                <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#calibrationInModal">
                                  <i class="bi bi-pencil" aria-hidden="true"></i>
                                </button>
                                <a href="/calibration_pdf.php" target="_blank" class="me-3">
                                  <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                                <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                              </td>
                            <?php }  ?>
                          </tr>
                          <tr>
                            <td>
                              Calibration Out
                            </td>
                            <td>
                              Sherta lab
                            </td>
                            <td>
                              30/09/2022
                            </td>
                            <td>
                              30/09/2022
                            </td>
                            <?php
                            if ($type != 1) {
                            ?>
                              <td>
                                <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#calibrationOutModal">
                                  <i class="bi bi-pencil" aria-hidden="true"></i>
                                </button>
                                <a href="/calibration_pdf.php" target="_blank" class="me-3">
                                  <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                                <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                              </td>
                            <?php }  ?>
                          </tr>
                          <tr>
                            <td>
                              Receipt
                            </td>
                            <td>
                              Common/Maintenance
                            </td>
                            <td>
                              30/09/2022
                            </td>
                            <td>
                              30/09/2022
                            </td>
                            <?php
                            if ($type != 1) {
                            ?>
                              <td>
                                <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#receiptModal">
                                  <i class="bi bi-pencil" aria-hidden="true"></i>
                                </button>
                                <a href="/calibration_pdf.php" target="_blank" class="me-3">
                                  <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                                <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                              </td>
                            <?php }  ?>
                          </tr>
                          <tr>
                            <td>
                              Issuance
                            </td>
                            <td>
                              Common/Maintenance
                            </td>
                            <td>
                              30/09/2022
                            </td>
                            <td>
                              30/09/2022
                            </td>
                            <?php
                            if ($type != 1) {
                            ?>
                              <td>
                                <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" data-bs-target="#issuanceModal">
                                  <i class="bi bi-pencil" aria-hidden="true"></i>
                                </button>
                                <a href="/calibration_pdf.php" target="_blank" class="me-3">
                                  <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                                <a href="#"><i class="bi bi-trash" aria-hidden="true"></i></a>
                              </td>
                            <?php }  ?>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <?php
                    if ($type != 1) {
                    ?>
                      <div class="card-footer m-6">
                        <div class="row" style="text-align:center; float:right;">
                          <div class="mb-4">
                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">
                              <?php echo $type == 0 ? "Create" : "Update"  ?>
                            </button>
                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!--Modals-->
    <?php include('calibration_detail_modal.php'); ?>

  </div>
  <?php include('includes/footer.php'); ?>
  <?php include('includes/scrolltop.php'); ?>
  <script>
    var hostUrl = "assets/";
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

</html>