<form role="form" id="edit"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
  {{method_field('PATCH')}}
  <div class="card-body">
    <div class="row" style="padding-top: 10px">
      <div class="col-md-4">
        <img src="@if($produk->foto_thumnail!='' ) {{asset($produk->foto_thumnail)}} @else {{asset('lte/dist/img/imageDefault.jpg')}} @endif" class="product-image" alt="Product Image"  style="height: 220px">
        <div class="form-group" style="padding-top: 25px">
          <label for="input_deskripsi">Deskripsi</label>
          <textarea name="input_deskripsi" id="input_deskripsi"  class="form-control" placeholder="Deskripsi" rows="10">{{$produk->detail}}</textarea>
        </div>
        <div class="form-group">
          <label for="input_hastag">Hastag</label>
          <textarea name="input_hastag" id="input_hastag"  class="form-control" placeholder="Hastag" rows="6">{{$produk->hastag}}</textarea>
        </div>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <label for="input_nama">Nama Barang</label>
          <input type="text" name="input_nama" id="input_nama" placeholder="Nama Barang" class="form-control" value="{{$produk->nama}}">
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
            <div class="form-group" id="form_foto_thumnail">
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
                  <input type="text" class="form-control" id="input_jenis" placeholder="Pilih Jenis" name="input_jenis" autocomplete="off" value="{{$produk->mst_jenis_produk_nama}}">
                  <span id="error_input_jenis" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_jenis_id' name="input_jenis_id" readonly class="form-control"  value="{{$produk->jenis_id}}">
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
                  <input type="text" class="form-control" id="input_bahan" placeholder="Pilih Bahan" name="input_bahan" autocomplete="off" value="{{$produk->mst_bahan_jenis_nama}}">
                  <span id="error_input_bahan" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_bahan_id' name="input_bahan_id" readonly class="form-control"  value="{{$produk->bahan_id}}">
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
                  <input type="text" class="form-control" id="input_tema" placeholder="Pilih Tema" name="input_tema" autocomplete="off"  value="{{$produk->mst_tema_jenis_nama}}">
                  <span id="error_input_tema" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_tema_id' name="input_tema_id" readonly class="form-control"  value="{{$produk->tema_id}}">
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
                  <input type="text" class="form-control" id="input_judul" placeholder="Pilih Judul" name="input_judul" autocomplete="off"  value="{{$produk->mst_judul_tema_nama}}">
                  <span id="error_input_judul" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_judul_id' name="input_judul_id" readonly class="form-control"  value="{{$produk->judul_id}}">
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/judul') }}" target="_blank">
                  <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                  </a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="input_barcode">Barcode</label>
              <input type="text" name="input_barcode" id="input_barcode" placeholder="Barcode" class="form-control" readonly  value="{{$produk->barcode}}">
              <span id="error_input_barcode" class="error invalid-feedback"></span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="input_harga_beli">Harga Beli</label>
              <div id="form_harga_beli">
                <input type="number" name="input_harga_beli" id="input_harga_beli" placeholder="Harga Beli" class="form-control" step="any"  value="{{$produk->harga_beli}}">
                <span id="error_input_harga_beli" class="error invalid-feedback"></span>
              </div>
              <br><span id="label_harga_beli"></span>
            </div>
            <div class="form-group">
              <label for="input_harga_jual">Harga Jual</label>
              <div id="form_harga_jual">
                <input type="number" name="input_harga_jual" id="input_harga_jual" placeholder="Harga Jual" class="form-control" step="any"  value="{{$produk->harga_jual}}">
                <span id="error_input_harga_jual" class="error invalid-feedback"></span>
              </div>
              <br><span id="label_harga_jual"></span>
            </div>
            <div class="form-group">
              <label for="input_gratis_ongkir" style="padding-bottom: 5px">Gratis Ongkir</label><br>
              <input type="checkbox" name="input_gratis_ongkir" id="input_gratis_ongkir"  {{$produk->status_gratis_ongkir=='1' ? 'checked' : ''}} data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
            <div class="form-group"  style="padding-top: 5px">
              <label for="input_diskon">Diskon</label>
              <input type="number" name="input_diskon" id="input_diskon" placeholder="Diskon" class="form-control" step="any" value="{{$produk->diskon}}">
              <span id="error_input_diskon" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
              <label for="input_tampilkan_harga_detail"  style="padding-bottom: 5px">Tampilkan Harga Detail</label><br>
              <input type="checkbox" name="input_tampilkan_harga_detail" id="input_tampilkan_harga_detail" {{$produk->status_tampil_harga_detail=='1' ? 'checked' : ''}} data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
            <div class="form-group">
              <label for="input_toko_sumber"  style="padding-top: 5px">Sumber Toko</label><br>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_toko_sumber" placeholder="Pilih Toko" name="input_toko_sumber" autocomplete="off" value="{{$produk->mst_sumber_toko_nama}}">
                  <span id="error_input_toko_sumber" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_toko_sumber_id' name="input_toko_sumber_id" readonly class="form-control" value="{{$produk->sumber_toko_id}}">
                </div>
                <div class="col-md-2" style="padding-top: 3px">
                  <a href="{{ URL :: to('/admin_bqs/sumber') }}" target="_blank">
                  <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                  </a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="input_is_stok">Tampilkan Stok</label><br>
              <input type="checkbox" name="input_tampilkan_stok" id="input_tampilkan_stok"  {{$produk->status_tampil_stok=='1' ? 'checked' : ''}} data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
          </div>
          <div class="col-md-6" id="dt_input_stok">
            <div class="form-group">
              <label for="input_stok">Stok</label>
              <div id="form_stok">
                <input type="number" name="input_stok" id="input_stok" placeholder="Stok" class="form-control" step="any" value="{{$produk->stok}}">
                <span id="error_input_stok" class="error invalid-feedback"></span>
              </div>
              <br><span id="label_stok"></span>
            </div>
          </div>
          <div class="col-md-6" id="dt_input_satuan">
            <div class="form-group">
              <label for="input_satuan">Satuan</label>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_satuan" placeholder="Pilih Satuan" name="input_satuan" autocomplete="off" value="{{$produk->mst_satuan_nama}}">
                  <span id="error_input_satuan" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_satuan_id' name="input_satuan_id" readonly class="form-control" value="{{$produk->satuan_id}}">
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
              <input type="checkbox" name="input_status_confirm" id="input_status_confirm"  {{$produk->status_confirm=='1' ? 'checked' : ''}} data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
          </div>
          <div class="col-md-6" id="dt_input_satuan">
            <div class="form-group">
              <label for="input_satuan">Owner</label>
              <div class="row">
                <div class="col-md-10">
                  <input type="text" class="form-control" id="input_owner" placeholder="Owner" name="input_owner" autocomplete="off" value="{{$produk->app_user_list_name}}">
                  <span id="error_input_owner" class="error invalid-feedback"></span>
                  <input type="hidden" id='input_owner_id' name="input_owner_id" readonly class="form-control" value="{{$produk->user_id}}">
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
    <div class="row" style="float: right;">
      <br>
      <button type="submit" class="btn btn-success">Simpan</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-default"
            data-dismiss="modal">
          Close
      </button>
    </div>
  </div>
  <!-- /.card-body -->
</form>
<div class="card-footer" id="form_detail_varian" style="display: none">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-primary" id="btn_add_varian"><span id="label_add_varian"></span></button>
      <button type="button" class="btn btn-success" id="btn_save_varian" style="display: none">Simpan Varian</button>&nbsp;&nbsp;
      <button class="btn btn-success" id="btn_refresh_detail"><i class="fas fa-sync-alt"></i>
          Refresh
      </button>&nbsp;&nbsp;
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
        <label for="input_detail_stok">Stok</label>
        <input type="number" name="input_detail_stok" id="input_detail_stok" placeholder="Stok" class="form-control" step="any">
        <span id="error_input_detail_stok" class="error invalid-feedback"></span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-10">
          <div class="form-group">
            <label for="input_detail_bahan">Bahan</label>
            <input type="text" class="form-control" id="input_detail_bahan" placeholder="Bahan" name="input_detail_bahan">
            <span id="error_input_detail_bahan" class="error invalid-feedback"></span>
            <input type="hidden" id='input_detail_bahan_id' name="input_detail_bahan_id" readonlyclass="form-control" >
          </div>
        </div>
        <div class="col-md-2" style="padding-top:30px">
          <a href="{{ URL :: to('/admin_bqs/bahan_jenis') }}" target="_blank">
            <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
          </a>
        </div>
      </div>      
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="input_detail_harga">Harga Beli</label>
        <input type="number" name="input_detail_harga_beli" id="input_detail_harga_beli" placeholder="Harga Beli" class="form-control" step="any">
        <span id="error_input_detail_harga_beli" class="error invalid-feedback"></span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="input_detail_harga">Harga Jual</label>
        <input type="number" name="input_detail_harga_jual" id="input_detail_harga_jual" placeholder="Harga Jual" class="form-control" step="any">
        <span id="error_input_detail_harga_jual" class="error invalid-feedback"></span>
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
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="input_detail_deskripsi">Deskripsi</label>
        <textarea name="input_detail_deskripsi" id="input_detail_deskripsi" placeholder="Deskripsi" class="form-control"></textarea>
        <span id="error_input_detail_deskripsi" class="error invalid-feedback"></span>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="input_detail_hastag">Hastag</label>
        <textarea name="input_detail_hastag" id="input_detail_hastag" placeholder="Hastag" class="form-control"></textarea>
        <span id="error_input_detail_hastag" class="error invalid-feedback"></span>
      </div>
    </div>
  </div>
</div>
</form>
<div class="col-md-12 col-sm-12 table-responsive">
    <table id="manage_all_detail" class="table table-collapse table-bordered table-hover  table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Bahan</th>
            <th>Stok</th>
            <th>Harga</th>
            <th width="20%">Action</th>
        </tr>
        </thead>
    </table>
</div>
<style type="text/css">
.modal-dialog {
  /*width: 90%;*/
  /*height: 80%;*/
}

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
  cekChild();
  $("#label_add_varian").html('Tambah Varian');
  table_produkDetail = $("#manage_all_detail").DataTable({
    processing: true,
    serverSide: true,
    // ajax: '{!! route('admin.allProdukDetail.produk') !!}',
    ajax: {
        url: '{!! route('admin.allProdukDetail.produk') !!}',
        type: "GET",
        data: function (d) {
              d.produk_id = '{{$produk->id}}';
        },
    },
    "columnDefs": [
      { 
        "targets": [ -1,0 ], //last column
        "orderable": false //set not orderable
      }
    ],
    "autoWidth": false,
  });
  $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
      'width': '220px',
      'height': '30px'
  });
});
function reload_tableDetail() {
    table_produkDetail.ajax.reload(null, false); //reload datatable ajax
    cekChild();
}
$("#btn_add_varian").click(function(){
  clearFormDetail();
  $("#form_variant_id").show('slow');
  $("#btn_save_varian").show();
  $("#btn_cancel_varian").show();
  $("#btn_add_varian").hide();
  $("#btn_refresh_detail").hide();
});
$("#btn_cancel_varian").click(function(){
  clearFormDetail();
  $("#btn_add_varian").show();
  $("#btn_refresh_detail").show();
  $("#form_variant_id").hide('slow');
  $("#btn_save_varian").hide();
  $("#btn_cancel_varian").hide();
});
$("#btn_save_varian").click(function(){
  var myDataDetail = new FormData($("#form_varian")[0]);
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  myDataDetail.append('_token', CSRF_TOKEN);
  myDataDetail.append('input_jenis_id', $("#input_jenis_id").val());
  myDataDetail.append('input_tema_id', $("#input_tema_id").val());
  myDataDetail.append('input_judul_id', $("#input_judul_id").val());
  if($("#input_detail_action").val()!='edit'){
    $.ajax({
      url: 'produkDetail',
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
              reload_tableDetail();
              notify_view(data.type, data.message);
              $("#btn_add_varian").show();
              $("#btn_refresh_detail").show();
              $("#form_variant_id").hide('slow');
              $("#btn_save_varian").hide();
              $("#btn_cancel_varian").hide();
              $("#btn_save_varian").prop('disabled', false); // disable button
              clearFormDetail();
          } else if (data.type === 'error') {
              if (data.errors) {
                  $.each(data.errors, function (key, val) {
                      $('#error_' + key).html(val);
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
  }else{
    var myDataDetail = new FormData($("#form_varian")[0]);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    myDataDetail.append('_token', CSRF_TOKEN);
    myDataDetail.append('_method', 'PATCH');
    myDataDetail.append('input_jenis_id', $("#input_jenis_id").val());
    myDataDetail.append('input_tema_id', $("#input_tema_id").val());
    myDataDetail.append('input_judul_id', $("#input_judul_id").val());
    $.ajax({
        url: 'produkDetail/'+$("#input_detail_id").val(),
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
              reload_tableDetail();
              notify_view(data.type, data.message);
              $("#btn_add_varian").show();
              $("#btn_refresh_detail").show();
              $("#form_variant_id").hide('slow');
              $("#btn_save_varian").hide();
              $("#btn_cancel_varian").hide();
              $("#btn_save_varian").prop('disabled', false); // disable button
              clearFormDetail();
            } else if (data.type === 'error') {
                if (data.errors) {
                    $.each(data.errors, function (key, val) {
                        $('#error_' + key).html(val);
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
  }
});
$("#manage_all_detail").on("click", ".edit", function () {
  $("#label_add_varian").html('Edit Varian');
  $("#btn_add_varian").hide();
  $("#btn_refresh_detail").hide();
  $("#form_variant_id").show('slow');
  $("#btn_save_varian").show();
  $("#btn_cancel_varian").show();
  var id = $(this).attr('id');
  var proudk_id = $("#input_detail_produk_id").val();
  $.ajax({
      url: 'produkDetail/' + id+'__'+proudk_id + '/edit',
      type: 'get',
      success: function (data) {
        $("#input_detail_id").val(data.id);
        $("#input_detail_nama").val(data.nama);
        $("#input_detail_action").val('edit');
        $("#input_detail_stok").val(data.stok);
        $("#input_detail_harga").val(data.harga);
        $("#input_detail_bahan").val(data.mst_bahan_jenis_nama);
        $("#input_detail_bahan_id").val(data.bahan_id);
        $("#input_detail_harga_jual").val(data.harga_jual);
        $("#input_detail_harga_beli").val(data.harga_beli);
        $("#input_detail_deskripsi").val(data.detail);
        $("#input_detail_hastag").val(data.hastag);
        $("#input_detail_foto").val(data.foto_thumnail);
        $("#label_add_varian").html('Tambah Varian');
      },
      error: function (result) {
        $("#label_add_varian").html('Tambah Varian');
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
  });
});
$("#manage_all_detail").on("click", ".delete", function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $(this).attr('id');
    
    Swal.fire({
      title: 'Apakah kamu yakin?',
      text: "Data tidak bisa dikembalikan",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
            url: 'produkDetail/' + id,
            data: {"_token": CSRF_TOKEN,"produk_id": $("#input_detail_produk_id").val()},
            type: 'DELETE',
            dataType: 'json',
            success: function (data) {
                if (data.type === 'success') {
                    Swal.fire(
                      'Selesai!',
                      'Data berhasil dihapus',
                      'success'
                    );
                reload_tableDetail();
                } else if (data.type === 'danger') {
                    Swal.fire("Kesalahan!", "Data gagal dihapus", "error");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error deleting!", "Try again", "error");
            }
        });
      }
    })
});
$("#btn_refresh_detail").click(function(){
  reload_tableDetail();
});
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
  $("#input_detail_bahan" ).autocomplete({
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
       $('#input_detail_bahan').val(ui.item.label); // display the selected text
       $('#input_detail_bahan_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(item.label)
      .appendTo( ul );
  };
  $('#edit').validate({
    submitHandler: function (form) {
        var myData = new FormData($("#edit")[0]);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        myData.append('_token', CSRF_TOKEN);

        $.ajax({
            url: 'produk/{{$produk->id}}',
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
function cekChild(){
    $.ajax({
        url: 'cekChild/{{$produk->id}}',
        type: 'get',
        dataType: 'json',
         success: function (data) {
          if (data.status) {
            if(data.hasChild){
              $("#form_harga_jual").hide();
              $("#label_harga_jual").html(data.harga_jual);
              $("#form_harga_beli").hide();
              $("#label_harga_beli").html(data.harga_beli);
              $("#form_stok").hide();
              $("#label_stok").html(data.stok);
              $("#form_foto_thumnail").hide();
            }else{
              $("#form_harga_jual").show();
              $("#form_harga_beli").show();
              $("#form_foto_thumnail").show();
              $("#form_stok").show();
            }
            if(data.hasHistory){
              $("#form_detail_varian").hide();
            }else{
              $("#form_detail_varian").show();
            }
          } else  {
            Swal.fire({
              icon: 'error',
              title: data.message
            })
          }
        },
        error: function (result) {
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
          })
        }
    });
}
function clearFormDetail(){
  $("#input_detail_id").val('');
  $("#input_detail_nama").val('');
  $("#input_detail_stok").val('');
  $("#input_detail_bahan").val('');
  $("#input_detail_bahan_id").val('');
  $("#input_detail_harga_beli").val('');
  $("#input_detail_harga_jual").val('');
  $("#input_detail_foto").val('');
  $("#input_detail_deskripsi").val('');
  $("#input_detail_hastag").val('');
}
</script>