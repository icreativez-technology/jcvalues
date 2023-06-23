<?php
session_start();
include('includes/functions.php');
switch ($_REQUEST['role']) {
    case '1':
        $role = 'Super Administrator';
        $disabled = true;
        break;
    case '2':
        $role = 'Administrator';
        $disabled = false;
        break;
    case '3':
        $role = 'Employee';
        $disabled = false;
        break;
}
?>
<style>
    .check-size {
        width: 1.25rem !important;
        height: 1.25rem !important;
    }

    #role_edit_form {
        height: 100% !important;
    }
</style>
<form class="form" id="role_edit_form" action="includes/role_permission_update.php" method="post" enctype="multipart/form-data">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header right-modal">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Permissions - <?php echo $role; ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow-y: auto">
                <div class="card-body pt-0 table-responsive">
                    <table class="table table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
                        <thead>
                            <tr class="text-gray-400 text-uppercase gs-0" data-height="30">
                                <th class="text-start min-w-400px">
                                    Module
                                </th>
                                <th class="text-center min-w-200px">
                                    View
                                </th>
                                <th class="text-center min-w-200px">
                                    Edit
                                </th>
                                <th class="text-center min-w-200px">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            <?php
                            $sql_data = "SELECT modules.*, permissions.can_view, permissions.can_edit, permissions.can_delete FROM modules LEFT JOIN permissions ON permissions.module_id = modules.id where role_id = '$_REQUEST[role]'";
                            $connect_data = mysqli_query($con, $sql_data);
                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $result_data['module']; ?>
                                        <input type="hidden" class="form-control" name="module_ids[]" value="<?php echo $result_data['id']; ?>">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input check-size check-view" type="checkbox" name="can_view[]" value="<?php echo $result_data['id']; ?>" <?php echo $result_data['can_view'] == "1" ? "checked" : ""; ?> <?php echo $disabled ? 'disabled' : '' ?>>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input check-size check-edit" type="checkbox" name="can_edit[]" value="<?php echo $result_data['id']; ?>" <?php echo $result_data['can_edit'] == "1" ? "checked" : ""; ?> <?php echo $disabled ? 'disabled' : '' ?>>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input check-size check-delete" type="checkbox" name="can_delete[]" value="<?php echo $result_data['id']; ?>" <?php echo $result_data['can_delete'] == "1" ? "checked" : ""; ?> <?php echo $disabled ? 'disabled' : '' ?>>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <?php if (!$disabled) { ?>
                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                <?php } ?>
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <input type="hidden" class="form-control" name="role_id" value="<?php echo $_REQUEST['role']; ?>">
</form>

<script>
    $('.check-delete').on('click', function() {
        var check = $(this)[0].checked;
        if (check) {
            $(this).closest('tr').find('.check-size').prop('checked', true);
        } else {
            $(this).closest('tr').find('.check-edit').prop('checked', false);
        }
    })
    $('.check-edit').on('click', function() {
        var check = $(this)[0].checked;
        if (check) {
            $(this).closest('tr').find('.check-view').prop('checked', true);
        } else {
            $(this).closest('tr').find('.check-delete').prop('checked', false);
        }
    })
    $('.check-view').on('click', function() {
        var check = $(this)[0].checked;
        if (!check) {
            $(this).closest('tr').find('.check-size').prop('checked', false);
        }
    })
</script>