<?php
  session_start();
  include('includes/functions.php');
  $_SESSION['Page_Title'] = "NCR";
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->

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
        <?php include('includes/header.php'); ?>
        <!-- Includes Top bar and Responsive Menu -->
        <!-- Breadcrumbs + Actions -->
        <div class="row breadcrumbs">
          <div class="col-lg-6">
            <p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
            <!-- MIGAS DE PAN -->
          </div>

          <div class="col-lg-6">
            <div class="d-flex justify-content-end">
              <a href="/ncr_detail.php?type=0">
                <button type="button" class="btn btn-light-primary me-3 topbottons">
                  New NCR
                </button>
              </a>
              <a href="/ncr_view_list.php">
                <button type="button" class="btn btn-light-primary me-3 topbottons">
                  <i class="bi bi-list-ul"></i> View List
                </button>
              </a>
            </div>
          </div>
        </div>
        <!-- End Breadcrumbs + Actions -->
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
          <!--begin::Container-->
          <div class="container-custom" id="kt_content_container">
            <!-- AQUI AÑADIR EL CONTENIDO  -->

            <!--begin::Container-->
            <div class="content d-flex flex-column flex-column-fluid filtros-audit" style="padding: 0;">
              
              <!--filters-->
              <div class="container-full">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-md-2">
                      <label class="filterlabel">From:</label>
                      <input type="date" class="form-control" placeholder="From" name="fromDate"
                        id="fromDate" value="<?php echo date('Y-m-01'); ?>" required />
                    </div>
                    <div class="col-md-2">
                      <label class="filterlabel">To:</label>
                      <input type="date" class="form-control" placeholder="From" name="todate"
                        id="toDate" value="<?php echo date('Y-m-d'); ?>" required />
                    </div>
                    <div class="col-md-2">
                      <label class="">Plant</label>
                      <select class="form-control" name="plant_id" id="plant" onchange="AgregrarPlantRelacionados();" required>
                        <option value="0">Please Select</option>
                        <?php
                          $sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
                          $connect_data = mysqli_query($con, $sql_data);
                          while ($result_data = mysqli_fetch_assoc($connect_data)) {
                            if ($result_data['Status'] == 'Active') {
                              $selected = $risk['plant_id'] == $result_data['Id_plant'] ? 'selected' : '';
                        ?>
                        <option value="<?php echo $result_data['Id_plant']; ?>" <?= $selected; ?>>
                          <?php echo $result_data['Title']; ?>
                        </option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="">Product Group</label>
                      <select class="form-control" name="product_group" required>
                      <?php 
                        $sql_data_pg = "SELECT * FROM Basic_Product_Group";
                        $connect_data_pg = mysqli_query($con, $sql_data_pg);
                        $flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
                                    
                        while ($result_data_pg = mysqli_fetch_assoc($connect_data_pg)) {
                          if($result_data_pg['Status'] == 'Active')
                          {
                            if($result_data_pg['Id_product_group'] == $result_data['Id_product_group'])
                            {
                            $flag_active_selected = 1;        
                            ?>
                          <option value="<?php echo $result_data_pg['Id_product_group']; ?>" selected="selected"><?php echo $result_data_pg['Title']; ?></option>
                            <?php 
                            }
                            else
                            {
                            ?>
                          <option value="<?php echo $result_data_pg['Id_product_group']; ?>"><?php echo $result_data_pg['Title']; ?></option>
                            <?php
                            }
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="">Department</label>
                      <select class="form-control" name="department" required>
                        <?php 
                        $sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
                        $connect_data = mysqli_query($con, $sql_data);
                        $flag_active_selected = 0;/*Bandera para comprobar si la planta del departamento sigue activa*/
                                    
                        while ($result_data_dep = mysqli_fetch_assoc($connect_data)) {
                          if($result_data_dep['Status'] == 'Active')
                          {
                            if($result_data_dep['Id_department'] == $result_data['Id_department'])
                            {
                            $flag_active_selected = 1;

                          ?>
                          <option value="<?php echo $result_data_dep['Id_department']; ?>" selected="selected"><?php echo $result_data_dep['Department']; ?></option>
                          <?php
                            }
                            else
                            {
                          ?>
                          <option value="<?php echo $result_data_dep['Id_department']; ?>"><?php echo $result_data_dep['Department']; ?></option>
                          <?php
                            }
                          }
                          }
                          ?>
                        </select>
                    </div>
                    <!-- <div class="col-md-2 ms-2 mt-6">
                      <Button class="btn btn-sm btn-primary mt-4" id="update">Apply Filter</Button>
                      <Button type="button" class="btn btn-sm btn-secondary mt-4"
                        onClick="window.location.href=window.location.href">Reset
                        Filter</Button>
                    </div> -->
                  </div>
                </div>
              </div>

              <!--board-->
              <div class="row mt-2">
                <div class="col-lg-3 col-md-6 mt-2">
                  <div class="card border-0 border-top border-3 border-primary shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fa fa-pencil text-primary fs-4"></i>
                        </div>
                        <div>
                          <p class="m-0">Create</p>
                          <p class="m-0 text-end">0</p>
                        </div>
                      </div>
                      <div class="mt-2 d-flex align-items-center">
                        <i class="fa fa-info-circle text-secondary me-2"></i>
                        <p class="m-0 text-secondary">&nbsp;</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 mt-2">
                  <div class="card border-0 border-top border-3 border-warning shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fa fa-envelope-open text-warning fs-4"></i>
                        </div>
                        <div>
                          <p class="m-0">Open</p>
                          <p class="m-0 text-end">0</p>
                        </div>
                      </div>
                      <div class="mt-2 d-flex align-items-center">
                        <i class="fa fa-info-circle text-secondary me-2"></i>
                        <p class="m-0 text-secondary">Yet to start, In progress</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 mt-2">
                  <div class="card border-0 border-top border-3 border-info shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fa fa-check-circle text-info fs-4"></i>
                        </div>
                        <div>
                          <p class="m-0">Completed</p>
                          <p class="m-0 text-end">0</p>
                        </div>
                      </div>
                      <div class="mt-2 d-flex align-items-center">
                        <i class="fa fa-info-circle text-secondary me-2"></i>
                        <p class="m-0 text-secondary">&nbsp;</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 mt-2">
                  <div class="card border-0 border-top border-3 border-danger shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fa fa-hourglass-start text-danger fs-4"></i>
                        </div>
                        <div>
                          <p class="m-0">Delay</p>
                          <p class="m-0 text-end">0</p>
                        </div>
                      </div>
                      <div class="mt-2 d-flex align-items-center">
                        <i class="fa fa-info-circle text-secondary me-2"></i>
                        <p class="m-0 text-secondary">&nbsp;</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!--chart-->
              <div class="row mt-4">
                <div class="col-lg-6 mt-2">
                  <div class="card">
                    <div class="card-header pb-2 pt-4">
                      <h4>Month Wise</h4>
                    </div>
                    <div class="card-body">
                      <canvas id="month-wise"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mt-2">
                  <div class="card">
                    <div class="card-header pb-2 pt-4">
                      <h4>Product Group</h4>
                    </div>
                    <div class="card-body">
                      <canvas id="angin-chart"></canvas>
                    </div>
                  </div>
                </div>
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
    <script>
    var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>

    <script type="text/javascript">
      const getRandomVal = (length) => {
        const a = [];
        for (let i = 0; i < length; i++) a[i]=i;

        return shuffle(a);
      }

      const shuffle = (array) => {
        let tmp, current, top = array.length;
        if(top) while(--top) {
          current = Math.floor(Math.random() * (top + 1));
          tmp = array[current];
          array[current] = array[top];
          array[top] = tmp;
        }
        return array;
      }

      //month wise chart
      const monthWiseLabels = [
        'Jan 20',
        'Feb 22',
        'Mar 20',
        'Apr 4',
        'May 6',
        'Jun 27',
        'Aug 28',
        'Sep 9'
      ];

      const monthWiseData = {
        labels: monthWiseLabels,
        datasets: [
          {
            label: 'Open',
            backgroundColor: 'rgb(254, 215, 19)',
            borderColor: 'rgb(254, 215, 19)',
            data: getRandomVal(8),
          },
          {
            label: 'Close',
            backgroundColor: 'rgb(0, 204, 207)',
            borderColor: 'rgb(0, 204, 207)',
            data: getRandomVal(8),
          }
        ]
      };

      const monthWiseChart = new Chart(
        document.getElementById('month-wise'),
        {
          type: 'bar',
          data: monthWiseData,
          options: {
            scales: {
              x: {
                grid: {
                  display: false
                }
              },
              y: {
                grid: {
                  display: false
                }
              }
            }
          }
        }
      );

      //angin group chart
      const anginLabels = [
        'item1',
        'item2',
        'item3',
        'item4',
        'item5',
        'item6',
        'item7',
        'item8',
        'item9',
        'item10',
        'item11',
      ];

      const anginData = {
        labels: anginLabels,
        datasets: [
          {
             label: 'Open',
            backgroundColor: 'rgb(254, 215, 19)',
            borderColor: 'rgb(254, 215, 19)',
            data: getRandomVal(11),
          },
          {
           label: 'Close',
            backgroundColor: 'rgb(0, 204, 207)',
            borderColor: 'rgb(0, 204, 207)',
            data: getRandomVal(11),
          }
        ]
      };

      const anginChart = new Chart(
        document.getElementById('angin-chart'),
        {
          type: 'bar',
          data: anginData,
          options: {
            scales: {
              x: {
                grid: {
                  display: false
                }
              },
              y: {
                grid: {
                  display: false
                }
              }
            }
          }
        }
      );
    </script>
</body>
<!--end::Body-->

</html>