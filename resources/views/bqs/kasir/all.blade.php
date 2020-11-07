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
                  <div class="col-md-12" style="padding-bottom: 20px">
                    <a href="{{ URL :: to('/bqs_template/kasir/create') }}">
                    <button class="btn btn-primary" ><i class="fas fa-plus-square"></i>
                        Tambah Kasir
                    </button>
                    </a>
                    <button class="btn btn-success" onclick="reload_table()"><i class="fas fa-sync"></i> 
                        Refresh
                    </button>
                  </div>
                  <div class="col-md-12 col-sm-12 table-responsive">
                      <table id="manage_all" class="table table-collapse table-bordered table-hover  table-striped">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Nama</th>
                              <th>Tanggal</th>
                              <th>Barang</th>
                              <th>Pembayaran</th>
                              <th>Status</th>
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
	$("#menu_transaksi").addClass('menu-open');
	$("#menu_transaksi").addClass('active');
  table = $("#manage_all").DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('admin.allKasir.kasir') !!}',
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
function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}
$("#manage_all").on("click", ".edit", function () {
  var id = $(this).attr('id');
  var base_url = "{!! url('/') !!}";
  window.location = base_url+'/bqs_template/kasir/' + id + '/edit';
    
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
            url: 'kasir/' + id,
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

</script>
@endsection