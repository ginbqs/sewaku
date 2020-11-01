@extends('admin.layouts.admin')
@section('title','Semua Produk')
@section('breadcumb')
	<li class="breadcrumb-item"><a href="#">Access Managemen</a></li>
	<li class="breadcrumb-item active">Operators</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-outline card-info">
      <div class="card-header">
        <h3 class="card-title">
          TABEL PRODUK
        </h3>
        <!-- tools box -->
        <div class="card-tools">
          <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
        <!-- /. tools -->
      </div>
    <div class="box-header with-border">
    </div>
      <!-- /.card-header -->
      <div class="card-body pad">
        	<div class="panel-body">
              <div class="row">
                  <div class="col-md-12" style="padding-bottom: 20px">
                    <button class="btn btn-primary" onclick="create()"><i class="fas fa-plus-square"></i>
                        Tambah Produk
                    </button>
                    <button class="btn btn-success" id="btn_refresh"><i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                  </div>
                  <div class="col-md-12" style="padding-bottom: 20px">
                      <div class="card card-success">
                        <div class="card-header">
                          <h3 class="card-title">Filter Detail</h3>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                          </div>
                          <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          @if($dt_auth->app_user_level_id=='root')
                          <div class="row">
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_provinsi" placeholder="Pilih Provinsi" name="filter_produk_provinsi">
                              <input type="hidden" id='filter_produk_provinsi_id' name="filter_produk_provinsi_id" readonly class="form-control" >
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_kota" placeholder="Pilih Kota" name="filter_produk_kota">
                              <input type="hidden" id='filter_produk_kota_id' name="filter_produk_kota_id" readonly class="form-control" >
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_kecamatan" placeholder="Pilih Kecamatan" name="filter_produk_kecamatan">
                              <input type="hidden" id='filter_produk_kecamatan_id' name="filter_produk_kecamatan_id" readonly class="form-control" >
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_desa" placeholder="Pilih Desa" name="filter_produk_desa">
                              <input type="hidden" id='filter_produk_desa_id' name="filter_produk_desa_id" readonly class="form-control" >
                            </div>
                          </div>
                          @endif
                          <div class="row" style="padding-top: 10px">
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_jenis" placeholder="Pilih Jenis" name="filter_produk_jenis">
                              <input type="hidden" id='filter_produk_jenis_id' name="filter_produk_jenis_id" readonly class="form-control" >
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_bahan" placeholder="Pilih Bahan" name="filter_produk_bahan">
                              <input type="hidden" id='filter_produk_bahan_id' name="filter_produk_bahan_id" readonly class="form-control" >
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_tema" placeholder="Pilih Tema" name="filter_produk_tema">
                              <input type="hidden" id='filter_produk_tema_id' name="filter_produk_tema_id" readonly class="form-control" >
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_judul" placeholder="Pilih Tema" name="filter_produk_judul">
                              <input type="hidden" id='filter_produk_judul_id' name="filter_produk_judul_id" readonly class="form-control" >
                            </div>
                          </div>
                          @if($dt_auth->app_user_level_id=='root')
                          <div class="row" style="padding-top: 10px">
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_tokoSumber" placeholder="Pilih Toko Sumber" name="filter_produk_tokoSumber">
                              <input type="hidden" id='filter_produk_tokoSumber_id' name="filter_produk_tokoSumber_id" readonly class="form-control" >
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control" id="filter_produk_user" placeholder="Pilih User" name="filter_produk_user">
                              <input type="hidden" id='filter_produk_user_id' name="filter_produk_user_id" readonly class="form-control" >
                            </div>
                          </div>
                          @endif
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                  </div>
                  <div class="col-md-12 col-sm-12 table-responsive">
                      <table id="manage_all" class="table table-collapse table-bordered table-hover  table-striped">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Nama</th>
                              <th>Barcode</th>
                              <th>Foto</th>
                              <th>Terjual</th>
                              <th width="20%">Action</th>
                          </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
  <!-- /.col-->
</div>
<style>
    @media screen and (min-width: 768px) {
        #myModal .modal-dialog {
            width: 75%;
            border-radius: 5px;
        }
    }
</style>
<script type="text/javascript">
$(document).ready(function () {
	$("#menu_produk").addClass('menu-open');
	$("#menu_produk_master_produk").addClass('active');
  table = $("#manage_all").DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('admin.allProduk.produk') !!}',
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
$("#btn_refresh").click(function(){
  reload_table();
});
function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}
function create(){
  $("#modal_data").empty();
  $('.modal-title').text('Tambah Produk');
  $("#modal-size").addClass('modal-xl');
  $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
  $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
  $.ajax({
    type:'GET',
    url:'produk/create',
    success: function (data) {
        $("#modal-overlay").removeClass();
        $("#modal-overlay-content").removeClass();
        $("#modal_data").html(data.html);
        $('#myModal').modal('show'); // show bootstrap modal
    },
    error: function (result) {
      $("#modal-overlay").removeClass();
      $("#modal-overlay-content").removeClass();
      Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
      })
    }
  })
}
$("#manage_all").on("click", ".edit", function () {
    $("#modal_data").empty();
    $("#modal-size").addClass('modal-xl');
    $('.modal-title').text('Edit Produk'); // Set Title to Bootstrap modal title
    $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
    $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
    var id = $(this).attr('id');

    $.ajax({
        url: 'produk/' + id + '/edit',
        type: 'get',
        success: function (data) {
          $("#modal-overlay").removeClass();
          $("#modal-overlay-content").removeClass();
          $("#modal_data").html(data.html);
          $('#myModal').modal('show'); // show bootstrap modal
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
});
$("#manage_all").on("click", ".delete", function () {
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
            url: 'produk/' + id,
            data: {"_token": CSRF_TOKEN},
            type: 'DELETE',
            dataType: 'json',
            success: function (data) {
                if (data.type === 'success') {
                    Swal.fire(
                      'Selesai!',
                      'Data berhasil dihapus',
                      'success'
                    );
                    reload_table();
                } else if (data.type === 'danger') {
                    Swal.fire("Kesalahan!", "Data gagal dihapus", "error");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Swal.fire({
                  icon: 'error',
                  title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
                })
            }
        });
      }
    })
});
$("#filter_produk_provinsi").keyup(function(){
    if($("#filter_produk_provinsi" ).val()==''){
        $("#filter_produk_provinsi_id").val('');
        $("#filter_produk_kota").val('');
        $("#filter_produk_kota_id").val('');
        $("#filter_produk_kecamatan").val('');
        $("#filter_produk_kecamatan_id").val('');
    }
});
$("#filter_produk_kota").keyup(function(){
    if($("#filter_produk_kota" ).val()==''){
        $("#filter_produk_kota_id").val('');
        $("#filter_produk_kecamatan").val('');
        $("#filter_produk_kecamatan_id").val('');
    }
});
$("#filter_produk_kecamatan").keyup(function(){
    if($("#filter_produk_kecamatan" ).val()==''){
        $("#filter_produk_kecamatan_id").val('');
    }
});
$( function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#filter_produk_provinsi" ).autocomplete({
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
          }
        });
      },
      select: function (event, ui) {
         // Set selection
         $('#filter_produk_provinsi').val(ui.item.label); // display the selected text
         $('#filter_produk_provinsi_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
        .appendTo( ul );
    }
    $("#filter_produk_kota" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url:"{{route('admin.autocompleteKota.kota')}}",
          type: 'post',
          dataType: "json",
          data: {
             _token: CSRF_TOKEN,
             search: request.term,
             provinsi_id: $("#filter_produk_provinsi_id").val(),
          },
          success: function( data ) {
             response( data );
          }
        });
      },
      select: function (event, ui) {
         // Set selection
         $('#filter_produk_kota').val(ui.item.label); // display the selected text
         $('#filter_produk_kota_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
        .appendTo( ul );
    };
    $("#filter_produk_kecamatan" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url:"{{route('admin.autocompleteKecamatan.kecamatan')}}",
          type: 'post',
          dataType: "json",
          data: {
             _token: CSRF_TOKEN,
             search: request.term,
             provinsi_id: $("#filter_produk_provinsi_id").val(),
             kota_id: $("#filter_produk_kota_id").val(),

          },
          success: function( data ) {
             response( data );
          }
        });
      },
      select: function (event, ui) {
         // Set selection
         $('#filter_produk_kecamatan').val(ui.item.label); // display the selected text
         $('#filter_produk_kecamatan_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
        .appendTo( ul );
    }
    $("#filter_produk_desa" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url:"{{route('admin.autocompleteDesa.desa')}}",
          type: 'post',
          dataType: "json",
          data: {
             _token: CSRF_TOKEN,
             search: request.term,
             provinsi_id: $("#filter_produk_provinsi_id").val(),
             kota_id: $("#filter_produk_kota_id").val(),
             kecamatan_id: $("#filter_produk_desa_id").val(),
          },
          success: function( data ) {
             response( data );
          }
        });
      },
      select: function (event, ui) {
         // Set selection
         $('#filter_produk_desa').val(ui.item.label); // display the selected text
         $('#filter_produk_desa_id').val(ui.item.value); // save selected id to input
         return false;
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .data( "ui-autocomplete-item", item )
        .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
        .appendTo( ul );
    }
});
</script>
@endsection