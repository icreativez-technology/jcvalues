<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Document Management System";
// $documetancion = scandir('./document-manager');
// unset($documetancion[array_search('.', $documetancion, true)]);
// unset($documetancion[array_search('..', $documetancion, true)]);

$email = $_SESSION['usuario'];
$roleSql = "SELECT Id_basic_role, Basic_Employee.Department_Head From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$department_head = $roleInfo['Department_Head'];
?>
<style>
    @media (max-width: 576px) {
    .icon-lg {
        display: none;
    }
}

</style>
<?php
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
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->

<!--begin::Body-->
<style>
    .span-icon {
        background-color: #f5f8fa !important;
        padding: 8px 12px !important;
        border-radius: 5px;
        background-color: #f5f8fa;
        cursor: pointer;
    }

    .span-icon-1 {
        background-color: #f5f8fa !important;
        padding: 10px 12px !important;
        border-radius: 5px;
        background-color: #f5f8fa;
        cursor: pointer;
        height: 38px;
    }

    td,
    a {
        font-size: 13px !important
    }

    .table-responsive table td {
        padding-top: 0.3rem !important;
        padding-bottom: 0.3rem !important;
    }
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <!-- Includes Top bar and Responsive Menu -->
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div class='col-12'>
                        <!--begin::Title-->
                        <div>
                            <p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
                            <!-- MIGAS DE PAN -->
                        </div>
                    </div>
                    <!--end::body-->
                </div>

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">

                        <!--begin::Card-->
                        <div class="card card-flush">
                            <!--begin::Card header-->
                            <div class="card-header pt-6">

                                <div class="card-title  ">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-5 mt-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Folders" id="termino" name="termino" />

                                        <!--<input class="form-control form-control-solid w-250px ps-15" type="text" name="termino" id="termino" placeholder="Search Files &amp; Folders" aria-label="Search">-->
                                    </div>
                                    <!--end::Search-->
                                </div>


                                <!-- -->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                                    <!--begin::new folder-->
                                    <?php if ($role == 1 || (strval($department_head) == "Yes")) { ?>
                                        <a href="/documentation_add_folder.php">
                                            <button type="button" class="btn btn-light-primary me-3" style="font-size: 10px;">
                                                <!--begin::Svg Icon | path: icons/duotune/files/fil013.svg-->
                                                <span class="svg-icon svg-icon-2 icon-lg" style="width: 5px; height: 8px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="8px" height="8px" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                                            <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="currentColor" />
                                                            <path opacity="0.3" d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <span style="font-size: 10px; font-weight: bold;">New Folder</span>
                                                </button>
                                            </a>
                                        <?php } ?>
                                        <!--end::new folder-->
                                        <!--begin::Add customer-->
                                        <a href="/documentation_add_file.php">
                                            <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" style="font-size: 7px;">
                                            <span style="font-size: 9px; font-weight: bold;">Upload Files</span>
                                                <!-- begin::Svg Icon | path: icons/duotune/files/fil018.svg-->
                                                <span class="svg-icon svg-icon-2 icon-lg" style="width: 12px; height: 12px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                                        <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM16 11.6L12.7 8.29999C12.3 7.89999 11.7 7.89999 11.3 8.29999L8 11.6H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H16Z" fill="currentColor" />
                                                        <path opacity="0.3" d="M11 11.6V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H11Z" fill="currentColor" />
                                                    </svg>
                                                </span> 
                                                <!--end::Svg Icon-->
                                            </button>
                                        </a>
                                        <!--end::Add customer-->

                                        <!--begin::Add customer-->
                                        <?php if ($role == 1 || (strval($department_head) == "Yes")) { ?>
                                            <a>
                                                <button type="button" class="btn btn-danger ms-3" id="delete-all" style="font-size: 9px;">
                                                    Delete Folders
                                                </button>
                                            </a>
                                        <?php } ?>
                                        <!--end::Add customer-->
                                    </div>
                                    <!--end::Toolbar-->
                                    <!--begin::Group actions-->
                                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-filemanager-table-toolbar="selected">
                                        <div class="fw-bolder me-5">
                                            <span class="me-2" data-kt-filemanager-table-select="selected_count"></span>Selected
                                        </div>
                                        <button type="button" class="btn btn-danger" data-kt-filemanager-table-select="delete_selected">Delete Selected</button>
                                    </div>
                                    <!--end::Group actions-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!-- Mostrar datos del buscador -->
                            <div class="table-area custom-search-nz table-responsive" id="docu_resultados">
                            </div>

                            <!-- Mostrar mensaje de eliminar
                            <div class="alert alert-success" style="display:none;"></div> -->

                            <!--begin::Card body-->
                            <div class="card-body">
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
                                    <div class="row m-2 table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5">
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                    <th class="w-20px" rowspan="1" colspan="1">
                                                        <div class="text-center" style="width:50px; cursor:pointer">
                                                            <input class="form-check-input w-20px h-20px" type="checkbox" id="folder-checkbox-all">
                                                        </div>
                                                    </th>
                                                    <th class="min-w-200px sorting_disabled" rowspan="1" colspan="1">
                                                        Name</th>
                                                    <th class="min-w-100px sorting_disabled" rowspan="1" colspan="1">
                                                        File Size</th>
                                                    <th class="min-w-120px sorting_disabled" rowspan="1" colspan="1">
                                                        File Count</th>
                                                    <th class="min-w-140px sorting_disabled" rowspan="1" colspan="1">
                                                        Modified Date</th>
                                                    <?php if ($role == 1 || (strval($department_head) == "Yes")) { ?>
                                                        <th class="w-125px sorting_disabled text-end" rowspan="1" colspan="1">Action
                                                        </th>
                                                    <?php } ?>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <tbody class="fw-bold text-gray-600">
                                                <?php
                                                foreach ($documetancion as $value) {
                                                    $url = "./document-manager/" . $value;

                                                    $documetancion_categoria = scandir($url);

                                                    unset($documetancion_categoria[array_search('.', $documetancion_categoria, true)]);
                                                    unset($documetancion_categoria[array_search('..', $documetancion_categoria, true)]);

                                                    $size = sizeFormat(dirSize($url));
                                                    $fi = new FilesystemIterator($url, FilesystemIterator::SKIP_DOTS);
                                                    $count =  iterator_count($fi);
                                                    $time = @filemtime($url);
                                                ?>

                                                    <tr>
                                                        <td class="w-10px">
                                                            <div class="text-center" style="width:50px ;cursor:pointer">
                                                                <input class="form-check-input w-20px h-20px folder-checkbox" type="checkbox" value="<?php echo $value; ?>">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <form class="d-flex">
                                                                <div class="d-flex align-items-center name-label">
                                                                    <span class="svg-icon svg-icon-2x svg-icon-primary">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor"></path>
                                                                            <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                    <a style="text-decoration: underline;" href="/documentation-view-folder.php?name=<?php echo $value ?>">
                                                                        <?php echo $value; ?>
                                                                    </a>
                                                                </div>
                                                                <div style="margin:0;visibility: hidden" class="d-flex name-field w-250px">
                                                                    <input type="hidden" name="oldName" value="<?php echo $value; ?>">
                                                                    <input class="form-control" type="text" name="newName" value="<?php echo $value; ?>">
                                                                    <span class="toggle-on span-icon-1 ms-2 mt-2 name-save">
                                                                        <i class="fa fa-check"></i>
                                                                    </span>

                                                                    <span class="toggle-off span-icon-1 name-cancel ms-2 mt-2">
                                                                        <b><i class="bi bi-x" style="font-size: 20px;"></i></b>
                                                                    </span>
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td><?php echo $size ?></td>
                                                        <td><?php echo $count ?></td>
                                                        <td>
                                                            <?php echo date("d-m-y", $time) ?></td>
                                                        <?php if ($role == 1 || strval($department_head) == "Yes") { ?>
                                                            <td>
                                                                <div class="d-flex justify-content-end align-items-center px-3 column-gap">
                                                                    <div class="ms-2">
                                                                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary view-menu" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                                                                            <span class="svg-icon svg-icon-5 m-0">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                                    <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                                                    <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                                                    <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                                                </svg>
                                                                            </span>
                                                                            <!--end::Svg Icon-->
                                                                        </button>
                                                                        <!--begin::Menu-->

                                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4 view-menu-content" data-kt-menu="true">
                                                                            <!--begin::Menu item-->
                                                                            <div class="menu-item px-3">
                                                                                <a class="menu-link text-danger px-3 name-edit" data-kt-filemanager-table-filter="delete_row">Edit
                                                                                    Folder</a>
                                                                            </div>
                                                                            <div class="menu-item px-3">
                                                                                <a data-id="<?php echo $value ?>" class="menu-link text-danger px-3 delete_folder" data-kt-filemanager-table-filter="delete_row">Delete</a>
                                                                            </div>

                                                                            <!--end::Menu item-->
                                                                        </div>
                                                                        <!--end::Menu-->
                                                                    </div>

                                                                </div>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                                <!-- fin desplegable -->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->


                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->

                <!-- FINAL CONTENIDO PERSONALIZADO -->

                <?php include('includes/footer.php'); ?>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->


    <?php include('includes/scrolltop.php'); ?>

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/custom/apps/file-manager/list.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
    <script>
        $(document).on('click', '.name-edit', function() {
            $(this).closest('tr').find('.name-label').removeClass('d-flex').css('display', 'none');
            $(this).closest('tr').find('.name-field').css('visibility', 'visible');
        });

        $(document).on('click', '.name-cancel', function() {
            $(this).closest('tr').find('.name-label').addClass('d-flex').css('display', 'unset');
            $(this).closest('tr').find('.name-field').css('visibility', 'hidden');
        });

        $(document).on('click', '.name-save', function() {
            const oldName = $(this).closest('.name-field').find('[name="oldName"]').val();
            const newName = $(this).closest('.name-field').find('[name="newName"]').val();
            const data = {
                oldName: oldName,
                newName: newName
            }
            $.ajax({
                type: 'POST',
                url: 'includes/documentation_rename_folder.php',
                data: data
            }).done(function(result) {
                if (result == "2") {
                    alert('The folder name is invalid')
                } else if (result == "3") {
                    alert('The folder is already exist')
                }
                window.location.reload();
            });

        });

        $(document).on('click', '.delete_folder', function() {
            const folderName = $(this).data('id');
            const data = {
                name: folderName
            }
            $.ajax({
                type: 'POST',
                url: 'includes/documentation_delete_folder.php',
                data: data
            }).done(function(result) {
                if (result == "2") {
                    alert('You cannot remove the folder which contain files')
                }
                window.location.reload();
            });
        });

        $('#folder-checkbox-all').on('click', function() {
            let checkboxElem = $('.folder-checkbox');
            if ($('#folder-checkbox-all:checked').length) {
                $.each(checkboxElem, function(key, elem) {
                    elem.checked = true;
                });

            } else {
                $.each(checkboxElem, function(key, elem) {
                    elem.checked = false;
                });
            }
        });


        $('#delete-all').on('click', function() {
            let checkboxElem = $('.folder-checkbox:checked');
            let dataArr = new Array();
            $.each(checkboxElem, function(key, elem) {
                dataArr.push({
                    name: $(elem).val()
                });
            });

            if (dataArr.length > 0) {
                console.log(dataArr);
                $.ajax({
                    url: `includes/document-folder-bulk-delete.php`,
                    type: "POST",
                    dataType: "html",
                    data: {
                        data: dataArr,
                    },
                }).done(function(resultado) {
                    if (resultado) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
</body>
<!--end::Body-->

</html>