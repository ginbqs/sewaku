<form role="form" id="edit"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  {{method_field('PATCH')}}
  <div class="card-body">

    <div class="row" style="padding-top: 10px">
      <div class="col-md-4">
        <img src="@if($produk->gambar!='' ) {{asset($produk->gambar)}} @else {{asset('admin/dist/img/imageDefault.jpg')}} @endif" class="product-image" alt="Product Image"  style="height: 220px">
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <h4 for="input_nama">
            {{$produk->nama}}
          </h4>
        </div>
        <div class="row">
          <label class="col-6">Kategori</label>
          <label class="col-6">: {{$produk->kategori}}</label>
        </div>
        <div class="row">
          <label class="col-6">Stok</label>
          <label class="col-6">: {{$produk->jumlah}}</label>
        </div>
      </div>
    </div>
    <div class="row" id="form_add_kasir">
      <label class="col-sm-12" style="text-align: center;"> <span style="font-size: 20px">Jumlah Sewa: </span> </label>
      <div class="col-sm-2">
        <button class="btn btn-danger btn-block" id="minus_input_jumlah_beli_produk_{{$produk->id}}" type="button"><span style="font-size: 25px;font-weight: bold;">-</span></button>
      </div>
      <div class="col-sm-8">
        <input type="number" name="input_jumlah_beli_produk_{{$produk->id}}" id="input_jumlah_beli_produk_{{$produk->id}}" step="any" class="form-control" style="height: 50px" value="0">
      </div>
      <div class="col-sm-2">
        <button class="btn btn-success  btn-block" id="add_input_jumlah_beli_produk_{{$produk->id}}" type="button"><span style="font-size: 25px;font-weight: bold;">+</span></button>
      </div>
      <div class="col-md-12">
        <label class="col-sm-12" style="text-align: center;"> <span style="font-size: 15px">Keterangan : </span> </label>
        <textarea name="input_keterangan_detail" id="input_keterangan_detail" placeholder="Keterangan" class="form-control" rows="3"></textarea>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</form>

<div class="card-footer" id="action_form_kasir">
    <button type="button" class="btn btn-success btn-block col-md-12" id="btn_add_kasir_save"><span style="font-size: 20px">Simpan</span></button>
    <button type="button" class="btn btn-default btn-block col-md-12" id="btn_add_kasir_cancel" data-dismiss="modal"><span style="font-size: 20px">Cancel</span></button>
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
  $("#btn_add_kasir_save").click(function(){
    var base_url = "{!! url('/') !!}";
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var myDataDetail = new FormData();
    myDataDetail.append('_token', CSRF_TOKEN);
    myDataDetail.append('trans_stok_id', "{{$kasir->trans_stok_id}}");
    myDataDetail.append('input_detail_action', 'add');
    myDataDetail.append('input_keterangan', $("#input_keterangan_detail").val());
    myDataDetail.append('input_nama_barang', "{{$produk->nama}}");
    let number = 0;
    $("input[name^='input_jumlah_beli_produk_']" ).each(function(){
      number = parseInt(number) + parseInt($(this).val());
      if(parseInt($(this).val()) > 0){
        myDataDetail.append($(this).attr('id'), $(this).val());
      }
    });
    if(number < 1){
      Swal.fire({
        icon: 'info',
        title: 'Silahkan Input Jumlah Stok Opname'
      })
      return false;
    }
    $.ajax({
      url: base_url+'/bqs_template/kasir/createKasirDetail',
      type: 'POST',
      data: myDataDetail,
      dataType: 'json',
      cache: false,
      processData: false,
      contentType: false,
      beforeSend: function () {
          $("#btn_add_kasir_save").prop('disabled', true); // disable button
      },
      success: function (data) {
          if (data.type === 'success') {
              notify_view(data.type, data.message);
              $("#btn_add_varian").show();
              $("#form_variant_id").hide('slow');
              $("#btn_save_varian").hide();
              $("#btn_cancel_varian").hide();
              $("#btn_add_kasir_save").prop('disabled', false); // disable button
              $('#myModal').modal('hide'); // hide bootstrap modal
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
              $("#btn_add_kasir_save").prop('disabled', false); // disable button
          }
      },
      error: function (result) {
        $("#btn_add_kasir_save").prop('disabled', false); // disable button
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
    });
  });
});
$("#minus_input_jumlah_beli_produk_{{$produk->id}}").click(function(){
    let oldValue = $("#input_jumlah_beli_produk_{{$produk->id}}").val();
    if(parseInt(oldValue) - 1 < 0){
      $("#input_jumlah_beli_produk_{{$produk->id}}").val(0)
    }else{
      let newValue = parseInt(oldValue)-1;
      $("#input_jumlah_beli_produk_{{$produk->id}}").val(newValue);
    }
  });
  $('#add_input_jumlah_beli_produk_{{$produk->id}}').click(function() {
    let oldValue = $("#input_jumlah_beli_produk_{{$produk->id}}").val();
    let newValue = parseInt(oldValue)+1;
    $("#input_jumlah_beli_produk_{{$produk->id}}").val(newValue);
  });
</script>