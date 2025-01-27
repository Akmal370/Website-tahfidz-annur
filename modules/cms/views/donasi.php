<!--begin::Content-->
<style>
    .tagify.form-control-lg {
        border-radius : 0.625rem !important;
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <form method="POST" action="<?= base_url('cms_function/update_donasi'); ?>" class="container-xxl" id="form_ubah_donasi">
        <!--begin::Basic primary-->
        <div class="card mb-5 mt-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Pengaturan Tampilan Donasi</h3>
                </div>
                <!--end::Card title-->
                
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <div class="collapse show">
                <!--begin::Form-->
                <div class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Background</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?= image_check('default.jpg','default') ?>')">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-300px h-125px" style="background-size : contain;background-image: url('<?= image_check($result->image_donasi,'setting') ?>')"></div>
                                    <!--end::Preview existing avatar-->
                                    
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah data">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="image_donasi" accept=".png, .jpg" />
                                        <input type="hidden" name="image_donasi_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Cancel-->
                                    <span class="hps_image_donasi btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batal">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="hps_image_donasi btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus data">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Tipe yang didukung: png, jpg</div>
                                <div class="form-text text-danger">Untuk kesesuaian disarankan menggunakan background donasi dengan rasio 695∶75, 139∶15 atau mendekati</div>
                                <input type="hidden" name="name_image_donasi" value="<?=$result->image_donasi;?>">
                                <!--end::Hint-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label for="title_donasi" class="col-lg-4 col-form-label required fw-semibold fs-6">Judul</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="req_title_donasi">
                                        <input id="title_donasi" value="<?= $result->title_donasi; ?>" type="text" name="title_donasi" class="form-control form-control-lg form-control-solid" placeholder="Masukkan judul donasi" autocomplete="off" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label for="text_donasi" class="required col-lg-4 col-form-label fw-semibold fs-6">Deskripsi Donasi</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="req_text_donasi">
                                        <textarea name="text_donasi" id="text_donasi" cols="30" rows="3" class="form-control form-control-lg form-control-solid" placeholder="Masukkan deskripsi singkat website"><?= $result->text_donasi; ?></textarea>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                    
                    </div>
                    <!--end::Card body-->
                    
                    
                </div>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Basic primary-->
    </form>
    <!--end::Container-->
</div>
<!--end::Content-->

