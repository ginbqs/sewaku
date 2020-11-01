<form role="form" id="create"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  <div class="card-body">
    <div class="row" style="padding-top: 10px">
      <div class="col-md-4">
        <img src="{{ asset('lte/dist/img/imageDefault.png') }}" class="product-image" alt="Product Image"  style="height: 220px">
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <label for="input_nama">Nama Barang</label>
          <input type="text" name="input_nama" id="input_nama" placeholder="Nama Barang" class="form-control">
          <span id="error_input_nama" class="error invalid-feedback"></span>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="input_foto_dasar">Foto Dasar</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" id="input_foto_dasar" name="input_foto_dasar">
                  <span id="error_input_foto_dasar" class="error invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="input_jenis">Jenis</label>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_jenis" placeholder="Pilih Jenis" name="input_jenis" autocomplete="off">
                  <span id="error_input_jenis" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_jenis_id' name="input_jenis_id" readonly class="form-control" >
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/jenis_produk') }}" target="_blank">
                  <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                  </a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="input_tema">Tema</label>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_tema" placeholder="Pilih Tema" name="input_tema" autocomplete="off">
                  <span id="error_input_tema" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_tema_id' name="input_tema_id" readonly class="form-control" >
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/tema') }}" target="_blank">
                  <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                  </a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="input_judul">Judul</label>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_judul" placeholder="Pilih Judul" name="input_judul" autocomplete="off">
                  <span id="error_input_judul" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_judul_id' name="input_judul_id" readonly class="form-control" >
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/judul') }}" target="_blank">
                  <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="input_barcode">Barcode</label>
              <input type="text" name="input_barcode" id="input_barcode" placeholder="Barcode" class="form-control" readonly>
              <span id="error_input_barcode" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_deskripsi">Deskripsi</label>
              <textarea name="input_deskripsi" id="input_deskripsi"  class="form-control" placeholder="Deskripsi" rows="9"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
    </div>
  </div>
  <!-- /.card-body -->

  <div class="card-footer">
    <button type="submit" class="btn btn-success">Simpan</button>
    <button type="button" class="btn btn-default"
            data-dismiss="modal">
        Close
    </button>
  </div>
</form>
<script type="text/javascript">
$(document).ready(function () {
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  });
  $('#create').validate({
    submitHandler: function (form) {

        var myData = new FormData($("#create")[0]);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        myData.append('_token', CSRF_TOKEN);

        $.ajax({
            url: 'desa',
            type: 'POST',
            data: myData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#submit").prop('disabled', true); // disable button
                $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
                $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
            },
            success: function (data) {
                if (data.type === 'success') {
                    reload_table();
                    notify_view(data.type, data.message);
                    $("#modal-overlay").removeClass();
                    $("#modal-overlay-content").removeClass();
                    $("#submit").prop('disabled', false); // disable button
                    $('#myModal').modal('hide'); // hide bootstrap modal

                } else if (data.type === 'error') {
                    if (data.errors) {
                        $.each(data.errors, function (key, val) {
                            $('#error_' + key).html(val);
                            $("#"+key).addClass('is-invalid');
                        });
                    }
                    $("#status").html(data.message);
                    $("#modal-overlay").removeClass();
                    $("#modal-overlay-content").removeClass();
                    $("#submit").prop('disabled', false); // disable button

                }

            },
            error: function (result) {
              $("#status").html(data.message);
              $("#modal-overlay").removeClass();
              $("#modal-overlay-content").removeClass();
              $("#submit").prop('disabled', false); // disable button
              Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
              })
            }
        });
    }
  });
});
function barcode(code){
  let barcode = $("#input_barcode").val();
  barcode = barcode+'-'+code;
  $("#input_barcode").val(barcode);
}
</script>