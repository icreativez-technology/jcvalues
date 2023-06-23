<?php
include('includes/functions.php');
$consulta =  "SELECT customer_complaints.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Customer_Nature_of_Complaints.Title, Basic_Customer.Customer_Name FROM customer_complaints 
LEFT JOIN Basic_Employee ON customer_complaints.created_by = Basic_Employee.Id_employee
LEFT JOIN Customer_Nature_of_Complaints ON customer_complaints.nature_of_complaint_id = Customer_Nature_of_Complaints.Id_customer_nature_of_complaints
LEFT JOIN Basic_Customer ON customer_complaints.customer_id = Basic_Customer.Id_customer
WHERE customer_complaints.is_deleted = 0 order by created_at DESC";
$termino = "";
if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$consulta =  "SELECT customer_complaints.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Customer_Nature_of_Complaints.Title, Basic_Customer.Customer_Name FROM customer_complaints 
	LEFT JOIN Basic_Employee ON customer_complaints.created_by = Basic_Employee.Id_employee
	LEFT JOIN Customer_Nature_of_Complaints ON customer_complaints.nature_of_complaint_id = Customer_Nature_of_Complaints.Id_customer_nature_of_complaints
	LEFT JOIN Basic_Customer ON customer_complaints.customer_id = Basic_Customer.Id_customer
	WHERE customer_complaints.is_deleted = 0
	AND complaint_id LIKE '%" . $termino . "%' OR Basic_Employee.First_Name LIKE '%" . $termino . "%' OR Basic_Employee.Last_Name LIKE '%" . $termino . "%' OR customer_order_ref LIKE '%" . $termino . "%' OR Basic_Customer.Customer_Name LIKE '%" . $termino . "%' OR Customer_Nature_of_Complaints.Title LIKE '%" . $termino . "%' OR customer_complaints.status LIKE '%" . $termino . "%' order by id DESC";
}
$consultaBD = mysqli_query($con, $consulta);
if ($consultaBD && strlen($termino) > 0) {
	echo '<div class="card-body pt-0 table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_department_table">
        <thead>
            <tr class="text-start text-gray-400 text-uppercase gs-0">
				<th class="min-w-100px">Unique Id</th>
				<th class="min-w-100px">Created By</th>
				<th class="min-w-100px">Customer Name</th>
				<th class="min-w-100px">Order Ref No</th>
				<th class="min-w-100px">Nature of Complaint</th>
				<th class="min-w-100px">Status</th>
				<th class="min-w-100px">Action</th>
            </tr>
        </thead>';
	while ($result_data = mysqli_fetch_assoc($consultaBD)) {
		echo "<tbody class='fw-bold text-gray-600'><tr>";
		echo "<td>";
		echo $result_data['complaint_id'];
		echo "</td><td>";
		echo $result_data['First_Name'] . ' ' . $result_data['Last_Name'];
		echo "</td><td>";
		echo $result_data['Customer_Name'];
		echo "</td><td>";
		echo $result_data['customer_order_ref'];
		echo "</td><td>";
		echo $result_data['Title'];
		echo "</td>";
		$class = ($result_data['status'] == "Open") ? "status-danger" : "status-active";
		echo '<td><div class="' . $class . '">' . $result_data['status'] . '</div></td><td>';
		echo '<a href="/customer_complaint_edit.php?id=' . $result_data['id'] . '&type=view" class="me-3"><i class="fa fa-eye" aria-hidden="true"></i></a>';
		if ($result_data['status'] == "Open") {
			echo '<a href="/customer_complaint_edit.php?id=' . $result_data['id'] . '" class="me-3"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
		} else {
			echo '<a data-id="' . $result_data['id'] . '" target="_blank" class="print-customer-complaint me-3"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></a>';
		}
		echo "</td>";
	}
	echo "</tr></tbody></table></div>";
}
