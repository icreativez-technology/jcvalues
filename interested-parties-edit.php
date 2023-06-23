<?php
session_start();
include('includes/functions.php');
$getDataQuery = "SELECT * FROM interested_parties WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $getDataQuery);
$resultData = mysqli_fetch_assoc($connectData);
$sql = "SELECT * From Basic_Employee Where Id_employee = $resultData[approved_by]";
$fetch = mysqli_query($con, $sql);
$approvedInfo = mysqli_fetch_assoc($fetch);
$sql = "SELECT * From Basic_Employee Where Id_employee = $resultData[created_by]";
$fetch = mysqli_query($con, $sql);
$createdInfo = mysqli_fetch_assoc($fetch);
$partySqlData = "SELECT * FROM interested_party_list WHERE is_deleted = 0 AND interested_party_id = '$_REQUEST[id]'";
$partyData = mysqli_query($con, $partySqlData);
$parties =  array();
while ($row = mysqli_fetch_assoc($partyData)) {
    array_push($parties, $row);
}
$publish = ($resultData['revision'] == 0 && $resultData['is_published'] == 0) ? "true" : "false";
$_SESSION['Page_Title'] = "Edit Interested Party - " . $resultData['year'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!--begin::Body-->
<style>
    .required::after {
        content: "*";
        color: #e1261c;
    }

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

    #parties-form {
        height: 100%;
    }

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        top: 0 !important;
        right: 0 !important;
        margin: auto;
        width: 320px;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Left*/
    .modal.left.fade .modal-dialog {
        left: -320px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog {
        left: 0;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }
</style>

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
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/interested-parties.php">Analysis and Expectations of
                                    Interested Parties</a> »
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
                        <div class="card card-flush">
                            <form class="form" action="includes/interested-parties-update.php" method="post" id="party-form" enctype="multipart/form-data">
                                <!-- begin::Form Content -->
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        Interested Parties
                                    </div>
                                    <div id="custom-section-1">
                                        <div class="form-group row">
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Year</label>
                                                <input type="number" class="form-control" id="year" name="year" value="<?php echo $resultData['year'] ?>" readonly required>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Revision</label>
                                                <input type="text" class="form-control" name="revision" value="<?php echo $resultData['revision'] ?>" readonly required>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Created By</label>
                                                <input type="hidden" class="form-control" name="created_by" value="<?php echo $createdInfo['Id_employee'] ?>" readonly required>
                                                <input type="text" class="form-control" value="<?php echo $createdInfo['First_Name'] . ' ' . $createdInfo['Last_Name']; ?>" readonly>
                                            </div>
                                            <div class="col-lg-3 ver-disabled mt-5">
                                                <label class="required">Approved By</label>
                                                <input type="hidden" class="form-control" name="approved_by" value="<?php echo $approvedInfo['Id_employee'] ?>" readonly required>
                                                <input type="text" class="form-control" value="<?php echo $approvedInfo['First_Name'] . ' ' . $approvedInfo['Last_Name']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container-full customer-header d-flex justify-content-between">
                                        Edit Parties
                                        <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#parties-modal"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <table class="table table-row-dashed fs-6 gy-5">
                                                <thead>
                                                    <tr class="text-start text-muted text-uppercase gs-0">
                                                        <th class="min-w-300px ps-3">
                                                            Interested Party</th>
                                                        <th class="min-w-300px ">
                                                            Requirements</th>
                                                        <th class="w-300px">
                                                            Expectations</th>
                                                        <th class="w-100px">
                                                            Type</th>
                                                        <th class="w-100px">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 fw-bold" id="list-table">
                                                    <input type="hidden" name="dataArr" id="dataArr" value='<?php echo json_encode($parties) ?>'>
                                                    <?php if ($parties && count($parties) > 0) {
                                                        foreach ($parties as $key => $party) { ?>
                                                            <tr id="<?php echo $key ?>">
                                                                <td>

                                                                    <input class="form-control" type="hidden" name="interested_party[]" value="<?php echo $party['interested_party']; ?>" required>
                                                                    <?php echo $party['interested_party']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $party['requirements']; ?>
                                                                    <input class="form-control" type="hidden" name="requirements[]" value="<?php echo $party['requirements']; ?>" required>
                                                                </td>
                                                                <td>
                                                                    <?php echo $party['expectations']; ?>
                                                                    <input class="form-control" type="hidden" name="expectations[]" value="<?php echo $party['expectations']; ?>" required>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="hidden" name="type[]" value="<?php echo $party['type'] ?>" required>
                                                                    <?php
                                                                    if ($party['type'] == "Internal") {
                                                                        echo "Internal";
                                                                    } else {
                                                                        echo "External";
                                                                    }

                                                                    ?>

                                                                </td>
                                                                <td class="list-row" style="vertical-align:middle">
                                                                    <a class="list-edit cursor-pointer me-2" data-id="<?php echo $party['id'] ?>"><i class="bi bi-pencil"></i></a>
                                                                    <a class="list-remove cursor-pointer" data-id="<?php echo $party['id'] ?></td>"><i class="bi bi-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end::Form Content -->
                                <div class="card-footer">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Save</button>
                                            <?php if ($publish == "true") { ?>
                                                <a type="button" class="btn btn-sm btn-warning ms-2" onclick="publish()">Publish</a>
                                            <?php } ?>
                                            <a type="button" href="/interested-parties.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="publish" value="<?php echo $publish; ?>">
                                <input type="hidden" name="id" value="<?php echo $resultData['id']; ?>">
                                <input type="hidden" name="action" id="action" value="save">
                                <!--end::Content-->
                            </form>

                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->


                <!-- Mitigation Modal start -->
                <div class="modal right fade" id="parties-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="parties-form" class="form" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header right-modal">
                                    <h5 class="modal-title" id="staticBackdropLabel">Add Party
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetModalVal()" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="overflow-y: scroll;">
                                    <div class="row mt-2">
                                        <div class="col-md-12 mt-2">
                                            <input type="hidden" class="form-control" id="partyId" name="partyId" value="">
                                            <label class="required">Interested Party</label>
                                            <textarea type="text" class="form-control" id="interestedPartyModal" name="interestedPartyModal" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12 mt-2">
                                            <label class="required">Requirements</label>
                                            <textarea type="text" class="form-control" id="requirementsModal" name="requirementsModal" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12 mt-2">
                                            <label class="required">Expectations</label>
                                            <textarea type="text" class="form-control" id="expectationsModal" name="expectationsModal" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12 mt-2">
                                            <label class="required">Type</label>
                                            <select class="form-control" name="typeModal" id="typeModal" required>
                                                <option value="">Select</option>
                                                </option>
                                                <option value="Internal">Internal</option>
                                                </option>
                                                <option value="External">External</option>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" id="parties-submit">Add</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="parties-cancel" data-bs-dismiss="modal" onclick="resetModalVal();">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- Mitigation Modal End -->
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
    <script>
        let rowId = JSON.parse($('#dataArr').val()).length;
        let editRowId = "";

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('#parties-form').submit(function(e) {
            e.preventDefault()
            let interestedPartyModal = $("#interestedPartyModal").val();
            let requirementsModal = $("#requirementsModal").val();
            let expectationsModal = $("#expectationsModal").val();
            let typeModal = $("#typeModal").val();
            let typeModalContent = $("#typeModal option:selected").text();
            return appendTask(interestedPartyModal, requirementsModal, expectationsModal, typeModal,
                typeModalContent);
        });


        function appendTask(interestedPartyModal, requirementsModal, expectationsModal, typeModal,
            typeModalContent) {
            if (editRowId != "") {
                let content = `
        <td><input class="form-control" type="hidden" name="interested_party[]" value="${interestedPartyModal}" required>${interestedPartyModal}</td>
        <td><input class="form-control" type="hidden" name="requirements[]" value="${requirementsModal}" required>${requirementsModal}</td>
        <td><input class="form-control" type="hidden" name="expectations[]" value="${expectationsModal}" required> ${expectationsModal}</td>
        <td><input class="form-control" type="hidden" name="type[]" value="${typeModal}" required>${typeModalContent}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>`
                $('#' + editRowId).empty();
                $('#' + editRowId).append(content);
            } else {
                rowId++;
                let content = `<tr id="${rowId}"><td ><input class="form-control" type="hidden" name="interested_party[]" value="${interestedPartyModal}" required>${interestedPartyModal}</td>
        <td><input class="form-control" type="hidden" name="requirements[]" value="${requirementsModal}" required>${requirementsModal}</td>
        <td><input class="form-control" type="hidden" name="expectations[]" value="${expectationsModal}" required> ${expectationsModal}</td>
        <td><input class="form-control" type="hidden" name="type[]" value="${typeModal}" required>${typeModalContent}</td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td></tr>`
                $('#list-table').append(content);
            }
            return $('#parties-cancel').trigger("click");
        }

        function resetModalVal() {
            editRowId = "";
            $("#interestedPartyModal").val("");
            $("#expectationsModal").val("");
            $("#requirementsModal").val("");
            return $("#typeModal").val("");
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
            let interestedParty = $(row).find('input[name="interested_party[]"]').val();
            let requirements = $(row).find('input[name="requirements[]"]').val();
            let expectations = $(row).find('input[name="expectations[]"]').val();
            let type = $(row).find('input[name="type[]"]').val()
            return {
                interestedParty,
                requirements,
                expectations,
                type,
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#interestedPartyModal').val(dataArr.interestedParty);
                $('#expectationsModal').val(dataArr.expectations);
                $('#requirementsModal').val(dataArr.requirements);
                $('#typeModal').val(dataArr.type);
                return true;
            }
            return false;
        }

        function publish() {
            $("#action").val("publish");
            $("#party-form").submit();
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>