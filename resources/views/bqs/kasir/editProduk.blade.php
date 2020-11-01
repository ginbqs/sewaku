<form role="form" id="edit"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  {{method_field('PATCH')}}
  <div class="card-body">

    <div class="row" style="padding-top: 10px">
      <div class="col-md-4">
        <img src="@if($produk->foto_thumnail!='' ) {{asset($produk->foto_thumnail)}} @else {{asset('lte/dist/img/imageDefault.jpg')}} @endif" class="product-image" alt="Product Image"  style="height: 220px">
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <h4 for="input_nama">
            {{$produk->nama}}
          </h4>
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
          <label class="col-6">: @if($produk->status_expire=='1') {{$produk->tgl_kadaluarsa}} @else - @endif</label>
        </div>
        <div class="row" id="tampil_harga" >
            <div class="col-12">
                <div class="row">
                  <label class="col-6">Harga</label>
                  <label class="col-6">: {{$produk->harga_jual}}</label>
                </div>
            </div>
        </div>
        <div class="row">
          <label class="col-6">Diskon Produk</label>
          <label class="col-12"><input type="number" name="input_diskon_produk" id="input_diskon_produk" step="any" class="form-control" style="height: 40px" @if(isset($produk->diskon)) value="{{ $produk->diskon}}" @else value="0" @endif></label>
        </div>
      </div>
    </div>
    <div class="row" id="form_add_pengeluaran" style="padding-top: 20px">
      <label class="col-sm-12" style="text-align: center;"> <span style="font-size: 20px">Jumlah Beli : </span> </label>
      <div class="col-sm-2">
        <button class="btn btn-danger btn-block" id="minus_input_jumlah_beli_produk_{{$produk->id}}" type="button"><span style="font-size: 25px;font-weight: bold;">-</span></button>
      </div>
      <div class="col-sm-8">
        <input type="number" name="input_jumlah_beli_produk_{{$produk->id}}" id="input_jumlah_beli_produk_{{$produk->id}}" step="any" class="form-control" style="height: 50px" @if(isset($produk->jumlah)) value="{{ $produk->jumlah}}" @else value="0" @endif>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-success  btn-block" id="add_input_jumlah_beli_produk_{{$produk->id}}" type="button"><span style="font-size: 25px;font-weight: bold;">+</span></button>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</form>

<div class="card-body">
<span id="span_varian_pengeluaran"></span>
</div>
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
  getValidateVarian();
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $("#btn_add_pengeluaran_save").click(function(){
    var base_url = "{!! url('/') !!}";
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var myDataDetail = new FormData();
    myDataDetail.append('_token', CSRF_TOKEN);
    myDataDetail.append('input_detail_action', 'add');
    myDataDetail.append('input_diskon_produk', $("#input_diskon_produk").val());
    @if(isset($produk->jumlah))
    myDataDetail.append('keranjang_id', {{$produk->keranjang_id}});
   @endif
    let number = 0;
    $("input[name^='input_jumlah_beli_produk_']" ).each(function(){
      @if(!isset($produk->jumlah))
      number = parseInt(number) + parseInt($(this).val());
      if(parseInt($(this).val()) > 0){
        myDataDetail.append($(this).attr('id'), $(this).val());
      }
      @else
        myDataDetail.append($(this).attr('id'), $(this).val());
      @endif
    });
    @if(!isset($produk->jumlah))
    if(number < 1){
      Swal.fire({
        icon: 'info',
        title: 'Silahkan Input Jumlah Pembelian'
      })
      return false;
    }
    @endif
    $.ajax({
      url: 'createPembelian',
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
              getValidateVarian();
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
function getValidateVarian(){
  var base_url = "{!! url('/') !!}";
  $.ajax({
      url: base_url+'/admin_bqs/getValidateVarian/{{$produk->id}}',
      type: 'get',
      success: function (data) {
        let res = JSON.parse(data);
        let dt_child = res.child;
        $("#span_varian_pengeluaran").html('');
        if(dt_child.length > 0){
          $("#tampil_harga").hide();
          $("#form_add_pengeluaran").hide();
          $("#action_form_pengeluaran").show();

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
                  html +='<label>Harga</label>';
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
                  html +='<label>: '+(item.status_expire=='1' ? item.tgl_kadaluarsa : '-')+'</label>';
                html +='</div>';
              html +='</div>';

            html +='</div>';
            html +='<div class="col-sm-8">';
              html += '<div class="row" style="vertical-align:center">';
                html +='<label class="col-sm-12" style="text-align: center;"> <span style="font-size: 20px">Jumlah Beli : </span> </label>';
                html +='<div class="col-sm-2">';
                html +="<button class='btn btn-danger btn-block' id='minus_input_jumlah_beli_produk_"+item.id+"' name='minus_input_jumlah_beli_produk_"+item.id+"' onclick='addInputPengeluaran(\""+item.id+"\",\"minus\")' type='button'><span style='font-size: 25px;font-weight: bold;''>-</span></button>";
                html +='</div>';
                html +='<div class="col-sm-8">';
                html +='<input type="number" name="input_jumlah_beli_produk_'+item.id+'" id="input_jumlah_beli_produk_'+item.id+'"  step="any" class="form-control" style="height: 50px" value="0">';
                html +='</div>';
                html +='<div class="col-sm-2">';
                html +="<button class='btn btn-primary  btn-block' id='add_input_jumlah_beli_produk_"+item.id+"'  onclick='addInputPengeluaran(\""+item.id+"\",\"plus\")'  type='button'><span style='font-size: 25px;font-weight: bold;''>+</span></button>";
                html +='</div>';
              html +='</div>';
            html +='</div>';
          html += '</div>';
          });
          $("#span_varian_pengeluaran").html(html);
          getKeranjang();

        }else{
          $("#tampil_harga").show();
          $("#form_add_pengeluaran").show();
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
  function addInputPengeluaran(id,type){
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