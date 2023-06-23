<?php

require_once "includes/functions.php";

$consulta = " SELECT * FROM Basic_Product_Group LIMIT 0";
$termino = "";

if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta = "SELECT Basic_Customer.*,  tbl_Countries.CountryName FROM Basic_Customer LEFT JOIN tbl_Countries ON Basic_Customer.Country_of_Origin = tbl_Countries.CountryID WHERE Basic_Customer.Customer_Name LIKE '%" . $termino . "%' OR Basic_Customer.Status LIKE '%" . $termino . "%' OR Basic_Customer.Primary_Contact_Person LIKE '%" . $termino . "%' OR Basic_Customer.Email LIKE '%" . $termino . "%'  OR Basic_Customer.Customer_Id LIKE '%" . $termino . "%' order by Basic_Customer.Id_customer DESC";
}

$consultaBD = mysqli_query($con, $consulta);


if ($consultaBD && strlen($termino) > 0) {
	echo '
			<div class="card-body pt-0 table-responsive">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_Product Groups_table">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-gray-400 text-uppercase gs-0">
												<th class="min-w-25px">Customer ID</th>
												<th class="min-w-25px">Customer Name</th>
												<th class="min-w-25px">Location</th>
												<th class="min-w-25px">Primary Contact</th>
												<th class="min-w-25px">Email</th>
												<th class="min-w-25px">Parent Company</th>
												<th class="min-w-25px">Status</th>
												<th class="text-end min-w-100px">Actions</th>
											</tr>
											<!--end::Table row-->
										</thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'>
						<tr>";

		echo "<td>";
		echo $result_data['Customer_Id'];
		echo "</td>";

		echo "<td>";
		echo $result_data['Customer_Name'];
		echo "</td>";

		echo "<td>";
		echo $result_data['CountryName'];
		echo "</td>";

		echo "<td>";
		echo "· " . $result_data['Primary_Contact_Person'];
		echo "</td>";

		echo "<td>";
		echo $result_data['Email'];
		echo "</td>";

		echo "<td>";
		echo $result_data['Parent_Company'];
		echo "</td>";

		if ($result_data['Status'] == 'Active') {
			echo '<td><a href="/includes/basicsettings_customers_status.php?pg_id=' . $result_data['Id_customer'] . '"><div class="status-active">Active</div></a></td>';
		} else {
			echo '<td><a href="/includes/basicsettings_customers_status.php?pg_id=' . $result_data['Id_customer'] . '"><div class="status-danger">Suspended</div></a></td>';
		}

		echo '<td class="text-end"><a href="/admin_customers-edit.php?pg_id=' . $result_data['Id_customer'] . '"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a> ';
		echo '<a href="/admin_customers-edit.php?pg_id=' . $result_data['Id_customer'] . '&view"><i class="fa fa-eye" aria-hidden="true"></i></a>
		<a href="/admin_customers-delete.php?pg_id=' . $result_data['Id_customer'] . '"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
		</td>';
		echo "

						</tr>
				</tbody>
			";
	}
	echo "</table>
		</div>
		</div>";
}
