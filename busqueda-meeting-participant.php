<?php 
session_start();
require_once "includes/functions.php";

/*$consulta=" SELECT * FROM Basic_Product_Group LIMIT 0";
$termino= "";*/


if(isset($_POST['productos']))
{	


	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$id_meeting = $_SESSION['id_meeting'];

	$consulta="SELECT * FROM Basic_Employee WHERE Status LIKE 'Active' AND (First_Name LIKE '%".$termino."%' OR Last_Name LIKE '%".$termino."%' OR Email LIKE '%".$termino."%' OR Admin_User LIKE '%".$termino."%' OR Custom_ID LIKE '%".$termino."%')";
}

$consultaBD = mysqli_query($con, $consulta);


if($consultaBD && strlen($termino) > 0){
	echo '
			<div class="card-body pt-0 table-responsive">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_Product Groups_table">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-gray-400 text-uppercase gs-0">
												<th class="min-w-25px">Employee</th>
												<th class="min-w-25px">ID</th>
												<th class="min-w-25px">Plant</th>
												<th class="min-w-25px">Department</th>
												<th class="min-w-25px">Status</th>
												<th class="text-end min-w-100px">Actions</th>
												
											</tr>
											<!--end::Table row-->
										</thead>';
				while ($result_data = mysqli_fetch_assoc($consultaBD)) {
					/*$sql_datos_co = "SELECT * FROM Meeting_Co_Ordinator WHERE Id_employee = '$result_data[Id_employee]'";
					$connect_data2 = mysqli_query($con, $sql_datos_co);
					$result_data2 = mysqli_fetch_assoc($connect_data2);

					/*Check if user is coordinator. If 1 is not coordinator so it wont be printed
					if($result_data2){
						$iscoord = 0;
					}else{
						$iscoord = 1;
					}


					if($iscoord==0){*/
								echo "<tbody class='fw-bold text-gray-600'>
										<tr>
											<td class='d-flex align-items-center'>
											<div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
													<div class='symbol-label'>
														<img src='assets/media/avatars/".$result_data['Avatar_img']."' class='w-100' />
													</div>
											</div>";
								echo '<div class="d-flex flex-column">
										'.$result_data['First_Name'].' '.$result_data['Last_Name'].'
										<span>'.$result_data['Email'].'</span>
								';
									echo"</td>";
									
									echo"<td>";
									echo $result_data['Custom_ID'];
									echo"</td>";
									
									echo"<td>";
									/*Select Plants Name*/
									$sql_data_plants = "SELECT Id_plant, Title FROM Basic_Plant WHERE Id_plant LIKE '$result_data[Id_plant]'";
									$connect_data_plants = mysqli_query($con, $sql_data_plants);
									$result_data_plants = mysqli_fetch_assoc($connect_data_plants);
									echo $result_data_plants['Title'];
									echo"</td>";

									echo"<td>";
									/*Select Department Name*/
									$sql_data_department = "SELECT Id_department, Department FROM Basic_Department WHERE Id_department LIKE '$result_data[Id_department]'";
									$connect_data_department = mysqli_query($con, $sql_data_department);
									$result_data_department = mysqli_fetch_assoc($connect_data_department);
									echo $result_data_department['Department'];
									echo"</td>";


											if($result_data['Status'] == 'Active')
											{
												echo '<td><div class="status-active">Active</div></td>';
											}
											else
											{
												echo '<td><div class="status-danger">Suspended</div></td>';
											}

									echo '<td class="text-end"><a href="/meeting-add-participant.php?pg_id='.$result_data['Id_employee'].'&id_meet='.$id_meeting .'" class="menu-link px-3"><i class="bi bi-plus-circle" style="padding-right: 4px;"></i>Add</a></td>';

									echo "

										</tr>
								</tbody>
							";
				//}	

	}
	echo "</table>
		</div>
		</div>";
}
?>