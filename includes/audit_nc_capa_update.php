<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $id = $_POST["id"];
        $unique_id = $_POST["unique_id"];
        $ncr_issue_date = $_POST["ncr_issue_date"];
        $finding_type = $_POST["finding_type"];
        $clause = $_POST["clause"];
        $audit_point = $_POST["audit_point"];
        $product_process_impact = $_POST["product_process_impact"];
        $objective_evidence_details = $_POST["objective_evidence_details"];
        $non_conformance_description = $_POST["non_conformance_description"];
        $updateSql = "UPDATE `audit_nc_capa_external` SET `ncr_issue_date` = '$ncr_issue_date', `finding_type` = '$finding_type', `clause` = '$clause', `audit_point` = '$audit_point', `product_process_impact` = '$product_process_impact', `objective_evidence_details` = '$objective_evidence_details', `non_conformance_description` = '$non_conformance_description' WHERE `audit_nc_capa_id` = '$id'";
        $updateResult = mysqli_query($con, $updateSql);
        if ($_FILES["file"]["name"]) {
            unlink("../" . $_POST['ext_file_path']);
            $directory = "../audit_nc_capa/" . $unique_id;
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            $fileName = $_FILES["file"]["name"];
            $targetFile = $directory . basename($fileName);
            $destinationFolder = $directory . "/" . $fileName;
            move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
            $filePath = "audit_nc_capa/" . $unique_id . "/" . $fileName;
            $sql = "UPDATE audit_nc_capa_external SET file_path = '$filePath', file_name = '$fileName' WHERE audit_nc_capa_id = '$id'";
            $connect_data = mysqli_query($con, $sql);
        }
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../audit_nc_capa_edit.php?id=$id&ncr");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}