<?php
session_start();
mb_internal_encoding('UTF-8');
require_once '../vendor/autoload.php'; 
// require_once __DIR__ . '/../vendor/autoload.php';
include('functions.php');
include('mtc-certificate.php');


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

$matrialTypeQuery = "SELECT * FROM `serial_heat_type_material`
INNER JOIN components
ON components.id = serial_heat_type_material.component_id
INNER JOIN `material_specifications`
ON material_specifications.id = serial_heat_type_material.material_specification_id
WHERE serial_heat_type_material.`serial_heat_details_id`= $id";

$connect_m_type = mysqli_query($con, $matrialTypeQuery);

$matrialType =  array();
while ($row = mysqli_fetch_assoc($connect_m_type)) {
	array_push($matrialType, $row);
}

$matrialTypeValues = [];
$matrialTypes = [];
foreach ($matrialType as $matrial) {
	array_push($matrialTypes, $matrial['component']);
	array_push($matrialTypeValues, $matrial['material_specification']);
}


// print_r($matrialTypeValues);
// die();

$productTypeId  = $serialData['product_type_id'];

$componentsType = "SELECT component_id FROM product_type_component WHERE product_type_id = $productTypeId AND mandatory= 1";
$pType = mysqli_query($con, $componentsType);

$components   = array();
$componentIds = array();
foreach ($pType as  $type) {
	array_push($componentIds, $type['component_id']);
}


$componentIds  = implode(",", $componentIds);

$markingSql = "SELECT serial_no, group_concat(component_id separator ',')  AS components, group_concat(heat_no_description separator ',')  AS heat, group_concat(certificate_no_description separator ',')  AS certificate FROM serial_heat_marking WHERE is_deleted =0 AND serial_heat_details_id = $id GROUP BY serial_no";
$connect_marking = mysqli_query($con, $markingSql);
$markingData =  array();
while ($row = mysqli_fetch_assoc($connect_marking)) {
	array_push($markingData, $row);
}


$componentSql = "SELECT * FROM components WHERE id IN ($componentIds) ";
$componentconnect = mysqli_query($con, $componentSql);

$componentDataArr =  array();
while ($row = mysqli_fetch_assoc($componentconnect)) {
	array_push($componentDataArr, $row['component']);
}

$queryString = "SELECT design_standards.id as id, design_standards.design_standard as name FROM design_standards JOIN product_type_design_std ON product_type_design_std.design_std_id = design_standards.id WHERE design_standards.status = '1' AND product_type_design_std.product_type_id = $serialData[product_type_id]";
$queryConnection = mysqli_query($con, $queryString);
$queryData = mysqli_fetch_all($queryConnection, MYSQLI_ASSOC);

$queryStringTesting = "SELECT testing_standards.id as id, testing_standards.testing_standard as name FROM testing_standards JOIN product_type_testing_std ON product_type_testing_std.testing_std_id = testing_standards.id WHERE testing_standards.status = '1' AND product_type_testing_std.product_type_id = $serialData[product_type_id]";
$queryConnectionTesting = mysqli_query($con, $queryStringTesting);
$queryDataTesting = mysqli_fetch_all($queryConnectionTesting, MYSQLI_ASSOC);


$revision = $serialData["revision"] ? $serialData["revision"] : "-";
$purchaser = isset($serialData['purchaser']) ? $serialData['purchaser'] : '-';
$po_no = isset($serialData['po_no']) ? $serialData['po_no'] : '-';
$issued_date = isset($serialData['issued_date']) ? date("d/m/y", strtotime($serialData['issued_date'])) : '-';
$jc_po_ref = isset($serialData['jc_po_ref']) ? $serialData['jc_po_ref'] : '-';
$cert_n = isset($serialData['cert_n']) ? $serialData['cert_n'] : '-';

$productType = '';
$productTypeId = '';
foreach ($productTypes as $type) {
	if ($serialData['product_type_id'] == $type['id']) {
		$productType = $type['product_type'];
		$productTypeId = $type['id'];
	};
};

$size = '';
foreach ($sizes as $item) {
	if ($serialData['size_id'] == $item['id']) {
		$size = $item['size'];
	}
}

$bore = '';
foreach ($bores as $item) {
	if ($serialData['bore_id'] == $item['id']) {
		$bore = $item['bore'];
	}
}

$ends = '';

foreach ($endConnections as $end_connection) {
	if ($serialData['end_connection_id'] == $end_connection['id']) {
		$ends = $end_connection['end_connection'];
	}
}

$article = isset($serialData['article']) ? $serialData['article']  : '-';
$jc_standard = isset($serialData['jc_standard']) ? $serialData['jc_standard']  : '-';
$other = isset($serialData['other']) ? $serialData['other']  : '-';
$qty = isset($serialData['qty']) ? $serialData['qty']  : '-';

$model = 802;

$designStandard = '';

foreach ($queryData as $item) {
	$designStandard =  $designStandard . $item['name'];
}

$testingStd = '';

foreach ($queryDataTesting as $item) {
	$testingStd = $testingStd . ', ' .  $item['name'];
}


$hydraulicShell = isset($serialData['hydraulic_shell']) ? $serialData['hydraulic_shell']  : '-';
$hydraulicSeat  = isset($serialData['hydraulic_seat']) ? $serialData['hydraulic_seat']  : '-';
$pneumaticShell = isset($serialData['pneumatic_shell']) ? $serialData['pneumatic_shell']   : '-';
$pneumaticSeat  = isset($serialData['pneumatic_seat']) ? $serialData['pneumatic_seat'] : '-';
$item  = isset($serialData['item']) ? $serialData['item']  : '-';
$qty   = isset($serialData['qty']) ? $serialData['qty']   : '-';


$materialData = [];
for ($i = 0; $i <= count($componentDataArr) - 1; $i++) {
	for ($j = 0; $j <= $i; $j++) {
		$materialData[$componentDataArr[$i]] = $matrialTypeValues[$j];
	}
}


$markingTableHeadings = [];
$markingTableWithSubHeadings = [];
$matrialTypeData = "";
foreach ($materialData as $key => $value) {

    array_push($markingTableHeadings, $key);
    $slicedValue = substr($value, 0, -4); 
    $matrialTypeData .= "<tr>";
    $matrialTypeData .= "<td><div style='font-weight: bold;'>" . $key . "</div></td>";
	$matrialTypeData .= "<td>&nbsp;" . $slicedValue . "&deg;C)</td>";
    $matrialTypeData .= "</tr>";
}


foreach ($markingTableHeadings as $headings) {
	$markingTableWithSubHeadings[$headings] = ['Heat Nr.', 'Certificate Nr.'];
	if ($headings === 'CONNECTOR') {
        $markingTableWithSubHeadings[$headings] = ['Heat Nr.', 'Heat Nr.', 'Certificate Nr.'];
    }else{
	    $markingTableWithSubHeadings[$headings] = ['Heat Nr.', 'Certificate Nr.'];
	}
}


$mtHeadings = "";
$mtHeadings .= "<tr>";
$mtHeadings .= "<th rowspan='2'>Serial. Nr.</th>";
$mtSubHeadings = [];

foreach ($markingTableWithSubHeadings as $key => $value) {
    if ($key === 'CONNECTOR') {
        $mtHeadings .= "<th colspan='3'>" . $key . "</th>";
    } else {
        $mtHeadings .= "<th colspan='2'>" . $key . "</th>";
    }
    $mtSubHeadings = array_merge($mtSubHeadings, $value);
}
$mtHeadings .= "</tr>";

$mtHeadings .= "<tr>";
foreach ($mtSubHeadings as $value) {
    $mtHeadings .= "<th>" . $value . "</th>";
}
$mtHeadings .= "</tr>";

$serialHeatRows25 = ''; 
$serialHeatRows = array(); 
$index = 0;

$mtcCertificates = array();
$chunks = array_chunk($markingData,35); // Split the $markingData into chunks of 45 rows
$counter = 0;
foreach ($chunks as $chunkIndex => $chunk) {
    if ($chunkIndex >= 1) {
        break; 
    }

    $chunkSerialHeatRows = ""; 
    foreach ($chunk as $mD) {
        if ($counter >= 35) {
            break; // Exit the loop after 45 iterations
        }
        $counter++;
        $chunkSerialHeatRows .= "<tr>";
        $chunkSerialHeatRows .= "<td>" . $mD["serial_no"] . "</td>";

        $heat_ = explode(",", $mD['heat']);
        $certificate_ = explode(",", $mD['certificate']);
        array_push($mtcCertificates, $certificate_);
        $columnContent = "";
        for ($i = 0; $i < count($markingTableHeadings); $i++) {
            $heatCell = isset($heat_[$i]) ? $heat_[$i] : "-";
            $certificateCell = isset($certificate_[$i]) ? $certificate_[$i] : "-";
            if ($markingTableHeadings[$i] == 'CONNECTOR') {
                $columnContent .= "<td>" . $heatCell . "</td>" . "<td>" . $heatCell . "</td>" . "<td>" . $certificateCell . "</td>";
            } else {
                $columnContent .= "<td>" . $heatCell . "</td>" . "<td>" . $certificateCell . "</td>";
            }
        }
        $chunkSerialHeatRows .= $columnContent;

        $chunkSerialHeatRows .= ("</tr>");

    }
    $serialHeatRows25 = $chunkSerialHeatRows; 
}





$index = 0;
$markingData = array_slice($markingData, 35);
$chunks = array_chunk($markingData, 75); // Split the $markingData into chunks of 75 rows
foreach ($chunks as $chunk) {
    $chunkSerialHeatRows = ""; // Create a new string for each chunk
    foreach ($chunk as $mD) {
            $chunkSerialHeatRows .= "<tr>";
            $chunkSerialHeatRows .= "<td>" . $mD["serial_no"] . "</td>";

            $heat_ = explode(",", $mD['heat']);
            $certificate_ = explode(",", $mD['certificate']);
            array_push($mtcCertificates, $certificate_);
            $columnContent = "";
            for ($i = 0; $i < count($markingTableHeadings); $i++) {
                $heatCell = isset($heat_[$i]) ? $heat_[$i] : "-";
                $certificateCell = isset($certificate_[$i]) ? $certificate_[$i] : "-";
                if ($markingTableHeadings[$i] == 'CONNECTOR') {
                    $columnContent .= "<td>" . $heatCell . "</td>" . "<td>" . $heatCell . "</td>" . "<td>" . $certificateCell . "</td>";
                } else {
                    $columnContent .= "<td>" . $heatCell . "</td>" . "<td>" . $certificateCell . "</td>";
                }
            }
            $chunkSerialHeatRows .= $columnContent;

            $chunkSerialHeatRows .= ("</tr>");
    }
    
    $serialHeatRows[] = $chunkSerialHeatRows; 
}



$mtcCertificates = array_unique(array_merge(...$mtcCertificates));


$mpdf = new \Mpdf\Mpdf([
	'mode' => 'c',
	'margin_left' => 10,
	'margin_right' => 10,
	'margin_top' => 10,
	'margin_bottom' => 20,
	'margin_header' => 10,
	'margin_footer' => 10,
	'default_charset' => 'UTF-8'
]);

$html = '';



foreach ($serialHeatRows as $chunkIndex => $chunkRows) {
    $html .= '<tr>
        <td width="100%">
            <div style="margin-top:10px;">
                <br/>
                <div style="font-weight: bold;">MARKING AND TRACEABILITY OF PRESSURE RETAINING PARTS</div>
                <div style="">Main Pressure-retaining parts. (cert. 3.1 enclosed)</div>

                <table width="100%" border="1" style="border-collapse: collapse; font-size: 8px; text-align: center; padding:5px; color: transparent;" cellspacing="2" cellpadding="2">
                    <thead style="border: 1px solid lightgray;">
                        ' . $mtHeadings . '
                    </thead>
                    <tbody style="border: 1px solid lightgray;">
                        ' .  $chunkRows . '
                    </tbody>
                </table>
            </div>
        </td>
    </tr>';
}







$QCcontent = '
<div style="font-family: sans-serif; font-size: 8px;">
<table width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size: 8px;">
	<tr>
		<td width="10%" align="center" style="border: 1px solid lightgray;">
			<img src="../Imagenes/logo_PDF.png" width="50px" />
		</td>
		<td width="80%" align="center" style="border: 1px solid lightgray; font-weight: bold; font-size: 25px">
			QUALITY CERTIFICATE
		</td>
		<td width="10%" style="border: 1px solid lightgray; text-align: center;">
			<p>
				PS07/F1
			</p>
			<p>
				F rev. ' . $revision . '
			</p>
		</td>
	</tr>
</table>
<div style="text-align: right; margin-top: 3px; color: #adb5bd">
	Sheet {PAGENO}/{nbpg}
</div>
</div>
	<table width="100%" style="font-family: sans-serif; font-size:10px;color:lightgray !important;">
		<tr>
			<td width ="100%">
				<table width="100%" style="vertical-align: middle; font-size: 8px;">
					<tr>
						<td width="25%">
							<div><strong>Purchaser:</strong> <span style="font-weight: normal">' . $purchaser . '</span></div>
							<div><strong>PO.nr: </strong><span style="font-weight: normal">' . $po_no . '</span></div>
						</td>
						<td width="25%">
							<div><strong>Date: </strong><span style="font-weight: normal">' . $issued_date . '</span></div>
							<div><strong>JC ref: </strong><span style="font-weight: normal">' . $jc_po_ref . '</span></div>
						</td>
						<td width="25%">
							<img src="img/logo1.png" width="25" style="margin: 3px">
		         			 <div style="background-color: #ffff00; "> 0056</div>
						</td>
						<td width="25%">
							<div><strong>Cert No: </strong><span style="font-weight: normal">' . $cert_n . '</span></div>
							<div><strong>issued: </strong><span style="font-weight: normal">' . $issued_date . '</span></div>
						</td>
					</tr>
				</table>
			
				<p>
					JC Fábrica de Válvulas S.A.U (JCFV S.A.U) CERTIFY that the manufacture of the valves and/or fittings mentioned, delivered on account of your referenced order, has been fulfilled according to the specifications indicated.
				</p>
			</td>
		</tr>

		<tr>
			<td width ="100%">
				<table width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size: 8px;">
					<tr>
						<td width="100%" style="border: 1px solid lightgray; font-weight: bold">
							PRODUCT DESCRIPTION
						</td>
					</tr>
					<tr>
						<td style="border: 1px solid lightgray;">
						 <table width="100%" style="font-size: 8px;">
							<tr>
							<td width="33%">
								<div class="d-flex">
								<p class="mb-1 me-2 fw-bold"><b>PRODUCT TYPE -</b>:    '.$productType.' </p>
								<p class="mb-1 me-2 fw-bold"><b>SIZE -</b>:    '.$size.'</p>
								<p class="mb-1 me-2 fw-bold"><b>BORE -</b>:  '.$bore.'</p>
								</div>
							</td>
							<td width="33%">
								<div class="d-flex">
								<p class="mb-1 me-2 fw-bold"><b>ENDS -:  </b>'. $ends .' </p>
								<p class="mb-1 me-2 fw-bold"><b>ARTICLE -:  </b>'. $article .' </p>
								<p class="mb-1 me-2 fw-bold"><b>MODEL -:  </b>'. $model .' </p>
								</div>
							</td>
							<td width="33%">
								<div class="d-flex">
								<p class="mb-1 me-2 fw-bold"><b>ITEM -:  </b>'. $item .' </p>
								<p class="mb-1 me-2 fw-bold"><b>QTY -:  </b>'. $qty .'</p>
								<p class="mb-1 me-2 fw-bold"><b>DESIGN STANDARD -:  </b>'. $designStandard .'</p>
								</div>
							</td>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	
		<tr>
			<td width ="100%">
				<table width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size: 8px; margin-top: 10px">
					<tr>
						<td width="100%" style="border: 1px solid lightgray; font-weight: bold">
							TYPE MATERIAL
						</td>
					</tr>
					<tr>
						<td width="100%" style="border: 1px solid lightgray;">
							<table style="font-size: 8px;">
							' . $matrialTypeData . '
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td width ="100%">
				<table width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size: 8px; margin-top: 10px">
					<tr>
						<td width="100%" style="border: 1px solid lightgray; font-weight: bold">
							TEST DESCRIPTION
						</td>
					</tr>
					<tr>
						<td width="100%" style="border: 1px solid lightgray;">

								<table width="100%" style="font-size: 8px;">
								<tr>
								<td width="33%">
									<div class="d-flex">
									<p class="mb-1 me-2 fw-bold"><b>Testing Std.:</b>:    '.$testingStd.' </p>
									<br>
									<p class="mb-1 me-2 fw-bold"><b>Hydraulic (barg):  </b> &nbsp; &nbsp; Shell  &nbsp; &nbsp; '. $hydraulicShell .'&nbsp; &nbsp; Seat  &nbsp; &nbsp; '.$hydraulicSeat.'</p>
									</div>
								</td>
								<td width="33%">
									<div class="d-flex">
									<p class="mb-1 me-2 fw-bold"><b>DIN.:</b>:    '.$designStandard.'</p>								
									</div>
								</td>
								<td width="33%">
									<div class="d-flex">
									<p class="mb-1 me-2 fw-bold"><b>JC Std.:</b>:  '.$jc_standard.'  &nbsp;&nbsp;&nbsp;&nbsp;<b>Others.:</b>:  '.$other.'</p>
									<br>
									<p class="mb-1 me-2 fw-bold"><b>Pneumatic (barg):  </b> &nbsp; &nbsp; Shell  &nbsp; &nbsp; '. $pneumaticShell .'&nbsp; &nbsp; Seat  &nbsp; &nbsp; '.$pneumaticSeat.'</p>
									</div>
								</td>
								</tr>
								<tr>
									<td>
										Test Results: Satisfactory, seats tightness as per leakage ISO 5208 Rate A for soft seats & Rate D for metal seats.
									</td>
									<td>
										Testing duration as per applicable standard.
									</td>
								</tr>
								</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
        <td width="100%">
            <div style="margin-top:10px;">
                <br/>
                <div style="font-weight: bold;">MARKING AND TRACEABILITY OF PRESSURE RETAINING PARTS</div>
                <div style="">Main Pressure-retaining parts. (cert. 3.1 enclosed)</div>

                <table width="100%" border="1" style="border-collapse: collapse; font-size: 8px; text-align: center; padding:5px; color: transparent;" cellspacing="2" cellpadding="2">
                    <thead style="border: 1px solid lightgray;">
                        ' . $mtHeadings . '
                    </thead>
                    <tbody style="border: 1px solid lightgray;">
                        ' .  $serialHeatRows25 . '
                    </tbody>
                </table>
            </div>
        </td>
    </tr>

		'.$html.'

		<tr>
			<td width ="100%">
				<table width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size: 8px; margin-top: 10px">
					<tr>
						<td width="100%" style="border: 1px solid lightgray; font-weight: bold">
							NOTES
						</td>
					</tr>
					<tr>
						<td width="100%" style="border: 1px solid lightgray;">
							<div>
								&nbsp;Fire Safe design tested acc. API 6FA, ISO 10497, API 607 / These supply materials are in accordance with NACE MR0175/ISO15156 & NACE MR0103/ISO17945 / Visual and control dimensional results satisfactory as per GAD / Marking according MSS SP-25.
							</div>
							<br/>
							<div style="font-weight: bold">&nbsp;EU DECLARATION OF CONFORMITY </div>
							<div style="font-weight: bold">&nbsp;JC FÁBRICA DE VÁLVULAS S.A.U DECLARES THAT: </div>
							<div>
								&nbsp;The referred ball valves, classified as pressure accessories, have been designed and manufactured in accordance with the requirements of the Pressure Equipment Directive 2014/68/EU and are in conformity with national implementing legislation.
							</div>
							<div>
		             &nbsp;This declaration of conformity is issued under the sole responsibility of the manufacturer.
		          </div>
							<br/>

		          <div style="font-weight: bold">
		             &nbsp;NOTIFIED BODY WHICH CARRIED OUT THE INSPECTION:
		          </div>
		          <div>
		             &nbsp;BUREAU VERITAS INSPECCIÓN Y TESTING, S.L. (Notified Body nr <b>0056</b>)
		          </div>
		          <div>
		             &nbsp;Camí de Ca n’Ametller, 34, 08195 Sant Cugat del Vallés – Barcelona – Spain
		          </div>
		          <div>
		             &nbsp;Reference number of the Certificate of Quality System Approval <b>CE-0056-PED-H1-JCV 001-20-ESP</b>
		          </div>
		          <div style="font-weight: bold">
		            &nbsp;For Category I Notified Body is not required.
		          </div>
		          <br/>

		          <div style="font-weight: bold">
		            &nbsp;ASSESMENT OF CONFORMITY PROCEDURE FOLLOWED
		          </div>
		          <div>
		             &nbsp;MODULE H1 of ANNEX III of DIRECTIVE 2014/68/EU
		          </div>
		          <div style="font-weight: bold">
		            &nbsp;CE marking must not be affixed for SEP equipment.
		          </div>
		          <br/>

		          <div style="font-weight: bold">
		            &nbsp;The object of the declaration described above is in conformity with the relevant Union harmonization legislation:
		          </div>
		          <div>
		            &nbsp;Basics standards apply EN 12266-1:2012, API 598 ed.10, EN ISO 17292:2015, ASME B16.34-2017, ASME B16.10-2017, ASME B16.5-2020, ASME B16.25-2017, EN 558-2017, API 6D ed.24, API 600 ed.13, API 6FA ed.4, ISO 10497:2010, API 607 ed.7, EN 1983:2013, ISO 5211:2017. For specific standards of each figure type, please see JC datasheets.
		          </div>

		          <div>
		            &nbsp;Other DIRECTIVES that apply to this product: ATEX 2014/34/EU classification Group II Cat 2,  for use in explosive atmospheres, zones 1, 2 and 21, 22. Evaluation of compliance according to appendix VIII. Marked <img src="img/mark1.png" width="60"> LCIE 05 AR 023. According UNE EN ISO 80079-36:2017, EN 1127-1:2012.
		          </div>
		          <br/>

		          <div>
		            &nbsp; NOTE: When the JC Ball valve assemble accessories which require submittal to other Directives they will be labelled with CE mark and to the Declaration of Conformity of JC will be joined the declaration of Conformity of manufacturer of accessory.
		          </div>
		          <br/>

		          <table width="100%">
		          	<tr>
			            <td width="30%">
			              <div style="font-weight: bold">Sant Boi (Barcelona) Spain</div>
			              <div style="font-weight: bold">Cesar Abarca</div>
			              <div style="font-weight: bold">CEO of Organization</div>
			            </td>
			            <td width="70%">
			              <img src="./img/sign1.png" width="200px">
			            </td>
		            </tr>
		          </table>
				    </td>
				</tr>
				</table>
			</td>
		</tr>

	</table>
	<div style="font-family: sans-serif; font-size: 8px;">
<table width="100%" style="vertical-align: bottom; font-size: 8px;">
	<tr>
		<td width="15%"></td>
		<td width="36%">
			<div>JC Fabrica de Valvulas S.A.U.</div>
		</td>
		<td width="19%"></td>
		<td width="15%"></td>
		<td width="15%"></td>
	</tr>
	<tr>
		<td width="15%"></td>
		<td width="36%" style="color: #adb5bd;">
			<div>Av. Segle XXl, 75 - Pol. Ind. Can Calderon</div>
			<div>08830 Sant del Llobregal - Barcelona (Spain)</div>
		</td>
		<td width="19%" style="border-left: 1px solid #d63384; padding-left: 5px; color: #adb5bd">
			<div>T. +34 936 548 686</div>
			<div>F. +34 936 548 687</div>
		</td>
		<td width="15%" style="border-left: 1px solid #d63384; padding-left: 5px; color: #adb5bd">
			<div>jc@jc-valves.com</div>
			<div>www.jc-valves.com</div>
		</td>
		<td width="15%"></td>
	</tr>
</table>
<div style="text-align: right; margin-top: 3px; color: #adb5bd">
	Sheet {PAGENO}/{nbpg}
</div>
</div>
	';

$mtcCertificates = array_values($mtcCertificates);	
//MTC Certificates
$MCcontent = null;
if(isset($mtcCertificates )){
	for($i=0; $i<=count($mtcCertificates)-1; $i++){
		$MCcontent .=  mtcCertificates($mtcCertificates[$i],$con);
	}
}


$mpdf->WriteHTML($QCcontent);

if($MCcontent){
	$mpdf->AddPage();
    $mpdf->WriteHTML($MCcontent);
}


$mpdf->Output($serialData['cert_n'].'.pdf', 'D');


?>