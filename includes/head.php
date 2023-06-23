<?php
// session_start();
error_reporting(E_ERROR | E_PARSE);
include('includes/functions.php');

//comprobar Login
$email = $_SESSION['usuario'];
// Extraer datos del usuario
$sql_datos_usuario = "SELECT * FROM Basic_Employee WHERE Email = '$email'";
$result_datos_usuario = mysqli_query($con, $sql_datos_usuario);
$dt = mysqli_fetch_assoc($result_datos_usuario);
$Id_employee = $dt['Id_employee'];
if ($_SESSION['Page_Title'] == "Meetings") {
    include('datos-calendar.php');
} else if ($_SESSION['Page_Title'] == "Inspection Management") {
    include('inspection-calendar.php');
}
?>

<!--begin::Head-->

<head>
    <base href="">
    <title>D_QMS <?php echo $_SESSION['Page_Title']; ?></title>
    <meta charset="utf-8" />

    <meta name="description" content="D_QMS for JC Valves." />
    <meta name="keywords" content="D_QMS Program" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="D_QMS" />
    <!-- <meta http-equiv="refresh" content="1800;url=includes/logout.php" /> -->

    <link rel="shortcut icon" href="Imagenes/favicon.png" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Stylesheets-->
    <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/custom/leaflet/leaflet.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!--end::Global Stylesheets Bundle-->
    <script src="JS/jquery-3.6.0.min.js"></script>
    <script src="JS/buscar.js"></script>
    <script src="JS/eliminar-documentos.js"></script>
    <script src="JS/view-documentos.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- fullcalendar -->
    <script src='https://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
    <script src='https://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
    <script src="https://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
    <script src='https://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
    <script src="https://kit.fontawesome.com/ac14141ba7.js" crossorigin="anonymous"></script>

    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        div::-webkit-scrollbar
            {
            height:7px;
            }
        div::-webkit-scrollbar-track
            {
                border-radius: 10px;
                webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);

            }
        div::-webkit-scrollbar-thumb
            {
                background-color: slategray;
                webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
            }

            div::-webkit-scrollbar-thumb:hover
            {
                background-color: slategray;

            }

            /* for filter active status*/
            .blue{
                  color:#009EF7;
            }




    </style>

 </head>
<!--end::Head-->