<?php 
    $obj = [];
    $title = '';
    $description = '';
    $mirror = 'N';
    $button = 'N';
    $button_name = '';
     $img = '';
    $button_link = '';
    if ($detail->data != '') {
        $obj = json_decode($detail->data);
        $title = (isset($obj->title)) ? $obj->title : ''; 
        $description = (isset($obj->description)) ? $obj->description : ''; 
        $mirror = (isset($obj->mirror)) ? $obj->mirror : 'N'; 
        $button = (isset($obj->button)) ? $obj->button : 'N'; 
        $button_name = (isset($obj->button_name)) ? $obj->button_name : ''; 
        $button_link = (isset($obj->button_link)) ? $obj->button_link : ''; 
        $img = (isset($obj->image)) ? $obj->image : ''; 
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
            </div>
        </div>
        <!--end::Card title-->

        <div class="card-body d-flex justify-content-center align-items-center flex-column">
            <div class="row d-flex justify-content-center align-items-center" style="width : 90%;">
                
                <div id="place-mirror-<?= $detail->id_cms_section; ?>" class="d-flex <?= ($mirror == 'Y') ? 'flex-row-reverse' :''; ?>">
                    <div class="col-md-4">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">Gambar</label>
                            <!--end::Label-->
                            <!--begin::Image input-->
                            <div class="image-input" data-kt-image-input="true" style="background-image: url('<?= image_check('notfound.jpg','default') ?>')">
                                <!--begin::Image preview wrapper-->
                                <div id="display-image-<?= $detail->id_cms_section; ?>" class="image-input-wrapper w-125px h-125px" style="background-image: url('<?= image_check($img,'hero') ?>')"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Data">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" id="set-image-hero-<?= $detail->id_cms_section; ?>" onchange="hero_image(this,<?= $detail->id_cms_section; ?>,'<?= $img; ?>')" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_image" data-kt-image-input-action="cancel" onclick="remove_img('<?= $img; ?>',<?= $detail->id_cms_section; ?>)" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Batal">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_image" data-kt-image-input-action="remove" onclick="remove_img('<?= $img; ?>',<?= $detail->id_cms_section; ?>)" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Hapus Data">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Tipe: png, jpg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="col-md-8">
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
                        <div class="fv-row mb-7 w-100 d-flex">
                            <div class="col-md-6 pe-2">
                                <label class="required fw-semibold fs-6 mb-2">Button</label>
                                <select name="button" onchange="select_button(this,<?= $detail->id_cms_section; ?>)" data-prefix="button" class="form-select form-select-solid mb-3" data-control="select2" data-placeholder="Pilih button">
                                    <option value="N" <?= ($button == 'N') ? 'selected' : ''; ?>>Tidak</option>
                                    <option value="Y" <?= ($button == 'Y') ? 'selected' : ''; ?>>Ya</option>
                                </select>
                            </div>
                            <div class="col-md-6 ps-2">
                                <label class="required fw-semibold fs-6 mb-2">Mirror</label>
                                <select name="mirror" onchange="select_mirror(this,<?= $detail->id_cms_section; ?>)" data-prefix="mirror" class="form-select form-select-solid mb-3" data-control="select2" data-placeholder="Pilih posisi">
                                    <option value="N" <?= ($mirror == 'N') ? 'selected' : ''; ?>>Tidak (Gambar di kiri)</option>
                                    <option value="Y" <?= ($mirror == 'Y') ? 'selected' : ''; ?>>Ya (Gambar di kanan)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fv-row mb-7 w-100 d-flex <?= ($button == 'N') ? 'd-none' : ''; ?>" id="parent-button-<?= $detail->id_cms_section; ?>">
                    <div class="fv-row mb-7 w-100">
                        <label class="fw-semibold fs-6 mb-2">Button Attribut</label>
                        <div class="input-group">
                            <input type="hidden" value="<?= $button_name;?>" id="history-button_name-<?= $detail->id_cms_section; ?>">
                            <input type="hidden" value="<?= $button_link;?>" id="history-button_link-<?= $detail->id_cms_section; ?>">

                            <input type="text" value="<?= $button_name; ?>" onkeyup="cek_button_hero(this,'#button_link-<?= $detail->id_cms_section; ?>',<?= $detail->id_cms_section; ?>)" name="button_name" id="button_name-<?= $detail->id_cms_section; ?>" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Nama Button" autocomplete="off" >
                            <input type="text" value="<?= $button_link; ?>" onkeyup="cek_button_hero(this,'#button_name-<?= $detail->id_cms_section; ?>',<?= $detail->id_cms_section; ?>)" name="button_link" id="button_link-<?= $detail->id_cms_section; ?>" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Url Button" autocomplete="off" >
                            <button class="btn btn-primary" disabled="true" id="btn-save-button-<?= $detail->id_cms_section; ?>" type="button" onclick="insert_button_hero(this,<?= $detail->id_cms_section; ?>)">
                                <i class="fa-solid fa-save"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="fv-row mb-7 w-100">
                        <div class="w-100 d-flex justify-content-between align-items-center mb-4">
                            <label class="fw-semibold fs-6 mb-2">Deskripsi</label>
                            <button class="btn btn-sm btn-primary" id="btn-save-ck-<?= $detail->id_cms_section; ?>" onclick="save_value_ck<?= $detail->id_cms_section; ?>(<?= $detail->id_cms_section; ?>)" disabled="true" type="button">
                                <i class="fa-solid fa-plus"></i> Simpan
                            </button>
                        </div>
                        <textarea id="backup-text-<?= $detail->id_cms_section; ?>" class="d-none" cols="30" rows="10"><?= $description;?></textarea>
                        <textarea class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi"  name="description" id="description-<?= $detail->id_cms_section; ?>" cols="30" rows="2"><?= $description;?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var myDesc<?= $detail->id_cms_section; ?>;
ClassicEditor.create( document.querySelector( '#description-<?= $detail->id_cms_section; ?>' ), {
    toolbar: {
        items: CKEditor_tool,
        shouldNotGroupWhenFull: true
    },
    fontSize: {
        options: [
            10, 12, 14, 16, 18, 20, 24, 28, 32, 36, 40, 48
        ],
        supportAllValues: true // Mengizinkan ukuran font bebas di input
    },
    link: {
        addTargetToExternalLinks: true, // Buka tautan eksternal di tab baru
    },
    alignment: {
        options: ['left', 'center', 'right', 'justify'] // Opsi alignment yang tersedia
    },
    table: {
        contentToolbar: ["tableColumn", "tableRow", "mergeTableCells"]
    },
    fontColor: {
        colors: [
            {
                color: 'hsl(0, 0%, 0%)',
                label: 'Black'
            },
            {
                color: 'hsl(0, 75%, 60%)',
                label: 'Red'
            },
            {
                color: 'hsl(120, 75%, 60%)',
                label: 'Green'
            },
            {
                color: 'hsl(240, 75%, 60%)',
                label: 'Blue'
            },
            {
                color: 'hsl(60, 75%, 60%)',
                label: 'Yellow'
            }
        ],
        columns: 5,
        documentColors: 10,
        // Aktifkan color picker
        colorPicker: true
    },
    link: {
        addTargetToExternalLinks: true, // Add 'target="_blank"' for external links
        decorators: {
            openInNewTab: {
                mode: 'manual',
                label: 'Open in a new tab',
                attributes: {
                    target: '_blank',
                    rel: 'noopener noreferrer'
                }
            }
        }
    },
    fontBackgroundColor: {
        colors: [
            {
                color: 'hsl(0, 0%, 100%)',
                label: 'White'
            },
            {
                color: 'hsl(0, 0%, 0%)',
                label: 'Black'
            },
            {
                color: 'hsl(0, 75%, 60%)',
                label: 'Red'
            },
            {
                color: 'hsl(120, 75%, 60%)',
                label: 'Green'
            },
            {
                color: 'hsl(240, 75%, 60%)',
                label: 'Blue'
            },
            {
                color: 'hsl(60, 75%, 60%)',
                label: 'Yellow'
            }
        ]
    },
    language: "en",
    licenseKey: ''
    
} )
.then( editor<?= $detail->id_cms_section; ?> => {
    //window.editor = editor;
    myDesc<?= $detail->id_cms_section; ?> = editor<?= $detail->id_cms_section; ?>;
    editor<?= $detail->id_cms_section; ?>.model.document.on('change:data', () => {
        var valck = editor<?= $detail->id_cms_section; ?>.getData();
        var backupck = $('#backup-text-<?= $detail->id_cms_section; ?>').val();
        if (valck == '' && backupck == '') {
            $('#btn-save-ck-<?= $detail->id_cms_section; ?>').attr('disabled', true);
        }else{
            $('#btn-save-ck-<?= $detail->id_cms_section; ?>').attr('disabled', false);
        }
    });
} )
.catch( error => {
    console.error( 'Oops, something went wrong!' );
    console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
    console.warn( 'Build id: vd7qnogyyu6n-nohdljl880ze' );
    console.error( error );
} );


function save_value_ck<?= $detail->id_cms_section; ?>(id){
    const b = myDesc<?= $detail->id_cms_section; ?>;
    const obj = {}; 
    obj['description'] = b.getData(); // Dengan bracket notation

    save_perangkat_section(obj,id,'text');
    $('#backup-text-'+id).val(b.getData());
    $('#btn-save-ck-'+id).attr('disabled',true);
}

</script>