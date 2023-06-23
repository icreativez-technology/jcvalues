<?php
  session_start();
  include('includes/functions.php');
  $_SESSION['Page_Title'] = "Kaizen Detail";
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
              <p><a href="/">Home</a> » <a href="/kaizen.php">Kaizen</a> » <a href="/kaizen_view_list.php">Kaizen List</a> »
                <?php echo $_SESSION['Page_Title']; ?></p>
            </div>
          </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <div class="container-custom" id="kt_content_container">
            <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Kaizen Details</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="self-tab" data-bs-toggle="tab" data-bs-target="#self" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Self Evalution</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="hod-tab" data-bs-toggle="tab" data-bs-target="#hod" type="button" role="tab" aria-controls="mitigation" aria-selected="false">HOD Evalution</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="committee-tab" data-bs-toggle="tab" data-bs-target="#committee" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Committee Evalution</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <!--Kaizen Details-->
              <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <!-- begin::Form Content -->
                    <div class="card-body">
                      <div class="form-group row mt-2">
                        <div class="col-lg-3 mt-2">
                          <label class="required">Team Leader</label>
                          <select class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value="">Afsal Hussain</option>
                            <option value="">Please Select</option>
                          </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                          <label class="required">Plant</label>
                          <select class="form-control" name="plant_id" id="plant" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value="0">CBR</option>
                            <option value="0">Please Select</option>
                          </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                          <label class="required">Prodcut Group</label>
                          <select class="form-control" name="plant_id" id="plant" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value="0">common</option>
                            <option value="0">Please Select</option>
                          </select>
                        </div>
                        <!-- <div class="col-lg-3 mt-2">
                          <label class="required">Product Details</label>
                          <input type="" name="" class="form-control" <?php  echo $disabled ? "disabled" : ""  ?> >
                        </div>-->
                        <div class="col-lg-3 mt-2">
                          <label class="required">Department</label>
                          <select class="form-control" name="" id="plant" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value="0">Maintenance</option>
                            <option value="0">Please Select</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-3 mt-2">
                          <label class="required">Category</label>
                          <select class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value="">Delivery</option>
                            <option value="">Please Select</option>
                          </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                          <label class="required">Focus Area</label>
                          <select class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value="">New Product/Process Development/Qualification</option>
                            <option value="">Please Select</option>
                          </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                          <label class="required">Process</label>
                          <select class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value="">Final Inspection</option>
                            <option value="">Please Select</option>
                          </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                          <label class="required">Kaizen Type</label>
                          <select class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value="">Individaul</option>
                            <option value="">Please Select</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row mt-2">
                        <!-- <div class="col-lg-3 mt-2">
                          <label class="required">Implemented On</label>
                          <input type="date" class="form-control" name=""
                            id="date" value="< ?php echo date('Y-m-d'); ?>" required < ?php  echo $disabled ? "disabled" : ""  ?> >
                        </div> -->
                        <div class="col-lg-12 mt-2">
                          <label class="required">Team Members</label>
                          <select class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>>
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <label class="required">Theme of Kaizen</label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-6 mt-2">
                          <label class="required">Before Improvement</label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
                        </div>
                        <div class="col-lg-6 mt-2">
                          <label class="required">after Improvement</label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
                        </div>
                      </div>
                      <!-- <div class="form-group row mt-2">
                        <div class="col-lg-6 mt-2">
                          <label>File Upload</label>
                          <div class="d-flex align-items-center">
                            <input type="file" class="form-control" name="files[]" accept=".pdf" multiple <?php  echo $disabled ? "disabled" : ""  ?>>
                            <button class="btn btn-secondary py-2 mt-2">Upload</button>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-md-12 mt-2">
                          <table class="table table-row-dashed fs-4 gy-5">
                            <thead>
                              <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
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
                      </div> -->
                      <div class="d-flex justify-content-between mt-4">
                        <h5 class="fw-bold text-primary m-0">
                          Benefits
                        </h5>
                      </div>
                      <div class="form-group row mt-2 align-items-stretch">
                        <div class="col-lg-4 mt-2">
                          <label class="">
                            Expenditure 
                            <small>(if any)</small>: 
                            <small class="text-primary">Please share details of expenditure incurred to implement Kaizan</small>
                          </label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
                        </div>
                        <div class="col-lg-4 mt-2">
                          <label class="">
                            Direct Savings 
                            <small>(if any)</small>: 
                            <small class="text-primary">Please elaborate direct savings against estimates due to implementation of Kaizan</small>
                          </label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
                        </div>
                        <div class="col-lg-4 mt-2">
                          <label class="required">
                            Indirect Savings 
                            <small>(if any)</small>: 
                            <small class="text-primary">Please elaborate indirect savings e.g. man hours, service level improvement energy, NVA revoval etc.</small>
                          </label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
                        </div>
                      </div>
                      <div class="form-group row mt-2 align-items-stretch">
                        <div class="col-lg-4 mt-2">
                          <label class="">
                            Total Expenditure 
                            <small>(E)</small> 
                            <small class="text-primary ms-2">Enter number only</small>
                          </label>
                          <input type="number" name="" class="form-control" <?php  echo $disabled ? "disabled" : ""  ?> >
                        </div>
                        <div class="col-lg-4 mt-2">
                          <label class="">
                            Total Direct Saving
                            <small>(D)</small> 
                            <small class="text-primary ms-2">Enter number only</small>
                          </label>
                          <input type="number" name="" class="form-control" <?php  echo $disabled ? "disabled" : ""  ?> >
                        </div>
                        <div class="col-lg-4 mt-2">
                          <label class="required">
                            Total Indirect Saving
                            <small>(I)</small>: 
                            <small class="text-primary">Enter number only</small>
                          </label>
                          <input type="number" name="" class="form-control" <?php  echo $disabled ? "disabled" : ""  ?> >
                        </div>
                      </div>
                      <div class="form-group row mt-2 align-items-stretch">
                        <div class="col-lg-4 mt-2">
                          <label class="">
                            Final Monetary Gain 
                            <small>((D + I ) - E)</small> 
                          </label>
                          <input type="number" name="" readonly class="form-control" <?php  echo $disabled ? "disabled" : ""  ?> >
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
                              <?php echo $type == 0 ? "Save" : "Update"  ?>
                            </button>
                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>

              <!--Self Evalution-->
              <div class="tab-pane fade" id="self" role="tabpanel" aria-labelledby="details-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <!-- begin::Form Content -->
                    <div class="card-body">
                      <div class="form-group row mt-2">
                        <div class="col-md-12 mt-2 kaizen-table">
                          <table class="table table-bordered">
                            <thead>
                              <tr class="fw-bold">
                                <th class="min-w-100px p2-4">Criterion</th>
                                <th class="" colspan="4">point</th>
                              </tr>
                            </thead>
                            <tbody class="">
                              <tr class="">
                                <td class="">
                                  Individual or Team
                                </td>
                                <td>
                                  <div>
                                    <p>1 person</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="individual">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>2 person</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="individual">
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>2 person</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="individual" checked>
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  One time or sustainable
                                </td>
                                <td>
                                  <div>
                                    <p>One Time</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="time">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Sustainable for 1 year</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="time">
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Perpetual</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="time" checked>
                                      <label class="form-check-label">
                                        30
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  Proactive/Reactive
                                </td>
                                <td>
                                  <div>
                                    <p>Flower Stage</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Bud Stage</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive">
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Sprout Stage</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive" checked>
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Seed Stage</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive">
                                      <label class="form-check-label">
                                        25
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  Creativity
                                </td>
                                <td>
                                  <div>
                                    <p>Low</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="creativity">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Medium</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="creativity" checked>
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>High</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="creativity">
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Unique</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="creativity">
                                      <label class="form-check-label">
                                        25
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                       <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <h6 class="fw-bold">Focus Area Multiplier: <span class="badge bg-info fs-3 ms-2">1.5</span></h6>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <h6 class="fw-bold">Self Evalution Score: <span class="badge bg-info fs-3 ms-2">128</span></h6>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <label class="">Remarks</label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
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
                              <?php echo $type == 0 ? "Save" : "Update"  ?>
                            </button>
                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>

              <!--HOD Evalution-->
              <div class="tab-pane fade" id="hod" role="tabpanel" aria-labelledby="details-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <!-- begin::Form Content -->
                    <div class="card-body">
                      <div class="form-group row mt-2">
                        <div class="col-md-12 mt-2 kaizen-table">
                          <table class="table table-bordered">
                            <thead>
                              <tr class="fw-bold">
                                <th class="min-w-100px p2-4">Criterion</th>
                                <th class="" colspan="4">points</th>
                              </tr>
                            </thead>
                            <tbody class="">
                              <tr class="">
                                <td class="">
                                  Individual or Team
                                </td>
                                <td>
                                  <div>
                                    <p>1 person</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="individual">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>2 person</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="individual">
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>2 person</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="individual" checked>
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  One time or sustainable
                                </td>
                                <td>
                                  <div>
                                    <p>One Time</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="time">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Sustainable for 1 year</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="time">
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Perpetual</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="time" checked>
                                      <label class="form-check-label">
                                        30
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  Proactive/Reactive
                                </td>
                                <td>
                                  <div>
                                    <p>Flower Stage</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Bud Stage</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive">
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Sprout Stage</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive" >
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Seed Stage</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive" checked>
                                      <label class="form-check-label">
                                        25
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  Creativity
                                </td>
                                <td>
                                  <div>
                                    <p>Low</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="creativity">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Medium</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="creativity" >
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>High</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="creativity">
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Unique</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="creativity" checked>
                                      <label class="form-check-label">
                                        25
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                       <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <h6 class="fw-bold">Focus Area Multiplier: <span class="badge bg-info fs-3 ms-2">1.5</span></h6>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-4 mt-2">
                          <h6 class="fw-bold">Self Evalution Score: <span class="badge bg-info fs-3 ms-2">128</span></h6>
                        </div>
                        <div class="col-lg-4 mt-2">
                          <h6 class="fw-bold">HOD Evalution Score: <span class="badge bg-info fs-3 ms-2">150</span></h6>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <label class="">Remarks</label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
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
                              <?php echo $type == 0 ? "Save" : "Update"  ?>
                            </button>
                            <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>

              <!--Committee Evalution-->
              <div class="tab-pane fade" id="committee" role="tabpanel" aria-labelledby="details-tab">
                <div class="card card-flush">
                  <form class="form" action="" method="post" enctype="multipart/form-data">
                    <!-- begin::Form Content -->
                    <div class="card-body">
                      <div class="form-group row mt-2">
                        <div class="col-md-12 mt-2 kaizen-table">
                          <table class="table table-bordered">
                            <thead>
                              <tr class="fw-bold">
                                <th class="min-w-100px p2-4">Criterion</th>
                                <th class="" colspan="4">points</th>
                              </tr>
                            </thead>
                            <tbody class="">
                              <tr class="">
                                <td class="">
                                  Individual or Team
                                </td>
                                <td>
                                  <div>
                                    <p>1 person</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="individual">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>2 person</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="individual">
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>2 person</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="individual">
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  One time or sustainable
                                </td>
                                <td>
                                  <div>
                                    <p>One Time</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="time">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Sustainable for 1 year</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="time">
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Perpetual</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="time">
                                      <label class="form-check-label">
                                        30
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  Proactive/Reactive
                                </td>
                                <td>
                                  <div>
                                    <p>Flower Stage</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Bud Stage</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive">
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Sprout Stage</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive" >
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Seed Stage</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="Proactive">
                                      <label class="form-check-label">
                                        25
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="">
                                <td class="">
                                  Creativity
                                </td>
                                <td>
                                  <div>
                                    <p>Low</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="creativity">
                                      <label class="form-check-label">
                                        10
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Medium</p>
                                    <div class="form-check mt-2">
                                      <input class="form-check-input" type="radio" name="creativity" >
                                      <label class="form-check-label">
                                        15
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>High</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="creativity">
                                      <label class="form-check-label">
                                        20
                                      </label>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <p>Unique</p>
                                    <div class="form-check form-check-sm mt-2">
                                      <input class="form-check-input" type="radio" name="creativity">
                                      <label class="form-check-label">
                                        25
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                       <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <h6 class="fw-bold">Focus Area Multiplier: <span class="badge bg-info fs-3 ms-2">1.5</span></h6>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-4 mt-2">
                          <h6 class="fw-bold">Self Evalution Score: <span class="badge bg-info fs-3 ms-2">128</span></h6>
                        </div>
                        <div class="col-lg-4 mt-2">
                          <h6 class="fw-bold">HOD Evalution Score: <span class="badge bg-info fs-3 ms-2">150</span></h6>
                        </div>
                        <div class="col-lg-4 mt-2">
                          <h6 class="fw-bold">Evalution committee Score: <span class="badge bg-info fs-3 ms-2">109</span></h6>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-lg-12 mt-2">
                          <label class="">Remarks</label>
                          <textarea rows="2" class="form-control" name="" required <?php  echo $disabled ? "disabled" : ""  ?>></textarea>
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
                              <?php echo $type == 0 ? "Save" : "Update"  ?>
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
    <!--end::Container-->
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
    var hostUrl = "assets/";
    $("input").intlTelInput({
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
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