@extends('admin.layouts.admin')
@section('title','Semua Pembelian')
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
          TABEL PEMBELIAN
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
      <div class="card-body pad" id="kasir_input" >
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-info">
                  <div class="card-header">
                    <h2 class="card-title">KERANJANG</h2>
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
                            <label for="input_selisih">Selisih</label>
                            <input type="number" id="input_selisih" class="form-control" name="input_selisih" autocomplete="off" placeholder="Selisih" step="any" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-12">
                          <button type="submit" class="btn btn-info  btn-block">BAYAR</button>
                        </div>
                        <div class="col-12" style="padding-top: 10px">
                          <button type="button" class="btn btn-default btn-block" id="btn_kembali">Kembali</button>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-footer -->
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
  $("#menu_kasir").addClass('menu-open');
  $("#menu_kasir_detail").addClass('active');
  $("#btn_kembali").click(function() {
    window.location.href = "{{ URL :: to('/admin_bqs/kasir') }}";
  });
  getKeranjang();
 
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
                    $("#btn_kembali").click();
                } else if (data.type === 'error') {
                    if (data.errors) {
                        $.each(data.errors, function (key, val) {
                            $('#error_' + key).html(val);
                            $("#"+key).addClass('is-invalid');
                        });
                    }
                    $("#submit").prop('disabled', false); // disable button
                }
                reload_keranjang_table();
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
});
function getKeranjang(){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      url: 'getKeranjang',
      type: 'get',
      dataType: 'json',
      success: function (data) {
        $("#input_pembeli").val('GUEST');
        $("#input_subtotal").val(data.data.total_nilai_terjual);
        $("#input_diskon").val(0);
        $("#input_total_bayar").val(data.data.total_nilai_terjual);
        $("#input_bayar").val(data.data.total_nilai_terjual);
        $("#input_selisih").val(0);
        $("#perhitungan_total").html('Rp. '+data.data.total_nilai_terjual);
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
  $("#input_bayar").val(totalharusbayar);

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
</script>
@endsection