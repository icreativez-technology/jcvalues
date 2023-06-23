<?php

session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Login";
$directory = "logo/";
$files = scandir($directory);
$logo = $directory . $files[2];
if (isset($_SESSION['LAST_ATTEMPT']) && (time() - $_SESSION['LAST_ATTEMPT'] > 60)) {
    unset($_SESSION['LAST_ATTEMPT']);
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<!--begin::Body-->

<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-cover bgi-attachment-fixed" style="background-image: url(Imagenes/dqms_bg_si.jpg)">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a class="mb-12">
                    <img alt="Logo" src="<?php echo $logo; ?>" class="logo_big_dqms" />
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="../../demo4/dist/index.html" action="includes/comprobacion-usuario.php" method="post">
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">Sign In to D-QMS</h1>
                            <!--end::Title-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Label-->
                                <label class="form-label fs-6 mb-0">Password</label>
                                <!--end::Label-->
                                <!--begin::Link-->
                                <!-- <a href="/forgot-password.php" class="link-primary fs-6 fw-bolder">Forgot Password ?</a> -->
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                            <!--end::Input-->
                            <div class="d-flex mt-2">
                                <input class="me-2" type="checkbox" name="remember" id="remember" <?= isset($_COOKIE["usermail"]) ? 'checked' : '' ?> />
                                <label class="form-label fs-6 mb-0" for="remember">Remember me</label>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <input type="submit" class="btn btn-sm btn-primary w-100 mb-5" value="Login">
                        </div>
                        <?php if (isset($_SESSION['LAST_ATTEMPT'])) { ?>
                            <small class="text-danger">Your account has been blocked after multiple consecutive login attempts. Please contact Super Administrator.</small>
                        <?php } else if (isset($_SESSION['LOGIN_ATTEMPT'])) { ?>
                            <small class="text-danger">Incorrect Email or Password. Please check your credentials and try again.</small><br>
                            <small class="text-danger">Remaining Attempts : <?php echo 3 - $_SESSION['LOGIN_ATTEMPT'] ?></small>
                        <?php } ?>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <?php include('includes/footer.php'); ?>
            <!--end::Footer-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/custom/authentication/sign-in/general.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>