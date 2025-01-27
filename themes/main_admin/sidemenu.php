<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
<!--begin::Page-->
<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
    <!--begin::Header-->
    <div id="kt_app_header" class="app-header">
        <!--begin::Header container-->
        <div class="app-container container-fluid d-flex align-items-stretch flex-stack" id="kt_app_header_container">
            <!--begin::Sidebar toggle-->
            <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
                <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-2" id="kt_app_sidebar_mobile_toggle">
                    <i class="ki-outline ki-abstract-14 fs-2"></i>
                </div>
                <!--begin::Logo image-->
                <?php if($setting->logo) : ?>
                <a href="<?= base_url('dashboard') ?>">
                    <img alt="Logo" src="<?= image_check($setting->logo,'setting'); ?>" class="h-50px" />
                </a>
                <?php endif;?>
                <!--end::Logo image-->
            </div>
            <!--end::Sidebar toggle-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
                <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1">
                    <?php if(isset($button)) : ?>
                        <div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0">
                            <!--begin:Menu item-->
                            <div class="menu-item me-0 me-lg-2">
                                <!--begin:Menu link-->
                                <button type="button" data-loader="big" <?= (isset($button['data'])) ? $button['data'] : ''; ?> onclick="submit_form(this,'<?= (isset($button['form_id'])) ? $button['form_id'] : ''; ?>',<?= (isset($button['form_num'])) ? $button['form_num'] : 0; ?>)" id="<?= $button['id']; ?>" class="menu-link btn btn-sm" style="background-color: var(--bs-primary);">
                                    <span class="menu-title m-1 text-white"><?= (isset($button['name'])) ? $button['name'] : ucwords('submit'); ?></span>
                                </button>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                    <?php endif;?>
                </div>
                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-circle" style="width : 45px;height:45px;background-image : url('<?= image_check($this->session->userdata(PREFIX_SESSION.'_image'), 'user','user') ?>');background-position : center;background-size : cover;background-repeat : no-repeat;" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"></div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol me-5" style="width : 50px;height:50px;background-image : url('<?= image_check($this->session->userdata(PREFIX_SESSION.'_image'), 'user','user') ?>');background-position : center;background-size : cover;background-repeat : no-repeat;" ></div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5"><?= short_text($this->session->userdata(PREFIX_SESSION.'_name'),8); ?>
                                        <span class="badge badge-light-primary fw-bold fs-8 px-2 py-1 ms-2"><?= $this->session->userdata(PREFIX_SESSION.'_role') ?></span>
                                    </div>
                                    <a class="fw-semibold text-muted text-hover-primary fs-7"><?= phone_format($this->session->userdata(PREFIX_SESSION.'_phone')) ?></a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="<?= base_url('profile') ?>" class="menu-link px-5">Profil</a>
                        </div>
                        <!--end::Menu item-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="<?= base_url('logout') ?>" onclick="confirm_alert(this,event,'Apakah anda yakin akan meninggalkan sistem?')" class="menu-link px-5">Keluar</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
            </div>
            <!--end::Navbar-->
            <!--begin::Separator-->
            <div class="app-navbar-separator separator d-none d-lg-flex"></div>
            <!--end::Separator-->
        </div>
        <!--end::Header container-->
    </div>
    <!--end::Header-->
<!--begin::Wrapper-->
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
<!--begin::Sidebar-->
<div id="reload_sidebar">
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <div class="app-sidebar-header d-flex flex-stack d-none d-lg-flex pt-8 pb-2" id="kt_app_sidebar_header">
            <!--begin::Logo-->
            
            <a href="<?= base_url('dashboard') ?>" class="app-sidebar-logo">
            <?php if($setting->logo) : ?>
                <img alt="Logo" src="<?= image_check($setting->logo,'setting'); ?>" style="height : 60px;" class="d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
                <img alt="Logo" src="<?= image_check($setting->logo,'setting'); ?>" style="height : 60px;" class="d-none d-sm-inline app-sidebar-logo-default theme-dark-show" />
                <?php endif;?>
            </a>
            
            <!--end::Logo-->
            <!--begin::Sidebar toggle-->
            <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-sm btn-icon bg-light btn-color-gray-700 btn-active-color-primary d-none d-lg-flex rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                <i class="ki-outline ki-text-align-right rotate-180 fs-1"></i>
            </div>
            <!--end::Sidebar toggle-->
        </div>
        <!--begin::Navs-->
        <div class="app-sidebar-navs flex-column-fluid py-6" id="kt_app_sidebar_navs">
            <div id="kt_app_sidebar_navs_wrappers" class="app-sidebar-wrapper hover-scroll-y my-2" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-wrappers="#kt_app_sidebar_navs" data-kt-scroll-offset="5px">

                <!--begin::Sidebar menu-->
                <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary">
                    <!--begin::Heading-->
                    <div class="menu-item mb-2">
                        <div class="menu-heading text-uppercase fs-7 fw-bold">Menu</div>
                        <!--begin::Separator-->
                        <div class="app-sidebar-separator separator"></div>
                        <!--end::Separator-->
                    </div>
                    <!--end::Heading-->
                    <!--begin:Menu item-->
                    <a href="<?= base_url('dashboard'); ?>" class="menu-item here show menu-accordion">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= (in_array($this->uri->segment(1), ['dashboard'])) ? 'active' : ''; ?>">
                            <span class="menu-icon">
                            <i class="ki-duotone ki-home fs-2"></i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </span>
                        <!--end:Menu link-->
                    </a>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                     <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= set_menu_active($this->uri->segment(1), ['master'],'hover show') ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= (in_array($this->uri->segment(1), ['master'])) ? 'active' : ''; ?>">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-dropbox fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                </i>
                            </span>
                            <span class="menu-title">Master</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <a href="<?= base_url('master/user'); ?>" class="menu-item menu-accordion <?= set_submenu_active($this->uri->segment(1), ['master'], $this->uri->segment(2), ['user']) ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">User</span>
                                </span>
                                <!--end:Menu link-->
                            </a>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <a href="<?= base_url('master/member'); ?>" class="menu-item menu-accordion <?= set_submenu_active($this->uri->segment(1), ['master'], $this->uri->segment(2), ['member']) ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Member</span>
                                </span>
                                <!--end:Menu link-->
                            </a>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                     <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= set_menu_active($this->uri->segment(1), ['cms'],'hover show') ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= (in_array($this->uri->segment(1), ['cms'])) ? 'active' : ''; ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-camera-retro fs-2"></i>
                            </span>
                            <span class="menu-title">CMS</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <?php if($access['cms']) : ?>
                                <?php foreach($access['cms'] AS $row) : ?>
                                <!--begin:Menu item-->
                                <a href="<?= base_url('cms/'.base64url_encode($row['id_page'])); ?>" class="menu-item menu-accordion <?= set_submenu_active($this->uri->segment(1), ['cms'], $this->uri->segment(2), [base64url_encode($row['id_page'])]) ?>">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"><?= ucwords($row['name']) ?></span>
                                    </span>
                                    <!--end:Menu link-->
                                </a>
                                <!--end:Menu item-->
                                <?php endforeach;?>
                            <?php endif;?>
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <a href="<?= base_url('report'); ?>" class="menu-item here show menu-accordion">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= (in_array($this->uri->segment(1), ['report'])) ? 'active' : ''; ?>">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-graph-4 fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                </i>     
                            </span>
                            <span class="menu-title">Laporan Donasi</span>
                        </span>
                        <!--end:Menu link-->
                    </a>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <a href="<?= base_url('setting'); ?>" class="menu-item here show menu-accordion">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= (in_array($this->uri->segment(1), ['setting'])) ? 'active' : ''; ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-gear fs-2"></i>
                            </span>
                            <span class="menu-title">Pengaturan</span>
                        </span>
                        <!--end:Menu link-->
                    </a>
                    <!--end:Menu item-->
                </div>
                <!--end::Sidebar menu-->
            </div>
        </div>
        <!--end::Navs-->
    </div>
</div>
