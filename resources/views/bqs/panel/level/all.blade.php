@extends('bqs.layouts.admin')
@section('title','Semua level')
@section('breadcumb')
	<li class="breadcrumb-item"><a href="#">Access Managemen</a></li>
	<li class="breadcrumb-item active">Level</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-outline card-info">
      <div class="card-header">
        <h3 class="card-title">
          TABEL LEVEL
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
                        Tambah Level
                    </button>
                    <button class="btn btn-success" id="btn_refresh"><i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                  </div>
                  <div class="col-md-12 col-sm-12 table-responsive">
                      <table id="manage_all" class="table table-collapse table-bordered table-hover  table-striped">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Level</th>
                              <th>Nama</th>
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
	$("#menu_access_management").addClass('menu-open');
  $("#menu_access_management_level").addClass('active');
  table_level = $("#manage_all").DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('admin.allLevel.level') !!}',
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
    table_level.ajax.reload(null, false); //reload datatable ajax
}
function create(){
  $("#modal_data").empty();
  $('.modal-title').text('Tambah Level');
  // $("#modal-size").addClass('modal-xl');
  $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
  $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
  $.ajax({
    type:'GET',
    url:'level/create',
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
        $("#modal_data").html("Sorry Cannot Load Data");
    }
  })
}
$("#manage_all").on("click", ".edit", function () {
    $("#modal_data").empty();
    $('.modal-title').text('Edit Level'); // Set Title to Bootstrap modal title
    $("#modal-overlay").addClass('overlay d-flex justify-content-center align-items-center');
    $("#modal-overlay-content").addClass('fas fa-2x fa-sync fa-spin');
    var id = $(this).attr('id');

    $.ajax({
        url: 'level/' + id + '/edit',
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
            $("#modal_data").html("Sorry Cannot Load Data");
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
            url: 'level/' + id,
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
                    Swal.fire({
                      icon: 'error',
                      title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
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
    })
});
</script>
@endsection