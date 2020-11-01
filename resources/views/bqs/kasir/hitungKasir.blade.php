<form role="form" id="tutupKasir"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  <div class="card-body">

    <div class="row" style="padding-top: 10px">
      <div class="col-md-12">
        <div class="row">
          <label class="col-6">Saldo Awal</label>
          <label class="col-12"><input type="number" name="input_saldo_awal" id="input_saldo_awal" step="any" class="form-control" style="height: 40px" value="{{$kasirBuka->nilai_awal}}" readonly=""></label>
        </div>
        <div class="row">
          <label class="col-6">Saldo Akhir</label>
          <label class="col-12"><input type="number" name="input_saldo_akhir" id="input_saldo_akhir" step="any" class="form-control" style="height: 40px" value="{{$kasir->total_nilai_terjual}}" readonly=""></label>
        </div>
        <div class="row">
          <label class="col-6">Saldo Hitung Manual</label>
          <label class="col-12"><input type="number" name="input_saldo_manual" id="input_saldo_manual" step="any" class="form-control" style="height: 40px" value="{{$kasir->total_nilai_terjual}}"></label>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="card-footer" id="action_form_pengeluaran">
      <button type="submit" class="btn btn-success btn-block col-md-12"><span style="font-size: 20px">Tutup Kasir</span></button>
      <button type="button" class="btn btn-default btn-block col-md-12" data-dismiss="modal"><span style="font-size: 20px">Cancel</span></button>
  </div>
</form>

<style type="text/css">
.modal-content {
  max-height: 90%;
  border-radius: 0;
}
.modal-body{
  overflow-y: auto;
}
</style>
<script type="text/javascript">
$(document).ready(function () {
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $('#tutupKasir').validate({
    submitHandler: function (form) {
      var myData = new FormData($("#tutupKasir")[0]);
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      myData.append('_token', CSRF_TOKEN);
      
      Swal.fire({
        title: 'Apakah kamu yakin menutup jadwal kasir hari ini?',
        text: "Data tidak bisa dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Tutup!'
      }).then((result) => {
        if (result.value) {
         $.ajax({
            url: 'tutupKasir',
            type: 'POST',
            data: myData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#submit").prop('disabled', true); // disable button
            },
            success: function (data) {
                if (data.type === 'success') {
                    notify_view(data.type, data.message);
                    $("#submit").prop('disabled', false); // disable button
                    $('#myModal').modal('hide'); // hide bootstrap modal
                } else if (data.type === 'error') {
                    if (data.errors) {
                        $.each(data.errors, function (key, val) {
                            $('#error_' + key).html(val);
                            $("#"+key).addClass('is-invalid');
                        });
                    }
                    $("#submit").prop('disabled', false); // disable button
                }
                cekKasirAbsen();
            },
            error: function (result) {
              Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
              })
            }
        });
        }
      })
    }
  });
});
</script>