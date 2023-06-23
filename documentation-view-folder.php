<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "View Folder";

$email = $_SESSION['usuario'];
$roleSql = "SELECT Id_basic_role, Basic_Employee.Department_Head From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$department_head = $roleInfo['Department_Head'];
?>
<style>
    td,
    a {
        font-size: 13px !important
    }
</style>
<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->

<!--begin::Body-->

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
                    <div>
                        <!--begin::Title-->
                        <div>
                            <p><a href="/">Home</a> » <a href="/documentation.php">Document Managment System</a>
                                »<?php echo $_SESSION['Page_Title']; ?></p>
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
                            <div class="card-title ms-4 mt-2">
                                <input type="hidden" name="name" id="name" value="<?php echo $_REQUEST['name']; ?>">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-5 mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Document No" id="search-files" name="search-files" />

                                    <!--<input class="form-control form-control-solid w-250px ps-15" type="text" name="termino" id="termino" placeholder="Search Files &amp; Folders" aria-label="Search">-->
                                </div>
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body">
                                <?php
                                // variable $i para los desplegables
                                $url = "./document-manager/" . $_REQUEST['name'];

                                $documetancion_categoria = scandir($url);

                                unset($documetancion_categoria[array_search('.', $documetancion_categoria, true)]);
                                unset($documetancion_categoria[array_search('..', $documetancion_categoria, true)]);

                                ?>

                                <div class="table-area custom-search-nz" id="search-result">
                                </div>
                                <!--begin::Item-->
                                <div class="row mb-4 mt-4">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack mb-4">
                                        <!--begin::Folder path-->
                                        <div class="badge badge-lg badge-light-primary">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <span><a href="/documentation.php">Document Managment System</a></span>
                                                <span class="ms-3 me-3">»</span>
                                                <span><?php echo $_REQUEST['name'] ?></span>
                                            </div>
                                        </div>

                                        <div class="me-6">
                                            <select class="form-control" name="language" id="lang" required>
                                                <option value="">Select Langauge</option>
                                                <option value="0" <?php echo (isset($_GET['lang']) && $_REQUEST['lang'] == '0') ? "selected" : "" ?>>
                                                    English</option>
                                                <option value="1" <?php echo (isset($_GET['lang']) && $_REQUEST['lang'] == '1') ? "selected" : "" ?>>
                                                    Spanish</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex align-items-center mb-n1">
                                        <!--begin::Bullet-->
                                        <!--<span class="bullet me-3"></span>-->
                                        <!--end::Bullet-->
                                        <!--begin::Label-->
                                        <!--begin::Table-->
                                        <!--<table id="kt_file_manager_list" data-kt-filemanager-table="folders" class="table align-middle table-row-dashed fs-6 gy-5 gx-5">-->
                                        <!-- NOTA: ESTA ID Y DATA HACE LA FUNCIONALIDAD DEL BUSCADOR -->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bold text-uppercase gs-0">

                                                    <th class="min-w-125px hidde-responsive-j6">
                                                        Document No
                                                    </th>
                                                    <th class="min-w-125px hidde-responsive-j6">
                                                        Rev No</th>
                                                    <th class="hidde-responsive-j6">
                                                        Prepared by
                                                    </th>
                                                    <th class="hidde-responsive-j6">
                                                        Date Prep.
                                                    </th>
                                                    <th class="hidde-responsive-j6">
                                                        Review by
                                                    </th>
                                                    <th class="hidde-responsive-j6">
                                                        Date Rev.
                                                    </th>
                                                    <th class="hidde-responsive-j6">
                                                        Approved by
                                                    </th>
                                                    <th class="min-w-125px hidde-responsive-j6">
                                                        Date App.
                                                    </th>
                                                    <th class="min-w-125px hidde-responsive-j6">
                                                        Language
                                                    </th>
                                                    <th class="min-w-125px hidde-responsive-j6">
                                                        Actions
                                                    </th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">

                                                <?php
                                                $resultData = array();

                                                foreach ($documetancion_categoria as $value_categoria) {
                                                    $sql_datos_document = null;

                                                    if (isset($_GET['lang']) && $_GET['lang'] != "") {
                                                        $sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks,language FROM Document WHERE language = '$_REQUEST[lang]' AND  File LIKE '$value_categoria'";
                                                    } else {
                                                        $sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks, language FROM Document WHERE File LIKE '$value_categoria'";
                                                    }

                                                    $conect_datos_document = mysqli_query($con, $sql_datos_document);

                                                    while ($row = mysqli_fetch_assoc($conect_datos_document)) {
                                                        array_push($resultData, $row);
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <?php
                                                    /*PAGINACION*/
                                                    $pagination_ok = 1;
                                                    /*PAGINACION*/
                                                    /*Numero total de registros*/
                                                    $num_rows = count($resultData);
                                                    /*contador*/
                                                    $page_register_count = 0;
                                                    /*max. registros per pagina*/
                                                    $max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 50;
                                                    /*Si hay paginación*/
                                                    if ($_REQUEST['page'] && $_REQUEST['page'] != 1) {
                                                        $this_page = $_REQUEST['page'] - 1;
                                                        $pass_registers = $max_registers_page * $this_page;
                                                        $registers_off = 0;
                                                    } else {
                                                        /*Si es la primera página, ponemos esto para que evite el uso del continue - Saltaba el primer registro sin esto-*/
                                                        $this_page = 0;
                                                        $pass_registers = 0;
                                                        $registers_off = 0;
                                                    }

                                                    foreach ($resultData as $result_datos_document) {
                                                        /*PAGINACION*/
                                                        if ($pagination_ok == 1) {
                                                            /*codigo para saltar registros de paginas anteriores*/
                                                            if ($registers_off != $pass_registers) {
                                                                $registers_off++;
                                                                continue;
                                                            }
                                                            /*codigo para mostrar solo los registros de la pagina*/
                                                            if ($page_register_count != $max_registers_page) {
                                                                $page_register_count++;
                                                            } else {
                                                                break;
                                                            }
                                                        }

                                                    ?>
                                                        <td class="hidde-responsive-j6"><a target="_blank" style="text-decoration: underline;" href="./document-manager/<?php echo $_REQUEST['name'] ?>/<?php echo $result_datos_document['File'] ?>"><?php echo $result_datos_document['Format_No']; ?></a>
                                                        </td>

                                                        <td class="hidde-responsive-j6">
                                                            <?php echo $result_datos_document['Rev_No']; ?>
                                                        </td>
                                                        <td class="hidde-responsive-j6">
                                                            <?php
                                                            $id_prepared_by = $result_datos_document['Prepared_by'];
                                                            $consulta_prepared_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_prepared_by";
                                                            $consulta_general_prepared_by = mysqli_query($con, $consulta_prepared_by);
                                                            $result_prepared_by = mysqli_fetch_assoc($consulta_general_prepared_by);
                                                            echo $result_prepared_by['First_Name'] . ' ' . $result_prepared_by['Last_Name'];
                                                            ?>

                                                        </td>
                                                        <td class="hidde-responsive-j6">
                                                            <?php echo date("d-m-y", strtotime($result_datos_document['Date_of_preparation'])); ?>
                                                        </td>
                                                        <td class="hidde-responsive-j6">

                                                            <?php
                                                            $id_reviewd_by = $result_datos_document['Reviewd_by'];
                                                            $consulta_reviewd_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_reviewd_by";
                                                            $consulta_general_reviewd_by = mysqli_query($con, $consulta_reviewd_by);
                                                            $result_reviewd_by = mysqli_fetch_assoc($consulta_general_reviewd_by);
                                                            echo  $result_reviewd_by['First_Name'] . ' ' . $result_reviewd_by['Last_Name'];
                                                            ?>

                                                        </td>
                                                        <td class="hidde-responsive-j6">
                                                            <?php echo date("d-m-y", strtotime($result_datos_document['Date_of_revision'])); ?>
                                                        </td>
                                                        <td class="hidde-responsive-j6">

                                                            <?php
                                                            $id_approved_by = $result_datos_document['Approved_by'];
                                                            $consulta_approved_by = "SELECT * FROM Basic_Employee WHERE Id_employee = $id_approved_by";
                                                            $consulta_general_approved_by = mysqli_query($con, $consulta_approved_by);
                                                            $result_approved_by = mysqli_fetch_assoc($consulta_general_approved_by);

                                                            echo  $result_approved_by['First_Name'] . ' ' . $result_approved_by['Last_Name'];
                                                            ?>

                                                        </td>
                                                        <td class="hidde-responsive-j6">
                                                            <?php echo date("d-m-y", strtotime($result_datos_document['Date_of_approval'])); ?>
                                                        </td>
                                                        <td class="hidde-responsive-j6">
                                                            <?php if ($result_datos_document['language'] == '0') {
                                                                echo "English";
                                                            } else if ($result_datos_document['language'] == '1') {
                                                                echo "Spanish";
                                                            }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="/documentation_view_file.php?<?php echo $result_datos_document['File']; ?>"><i class="bi bi-eye-fill" style="padding-right: 4px;"></i></a>
                                                            <a href="/documentation_edit_file.php?name=<?php echo $result_datos_document['File']; ?>"><i class="bi bi-pencil" style="padding-right: 4px;"></i></a>
                                                            <?php if ($role  == 1 || strval($department_head) == "Yes") { ?>
                                                                <a href="/documentation_delete.php?pg_id=<?php echo $result_datos_document['File']; ?>"><i class="bi bi-trash" style="padding-right: 4px;"></i></a>
                                                            <?php } ?>
                                                            <a href="documentation_historial_file.php?<?php echo $result_datos_document['File']; ?>"><i class="bi bi-hourglass-split" style="padding-right: 4px;"></i></a>
                                                        </td>
                                                        <!--end::Actions-->

                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>

                                    </div>
                                    <!--end::Item-->
                                    <!--start:: PAGINATION-->
                                    <div class="d-flex justify-content-between">
                                        <div class="ms-3 pageRange">
                                            <select id="pageRange" name="pageRange" class="form-select">
                                                <option value="10" <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>10
                                                </option>
                                                <option value="25" <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>25
                                                </option>
                                                <option value="50" <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>50
                                                </option>
                                                <option value="100" <?php echo ($max_registers_page == 100) ? 'selected' : ''; ?>>100
                                                </option>
                                            </select>
                                        </div>
                                        <div class="me-6">
                                            <ul class="pagination pagination-circle pagination-outline">
                                                <?php
                                                if ($pagination_ok == 1) {
                                                    $num_pages = $num_rows / $max_registers_page;
                                                    $total_pages = ceil($num_pages);
                                                    if (!$_REQUEST['page']) {
                                                        $_REQUEST['page'] = 1;
                                                    }
                                                    $current_page = $_REQUEST['page'];
                                                }
                                                ?>
                                                <input type="hidden" id="total_pages" value="<?php echo $total_pages ?>">
                                                <input type="hidden" id="current_page" value="<?php echo $current_page ?>">
                                            </ul>
                                            <!--end:: PAGINATION-->
                                        </div>
                                    </div>
                                    <!--end:: PAGINATION-->
                                </div>
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
    <!-- BUSCADOR SEARCH PARA: Department -->
    <script src="JS/buscar-search-file.js"></script>
    <!-- FIN BUSCADOR SEARCH JS -->
    <!--end::Page Custom Javascript-->
    <script>
        const element = document.querySelector(".pagination");
        let totalPages = Number($("#total_pages").val());
        let page = Number($("#current_page").val());

        if (totalPages > 0) {
            element.innerHTML = createPagination(totalPages, page);
        }

        function createPagination(totalPages, page) {
            let liTag = '';
            let active;
            let beforePage = page - 2;
            let afterPage = page + 2;
            let prevLabel = "<";
            let nextLabel = ">";
            let firstPage = "<<";
            let lastPage = ">>";
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const name = urlParams.get('name');

            liTag +=
                `<li class="page-item m-1"><a href="/documentation-view-folder.php?name=${name}&page=${1}" class="page-link">${firstPage}</a></li>`;
            if (page > 1) {
                liTag +=
                    `<li class="page-item m-1"><a href="/documentation-view-folder.php?name=${name}&page=${page - 1}" class="page-link">${prevLabel}</a></li>`;
            }
            if (page == totalPages) {
                beforePage = beforePage - 2;
            } else if (page == totalPages - 1) {
                beforePage = beforePage - 1;
            }
            if (page == 1) {
                afterPage = afterPage + 2;
            } else if (page == 2) {
                afterPage = afterPage + 1;
            }
            beforePage = beforePage > 0 ? beforePage : 1;
            for (var plength = beforePage; plength <= afterPage; plength++) {
                if (plength > totalPages) {
                    continue;
                }
                if (plength == 0) {
                    plength = plength + 1;
                }
                if (page == plength) {
                    active = "active";
                } else {
                    active = "";
                }
                liTag +=
                    `<li class="page-item m-1 ${active}"><a href="/documentation-view-folder.php?name=${name}&page=${plength}" class="page-link">${plength}</a></li>`;
            }
            if (page < totalPages) {
                liTag +=
                    `<li class="page-item m-1"><a href="/documentation-view-folder.php?name=${name}&page=${page + 1}" class="page-link">${nextLabel}</a></li>`;
            }
            liTag +=
                `<li class="page-item m-1"><a href="/documentation-view-folder.php?name=${name}&page=${totalPages}" class="page-link">${lastPage}</a></li>`;
            element.innerHTML = liTag;
            return liTag;
        }

        $('#lang').on('change', function() {
            let lang = $('#lang').val();
            orginUrl = window.location.href.replace(window.location.search, '');
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            (lang != "") ? urlParams.set('lang', lang): urlParams.delete('lang');
            let newUrl = [orginUrl, urlParams.toString()].join('?');
            return window.location.href = newUrl;
        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>