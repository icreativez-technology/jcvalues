<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Forgot Password";

?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<style>
	.required::after {
		content: "*";
		color: #e1261c;
	}
</style>

<body id="kt_body" class="bg-body">
	<div class="d-flex flex-column flex-root">
		<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-cover bgi-attachment-fixed" style="background-image: url(Imagenes/dqms_bg_si.jpg)">
			<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				<a href="/" class="mb-12">
					<img alt="Logo" src="Imagenes/logo_big.png" class="logo_big_dqms" />
				</a>
				<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
					<form class="form" action="includes/forgot-password-form.php" method="post" enctype="multipart/form-data">
						<div class="text-center mb-5">
							<h1 class="text-dark">Forgot Password</h1>
						</div>
						<?php if (isset($_GET['mailerr'])) { ?>
							<div class="text-center mb-5">
								<small class="text-danger fs-6">Something went wrong!</small>
							</div>
						<?php } ?>
						<?php if (isset($_GET['emailerr'])) { ?>
							<div class="text-center mb-5">
								<small class="text-danger fs-6">Invalid email address!</small>
							</div>
						<?php } ?>
						<?php if (isset($_GET['usererr'])) { ?>
							<div class="text-center mb-5">
								<small class="text-danger fs-6">No user is registered with this email address!</small>
							</div>
						<?php } ?>
						<div class="fv-row mb-10">
							<label class="form-label fs-6 fw-bolder text-dark required">Email</label>
							<input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" required />
						</div>
						<div class="text-center">
							<input type="submit" class="btn btn-sm btn-primary w-100 mb-5" value="Send Password Reset Link">
						</div>
					</form>
				</div>
			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<script>
		var hostUrl = "assets/";
	</script>
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<script src="assets/js/custom/authentication/sign-in/general.js"></script>

</body>

</html>