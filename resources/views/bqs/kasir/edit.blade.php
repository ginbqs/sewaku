@extends('bqs.layouts.admin')
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
                              <label for="input_peminjam">Peminjam</label><br>
                              <input type="text" id="input_peminjam" class="form-control" name="input_peminjam" placeholder="Peminjam" autocomplete="off" value="{{$kasir->peminjam}}" {{ ($kasir->status != 'draft' ? 'readonly' : '') }}>
                              <input type="hidden" id="input_peminjam_id" class="form-control" name="input_peminjam_id" autocomplete="off"  value="{{$kasir->user_id}}"  {{ ($kasir->status != 'draft' ? 'readonly' : '') }}>
                              <input type="hidden" id="input_action" class="form-control" name="input_action" autocomplete="off" value="{{$act}}">
                            </div>
                            <div class="form-group">
                              <label for="input_pinjam">Tanggal Pinjam</label><br>
                              <input type="text" id="input_pinjam" class="form-control" name="input_pinjam" placeholder="Tanggal Pinjam" autocomplete="off"  value="{{$kasir->tanggal_pinjam}}"  {{ ($kasir->status != 'draft' ? 'readonly' : '') }}>
                            </div>
                            <div class="form-group">
                              <label for="input_harus_dikembalikan">Tanggal Harus Dikembalikan</label><br>
                              <input type="text" id="input_harus_dikembalikan" class="form-control" name="input_harus_dikembalikan" placeholder="Tanggal Harus Dikembalikan" autocomplete="off" value="{{$kasir->tanggal_kembali}}"  {{ ($kasir->status != 'draft' ? 'readonly' : '') }}>
                            </div>
                            <div class="form-group">
                              <label for="input_keterangan">Keterangan</label>
                              <textarea name="input_keterangan" id="input_keterangan" placeholder="Keterangan" class="form-control" rows="5" @if($kasir->status=='kembali') disabled @endif>{{$kasir->keterangan}}</textarea>
                              <span id="input_keterangan" class="error invalid-feedback"></span>
                            </div>
                          </div>
                          @if($kasir->status=='pinjam' || $kasir->status=='kembali')
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="input_dikembalikan">Tanggal Dikembalikan</label><br>
                              <input type="text" id="input_dikembalikan" class="form-control" name="input_dikembalikan" placeholder="Tanggal Dikembalikan" autocomplete="off" value="{{$kasir->tanggal_dikembalikan}}"  {{ ($kasir->status  == 'kembali' ? 'readonly' : '') }}>
                            </div>
                            <div class="form-group">
                              <label for="input_hari_telat">Telat</label><br>
                              <input type="text" id="input_hari_telat" class="form-control" name="input_hari_telat" placeholder="Telat" autocomplete="off" value="{{$kasir->hari_telat}}" readonly="" >
                            </div>
                            <div class="form-group">
                              <label for="input_total_bayar">Bayar Sewa</label><br>
                              <input type="number" id="input_total_bayar" class="form-control" name="input_total_bayar" placeholder="Bayar Sewa" autocomplete="off" value="{{$kasir->total_bayar}}"  {{ ($kasir->status  == 'kembali' ? 'readonly' : '') }}>
                            </div>
                            <div class="form-group">
                              <label for="input_total_denda">Denda Telat</label><br>
                              <input type="number" id="input_total_denda" class="form-control" name="input_total_denda" placeholder="Denda Telat" autocomplete="off" value="{{$kasir->total_denda}}"  {{ ($kasir->status  == 'kembali' ? 'readonly' : '') }}>
                            </div>
                            <div class="form-group">
                              <label for="input_total_pembayaran">Total Yang Harus Dibayar</label><br>
                              <input type="number" id="input_total_pembayaran" class="form-control" name="input_total_pembayaran" placeholder="Total Yang Harus Dibayar" autocomplete="off" value="{{$kasir->total_bayar + $kasir->total_denda}}"  readonly="">
                            </div>
                            <div class="form-group">
                              <label for="input_total_terima_uang">Total Terima Uang</label><br>
                              <input type="number" id="input_total_terima_uang" class="form-control" name="input_total_terima_uang" placeholder="Total Terima Uang" autocomplete="off" value="{{$kasir->total_uang}}"  {{ ($kasir->status == 'kembali' ? 'readonly' : '') }}>
                            </div>
                            <div class="form-group">
                              <label for="input_total_kembali">Kembalian</label><br>
                              <input type="number" id="input_total_kembali" class="form-control" name="input_total_kembali" placeholder="Kembalian" autocomplete="off" value="{{$kasir->total_kembali}}"  readonly="">
                            </div>
                          </div>
                          @endif
                        </div>
                        <div class="row" style="float: right;">
                          <br>
                          @if($kasir->status=='draft')
                          <button type="button" class="btn btn-danger" id="selesai_kasir">Sewakam Barang</button>&nbsp;&nbsp;
                          @endif
                          @if($kasir->status=='pinjam')
                          <button type="button" class="btn btn-danger" id="kembali_kasir">Kembalikan Barang</button>&nbsp;&nbsp;
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
                            @if($kasir->status=='draft')
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">DATA BARANG</a>
                            </li>
                            @endif
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">DATA PINJAMAN</a>
                            </li>
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            @if($kasir->status=='draft')
                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                              <div class="col-md-12 col-sm-12 table-responsive">
                                  <div style="padding-bottom: 10px">
                                    <button class="btn btn-success" onclick="reload_tableProduk()"><i class="fa fa-sync"></i> Refresh</button>
                                  </div>
                                  <table id="manage_all_produk" class="table table-collapse table-bordered table-hover  table-striped">
                                      <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Nama</th>
                                          <th>Kategori</th>
                                          <th>Gambar</th>
                                          <th>Jumlah/Terpinjam</th>
                                          <th width="20%">Action</th>
                                      </tr>
                                      </thead>
                                  </table>
                              </div>
                            </div>
                            @endif
                            <div class="tab-pane fade @if($kasir->status!='draft') show active @endif" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                              <div class="col-md-12 col-sm-12 table-responsive">
                                  <div style="padding-bottom: 10px">
                                    <button class="btn btn-success" onclick="reload_tableKasir()"><i class="fa fa-sync"></i> Refresh</button>
                                  </div>
                                  <table id="manage_all_kasir" class="table table-collapse table-bordered table-hover  table-striped">
                                      <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Barang</th>
                                          <th>Jumlah</th>
                                          <th>Keterangan</th>
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
<style type="text/css">
  #ui-datepicker-div{
    background-color: #b8b8b8
  }
  .ui-datepicker-header{
    text-align: center;
  }
  .ui-datepicker-prev{
    margin-right:40%
  }
</style>
<script type="text/javascript">
$(document).ready(function () {
  $("#menu_transaksi").addClass('menu-open');
  $("#menu_transaksi").addClass('active');
  $("#input_pinjam").datepicker();
  $("#input_harus_dikembalikan").datepicker();
  $("#input_dikembalikan").datepicker();
  
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
        url: '{!! route('admin.allKasirDetail.kasirDetail') !!}',
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
        url: '{!! route('admin.allBarang.barang') !!}',
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
    @if($kasir->status=='draft') 
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
    @if($kasir->status=='draft') 
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
  @if($kasir->status=='draft') 
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
$("#selesai_kasir").click(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $(this).attr('id');
    if($("#input_peminjam").val()=='' || $("#input_peminjam_id").val()=='' || $("#input_pinjam").val()=='' || $("#input_harus_dikembalikan").val()==''){
      Swal.fire("Kesalahan!", "Data Peminjam, Tanggal Pinjam atau Tanggal Harus Dikembalikan harus di isi", "info");
      return false;
    }
    Swal.fire({
      title: 'Apakah kamu yakin?',
      text: "Stok akan berkurang dan Barang yang disewakan tidak bisa diedit kembali",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Ya, Sewakan!'
    }).then((result) => {
      if (result.value) {
        var base_url = "{!! url('/') !!}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var myData = new FormData();
        myData.append('_token', CSRF_TOKEN);
        myData.append('input_peminjam', $("#input_peminjam").val());
        myData.append('input_peminjam_id', $("#input_peminjam_id").val());
        myData.append('input_pinjam', $("#input_pinjam").val());
        myData.append('input_harus_dikembalikan', $("#input_harus_dikembalikan").val());
        $.ajax({
            url: base_url+'/bqs_template/kasir/selesai/{{$kasir->id}}',
            type: 'POST',
            data: myData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
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
$("#kembali_kasir").click(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $(this).attr('id');
    if($("#input_peminjam").val()=='' || $("#input_peminjam_id").val()=='' || $("#input_pinjam").val()=='' || $("#input_harus_dikembalikan").val()=='' || $("#input_dikembalikan").val()==''){
      Swal.fire("Kesalahan!", "Data Peminjam, Tanggal Pinjam, Tanggal Harus Dikembalikan atau Tanggal Dikembalikan harus di isi", "info");
      return false;
    }
    Swal.fire({
      title: 'Apakah kamu yakin?',
      text: "Stok akan bertambah dan Barang yang dikembalikan tidak bisa diedit kembali",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Ya, Kembalikan!'
    }).then((result) => {
      if (result.value) {
        var base_url = "{!! url('/') !!}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var myData = new FormData();
        myData.append('_token', CSRF_TOKEN);
        myData.append('input_peminjam', $("#input_peminjam").val());
        myData.append('input_peminjam_id', $("#input_peminjam_id").val());
        myData.append('input_pinjam', $("#input_pinjam").val());
        myData.append('input_harus_dikembalikan', $("#input_harus_dikembalikan").val());
        myData.append('input_dikembalikan', $("#input_dikembalikan").val());
        myData.append('input_hari_telat', $("#input_hari_telat").val());
        myData.append('input_total_bayar', $("#input_total_bayar").val());
        myData.append('input_total_denda', $("#input_total_denda").val());
        myData.append('input_total_pembayaran', $("#input_total_pembayaran").val());
        myData.append('input_total_terima_uang', $("#input_total_terima_uang").val());
        myData.append('input_total_kembali', $("#input_total_kembali").val());
        $.ajax({
            url: base_url+'/bqs_template/kasir/kembalikan/{{$kasir->id}}',
            type: 'POST',
            data: myData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
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
$("#input_total_terima_uang").change(function(){
    if(parseInt($("#input_total_pembayaran").val()) < 1){
      Swal.fire("Kesalahan!", "Total Yang Harus Dibayar harus lebih dari nol", "error");
      $("#input_total_terima_uang").val(0);
      return false;
    }
    var totalKembali = parseInt($("#input_total_terima_uang").val()) - parseInt($("#input_total_pembayaran").val());
    $("#input_total_kembali").val(totalKembali);
});
$("#input_total_bayar").change(function(){
  totalHarusBayar();
})
$("#input_total_denda").change(function(){
  totalHarusBayar();
})
function totalHarusBayar(){
  var totalBayar = parseInt($("#input_total_bayar").val()) > 0 ? parseInt($("#input_total_bayar").val()) : 0;
  var totalDenda = parseInt($("#input_total_denda").val()) > 0 ? parseInt($("#input_total_denda").val()) : 0;
  var total = totalBayar + totalDenda;
  $("#input_total_pembayaran").val(total);
}
$("#input_dikembalikan").change(function(){
  var input_harus_dikembalikan = $('#input_harus_dikembalikan').val()
  var tglStart = input_harus_dikembalikan.split('-');
  var start = new Date(tglStart[1]+'/'+tglStart[2]+'/'+tglStart[0]);
  // var input_dikembalikan = $('#input_dikembalikan').val()
  // var tglEnd = input_dikembalikan.split('-');
  // var end = new Date(tglEnd[1]+'-'+tglEnd[2]+'-'+tglEnd[0]);
  // var telat = new Date(end - start) / (1000 * 60 * 60 * 24 * 365.25);
  // var start= $("#input_harus_dikembalikan").datepicker("getDate");
  var end= $("#input_dikembalikan").datepicker("getDate");
  var telat = (end- start) / (1000 * 60 * 60 * 24);
  $("#input_hari_telat").val(Math.round(telat));
});
</script>
@endsection
