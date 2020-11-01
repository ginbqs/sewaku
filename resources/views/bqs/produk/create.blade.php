<form role="form" id="create"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  <div class="card-body">
    <div class="row" style="padding-top: 10px">
      <div class="col-md-4">
        <img src="{{ asset('lte/dist/img/imageDefault.png') }}" class="product-image" alt="Product Image"  style="height: 220px">
        <div class="form-group" style="padding-top: 25px">
          <label for="input_deskripsi">Deskripsi</label>
          <textarea name="input_deskripsi" id="input_deskripsi"  class="form-control" placeholder="Deskripsi" rows="9"></textarea>
        </div>
        <div class="form-group">
          <label for="input_hastag">Hastag</label>
          <textarea name="input_hastag" id="input_hastag"  class="form-control" placeholder="Hastag" rows="5"></textarea>
        </div>
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
              <label for="input_foto_thumnail">Foto Thumnail</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" id="input_foto_thumnail" name="input_foto_thumnail">
                  <span id="error_input_foto_thumnail" class="error invalid-feedback"></span>
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
              <label for="input_bahan">Bahan</label>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_bahan" placeholder="Pilih Bahan" name="input_bahan" autocomplete="off">
                  <span id="error_input_bahan" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_bahan_id' name="input_bahan_id" readonly class="form-control" >
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/bahan_jenis') }}" target="_blank">
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
            <div class="form-group">
              <label for="input_is_stok">Tampilkan Stok</label><br>
              <input type="checkbox" name="input_tampilkan_stok" id="input_tampilkan_stok" data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="input_harga_beli">Harga Beli</label>
              <input type="number" name="input_harga_beli" id="input_harga_beli" placeholder="Harga Beli" class="form-control" step="any">
            </div>
            <div class="form-group">
              <label for="input_harga_jual">Harga Jual</label>
              <input type="number" name="input_harga_jual" id="input_harga_jual" placeholder="Harga Jual" class="form-control" step="any">
              <span id="error_input_harga_jual" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_gratis_ongkir" style="padding-bottom: 5px">Gratis Ongkir</label><br>
              <input type="checkbox" name="input_gratis_ongkir" id="input_gratis_ongkir" data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
            <div class="form-group"  style="padding-top: 5px">
              <label for="input_diskon">Diskon</label>
              <input type="number" name="input_diskon" id="input_diskon" placeholder="Diskon" class="form-control" step="any">
              <span id="error_input_diskon" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_tampilkan_harga_detail"  style="padding-bottom: 5px">Tampilkan Harga Detail</label><br>
              <input type="checkbox" name="input_tampilkan_harga_detail" id="input_tampilkan_harga_detail" data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
            <div class="form-group">
              <label for="input_toko_sumber"  style="padding-top: 5px">Sumber Toko</label><br>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_toko_sumber" placeholder="Pilih Toko" name="input_toko_sumber" autocomplete="off">
                  <span id="error_input_toko_sumber" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_toko_sumber_id' name="input_toko_sumber_id" readonly class="form-control" >
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/sumber_toko') }}" target="_blank">
                  <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6" id="dt_input_stok">
            <div class="form-group">
              <label for="input_stok">Stok</label>
              <input type="number" name="input_stok" id="input_stok" placeholder="Stok" class="form-control" step="any">
              <span id="error_input_stok" class="error invalid-feedback"></span>
            </div>
          </div>
          <div class="col-md-6" id="dt_input_satuan">
            <div class="form-group">
              <label for="input_satuan">Satuan</label>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_satuan" placeholder="Pilih Satuan" name="input_satuan" autocomplete="off">
                  <span id="error_input_satuan" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_satuan_id' name="input_satuan_id" readonly class="form-control" >
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/satuan') }}" target="_blank">
                  <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6" id="dt_input_stok">
            <div class="form-group">
              <label for="input_is_stok">Status Confirm</label><br>
              <input type="checkbox" name="input_status_confirm" id="input_status_confirm"  checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
          </div>
          <div class="col-md-6" id="dt_input_satuan">
            <div class="form-group">
              <label for="input_satuan">Owner</label>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_owner" placeholder="Owner" name="input_owner" autocomplete="off" >
                  <span id="error_input_owner" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_owner_id' name="input_owner_id" readonly class="form-control">
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/users') }}" target="_blank">
                  <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <br>
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
  $("#input_jenis").change(function(){
    if($(this).val()==''){
      $("#input_bahan").val('');
      $("#input_bahan_id").val('');
      $("#input_jenis_id").val('');
    }
  })
  $("#input_jenis" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteJenis.jenis_produk')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term,
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
       $("#input_bahan").val('');
       $("#input_bahan_id").val('');
       $('#input_jenis').val(ui.item.label); // display the selected text
       $('#input_jenis_id').val(ui.item.value); // save selected id to input
       $('#input_toko_sumber').val(ui.item.mst_sumber_toko_nama); // display the selected text
       $('#input_toko_sumber_id').val(ui.item.sumber_toko_id); // save selected id to input
       $('#input_diskon').val(ui.item.diskon); // save selected id to input
       if(ui.item.status_gratis_ongkir=='1'){
        $("#input_gratis_ongkir").bootstrapSwitch('state', true);
       }else{
        $("#input_gratis_ongkir").bootstrapSwitch('state', false);
       }
       if(ui.item.status_tampil_harga_detail=='1'){
        $("#input_tampilkan_harga_detail").bootstrapSwitch('state', true);
       }else{
        $("#input_tampilkan_harga_detail").bootstrapSwitch('state', false);
       }
       if(ui.item.status_tampil_stok=='1'){
        $("#input_tampilkan_stok").bootstrapSwitch('state', true);
       }else{
        $("#input_tampilkan_stok").bootstrapSwitch('state', false);
       }
       
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(item.label)
      .appendTo( ul );
  };
  $("#input_bahan" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteBahan_jenis.bahan_jenis')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term,
           jenis_id: $("#input_jenis_id").val(),
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
       $('#input_bahan').val(ui.item.label); // display the selected text
       $('#input_bahan_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(item.label)
      .appendTo( ul );
  };
  $("#input_tema").change(function(){
    if($(this).val()==''){
      $("#input_judul").val('');
      $("#input_judul_id").val('');
      $("#input_tema_id").val('');
    }
  });
  $("#input_tema" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteTema.tema')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term
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
       $("#input_judul").val('');
       $("#input_judul_id").val('');
       $('#input_tema').val(ui.item.label); // display the selected text
       $('#input_tema_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(item.label)
      .appendTo( ul );
  };
  $("#input_judul" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteJudul.judul')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term
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
       $('#input_judul').val(ui.item.label); // display the selected text
       $('#input_judul_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(item.label)
      .appendTo( ul );
  };
  $("#input_toko_sumber" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteSumberToko.sumber_toko')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term,
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
       $('#input_toko_sumber').val(ui.item.label); // display the selected text
       $('#input_toko_sumber_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Alamat : " + item.deskripsi+ "</span>" )
      .appendTo( ul );
  };
  $("#input_satuan" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteSatuan.satuan')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term,
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
       $('#input_satuan').val(ui.item.label); // display the selected text
       $('#input_satuan_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(item.label)
      .appendTo( ul );
  };
  $("#input_owner" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteUsers.users')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term,
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
       $('#input_owner').val(ui.item.label); // display the selected text
       $('#input_owner_id').val(ui.item.value); // save selected id to input
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
            url: 'produk',
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
  $("#input_tampilkan_stok").click(function(){
    if ($('#input_tampilkan_stok').prop('checked')) {
      $("#dt_input_stok").show();
      $("#dt_input_satuan").show();
      
    }else{
      $("#dt_input_stok").hide();
      $("#dt_input_satuan").hide();
    }
  });
});
</script>