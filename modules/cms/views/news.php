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
                            <h1 class="d-flex text-dark fw-bold m-0 fs-3">Data Berita</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Base Data</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">Berita</li>
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
                            <input type="text" name="search" value="<?= $search; ?>" class="form-control form-control-solid w-250px ps-13" aria-label="Cari" aria-describedby="button-cari-news" placeholder="Cari" autocomplete="off">
                            <button type="button" onclick="search(false)" class="btn btn-primary d-none" type="button" id="button-cari-news">
                                <i class="ki-duotone ki-magnifier fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-none justify-content-end" id="sistem_drag">
                                <button type="button" id="btn_hapus" onclick="submit_form(this,'#reload_table',0,'/delete2/news/<?= base64url_encode('cms/news') ?>',true,true)" data-message="Apakah anda yakin akan menghapus data? Data yang dihapus tidak dapat dipulihkan" class="btn btn-sm btn-light-danger me-3">Hapus</button>
                                <button type="button" id="btn_block" onclick="submit_form(this,'#reload_table',0,'/block/news/<?= base64url_encode('cms/news') ?>',true)" class="btn btn-sm btn-light-warning me-3">Sembunyikan</button>
                                <button type="button" id="btn_unblock" onclick="submit_form(this,'#reload_table',0,'/unblock/news/<?= base64url_encode('cms/news') ?>',true)" class="btn btn-sm btn-light-success me-3">Tampilkan</button>
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
                                        <!--end::Input group-->

                                         <div class="mb-5">
                                            <label class="form-label fs-6 fw-semibold">Kategori</label>
                                            <select name="id_news_category" class="form-select form-select-solid filter-input" data-control="select2" data-placeholder="Pilih Status">
                                                <option value="all">Semua</option>
                                                <?php if($category) : ?>
                                                <?php foreach($category AS $row) :?>
                                                <option value="<?= $row->id_news_category; ?>" <?php if ($this->input->get('id_news_category') == $row->id_news_category) {
                                                                        echo 'selected';
                                                                    } ?>><?= ucfirst($row->name); ?></option>
                                                <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                        </div>


                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button" onclick="filter(['status','id_news_category'],false)" class="btn btn-primary fw-semibold px-6">Terapkan</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Filter-->

                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Add news-->
                             <button type="button" class="btn btn-sm btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_news_category">
                                <i class="ki-duotone ki-plus fs-2"></i>Category</button>
                            <!--end::Add news-->
                            <!--begin::Add news-->
                             <button type="button" class="btn btn-sm btn-primary" onclick="tambah_data(this,'<?= $id_page; ?>')" data-bs-toggle="modal" data-bs-target="#kt_modal_news">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Berita</button>
                            <!--end::Add news-->
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
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input cursor-pointer" type="checkbox" onchange="checked_action(this)" <?php if (!$result) {
                                                                                                                                                    echo 'disabled';
                                                                                                                                                } ?>>
                                            </div>
                                        </th>
                                        <th class="min-w-150px">Gambar</th>
                                        <th class="min-w-200px">Judul</th>
                                        <th class="min-w-200px">Berita Pendek</th>
                                        <th class="min-w-150px text-center">Status</th>
                                        <th class="min-w-100px text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>

                                    <?php if ($result) : ?>
                                        <?php foreach ($result as $row) : ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input widget-9-check cursor-pointer child_checkbox" name="id_batch[]" onchange="child_checked()" type="checkbox" value="<?= $row->id_news ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center flex-column">
                                                        
                                                        <div class="background-partisi d-flex justify-content-center align-items-center flex-column" style="width : 150px;height:150px;background-image: linear-gradient(rgb(44 212 36 / 63%), rgb(0 0 0 / 36%)),url('<?= image_check($row->image,'news') ?>');">
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-start flex-column">
                                                        <div class="badge badge-light-primary d-block fs-7 mb-2"><?= ucwords($row->category) ?></div>
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a class="text-dark fw-bold text-hover-primary fs-6"><?= ucwords(short_text($row->title,50)); ?></a>
                                                        </div>            
                                                    </div>
                                                </td>
                                                <td>
                                                    <?= short_text($row->short_description,200); ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <div class="form-check form-switch">
                                                            <input onchange="switching(this,event,<?= $row->id_news ?>)" data-url="<?= base_url('setting_function/switch/news') ?>" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-<?= $row->id_news ?>" <?= ($row->status == 'Y') ? 'checked': ''; ?>>
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center flex-shrink-0">
                                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1" title="Edit data" onclick="ubah_data(this,<?= $row->id_news ?>,'<?= $id_page; ?>')" data-image="<?= image_check($row->image,'news'); ?>" data-bs-toggle="modal" data-bs-target="#kt_modal_news">
                                                            <i class="ki-outline ki-pencil fs-2"></i>
                                                        </button>
                                                        <button type="button" onclick="hapus_data(event,<?= $row->id_news; ?>,'cms_function/hapus_news/<?= $id_page; ?>')" title="Hapus Data" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                                                            <i class="ki-outline ki-trash fs-2"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <?php 
                                                $nobase = 6;
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

<!-- Modal Tambah news -->
<div class="modal fade" id="kt_modal_news" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit Berita|Tambah Berita"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_news" class="form" action="<?= base_url('cms_function/tambah_news') ?>" method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7" id="#">
                        
                        <div id="lead"></div>
                        <input type="hidden" name="id_page" value="<?= $id_page;?>">
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
                                    <input type="file" id="upload_foto_news" name="image" accept=".png, .jpg, .jpeg" />
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
                        <div class="fv-row mb-7" id="req_id_news_category">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Kategori</label>
                            <!--end::Label-->
                            <div>
                                <select id="id_news_category" name="id_news_category" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kategori">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach($category AS $row) : ?>
                                        <option value="<?= $row->id_news_category;?>"><?= ucfirst($row->name); ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_title">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Judul</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Judul" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <input type="hidden" name="name_image">
                        <input type="hidden" name="id_news">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_short_description">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Deskripsi Singkat</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="short_description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi Singkat" cols="30" rows="3"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_long_description">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Isi Berita</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="long_description" id="long_description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Isi Berita" cols="30" rows="3"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_news" data-editor="long_description" onclick="submit_form(this,'#form_news',1)" class="btn btn-primary">
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





<!-- Modal Tambah news -->
<div class="modal fade" id="kt_modal_news_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal_category">Kategori Berita</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7" id="parent_category">
                <!--begin::Form-->
                <form id="form_news_category" class="form" method="POST" enctype="multipart/form-data">
                    <div class="fv-row mb-7 w-100" id="req_category_name">
                        <label class="required fw-semibold fs-6 mb-2">Kategori</label>
                        <input type="hidden" name="id_page" value="<?= $id_page;?>">
                        <div id="tambah_category" class="input-group">
                            <input name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Kategori Berita" autocomplete="off">
                            <button class="btn btn-primary" onclick="submit_form(this,'#form_news_category',3,'',false,false,'','<?= base_url('cms_function/tambah_news_category/'.$id_page) ?>')" id="button_add_news_category" type="button">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <div id="edit_category" class="input-group d-none">
                            <input type="hidden" name="id_news_category" value="">
                            <input name="name_edit" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Kategori Berita" autocomplete="off">
                            <button class="btn btn-warning" onclick="submit_form(this,'#form_news_category',3,'',false,false,'','<?= base_url('cms_function/ubah_news_category/'.$id_page) ?>')" id="button_edit_news_category" type="button">
                                <i class="fa-solid fa-pen-nib fs-5"></i>
                            </button>
                            <button class="btn btn-danger" onclick="change_mode('#edit_category','#tambah_category')" type="button">
                                <i class="fa-solid fa-x fs-5"></i>
                            </button>
                        </div>
                    </div>   
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <?php
                                    $col = 2;
                                ?>
                                <th style="width: 80px;" colspan="<?= $col;?>"><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($category) : ?>
                                <?php foreach($category AS $row) :?>
                                    <tr>
                                        <td><?= ucwords($row->name); ?></td>
                                        <td style="width : 50px;">
                                            <button type="button" class="btn btn-sm btn-warning"  onclick="change_mode('#tambah_category','#edit_category',[<?= $row->id_news_category ?>,'<?= $row->name; ?>'])">
                                                <i class="fa-solid fa-pen-nib fs-5"></i>
                                            </button>
                                        </td>
                                        <td style="width : 50px;">
                                            <button type="button" onclick="hapus_data(event,<?= $row->id_news_category; ?>,'cms_function/hapus_news_category/<?= $id_page; ?>')" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash fs-5"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else : ?>
                            <tr>
                                <?php
                                    $col2 = 3;
                                ?>
                                <td colspan="<?= $col2;?>">Tidak ada data</td>
                            </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
