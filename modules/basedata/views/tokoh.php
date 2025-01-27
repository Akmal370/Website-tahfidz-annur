<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <div class="card mb-5 mb-xl-8">
                    <div class="d-flex flex-stack flex-wrap ms-10 mt-10">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-start">
                            <!--begin::Title-->
                            <h1 class="d-flex text-dark fw-bold m-0 fs-3">Data Tokoh</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Base Data</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">Tokoh</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--begin::Body-->
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <div class="d-flex align-items-center position-relative me-3 search_mekanik w-300px">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" name="search" value="<?= $search; ?>" class="form-control form-control-solid w-250px ps-13" aria-label="Cari" aria-describedby="button-cari-tokoh" placeholder="Cari" autocomplete="off">
                            <button type="button" onclick="search(false)" class="btn btn-primary d-none" type="button" id="button-cari-tokoh">
                                <i class="ki-duotone ki-magnifier fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-none justify-content-end" id="sistem_drag">
                                <?php if(($action == 'all' || isset($action->$prefix_page->D))) : ?>
                                <button type="button" id="btn_hapus" onclick="submit_form(this,'#reload_table',0,'/delete2/tokoh/<?= base64url_encode('basedata/tokoh') ?>',true,true)" data-message="Apakah anda yakin akan menghapus data? Data yang dihapus tidak dapat dipulihkan" class="btn btn-sm btn-light-danger me-3">Hapus</button>
                                <?php endif;?>
                                <?php if(($action == 'all' || isset($action->$prefix_page->B))) : ?>
                                <button type="button" id="btn_block" onclick="submit_form(this,'#reload_table',0,'/block/tokoh/<?= base64url_encode('basedata/tokoh') ?>',true)" class="btn btn-sm btn-light-warning me-3">Sembunyikan</button>
                                <button type="button" id="btn_unblock" onclick="submit_form(this,'#reload_table',0,'/unblock/tokoh/<?= base64url_encode('basedata/tokoh') ?>',true)" class="btn btn-sm btn-light-success me-3">Tampilkan</button>
                                <?php endif;?>
                            </div>
                            <div class="d-flex justify-content-end" id="sistem_filter">

                                <!--begin::Filter-->
                                <button type="button" class="btn btn-sm btn-secondary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-filter fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Penyaringan
                                </button>
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px filter_mekanik" data-kt-menu="true">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Pilih Penyaringan</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Separator-->
                                    <!--begin::Content-->
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <label class="form-label fs-6 fw-semibold">Status</label>
                                            <select name="status" class="form-select form-select-solid filter-input" data-control="select2" data-placeholder="Pilih Status">
                                                <option value="all">Semua</option>
                                                <option value="Y" <?php if ($this->input->get('status') == 'Y') {
                                                                        echo 'selected';
                                                                    } ?>>Aktif</option>
                                                <option value="N" <?php if ($this->input->get('status') == 'N') {
                                                                        echo 'selected';
                                                                    } ?>>Tidak Aktif</option>
                                            </select>
                                        </div>


                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button" onclick="filter(['status'],false)" class="btn btn-primary fw-semibold px-6">Terapkan</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Filter-->

                            </div>
                            <!--end::Toolbar-->
                            <?php if($action == 'all' || isset($action->$prefix_page->C)) : ?>
                            <!--begin::Add tokoh-->
                             <button type="button" class="btn btn-sm btn-primary" onclick="tambah_data(this)" data-bs-toggle="modal" data-bs-target="#kt_modal_tokoh">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Tokoh</button>
                            <!--end::Add tokoh-->
                            <?php endif;?>
                        </div>
                    </div>
                    <!--end::Header-->
                    <div class="card-body py-3" id="base_table">
                        <!--begin::Table container-->
                        <form action="<?= base_url('setting_function/drag') ?>" method="POST" class="table-responsive" id="reload_table">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="w-25px">
                                            <?php if(($action == 'all' || isset($action->$prefix_page->B) || isset($action->$prefix_page->D))) : ?>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input cursor-pointer" type="checkbox" onchange="checked_action(this)" <?php if (!$result) {
                                                                                                                                                    echo 'disabled';
                                                                                                                                                } ?>>
                                            </div>
                                            <?php endif;?>
                                        </th>
                                        <th class="min-w-150px">Gambar</th>
                                        <th class="min-w-200px">Name</th>
                                        <?php if($action == 'all' || isset($action->$prefix_page->B)) : ?>
                                        <th class="min-w-150px text-center">Status</th>
                                        <?php endif;?>
                                        <?php if(isset($action)) : ?>
                                            <?php if($action == 'all' || isset($action->$prefix_page->D) || isset($action->$prefix_page->U)) : ?>
                                            <th class="min-w-100px text-center">Aksi</th>
                                            <?php endif;?>
                                        <?php endif;?>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>

                                    <?php if ($result) : ?>
                                        <?php foreach ($result as $row) : ?>
                                            <tr>
                                                <td>
                                                    <?php if(($action == 'all' || isset($action->$prefix_page->B) || isset($action->$prefix_page->D))) : ?>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input widget-9-check cursor-pointer child_checkbox" name="id_batch[]" onchange="child_checked()" type="checkbox" value="<?= $row->id_tokoh ?>">
                                                    </div>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center flex-column">
                                                        
                                                        <div class="background-partisi d-flex justify-content-center align-items-center flex-column" style="width : 150px;height:150px;background-image: url('<?= image_check($row->image,'tokoh') ?>');">
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-start flex-column">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a class="text-dark fw-bold text-hover-primary fs-6"><?= ucwords(short_text($row->name,50)); ?></a>
                                                        </div>            
                                                    </div>
                                                </td>
                                                <?php if($action == 'all' || isset($action->$prefix_page->B)) : ?>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <div class="form-check form-switch">
                                                            <input onchange="switching(this,event,<?= $row->id_tokoh ?>)" data-url="<?= base_url('setting_function/switch/tokoh') ?>" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-<?= $row->id_tokoh ?>" <?= ($row->status == 'Y') ? 'checked': ''; ?>>
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                                <?php endif;?>
                                                <?php if(isset($action)) : ?>
                                                <td>
                                                    <div class="d-flex justify-content-center flex-shrink-0">
                                                        <?php if($action == 'all' || isset($action->$prefix_page->U)) : ?>
                                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1" title="Edit data" onclick="ubah_data(this,<?= $row->id_tokoh ?>)" data-image="<?= image_check($row->image,'tokoh'); ?>" data-bs-toggle="modal" data-bs-target="#kt_modal_tokoh">
                                                            <i class="ki-outline ki-pencil fs-2"></i>
                                                        </button>
                                                        <?php endif;?>

                                                        <?php if($action == 'all' || isset($action->$prefix_page->D)) : ?>
                                                        <button type="button" onclick="hapus_data(event,<?= $row->id_tokoh; ?>,'basedata_function/hapus_tokoh')" title="Hapus Data" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                                                            <i class="ki-outline ki-trash fs-2"></i>
                                                        </button>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <?php endif;?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <?php 
                                                $nobase = 3;
                                                if($action == 'all' || isset($action->$prefix_page->B)) {
                                                    $nobase += 1;
                                                }
                                                if($action == 'all' || isset($action->$prefix_page->D) || isset($action->$prefix_page->U)) {
                                                    $nobase += 1;
                                                }
                                            ?>
                                            <td colspan="<?= $nobase; ?>">
                                                <center>Data Tidak Ditemukan</center>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                            <?= $this->pagination->create_links(); ?>
                        </form>
                        <!--end::Table container-->
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

<!-- Modal Tambah tokoh -->
<div class="modal fade" id="kt_modal_tokoh" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit Tokoh|Tambah Tokoh"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_tokoh" class="form" action="<?= base_url('basedata_function/tambah_tokoh') ?>" method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7" id="#">
                        
                        <div id="lead"></div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
                            <!--begin::Label-->
                            <label class="required d-block fw-semibold fs-6 mb-5">Gambar</label>
                            <!--end::Label-->
                            <!--begin::Image input-->
                            <div class="image-input" data-kt-image-input="true" style="background-image: url('<?= image_check('notfound.jpg','default') ?>')">
                                <!--begin::Image preview wrapper-->
                                <div id="display_image" class="image-input-wrapper w-200px h-200px" style="background-image: url('<?= image_check('notfound.jpg','default') ?>')"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Data">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" id="upload_foto_tokoh" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle hps_foto btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_image" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Batal">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span class="btn btn-icon btn-circle hps_foto btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_image" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Hapus Data">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Tipe: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_name">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Tokoh</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Nama" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <input type="hidden" name="name_image">
                        <input type="hidden" name="id_tokoh">
                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_address">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Alamat</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="address" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Alamat" cols="30" rows="3"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <?php if($sosmed) : ?>
                            <?php foreach($sosmed AS $row) : ?>
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label for="input_<?= $row->id_sosmed;?>" class="col-lg-4 col-form-label fw-semibold fs-6"><?= ucwords($row->name) ?></label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-12 fv-row">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="icon-<?= $row->id_sosmed;?>">
                                                    <i class="<?= $row->icon;?>"></i>
                                                </span>
                                                <input type="text" name="sosmed[<?= $row->id_sosmed;?>]" value="<?= $row->url; ?>" id="input_<?= $row->id_sosmed;?>" autocomplete="off" class="form-control" placeholder="Masukan Url" aria-label="Masukan Url" aria-describedby="icon-<?= $row->id_sosmed;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Row-->

                                    
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <?php endforeach;?>
                        <?php else :?>
                            TIDAK ADA DATA SOSMED
                        <?php endif; ?>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_description">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Deskripsi</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="description" id="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Isi Berita" cols="30" rows="3"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_tokoh" data-editor="description" onclick="submit_form(this,'#form_tokoh',1)" class="btn btn-primary">
                            <span class="indicator-label">Kirim</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>