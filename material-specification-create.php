<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Add Material Specification";
$sqlData = "SELECT id, parameter FROM chemicals WHERE status = 1";
$connectData = mysqli_query($con, $sqlData);
$count = mysqli_num_rows($connectData);
$half = ceil($count / 2);
$chemicals = mysqli_fetch_all($connectData, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<style>
  .impact-show {
    display: flex;
  }

  .impact-hide {
    display: none;
  }
</style>
<?php include('includes/admin_check.php'); ?>
<!--begin::Body-->
<script>
  function validateForm() {
    $(".material-spec").removeClass("d-block");
    $(".material-spec").addClass("d-none");
    $(".edition").removeClass("d-block");
    $(".edition").addClass("d-none");
    $(".heat").removeClass("d-block");
    $(".heat").addClass("d-none");
    if ($("#material_specification").val() == "") {
      $(".material-spec").removeClass("d-none");
      $(".material-spec").addClass("d-block");
      return false;
    }
    if ($("#nom_comp").val() == "") {
      $(".edition").removeClass("d-none");
      $(".edition").addClass("d-block");
      return false;
    }
    if ($("#heat_treatment").val() == "") {
      $(".heat").removeClass("d-none");
      $(".heat").addClass("d-block");
      return false;
    }
    if ($(".is-invalid")[0]) {
      return false;
    }
    $("#material-specification-add").submit();
  }
</script>

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
        <div class="breadcrumbs">
          <!--begin::body-->
          <div>
            <div>
              <p><a href="/">Home</a> » <a href="/admin-panel.php">Admin Panel</a> » <a href="/material-specification.php">Material Specification</a> »
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
            <!-- AQUI AÑADIR EL CONTENIDO  -->
            <div class="card card-custom gutter-b example example-compact">
              <!--begin::form-->
              <form action="includes/material-specification-add.php" method="post" enctype="multipart/form-data" id="material-specification-add">
                <div class="container-full customer-header d-flex justify-content-between mt-2">
                  General Information
                </div>
                <div class="row mt-3 ms-6 mb-6" style="margin-right:10px;">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Material Specification*</label>
                      <input type="text" class="form-control" name="material_specification" id="material_specification" required oninput="this.value = this.value.toUpperCase()">
                      <small class="text-danger material-spec d-none">The material specification
                        field is required</small>
                      <?php if (isset($_GET['existspec'])) { ?>
                        <small class="text-danger">The material specifcation name has already been
                          taken</small>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Edition*</label>
                      <input type="number" class="form-control" name="nom_comp" id="nom_comp" required>
                      <small class="text-danger edition d-none">The edition field is
                        required</small>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Product Form</label>
                      <select class="form-control" name="product_form">
                        <option value="">Select</option>
                        <option value="casting">CASTING</option>
                        <option value="forging">FORGING</option>
                        <option value="plate">PLATE</option>
                        <option value="bar">BAR</option>
                        <option value="bolting">BOLTING</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>UNS</label>
                      <input type="text" class="form-control" name="uns" oninput="this.value = this.value.toUpperCase()">
                    </div>
                  </div>
                </div>
                <div class="row mt-3 ms-6 mb-6" style="margin-right:10px;">
                  <div class="col-md-6">
                    <div class="row form-group">
                      <label>ASME IX</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="asme_ix_p_no" placeholder="P No" oninput="this.value = this.value.toUpperCase()">
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="asme_ix_group_no" placeholder="Group No" oninput="this.value = this.value.toUpperCase()">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row form-group">
                      <label>Temperature Limit(°C)</label>
                      <div class="col-md-6">
                        <input type="number" step="any" id="min_temperature_limit" onKeyUp="minParameterVal('temperature_limit')" class="form-control" name="temperature_limit_min" placeholder="Minimum">
                      </div>
                      <div class="col-md-6">
                        <input type="number" step="any" id="max_temperature_limit" onKeyUp="maxParameterVal('temperature_limit')" class="form-control" name="temperature_limit_max" placeholder="Maximum">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="container-full customer-header d-flex justify-content-between mt-2">
                  Chemical Information
                </div>
                <div class="row mt-3 ms-6 mb-6" style="margin-right:10px;">
                  <div class="col-md-6 text-center">
                    <table class="table align-middle table-row-dashed gy-1">
                      <tr>
                        <th width="">Select</th>
                        <th width="40%" style="text-align: left;">Parameter<span class="text-danger">*</span></th>
                        <th width="30%" style="text-align: left;">Min</th>
                        <th width="30%" style="text-align: left;">Max</th>
                      </tr>
                      <?php foreach ($chemicals as $key => $chemical) {
                        if ($key < $half) { ?>
                          <tr>
                            <td><input type="checkbox" name="chemical_check_id[]" value=<?php echo $chemical['id']; ?> onChange="checkValue(<?= $key ?>)" id="check_id<?= $key ?>">
                            </td>
                            <td style="text-align: left;" width="50%">
                              <?php echo $chemical['parameter']; ?><input type="hidden" checked name="chemical_id[]" value=<?php echo $chemical['id']; ?>></td>
                            <td><input type="number" step="any" class="form-control" id="min<?= $key ?>" name="minimum_value[]" onKeyUp="minVal(<?= $key ?>)" style="width: 10em;"></td>
                            <td><input type="number" step="any" class="form-control" id="max<?= $key ?>" name="maximum_value[]" onKeyUp="maxVal(<?= $key ?>)" style="width: 10em; margin-left: 0.2em;"></td>
                          </tr>
                      <?php }
                      } ?>
                    </table>
                  </div>
                  <div class="col-md-6 text-center">
                    <table class="table align-middle table-row-dashed gy-1">
                      <tr>
                        <th width="">Select</th>
                        <th width="40%" style="text-align: left;">Parameter<span class="text-danger">*</span></th>
                        <th width="30%" style="text-align: left;">Min</th>
                        <th width="30%" style="text-align: left;">Max</th>
                      </tr>
                      <?php foreach ($chemicals as $key => $chemical) {
                        if ($key >= $half) { ?>
                          <tr>
                            <td><input type="checkbox" name="chemical_check_id[]" value=<?php echo $chemical['id']; ?> onChange="checkValue(<?= $key ?>)" id="check_id<?= $key ?>">
                            </td>
                            <td style="text-align: left;" width="50%">
                              <?php echo $chemical['parameter']; ?><input type="hidden" checked name="chemical_id[]" value=<?php echo $chemical['id']; ?>></td>
                            <td><input type="number" step="any" class="form-control" id="min<?= $key ?>" name="minimum_value[]" onKeyUp="minVal(<?= $key ?>)" style="width: 10em;"></td>
                            <td><input type="number" step="any" class="form-control" id="max<?= $key ?>" name="maximum_value[]" onKeyUp="maxVal(<?= $key ?>)" style="width: 10em; margin-left: 0.2em;"></td>
                          </tr>
                      <?php }
                      } ?>
                    </table>
                  </div>
                </div>
                <div class="container-full customer-header d-flex justify-content-between mt-2">
                  Mechanical Information
                </div>
                <div class="card-header mt-2">
                  <h3 class="card-title">Tensile Test</h3>
                </div>
                <div class="row mt-3 ms-6 mb-6" style="margin-right:10px;">
                  <div class="col-md-3">
                    <div class="row form-group">
                      <label>Tensile Strength (UTS)(Mpa)</label>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="min_tensile_strength" onKeyUp="minParameterVal('tensile_strength')" name="tensile_strength_min" placeholder="Minimum">
                      </div>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="max_tensile_strength" onKeyUp="maxParameterVal('tensile_strength')" name="tensile_strength_max" placeholder="Maximum">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row form-group">
                      <label>Yield Strength (YS)(Mpa)</label>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="min_yield_strength" onKeyUp="minParameterVal('yield_strength')" name="yield_strength_min" placeholder="Minimum">
                      </div>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="max_yield_strength" onKeyUp="maxParameterVal('yield_strength')" name="yield_strength_max" placeholder="Maximum">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row form-group">
                      <label>Elongation (E)(%)</label>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="min_elongation" onKeyUp="minParameterVal('elongation')" name="elongation_min" placeholder="Minimum">
                      </div>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="max_elongation" onKeyUp="maxParameterVal('elongation')" name="elongation_max" placeholder="Maximum">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row form-group">
                      <label>Reduction Area (RA)(%)</label>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="min_reduction_area" onKeyUp="minParameterVal('reduction_area')" name="reduction_area_min" placeholder="Minimum">
                      </div>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="max_reduction_area" onKeyUp="maxParameterVal('reduction_area')" name="reduction_area_max" placeholder="Maximum">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-header mt-2">
                  <h3 class="card-title">Hardness Test</h3>
                </div>
                <div class="row mt-3 ms-6 mb-6" style="margin-right:10px;">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Hardness M.U.</label>
                      <select class="form-control" name="hardness_mu">
                        <option value="">Select</option>
                        <option value="HB">HB</option>
                        <option value="HRC">HRC</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row form-group">
                      <label>Limits</label>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="min_hardness_test_limit" onKeyUp="minParameterVal('hardness_test_limit')" name="hardness_test_limit_min" placeholder="Minimum">
                      </div>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="max_hardness_test_limit" onKeyUp="maxParameterVal('hardness_test_limit')" name="hardness_test_limit_max" placeholder="Maximum">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-header mt-2">
                  <h3 class="card-title"><input type="checkbox" name="impact_test_status" checked onChange="checkImpactStatus(this)" /> &nbsp; Impact Test</h3>
                </div>
                <div class="row mt-3 ms-6 mb-6 impact-div impact-show" style="margin-right:10px;">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Temperature</label>
                      <select class="form-control" name="impact_test_temperature" id="impact_test_temperature">
                        <option value="">Select</option>
                        <option value="-29°C">-29°C</option>
                        <option value="-46°C">-46°C</option>
                        <option value="-50°C">-50°C</option>
                        <option value="-100°C">-100°C</option>
                        <option value="-196°C">-196°C</option>
                        <option value="20°C">20°C</option>
                        <option value="25°C">25°C</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row form-group">
                      <label>Limits</label>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="min_impact_test_limit" onKeyUp="minParameterVal('impact_test_limit')" name="impact_test_limit_min" placeholder="Minimum">
                      </div>
                      <div class="col-md-6">
                        <input type="number" step="any" class="form-control" id="max_impact_test_limit" onKeyUp="maxParameterVal('impact_test_limit')" name="impact_test_limit_max" placeholder="Maximum">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="container-full customer-header d-flex justify-content-between mt-2">
                  Heat Treatment Information
                </div>
                <div class="row mt-3 ms-6 mb-6" style="margin-right:10px;">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Heat Treatment*</label>
                      <input type="text" class="form-control" name="heat_treatment" id="heat_treatment" required oninput="this.value = this.value.toUpperCase()">
                      <small class="text-danger heat d-none">The heat treatment field is
                        required</small>
                      <?php if (isset($_GET['existheat'])) { ?>
                        <small class="text-danger">The heat treatment name has already been
                          taken</small>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div style="float:right; margin-right:10px; margin-bottom:10px;">
                      <button onclick="return validateForm()" class="btn btn-sm btn-success float-right mt-4 me-2">Save</button>
                      <a href="/material-specification.php" class="btn btn-sm btn-danger mt-4 float-right">Cancel</a>
                    </div>
                  </div>
                </div>
              </form>
              <!--end::form-->
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
  <script>
    var hostUrl = "assets/";
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript">

    $('#nom_comp').datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years", 
      autoclose: true,
      endDate: "today"
    });

    function maxVal(keyVal) {
      var max = $('#max' + keyVal).val();
      var min = $('#min' + keyVal).val();
      if ((min == "" && max != "") || (max != "" && min != "" && Number(max) > Number(min))) {
        $('#max' + keyVal).attr('class', 'form-control text-box is-valid');
        $('#min' + keyVal).attr('class', 'form-control text-box is-valid');
        $(':button[type="submit"]').prop('disabled', false);
        $('#check_id' + keyVal).prop('checked', true);
      } else {
        if (max == "" && min == "") {
          $('#min' + keyVal).attr('class', 'form-control');
          $('#max' + keyVal).attr('class', 'form-control');
          $(':button[type="submit"]').prop('disabled', false);
          $('#check_id' + keyVal).prop('checked', false);
        } else if (max == "" && min != "") {
          $('#min' + keyVal).attr('class', 'form-control text-box is-valid');
          $('#max' + keyVal).attr('class', 'form-control text-box is-valid');
          $(':button[type="submit"]').prop('disabled', false);
          $('#check_id' + keyVal).prop('checked', true);
        } else {
          $('#max' + keyVal).attr('class', 'form-control text-box  is-invalid');
          $('#check_id' + keyVal).prop('checked', false);
          $(':button[type="submit"]').prop('disabled', true);
        }
      }
    }

    function minVal(keyVal) {
      var max = $('#max' + keyVal).val();
      var min = $('#min' + keyVal).val();
      if ((max == "" && min != "") || (min != "" && max != "" && Number(max) > Number(min))) {
        $('#min' + keyVal).attr('class', 'form-control text-box is-valid');
        $('#max' + keyVal).attr('class', 'form-control text-box is-valid');
        $(':button[type="submit"]').prop('disabled', false);
        $('#check_id' + keyVal).prop('checked', true);
      } else {
        if (min == "" && max == "") {
          $('#min' + keyVal).attr('class', 'form-control');
          $('#max' + keyVal).attr('class', 'form-control');
          $(':button[type="submit"]').prop('disabled', false);
          $('#check_id' + keyVal).prop('checked', false);
        } else if (min == "" && max != "") {
          $('#min' + keyVal).attr('class', 'form-control text-box is-valid');
          $('#max' + keyVal).attr('class', 'form-control text-box is-valid');
          $(':button[type="submit"]').prop('disabled', false);
          $('#check_id' + keyVal).prop('checked', true);
        } else {
          $('#min' + keyVal).attr('class', 'form-control text-box is-invalid');
          $('#check_id' + keyVal).prop('checked', false);
          $(':button[type="submit"]').prop('disabled', true);
        }
      }
    }

    function checkValue(keyVal) {
      var isChecked = $('#check_id' + keyVal).prop('checked');
      var max = $('#max' + keyVal).val();
      var min = $('#min' + keyVal).val();
      if (!isChecked) {
        $('#min' + keyVal).attr('class', 'form-control');
        $('#max' + keyVal).attr('class', 'form-control');
        $('#max' + keyVal).val("");
        $('#min' + keyVal).val("");
        $(':button[type="submit"]').prop('disabled', false);
      } else {
        if ((max == "" && min != "") || (min == "" && max != "") || (min != "" && max != "" && Number(max) > Number(
            min))) {
          $('#min' + keyVal).attr('class', 'form-control text-box is-valid');
          $('#max' + keyVal).attr('class', 'form-control text-box is-valid');
          $(':button[type="submit"]').prop('disabled', false);
        } else if (min == "" && max == "") {
          $('#min' + keyVal).attr('class', 'form-control text-box is-invalid');
          $('#max' + keyVal).attr('class', 'form-control text-box is-invalid');
          $(':button[type="submit"]').prop('disabled', true);
          $('#check_id' + keyVal).prop('checked', true);
        } else {
          $('#min' + keyVal).attr('class', 'form-control text-box is-invalid');
          $('#max' + keyVal).attr('class', 'form-control text-box is-invalid');
          $('#check_id' + keyVal).prop('checked', false);
          $(':button[type="submit"]').prop('disabled', true);
        }
      }
    }

    function checkImpactStatus(obj) {
      var isChecked = $(obj).prop('checked');
      if (!isChecked) {
        $('#impact_test_temperature').val('');
        $('#min_impact_test_limit').val('');
        $('#max_impact_test_limit').val('');
        minParameterVal('impact_test_limit');
        maxParameterVal('impact_test_limit');
        $('.impact-div').removeClass('impact-show');
        $('.impact-div').addClass('impact-hide');
      } else {
        $('.impact-div').removeClass('impact-hide');
        $('.impact-div').addClass('impact-show');
      }
    }

    function maxParameterVal(field) {
      var max = $("#max_" + field).val();
      var min = $("#min_" + field).val();
      if ((min == "" && max != "") || (max != "" && min != "" && Number(max) > Number(min))) {
        $("#max_" + field).attr('class', 'form-control text-box is-valid');
        $("#min_" + field).attr('class', 'form-control text-box is-valid');
        $(':button[type="submit"]').prop('disabled', false);
      } else {
        if (max == "" && min == "") {
          $("#min_" + field).attr('class', 'form-control');
          $("#max_" + field).attr('class', 'form-control');
          $(':button[type="submit"]').prop('disabled', false);
        } else if (max == "" && min != "") {
          $("#min_" + field).attr('class', 'form-control text-box is-valid');
          $("#max_" + field).attr('class', 'form-control text-box is-valid');
          $(':button[type="submit"]').prop('disabled', false);
        } else {
          $("#max_" + field).attr('class', 'form-control text-box  is-invalid');
          $(':button[type="submit"]').prop('disabled', true);
        }
      }
    }

    function minParameterVal(field) {
      var max = $("#max_" + field).val();
      var min = $("#min_" + field).val();
      if ((max == "" && min != "") || (min != "" && max != "" && Number(max) > Number(min))) {
        $("#min_" + field).attr('class', 'form-control text-box is-valid');
        $("#max_" + field).attr('class', 'form-control text-box is-valid');
        $(':button[type="submit"]').prop('disabled', false);
      } else {
        if (min == "" && max == "") {
          $("#min_" + field).attr('class', 'form-control');
          $("#max_" + field).attr('class', 'form-control');
          $(':button[type="submit"]').prop('disabled', false);
        } else if (min == "" && max != "") {
          $("#min_" + field).attr('class', 'form-control text-box is-valid');
          $("#max_" + field).attr('class', 'form-control text-box is-valid');
          $(':button[type="submit"]').prop('disabled', false);
        } else {
          $("#min_" + field).attr('class', 'form-control text-box is-invalid');
          $(':button[type="submit"]').prop('disabled', true);
        }
      }
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
  <!--end::Page Custom Javascript-->
  <!--end::Javascript-->
</body>
<!--end::Body-->

</html>