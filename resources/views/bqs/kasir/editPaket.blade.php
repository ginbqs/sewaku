<form role="form" id="edit"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  {{method_field('PATCH')}}
  <div class="card-body">

    <div class="row" style="padding-top: 10px">
      <div class="col-md-12">
        <div class="form-group">
          <h4 for="input_nama">
            {{$paket->keterangan}}
          </h4>
        </div>
      </div>
    </div>
    <div class="row" id="form_add_pengeluaran" style="padding-top: 20px">
      <label class="col-sm-12" style="text-align: center;"> <span style="font-size: 20px">Jumlah Beli : </span> </label>
      <div class="col-sm-2">
        <button class="btn btn-danger btn-block" id="minus_input_jumlah_beli_paket_{{$paket->id}}" type="button"><span style="font-size: 25px;font-weight: bold;">-</span></button>
      </div>
      <div class="col-sm-8">
        <input type="number" name="input_jumlah_beli_paket_{{$paket->id}}" id="input_jumlah_beli_paket_{{$paket->id}}" step="any" class="form-control" style="height: 50px" @if(isset($paket->jumlah)) value="{{ $paket->jumlah}}" @else value="0" @endif>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-success  btn-block" id="add_input_jumlah_beli_paket_{{$paket->id}}" type="button"><span style="font-size: 25px;font-weight: bold;">+</span></button>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</form>

<div class="card-footer" id="action_form_pengeluaran">
    <button type="button" class="btn btn-success btn-block col-md-12" id="btn_add_pengeluaran_save"><span style="font-size: 20px">Simpan</span></button>
    <button type="button" class="btn btn-default btn-block col-md-12" id="btn_add_pengeluaran_cancel" data-dismiss="modal"><span style="font-size: 20px">Cancel</span></button>
</div>
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
  $("#btn_add_pengeluaran_save").click(function(){
    var base_url = "{!! url('/') !!}";
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var myDataDetail = new FormData();
    myDataDetail.append('_token', CSRF_TOKEN);
    myDataDetail.append('input_detail_action', 'add');
    myDataDetail.append('paket_id', {{$paket->id}});
    let number = 0;
    $("input[name^='input_jumlah_beli_paket_']" ).each(function(){
      @if(!isset($paket->jumlah))
      number = parseInt(number) + parseInt($(this).val());
      if(parseInt($(this).val()) > 0){
        myDataDetail.append($(this).attr('id'), $(this).val());
      }
      @else
        myDataDetail.append($(this).attr('id'), $(this).val());
      @endif
    });
    @if(!isset($paket->jumlah))
    if(number < 1){
      Swal.fire({
        icon: 'info',
        title: 'Silahkan Input Jumlah Paket'
      })
      return false;
    }
    @endif
    $.ajax({
      url: 'createPembelianPaket',
      type: 'POST',
      data: myDataDetail,
      dataType: 'json',
      cache: false,
      processData: false,
      contentType: false,
      beforeSend: function () {
          $("#btn_add_pengeluaran_save").prop('disabled', true); // disable button
      },
      success: function (data) {
          if (data.type === 'success') {
              notify_view(data.type, data.message);
              $("#btn_add_pengeluaran_save").prop('disabled', false); // disable button
              $('#myModal').modal('hide'); // hide bootstrap modal
              getKeranjang();
          } else if (data.type === 'error') {
              if (data.errors) {
                  $.each(data.errors, function (key, val) {
                      $('#error_' + key).html(val);
                      console.log("#"+key);
                      $("#"+key).addClass('is-invalid');
                  });
              }else{
                Swal.fire({
                  icon: 'error',
                  title: data.message
                })
              }
              $("#btn_add_pengeluaran_save").prop('disabled', false); // disable button
          }
          reload_keranjang_table();
      },
      error: function (result) {
        $("#btn_add_pengeluaran_save").prop('disabled', false); // disable button
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
    });
  });
});
$("#minus_input_jumlah_beli_paket_{{$paket->id}}").click(function(){
    let oldValue = $("#input_jumlah_beli_paket_{{$paket->id}}").val();
    if(parseInt(oldValue) - 1 < 0){
      $("#input_jumlah_beli_paket_{{$paket->id}}").val(0)
    }else{
      let newValue = parseInt(oldValue)-1;
      $("#input_jumlah_beli_paket_{{$paket->id}}").val(newValue);
    }
  });
  $('#add_input_jumlah_beli_paket_{{$paket->id}}').click(function() {
    let oldValue = $("#input_jumlah_beli_paket_{{$paket->id}}").val();
    let newValue = parseInt(oldValue)+1;
    $("#input_jumlah_beli_paket_{{$paket->id}}").val(newValue);
  });
  function addInputPengeluaran(id,type){
    let oldValue = $("#input_jumlah_beli_paket_"+id).val();
    if(type=='minus'){
      if(parseInt(oldValue) - 1 < 0){
        $("#input_jumlah_beli_paket_"+id).val(0)
      }else{
        let newValue = parseInt(oldValue)-1;
        $("#input_jumlah_beli_paket_"+id).val(newValue);
      }  
    }else{
      let oldValue = $("#input_jumlah_beli_paket_"+id).val();
      let newValue = parseInt(oldValue)+1;
      $("#input_jumlah_beli_paket_"+id).val(newValue);
    }
    
  }
</script>