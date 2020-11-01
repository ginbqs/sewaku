<form role="form" id="create"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="input_name">Nama</label>
          <input type="text" class="form-control" id="input_name" placeholder="Nama" name="input_name">
          <span id="error_input_name" class="error invalid-feedback"></span>
        </div>
        <div class="form-group">
          <label for="input_email">Email</label>
          <input type="email" class="form-control" id="input_email" placeholder="Email" name="input_email">
          <span id="error_input_email" class="error invalid-feedback"></span>
        </div>
        <div class="form-group">
          <label for="input_phone_number">No HP</label>
          <input type="text" class="form-control" id="input_phone_number" placeholder="No HP" name="input_phone_number">
          <span id="error_input_phone_number" class="error invalid-feedback"></span>
        </div>
        <div class="form-group">
          <label for="input_password">Password</label>
          <input type="password" class="form-control" id="input_password" placeholder="Password" name="input_password">
          <span id="error_input_password" class="error invalid-feedback"></span>
        </div>
        <div class="form-group">
          <label for="input_level">Level</label><br>
          <div class="row">
            <div class="col-md-10">
              <input type="text" class="form-control" id="input_level" placeholder="Pilih Level" name="input_level" autocomplete="off">
              <input type="hidden" id='input_level_id' name="input_level_id" readonly class="form-control" >
              <span id="error_input_level" class="error invalid-feedback"></span>
            </div>
            <div class="col-md-2" style="padding-top: 3px">
              <a href="{{ URL :: to('/admin_bqs/level') }}" target="_blank">
              <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="input_kota">Provinsi</label>
          <input type="text" class="form-control" id="input_provinsi" placeholder="Provinsi" name="input_provinsi">
          <span id="error_input_provinsi" class="error invalid-feedback"></span>
          <input type="hidden" id='input_provinsi_id' name="input_provinsi_id" readonly class="form-control" >
        </div>
        <div class="form-group">
          <label for="input_kota">Kota</label>
          <input type="text" class="form-control" id="input_kota" placeholder="Kota" name="input_kota">
          <span id="error_input_kota" class="error invalid-feedback"></span>
          <input type="hidden" id='input_kota_id' name="input_kota_id" readonly class="form-control" >
        </div>
        <div class="form-group">
          <label for="input_kecamatan">Kecamatan</label>
          <input type="text" class="form-control" id="input_kecamatan" placeholder="Kota" name="input_kecamatan">
          <span id="error_input_kecamatan" class="error invalid-feedback"></span>
          <input type="hidden" id='input_kecamatan_id' name="input_kecamatan_id" readonly class="form-control" >
        </div>
        <div class="form-group">
          <label for="input_desa">Desa</label>
          <input type="text" class="form-control" id="input_desa" placeholder="Desa" name="input_desa" autocomplete="off">
          <span id="error_input_desa" class="error invalid-feedback"></span>
          <input type="hidden" id='input_desa_id' name="input_desa_id" readonly class="form-control" >
        </div>
        <div class="form-group">
          <label for="input_username">Alamat</label>
          <textarea class="form-control" id="input_alamat" placeholder="Alamat" name="input_alamat" rows="5"></textarea>
          <span id="error_input_alamat" class="error invalid-feedback"></span>
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
<style type="text/css">
  .capitalize {
    text-transform: uppercase;
  }
</style>
<script type="text/javascript">
$(document).ready(function () {
  $('#create').validate({
    submitHandler: function (form) {

        var myData = new FormData($("#create")[0]);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        myData.append('_token', CSRF_TOKEN);

        $.ajax({
            url: 'users',
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
$("#input_provinsi").keyup(function(){
    if($("#input_provinsi" ).val()==''){
        $("#input_provinsi_id").val('');
        $("#input_kota").val('');
        $("#input_kota_id").val('');
        $("#input_kecamatan").val('');
        $("#input_kecamatan_id").val('');
        $("#input_desa").val('');
        $("#input_desa_id").val('');
    }
});
$("#input_kota").keyup(function(){
    if($("#input_kota" ).val()==''){
        $("#input_kota_id").val('');
        $("#input_kecamatan").val('');
        $("#input_kecamatan_id").val('');
        $("#input_desa").val('');
        $("#input_desa_id").val('');
    }
});
$("#input_kecamatan").keyup(function(){
    if($("#input_kecamatan" ).val()==''){
        $("#input_kecamatan_id").val('');
        $("#input_desa").val('');
        $("#input_desa_id").val('');
    }
});
$("#input_level" ).keyup(function(){
    if($("#input_level" ).val()==''){
        $("#input_level").val('');
        $("#input_level_id").val('');
    }
});
$( function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#input_provinsi" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url:"{{route('admin.autocompleteProvinsi.provinsi')}}",
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
         $('#input_provinsi').val(ui.item.label); // display the selected text
         $('#input_provinsi_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li style='padding-left:10px;'>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
        .appendTo( ul );
    }
    $("#input_kota" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url:"{{route('admin.autocompleteKota.kota')}}",
          type: 'post',
          dataType: "json",
          data: {
             _token: CSRF_TOKEN,
             search: request.term,
             provinsi_id: $("#input_provinsi_id").val(),
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
         $('#input_kota').val(ui.item.label); // display the selected text
         $('#input_kota_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li style='padding-left:10px;'>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
        .appendTo( ul );
    };
    $("#input_kecamatan" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url:"{{route('admin.autocompleteKecamatan.kecamatan')}}",
          type: 'post',
          dataType: "json",
          data: {
             _token: CSRF_TOKEN,
             search: request.term,
             provinsi_id: $("#input_provinsi_id").val(),
             kota_id: $("#input_kota_id").val(),

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
         $('#input_kecamatan').val(ui.item.label); // display the selected text
         $('#input_kecamatan_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li style='padding-left:10px;'>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
        .appendTo( ul );
    }
    $("#input_desa" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url:"{{route('admin.autocompleteDesa.desa')}}",
          type: 'post',
          dataType: "json",
          data: {
             _token: CSRF_TOKEN,
             search: request.term,
             provinsi_id: $("#input_provinsi_id").val(),
             kota_id: $("#input_kota_id").val(),
             kecamatan_id: $("#input_kecamatan_id").val(),
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
         $('#input_desa').val(ui.item.label); // display the selected text
         $('#input_desa_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li style='padding-left:10px;'>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
        .appendTo( ul );
    }

    $("#input_level" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url:"{{route('admin.autocompleteLevel.level')}}",
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
         $('#input_level').val(ui.item.label); // display the selected text
         $('#input_level_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li style='padding-left:10px;'>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label  )
        .appendTo( ul );
    }
    
});
</script>