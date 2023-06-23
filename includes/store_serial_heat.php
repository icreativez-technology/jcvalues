<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_SESSION['usuario'];
    $empSql = "SELECT * From Basic_Employee Where Email = '$email'";
    $fetchEmp = mysqli_query($con, $empSql);
    $EmpInfo = mysqli_fetch_assoc($fetchEmp);

    $purchaser = strtoupper($_POST["purchaser"]);
    $purchase_date = $_POST["purchase_date"];
    $cert_n = strtoupper($_POST["cert_n"]);
    $po_no = strtoupper($_POST["po_no"]);
    $jc_po_ref = strtoupper($_POST["jc_po_ref"]);
    $issued_date = $_POST["issued_date"];
    $revision = $_POST["revision"];
    $product_type_id = $_POST["product_type_id"];
    $size_id = $_POST["size_id"];
    $bore_id = $_POST["bore_id"];
    $class_id = $_POST["class_id"];
    $end_connection_id = $_POST["end_connection_id"];
    $item = strtoupper($_POST["item"]);
    $article = strtoupper($_POST["article"]);
    $qty = $_POST["qty"];
    $jc_standard = strtoupper($_POST["jc_standard"]);
    $other = strtoupper($_POST["other"]);
    $hydraulic_shell = $_POST["hydraulic_shell"];
    $hydraulic_seat = $_POST["hydraulic_seat"];
    $pneumatic_shell = $_POST["pneumatic_shell"];
    $pneumatic_seat = $_POST["pneumatic_seat"];
    $typeArr = $_POST["typeArr"];
    $markingArr = $_POST["markingArr"];
    // print_r($markingArr);
    $created_by = $EmpInfo['Id_employee'];

    $invalid_heat=0;
    $invalid_no="";

    function heatCheck($con, $heat, $certificate){
    $empSql = "SELECT * FROM supplier_certificates WHERE material_certificate_number='$certificate' AND heat_number='$heat'";
    $fetchEmp = mysqli_query($con, $empSql);
    $num_rows = mysqli_num_rows($fetchEmp);
    if($num_rows==0){
        return false;
    }
        return true;
    }



    if ($_SESSION['usuario']) {

        //pre-check if the heat & certificate is found
        foreach ($markingArr as $key => $val) {
           if(isset($val['heat_description']))
           {
            if(heatCheck($con, $val['heat_description'], $val['certificate_description'])==false)
            {
                $invalid_no=$val['serial_no'];
                $invalid_heat=$invalid_heat+1;
                break;
            }
            }
        }

        if($invalid_heat>0){
              // echo "<script type='text/javascript'>alert('Invalid Heat No (or) Certificate No');</script>";
            echo "Invalid Heat No (or) Certificate No. Error in Serial: ".$invalid_no;
            // $msg="Invalid Heat No (or) Certificate No";
            return false;
            // return false;
        }
        else{
        $serialAdd = "INSERT INTO `serial_heat_details` (`purchaser`, `purchase_date`,`cert_n`,`po_no`,`jc_po_ref`,`issued_date`,`revision`,`product_type_id`,`size_id`,`bore_id`,`class_id`,
        `end_connection_id`,`item`,`article`,`qty`,`jc_standard`,`other`,
        `hydraulic_shell`,`hydraulic_seat`,`pneumatic_shell`,`pneumatic_seat`,`created_by`, `is_editable`) VALUES
        ('$purchaser','$purchase_date','$cert_n','$po_no','$jc_po_ref','$issued_date','$revision','$product_type_id',
        '$size_id','$bore_id','$class_id','$end_connection_id','$item','$article','$qty',
        '$jc_standard','$other','$hydraulic_shell','$hydraulic_seat','$pneumatic_shell','$pneumatic_seat','$created_by', '1')";

        $serialAddResult = mysqli_query($con, $serialAdd);
        $serial_heat_id = mysqli_insert_id($con);

        foreach ($typeArr as $key => $val) {
            $addTypeSql = "INSERT INTO `serial_heat_type_material`(`serial_heat_details_id`,`component_id`,`is_component_checked`,`material_specification_id`) VALUES ('$serial_heat_id','$val[component_id]','$val[is_component_checked]','$val[material_specification_id]')";
            $addTypeConnect = mysqli_query($con, $addTypeSql);
        }

        foreach ($markingArr as $key => $val) {
            $addMarkingSql = "INSERT INTO `serial_heat_marking`(`serial_heat_details_id`,`component_id`,`serial_no`,`heat_no_description`,`certificate_no_description`) VALUES ('$serial_heat_id','$val[component_id]','".strtoupper($val['serial_no'])."','".strtoupper($val['heat_description'])."','".strtoupper($val['certificate_description'])."')";
            $addMarkingConnect = mysqli_query($con, $addMarkingSql);
        }
        $msg='Created Successfully!';
        echo $msg;
        //echo true;
    }
    }
    else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo $msg;
    }
}
/* else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}*/

