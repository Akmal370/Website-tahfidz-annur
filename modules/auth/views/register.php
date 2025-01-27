<div class="d-flex flex-column flex-root">
    <!--begin::Page bg image-->
   <style>
      body { 
         background-size : cover;
         background-repeat : no-repeat;
         background-position : center;
         background-image: linear-gradient(135deg, #1963a621 0%, var(--bs-primary) 100%),url('<?= image_check('login.jpg','background') ?>'); 
      }
      
   </style>
   <!--end::Page bg image-->
    <!--begin::Authentication - Sign-up -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center align-items-center">
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" method="POST"  novalidate="novalidate" id="form_register" action="<?= base_url('auth_function/register_proses'); ?>">
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <img src="<?= image_check($setting->logo,'setting') ?>" alt="" width="100px">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3 mt-2">Daftar Member</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Buat akun member untuk melanjutkan akses di program SiAir sebagai member</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Masukan nama lengkap" name="name" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            
                            <!--begin::Input group-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="email" placeholder="Masukan alamat email" name="email" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-8">
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="number" name="phone" class="form-control bg-transparent"  placeholder="Masukkan nomor telepon" autocomplete="off" >
                                </div>
                            </div>

                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="button_register" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Daftar</span>
                                    <!--end::Indicator label-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">Sudah memiliki akun ?
                            <a href="<?= base_url('login') ?>" class="link-primary fw-semibold">Masuk sekarang</a></div>
                            <!--end::Sign up-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-up-->
</div>