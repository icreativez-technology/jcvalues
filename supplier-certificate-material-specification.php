<?php
require_once "includes/functions.php";
if (isset($_POST['id'])) {
    $heatSql = "SELECT * FROM heat_treatments WHERE material_specification_id = $_REQUEST[id]";
    $heatSqlConnectData = mysqli_query($con, $heatSql);
    $heat = mysqli_fetch_assoc($heatSqlConnectData);
    if (!isset($heat['heat_treatment'])) {
        $heat['heat_treatment'] = "-";
        $heat['id'] = null;
    }
    $tensileSql = "SELECT * FROM material_specification_tensile_test WHERE material_specification_id = $_REQUEST[id]";
    $tensileSqlConnectData = mysqli_query($con, $tensileSql);
    $tensile = mysqli_fetch_assoc($tensileSqlConnectData);
    $tensile['tensile_strength_min'] = ($tensile['tensile_strength_min']) ? $tensile['tensile_strength_min'] : '-';
    $tensile['tensile_strength_max'] = ($tensile['tensile_strength_max']) ? $tensile['tensile_strength_max'] : '-';
    $tensile['yield_strength_min'] = ($tensile['yield_strength_min']) ? $tensile['yield_strength_min'] : '-';
    $tensile['yield_strength_max'] = ($tensile['yield_strength_max']) ? $tensile['yield_strength_max'] : '-';
    $tensile['elongation_min'] = ($tensile['elongation_min']) ? $tensile['elongation_min'] : '-';
    $tensile['elongation_max'] = ($tensile['elongation_max']) ? $tensile['elongation_max'] : '-';
    $tensile['reduction_area_min'] = ($tensile['reduction_area_min']) ? $tensile['reduction_area_min'] : '-';
    $tensile['reduction_area_max'] = ($tensile['reduction_area_max']) ? $tensile['reduction_area_max'] : '-';
    $required = $tensile['reduction_area_max'] != "-" || $tensile['reduction_area_min'] != "-" ? "required" : "";

    $hardnessSql = "SELECT * FROM material_specification_hardness_test WHERE material_specification_id = $_REQUEST[id]";
    $hardnessSqlConnectData = mysqli_query($con, $hardnessSql);
    $hardness = mysqli_fetch_assoc($hardnessSqlConnectData);
    $hardness['hardness_mu'] = ($hardness['hardness_mu']) ? $hardness['hardness_mu'] : '-';
    $hardness['hardness_test_limit_min'] = ($hardness['hardness_test_limit_min']) ? $hardness['hardness_test_limit_min'] : '-';
    $hardness['hardness_test_limit_max'] = ($hardness['hardness_test_limit_max']) ? $hardness['hardness_test_limit_max'] : '-';

    $impactSql = "SELECT * FROM material_specification_impact_test WHERE material_specification_id = $_REQUEST[id]";
    $impactSqlConnectData = mysqli_query($con, $impactSql);
    $impact = mysqli_fetch_assoc($impactSqlConnectData);
    $impact['impact_test_temperature'] = ($impact['impact_test_temperature']) ? $impact['impact_test_temperature'] : '-';
    $impact['impact_test_limit_min'] = ($impact['impact_test_limit_min']) ? $impact['impact_test_limit_min'] : '-';
    $impact['impact_test_limit_max'] = ($impact['impact_test_limit_max']) ? $impact['impact_test_limit_max'] : '-';

    $chemicalInfoSql = "SELECT material_specification_chemicals.*, chemicals.parameter FROM material_specification_chemicals LEFT JOIN chemicals ON material_specification_chemicals.chemical_id=chemicals.id WHERE material_specification_id = $_REQUEST[id] AND material_specification_chemicals.status = 1";
    $chemicalInfoSqlConnectData = mysqli_query($con, $chemicalInfoSql);
    $chemicalInfo = array();
    while ($row = mysqli_fetch_assoc($chemicalInfoSqlConnectData)) {
        array_push($chemicalInfo, $row);
    }   
}

echo '
<div class="tab-pane fade show active" id="chemical" role="tabpanel" aria-labelledby="chemical-tab">
    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered table-chemical">
                <thead>
                    <tr>
                        <tr>
                            <th scope="col" rowspan="2">PARAMETER</th>
                            <th scope="col" rowspan="2">ACTUAL</th>
                            <th scope="colgroup" colspan="2">STANDARD</th>
                        </tr>
                        <tr>
                            <th scope="col">MIN</th>
                            <th scope="col">MAX</th>
                        </tr>
                    </tr>
                </thead>
                <tbody>';
if ($chemicalInfo != null) {
    foreach ($chemicalInfo as $key => $chemical) {
        $min = ($chemicalInfo[$key]['min_value'] != null) ? $chemicalInfo[$key]['min_value'] : '-';
        $max = ($chemicalInfo[$key]['max_value'] != null) ? $chemicalInfo[$key]['max_value'] : '-';
        echo '<tr scope="row"><td scope="col">' . $chemicalInfo[$key]['parameter'] . '</td>
        <td class="actual_td" scope="col">
            <div>
                <input type="hidden" class="form-control" name="chemical_id[]" value="' . $chemicalInfo[$key]['chemical_id'] . '">
                <input type="number" step="any" required onKeyUp="validateActual(' . $key . ')" class="form-control chem-input" id="actual_chemical_' . $key . '" name="actual_chemical[]" value="">
            </div>
        </td>
        <td class="std-td" scope="col" id="min_chemical_' . $key . '">' . $min . '</td>
        <td class="std-td" scope="col" id="max_chemical_' . $key . '">' . $max . '</td></tr>';
    }
} else {
    echo '<tr scope="row"><td scope="col" colspan="4"><center><div class="text-danger">Material specification does not have chemical value</div></center></td></tr>';
}
echo '</tbody>
            </table>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="mechanical" role="tabpanel" aria-labelledby="mechanical-tab">
    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered table-chemical">
                <thead>
                    <tr>
                        <tr>
                            <th scope="col" rowspan="2" colspan="4">PARAMETER</th>
                            <th scope="col" rowspan="2">ACTUAL</th>
                            <th scope="colgroup" colspan="2">STANDARD</th>
                        </tr>
                        <tr>
                            <th scope="col">MIN</th>
                            <th scope="col">MAX</th>
                        </tr>
                    </tr>
                </thead>
                <tbody>
                    <tr class="header-tr">
                        <td colspan="7">
                            <label>TENSILE TEST</label>
                        </td>
                    </tr>
                    <tr scope="row">
                        <td scope="col" colspan="4">Tensile Strength (UTS)(Mpa)</td>
                        <td class="actual_td" scope="col">
                            <div><input type="number" required step="any" class="form-control" name="actual_tensile_strength" id="actual_tensile_strength"  onKeyUp="validateActualTensile(`tensile_strength`)"></div>
                        </td>
                        <td class="std-td" scope="col" id="min_tensile_strength">' . $tensile['tensile_strength_min'] . '</td>
                        <td class="std-td" scope="col" id="max_tensile_strength">' . $tensile['tensile_strength_max'] . '</td>
                    </tr>
                    <tr scope="row">
                        <td scope="col" colspan="4">Yield Strength (YS)(Mpa)</td>
                        <td class="actual_td" scope="col">
                            <div><input type="number" required step="any" class="form-control" name="actual_yield_strength" id="actual_yield_strength" onKeyUp="validateActualTensile(`yield_strength`)"></div>
                        </td>
                        <td class="std-td" scope="col" id="min_yield_strength">' . $tensile['yield_strength_min'] . '</td>
                        <td class="std-td" scope="col" id="max_yield_strength">' . $tensile['yield_strength_max'] . '</td>
                    </tr>
                    <tr scope="row">
                        <td scope="col" colspan="4">Elongation (E)(%)</td>
                        <td class="actual_td" scope="col">
                            <div><input type="number" required step="any" class="form-control" name="actual_elongation" id="actual_elongation" onKeyUp="validateActualTensile(`elongation`)"></div>
                        </td>
                        <td class="std-td" scope="col" id="min_elongation">' . $tensile['elongation_min'] . '</td>
                        <td class="std-td" scope="col" id="max_elongation">' . $tensile['elongation_max'] . '</td>
                    </tr>
                    <tr scope="row">
                        <td scope="col" colspan="4">Reduction Area (RA)(%)</td>
                        <td class="actual_td" scope="col">
                            <div><input type="number" '.$required.' step="any" class="form-control" name="actual_reduction_area" id="actual_reduction_area" onKeyUp="validateActualTensile(`reduction_area`)"></div>
                        </td>
                        <td class="std-td" scope="col" id="min_reduction_area">' . $tensile['reduction_area_min'] . '</td>
                        <td class="std-td" scope="col" id="max_reduction_area">' . $tensile['reduction_area_max'] . '</td>
                    </tr>
                    <tr class="header-tr">
                        <td colspan="7">
                            <label>HARDNESS TEST SETS</label>
                        </td>
                    </tr>
                    <tr scope="row">
                        <td scope="col" style="width:30%" colspan="4">Hardness M.U.</td>
                        <td  colspan="3" scope="col" >' . $hardness['hardness_mu'] . '</td>
                    </tr>
                    <tr scope="row">
                    <td colspan="1" scope="col">Limit</td>
                    <td scope="col" colspan="1"><input type="number" id="hardness_result_1" name="hardness_result_1" required step="any" class="form-control" placeholder="Result 1" onKeyUp="validateAverage(`hardness_result`, `hardness_test_limit`, `1`)"></td>
                    <td scope="col" colspan="1"><input type="number" id="hardness_result_2" name="hardness_result_2" required step="any" class="form-control"  placeholder="Result 2" onKeyUp="validateAverage(`hardness_result`, `hardness_test_limit`, `2`)"></td>
                    <td scope="col" colspan="1"><input type="number" id="hardness_result_3" name="hardness_result_3" required step="any" class="form-control" placeholder="Result 3" onKeyUp="validateAverage(`hardness_result`, `hardness_test_limit`, `3`)"></td>
                    <td class="actual_td" scope="col">
                    <div class="ver-disabled">
                        <input type="number" step="any" class="form-control" name="actual_hardness_test_limit" id="actual_hardness_test_limit">
                    </div>
                    </td>
                    <td class="std-td" scope="col" id="min_hardness_test_limit">' . $hardness['hardness_test_limit_min'] . '</td>
                    <td class="std-td" scope="col" id="max_hardness_test_limit">' . $hardness['hardness_test_limit_max'] . '</td>
                    </tr>';
if ($impact['status']) {
    echo '<tr class="header-tr">
                        <td colspan="7">
                            <label>IMPACT TEST SETS</label>
                        </td>
                    </tr>
                    <tr scope="row">
                        <td scope="col" colspan="4">Temperature</td>
                        <td colspan="3" scope="col" >' . $impact['impact_test_temperature'] . '</td>
                    </tr>
                    <tr scope="row">
                        <td scope="col" colspan="1" >Limit</td>
                        <td scope="col" colspan="1"><input type="number" id="impact_result_1" name="impact_result_1" step="any" class="form-control" placeholder="Result 1" onKeyUp="validateAverage(`impact_result`, `impact_test_limit`, `1`)"></td>
                        <td scope="col" colspan="1"><input type="number" id="impact_result_2" name="impact_result_2" step="any" class="form-control" placeholder="Result 2" onKeyUp="validateAverage(`impact_result`, `impact_test_limit`, `2`)"></td>
                        <td scope="col" colspan="1"><input type="number" id="impact_result_3" name="impact_result_3" step="any" class="form-control" placeholder="Result 3" onKeyUp="validateAverage(`impact_result`, `impact_test_limit`, `3`)"></td>
                        <td class="actual_td" colspan="1" scope="col">
                        <div class="form-group ver-disabled"">
                            <input type="number" step="any" class="form-control" name="actual_impact_test_limit" id="actual_impact_test_limit">
                        </div>
                    </td>
                    <td class="std-td" scope="col" id="min_impact_test_limit">' . $impact['impact_test_limit_min'] . '</td>
                    <td class="std-td" scope="col" id="max_impact_test_limit">' . $impact['impact_test_limit_max'] . '</td>
                    </tr>';
}
echo '</tbody>
            </table>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="heat-treatment" role="tabpanel" aria-labelledby="heat-treatment-tab">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Heat Treatment</label>
                <input type="text" class="form-control" disabled value="' . $heat['heat_treatment'] . '">
                <input type="hidden" class="form-control" name="heat_treatment_id" value="' . $heat['id'] . '">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Notes*</label>
                <input type="text" class="form-control" required name="heat_notes">
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-3">
            <div class="form-group">
                <label>Melting Process</label>
                <input type="text" class="form-control" name="melting_process">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Other Specs Agreed</label>
                <input type="text" class="form-control" required name="other_specs_agreed">
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="special-test" role="tabpanel" aria-labelledby="special-test-tab">
    <div class="row special-test-elem special-test-newelem">
        <div class="col-md-4">
            <div class="form-group">
                <label>Type of Test</label>
                <input type="text" name="type_of_test[]" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Result</label>
                <input type="text" name="result[]" class="form-control">
            </div>
        </div>
        <div class="col-md-2 p-6 mt-5 special-test-actions">
            <a class="add-item special-test-append"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</div>
<input type="hidden" class="form-control" name="impact_status" value="' . $impact['status'] . '">
';
