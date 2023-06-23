<?php
session_start();
include('functions.php');
$id = $_REQUEST['id'];
$email = $_SESSION['usuario'];
$userSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchUser = mysqli_query($con, $userSql);
$userInfo = mysqli_fetch_assoc($fetchUser);
$userId = $userInfo['Id_employee'];

$sql = "SELECT * FROM product_types WHERE deleted_at is NULL and status = 1";
$connect = mysqli_query($con, $sql);
$productTypes = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM sizes WHERE is_deleted = 0 and status = 1";
$connect = mysqli_query($con, $sql);
$sizes = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM bores WHERE deleted_at is NULL and status = 1";
$connect = mysqli_query($con, $sql);
$bores = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM classes WHERE is_deleted = 0 and status = 1";
$connect = mysqli_query($con, $sql);
$classes = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM end_connections WHERE deleted_at is NULL and status = 1";
$connect = mysqli_query($con, $sql);
$endConnections = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM design_standards WHERE deleted_at is null and status = 1";
$connect = mysqli_query($con, $sql);
$designStandards = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM testing_standards WHERE deleted_at is null and status = 1";
$connect = mysqli_query($con, $sql);
$testingStandards = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$sql = "SELECT * FROM material_specifications WHERE is_deleted = 0 AND is_editable = 1";
$connect = mysqli_query($con, $sql);
$materialSpecifications = mysqli_fetch_all($connect, MYSQLI_ASSOC);

$serialSql = "SELECT * FROM serial_heat_details WHERE is_deleted = 0 AND id = $id";
$connect_serial =  mysqli_query($con, $serialSql);
$serialData =  mysqli_fetch_assoc($connect_serial);

$typeSql = "SELECT * FROM serial_heat_type_material WHERE is_deleted = 0 AND serial_heat_details_id = $id";
$connect_type = mysqli_query($con, $typeSql);
$typeData =  array();
while ($row = mysqli_fetch_assoc($connect_type)) {
    array_push($typeData, $row);
}

$markingSql = "SELECT serial_no, group_concat(component_id separator ',')  AS components, group_concat(heat_no_description separator ',')  AS heat, group_concat(certificate_no_description separator ',')  AS certificate FROM dmqsdb_jcvalves.serial_heat_marking WHERE is_deleted =0 AND serial_heat_details_id = $id GROUP BY serial_no";
$connect_marking = mysqli_query($con, $markingSql);
$markingData =  array();
while ($row = mysqli_fetch_assoc($connect_marking)) {
    array_push($markingData, $row);
}

$componentSql = "SELECT * FROM components WHERE is_deleted = 0 AND status = 1";
$componentconnect = mysqli_query($con, $componentSql);
$componentDataArr =  array();
while ($row = mysqli_fetch_assoc($componentconnect)) {
    array_push($componentDataArr, $row);
}


$queryString = "SELECT design_standards.id as id, design_standards.design_standard as name FROM design_standards JOIN product_type_design_std ON product_type_design_std.design_std_id = design_standards.id WHERE design_standards.status = '1' AND product_type_design_std.product_type_id = $serialData[product_type_id]";
$queryConnection = mysqli_query($con, $queryString);
$queryData = mysqli_fetch_all($queryConnection, MYSQLI_ASSOC);

$queryStringTesting = "SELECT testing_standards.id as id, testing_standards.testing_standard as name FROM testing_standards JOIN product_type_testing_std ON product_type_testing_std.testing_std_id = testing_standards.id WHERE testing_standards.status = '1' AND product_type_testing_std.product_type_id = $serialData[product_type_id]";
$queryConnectionTesting = mysqli_query($con, $queryStringTesting);
$queryDataTesting = mysqli_fetch_all($queryConnectionTesting, MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quality Certification</title>
</head>

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- <link rel="stylesheet" type="text/css" href="./css/style.css"> -->
<style>
    :root {
        --pdf-height: 1080px;
    }

    #element-to-print {
        margin-right: auto;
        margin-left: auto;
        padding: 0 !important;
        font-family: Poppins, Helvetica, sans-serif;
        height: var(--pdf-height);
        width: 783px;
    }

    #element-to-print p {
        font-size: 10px;
    }

    #element-to-print p .text-uppercase {
        font-size: 9px;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        margin-top: 0;
    }

    #element-to-print .footer {
        /*        position: absolute;*/
        bottom: 0;
        width: 98%;
    }

    #element-to-print .footer p {
        font-size: 10px !important;
    }

    #element-to-print .c-logo img {
        margin-top: -10px
    }

    #element-to-print .c-logo p {
        background-color: yellow;
        margin-top: -5px !important;
    }

    table {
        font-size: 9px;
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid rgba(0, 0, 0, 0.125);
        padding: 3px;
        text-align: center;
    }
</style>

<body>
    <div id="element-to-print">
        <!--Header-->
        <div class="card m-0 mt-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="p-1">
                    <div class="card">
                        <div class="p-1">
                            <img src="./Imagenes/logo_PDF.png" class="mx-auto d-block py-1" width="38">
                        </div>
                    </div>
                </div>
                <div class="flex-fill">
                    <div class="card">
                        <h1 class="text-uppercase text-center m-0 p-1" style="height: 46px;">
                            QUALITY CERTIFICATE
                        </h1>
                    </div>
                </div>
                <div class="p-1">
                    <div class="card">
                        <div class="p-2">
                            <p class="text-center m-0 fw-bold">
                                PS07/F1
                            </p>
                            <p class="text-center m-0 fw-bold">
                                F rev. <?php echo isset($serialData['revision']) ? $serialData['revision'] : '-'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-end m-0 me-4 text-secondary">Sheet 1/4</p>

        <div class="d-flex justify-content-between mt-2 me-2">
            <div class="">
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">Purchaser:</p>
                    <p class="mb-1"><?php echo isset($serialData['purchaser']) ? $serialData['purchaser'] : '-'; ?></p>
                </div>
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">PO.nr:</p>
                    <p class="mb-1"><?php echo isset($serialData['po_no']) ? $serialData['po_no'] : '-'; ?></p>
                </div>
            </div>
            <div class="">
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">Date:</p>
                    <p class="mb-1">
                        <?php echo isset($serialData['issued_date']) ? date("d/m/y", strtotime($serialData['issued_date'])) : '-'; ?>
                    </p>
                </div>
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">JC ref:</p>
                    <p class="mb-1"><?php echo isset($serialData['jc_po_ref']) ? $serialData['jc_po_ref'] : '-'; ?></p>
                </div>
            </div>
            <div class="c-logo">
                <img src="./img/logo1.png" width="30">
                <p class="m-0 fw-bold text-center">0056</p>
            </div>
            <div class="">
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">Cert No:</p>
                    <p class="mb-1"><?php echo isset($serialData['cert_n']) ? $serialData['cert_n'] : '-'; ?></p>
                </div>
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">issued:</p>
                    <p class="mb-1">
                        <?php echo isset($serialData['issued_date']) ? date("d/m/y", strtotime($serialData['issued_date'])) : '-'; ?>
                    </p>
                </div>
            </div>
        </div>

        <p class="mt-2">
            JC Fábrica de Válvulas S.A.U (JCFV S.A.U) CERTIFY that the manufacture of the valves and/or fittings
            mentioned, delivered on account of your referenced order, has been fulfilled according to the specifications
            indicated.
        </p>

        <!--content 1-->
        <div class="card mt-2 ">
            <div class="row m-0">
                <div class="col-12 p-1">
                    <div class="card p-1 h-100">
                        <p class="fw-bold p-0 m-0">PRODUCT DESCRIPTION</p>
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-12 p-1 pt-0">
                    <div class="card p-1 h-100">
                        <div class="d-flex justify-content-between me-2">
                            <div class="d-flex">
                                <p class="m-0 fw-bold">PRODUCT TYPE -</p>
                                <p class="m-0 ps-1">
                                    <?php foreach ($productTypes as $productType) {
                                        if ($serialData['product_type_id'] == $productType['id']) {
                                            echo $productType['product_type'];
                                        }
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-bold m-0">SIZE -</p>
                                <p class="m-0 ps-1">
                                    <?php foreach ($sizes as $size) {
                                        if ($serialData['size_id'] == $size['id']) {
                                            echo $size['size'];
                                        }
                                    } ?>
                                </p>
                            </div>
                            <div class="d-flex">
                                <p class="m-0 fw-bold">BORE -</p>
                                <p class="m-0 ps-1">
                                    <?php foreach ($bores as $bore) {
                                        if ($serialData['bore_id'] == $bore['id']) {
                                            echo $bore['bore'];
                                        }
                                    } ?>
                                </p>
                            </div>
                            <div class="d-flex">
                                <p class="m-0 fw-bold">ENDS -</p>
                                <p class="m-0 ps-1">
                                    <?php foreach ($endConnections as $end_connection) {
                                        if ($serialData['end_connection_id'] == $end_connection['id']) {
                                            echo $end_connection['end_connection'];
                                        }
                                    } ?>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between me-2">
                            <div class="d-flex">
                                <p class="m-0 fw-bold">ARTICLE -</p>
                                <p class="m-0 ps-1">
                                    <?php echo isset($serialData['article']) ? $serialData['article']  : '-'; ?></p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-bold m-0">MODEL -</p>
                                <p class="m-0 ps-1">802</p>
                            </div>
                            <div class="d-flex">
                                <p class="m-0 fw-bold">ITEM -</p>
                                <p class="m-0 ps-1">
                                    <?php echo isset($serialData['item']) ? $serialData['item']  : '-'; ?></p>
                            </div>
                            <div class="d-flex">
                                <p class="m-0 fw-bold">QTY -</p>
                                <p class="m-0 ps-1">
                                    <?php echo isset($serialData['qty']) ? $serialData['qty']   : '-'; ?></p>
                            </div>
                            <div class="d-flex">
                                <p class="m-0 fw-bold">DESIGN STANDARD -</p>
                                <p class="m-0 ps-1">
                                    <?php
                                    foreach ($queryData as $item) {
                                        echo  $item['name'];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--content 2-->
        <div class="card mt-2 ">
            <div class="row m-0">
                <div class="col-12 p-1">
                    <div class="card p-1 h-100">
                        <p class="fw-bold p-0 m-0">TYPE MATERIAL</p>
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-12 p-1 pt-0">
                    <div class="card p-1 h-100">
                        <div class="row">
                            <div class="col-6 d-flex justify-content-start">
                                <div>
                                    <p class="m-0 fw-bold">BODY</p>
                                    <p class="m-0 fw-bold">BODY CONNECTOR</p>
                                    <p class="m-0 fw-bold">BALL</p>
                                    <p class="m-0 fw-bold">STEM</p>
                                    <p class="m-0 fw-bold">O'RING</p>
                                </div>
                                <div class="ms-2">
                                    <p class="m-0">ASTM A182 Gr. F51</p>
                                    <p class="m-0">ASTM A182 Gr. F51</p>
                                    <p class="m-0">ASTM A182 Gr. F51</p>
                                    <p class="m-0">ASTM A182 Gr. F51</p>
                                    <p class="m-0">FKM</p>
                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-start">
                                <div>
                                    <p class="m-0 fw-bold">SEATS</p>
                                    <p class="m-0 fw-bold">BODY GASKETS</p>
                                    <p class="m-0 fw-bold">PACKING</p>
                                    <p class="m-0 fw-bold">BOLTS</p>
                                    <p class="m-0 fw-bold">NUTS</p>
                                </div>
                                <div class="ms-4">
                                    <p class="m-0">RPTFE</p>
                                    <p class="m-0">PTFE/GRAPHITE</p>
                                    <p class="m-0">GRAPHITE</p>
                                    <p class="m-0">ASTM A193 Gr. B8M</p>
                                    <p class="m-0">ASTM A194 Gr. 8M</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--content 3-->
        <div class="card mt-2 ">
            <div class="row m-0">
                <div class="col-12 p-1">
                    <div class="card p-1 h-100">
                        <p class="fw-bold p-0 m-0">TEST DESCRIPTION</p>
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-12 p-1 pt-0">
                    <div class="card p-1 h-100">
                        <div class="d-flex justify-content-between me-2">
                            <p class="m-0">Testing Std.:</p>
                            <?php
                            foreach ($queryDataTesting as $item) {
                                echo  $item['name'];
                            }
                            ?>
                            <!-- <p class="m-0">API 598</p>
                            <p class="fw-bold m-0">...YES...</p>
                            <p class="m-0">DIN 3230 Teil......</p>
                            <p class="m-0">JC Std</p>
                            <p class="m-0">.....PS07/l1</p>
                            <p class="m-0">Other........</p> -->
                        </div>
                        <div class="d-flex justify-content-between me-2">
                            <p class="m-0">Hydraulic (barg): </p>
                            <p class="m-0">Shell</p>
                            <p class="m-0">
                                <?php echo isset($serialData['hydraulic_shell']) ? $serialData['hydraulic_shell']  : '-'; ?>
                            </p>
                            <p class="m-0">Seat</p>
                            <p class="m-0">
                                <?php echo isset($serialData['hydraulic_seat']) ? $serialData['hydraulic_seat']  : '-'; ?>
                            </p>
                            <p class="m-0">/ &nbsp; Pneumatic (barg):</p>
                            <p class="m-0">Shell</p>
                            <p class="m-0">
                                <?php echo isset($serialData['pneumatic_shell']) ? $serialData['pneumatic_shell']   : '-'; ?>
                            </p>
                            <p class="m-0">/ &nbsp; Seat</p>
                            <p class="m-0">
                                <?php echo isset($serialData['pneumatic_seat']) ? $serialData['pneumatic_seat'] : '-'; ?>
                            </p>
                            <p class="m-0">/ &nbsp; Functional</p>
                        </div>
                        <p class="m-0 me-2">
                            Test Results: Satisfactory, seats tightness as per leakage ISO 5208 Rate A for soft seats &
                            Rate D for metal seats.
                        </p>
                        <p class="m-0 me-2">
                            Testing duration as per applicable standard.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!--Serial Number-->
        <div class="mt-3">
            <p class="m-0 fw-bold">MARKING AND TRACEABILITY OF PRESSURE RETAINING PARTS</p>
            <p class="m-0">Main Pressure-retaining parts. (cert. 3.1 enclosed)</p>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Serial. Nr.</th>
                        <th colspan="2">BODY</th>
                        <th colspan="3">BODY CONNECTOR</th>
                        <th colspan="2">BALL</th>
                        <th colspan="2">STEM</th>
                    </tr>
                    <tr>
                        <th>Heat Nr.</th>
                        <th>Certificate Nr.</th>
                        <th>Heat Nr.</th>
                        <th>Heat Nr.</th>
                        <th>Certificate Nr.</th>
                        <th>Heat Nr.</th>
                        <th>Certificate Nr.</th>
                        <th>Heat Nr.</th>
                        <th>Certificate Nr.</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>42112.1001</td>
                        <td>YX2102</td>
                        <td>SH042321</td>
                        <td>YX2102</td>
                        <td>YX2102</td>
                        <td>SH042322</td>
                        <td>K24-S14</td>
                        <td>SH042323</td>
                        <td>YX2102</td>
                        <td>SH042324</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer mt-4">
            <div class="d-flex m-0 mt-2 justify-content-end">
                <div class=" p-1">
                    <p class="m-0 fw-bold">
                        JC Fabrica de Valvulas S.A.U.
                    </p>

                    <p class="m-0 text-muted">
                        Av. Segle XXl, 75 - Pol. Ind. Can Calderon
                    </p>
                    <p class="m-0 text-muted">
                        08830 Sant del Llobregal - Barcelona (Spain)
                    </p>
                </div>
                <div class="p-1 ms-4">
                    <p class="m-0 fw-bold">
                        &nbsp;
                    </p>
                    <div class="border-start border-2 border-danger ps-1">
                        <p class="m-0 text-muted">
                            T. +34 936 548 686
                        </p>
                        <p class="m-0 text-muted">
                            F. +34 936 548 687
                        </p>
                    </div>
                </div>
                <div class="p-1 ms-4">
                    <p class="m-0 fw-bold">
                        &nbsp;
                    </p>
                    <div class="border-start border-2 border-danger ps-1">
                        <p class="m-0 text-muted">
                            jc@jc-valves.com
                        </p>
                        <p class="m-0 text-muted">
                            www.jc-valves.com
                        </p>

                    </div>
                </div>
            </div>
        </div>

        <!--content 4-->
        <div class="card mt-2 ">
            <div class="row m-0">
                <div class="col-12 p-1">
                    <div class="card p-1 h-100">
                        <p class="fw-bold p-0 m-0">NOTES</p>
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-12 p-1 pt-0">
                    <div class="card p-1 h-100">
                        <p class="m-0 me-2">
                            Fire Safe design tested acc. API 6FA, ISO 10497, API 607 / These supply materials are in
                            accordance with NACE MR0175/ISO15156 & NACE MR0103/ISO17945 / Visual and control dimensional
                            results satisfactory as per GAD / Marking according MSS SP-25.
                        </p>
                        <p class="m-0 me-2 mt-2 fw-bold">
                            EU DECLARATION OF CONFORMITY
                        </p>
                        <p class="m-0 me-2 fw-bold">
                            JC FÁBRICA DE VÁLVULAS S.A.U DECLARES THAT:
                        </p>
                        <p class="m-0 me-2">
                            The referred ball valves, classified as pressure accessories, have been designed and
                            manufactured in accordance with the requirements of the Pressure Equipment Directive
                            2014/68/EU and are in conformity with national implementing legislation.
                        </p>
                        <p class="m-0 me-2">
                            This declaration of conformity is issued under the sole responsibility of the manufacturer.
                        </p>

                        <p class="m-0 me-2 mt-2 fw-bold">
                            NOTIFIED BODY WHICH CARRIED OUT THE INSPECTION:
                        </p>
                        <p class="m-0 me-2">
                            BUREAU VERITAS INSPECCIÓN Y TESTING, S.L. (Notified Body nr <b>0056</b>)
                        </p>
                        <p class="m-0 me-2">
                            Camí de Ca n’Ametller, 34, 08195 Sant Cugat del Vallés – Barcelona – Spain
                        </p>
                        <p class="m-0 me-2">
                            Reference number of the Certificate of Quality System Approval <b>CE-0056-PED-H1-JCV
                                001-20-ESP</b>
                        </p>
                        <p class="m-0 me-2 fw-bold">
                            For Category I Notified Body is not required.
                        </p>

                        <p class="m-0 me-2 mt-2 fw-bold">
                            ASSESMENT OF CONFORMITY PROCEDURE FOLLOWED
                        </p>
                        <p class="m-0 me-2">
                            MODULE H1 of ANNEX III of DIRECTIVE 2014/68/EU
                        </p>
                        <p class="m-0 me-2 fw-bold">
                            CE marking must not be affixed for SEP equipment.
                        </p>

                        <p class="m-0 me-2 mt-2 fw-bold">
                            The object of the declaration described above is in conformity with the relevant Union
                            harmonization legislation:

                        </p>
                        <p class="m-0 me-2">
                            Basics standards apply EN 12266-1:2012, API 598 ed.10, EN ISO 17292:2015, ASME B16.34-2017,
                            ASME B16.10-2017, ASME B16.5-2020, ASME B16.25-2017, EN 558-2017, API 6D ed.24, API 600
                            ed.13, API 6FA ed.4, ISO 10497:2010, API 607 ed.7, EN 1983:2013, ISO 5211:2017. For specific
                            standards of each figure type, please see JC datasheets.
                        </p>

                        <p class="m-0 me-2 mt-2">
                            Other DIRECTIVES that apply to this product: ATEX 2014/34/EU classification Group II Cat 2,
                            for use in explosive atmospheres, zones 1, 2 and 21, 22. Evaluation of compliance according
                            to appendix VIII. Marked <img src="./img/mark1.png" width="60"> LCIE 05 AR 023. According
                            UNE EN ISO 80079-36:2017, EN 1127-1:2012.
                        </p>

                        <p class="m-0 me-2 mt-2">
                            NOTE: When the JC Ball valve assemble accessories which require submittal to other
                            Directives they will be labelled with CE mark and to the Declaration of Conformity of JC
                            will be joined the declaration of Conformity of manufacturer of accessory.
                        </p>

                        <div class="d-flex mt-2">
                            <div class="me-4">
                                <p class="m-0 me-2 mt-2 fw-bold">Sant Boi (Barcelona) Spain</p>
                                <p class="m-0 me-2 fw-bold">Cesar Abarca</p>
                                <p class="m-0 me-2 fw-bold">CEO of Organization</p>
                            </div>
                            <div class="">
                                <img src="./img/sign1.png" width="200px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--content 5-->
        <div class="row mt-4">
            <div class="col-6">
                <p class="m-0 fw-bold">
                    Quality Department
                </p>
            </div>
            <div class="col-6">
                <p class="m-0 fw-bold">
                    Third Part Inspection
                </p>
            </div>
        </div>

        <div class="footer">
            <div class="mt-4">
                <div class="d-flex m-0 mt-2 justify-content-end">
                    <div class=" p-1">
                        <p class="m-0 fw-bold">
                            JC Fabrica de Valvulas S.A.U.
                        </p>

                        <p class="m-0 text-muted">
                            Av. Segle XXl, 75 - Pol. Ind. Can Calderon
                        </p>
                        <p class="m-0 text-muted">
                            08830 Sant del Llobregal - Barcelona (Spain)
                        </p>
                    </div>
                    <div class="p-1 ms-4">
                        <p class="m-0 fw-bold">
                            &nbsp;
                        </p>
                        <div class="border-start border-2 border-danger ps-1">
                            <p class="m-0 text-muted">
                                T. +34 936 548 686
                            </p>
                            <p class="m-0 text-muted">
                                F. +34 936 548 687
                            </p>
                        </div>
                    </div>
                    <div class="p-1 ms-4">
                        <p class="m-0 fw-bold">
                            &nbsp;
                        </p>
                        <div class="border-start border-2 border-danger ps-1">
                            <p class="m-0 text-muted">
                                jc@jc-valves.com
                            </p>
                            <p class="m-0 text-muted">
                                www.jc-valves.com
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>