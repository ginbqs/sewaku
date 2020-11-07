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
                    <form role="form" id="create"   enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    {{method_field('PATCH')}}
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="input_peminjam">Peminjam</label><br>
                              <input type="text" id="input_peminjam" class="form-control" name="input_peminjam" placeholder="Peminjam" autocomplete="off">
                              <input type="hidden" id="input_peminjam_id" class="form-control" name="input_peminjam_id" autocomplete="off" >
                              <input type="hidden" id="input_action" class="form-control" name="input_action" autocomplete="off" value="{{$act}}">
                            </div>
                            <div class="form-group">
                              <label for="input_pinjam">Tanggal Pinjam</label><br>
                              <input type="text" id="input_pinjam" class="form-control" name="input_pinjam" placeholder="Tanggal Pinjam" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <label for="input_harus_dikembalikan">Tanggal Harus Dikembalikan</label><br>
                              <input type="text" id="input_harus_dikembalikan" class="form-control" name="input_harus_dikembalikan" placeholder="Tanggal Harus Dikembalikan" autocomplete="off">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="input_keterangan">Keterangan</label>
                              <textarea name="input_keterangan" id="input_keterangan" placeholder="Keterangan" class="form-control" rows="5"></textarea>
                              <span id="input_keterangan" class="error invalid-feedback"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->

                      <div class="card-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ URL :: to('/bqs_template/kasir') }}">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">
                            Close
                        </button>
                        </a>
                      </div>
                    </form>
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
  
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $("#input_peminjam" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url:"{{route('admin.autocompleteUser.user')}}",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term,
           table:'provinsi'
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
       $('#input_peminjam').val(ui.item.label); // display the selected text
       $('#input_peminjam_id').val(ui.item.value); // save selected id to input
       return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li style='padding-left:10px;'>" )
      .data( "ui-autocomplete-item", item )
      .append(  item.label + "<br><span style='font-size:11;font-style:italic'>Longitude / Latitude : " + item.longitude + " / " + item.longitude + "</span>" )
      .appendTo( ul );
  }
  $('#create').validate({
    submitHandler: function (form) {
        var myData = new FormData($("#create")[0]);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        myData.append('_token', CSRF_TOKEN);

        $.ajax({
            url: 'kasir',
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
                    var base_url = "{!! url('/') !!}";
                    window.location = base_url+'/bqs_template/kasir/' + data.id + '/edit';
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
</script>
@endsection
