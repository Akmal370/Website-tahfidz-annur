<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <div>
                    <div class="card mb-3 mb-xl-8">
                        <div class="d-flex flex-stack flex-wrap px-10 justify-content-between align-items-center py-5">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column align-items-start justify-content-center mb-5">
                                <!--begin::Title-->
                                <h1 class="d-flex text-primary fw-bold m-0 fs-3"><?= ucwords($page->name) ?></h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-600">
                                        <a class="text-gray-600 text-hover-primary">CMS</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-600"><?= ucwords($page->name) ?></li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <?php if($section) : ?>
                                <button onclick="sorting_section(this)" class="btn btn-sm btn-light-primary me-2" type="button">
                                    <i class="fa-solid fa-sort fs-2"></i>
                                    Pengurutan
                                </button>
                                <?php endif;?>
                                <button onclick="submit_form(this,'#form_table_sort',0)" data-loader="big" id="simpan_sorting" class="btn btn-sm btn-light-warning me-2 hidin" id="kt_frame_button" type="button">
                                    <i class="fa-solid fa-save fs-2"></i>
                                    Simpan
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div id="display_tabel_sort" class="hidin">
                    <form id="form_table_sort" method="POST" action="<?= base_url('cms_function/sorting_section') ?>" class="table-responsive">
                        <table id="table_sort_simple" class="table table-striped table-bordered align-middle gs-0 gy-4 rounded-3">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="ps-3">Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($section) : ?>
                                    <?php foreach($section AS $row) : ?>
                                        <tr class="cursor-move" draggable="true">
                                            <input type="hidden" name="id[]" value="<?= $row->id_cms_section; ?>">
                                            <td class="ps-3"><?= $row->layout.' (CMS'.date('YmdHis',strtotime($row->create_date)).$row->id_cms_section.')'; ?></td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php else :?>
                                    <tr class="cursor-move" draggable="true">
                                        <td class="ps-3">Tidak ada data</td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div id="display_section" class="showin">
                    <?php if($section) : ?>
                        <?php foreach($section AS $row) : ?>
                            <div id="section_loop_<?= $row->id_cms_section; ?>">
                                <?php
                                    $data = [];
                                    $data['id_page'] = $id_page;
                                    $data['id_layout'] = $row->id_layout;  
                                    $data['detail'] = $row;  
                                    $data['attribut'] = $attribut;
                                ?>
                                <?= $this->load->view('section/'.$row->file,$data);?>
                            </div>
                        <?php endforeach;?>
                    <?php else : ?>
                        
                    <?php endif;?>
                    <div id="display_not_found" class="card mb-3 py-5 mb-xl-8 mt-0 <?= ($section) ? 'hidin' : 'showin'; ?>">
                        <div class="d-flex justify-content-center align-items-center flex-column w-100">
                            <img src="<?= image_check('empty.svg','default') ?>" alt="Tidak ada data" style="width : 200px">
                            <h3 class="text-primary">Data section tidak ditemukan</h3>
                            <p>Silahkan menambahkan section untuk mengisi halaman ini!</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>


<!--begin::Drawer-->
<div
    id="kt_frame"
    class="bg-white"
    data-kt-drawer="true"
    data-kt-drawer-activate="true"
    data-kt-drawer-toggle="#kt_frame_button"
    data-kt-drawer-close="#kt_frame_close"
    data-kt-drawer-overlay="true"
    data-kt-drawer-permanent="true"
    data-kt-drawer-width="{default:'300px', 'md': '400px'}"
>
    <!--begin::Card-->
    <div class="card rounded-0 w-100" style="overflow-x : hidden;">
        <!--begin::Card header-->
        <div class="card-header pe-5">
            <!--begin::Title-->
            <div class="card-title">
                Layout Design
            </div>
            <!--end::Title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_frame_close">
                    <i class="fa-solid fa-x fs-3"></i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body d-flex justify-content-center flex-wrap row">
            <?php if($layout) : ?>
                <?php foreach($layout AS $row) : ?>
                <a role="button" onclick="add_section(this,<?= $id_page;?>,<?= $row->id_layout ?>)" class="btn_add_layout col-md-5 card py-3 m-2 px-2 cursor-pointer hover-primary" style="height : 160px;">
                    <img class="symbol w-100" style="height : 80px" src="<?= image_check($row->image, 'section') ?>" alt="<?= ucwords($row->name); ?>">
                    <h5 class="text-dark text-center text-bold mt-3"><?= ucwords($row->name); ?></h5>
                </a>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end::Drawer-->

<!-- BANNER -->

<!-- Modal Tambah cms_banner -->
<div class="modal fade" id="kt_modal_cms_banner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Banner <span id="banner_id_cms"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="choose-tab" data-bs-toggle="tab" data-bs-target="#choose-tab-pane" type="button" role="tab" aria-controls="choose-tab-pane" aria-selected="true">Pilih Banner</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="insert-tab" data-bs-toggle="tab" data-bs-target="#insert-tab-pane" type="button" role="tab" aria-controls="insert-tab-pane" aria-selected="false">Tambah Banner</button>
                    </li>
                </ul>
                
                <!--begin::Form-->
                <form id="form_cms_banner" class="tab-content form mt-5" action="<?= base_url('cms_function/tambah_cms_banner') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="cms" value="true">
                    <div aria-labelledby="choose-tab" tabindex="0" class="tab-pane fade show active" id="choose-tab-pane">
                        <input type="hidden" name="id_cms_section">
                        <?php if($banner) : ?>
                            <?php foreach($banner AS $row) : ?>
                                <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                    <!--begin::Details-->
                                    <div class="d-flex align-items-start justify-content-center">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input id="id-banner-<?= $row->id_banner; ?>" class="form-check-input widget-9-check cursor-pointer child_checkbox" name="id_banner[]" type="checkbox" value="<?= $row->id_banner ?>">
                                        </div>
                                        <!--begin::Details-->
                                        <?php $ext = explode('.',$row->file); ?>
                                        <?php if(in_array($ext[1],['mp4'])) : ?>
                                            <a href="<?= image_check($row->file,'banner'); ?>" target="_BLANK">
                                                <div class="symbol me-5 background-partisi shadow" style="width : 100px;height:50px;background-image : url('<?= image_check('video.jpg','default'); ?>')"></div>
                                            </a>
                                        <?php else :?>
                                            <div onclick="preview_image(this,'<?= image_check($row->file,'banner'); ?>')" class="symbol me-5 background-partisi shadow cursor-pointer" style="width : 100px;height:50px;background-image : url('<?= image_check($row->file,'banner'); ?>')"></div>
                                        <?php endif;?>
                                        <label for="id-banner-<?= $row->id_banner; ?>" class="ms-6 w-100">
                                            <!--begin::Name-->
                                            <a role="button" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">
                                                <?= $row->title; ?>
                                            </a>
                                            <!--end::Name-->

                                            <!--begin::Email-->
                                            <div class="fw-semibold text-muted"> <?= $row->description; ?></div>
                                            <!--end::Email-->
                                        
                                        </label>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Details-->

                                </div>
                            <?php endforeach;?>
                        <?php else : ?>
                            <div class="d-flex justify-content-center align-items-center flex-column w-100">
                                <img src="<?= image_check('empty.svg','default') ?>" alt="Tidak ada data" style="width : 200px">
                                <h3 class="text-primary">Data banner tidak ditemukan</h3>
                                <p>Tambahkan banner untuk mengakses fitur ini! Hubungi admin jika terjadi kesalahan</p>
                            </div>
                        <?php endif;?>
                        <div class="modal-footer d-flex justify-content-center align-items-center">
                            <button type="button" id="submit_cms_banner" onclick="submit_form(this,'#form_cms_banner',1)" data-loader="big" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                            </button>
                        </div>
                    </div>
                    <div aria-labelledby="insert-tab" tabindex="0" class="tab-pane fade" id="insert-tab-pane">
                        <?php $this->load->view('cms/modal/tambah_edit_banner.php'); ?>
                        <div class="modal-footer d-flex justify-content-center align-items-center">
                            <button type="button" id="submit_cms_banner_2" onclick="submit_form(this,'#form_cms_banner',1,'',false,false,'','<?= base_url('cms_function/tambah_banner'); ?>')" data-loader="big" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                            </button>
                        </div>
                    </div>
                </form>
                
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>

<!-- Modal ubah cms_banner -->
<div class="modal fade" id="kt_modal_ubah_banner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Banner <span id="ubah_banner_id_cms"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            
            <div class="modal-body mx-5 mx-xl-15 my-7">
                
                <!--begin::Form-->
                <form id="form_ubah_banner" class="tab-content form mt-5" action="<?= base_url('cms_function/ubah_banner') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="cms" value="true">
                    <input type="hidden" name="id_cms_section">
                    <div id="display_edit_banner"></div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="button" id="submit_cms_banner_2" onclick="submit_form(this,'#form_ubah_banner',2)" data-loader="big" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                </form>
                
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>



<!-- Modal Tambah cms_banner -->
<div class="modal fade" id="kt_modal_detail_banner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Banner <span id="detail_banner_id_cms"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <div id="display_detail_modal"></div>
            </div>
        </div>
    </div>
</div>
