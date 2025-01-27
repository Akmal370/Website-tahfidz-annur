<style>
  span.fadedin{
    margin-left : 10px; 
  }
</style>
<section id="pricing">
      <div class="wrapper image-wrapper <?php if($result->image_donasi && file_exists('./data/setting/'.$result->image_donasi)) :  ?> bg-image bg-overlay <?php endif;?>" <?php if($result->image_donasi && file_exists('./data/setting/'.$result->image_donasi)) :  ?>data-image-src="<?= image_check($result->image_donasi,'setting'); ?>" <?php endif;?>>
        <div class="container py-15 py-md-17">
          <div class="row">
            <div class="col-xl-9 mx-auto">
              <div class="card border-0 bg-white-900" style="box-shadow: 0px 1px 20px 4px #D3D3D3 !important;">
                <div class="card-body py-lg-13 px-lg-16">
                  <?php if($result->title_donasi) : ?>
                  <h2 class="display-5 mb-3 text-center"><?= $result->title_donasi; ?></h2>
                  <?php endif;?>
                  <?php if($result->text_donasi) : ?>
                  <p class="lead fs-lg text-center mb-10"><?= $result->text_donasi; ?></p>
                  <?php endif;?>
                  <form class="contact-form needs-validation" id="form_donasi" method="post" action="<?= base_url('user_function/donasi') ?>" novalidate>
                    <div class="messages"></div>
                    <div class="row gx-4">
                      <div class="col-md-6">
                        <div class="form-floating mb-4" id="req_name">
                          <input id="form_name" type="text" name="name" class="form-control bg-white-700 border-0" placeholder="Masukkan Nama Anda" required autocomplete="off">
                          <label for="form_name">Nama *</label>
                        </div>
                      </div>
                      <!-- /column -->
                      <div class="col-md-6">
                        <div class="form-floating mb-4" id="req_email">
                          <input id="form_email" type="email" name="email" class="form-control bg-white-700 border-0" placeholder="Masukkan Alamat Email" required autocomplete="off">
                          <label for="form_email">Email *</label>
                        </div>
                      </div>
                      <div class="col-md-12" >
                        <div class="form-floating mb-4" id="req_nominal">
                          <input id="form_nominal" type="text" id="tampilan_rupiah" onkeyup="matauang(this,'#rupiah')" class="form-control bg-white-700 border-0" placeholder="Masukkan Nominal Donasi" required autocomplete="off">
                            <input type="hidden" name="nominal" id="rupiah" />
                          <label for="form_nominal">Nominal Donasi *</label>
                        </div>
                      </div>

                      <!-- /column -->
                      <div class="col-12">
                        <div class="form-floating mb-4" >
                          <textarea id="form_message" name="message" class="form-control bg-white-700 border-0" placeholder="Masukkan Pesan" style="height: 150px" required></textarea>
                          <label for="form_message">Message</label>
                        </div>
                      </div>
                      <input type="hidden" name="code" id="code_transaksi">
                      <!-- /column -->
                      <div class="col-12 text-center">
                        <button type="button" id="button_donasi_asli" data-loader="big" onclick="submit_form(this,'#form_donasi')" class="d-none">Button Bayangan</button>
                        <button type="button" id="button_donasi"  onclick="payNow()" class="btn btn-primary rounded-pill btn-send">Kirim Donasi</button>
                      </div>
                      <!-- /column -->
                    </div>
                    <!-- /.row -->
                  </form>
                  <!-- /form -->
                </div>
                <!--/.card-body -->
              </div>
              <!--/.card -->
            </div>
            <!-- /column -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.wrapper -->
    </section>
    <!-- /section -->

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Ko-BQH-zjz0YaJvl"></script>
    <script>
      function payNow() {
        $('.fadedin').remove();
        var id = 'DONATE' + new Date().getTime();
        var name = $('#form_name').val();
        var email = $('#form_email').val();
        var nominal = $('#rupiah').val();
        var message = $('#form_message').val();
        $.ajax({
            url: '<?= base_url("user_function/payment") ?>',
            method: 'POST',
            data: { 
              id: id,
              name : name,
              email : email,
              nominal : nominal,
              message : message
            },
            dataType : 'json',
            beforeSend: function(){
                $('#button_donasi').prop('disabled',true);
                $('#button_donasi').html('Tunggu sebentar..');
            },
            success: function (data) {
              $('#button_donasi').prop('disabled',false);
                $('#button_donasi').html('Kirim Donasi');
              if (data.status ==200 || data.status == true) {
                  snap.pay(data.token, {
                    onSuccess: function (result) {
                      $('#code_transaksi').val(id);
                        const button = document.getElementById('button_donasi_asli');
                        button.click(); // Langsung trigger submit saat halaman dimuat
                    },
                    onPending: function (result) {
                        Swal.fire({
                              html: 'Pembayaran di pendding',
                              icon: 'warning',
                              buttonsStyling: !1,
                              confirmButtonText: 'Lanjutkan',
                              customClass: {
                                  confirmButton: css_btn_confirm
                              }
                          })
                        console.log(result);
                    },
                    onError: function (result) {
                        Swal.fire({
                              html: 'Pembayaran gagal! Coba lagi nanti!',
                              icon: 'error',
                              buttonsStyling: !1,
                              confirmButtonText: 'Lanjutkan',
                              customClass: {
                                  confirmButton: css_btn_confirm
                              }
                          })
                        console.log(result);
                    }
                });
              }else{
                if (data.required) {
                    // console.log(data.required);
                    const array = data.required.length;
                    for (var i = 0; i < array; i++) {
                        $('#' + data.required[i][0]).append('<span class="text-danger size-12 fadedin">' + data.required[i][1] + '</span>');
                        // console.log(data.required[i][0]);
                    }

                }else{
                  Swal.fire({
                      html: data.alert.message,
                      icon: icon,
                      buttonsStyling: !1,
                      confirmButtonText: 'Lanjutkan',
                      customClass: {
                          confirmButton: css_btn_confirm
                      }
                  });
                }
              }
            }
        });
        
      }
    </script>