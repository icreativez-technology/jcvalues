<?php

    session_start();
    include('functions.php');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Compliant</title>
</head>

<style>
#element-to-print {
    padding: 0 !important;
    font-family: Poppins,Helvetica,sans-serif;
    height: 1080px;
    position: relative;
}
#element-to-print *{
    font-family: Poppins,Helvetica,sans-serif !important;
}

#element-to-print .bordered-table-body td {
    padding-bottom: 3px;
    padding-top: 3px;
    font-size: 10px;
    color: black !important;
    font-weight: 200;
}
#element-to-print .bordered-table-body tr {
    border: 1px solid rgba(0, 0, 0, 0.125) !important;  
    border-bottom: none !important;
}
#element-to-print .bordered-table-body tr:last-child {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125) !important;
}

#element-to-print p {
    font-size: 10px;
    font-weight: 300;
    color: black !important;
    margin-bottom: 3px;
}

#element-to-print  .bg-title {
    background-color: #F1F9FF;
    font-weight: 700;
    color: black !important;
    font-size: 11px;
    padding-bottom: 3px;
}
#element-to-print  .table-bordered tr td,tr th{
    border: none;
    text-align: left;
    font-size: 10px;
}
#element-to-print .m-0 {
    margin: 0;
}
#element-to-print  .fw-bold {
    font-size: 11px;
    font-weight: 700;
    color: black !important;
} 
#element-to-print .footer {
    position: absolute;
    bottom: 0;
    width: 100%;
} 
#element-to-print .footer p{
    font-size: 10px !important;
}
</style>

<body>
    <!-- first page -->
    <div id="element-to-print">
        <!--Logo-->
        <div class="d-flex justify-content-start">
            <div>
                <img src="./Imagenes/logo_PDF.png" class="mx-auto d-block py-1" width="60">
            </div>
        </div>

        <!--Details-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Customer Compliant Details - Unique Id :CC_21Dec_001</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 30%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr >
                            <td class="fw-bold ps-2">On Behalf of</td>
                            <td class="fw-bold">Customer Name</td>
                            <td class="fw-bold ">Order Ref Number</td>
                            <td class="fw-bold">Product Details</td>
                        </tr>
                        <tr >
                            <td class="text-start ps-2">Lunar Spares</td>
                            <td class="">Lunar Spares Ltd</td>
                            <td class="">order001></td>
                            <td class="">Engine valve</td>
                        </tr>

                        <tr >
                            <td class="fw-bold ps-2">Nature of Compliant</td>
                            <td class="fw-bold">Date</td>
                            <td class="fw-bold ">Email</td>
                            <td class="fw-bold">Phone</td>
                        </tr>
                        <tr >
                            <td class="text-start ps-2">Product Defect</td>
                            <td class="">06 Dec 21</td>
                            <td class="">Kamals@gmail.com</td>
                            <td class="">945678643</td>
                        </tr>

                        <tr >
                            <td class="fw-bold ps-2">Compliant Details</td>
                            <td class="fw-bold"></td>
                            <td class="fw-bold "></td>
                            <td class="fw-bold"></td>
                        </tr>
                        <tr >
                            <td class="text-start ps-2">Valve defect</td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--D1 - D2-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D1 - D2</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 40%">
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 10%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr >
                            <td class="fw-bold ps-2">Action Category</td>
                            <td class="fw-bold">Details of Solution</td>
                            <td class="fw-bold "></td>
                            <td class="fw-bold"></td>
                        </tr>
                        <tr >
                            <td class="text-start ps-2">Processed</td>
                            <td class="">Test</td>
                            <td class=""></td>
                            <td class=""></td>
                        </tr>

                        <tr >
                            <td class="fw-bold ps-2">Plant</td>
                            <td class="fw-bold">Product Group</td>
                            <td class="fw-bold ">Department</td>
                            <td class="fw-bold">Owner</td>
                        </tr>
                        <tr >
                            <td class="text-start ps-2">CBR</td>
                            <td class="">Common</td>
                            <td class="">Maintenance</td>
                            <td class="">Ram V</td>
                        </tr>

                        <tr >
                            <td class="fw-bold ps-2">Team Memebers</td>
                            <td class="fw-bold"></td>
                            <td class="fw-bold "></td>
                            <td class="fw-bold"></td>
                        </tr>
                        <tr >
                            <td class="text-start ps-2">Admin, Boa, Admin, Test, Abhijit Patra</td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--D3-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D3</p>
            </div>
            <div class="card mt-2 border">
                <div class="card-body p-0">
                    <div class="col-12 bg-title">
                        <p class="m-0 fw-bold ">Preliminary Analysis</p>
                    </div>
                    <div class="col-12 mt-1">
                        <p class="m-0 fw-bold ">Indicative Cause of Non Conformance</p>
                    </div>
                    <div class="col-12 mt-1">
                        <p class="m-0 fw-bold ">Test</p>
                    </div>
                    <div class="col-12 bg-title mt-2">
                        <p class="m-0 fw-bold ">Correction</p>
                    </div>
                    <table class="table table-bordered mt-2">
                        <colgroup>
                            <col span="1" style="width: 40%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 20%">
                        </colgroup>
                        <tbody class="text-center bordered-table-body">
                            <tr >
                                <td class="fw-bold ps-2">Correction</td>
                                <td class="fw-bold">Who</td>
                                <td class="fw-bold ">When</td>
                                <td class="fw-bold ">Review</td>
                                <td class="fw-bold ">Status</td>
                                <td class="fw-bold">Remarks</td>
                            </tr>
                            <tr >
                                <td class="text-start ps-2">Test Corr</td>
                                <td class="">Mahesh K</td>
                                <td class="">07 Dec 21</td>
                                <td class="">OK</td>
                                <td class="">100%</td>
                                <td class=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--D4-->
        <div class="row m-0 mt-2">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold">D4</p>
            </div>
            <div class="card mt-2 border">
                <div class="card-body p-0">
                    <div class="col-12 bg-title">
                        <p class="m-0 fw-bold ">Cause Analysis Table (4M Analysis)</p>
                    </div>
                    <table class="table table-bordered mt-2">
                        <colgroup>
                            <col span="1" style="width: 40%">
                            <col span="1" style="width: 30%">
                            <col span="1" style="width: 30%">
                        </colgroup>
                        <tbody class="text-center bordered-table-body">
                            <tr >
                                <td class="fw-bold ps-2">Category</td>
                                <td class="fw-bold">Cause</td>
                                <td class="fw-bold">Significant</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-2">Man</td>
                                <td class="">Test</td>
                                <td class="">Yes</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-2">Machine</td>
                                <td class="">Test 2</td>
                                <td class="">Yes</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="col-12 bg-title mt-1">
                        <p class="m-0 fw-bold ">Why Why Analysis</p>
                    </div>
                    <table class="table table-bordered mt-2">
                        <colgroup>
                            <col span="1" style="width: 30%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 20%">
                        </colgroup>
                        <tbody class="text-center bordered-table-body">
                            <tr>
                                <td class="fw-bold ps-2">Significant Cause</td>
                                <td class="fw-bold">1st Why</td>
                                <td class="fw-bold ">2nd Why</td>
                                <td class="fw-bold ">3rd Why</td>
                                <td class="fw-bold ">4th Why</td>
                                <td class="fw-bold ">5th Why</td>
                                <td class="fw-bold">Root Cause</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-2">Test</td>
                                <td class="">Test Why</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="">Test Why</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-2">Test 2</td>
                                <td class="">Test Why 2</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="">Test Why 2</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="col-12 bg-title mt-1">
                        <p class="m-0 fw-bold ">Corrective Action Plan</p>
                    </div>
                    <table class="table table-bordered mt-2">
                        <tbody class="text-center bordered-table-body">
                            <tr>
                                <td class="fw-bold ps-2">Root Cause</td>
                                <td class="fw-bold">Corrective Action</td>
                                <td class="fw-bold ">Who</td>
                                <td class="fw-bold ">When</td>
                                <td class="fw-bold ">MoC</td>
                                <td class="fw-bold ">Risk Assessment</td>
                                <td class="fw-bold ">Review</td>
                                <td class="fw-bold">Status</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-2">Test why</td>
                                <td class="">Test ca</td>
                                <td class="">Mahesh K</td>
                                <td class="">07 Dec 21</td>
                                <td class="">Yes</td>
                                <td class="">Yes</td>
                                <td class="">OK</td>
                                <td class="">100%</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-2">Test why 2</td>
                                <td class="">Test ca 2</td>
                                <td class="">Santhosh G</td>
                                <td class="">07 Dec 21</td>
                                <td class="">Yes</td>
                                <td class="">Yes</td>
                                <td class="">OK</td>
                                <td class="">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="d-flex justify-content-between border-top mx-4">
                <p class="m-0">Format No: Moc 1 Revision No: 1</p>
                <p class="m-0">Electronically generated document, signature not required. Page 1 of 2</p>
            </div>      
        </div>
    </div>

    <!-- second page -->
    <div id="element-to-print">
        <!--Logo-->
        <div class="d-flex justify-content-start" style="margin-top: 45px">
            <div>
                <img src="./Imagenes/logo_PDF.png" class="mx-auto d-block py-1" width="60">
            </div>
        </div>

        <!--D6 - D7-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D6 - D7</p>
            </div>
            <div class="card mt-2 border">
                <div class="card-body p-0">
                    <div class="col-12 bg-title">
                        <p class="m-0 fw-bold ">Effectiveness verification</p>
                    </div>
                    <table class="table table-bordered mt-2">
                        <tbody class="text-center bordered-table-body">
                            <tr>
                                <td class="fw-bold ps-2">Root Cause</td>
                                <td class="fw-bold">Corrective Action</td>
                                <td class="fw-bold ">Who</td>
                                <td class="fw-bold ">When</td>
                                <td class="fw-bold ">MoC</td>
                                <td class="fw-bold ">Risk Assessment</td>
                                <td class="fw-bold ">Review</td>
                                <td class="fw-bold">Status</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-2">Test why</td>
                                <td class="">Test ca</td>
                                <td class="">Mahesh K</td>
                                <td class="">07 Dec 21</td>
                                <td class="">Yes</td>
                                <td class="">Yes</td>
                                <td class="">OK</td>
                                <td class="">100%</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-2">Test why 2</td>
                                <td class="">Test ca 2</td>
                                <td class="">Santhosh G</td>
                                <td class="">07 Dec 21</td>
                                <td class="">Yes</td>
                                <td class="">Yes</td>
                                <td class="">OK</td>
                                <td class="">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="d-flex justify-content-between border-top mx-4">
                <p class="m-0">Format No: Moc 1 Revision No: 1</p>
                <p class="m-0">Electronically generated document, signature not required. Page 2 of 2</p>
            </div>      
        </div>
    </div>
</body>
<script type="text/javascript" src="./js/accordion-action.js"></script>
</html>