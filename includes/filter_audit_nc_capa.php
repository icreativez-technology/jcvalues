<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $dataArr = array();
        $startDate = $_POST['startDate'];
        $endDate = date('Y-m-d', strtotime('+1 day', strtotime($_POST['endDate'])));

        $internalSqlData = "SELECT audit_management_list.audit_type as audit_type ,Basic_Department.Department as department FROM audit_nc_capa_ncr_details
        LEFT JOIN internal_audits ON internal_audits.audit_id = audit_nc_capa_ncr_details.audit_id
        LEFT JOIN admin_audit_area ON internal_audits.audit_area_id = admin_audit_area.id
        LEFT JOIN Basic_Department ON admin_audit_area.department_id = Basic_Department.Id_department
        LEFT JOIN audit_management_list ON audit_nc_capa_ncr_details.audit_id = audit_management_list.id WHERE audit_management_list.audit_type = 'Internal'
        AND audit_nc_capa_ncr_details.created_at BETWEEN  '$startDate' AND '$endDate' AND audit_nc_capa_ncr_details.is_deleted = 0;";

        $internalConectData = mysqli_query($con, $internalSqlData);
        $internalArr = array();
        while ($result_data = mysqli_fetch_assoc($internalConectData)) {
            array_push($internalArr, $result_data['department']);
        }

        $externalSqlData = "SELECT audit_management_list.audit_type as audit_type ,Basic_Department.Department as department FROM audit_nc_capa_ncr_details
        LEFT JOIN external_and_customer_audits ON external_and_customer_audits.audit_id = audit_nc_capa_ncr_details.audit_id
        LEFT JOIN Basic_Department ON external_and_customer_audits.department_id = Basic_Department.Id_department
        LEFT JOIN audit_management_list ON audit_nc_capa_ncr_details.audit_id = audit_management_list.id WHERE audit_management_list.audit_type = 'External'
        AND audit_nc_capa_ncr_details.created_at BETWEEN  '$startDate' AND '$endDate' AND audit_nc_capa_ncr_details.is_deleted = 0";

        $externalConectData = mysqli_query($con, $externalSqlData);
        $externalArr = array();
        while ($result_data = mysqli_fetch_assoc($externalConectData)) {
            array_push($externalArr, $result_data['department']);
        }

        $inernalCountSql = "SELECT count(*) AS total, sum(case when audit_nc_capa_ncr_details.status = 'Open' then 1 else 0 end) AS active, 
        sum(case when audit_nc_capa_ncr_details.status = 'Closed' then 1 else 0 end) AS closed FROM audit_nc_capa_ncr_details 
        LEFT JOIN internal_audits ON internal_audits.audit_id = audit_nc_capa_ncr_details.audit_id
        LEFT JOIN audit_management_list ON audit_nc_capa_ncr_details.audit_id = audit_management_list.id
        WHERE audit_management_list.audit_type = 'Internal'  AND audit_nc_capa_ncr_details.created_at BETWEEN '$startDate' AND '$endDate' AND audit_nc_capa_ncr_details.is_deleted = 0";
        $fetchInternalCount = mysqli_query($con, $inernalCountSql);
        $internalCountInfo = mysqli_fetch_assoc($fetchInternalCount);

        $externalCountSql = "SELECT count(*) AS total, sum(case when audit_nc_capa_ncr_details.status = 'Open' then 1 else 0 end) AS active, 
        sum(case when audit_nc_capa_ncr_details.status = 'Closed' then 1 else 0 end) AS closed FROM audit_nc_capa_ncr_details 
        LEFT JOIN external_and_customer_audits ON external_and_customer_audits.audit_id = audit_nc_capa_ncr_details.audit_id
        LEFT JOIN audit_management_list ON audit_nc_capa_ncr_details.audit_id = audit_management_list.id
        WHERE audit_management_list.audit_type = 'External'  AND audit_nc_capa_ncr_details.created_at BETWEEN '$startDate' AND '$endDate' 
        AND audit_nc_capa_ncr_details.is_deleted = 0";
        $fetchExternalCount = mysqli_query($con, $externalCountSql);
        $externalCountInfo = mysqli_fetch_assoc($fetchExternalCount);

        $monthWiseSqlData = "SELECT finding_type FROM audit_nc_capa_ncr_details
        LEFT JOIN audit_nc_capa_external ON audit_nc_capa_ncr_details.id = audit_nc_capa_external.audit_nc_capa_id WHERE audit_nc_capa_ncr_details.created_at BETWEEN  '$startDate' AND '$endDate' AND audit_nc_capa_ncr_details.is_deleted = 0";
        $monthWiseConectData = mysqli_query($con, $monthWiseSqlData);
        $monthWiseArrExternal = array();
        while ($result_data = mysqli_fetch_assoc($monthWiseConectData)) {
            array_push($monthWiseArrExternal, $result_data['finding_type']);
        }

        $monthWiseInternalSqlData = "SELECT finding_type FROM audit_nc_capa_ncr_details
        LEFT JOIN audit_management_execute_check_list ON audit_nc_capa_ncr_details.id = audit_management_execute_check_list.anc_id WHERE audit_nc_capa_ncr_details.created_at BETWEEN  '$startDate' AND '$endDate' AND audit_nc_capa_ncr_details.is_deleted = 0";
        $monthWiseInternalConectData = mysqli_query($con, $monthWiseInternalSqlData);
        $monthWiseArrInternal = array();
        while ($result_data = mysqli_fetch_assoc($monthWiseInternalConectData)) {
            array_push($monthWiseArrInternal, $result_data['finding_type']);
        }


        $dataArr['internal'] = $internalArr;
        $dataArr['external'] = $externalArr;
        $dataArr['internalCount'] = $internalCountInfo;
        $dataArr['externalCount'] = $externalCountInfo;
        $dataArr['monthWiseExternal'] = $monthWiseArrExternal;
        $dataArr['monthWiseInternal'] = $monthWiseArrInternal;
        echo json_encode($dataArr);
    }
}