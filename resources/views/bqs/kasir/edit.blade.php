@extends('admin.layouts.admin')
@section('title','Semua Kasir')
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
          TABEL KASIR
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
                  <!-- <div class="col-md-3 col-sm-3"></div> -->
                  <div class="col-md-12 col-sm-12 table-responsive">
                    <form role="form" id="edit"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
                      {{method_field('PATCH')}}
                      <div class="card-body">
                        <div class="row" style="padding-bottom: 20px">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="input_tgl_kasir">Tanggal Kasir</label><br>
                              <input type="text" id="input_tgl_kasir" class="form-control" name="input_tgl_kasir" autocomplete="off" value="{{$kasir->tanggal}}" @if($kasir->status=='1') disabled @endif>
                              <input type="hidden" id="input_action" class="form-control" name="input_action" autocomplete="off" value="{{$act}}">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="input_keterangan">Keterangan</label>
                              <textarea name="input_keterangan" id="input_keterangan" placeholder="Keterangan" class="form-control" rows="5" @if($kasir->status=='1') disabled @endif>{{$kasir->keterangan}}</textarea>
                              <span id="input_keterangan" class="error invalid-feedback"></span>
                            </div>
                          </div>
                          <div class="col-md-6">  
                          </div>
                          <div class="col-md-6" style="background-color: green;color: white;font-weight: bold;font-size: 20px;padding-top: 5px">
                              <label for="nilai_kasir">Nilai Kasir : <span id="nilai_kasir"></span></label>
                          </div>
                        </div>
                        <div class="row" style="float: right;">
                          <br>
                          <button type="submit" class="btn btn-success" @if($kasir->status=='1') disabled @endif>Simpan</button>&nbsp;&nbsp;
                          @if($kasir->status!='1')
                          <button type="button" class="btn btn-danger" id="selesai_kasir">Selesai</button>&nbsp;&nbsp;
                          @endif
                          <a href="{{ URL :: to('/bqs_template/kasir') }}">
                          <button type="button" class="btn btn-default"
                                  data-dismiss="modal">
                              Close
                          </button>
                          </a>
                        </div>
                      </div>
                      <!-- /.card-body -->
                    </form>
                    <div class="col-md-12">
                      <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist" style="padding: 10px">
                            @if($kasir->status!='1')
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">DATA PRODUK</a>
                            </li>
                            @endif
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">DATA Kasir</a>
                            </li>
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            @if($kasir->status!='1')
                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                              <div class="col-md-12 col-sm-12 table-responsive">
                                  <div style="padding-bottom: 10px">
                                    <button class="btn btn-success" onclick="reload_tableProduk()"><i class="fa fa-sync"></i> Refresh</button>
                                  </div>
                                  <table id="manage_all_produk" class="table table-collapse table-bordered table-hover  table-striped">
                                      <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Foto</th>
                                          <th>Nama</th>
                                          <th width="20%">Action</th>
                                      </tr>
                                      </thead>
                                  </table>
                              </div>
                            </div>
                            @endif
                            <div class="tab-pane fade @if($kasir->status=='1') show active @endif" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                              <div class="col-md-12 col-sm-12 table-responsive">
                                  <div style="padding-bottom: 10px">
                                    <button class="btn btn-success" onclick="reload_tableKasir()"><i class="fa fa-sync"></i> Refresh</button>
                                  </div>
                                  <table id="manage_all_kasir" class="table table-collapse table-bordered table-hover  table-striped">
                                      <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Produk</th>
                                          <th>Kasir</th>
                                          <th width="20%">Action</th>
                                      </tr>
                                      </thead>
                                  </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
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
  $("#menu_transaksi").addClass('menu-open');
  $("#menu_transaksi").addClass('active');
  $("#input_tgl_kasir").datepicker();
  getNilai();
  
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $('#edit').validate({
    submitHandler: function (form) {
        var myData = new FormData($("#edit")[0]);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        myData.append('_token', CSRF_TOKEN);
        var base_url = "{!! url('/') !!}";
        $.ajax({
            url: base_url+'/bqs_template/kasir/{{$kasir->id}}',
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
                    notify_view(data.type, data.message);
                    $("#submit").prop('disabled', false); // disable button
                } else if (data.type === 'error') {
                    if (data.errors) {
                        $.each(data.errors, function (key, val) {
                            $('#error_' + key).html(val);
                            $("#"+key).addClass('is-invalid');
                        });
                    }
                    $("#submit").prop('disabled', false); // disable button
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
  });
});

$(document).ready(function () {
  table_kasirDetail = $("#manage_all_kasir").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{!! route('bqs.allKasirDetail.kasirDetail') !!}',
        type: "GET",
        data: function (d) {
              d.trans_stok_id = '{{$kasir->id}}';
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
  table_produkDetail = $("#manage_all_produk").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{!! route('admin.allProduk.produk') !!}',
        type: "GET",
        data: function (d) {
              d.sumber = 'kasir';
              d.trans_stok_id = "{{$kasir->id}}";
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
      'width': '350px',
      'height': '50px'
  });
$("#manage_all_kasir").on("click", ".edit", function () {
    @if($kasir->status!='1') 
      $("#modal_data").empty();
      $("#modal-size").addClass('modal-lg');
      $('.modal-title').text('Edit Kasir'); // Set Title to Bootstrap modal title
      $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
      $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
      var id = $(this).attr('id');
      var base_url = "{!! url('/') !!}";

      $.ajax({
          url: base_url+'/bqs_template/kasir/editKasir/'+id,
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
    @else
      Swal.fire({
        icon: 'info',
        title: 'Data sudah diselesaikan. Tidak bisa di ubah'
      })
    @endif
});
$("#manage_all_kasir").on("click", ".delete", function () {
    @if($kasir->status!='1') 
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
          var base_url = "{!! url('/') !!}";
          $.ajax({
              url:  base_url+'/bqs_template/kasir/kasirDetail/' + id,
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
                      $("#nilai_kasir").html(data.total_nilai);
                      reload_tableKasir();
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
    @else
      Swal.fire({
        icon: 'info',
        title: 'Data sudah diselesaikan. Tidak bisa di ubah'
      })
    @endif
});
});
function reload_tableKasir() {
    table_kasirDetail.ajax.reload(null, false); //reload datatable ajax
}
function reload_tableProduk() {
    table_produkDetail.ajax.reload(null, false); //reload datatable ajax
}
$("#manage_all_produk").on("click", ".edit", function () {
  @if($kasir->status!='1') 
   $("#modal_data").empty();
    $("#modal-size").addClass('modal-lg');
    $('.modal-title').text('Edit Produk'); // Set Title to Bootstrap modal title
    $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
    $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
    var id = $(this).attr('id');
    var base_url = "{!! url('/') !!}";

    $.ajax({
        url: base_url+'/bqs_template/kasir/editProduk/'+id,
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
  @else
    Swal.fire({
      icon: 'info',
      title: 'Data sudah diselesaikan. Tidak bisa di ubah'
    })
  @endif
});
$("#custom-tabs-one-home-tab").click(function(){
  reload_tableProduk();
});;
$("#custom-tabs-one-profile-tab").click(function(){
  reload_tableKasir();
});;
function getNilai(){
  var base_url = "{!! url('/') !!}";
  $.ajax({
      url: base_url+'/bqs_template/kasir/getNilai/{{$kasir->id}}',
      type: 'get',
      success: function (data) {
        $("#nilai_kasir").html(data.total_nilai);
      },
      error: function (result) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
  });
}
$("#selesai_kasir").click(function(){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $(this).attr('id');
    
    Swal.fire({
      title: 'Apakah kamu yakin?',
      text: "Stok akan di update dan Data ini tidak bisa di edit kembali",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Ya, Selesaikan!'
    }).then((result) => {
      if (result.value) {
        var base_url = "{!! url('/') !!}";
        $.ajax({
            url: base_url+'/bqs_template/kasir/selesai/{{$kasir->id}}',
            data: {"_token": CSRF_TOKEN},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.type === 'success') {
                    Swal.fire(
                      'Selesai!',
                      'Data berhasil diselesaikan',
                      'success'
                    );
                    location.reload();
                } else if (data.type === 'danger') {
                    Swal.fire("Kesalahan!", "Data gagal diselesaikan", "error");
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
</script>
@endsection
