<form role="form" id="edit"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  {{method_field('PATCH')}}
  <div class="card-body">

    <div class="row" style="padding-top: 10px">
      <div class="col-md-4">
        <img src="@if($produk->foto!='') {{asset('e-rung/public/'.$produk->foto)}} @else {{asset('admin/dist/img/imageDefault.jpg')}} @endif" class="product-image" alt="Product Image"  style="height: 220px">
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <h4 for="input_nama">
            {{$produk->nama}}
          </h4>
        </div>
        <div class="row">
          <label class="col-6">Tipe</label>
          <label class="col-6">: {{$produk->mst_tipe_nama}}</label>
        </div>
        <div class="row">
          <label class="col-6">Kategori</label>
          <label class="col-6">: {{$produk->mst_kategori_nama}}</label>
        </div>
        <div class="row">
          <label class="col-6">Stok</label>
          <label class="col-6">: {{$produk->stok}} {{$produk->mst_satuan_nama}}</label>
        </div>
        <div class="row">
          <label class="col-6">Stok Minimal</label>
          <label class="col-6">: {{$produk->stok_min}}  {{$produk->mst_satuan_nama}}</label>
        </div>
        <div class="row">
          <label class="col-6">Tgl Kadaluarsa</label>
          <label class="col-6">: @if($produk->is_expire=='1') {{$produk->tgl_kadaluarsa}} @else - @endif</label>
        </div>
        <div class="row" id="tampil_harga" >
          <div class="row">
            <label class="col-6">Harga Beli</label>
            <label class="col-6">: {{$produk->harga_beli}}</label>
          </div>
          <div class="row">
            <label class="col-6">Harga Jual</label>
            <label class="col-6">: {{$produk->harga_jual}}</label>
          </div>
        </div>
      </div>
    </div>
    <div class="row" id="form_add_kasir">
      <label class="col-sm-12" style="text-align: center;"> <span style="font-size: 20px">Jumlah Beli : </span> </label>
      <div class="col-sm-2">
        <button class="btn btn-danger btn-block" id="minus_input_jumlah_beli_produk_{{$produk->produk_id}}" type="button"><span style="font-size: 25px;font-weight: bold;">-</span></button>
      </div>
      <div class="col-sm-8">
        <input type="number" name="input_jumlah_beli_produk_{{$produk->produk_id}}" id="input_jumlah_beli_produk_{{$produk->produk_id}}" step="any" class="form-control" style="height: 50px" value="{{$produk->jumlah_fisik}}">
      </div>
      <div class="col-sm-2">
        <button class="btn btn-success  btn-block" id="add_input_jumlah_beli_produk_{{$produk->produk_id}}" type="button"><span style="font-size: 25px;font-weight: bold;">+</span></button>
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
    myDataDetail.append('trans_stok_id', "{{$produk->trans_stok_id}}");
    myDataDetail.append('input_detail_action', 'add');
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
        title: 'Silahkan Input Jumlah Barang'
      })
      return false;
    }
    $.ajax({
      url: base_url+'/bqs_template/kasir/updateKasirDetail/{{$produk->id}}__{{$produk->trans_stok_id}}',
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
              $("#btn_add_kasir_save").prop('disabled', false); // disable button
              $('#myModal').modal('hide'); // hide bootstrap modal
              reload_tableKasir();
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
          getNilai();
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

$("#minus_input_jumlah_beli_produk_{{$produk->produk_id}}").click(function(){
    let oldValue = $("#input_jumlah_beli_produk_{{$produk->produk_id}}").val();
    if(parseInt(oldValue) - 1 < 0){
      $("#input_jumlah_beli_produk_{{$produk->produk_id}}").val(0)
    }else{
      let newValue = parseInt(oldValue)-1;
      $("#input_jumlah_beli_produk_{{$produk->produk_id}}").val(newValue);
    }
  });
  $('#add_input_jumlah_beli_produk_{{$produk->produk_id}}').click(function() {
    let oldValue = $("#input_jumlah_beli_produk_{{$produk->produk_id}}").val();
    let newValue = parseInt(oldValue)+1;
    $("#input_jumlah_beli_produk_{{$produk->produk_id}}").val(newValue);
  });
</script>