<!--begin::Content-->
<style>
    .tagify.form-control-lg {
        border-radius : 0.625rem !important;
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <form method="POST" action="<?= base_url('setting_function/update_umum'); ?>" class="container-xxl" id="form_ubah_setting">
        <!--begin::Basic primary-->
        <div class="card mb-5 mt-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Pengaturan Umum</h3>
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
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Icon</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?= image_check('default.jpg','default') ?>')">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url('<?= image_check($result->icon,'setting') ?>')"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah data">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="icon" accept=".png, .jpg," />
                                        <input type="hidden" name="icon_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="hps_icon btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batal">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="hps_icon btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus data">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Tipe yang didukung: png, jpg, ico</div>
                                <input type="hidden" name="name_icon" value="<?=$result->icon;?>">
                                <!--end::Hint-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Logo</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?= image_check('default.jpg','default') ?>')">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-300px h-125px" style="background-size : contain;background-image: url('<?= image_check($result->logo,'setting') ?>')"></div>
                                    <!--end::Preview existing avatar-->
                                    
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah data">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="logo" accept=".png, .jpg" />
                                        <input type="hidden" name="logo_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Cancel-->
                                    <span class="hps_logo btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batal">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="hps_logo btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus data">
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
                                <div class="form-text text-danger">Untuk kesesuaian disarankan menggunakan logo dengan rasio 695∶75, 139∶15 atau mendekati</div>
                                <input type="hidden" name="name_logo" value="<?=$result->logo;?>">
                                <!--end::Hint-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label for="name" class="col-lg-4 col-form-label required fw-semibold fs-6">Nama</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="req_name">
                                        <input id="name" value="<?= $result->name; ?>" type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="Masukkan nama" autocomplete="off" />
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
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor Telepon</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8" >
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="parent_phone">
                                        <?php if($phone) : ?>
                                        <?php $no = 1; foreach($phone AS $row) : $num = $no++;?>
                                            <div class="input-group mb-3" id="phone-frame-<?= $num; ?>">
                                                <input type="text" name="name_phone[<?= $num; ?>]" value="<?= $row->name; ?>" class="form-control form-control-lg" placeholder="Nama teller (Opsional)" autocomplete="off"/>
                                                <span class="input-group-text" id="phone-62-<?= $num; ?>">
                                                    +62
                                                </span>
                                                <input id="phone" type="text" name="phone[<?= $num; ?>]" value="<?= $row->phone; ?>" class="form-control form-control-lg" placeholder="Masukkan nomor telepon" autocomplete="off" aria-describedby="phone-62-<?= $num; ?>"/>
                                                <?php if($num == 1) : ?>
                                                <button class="btn btn-primary" type="button" onclick="tambah_contact(this)">
                                                    <i class="fa fa-plus fs-4"></i>
                                                </button>
                                                <?php else : ?>
                                                <button class="btn btn-light-primary" type="button" onclick="hapus_contact(<?= $num; ?>)">
                                                    <i class="fa fa-trash fs-4"></i>
                                                </button>
                                                <?php endif;?>
                                            </div>
                                        <?php endforeach;?>
                                        <?php else : ?>
                                        <div class="input-group mb-3">
                                            <input type="text" name="name_phone[1]" class="form-control form-control-lg" placeholder="Masukkan nama teller" autocomplete="off"/>
                                            <span class="input-group-text" id="phone-62-1">
                                                +62
                                            </span>
                                            <input id="phone" type="text" name="phone[1]" class="form-control form-control-lg" placeholder="Masukkan nomor telepon" autocomplete="off" aria-describedby="phone-62-1"/>
                                            <button class="btn btn-primary" type="button" onclick="tambah_contact(this)">
                                                <i class="fa fa-plus fs-4"></i>
                                            </button>
                                        </div>
                                        <?php endif;?>
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
                            <label for="email" class="col-lg-4 col-form-label required fw-semibold fs-6">Alamat Email</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="req_email">
                                        <input id="email" value="<?= $result->email; ?>" type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="Masukkan alamat email" autocomplete="off" />
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
                            <label for="keyword_website" class="col-lg-4 col-form-label fw-semibold fs-6">Kata Kunci Pencarian</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="req_keyword">
                                        <input class="form-control form-control-lg form-control-solid ps-4" value="<?= $result->keyword; ?>" placeholder="Masukkan keyword website" name="keyword" id="keyword_website"/>
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
                            <label for="sort_description" class="col-lg-4 col-form-label fw-semibold fs-6">Deskripsi Singkat Website</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="req_sort_description">
                                        <textarea name="sort_description" id="sort_description" cols="30" rows="3" class="form-control form-control-lg form-control-solid" placeholder="Masukkan deskripsi singkat website"><?= $result->sort_description; ?></textarea>
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
                            <label for="address" class="col-lg-4 col-form-label fw-semibold fs-6">Alamat</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="req_address">
                                        <textarea name="address" id="address" cols="30" rows="3" class="form-control form-control-lg form-control-solid" placeholder="Masukkan alamat"><?= $result->address; ?></textarea>
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
                            <label for="description" class="col-lg-4 col-form-label fw-semibold fs-6">Deskripsi Website</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row" id="req_description">
                                        <textarea name="description" id="description" cols="30" rows="10" class="form-control form-control-lg form-control-solid" placeholder="Masukkan deskripsi website"><?= $result->description; ?></textarea>
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

