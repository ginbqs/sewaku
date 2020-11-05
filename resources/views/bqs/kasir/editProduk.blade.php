<form role="form" id="edit"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  {{method_field('PATCH')}}
  <div class="card-body">

    <div class="row" style="padding-top: 10px">
      <div class="col-md-4">
        <img src="@if($produk->foto!='' ) {{asset('e-rung/public/'.$produk->foto)}} @else {{asset('admin/dist/img/imageDefault.jpg')}} @endif" class="product-image" alt="Product Image"  style="height: 220px">
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
            <label class="col-6">Harga Beli</label>
            <label class="col-6">: {{$produk->harga_beli}}</label>
            <label class="col-6">Harga Jual</label>
            <label class="col-6">: {{$produk->harga_jual}}</label>
        </div>
      </div>
    </div>
    <div class="row" id="form_add_kasir">
      <label class="col-sm-12" style="text-align: center;"> <span style="font-size: 20px">Jumlah Opname Fisik : </span> </label>
      <div class="col-sm-2">
        <button class="btn btn-danger btn-block" id="minus_input_jumlah_beli_produk_{{$produk->id}}" type="button"><span style="font-size: 25px;font-weight: bold;">-</span></button>
      </div>
      <div class="col-sm-8">
        <input type="number" name="input_jumlah_beli_produk_{{$produk->id}}" id="input_jumlah_beli_produk_{{$produk->id}}" step="any" class="form-control" style="height: 50px" value="{{$produk->stok}}">
      </div>
      <div class="col-sm-2">
        <button class="btn btn-success  btn-block" id="add_input_jumlah_beli_produk_{{$produk->id}}" type="button"><span style="font-size: 25px;font-weight: bold;">+</span></button>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</form>
<div class="card-footer">
  <div class="row" id="form_tambah_vairan" style="display: none">
    <div class="col-md-12">
      <button type="button" class="btn btn-primary" id="btn_add_varian"><span id="label_add_varian"></span></button>
      <button type="button" class="btn btn-success" id="btn_save_varian" style="display: none">Save Varian</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-default" id="btn_cancel_varian"  style="display: none">Cancel</button>&nbsp;&nbsp;
    </div>
  </div>
</div>
<form role="form" id="form_varian"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
<div class="col-md-12" style="display:none" id="form_variant_id">
  <div class="row" style="padding-top: 10px">
    <div class="col-md-4">
      <div class="form-group">
        <label for="input_detail_nama">Nama Varian</label>
        <input type="text" name="input_detail_nama" id="input_detail_nama" placeholder="Nama Varian" class="form-control">
        <input type="hidden" name="input_detail_action" id="input_detail_action" placeholder="Nama Varian" class="form-control" value="add">
        <input type="hidden" name="input_detail_produk_id" id="input_detail_produk_id" placeholder="ID" class="form-control" value="{{$produk->id}}">
        <input type="hidden" name="input_detail_id" id="input_detail_id" placeholder="ID" class="form-control">
        <span id="error_input_detail_nama" class="error invalid-feedback"></span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="input_detail_harga_beli">Harga Beli</label>
        <input type="number" name="input_detail_harga_beli" id="input_detail_harga_beli" placeholder="Harga Beli" class="form-control" step="any">
        <span id="error_input_detail_harga_beli" class="error invalid-feedback"></span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="input_detail_harga_jual">Harga Jual</label>
        <input type="number" name="input_detail_harga_jual" id="input_detail_harga_jual" placeholder="Harga Jual" class="form-control" step="any">
        <span id="error_input_input_detail_harga_jual" class="error invalid-feedback"></span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="input_detail_stok">Stok</label>
        <input type="number" name="input_detail_stok" id="input_detail_stok" placeholder="Stok" class="form-control" step="any">
        <span id="error_input_detail_stok" class="error invalid-feedback"></span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="input_detail_tgl_kadaluarsa">Tgl Kadaluarsa</label>
        <input type="text" name="input_detail_tgl_kadaluarsa" id="input_detail_tgl_kadaluarsa" placeholder="Tanggal Kadaluarsa" class="form-control" step="any" @if($produk->is_expire!='1') readonly @endif>
        <span id="error_input_detail_tgl_kadaluarsa" class="error invalid-feedback"></span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="input_detail_foto">Foto</label>
        <div class="input-group">
          <div class="custom-foto">
            <input type="file" id="input_detail_foto" name="input_detail_foto">
            <span id="error_input_detail_foto" class="error invalid-feedback"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
<div class="card-body">
<span id="span_varian_kasir"></span>
</div>
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
  getValidateVarian();
  $("#label_add_varian").html('Tambah Varian');
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $("#btn_save_varian").click(function(){
    var base_url = "{!! url('/') !!}";
    var myDataDetail = new FormData($("#form_varian")[0]);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    myDataDetail.append('_token', CSRF_TOKEN);
    $.ajax({
      url: base_url+'/bqs_template/produkDetail',
      type: 'POST',
      data: myDataDetail,
      dataType: 'json',
      cache: false,
      processData: false,
      contentType: false,
      beforeSend: function () {
          $("#btn_save_varian").prop('disabled', true); // disable button
      },
      success: function (data) {
          if (data.type === 'success') {
              notify_view(data.type, data.message);
              $("#btn_add_varian").show();
              $("#form_variant_id").hide('slow');
              $("#btn_save_varian").hide();
              $("#btn_cancel_varian").hide();
              $("#btn_save_varian").prop('disabled', false); // disable button
              clearForm();
              getValidateVarian();
          } else if (data.type === 'error') {
              if (data.errors) {
                  $.each(data.errors, function (key, val) {
                      $('#error_' + key).html(val);
                      console.log("#"+key);
                      $("#"+key).addClass('is-invalid');
                  });
              }
              $("#btn_save_varian").prop('disabled', false); // disable button
          }

      },
      error: function (result) {
        $("#btn_save_varian").prop('disabled', false); // disable button
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
    });
  
  });
  $("#btn_add_kasir_save").click(function(){
    var base_url = "{!! url('/') !!}";
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var myDataDetail = new FormData();
    myDataDetail.append('_token', CSRF_TOKEN);
    myDataDetail.append('trans_stok_id', "{{$kasir->trans_stok_id}}");
    myDataDetail.append('input_detail_action', 'add');
    let number = 0;
    $("input[name^='input_jumlah_beli_produk_']" ).each(function(){
      number = parseInt(number) + parseInt($(this).val());
      // if(parseInt($(this).val()) > 0){
        myDataDetail.append($(this).attr('id'), $(this).val());
      // }
    });
    // if(number < 1){
    //   Swal.fire({
    //     icon: 'info',
    //     title: 'Silahkan Input Jumlah Stok Opname'
    //   })
    //   return false;
    // }
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
              clearForm();
              $('#myModal').modal('hide'); // hide bootstrap modal
              getValidateVarian();
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
$("#btn_add_varian").click(function(){
  $("#form_variant_id").show('slow');
  $("#btn_save_varian").show();
  $("#btn_cancel_varian").show();
  $("#btn_add_varian").hide();
  $("#tampil_harga").hide();
  $("#form_add_kasir").hide();
});
$("#btn_cancel_varian").click(function(){
  $("#btn_add_varian").show();
  $("#form_variant_id").hide('slow');
  $("#btn_save_varian").hide();
  $("#btn_cancel_varian").hide();
  getValidateVarian();
  clearForm();
});
function clearForm(){
  $('#input_detail_nama').val('');
  $('#input_detail_stok').val('');
  $('#input_detail_harga_jual').val('');
  $('#input_detail_harga_beli').val('');
  $('#input_detail_foto').val('');
}
function getValidateVarian(){
  var base_url = "{!! url('/') !!}";
  $.ajax({
      url: base_url+'/bqs_template/kasir/getValidateVarian/{{$produk->id}}',
      type: 'get',
      success: function (data) {
        let res = JSON.parse(data);
        if(!res.has_history){
          $("#form_tambah_vairan").show();
        }
        let dt_child = res.child;
        $("#span_varian_kasir").html('');
        if(dt_child.length > 0){
          $("#tampil_harga").hide();
          $("#form_add_kasir").hide();
          $("#action_form_kasir").show();

          var html = '';
          $.each(dt_child, function(i, item) {
          html += '<div class="row" style="border:1px solid black;margin-bottom:10px;padding:10px">';
            html +='<div class="col-sm-4">';
              html += '<div class="row">';            
                html +='<div class="col-sm-12">';
                  html +='<h4>'+item.nama+'</h4>';
                html +='</div>';
              html +='</div>';

              html += '<div class="row">';            
                html +='<div class="col-5">';
                  html +='<label>Stok</label>';
                html +='</div>';
                html +='<div class="col-7">';
                  html +='<label>: '+item.stok+'</label>';
                html +='</div>';
              html +='</div>';

              html += '<div class="row">';            
                html +='<div class="col-5">';
                  html +='<label>Harga Beli</label>';
                html +='</div>';
                html +='<div class="col-7">';
                  html +='<label>: '+item.harga_beli+'</label>';
                html +='</div>';
              html +='</div>';

              html += '<div class="row">';            
                html +='<div class="col-5">';
                  html +='<label>Harga Jual</label>';
                html +='</div>';
                html +='<div class="col-7">';
                  html +='<label>: '+item.harga_jual+'</label>';
                html +='</div>';
              html +='</div>';

              html += '<div class="row">';            
                html +='<div class="col-5">';
                  html +='<label>Expire</label>';
                html +='</div>';
                html +='<div class="col-7">';
                  html +='<label>: '+(item.is_expire=='1' ? item.tgl_kadaluarsa : '-')+'</label>';
                html +='</div>';
              html +='</div>';

            html +='</div>';
            html +='<div class="col-sm-8">';
              html += '<div class="row" style="vertical-align:center">';
                html +='<label class="col-sm-12" style="text-align: center;"> <span style="font-size: 20px">Jumlah Opname Fisik : </span> </label>';
                html +='<div class="col-sm-2">';
                html +="<button class='btn btn-danger btn-block' id='minus_input_jumlah_beli_produk_"+item.id+"' name='minus_input_jumlah_beli_produk_"+item.id+"' onclick='addInputKasir(\""+item.id+"\",\"minus\")' type='button'><span style='font-size: 25px;font-weight: bold;''>-</span></button>";
                html +='</div>';
                html +='<div class="col-sm-8">';
                html +='<input type="number" name="input_jumlah_beli_produk_'+item.id+'" id="input_jumlah_beli_produk_'+item.id+'"  step="any" class="form-control" style="height: 50px" value="'+item.stok+'">';
                html +='</div>';
                html +='<div class="col-sm-2">';
                html +="<button class='btn btn-primary  btn-block' id='add_input_jumlah_beli_produk_"+item.id+"'  onclick='addInputKasir(\""+item.id+"\",\"plus\")'  type='button'><span style='font-size: 25px;font-weight: bold;''>+</span></button>";
                html +='</div>';
              html +='</div>';
            html +='</div>';
          html += '</div>';
          });
          $("#span_varian_kasir").html(html);
        }else{
          $("#tampil_harga").show();
          $("#form_add_kasir").show();
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
  function addInputKasir(id,type){
    let oldValue = $("#input_jumlah_beli_produk_"+id).val();
    if(type=='minus'){
      if(parseInt(oldValue) - 1 < 0){
        $("#input_jumlah_beli_produk_"+id).val(0)
      }else{
        let newValue = parseInt(oldValue)-1;
        $("#input_jumlah_beli_produk_"+id).val(newValue);
      }  
    }else{
      let oldValue = $("#input_jumlah_beli_produk_"+id).val();
      let newValue = parseInt(oldValue)+1;
      $("#input_jumlah_beli_produk_"+id).val(newValue);
    }
    
  }
</script>