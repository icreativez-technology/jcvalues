<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $id = $_GET["id"];
    $deleted = date("Y/m/d");

    $auditStandardQuery = "SELECT Attachment FROM  audit_standard WHERE Id_audit_standard = '$id'";
    $auditStandardConData = mysqli_query($con, $auditStandardQuery);
    $auditStandardResultData = mysqli_fetch_assoc($auditStandardConData);

    if (!is_dir('../audit-standard-attachments/' . $auditStandardResultData['Attachment'])) {
        chmod("../audit-standard-attachments/" . $auditStandardResultData['Attachment'], 0644);
        unlink("../audit-standard-attachments/" . $auditStandardResultData['Attachment']);
    }
    //eliminar registro
    $consulta = "UPDATE audit_standard SET deleted_at = '$deleted' WHERE Id_audit_standard = '$id'";
    $consultaBD = mysqli_query($con, $consulta);
    header("Location: ../admin_audit-standard.php");
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}