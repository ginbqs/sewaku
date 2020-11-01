<form role="form" id="edit"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  {{method_field('PATCH')}}
  <div class="card-body">
    <div class="form-group">
      <label for="input_level">Level</label>
      <input type="text" class="form-control" id="input_level" placeholder="Level" name="input_level" value="{{$level->level}}">
      <span id="error_input_level" class="error invalid-feedback"></span>
    </div>
    <div class="form-group">
      <label for="input_value">Nama</label>
      <input type="text" class="form-control capitalize" id="input_value" placeholder="Nama" name="input_value" value="{{$level->value}}">
      <span id="error_input_value" class="error invalid-feedback"></span>
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
  $('#edit').validate({
    submitHandler: function (form) {

        var myData = new FormData($("#edit")[0]);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        myData.append('_token', CSRF_TOKEN);

        $.ajax({
            url: 'level/{{$level->level}}',
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