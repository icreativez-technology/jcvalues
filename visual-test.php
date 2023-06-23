<?php
  session_start();
  include('includes/functions.php');
  $_SESSION['Page_Title'] = "Visual Test";
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags && CSS -->
<?php include('includes/admin_check.php'); ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
  <div class="d-flex flex-column flex-root">
    
    <!--Page-->
    <div class="page d-flex flex-row flex-column-fluid">
      <?php include('includes/aside-menu.php'); ?>
      
      <!--Wrapper-->
      <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        
        <!-- Includes Top bar and Responsive Menu -->
        <?php include('includes/header.php'); ?>
        
        <!--BREADCRUMBS-->
        <div class="breadcrumbs">
          <div>
            <div>
              <p><a href="/">Home</a> » <a href="/admin-panel.php">Admin Panel</a> » <a href="/non-destructive-examination.php">Non-Destructive Examination</a> » <?php echo $_SESSION['Page_Title']; ?></p>
            </div>
          </div>
        </div>

        <!--Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <!--Container-->
          <div class="container-custom" id="kt_content_container">
            
            <div class="row g-5 g-xl-8 mt-1"> 
              <!--Viewing Method-->
              <div class="col-xl-3">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-column flex-center">
                    <div class="mb-2">
                      <h1 class="fw-bold text-gray-800 text-center lh-lg">Viewing Method</h1>
                    </div>
                    <div class="text-center mb-1">
                      <a class="btn btn-sm btn-primary" href="/vt-viewing-method.php">Select</a>
                    </div>
                  </div>
                </div>
              </div>

              <!--Technique-->
              <div class="col-xl-3">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-column flex-center">
                    <div class="mb-2">
                      <h1 class="fw-bold text-gray-800 text-center lh-lg">Technique</h1>
                    </div>
                    <div class="text-center mb-1">
                      <a class="btn btn-sm btn-primary" href="/vt-technique.php">Select</a>
                    </div>
                  </div>
                </div>
              </div>

              <!--Aids For Direct VT-->
              <div class="col-xl-3">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-column flex-center">
                    <div class="mb-2">
                      <h1 class="fw-bold text-gray-800 text-center lh-lg">Aids For Direct VT</h1>
                    </div>
                    <div class="text-center mb-1">
                      <a class="btn btn-sm btn-primary" href="/vt-aids-for-direct.php">Select</a>
                    </div>
                  </div>
                </div>
              </div>

              <!--Equipment For Remote VT-->
              <div class="col-xl-3">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-column flex-center">
                    <div class="mb-2">
                      <h1 class="fw-bold text-gray-800 text-center lh-lg">Equipment For Remote VT</h1>
                    </div>
                    <div class="text-center mb-1">
                      <a class="btn btn-sm btn-primary" href="/vt-equipment-for-remote.php">Select</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row g-5 g-xl-8 mt-1">
              <!--Lighting Type-->
              <div class="col-xl-3">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-column flex-center">
                    <div class="mb-2">
                      <h1 class="fw-bold text-gray-800 text-center lh-lg">Lighting Type</h1>
                    </div>
                    <div class="text-center mb-1">
                      <a class="btn btn-sm btn-primary" href="/vt-lighting-type.php">Select</a>
                    </div>
                  </div>
                </div>
              </div>

              <!--Light Source-->
              <div class="col-xl-3">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-column flex-center">
                    <div class="mb-2">
                      <h1 class="fw-bold text-gray-800 text-center lh-lg">Light Source</h1>
                    </div>
                    <div class="text-center mb-1">
                      <a class="btn btn-sm btn-primary" href="/vt-light-source.php">Select</a>
                    </div>
                  </div>
                </div>
              </div>

              <!--Light Incidence-->
              <div class="col-xl-3">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-column flex-center">
                    <div class="mb-2">
                      <h1 class="fw-bold text-gray-800 text-center lh-lg">Light Incidence</h1>
                    </div>
                    <div class="text-center mb-1">
                      <a class="btn btn-sm btn-primary" href="/vt-light-incidence.php">Select</a>
                    </div>
                  </div>
                </div>
              </div>

              <!--Diffuser Type-->
              <div class="col-xl-3">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-column flex-center">
                    <div class="mb-2">
                      <h1 class="fw-bold text-gray-800 text-center lh-lg">Diffuser Type</h1>
                    </div>
                    <div class="text-center mb-1">
                      <a class="btn btn-sm btn-primary" href="/vt-diffuser-type.php">Select</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include('includes/footer.php'); ?>
      </div>
    </div>
  </div>
  <?php include('includes/scrolltop.php'); ?>
  <script>
    var hostUrl = "assets/";
  </script>
  <!--Global Javascript Bundle(used by all pages)-->
  <script src="assets/plugins/global/plugins.bundle.js"></script>
  <script src="assets/js/scripts.bundle.js"></script>

  <!--Page Vendors Javascript(used by this page)-->
  <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
  <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
  <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>

  <!--Page Custom Javascript(used by this page)-->
  <script src="assets/js/widgets.bundle.js"></script>
  <script src="assets/js/custom/widgets.js"></script>
  <script src="assets/js/custom/apps/chat/chat.js"></script>
  <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
  <script src="assets/js/custom/utilities/modals/select-location.js"></script>
  <script src="assets/js/custom/utilities/modals/users-search.js"></script>

</body>
</html>
