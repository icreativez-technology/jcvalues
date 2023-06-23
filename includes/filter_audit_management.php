<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $dataArr = array();
        $startDate = $_POST['startDate'];
        $endDate = date('Y-m-d', strtotime('+1 day', strtotime($_POST['endDate'])));

        $internalSqlData = "SELECT Basic_Department.Department as department FROM audit_management_list 
        LEFT JOIN internal_audits ON internal_audits.audit_id = audit_management_list.id 
        LEFT JOIN admin_audit_area ON admin_audit_area.id = internal_audits.audit_area_id 
        LEFT JOIN Basic_Department ON Basic_Department.Id_department = admin_audit_area.department_id  
        WHERE audit_management_list.audit_type ='Internal' AND audit_management_list.created_at BETWEEN '$startDate' AND '$endDate' AND audit_management_list.is_deleted = 0";

        $internalConectData = mysqli_query($con, $internalSqlData);
        $internalArr = array();
        while ($result_data = mysqli_fetch_assoc($internalConectData)) {
            array_push($internalArr, $result_data['department']);
        }

        $externalSqlData = "SELECT audit_management_list.audit_type as audit_type, Basic_Department.Department as department FROM audit_management_list 
        LEFT JOIN external_and_customer_audits ON external_and_customer_audits.audit_id = audit_management_list.id
        LEFT JOIN Basic_Department ON Basic_Department.Id_department = external_and_customer_audits.department_id 
        WHERE audit_management_list.audit_type ='External' AND audit_management_list.created_at BETWEEN  '$startDate' AND '$endDate' AND audit_management_list.is_deleted = 0";

        $externalConectData = mysqli_query($con, $externalSqlData);
        $externalArr = array();
        while ($result_data = mysqli_fetch_assoc($externalConectData)) {
            array_push($externalArr, $result_data['department']);
        }

        $inernalCountSql = "SELECT count(*) AS total, sum(case when status = 'Audited' then 1 else 0 end) AS audited, 
        sum(case when status = 'Cancelled' then 1 else 0 end) AS cancelled,
        sum(case when status = 'Scheduled' then 1 else 0 end) AS scheduled,
        sum(case when status = 'Delayed' then 1 else 0 end) AS delay FROM audit_management_list WHERE audit_type = 'Internal'  AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
        $fetchInternalCount = mysqli_query($con, $inernalCountSql);
        $internalCountInfo = mysqli_fetch_assoc($fetchInternalCount);

        $externalCountSql = "SELECT count(*) AS total, sum(case when status = 'Audited' then 1 else 0 end) AS audited, 
        sum(case when status = 'Cancelled' then 1 else 0 end) AS cancelled,
        sum(case when status = 'Scheduled' then 1 else 0 end) AS scheduled,
        sum(case when status = 'Delayed' then 1 else 0 end) AS delay FROM audit_management_list WHERE audit_type = 'External' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
        $fetchExternalCount = mysqli_query($con, $externalCountSql);
        $externalCountInfo = mysqli_fetch_assoc($fetchExternalCount);

        $monthWiseInternalSql = "SELECT audit_type,  MONTH(created_at) as months FROM audit_management_list WHERE audit_type = 'Internal' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
        $fetchMonthWiseInternal = mysqli_query($con, $monthWiseInternalSql);
        $monthWiseInternalArr = array();
        while ($result_data = mysqli_fetch_assoc($fetchMonthWiseInternal)) {
            array_push($monthWiseInternalArr, $result_data);
        }

        $monthWiseExternalSql = "SELECT audit_type, MONTH(created_at) as months FROM audit_management_list WHERE audit_type = 'External' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
        $fetchMonthWiseExternal = mysqli_query($con, $monthWiseExternalSql);
        $monthWiseExternalArr = array();
        while ($result_data = mysqli_fetch_assoc($fetchMonthWiseExternal)) {
            array_push($monthWiseExternalArr, $result_data);
        }

        $dataArr['internal'] = $internalArr;
        $dataArr['external'] = $externalArr;
        $dataArr['internalCount'] = $internalCountInfo;
        $dataArr['externalCount'] = $externalCountInfo;
        $dataArr['monthwiseInternal'] = $monthWiseInternalArr;
        $dataArr['monthwiseExternal'] = $monthWiseExternalArr;
        echo json_encode($dataArr);
    }
}