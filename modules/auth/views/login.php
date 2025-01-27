<div class="d-flex justify-content-center align-items-center flex-column flex-root">
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
   <!--begin::Authentication - Sign-in -->
   <div class="d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Body-->
      <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
         <!--begin::Wrapper-->
         <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
               <!--begin::Wrapper-->
               <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                  <!--begin::Form-->
                  <form class="form w-100" method="POST" novalidate="novalidate" id="form_login" action="<?= base_url('auth_function/login_proses') ?>">
                     <!--begin::Heading-->
                     <div class="text-center mb-11">
                        <?php if($setting->logo) : ?>
                           <img class="mb-4" src="<?= image_check($setting->logo,'setting') ?>" alt="" width="150px">
                        <?php endif;?>
                        <p>Masukkan email & kata sandi untuk melanjutkan akses</p>
                        <!--end::Title-->
                     </div>
                     <!--begin::Heading-->
                     <!--begin::Input group=-->
                     <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="text" placeholder="Enter email" name="email" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Email-->
                     </div>
                     <!--end::Input group=-->
                     <div class="fv-row mb-3">
                        <!--begin::Password-->
                        <input type="password" placeholder="Enter password" name="password" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Password-->
                     </div>
                     <!--end::Input group=-->
                     <!--begin::Submit button-->
                     <div class="d-grid mb-10">
                        <button type="submit" id="button_login" class="btn btn-primary mt-5">
                           <!--begin::Indicator label-->
                           <span class="indicator-label">Log In</span>
                        </button>
                     </div>
                     <!--end::Submit button-->
                     <!--begin::Sign up-->
                     <!--end::Sign up-->
                      <div class="text-gray-500 text-center fw-semibold fs-6">
                     <a href="<?= base_url('register'); ?>" class="link-primary">Anda ingin bergabung bersama kami?</a></div>
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
   <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->