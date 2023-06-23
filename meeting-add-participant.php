<?php 
session_start();
include('includes/functions.php');		
$_SESSION['Page_Title'] = "Add Participant";
/*$documetancion = scandir('/var/www/vhosts/nivelz.biz/dqms.nivelz.biz/documentacion');
 unset($documetancion[array_search('.', $documetancion, true)]);
 unset($documetancion[array_search('..', $documetancion, true)]);*/

 $sql_data = "SELECT * FROM Meeting_Participant WHERE Id_employees = $_REQUEST[pg_id] AND Id_meeting = $_REQUEST[id_meet]";
 //echo $sql_data;
 $connect_data = mysqli_query($con, $sql_data);
 $result_data = mysqli_fetch_assoc($connect_data);


 if(count($result_data) == 0){

 	 
     $sql_data = "INSERT INTO Meeting_Participant VALUES ('', '$_REQUEST[id_meet]', '$_REQUEST[pg_id]')";
     $connect_data = mysqli_query($con, $sql_data);
     $result_data = mysqli_fetch_assoc($connect_data);

     //send mail
     $id_employee =  $_REQUEST[pg_id];
     $consulta_general_who ="SELECT * FROM Basic_Employee WHERE Id_employee = $id_employee";                        
     $consulta_result_general_who = mysqli_query($con, $consulta_general_who);
     $result_datos_general_who = mysqli_fetch_assoc($consulta_result_general_who);

     $id_meeting = $_REQUEST[id_meet];
     $consulta_general_meeting ="SELECT * FROM Meeting WHERE Id_meeting = $id_meeting";                        
     $consulta_result_general_meeting = mysqli_query($con, $consulta_general_meeting);
     $result_datos_general_meeting = mysqli_fetch_assoc($consulta_result_general_meeting);

     $para      = $result_datos_general_who['Email'];
     $titulo    = 'New meeting | '.$result_datos_general_meeting['Custom_Id'].' | '.$result_datos_general_meeting['Start_Date'].' | '.$result_datos_general_meeting['Start_Time'];
     $mensaje   = 'Hello, New Meeting has been scheduled.'; 
     $cabeceras = 'From: D-QMS@jc-valves.com';
     mail($para, $titulo, $mensaje, $cabeceras);

     header('Location: ../meeting_update.php?'.$_REQUEST[id_meet]);

 }else{

 	header('Location: ../meeting_update.php?'.$_REQUEST[id_meet]);

 }


?>

