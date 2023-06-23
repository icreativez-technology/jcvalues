<?php
// session_start();
include('includes/functions.php');
$directory = "logo/";
$files = scandir($directory);
$logo = $directory . $files[2];
$_SESSION['page']=$_SERVER['HTTP_REFERER'];

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // session_unset();     // unset $_SESSION variable for the run-time
    // session_destroy();
    unset($_SESSION["usuario"]);
    //  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   {
    //           $url = "https://";
    //  }
    // else  {
    //      $url = "http://";
    //  }
    // $url.= $_SERVER['HTTP_HOST'];
    // $url.= $_SERVER['REQUEST_URI'];
    // $_SESSION['page']=$url;
    $_SESSION['page']=$_SERVER['HTTP_REFERER'];
    echo '<script  type="text/javascript">
	alert("Session Ran Out. Please login again");
	window.location.replace(window.location.origin+"/sign-in.php");
	</script>';
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

$isLoggedIn = isset($_SESSION['usuario']) ? true : false;
if (!$isLoggedIn) {
    echo '<script  type="text/javascript">
	window.location.replace(window.location.origin+"/sign-in.php");
	</script>';
}
?>
<style>
    .modal.right .modal-content {
        overflow-y: inherit !important;
    }

    .modal .modal-header {
        padding: 10px !important;
    }
</style>
<!--begin::Header-->
<div id="kt_header" class="header bg-white align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-40px h-40px" id="kt_aside_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Mobile logo-->
        <!-- <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="../../index.php" class="d-lg-none">
                <img alt="Logo" src="<?php echo $logo; ?>" class="h-30px" />
            </a>
        </div> -->
        <!--end::Mobile logo-->

        <!--begin::Wrapper-->
        <div class="d-flex align-items-center justify-content-between flex-lg-grow-1 headermenucustom">
            <!--begin::Navbar-->
            <div style="width: 100% !important;">
                <!--begin::Menu wrapper-->
                <div>
                    <!--begin::Menu-->
                    <h1 class="dqmstitle">DQMS</h1>
                    <p class="dqmssubtitle">( Digital Quality Management Suite )</p>
                    <!--<p style="text-align: center !important;"><img src="Imagenes/logo_Q.png" class="dqmslogo" alt="Digital Quality Management Suite"></p>-->
                    <!--end::Menu-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!-- <a href="/report-bug.php" class="d-flex align-items-center justify-content-between"
                style="min-width: 107px; color:#000">
                <img alt="bug-logo" src="logo/bug-logo.jpeg" class="h-40px w-40px" />
                <span class="mt-2">Report Bug</span>
            </a> -->
            <a href="../../index.php" class="d-flex align-items-center justify-content-between">
                <img alt="Logo" src="<?php echo $logo; ?>" class="h-40px" />
            </a>
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->

<!-- Mitigation Modal start -->
<div class="modal right fade" id="password_popup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" id="change-pass-dlg">
        <form id="change-password-form" class="form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header right-modal">
                    <h5 class="modal-title" id="staticBackdropLabel">Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="required">New Password</label>
                            <input type="password" class="form-control" name="password" id="password_one" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="required">Confirm Password</label>
                            <input type="password" class="form-control" name="confirmpassword" id="password_two" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>

</div>

<div class="modal fade" id="logo_popup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="form" action="includes/upload-logo-form.php" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header right-modal">
                    <h5 class="modal-title" id="staticBackdropLabel">Upload Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <div class="symbol symbol-150px overflow-hidden me-3">
                                <div class="symbol-label">
                                    <img src="assets/media/avatars/<?php echo $dt['Avatar_img']; ?>" class="w-100" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 mt-10">
                            <input type="file" class="form-control mb-2" accept="image/*" name="logo" id="logo">
                            <label>Select image for logo (Max: 1MB)</label>
                            <br />
                            <label>Image name has to be without space.</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let url = window.location.href;
    $('#change-password-form').submit(function(e) {
        e.preventDefault();
        let password1 = $('#password_one').val();
        let password2 = $('#password_two').val();

        $.ajax({
            url: "includes/change-pass.php",
            type: "POST",
            dataType: "html",
            data: {
                password1: password1,
                password2: password2,
            },
        }).done(function(resultado) {
            if (resultado) {

                return window.location.reload();
            }
            return alert('Try Again');
        });
    });
</script>