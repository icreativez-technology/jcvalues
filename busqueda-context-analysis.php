<?php
require_once "includes/functions.php";
$consulta = "SELECT context_analysis.*, created.First_Name, created.Last_Name, approved.First_Name, approved.Last_Name FROM context_analysis 
LEFT JOIN Basic_Employee as created ON context_analysis.created_by = created.Id_employee
LEFT JOIN Basic_Employee as approved ON context_analysis.approved_by = approved.Id_employee 
WHERE is_deleted = 0 order by year DESC";
$termino = "";
if (isset($_POST['productos'])) {
    $termino = mysqli_real_escape_string($con, $_POST['productos']);
    $consulta = "SELECT context_analysis.*, created.First_Name, created.Last_Name, approved.First_Name, approved.Last_Name FROM context_analysis 
    LEFT JOIN Basic_Employee as created ON context_analysis.created_by = created.Id_employee
    LEFT JOIN Basic_Employee as approved ON context_analysis.approved_by = approved.Id_employee 
    WHERE is_deleted = 0 AND year LIKE '%" . $termino . "%' order by year DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
    echo '
    <div class="card-body pt-0 table-responsive">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <!--begin::Table head-->
        <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 text-uppercase gs-0">
                <th class="min-w-100px">Year</th>
                <th class="min-w-100px">Revision</th>
                <!--<th class="min-w-100px">Created Date</th> -->
                <th class="min-w-100px">Revision Date</th>
                <th class="min-w-160px">Created By</th>
                <th class="min-w-160px">Approved By</th>
                <th class="min-w-100px">Action</th>
            </tr>
            <!--end::Table row-->
        </thead>';
    while ($result_data = mysqli_fetch_assoc($consultaBD)) {
        echo "<tbody class='fw-bold text-gray-600'>
						<tr>
							<td>";
        echo $result_data['year'];
        echo "	</td>
							<td>";
        echo $result_data['revision'];
        // echo "</td> <td>";
        // echo date("d-m-y", strtotime($result_data['created_at']));
        echo "</td> <td>";
        echo date("d-m-y", strtotime($result_data['created_at']));
        echo "</td>";
        $sql = "SELECT * From Basic_Employee Where Id_employee = $result_data[created_by]";
        $fetch = mysqli_query($con, $sql);
        $createdInfo = mysqli_fetch_assoc($fetch);
        echo "<td>";
        echo $createdInfo['First_Name'] . ' ' . $createdInfo['Last_Name'];
        echo "</td>";
        $sql = "SELECT * From Basic_Employee Where Id_employee = $result_data[approved_by]";
        $fetch = mysqli_query($con, $sql);
        $approvedInfo = mysqli_fetch_assoc($fetch);
        echo "<td>";
        echo $approvedInfo['First_Name'] . ' ' . $approvedInfo['Last_Name'];
        echo "</td>";
        echo '<td><a href="/context-analysis-view.php?id=' . $result_data['id'] . '"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;';
        ?>
        <a data-id='<?php echo $result_data['id']; ?>' data-year='<?php echo $result_data['year']; ?>' data-revision='<?php echo $result_data['revision']; ?>' target="_blank" class="print-interested-parties me-3 cursor-pointer"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>
        <?php

        echo "</td>
						</tr>
				</tbody>
			";
    }
    echo "</table>
		</div>
		</div>";
}