<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $task_id = $_POST["task_id"];
        $sub_task_id = $_POST["subtaskId"];
        $is_deleted = '1';

        $subTaskUpdateSql = "UPDATE sub_tasks SET is_deleted = '$is_deleted' WHERE id = '$sub_task_id'";
        $subTaskUpdateSqlResult = mysqli_query($con, $subTaskUpdateSql);
        $listSqlData = "SELECT * FROM sub_tasks WHERE is_deleted = 0 AND task_id = '$task_id'";
        $listData = mysqli_query($con, $listSqlData);
        $lists =  array();
        while ($row = mysqli_fetch_assoc($listData)) {
            array_push($lists, $row);
        }
        if ($lists && count($lists) > 0) {
            foreach ($lists as $key => $list) {
                echo '<tr>
                <td>' . $list['title'] . '</td>
                <td>' . date("d-m-y", strtotime($list['date']))  . '</td>
                <td>';
                $consulta = "SELECT * FROM Basic_Employee";
                $consulta_general = mysqli_query($con, $consulta);
                while ($result_data = mysqli_fetch_assoc($consulta_general)) {
                    if ($result_data['Id_employee'] ==  $list['responsible']) {
                        echo $result_data['First_Name'] . ' ' . $result_data['Last_Name'];
                    }
                }
                echo '</td>';
                echo '</td>';
                echo '<td>';
                if ($list['status'] == '1') {
                    echo '<input class="form-control task-status" type="hidden" name="subtask_status"
                    value="1" required>
                <a class="badge badge-light-success cursor-pointer"
                    data-id="' . $list['id'] . '" onclick="changeStatus(this)">Open</a>';
                } else {
                    echo '<input class="form-control task-status" type="hidden" name="subtask_status"
                    value="0" required>
                <a class="badge badge-light-danger cursor-pointer"
                    data-id="' . $list['id'] . '" onclick="changeStatus(this)">Closed</a>';
                }
                echo '</td>';
                echo '<td class="list-row" style="vertical-align:middle">
                <a class="list-edit cursor-pointer me-2" data-id="' . $list['id'] . '"><i
                                                class="bi bi-pencil"></i></a>
                    <a class="list-remove cursor-pointer" data-id="' . $list['id'] . '"><i class="bi bi-trash"></i></a>
                </td>
            </tr>';
            }
        }
        echo false;
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}
