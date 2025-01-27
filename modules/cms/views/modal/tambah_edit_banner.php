<?php
    $prefix = "";
    $img = image_check('default.jpg','default');
    $type = 'insert';
    $active = 'img';
    $button = "";
    $title = "";
    $description = "";
    $button_name = "";
    $button_link = "";
    $alert = '';
    $name_file = "";
    if (isset($result)) {
        if ($cms == true) {
            $prefix = "edit_";
        }
        $type = 'edit';
        $img = image_check($result->file,'default');
        $ext = explode('.',$result->file);
        if (isset($ext[1]) ) {
            $name_file = $result->file;
            $img = image_check($result->file,'banner');
        }
        if ($result->button == 'Y') {
            $button = "Y";
            $button_name = $result->button_name;
            $button_link = $result->button_link;
        }

        $title = $result->title;
        $description = $result->description;
        

        
    }
?>
<div class="row w-100 d-flex justify-content-center align-items-start mt-5 mb-5">
    <div class="col-md-5 d-flex flex-column">
        <!-- IMAGE -->
        <div id="<?=$prefix?>modal_banner_display_image" class="background-partisi d-flex justify-content-center align-items-center flex-column <?= ($active != 'img') ? 'd-none' : ''; ?>" style="width : 100%;height:200px;background-image: linear-gradient(rgb(44 212 36 / 63%), rgb(0 0 0 / 36%)),url('<?= $img ?>');">
            <h4 id="<?=$prefix?>modal_banner_display_title" class="text-white text-center" style="font-size : 17px;width : 90%;"><?= $title;?></h4>
            <p id="<?=$prefix?>modal_banner_display_text" class="text-white text-center" style="font-size : 12px;width : 90%;"><?= $description;?></p>
            <button id="<?=$prefix?>modal_banner_display_button" class="btn btn-sm btn-warning <?= ($button != 'Y') ? 'd-none' : '';?>" style="min-width : 50px;min-height : 10px;font-size : 12px"><?= $button_name; ?></button>
        </div>
        <?= $alert;?>
       
    </div>
    <div class="col-md-7 d-flex flex-column justify-content-center align-items-start">
        <?php if($type == 'edit') : ?>
            <input type="hidden" name="id_banner" value="<?= $result->id_banner;?>">
            <input type="hidden" name="name_file" value="<?= $name_file; ?>">
        <?php endif;?>
        <!--begin::Input group-->
        <div class="fv-row mb-7 w-100" id="req_<?=$prefix?>file">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">File Banner</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="file" onchange="cek_image_banner(this,'<?=$prefix?>')" name="file" class="form-control form-control-solid mb-3 mb-lg-0" accept=".png, .jpg, .jpeg" placeholder="Masukkan File Banner" autocomplete="off" />
            <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 w-100" id="req_<?=$prefix?>title">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2">Judul</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="title" data-limit="30" onkeyup="set_banner_attr(this,'#<?=$prefix?>modal_banner_display_title')" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Judul" value="<?= $title; ?>" autocomplete="off" />
            <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 w-100" id="req_<?=$prefix?>description">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2">Deskripsi</label>
            <!--end::Label-->
            <!--begin::Input-->
            <textarea name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi Banner" onkeyup="set_banner_attr(this,'#<?=$prefix?>modal_banner_display_text')" cols="30" rows="10"><?= $description; ?></textarea>
            <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 w-100" id="req_<?=$prefix?>button">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2">Button</label>
            <!--end::Label-->
            <div>
                <select onchange="set_button(this,'<?=$prefix?>modal_banner_display_button')" id="<?=$prefix?>select_button" name="button" class="button_select2 form-select form-select-solid" data-control="select2">
                    <option value="N" <?= ($button != 'Y') ? 'selected' : ''; ?>>Tidak</option>
                    <option value="Y" <?= ($button == 'Y') ? 'selected' : ''; ?>>Ya</option>
                </select>
            </div>
        </div>
        <!--end::Input group-->

        <div class="fw-row d-flex flex-stack w-100">
            <div class="button_attribut col-md-6 pe-2" id="req_<?=$prefix?>button_name">
                 <!--begin::Label-->
                <label class="<?= ($button == 'Y') ? 'required' : ''; ?> fw-semibold fs-6 mb-2">Nama Button</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="button_name" data-limit="20" value="<?= $button_name; ?>" onkeyup="set_banner_attr(this,'#<?=$prefix?>modal_banner_display_button')"  class="form-control form-control-solid set_button_null mb-3 mb-lg-0" placeholder="Masukkan nama button" autocomplete="off" />
                <!--end::Input-->
            </div>
            <div class="button_attribut col-md-6 ps-2" id="req_<?=$prefix?>button_link">
                 <!--begin::Label-->
                <label class="<?= ($button == 'Y') ? 'required' : ''; ?> fw-semibold fs-6 mb-2">Url Button</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="button_link"  class="form-control form-control-solid set_button_null mb-3 mb-lg-0" value="<?= $button_link; ?>" placeholder="Masukkan link redirect" autocomplete="off" />
                <!--end::Input-->
            </div>
        </div>
    </div>
</div>