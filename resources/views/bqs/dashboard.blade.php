@extends('bqs.layouts.admin')
@section('title','DASHBOARD')
@section('breadcumb')
	<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
@endsection
@section('content')

<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3 id="total_transaksi">0</h3>

        <p>Transaksi</p>
      </div>
      <div class="icon">
        <i class="fas fa-cash-register"></i>
      </div>
      <a href="{{ URL :: to('bqs_template/kasir') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3 id="total_user">0<sup style="font-size: 20px"></sup></h3>

        <p>Total User</p>
      </div>
      <div class="icon">
        <i class="fas fa-user"></i>
      </div>
      <a href="{{ URL :: to('bqs_template/users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3 id="total_barang">0</h3>

        <p>Barang</p>
      </div>
      <div class="icon">
        <i class="fas fa-store"></i>
      </div>
      <a href="{{ URL :: to('bqs_template/barang') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>Chart</h3>

        <p>-</p>
      </div>
      <div class="icon">
        <i class="fas fa-chart-area"></i>
      </div>
      <a href="{{ URL :: to('bqs_template/semua') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<div class="row">
  <div class="col-md-12">
    <!-- Bar chart -->
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">Chart Transaksi</h3>

        <div class="card-tools">
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
<script type="text/javascript">
$(function(){
  getTotal();
  reload_table();
})
function reload_table() {
  var myData = new FormData();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  myData.append('_token', CSRF_TOKEN);
  var base_url = "{!! url('/') !!}";
  $.ajax({
    url: base_url+'/bqs_template/getChartSemuaTransBulanan',
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
function getTotal(){
    var myData = new FormData();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    myData.append('_token', CSRF_TOKEN);
    var base_url = "{!! url('/') !!}";
    $.ajax({
      url: base_url+'/bqs_template/getTotalDashboard',
      type: 'POST',
      data: myData,
      dataType: 'json',
      cache: false,
      processData: false,
      contentType: false,
      success: function (data) {
        $("#total_user").html(data.total_user);
        $("#total_transaksi").html(data.total_transaksi);
        $("#total_barang").html(data.total_barang);
      },
      error: function (result) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
        })
      }
    });
}
</script>
@endsection