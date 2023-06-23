<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $id = $_POST['id'];
        $audit_nc_capa_id = $_POST['audit_nc_capa_ncr_id'];
        $root_cause_analysis = $_POST['root_cause_analysis'];
        $corrective_action = $_POST['corrective_action'];
        $recommended_by = $_POST['recommended_by'];
        $date = $_POST['date'];
        $department_affected = $_POST['department_affected'];
        $responsible = $_POST['responsible'];
        $term = $_POST['term'];
        $risk_assessment = $_POST['risk_assessment'];
        $moc = $_POST['moc'];
        if ($id == "") {
            $addSql = "INSERT INTO audit_nc_capa_analysis_ca (audit_nc_capa_ncr_details_id, root_cause_analysis,corrective_action,recommended_by,date,department_affected,term,risk_assessment,moc) VALUES ('$audit_nc_capa_id', '$root_cause_analysis','$corrective_action','$recommended_by','$date','$department_affected','$term','$risk_assessment','$moc')";
            $addResult = mysqli_query($con, $addSql);
        } else {
            $updateSql = "UPDATE audit_nc_capa_analysis_ca SET root_cause_analysis = '$root_cause_analysis',corrective_action = '$corrective_action',recommended_by = '$recommended_by',date = '$date',department_affected='$department_affected',term='$term',risk_assessment='$risk_assessment',moc='$moc' WHERE id = '$id'";
            $updateResult = mysqli_query($con, $updateSql);
        }
        $deleteTeamMembersSql = "UPDATE audit_nc_capa_responsible SET is_deleted = 1 WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id'";
        $deleteTeamMembersSqlResult = mysqli_query($con, $deleteTeamMembersSql);
        foreach ($responsible as $key => $memberId) {
            $isExists = "SELECT id FROM audit_nc_capa_responsible WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id' AND member_id = '$memberId'";
            $result = mysqli_query($con, $isExists);
            if ($result->num_rows == 0) {
                $addMemberSql = "INSERT INTO audit_nc_capa_responsible (audit_nc_capa_ncr_details_id, member_id) VALUES ('$audit_nc_capa_id', '$memberId')";
                $addMemberSqlResult = mysqli_query($con, $addMemberSql);
            } else {
                $updateMemberSql = "UPDATE audit_nc_capa_responsible SET is_deleted = 0 WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id' AND member_id = '$memberId'";
                $updateMemberSqlResult = mysqli_query($con, $updateMemberSql);
            }
        }
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../audit_nc_capa_edit.php?id=$audit_nc_capa_id&analysisCa");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}