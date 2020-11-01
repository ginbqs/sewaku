@extends('frontend_bqs.layouts.app')
@section('title','BQS - SHOP')
@section('content')
<div class="amado-pro-catagory clearfix">
    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div class="img_size403 img_dummy" id="home_img_dummy_1">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_1"></span>
    </div>

    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div class="img_size639 img_dummy" id="home_img_dummy_2">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_2"></span>
    </div>

    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div class="img_size403 img_dummy" id="home_img_dummy_3">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_3"></span>
    </div>

    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div class="img_size403 img_dummy" id="home_img_dummy_4">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_4"></span>
    </div>

    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div  class="img_size403 img_dummy" id="home_img_dummy_5">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_5"></span>
    </div>

    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div class="img_size403 img_dummy" id="home_img_dummy_6">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_6"></span>
    </div>

    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div class="img_size639 img_dummy" id="home_img_dummy_7">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_7"></span>
    </div>

    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div class="img_size639 img_dummy" id="home_img_dummy_8">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_8"></span>
    </div>

    <!-- Single Catagory -->
    <div class="single-products-catagory clearfix">
        <div  class="img_size403 img_dummy" id="home_img_dummy_9">
            <span class="title_img_dumy">IMG</span>
        </div>
        <span id="content_img_9"></span>
    </div>
</div>
<style type="text/css">
.img_dummy {
    background-color: #c9c9c9;
    display: flex;
    justify-content: center;
    align-items: center;
    border-top: 1px solid white;
    border-bottom: : 1px solid white;
}
.img_size639{
    width: 400px;
    height: 355.83px;
}
.img_size403{
    width: 400px;
    height: 355.83px;
}
.title_img_dumy{
    color:#e0e0e0;
    font-size: 50px
}
/* md */
@media (min-width: 992px) {
    .img_dummy {
        background-color: #c9c9c9;
        display: flex;
        justify-content: center;
        align-items: center;
        border-left: 1px solid white;
        border-right: 1px solid white;
    }
    .img_size639{
        width: 450.3px;
        height: 639.53px;
    }
    .img_size403{
        width: 450.3px;
        height: 400.3px;
    }
    .title_img_dumy{
        color:#e0e0e0;
        font-size: 100px
    }
}
</style>
<script type="text/javascript">
$(document).ready(function () {
    getDataFavorite();
});
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
function getDataFavorite(){
    const urlParams = new URLSearchParams(window.location.search);
    const mySearch = urlParams.get('search');
    nameClass = ['','img_size403','img_size639','img_size403','img_size403','img_size403','img_size403','img_size639','img_size639','img_size403'];
    $.ajax({
        type:'POST',
        url:'getDataFavorite',
        data:{
            _token: CSRF_TOKEN,
            mySearch: mySearch, // Second add quotes on the value.
        },
        dataType: 'json',
        success: function (data) {
            let res = data.data;
            let res2 = data.favorite;
            if(res.length > 0){
                let no = 1;
                $.each(res, function(i, item) {
                    $('#home_img_dummy_'+no).hide();
                    var img = (item.foto_thumnail ? item.foto_thumnail : res2[i].img);
                    var htmlImg = '';
                    htmlImg += "<a href='"+item.link+"' id='home_link_"+i+"'>";
                        htmlImg += "<img src='{{ asset('') }}"+img+"' class='"+nameClass[no]+"' alt='"+item.nama+"'>";
                        htmlImg += '<div class="hover-content">';
                            htmlImg += '<div class="line"></div>';
                            htmlImg += '<p>Harga Rp. '+item.harga+'</p>';
                            htmlImg += '<h4>'+item.nama+'</h4>';
                        htmlImg += '</div>';
                    htmlImg += '</a>';
                    $('#content_img_'+no).html(htmlImg);
                    no++;
                });
            }
            for (var i = res.length+1; i <= 9; i++) {
                no = (i-1);
                $('#home_img_dummy_'+i).hide();
                var img =  res2[no].img;
                var htmlImg = '';
                htmlImg += "<a href='#' id='home_link_"+i+"'>";
                    htmlImg += "<img src='{{ asset('') }}"+img+"' class='"+nameClass[i]+"' alt='"+res2[no].nama+"'>";
                    htmlImg += '<div class="hover-content">';
                        htmlImg += '<div class="line"></div>';
                        htmlImg += '<p>Harga Rp. '+res2[no].harga+'</p>';
                        htmlImg += '<h4>'+res2[no].nama+'</h4>';
                    htmlImg += '</div>';
                htmlImg += '</a>';
                $('#content_img_'+i).html(htmlImg);
            }
        },
          error: function (result) {
            Swal.fire({
              icon: 'error',
              title: 'Terjadi kesalahan pada koneksi! <br>Pastikan koneksi Anda stabil'
            })
          }
      })
}
</script>
@endsection
