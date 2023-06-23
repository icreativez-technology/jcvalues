<?php
session_start();
include('includes/functions.php');
$productTypeId = $_POST["type"];
$qty = $_POST["qty"];
$mode = "";
if (isset($_POST["mode"])) {
    $mode =  $_POST["mode"];
}
$markingArr = array();
if (isset($_POST["markingArr"])) {
    //print_r($_POST["markingArr"]);
    $markingArr = $_POST["markingArr"];
    // natsort($markingArr);
}

$componentArr = array();
if (isset($_POST["component"])) {
    $componentArr = $_POST["component"];
}

$sql = "";
if ($productTypeId == "") {
    $sql = "SELECT components.id, components.component FROM components WHERE components.is_deleted = '0' AND components.status ='1'";
} else {
    $sql = "SELECT components.id, components.component FROM product_type_component LEFT JOIN components ON components.id = product_type_component.component_id  where product_type_component.product_type_id = '$productTypeId' AND components.is_deleted = '0' AND components.status ='1'";
}
$connect_data = mysqli_query($con, $sql);
$components =  array();
while ($row = mysqli_fetch_assoc($connect_data)) {
    array_push($components, $row);
}

function getElement($arr, $componentId, $property)
{
    $result = "";
    foreach ($arr['component'] as $item) {
        if ($item['component_id'] == $componentId) {
            $result = $item[$property];
        }
    }
    return $result;
}

?>
<?php if (count($componentArr) > 0) { ?>
<table class="table align-middle table-row-dashed fs-6" data-cols-width="20,20,20, 20, 20, 20, 10, 10">
    <thead>
        <tr class="text-start text-gray-400 text-uppercase gs-0 gy-3" data-height="30">
            <th class="w-250px text-center" rowspan="2"> Serial Nr.</th>
            <?php foreach ($components as $component) {
                    if (in_array(intval($component['id']), $componentArr)) {
                ?>
            <th class="w-200px text-center" rowspan="1" colspan="2"><?php echo $component['component'] ?></th>
            <?php }
                } ?>
        </tr>
        <tr>
            <?php foreach ($components as $component) {
                    if (in_array(intval($component['id']), $componentArr)) {
                ?>
            <th class="w-200px text-center" rowspan="1" colspan="1">Heat</th>
            <th class="w-200px text-center" rowspan="1" colspan="1">Cert</th>
            <?php }
                } ?>
        </tr>
    </thead>
    <tbody class="fw-bold text-gray-600">
        <?php for ($i = 0; $i < $qty; $i++) { ?>
        <tr>
            <td class="custom-input">
                <input class="form-control text-uppercase serial"  <?php echo $mode === "view" ? "disabled" : "" ?>
                    value="<?php echo count($markingArr) > 0 ? isset($markingArr[$i]) ? $markingArr[$i]['serial_no'] : "" : "" ?>"
                    required />
            </td>
            <?php foreach ($components as $component) {
                        if (in_array(intval($component['id']), $componentArr)) {
                    ?>
            <td class="custom-input">
                <input class="form-control text-uppercase heat"   <?php echo $mode === "view" ? "disabled" : "" ?> id="<?php echo $component['id'] ?>"
                    value="<?php echo (count($markingArr) > 0) ? isset($markingArr[$i]) ? getElement($markingArr[$i], $component['id'], 'heat_no') : "" : "" ?>"
                    required />
            </td>
            <td class="custom-input">
                <input class="form-control text-uppercase certificate"  <?php echo $mode === "view" ? "disabled" : "" ?>
                    value="<?php echo (count($markingArr) > 0) ? isset($markingArr[$i]) ? getElement($markingArr[$i], $component['id'], 'certificate_no') : "" : "" ?>"
                    required />
            </td>
            <?php
                        }
                    } ?>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>