<?php
session_start();
require_once "includes/functions.php";

/**
 * Get the directory size
 * @param  string $directory
 * @return integer
 */
function dirSize($directory)
{
	$size = 0;
	foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
		$size += $file->getSize();
	}
	return $size;
}

function sizeFormat($bytes)
{
	$kb = 1024;
	$mb = $kb * 1024;
	$gb = $mb * 1024;
	$tb = $gb * 1024;

	if (($bytes >= 0) && ($bytes < $kb)) {
		return $bytes . ' B';
	} elseif (($bytes >= $kb) && ($bytes < $mb)) {
		return ceil($bytes / $kb) . ' KB';
	} elseif (($bytes >= $mb) && ($bytes < $gb)) {
		return ceil($bytes / $mb) . ' MB';
	} elseif (($bytes >= $gb) && ($bytes < $tb)) {
		return ceil($bytes / $gb) . ' GB';
	} elseif ($bytes >= $tb) {
		return ceil($bytes / $tb) . ' TB';
	} else {
		return $bytes . ' B';
	}
}

$consulta = " SELECT * FROM Document LIMIT 0";
$termino = "";
$email = $_SESSION['usuario'];
$roleSql = "SELECT Id_basic_role, Basic_Employee.Department_Head From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$department_head = $roleInfo['Department_Head'];

if (isset($_POST['productos'])) {
	$termino = mysqli_real_escape_string($con, $_POST['productos']);
	$allfiles = scandir('./document-manager');
	unset($allfiles[array_search('.', $allfiles, true)]);
	unset($allfiles[array_search('..', $allfiles, true)]);



	$i = 0;

	echo '<div class="card-body">
		<!--begin::Table header-->
		<div class="d-flex flex-stack">
			<!--begin::Folder path-->
			<div class="badge badge-lg badge-light-primary">
				<div class="d-flex align-items-center flex-wrap">
					<span><a href="/documentation.php">Document Managment System</a></span>
				</div>
			</div>
		</div>
		<!--end::Table header-->

		<!-- desplegable-->
		<div>
			<div class="row m-2">
				<table class="table align-middle table-row-dashed fs-6 gy-5 gx-5">
					<thead>
						<!--begin::Table row-->
						<tr class="text-start text-gray-400 text-uppercase gs-0">
							<th class="w-20px" rowspan="1" colspan="1">
								<div class="text-center" style="width:50px; cursor:pointer">
									<input class="form-check-input w-20px h-20px"
										type="checkbox" data-kt-check="true"
										data-kt-check-target="#kt_file_manager_list .form-check-input"
										value="1">
								</div>
							</th>
							<th class="min-w-250px sorting_disabled" rowspan="1" colspan="1">
								Name</th>
								<th class="min-w-100px sorting_disabled" rowspan="1" colspan="1">
								File Size</th>
							<th class="min-w-120px sorting_disabled" rowspan="1" colspan="1">
								File Count</th>
							<th class="min-w-140px sorting_disabled" rowspan="1" colspan="1">
								Modified Date</th>';
	if ($role == 1 || strval($department_head) == "Yes") {
		echo '<th class="w-125px sorting_disabled text-end" rowspan="1"
														colspan="1">Action
													</th>';
	}
	echo '</tr>
			<!--end::Table row-->
					</thead>
					<tbody class="fw-bold text-gray-600">';
	foreach ($allfiles as $file) {
		if (stripos($file, $_POST['productos']) !== false) {
			$url = "./document-manager/" . $file;
			$size = sizeFormat(dirSize($url));
			$fi = new FilesystemIterator($url, FilesystemIterator::SKIP_DOTS);
			$count =  iterator_count($fi);
			$time = @filemtime($url);
			echo '<tr>
    <td class="w-10px">
        <div class="text-center" style="width:50px ;cursor:pointer">
            <input class="form-check-input w-20px h-20px" type="checkbox" data-kt-check="true"
                data-kt-check-target="#kt_file_manager_list .form-check-input" value="1">
        </div>
    </td>
    <td>
        <form class="d-flex">
            <div class="d-flex align-items-center name-label">
                <span class="svg-icon svg-icon-2x svg-icon-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor"></path>
                        <path
                            d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                <a style="text-decoration:underline" href="/documentation-view-folder.php?name=' . $file . '">' . $file . '</a></div>';
			echo '<div style="margin:0;visibility: hidden" class="d-flex name-field  w-250px">
    <input type="hidden"  name="oldName" value="' . $file . '">
<input class="form-control" type="text" name="newName" value="' . $file . '">
<span class="toggle-on span-icon-1 ms-2 mt-2 name-save">
    <i class="fa fa-check"></i>
</span>

<span class="toggle-off span-icon-1 name-cancel ms-2 mt-2">
    <b><i class="bi bi-x" style="font-size: 20px;"></i></b>
</span>

</div>
</form>
</td>';

			echo '<td>' . $size . '</td>
			<td>' . $count . '</td>
			<td>
				' . date("d-m-y", $time) . '</td>';
			if ($role == 1 || strval($department_head) == "Yes") {
				echo '<td>
<div
	class="d-flex justify-content-end align-items-center px-3 column-gap">
	<div class="ms-2">
	<div class="dropdown">
	<button class="btn btn-sm btn-icon btn-light btn-active-light-primary" type="button" id="drp_btn_' . $i . '" data-bs-toggle="dropdown" aria-expanded="false">
	<span class="svg-icon svg-icon-5 m-0">
		<svg xmlns="http://www.w3.org/2000/svg"
			width="24" height="24" viewBox="0 0 24 24"
			fill="none">
			<rect x="10" y="10" width="4" height="4"
				rx="2" fill="currentColor"></rect>
			<rect x="17" y="10" width="4" height="4"
				rx="2" fill="currentColor"></rect>
			<rect x="3" y="10" width="4" height="4"
				rx="2" fill="currentColor"></rect>
		</svg>
	</span>
	</button>
	<ul class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" aria-labelledby="drp_btn_' . $i . '"><li>
		<div class="dropdown-item px-3" style="cursor:pointer">
			<a class="menu-link text-danger px-3 name-edit" data-kt-filemanager-table-filter="delete_row">Edit
				Folder</a>
		</div>
  	 </li><li>
	  <div class="menu-item px-3">
	  	<a data-id="' . $file . '" class="menu-link text-danger px-3 delete_folder" data-kt-filemanager-table-filter="delete_row">Delete</a>
  	</div>
 	 </li>
	</ul>
  </div></div></div></div></td>';
			}

			echo '</tr>';
		}
	}
	echo '
</tbody>
</table>
</div>
</div>
<!-- fin desplegable -->
</div>';
}
