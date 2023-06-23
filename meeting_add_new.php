<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "New Meeting";
$email = $_SESSION['usuario'];
$sql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetch = mysqli_query($con, $sql);
$empInfo = mysqli_fetch_assoc($fetch);
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
    .required::after {
        content: "*";
        color: #e1261c;
    }

    .ver-disabled input {
        background-color: #e9ecef !important;
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
                            <p><a href="/">Home</a> » <a href="/meeting.php">Meetings</a> » <a href="/meeting_view_list.php">Meeting List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="card card-flush">
                            <form class="form" action="includes/meeting_add.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div id="custom-section-1">
                                        <div class="container-full customer-header">
                                            Schedule
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Title</label>
                                                <input type="text" class="form-control" name="title" required>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Coordinator</label>
                                                <input type="hidden" class="form-control" name="coordinator" value="<?php echo $empInfo['Id_employee']; ?>">
                                                <input type="text" class="form-control" value="<?php echo $empInfo['First_Name'] . ' ' . $empInfo['Last_Name']; ?>" disabled>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Category</label>
                                                <select class="form-control" name="category" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM meeting_category";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active') {
                                                    ?>
                                                            <option value="<?php echo $result_data['Id_meeting_category']; ?>">
                                                                <?php echo $result_data['Title']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Venue</label>
                                                <select class="form-control" name="venue" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql_data = "SELECT * FROM meeting_venue";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active') {
                                                    ?>
                                                            <option value="<?php echo $result_data['Id_meeting_venue']; ?>">
                                                                <?php echo $result_data['Title']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Date</label>
                                                <input type="date" class="form-control" name="date" required min="" id="date">
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">Start Time</label>
                                                <input type="time" class="form-control set-time" id="start_time" name="start_time" required>
                                            </div>
                                            <div class="col-lg-3 mt-5">
                                                <label class="required">End Time</label>
                                                <input type="time" class="form-control set-time" id="end_time" name="end_time" required>
                                            </div>
                                            <div class="col-lg-3 mt-5 ver-disabled">
                                                <label class="required">Duration</label>
                                                <input type="time" class="form-control" id="duration" name="duration" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 mt-5">
                                                <label class="required">Participants</label>
                                                <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Participants" name="participants[]" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" required multiple>
                                                    <?php
                                                    $sql_data = "SELECT * FROM Basic_Employee";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        if ($result_data['Status'] == 'Active' && $result_data['Id_employee'] != $empInfo['Id_employee']) {
                                                    ?>
                                                            <option value="<?php echo $result_data['Id_employee']; ?>">
                                                                <?php echo $result_data['First_Name']; ?>
                                                                <?php echo $result_data['Last_Name']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Save</button>
                                            <a type="button" href="/meeting.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
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

    <script>
        $(document).ready(function() {
            var date = new Date();
            document.getElementById("date").min = date.getFullYear() +
                "-" +
                ("0" + (date.getMonth() + 1)).slice(-2) +
                "-" +
                ("0" + date.getDate()).slice(-2);
        });

        function pad(n) {
            return (n < 10 && n > -1) ? ("0" + n) : n;
        };

        $(".set-time").on("change", function() {
            var valuestart = $("#start_time").val();
            var valuestop = $("#end_time").val();

            var timeStart = new Date("01/01/2022 " + valuestart + ":00");
            var timeEnd = new Date("01/01/2022 " + valuestop + ":00");

            var diff = timeEnd.getTime() - timeStart.getTime();

            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var ss = Math.floor(msec / 1000);
            msec -= ss * 1000;

            let duration = pad(hh) + ":" + pad(mm) + ":" + pad(ss);
            if (duration.includes("-", 0)) {
                $("#duration").val("");
                return $("#end_time").val("");
            };
            return $('#duration').val(String(duration));
        });
    </script>

</body>

</html>