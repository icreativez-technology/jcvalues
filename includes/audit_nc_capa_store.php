<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $audit_id = $_POST["audit_id"];
        $ncr_issue_date = $_POST["ncr_issue_date"];
        $finding_type = $_POST["finding_type"];
        $fileName = null;
        $filePath = null;
        $product_process_impact = $_POST["product_process_impact"];
        $clause = $_POST["clause"];
        $audit_point = $_POST["audit_point"];
        $objective_evidence_details = $_POST["objective_evidence_details"];
        $non_conformance_description = $_POST["non_conformance_description"];
        $prefix = "ANC-";
        $uniqueIdSql = "SELECT unique_id FROM audit_nc_capa_ncr_details order by id DESC LIMIT 1";
        $uniqueIdConnect = mysqli_query($con, $uniqueIdSql);
        $uniqueIdInfo = mysqli_fetch_assoc($uniqueIdConnect);
        $uniqueId = (isset($uniqueIdInfo['unique_id'])) ? $uniqueIdInfo['unique_id'] : null;
        $length = 4;
        if (!$uniqueId) {
            $og_length = $length - 1;
            $last_number = '1';
        } else {
            $code = substr($uniqueId, strlen($prefix));
            $increment_last_number = ((int)$code) + 1;
            $last_number_length = strlen($increment_last_number);
            $og_length = $length - $last_number_length;
            $last_number = $increment_last_number;
        }
        $zeros = "";
        for ($i = 0; $i < $og_length; $i++) {
            $zeros .= "0";
        }
        $unique_id = $prefix . $zeros . $last_number;
        $addSql = "INSERT INTO audit_nc_capa_ncr_details (unique_id, audit_id) VALUES ('$unique_id', '$audit_id')";
        $addResult = mysqli_query($con, $addSql);
        $audit_nc_capa_id = mysqli_insert_id($con);
        if ($_FILES["file"]["name"]) {
            $directory = "../audit_nc_capa/" . $unique_id;
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            $fileName = $_FILES["file"]["name"];
            $targetFile = $directory . basename($fileName);
            $destinationFolder = $directory . "/" . $fileName;
            move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
            $filePath = "audit_nc_capa/" . $unique_id . "/" . $fileName;
        }
        $addSql = "INSERT INTO audit_nc_capa_external (audit_nc_capa_id, ncr_issue_date, finding_type, file_name, file_path, product_process_impact, clause, audit_point, objective_evidence_details, non_conformance_description) VALUES ('$audit_nc_capa_id', '$ncr_issue_date', '$finding_type', '$fileName', '$filePath', '$product_process_impact', '$clause', '$audit_point', '$objective_evidence_details', '$non_conformance_description')";
        $addResult = mysqli_query($con, $addSql);
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../audit_nc_capa_view_list.php");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}