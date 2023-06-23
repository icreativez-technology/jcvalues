<?php
if ($dt['Admin_User'] == 'Employee') {
	/*User is not admin, redirect to dashboard*/
	header("Location: ../index.php");
}
