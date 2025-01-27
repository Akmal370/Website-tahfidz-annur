<style>
    .select2-container .select2-results__option img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
        vertical-align: middle;
        border-radius: 5px;
    }
</style>
<?php 
    $obj = [];
    $height = 100;
    if ($detail->data != '') {
        $obj = json_decode($detail->data);
        $height = (isset($obj->height)) ? $obj->height : 100; 
    }
    $banner = (isset($attribut['banner'][$detail->id_cms_section])) ? $attribut['banner'][$detail->id_cms_section] : [];
    $arr_check = '';
    if ($banner) {
        $arr_check = [];
        foreach ($banner as $key) {
            $arr_check[] = $key['id_banner'];
        }
        
        usort($banner, function($a, $b) {
            return $a['urutan'] <=> $b['urutan']; // Urutan menaik
        });
        $arr_check = implode('|',$arr_check);
    }
?>
<div class="card mb-3 mb-xl-8 mt-0 showin">
    <div class="card-header py-4" id="header-parent-<?= $detail->id_cms_section ?>">
        <!--begin::Card title-->
        <div class="card-title m-0 d-flex justify-content-between align-items-center flex-wrap w-100" id="header-reload-<?= $detail->id_cms_section ?>">
            <div class="d-flex justify-content-center align-items-center mb-2">
                <div class="form-check form-switch">
                    <input onchange="switching(this,event,<?= $detail->id_cms_section ?>)" data-url="<?= base_url('setting_function/switch/cms_section') ?>" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-<?= $detail->id_cms_section ?>" <?= ($detail->status == 'Y') ? 'checked': ''; ?>>
                </div>
                <h5 class="fw-bold m-0">Section <?= ucwords($detail->layout) ,' (CMS'.date('YmdHis',strtotime($detail->create_date)).$detail->id_cms_section.')'; ?></h5>
            </div>
            
            <div class="d-flex justify-content-center align-items-center mb-2">
                <button type="button" id="tambah-button-<?= $detail->id_cms_section ?>" onclick="tambah_cms_banner(<?= $detail->id_cms_section ?>,'CMS<?=date('YmdHis',strtotime($detail->create_date)).$detail->id_cms_section;?>','<?= $arr_check ?>')" data-bs-toggle="modal" data-bs-target="#kt_modal_cms_banner" class="btn btn-sm mx-2 btn-light-primary">
                    <i class="fa-solid fa-plus fs-2"></i>
                    Tambah
                </button>
            </div>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body d-flex justify-content-center align-items-center flex-column w-100">
        <table class="table table_banner w-100" id="parent-banner-<?= $detail->id_cms_section; ?>">
            <tbody class="fw-row d-flex flex-wrap justify-content-center align-items-center">
                <?php if($banner) : ?>
                    <?php $no = 1; foreach($banner AS $row) : $num = $no++;?> 
                    <tr id="parent-display-banner-<?= $detail->id_cms_section; ?>-<?= $num; ?>" data-id="<?= $row['id_cms_banner']; ?>" class="px-4 py-2 cursor-move" draggable="true">
                        <td>
                            <div class="shadow d-flex justify-content-center align-items-center flex-column position-relative overflow-hidden">
                                <div class="background-partisi d-flex justify-content-center align-items-center flex-column" style="width : 100%;height:150px;background-image: linear-gradient(rgb(212 43 36 / 63%), rgb(0 0 0 / 36%)),url('<?= image_check($row['file'],'banner') ?>');">
                                    <h4 class="text-white text-center" style="font-size : 8px;width : 90%;"><?= $row['title']; ?></h4>
                                    <p class="text-white text-center" style="font-size : 6px;width : 90%;"><?= $row['description']; ?></p>
                                    <?php if($row['button'] == 'Y') : ?>
                                    <button class="btn btn-sm btn-warning" style="min-width : 20px;min-height : 10px;font-size : 8px"><?= $row['button_name']; ?></button>
                                    <?php endif; ?>
                                </div>
                                <div class="action-cms-banner">
                                    <button type="button" onclick="detail_banner(<?= $row['id_banner']; ?>, 'CMS<?=date('YmdHis',strtotime($detail->create_date)).$detail->id_cms_section;?>',<?= $detail->id_cms_section; ?>)" data-bs-toggle="modal" data-bs-target="#kt_modal_detail_banner" title="Lihat data" class="btn btn-info btn-icon btn-sm mx-1">
                                        <i class="fa-solid fa-info fs-2"></i>
                                    </button>
                                    <button type="button" title="Edit data" onclick="ubah_banner(<?= $row['id_banner'] ?>,<?= $detail->id_cms_section ?>,'CMS<?=date('YmdHis',strtotime($detail->create_date)).$detail->id_cms_section;?>')" data-bs-toggle="modal" data-bs-target="#kt_modal_ubah_banner" class="btn btn-warning btn-icon btn-sm mx-1">
                                        <i class="ki-outline ki-pencil fs-2"></i>
                                    </button>
                                    <button type="button" onclick="hapus_data_noreload(this,<?= $row['id_cms_banner'];?>,'cms_function/hapus_banner','#parent-display-banner-<?= $detail->id_cms_section; ?>-<?= $num; ?>')" title="Hapus data" class="btn btn-danger btn-icon btn-sm mx-1">
                                        <i class="ki-outline ki-trash fs-2"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php endif;?>
            </tbody>
        </table>
        <div style="width : 80%;" class=" d-flex justify-content-center align-items-center flex-column">
            <div class="fv-row mb-7 w-100">
                <label class="required fw-semibold fs-6 mb-2">Tinggi</label>
                <select name="height" onchange="select_height(this,<?= $detail->id_cms_section; ?>)" data-prefix="tinggi banner (CMS<?=date('YmdHis',strtotime($detail->create_date)).$detail->id_cms_section;?>)" class="form-select form-select-solid mb-3" data-control="select2" data-placeholder="Pilih ukuran tinggi banner">
                    <option value="100" <?= ($height == 100) ? 'selected' : ''; ?>>100%</option>
                    <option value="80" <?= ($height == 80) ? 'selected' : ''; ?>>80%</option>
                    <option value="50" <?= ($height == 50) ? 'selected' : ''; ?>>50%</option>
                </select>
            </div>
        </div>
    </div>
</div>


<script>
    

document.querySelectorAll('#parent-banner-<?= $detail->id_cms_section; ?> tbody tr').forEach(row => {
    // Event saat drag dimulai
    row.addEventListener('dragstart', event => {
        draggedRow = row;
        row.style.opacity = '0.5';
    });

    // Event saat drag selesai
    row.addEventListener('dragend', () => {
        draggedRow.style.opacity = '1';
        draggedRow = null;

        // Memanggil fungsi untuk menyimpan urutan baru setelah drag selesai
        orderBanner();
    });

    // Event saat elemen di atas row lain
    row.addEventListener('dragover', event => {
        event.preventDefault();
        const targetRow = event.target.closest('tr');
        if (targetRow && targetRow !== draggedRow) {
            const rect = targetRow.getBoundingClientRect();
            const nextRow = (event.clientY - rect.top) > (rect.height / 2);
            targetRow.parentNode.insertBefore(draggedRow, nextRow ? targetRow.nextSibling : targetRow);
        }
    });
});

// Fungsi untuk mengirim data urutan row ke server menggunakan AJAX
function orderBanner() {
    // Ambil semua row saat ini dalam urutan baru
    const rows = document.querySelectorAll('#parent-banner-<?= $detail->id_cms_section; ?> tbody tr');
    const order = Array.from(rows).map((row, index) => ({
        id: row.getAttribute('data-id'),
        position: index + 1
    }));

     $.ajax({
        url: BASEURL + 'cms_function/sorting_banner',
        method: 'POST',
        data: { data: JSON.stringify({ order }) },
        dataType: 'json',
        success: function (data) {
            console.log(data);
        }
    })
}

</script>