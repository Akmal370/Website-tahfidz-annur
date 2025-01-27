<?php 
    $obj = [];
    $title = '';
    $subtitle = '';
    $show = 'all';
    if ($detail->data != '') {
        $obj = json_decode($detail->data);
        $title = (isset($obj->title)) ? $obj->title : ''; 
        $subtitle = (isset($obj->subtitle)) ? $obj->subtitle : ''; 
        $show = (isset($obj->show)) ? $obj->show : 'all'; 
    }

?>
<div class="card mb-3 mb-xl-8 mt-0 showin">
    <div class="card-header py-4" id="header-parent-<?= $detail->id_cms_section ?>">
        <!--begin::Card title-->
        <div class="card-title m-0 d-flex justify-content-between align-items-center flex-wrap w-100" id="header-reload-<?= $detail->id_cms_section ?>">
            <div class="d-flex justify-content-center align-items-center">
                <div class="form-check form-switch">
                    <input onchange="switching(this,event,<?= $detail->id_cms_section ?>)" data-url="<?= base_url('setting_function/switch/cms_section') ?>" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-<?= $detail->id_cms_section ?>" <?= ($detail->status == 'Y') ? 'checked': ''; ?>>
                </div>
                <h5 class="fw-bold m-0">Section <?= ucwords($detail->layout) ,' (CMS'.date('YmdHis',strtotime($detail->create_date)).$detail->id_cms_section.')'; ?></h5>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <button type="button" onclick="hapus_data(event,<?= $detail->id_cms_section; ?>,'cms_function/hapus_section','','big')" class="btn btn-sm mx-2 btn-primary">
                    <i class="fa-solid fa-trash fs-2"></i>
                    Hapus
                </button>
            </div>
        </div>
        <!--end::Card title-->


        <div class="card-body d-flex justify-content-center align-items-center flex-column">
            <div class="d-flex justify-content-center align-items-center flex-column" style="width : 80%;">
                <div class="fv-row mb-7 w-100">
                    <label class="fw-semibold fs-6 mb-2">Sub Judul</label>
                    <div class="input-group">
                        <input type="hidden" value="<?= $subtitle; ?>" id="history-sub-title-<?= $detail->id_cms_section; ?>">
                        <input type="text" value="<?= $subtitle; ?>" onkeyup="cek_text_input(this,'#btn-save-subtitle-<?= $detail->id_cms_section; ?>')" id="sub-title-<?= $detail->id_cms_section; ?>" name="subtitle" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Sub Judul" autocomplete="off" >
                        <button class="btn btn-primary" disabled="true" type="button" id="btn-save-subtitle-<?= $detail->id_cms_section; ?>" onclick="insert_target(this,<?= $detail->id_cms_section; ?>,'#sub-title-<?= $detail->id_cms_section; ?>')" data-name="subtitle" data-prefix="sub judul" data-disabled="true">
                            <i class="fa-solid fa-save"></i>
                        </button>
                    </div>
                </div>

                <div class="fv-row mb-7 w-100">
                    <label class="fw-semibold fs-6 mb-2">Judul</label>
                    <div class="input-group">
                        <input type="hidden" value="<?= $title;?>" id="history-title-<?= $detail->id_cms_section; ?>">
                        <input type="text" value="<?= $title; ?>" onkeyup="cek_text_input(this,'#btn-save-title-<?= $detail->id_cms_section; ?>')" name="title" id="title-<?= $detail->id_cms_section; ?>" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Judul" autocomplete="off" >
                        <button class="btn btn-primary" disabled="true" id="btn-save-title-<?= $detail->id_cms_section; ?>" type="button" onclick="insert_target(this,<?= $detail->id_cms_section; ?>,'#title-<?= $detail->id_cms_section; ?>')" data-name="title" data-prefix="judul" data-disabled="true">
                            <i class="fa-solid fa-save"></i>
                        </button>
                    </div>
                </div>

                <div class="fv-row mb-7 w-100">
                    <label class="required fw-semibold fs-6 mb-2">Jumlah Penampilan</label>
                    <select name="show" onchange="select_show(this,<?= $detail->id_cms_section; ?>)" data-prefix="Jumlah Penampilan (CMS<?=date('YmdHis',strtotime($detail->create_date)).$detail->id_cms_section;?>)" class="form-select form-select-solid mb-3" data-control="select2" data-placeholder="Pilih Jumlah Penampilan">
                        <option value="all" <?= ($show == 'all') ? 'selected' : ''; ?>>Semua</option>
                        <option value="3" <?= ($show == 3) ? 'selected' : ''; ?>>3 Data</option>
                        <option value="6" <?= ($show == 6) ? 'selected' : ''; ?>>6 Data</option>
                        <option value="9" <?= ($show == 9) ? 'selected' : ''; ?>>9 Data</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
