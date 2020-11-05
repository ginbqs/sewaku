<form role="form" id="create"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  <div class="card-body">
    <div class="row" style="padding-top: 10px">
      <div class="col-md-4">
        <img src="{{ asset('lte/dist/img/imageDefault.png') }}" class="product-image" alt="Product Image"  style="height: 220px">
        <div class="form-group" style="padding-top: 25px"></div>
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
              <label for="input_gambar">Foto Dasar</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" id="input_gambar" name="input_gambar">
                  <span id="error_input_gambar" class="error invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="input_kategori">Kategori</label>
              <input type="text" class="form-control" id="input_kategori" placeholder="Kategori" name="input_kategori" autocomplete="off">
              <span id="error_input_kategori" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_penulis">Penulis</label>
              <input type="text" class="form-control" id="input_penulis" placeholder="Penulis" name="input_penulis" autocomplete="off">
              <span id="error_input_penulis" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_penerbit">Penerbit</label>
              <input type="text" class="form-control" id="input_penerbit" placeholder="Penerbit" name="input_penerbit" autocomplete="off">
              <span id="error_input_penerbit" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_tahun_terbit">Tahun Terbit</label>
              <input type="number" class="form-control" id="input_tahun_terbit" placeholder="Pilih Tahun Terbit" name="input_tahun_terbit" autocomplete="off">
              <span id="error_input_tahun_terbit" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_isbn">ISBN</label><br>
              <input type="text" class="form-control" id="input_isbn" placeholder="ISBN" name="input_isbn" autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="input_halaman">Halaman</label>
              <input type="number" name="input_halaman" id="input_halaman" placeholder="Halaman" class="form-control">
            </div>
            <div class="form-group">
              <label for="input_jumlah">Stok</label>
              <input type="number" name="input_jumlah" id="input_jumlah" placeholder="Jumlah" class="form-control">
              <span id="error_input_jumlah" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_sinopsis" style="padding-bottom: 5px">Sinopsis</label>
              <textarea name="input_sinopsis" id="input_sinopsis" class="form-control" rows="4"></textarea>
              <span id="error_input_sinopsis" class="error invalid-feedback"></span>
            </div>
            <div class="form-group"  style="padding-top: 5px">
              <label for="input_nama_rak">Nama Rak</label>
              <input type="text" name="input_nama_rak" id="input_nama_rak" placeholder="Nama Rak" class="form-control">
              <span id="error_input_nama_rak" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_lokasi_rak"  style="padding-bottom: 5px">Lokasi Rak</label>
              <input type="text" name="input_lokasi_rak" id="input_lokasi_rak" placeholder="Lokasi Rak" class="form-control">
              <span id="error_input_lokasi_rak" class="error invalid-feedback"></span>
            </div>
          </div>
        </div>
      </div>
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
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $("#input_kategori" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteBarang.barang')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term,
           table:'kategori'
        },
        success: function( data ) {
           response( data );
        },
        error: function (result) {
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
          })
        }
      });
    },
    select: function (event, ui) {
       // Set selection
       $('#input_kategori').val(ui.item.label); // display the selected text
       $('#input_kategori_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(item.label)
      .appendTo( ul );
  };
  $('#create').validate({
    submitHandler: function (form) {
        var myData = new FormData($("#create")[0]);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        myData.append('_token', CSRF_TOKEN);

        $.ajax({
            url: 'barang',
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
              $("#modal-overlay").removeClass();
              $("#modal-overlay-content").removeClass();
              Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
              })
            }
        });
    }
  });
});
</script>