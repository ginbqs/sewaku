@extends('bqs.layouts.admin')
@section('title','Semua Transaksi')
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
          TABEL Transaksi
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
                    <button class="btn btn-success" onclick="reload_table()"><i class="fas fa-sync"></i> 
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
                          <div class="row" style="padding-top: 10px">
                            <div class="col-md-4">
                              <select class="form-control" id="filter_jenis_chart" name="filter_jenis_chart">
                                <option value="">-Pilih Jenis Chart-</option>
                                <option value="tahunan">Tahunan</option>
                                <option value="bulanan">Bulanan</option>
                              </select>
                            </div>
                            <div class="col-md-4" id="filter_tahunan"  style="display: none">
                              <select class="form-control" id="filter_tahun" name="filter_tahun">
                                <option value="">-Pilih Tahun-</option>
                                @for($i=date('Y');$i >= date('Y')-10;$i--)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                              </select>
                            </div>
                            <div id="filter_bulanan" class="col-md-4" style="display: none">
                              <select class="form-control" id="filter_bulan" name="filter_bulan">
                                <option value="">-Pilih Bulan-</option>
                                @foreach($bulan as $key => $bln)
                                <option value="{{$key}}">{{$bln}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="row" style="padding-top:20px">
                            <div class="col-md-12 pull-right">
                              <button id="tampilkanChart" class="btn btn-primary">TAMPILKAN</button>
                            </div>
                          </div>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                  </div>
                  <div class="col-md-12 col-sm-12 table-responsive">
                    <div class="row">
                      <div class="col-md-12">
                        <!-- Bar chart -->
                        <div class="card card-success">
                          <div class="card-header">
                            <h3 class="card-title">Chart Transaksi</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="chart">
                              <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                      <!-- /.col -->
                    </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="card-body pad">
          <div class="panel-body">
              <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5" style="font-size: 30px">
                  <div class="row"> 
                    <div class="col-md-6">Total Bayar</div>
                    <div class="col-md-6">
                      Rp. <span id="total_bayar"></span>
                    </div>
                  </div>
                  <div class="row"> 
                    <div class="col-md-6">Total Denda</div>
                    <div class="col-md-6">
                      Rp. <span id="total_denda"></span>
                    </div>
                  </div>
                  <div class="row"> 
                    <div class="col-md-6">Total Pembayaran</div>
                    <div class="col-md-6">
                      Rp. <span id="total_pembayaran"></span>
                    </div>
                  </div>
                  <div class="row"> 
                    <div class="col-md-6">Total Dibayar</div>
                    <div class="col-md-6">
                      Rp. <span id="total_dibayar"></span>
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
  $("#menu_chart").addClass('menu-open');
  $("#menu_chart_chart_peminjaman").addClass('active');
  getTotal();


});

function reload_table() {
  if(cekParam()){
    var myData = new FormData();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    myData.append('_token', CSRF_TOKEN);
    myData.append('filter_jenis_chart', $("#filter_jenis_chart").val());
    myData.append('filter_tahun', $("#filter_tahun").val());
    myData.append('filter_bulan', $("#filter_bulan").val());
    var base_url = "{!! url('/') !!}";
    $.ajax({
      url: base_url+'/bqs_template/getChartSemuaTrans',
      type: 'POST',
      data: myData,
      dataType: 'json',
      cache: false,
      processData: false,
      contentType: false,
      success: function (data) {
          var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false,
            display: true,
            position: 'top',
            labels: {
              boxWidth: 80,
              fontColor: 'black'
            }
          }
          var barChartCanvas = $('#barChart').get(0).getContext('2d')
          Chart.defaults.global.defaultFontFamily = "Lato";
          Chart.defaults.global.defaultFontSize = 18;
          var dataFirst = {
            label: "Bayar",
            data: data.nilai_bayar,
            lineTension: 0,
            fill: false,
            borderColor: 'red'
          };

          var dataSecond = {
            label: "Denda",
            data: data.nilai_denda,
            lineTension: 0,
            fill: false,
            borderColor: 'blue'
          };

          var dataThird = {
            label: "Total Pembayaran",
            data: data.nilai_total,
            lineTension: 0,
            fill: false,
            borderColor: 'green'
          };
          var dataFour = {
            label: "Total Dibayar",
            data: data.nilai_uang,
            lineTension: 0,
            fill: false,
            borderColor: 'black'
          };

        var speedData = {
          labels: data.x_column,
          datasets: [dataFirst, dataSecond, dataThird, dataFour],
        };
          var barChart = new Chart(barChartCanvas, {
            type: 'line', 
            data: speedData,
            options: barChartOptions
          })

          getTotal();
      },
      error: function (result) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
    });
  }
}
function getTotal(){
    var myData = new FormData();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    myData.append('_token', CSRF_TOKEN);
    myData.append('filter_jenis_chart', $("#filter_jenis_chart").val());
    myData.append('filter_tahun', $("#filter_tahun").val());
    myData.append('filter_bulan', $("#filter_bulan").val());
    var base_url = "{!! url('/') !!}";
    $.ajax({
      url: base_url+'/bqs_template/getTotalTransaksi',
      type: 'POST',
      data: myData,
      dataType: 'json',
      cache: false,
      processData: false,
      contentType: false,
      success: function (data) {
        $("#total_bayar").html(data.total_bayar);
        $("#total_denda").html(data.total_denda);
        $("#total_pembayaran").html(data.total_total);
        $("#total_dibayar").html(data.total_uang);
      },
      error: function (result) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
    });
}
$("#filter_jenis_chart").change(function(){
  if($(this).val()=='tahunan'){
    $("#filter_tahunan").show();
    $("#filter_bulanan").hide();
  }else if($(this).val()=='bulanan'){
    $("#filter_tahunan").show();
    $("#filter_bulanan").show();
  }else{
    $("#filter_bulanan").hide();
    $("#filter_tahunan").hide();
  }
})
$("#tampilkanChart").click(function(){
  reload_table();
});
function cekParam(){
  var cek = true;
  if($("#filter_jenis_chart").val()=='tahunan'){
    if($("#filter_tahun").val()==''){
      Swal.fire({
        icon: 'info',
        title: 'Silahkan pilih tahun terlebih dahulu'
      })
      cek =  false;
    }
  }else if($("#filter_jenis_chart").val()=='bulanan'){
    if($("#filter_tahun").val()=='' || $("#filter_bulan").val()==''){
      Swal.fire({
        icon: 'info',
        title: 'Silahkan pilih tahun dan bulan terlebih dahulu'
      })
      cek =  false;
    }
  }else{
    Swal.fire({
      icon: 'info',
      title: 'Silahkan pilih Filter Jenis Chart Terlebih Dahulu'
    })
    cek =  false;
  }
  return cek;
}
</script>
@endsection