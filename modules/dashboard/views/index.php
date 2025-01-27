<style>
/* Styling untuk peta */
    #display_map {
        height: 300px !important;
        width: 100% !important;
        margin : 0px 15px;
    }

</style>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
<!--begin::Container-->
<div class="container-xxl" id="form_ubah_web_profile">
    <!--begin::Basic primary-->
    <div class="w-100 card mb-5 mt-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0 d-flex justify-content-center align-items-start w-100 flex-column py-3 px-2">
                <h3 class="fw-bold m-0">Dashboard</h3>
                <p class="text-muted fs-5">List pendaftaran member tahfidz Quran</p>
            </div>
            <!--end::Card title-->
            
            
        </div>

        <div class="card-body py-3" id="base_table">
            <!--begin::Table container-->
            <form action="<?= base_url('setting_function/drag') ?>" method="POST" class="table-responsive" id="reload_table">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted">
                            <th class="w-25px">No</th>
                            <th class="min-w-200px">Data User</th>
                            <th class="min-w-150px">Kontak</th>
                            <th class="min-w-100px text-center">Aksi</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>

                        <?php if ($result) : ?>
                            <?php $no = ($offset + 1); foreach ($result as $row) : $num = $no++;?>
                                <tr>
                                    <td><?= $num ?>.</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol me-5 background-partisi" style="width : 45px;height:45px;background-image : url('<?= image_check($row->image, 'user','user') ?>')"></div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <a class="text-dark fw-bold text-hover-primary fs-6"><?= ifnull($row->name, 'Dalam proses...') ?></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($row->email || $row->phone) : ?>
                                            <div class="d-flex justify-content-start flex-column">
                                                <?php if ($row->email) : ?>

                                                    <span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-envelope" style="margin-right : 10px;"></i><?= $row->email; ?> </span>
                                                <?php endif; ?>
                                                <?php if ($row->phone) : ?>

                                                    <span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-phone" style="margin-right : 10px;"></i><?= $row->phone; ?> </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php else : ?>
                                            <span class="text-dark fw-bold text-hover-primary d-block fs-6"> - </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center flex-shrink-0">
                                            <button type="button" onclick="approval_member(<?= $row->id_user ?>,'Y')" class="btn btn-icon btn-primary btn-sm me-1" title="Edit data">
                                                <i class="fa-solid fa-check fs-2"></i>
                                            </button>
                                            <button type="button" onclick="approval_member(<?= $row->id_user ?>,'N')" title="Tolak Membar" class="btn btn-icon btn-danger btn-sm">
                                                <i class="fa-solid fa-x fs-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <?php 
                                    $nobase = 4;
                                ?>
                                <td colspan="<?= $nobase; ?>">
                                    <center>Data Tidak Ditemukan</center>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
                <?= $this->pagination->create_links(); ?>
            </form>
            <!--end::Table container-->
        </div>
    </div>
    

</div>
</div>


<script>
    function approval_member(id, status) {
    var msg = '';
    if (status == 'Y') {
        msg = 'Anda yakin akan menyetujui pendaftaran ini ?';
    }else{
        msg = 'Anda yakin akan menolak pendaftaran ini ?';
    }
    Swal.fire({
        html: msg,
        icon: 'warning',
        showCancelButton: true,
        buttonsStyling: !1,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: css_btn_confirm,
            cancelButton: css_btn_cancel
        },
        reverseButtons: true
    }).then((function (t) {
        if (t.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'dashboard_function/approval',
                method: 'POST',
                data: { id: id,status : status },
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    showLoading('Tunggu sebentar...');
                },
                success: function (data) {
                    // console.log(data);
                    if (data.status == 200 || data.status == true) {
                        if (data.alert) {
                            sessionStorage.setItem('isReload', 'true');
                            sessionStorage.setItem('alert_icon', 'success');
                            sessionStorage.setItem('alert_message', data.alert.message);
                            custom_reload();
                        }
                        
                    } else {
                        Swal.fire({
                            html: data.alert.message,
                            icon: 'warning',
                            buttonsStyling: !1,
                            confirmButtonText: 'Lanjutkan',
                            customClass: { confirmButton: css_btn_confirm }
                        });
                    }
                }
            })
        }
    }))
}
</script>