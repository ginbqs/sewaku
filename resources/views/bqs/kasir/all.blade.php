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
      <div class="card-body pad" id="kasir_absen" @if(isset($kasirLock->id)) style="display:none" @endif>
        <div class="card card-primary">
          <h1>SILAHKAN INPUT DATA KASIR</h1>
          <div class="card-header">
            <h3 class="card-title">Form Kasir</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" id="form_bukaKasir">
            <div class="card-body">
              <div class="form-group">
                <label for="input_saldoAwal">SALDO AWAL</label>
                <input type="number" class="form-control" id="input_saldoAwal" name="input_saldoAwal" placeholder="Saldo Awal" step="any">
              </div>
              <div class="form-group">
                <label for="input_catatan">CATATAN</label>
                <textarea id="input_catatan" name="input_catatan" placeholder="Catatan" rows="5" class="form-control"></textarea>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">BUKA KASIR</button>
            </div>
          </form>
        </div>
      </div>
      <div class="card-body pad" id="kasir_input" style="display: none">
        	<div class="panel-body">
            <div class="row">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12" style="padding-bottom: 20px">
                    <button class="btn btn-danger" id="btn_tutupKasir"><i class="fas fa-stop"></i> 
                         TUTUP KASIR
                    </button>
                  </div>
                  <div class="col-md-12  d-sm-block d-md-none" style="background-color: blue;padding: 20px;margin-bottom: 20px;border-radius: 20px" id="chekcoutbukahalamanbaru">
                    <span style="font-size: 30px" id="perhitungan_total">0</span>
                  </div>
                  <!-- TABLE BARANG -->
                  <div class="col-md-12">
                    <div class="card card-info card-tabs">
                      <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist" style="padding: 10px">
                          <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">PRODUK</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">PAKET MENU</a>
                          </li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                          <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                            <div class="col-md-12 col-sm-12 table-responsive">
                                <div style="padding-bottom: 10px">
                                  <button class="btn btn-success" onclick="reload_table()"><i class="fas fa-sync"></i> 
                                      Refresh
                                  </button>
                                </div>
                                <table id="manage_all" class="table table-collapse table-bordered table-hover  table-striped">
                                    <thead>
                                    <tr>
                                        <th>Barang</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                          </div>
                          <div class="tab-pane fade " id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                            <div class="col-md-12 col-sm-12 table-responsive">
                                <div style="padding-bottom: 10px">
                                  <button class="btn btn-success" onclick="reload_tablePaket()"><i class="fa fa-sync"></i> Refresh</button>
                                </div>
                                <table id="manage_allPaket" class="table table-collapse table-bordered table-hover  table-striped">
                                    <thead>
                                    <tr>
                                        <th>Paket</th>
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
                  <!-- END TABLE BARANG -->
                </div>
              </div>
              <div class="col-md-5 d-none d-sm-none d-md-block">
                <div class="card card-info" style="margin-top: 55px">
                  <div class="card-header" >
                    <h2 class="card-title"  style="padding: 7px">KERANJANG</h2>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="form-horizontal" id="form_keranjang">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="input_pembeli">Pembeli</label>
                            <input type="text" id="input_pembeli" class="form-control" name="input_pembeli" autocomplete="off" placeholder="Pembeli">
                            <input type="hidden" id="input_pembeli_id" class="form-control" name="input_pembeli_id" autocomplete="off" placeholder="Pembeli">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <table class="table table-striped table-collapse table-bordered table-hover"  id="manage_all_keranjang">
                            <thead>
                              <th>ID</th>
                              <th>Nama</th>
                              <th>Jumlah</th>
                              <th>Harga</th>
                              <th>Sub Total</th>
                            </thead>
                          </table>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="input_subtotal">Sub Total</label>
                            <input type="number" id="input_subtotal" class="form-control" name="input_subtotal" autocomplete="off" placeholder="Sub Total" step="any" readonly>
                          </div>  
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="input_diskon">Diskon</label>
                            <input type="number" id="input_diskon" class="form-control" name="input_diskon" autocomplete="off" placeholder="Diskon" step="any">
                          </div>  
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="input_total_bayar">Total Bayar</label>
                            <input type="number" id="input_total_bayar" class="form-control" name="input_total_bayar" autocomplete="off" placeholder="Total Bayar" step="any" readonly>
                          </div>  
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="input_bayar">Bayar</label>
                            <input type="number" id="input_bayar" class="form-control" name="input_bayar" autocomplete="off" placeholder="Bayar" step="any">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="input_selisih">Kembalian</label>
                            <input type="number" id="input_selisih" class="form-control" name="input_selisih" autocomplete="off" placeholder="Selisih" step="any" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-12">
                          <button type="button" id="print_pembelian" class="btn btn-warning  btn-block">PRINT</button>
                          <button type="submit" class="btn btn-info  btn-block">BAYAR</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <!-- /.col-->
</div>
<div id="print_pembelian_area">
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
  cekKasirAbsen();
	$("#menu_kasir").addClass('menu-open');
	$("#menu_kasir_detail").addClass('active');
  $("#chekcoutbukahalamanbaru").click(function() {
    window.location.href = "{{ URL :: to('/admin_bqs/checkOutHp') }}";
  });
  table = $("#manage_all").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{!! route('admin.allProdukKasir.kasir') !!}',
        type: "GET",
        data: function (d) {
              d.sumber = 'kasir';
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
  table_paket = $("#manage_allPaket").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{!! route('admin.allPaket.kasir') !!}',
        type: "GET",
        data: function (d) {
              d.sumber = 'kasir';
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
  table_keranjang = $("#manage_all_keranjang").DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('admin.allKeranjang.kasir') !!}',
    "columnDefs": [
      { 
        "targets": [ -1,0 ], //last column
        "orderable": false //set not orderable
      }
    ],
    "autoWidth": false,
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', aData[0]);
        $(nRow).attr('class', 'editKeranjang');
    }
  });
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $('#form_bukaKasir').validate({
    submitHandler: function (form) {
        var myData = new FormData($("#form_bukaKasir")[0]);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        myData.append('_token', CSRF_TOKEN);

        $.ajax({
            url: 'bukaKasir',
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
  });
  $('#form_keranjang').validate({
    submitHandler: function (form) {
      var myData = new FormData($("#form_keranjang")[0]);
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      myData.append('_token', CSRF_TOKEN);
      
      Swal.fire({
        title: 'Apakah kamu yakin menyelesaikan penjualan ini?',
        text: "Data tidak bisa dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Lunas!'
      }).then((result) => {
        if (result.value) {
         $.ajax({
            url: 'checkOut',
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
                reload_keranjang_table();
                reload_table();
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
  $("#input_pembeli" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteUsers.users')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term,
           level: 'pelanggan',
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
       $('#input_pembeli').val(ui.item.label); // display the selected text
       $('#input_pembeli_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px'>" )
      .data( "ui-autocomplete-item", item )
      .append(item.label)
      .appendTo( ul );
  };
});
$("#manage_all").on("click", ".editPembelian", function () {
    $("#modal_data").empty();
    $("#modal-size").addClass('modal-lg');
    $('.modal-title').text('Beli Barang'); // Set Title to Bootstrap modal title
    $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
    $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
    var id = $(this).attr('id');
    // var base_url = "{!! url('/') !!}";
    $.ajax({
        // url: base_url+'/admin_bqs/pengeluaran/editPengeluaran/'+id,
        url: 'pembelianProduk/'+id,
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
$("#manage_allPaket").on("click", ".editPaket", function () {
    $("#modal_data").empty();
    $("#modal-size").addClass('modal-lg');
    $('.modal-title').text('Beli Barang'); // Set Title to Bootstrap modal title
    $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
    $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
    var id = $(this).attr('id');
    $.ajax({
        url: 'pembelianPaket/'+id,
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
function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}
function reload_tablePaket() {
    table_paket.ajax.reload(null, false); //reload datatable ajax
}


$("#custom-tabs-one-home-tab").click(function(){
  reload_table();
});
$("#custom-tabs-one-profile-tab").click(function(){
  reload_tablePaket();
});
function cekKasirAbsen(){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      url: 'cekKasirAbsen',
      data: {"_token": CSRF_TOKEN},
      type: 'POST',
      dataType: 'json',
      success: function (data) {
          if (data.bukaKasir) {
              $("#kasir_input").show();
              $("#kasir_absen").hide();
          } else{
            $("#kasir_input").hide();
            $("#kasir_absen").show();
            Swal.fire("Buka Kasir!", "Silahkan Masukan Saldo Awal Terlebih Dahulu!", "info");
          }
          getKeranjang();
      },
      error: function (xhr, ajaxOptions, thrownError) {
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
          })
      }
  });
}
function getKeranjang(){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      url: 'getKeranjang',
      type: 'get',
      dataType: 'json',
      success: function (data) {
        $("#input_pembeli").val('GUEST');
        $("#input_pembeli_id").val('');
        $("#input_subtotal").val(data.data.total_nilai_terjual);
        $("#input_diskon").val(0);
        $("#input_total_bayar").val(data.data.total_nilai_terjual);
        $("#input_bayar").val(data.data.total_nilai_terjual);
        $("#input_selisih").val(0);
        $("#perhitungan_total").html('Rp. '+(data.data.total_nilai_terjual > 0 ? data.data.total_nilai_terjual : 0));
      },
      error: function (xhr, ajaxOptions, thrownError) {
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
          })
      }
  }); 
}
$("#manage_all_keranjang").on("click", ".editKeranjang", function (e) {
  console.log(e);
    $("#modal_data").empty();
    $("#modal-size").addClass('modal-lg');
    $('.modal-title').text('Edit Keranjang'); // Set Title to Bootstrap modal title
    $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
    $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
    var id = $(this).attr('id');
    // var base_url = "{!! url('/') !!}";
    $.ajax({
        // url: base_url+'/admin_bqs/pengeluaran/editPengeluaran/'+id,
        url: 'keranjangProduk/'+id,
        type: 'get',
        success: function (data) {
          $("#modal-overlay").removeClass();
          $("#modal-overlay-content").removeClass();
          $("#modal_data").html(data.html);
          $('#myModal').modal('show'); // show bootstrap modal
          reload_keranjang_table();
        },
        error: function (result) {
          $("#modal-overlay").removeClass();
          $("#modal-overlay-content").removeClass();
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
          })
          reload_keranjang_table();
        }
    });
});
function reload_keranjang_table() {
    table_keranjang.ajax.reload(null, false); //reload datatable ajax
}
$("#input_diskon").change(function(){
  getPerhitungan();
});
$("#input_bayar").change(function(){
  getPerhitungan();
});
function getPerhitungan(){
  let subTotal    = ($("#input_subtotal").val() > 0 ? $("#input_subtotal").val() : 0);
  let diskon      = ($("#input_diskon").val() > 0 ? $("#input_diskon").val() : 0);
  let totalBayar  = ($("#input_total_bayar").val() > 0 ? $("#input_total_bayar").val() : 0);
  let bayar       = ($("#input_bayar").val() > 0 ? $("#input_bayar").val() : 0);
  let selisih     = ($("#input_selisih").val() > 0 ? $("#input_selisih").val() : 0);

  let totalharusbayar = subTotal - ((diskon/100) * subTotal);
  $("#input_total_bayar").val(totalharusbayar);

  let selisihBayar = $("#input_bayar").val() - $("#input_total_bayar").val();
  $("#input_selisih").val(selisihBayar);
}
$("#btn_tutupKasir").click(function(){
  $("#modal_data").empty();
  $("#modal-size").addClass('modal-md');
  $('.modal-title').text('Tutup Kasir'); // Set Title to Bootstrap modal title
  $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
  $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
  var id = $(this).attr('id');
  $.ajax({
      url: 'hitungKasir',
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
})
$("#print_pembelian").click(function(){
  var myData = new FormData($("#form_bukaKasir")[0]);
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  myData.append('_token', CSRF_TOKEN);
  myData.append('pembeli', $("#input_pembeli").val());
  myData.append('pembeli_id', $("#input_pembeli_id").val());
  myData.append('sub_total', $("#input_subtotal").val());
  myData.append('diskon', $("#input_diskon").val());
  myData.append('total_bayar', $("#input_total_bayar").val());
  myData.append('bayar', $("#input_bayar").val());
  myData.append('kembalian', $("#input_selisih").val());
  $.ajax({
      url: 'print_pembelian',
      type: 'POST',
      data: myData,
      cache: false,
      processData: false,
      contentType: false,
      success: function (data) {
         var myWindow = window.open(data, "_blank", "scrollbars=yes,width=700,height=600,top=300");
         $(myWindow.document.body).html(data);
         myWindow.focus();
      },
      error: function (result) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
  });
});
</script>
@endsection