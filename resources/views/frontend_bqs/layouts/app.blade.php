<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>@yield('title')</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('frontEnd_v1/img/core-img/favicon.ico') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontEnd_v1/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd_v1/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd_v1/css/elegant-icons.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="{{ asset('frontEnd_v1/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>

</head>

<body>
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="{{ URL :: to('jenis_produk/001') }}" method="get">
                            <input type="search" name="search" id="search" placeholder="Type your keyword...">
                            <button type="submit"><img src="{{ asset('frontEnd_v1/img/core-img/search.png') }}" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="position:fixed;right:20px;top:50%; z-index: 2">
        <a href="https://wa.me/+628982200915?text=Assalamualaikum%0ANama%20%3A%20%0AAlamat%20%3A%20%0APesanan%20%3A%20%0AJumlah%20%3A" target="_blank">
        <img src="{{ asset('images/icon_whatsapp1.png') }}" width="100px"></a>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav (max width 767px)-->
        <div class="mobile-nav">
            <!-- Navbar Brand -->
            <div class="amado-navbar-brand">
                <a href="{{ asset('frontEnd_v1/index.html') }}"><img src="{{ asset($config['logo']) }}" alt=""></a>
            </div>
            <!-- Navbar Toggler -->
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Header Area Start -->
        @include('frontend_bqs.layouts.header')
        <!-- Header Area End -->

        <!-- Product Catagories Area Start -->
        <div class="products-catagories-area clearfix">
            @yield('content')
        </div>
        <!-- Product Catagories Area End -->
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Footer Area Start ##### -->
    @include('frontend_bqs.layouts.footer')
    <!-- ##### Footer Area End ##### -->
   
    <!-- Popper js -->
    <script src="{{ asset('frontEnd_v1/js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('frontEnd_v1/js/bootstrap.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('frontEnd_v1/js/plugins.js') }}"></script>
    <!-- Active js -->
    <script src="{{ asset('frontEnd_v1/js/active.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            let getPathName     = window.location.pathname;
            let activeMenu      = getPathName.split('/'); 
            let lastArray       = activeMenu.pop();
            if(lastArray==''){
                $("[name='menu_home']").addClass('active');
            }else{
                $("[name='menu_"+lastArray+"']").addClass('active');
            }
            setKeranjang();
        })
        function notify_view(type, message) {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            icon: type,
            title: '&nbsp&nbsp'+message
          })
        }
        function setKeranjang(data,sumber){
            // $.removeCookie('cookieKeranjangBQS');
            var cookieKeranjangBQS = $.cookie('cookieKeranjangBQS');
            if(typeof cookieKeranjangBQS!='undefined'){
                var dtCookie =  jQuery.parseJSON(cookieKeranjangBQS);
            }else{
                var dtCookie = [];
            }
            var newData = [];
            let newInput = false;
            if(typeof data!='undefined'){
                if(dtCookie.length > 0){
                    $.removeCookie('cookieKeranjangBQS',{ path: '/' });
                    var tambahKeranjang = true;
                    $.each(dtCookie,function(index, value){
                        if(value.id === data.id && value.ukuran_id === data.ukuran_id){
                            tambahKeranjang = false;
                            if(typeof sumber=='undefined'){
                                data.jumlah = parseInt(data.jumlah) + parseInt(value.jumlah)
                            }
                            newInput = true;
                            newData.push(data);
                        }else{
                            newInput = true;
                            newData.push(value);
                        }
                    })
                    if(tambahKeranjang){
                        newInput = true;
                        newData.push(data);
                    }
                }else{       
                    newInput = true;             
                    newData.push(data);
                }
                $.cookie('cookieKeranjangBQS', JSON.stringify(newData), { expires: 7 ,path: '/' });
            }

            if(typeof $.cookie('cookieKeranjangBQS')!='undefined'){
                var totalKeranjang =  jQuery.parseJSON($.cookie('cookieKeranjangBQS'));
            }else{
                var totalKeranjang = [];
            }
            $("#total_keranjang").html(totalKeranjang.length);
            if(newInput){
                notify_view('success','Data Berhasil Masuk Keranjang');
            }
            // console.log('===========setelah=====================');
            // console.log(totalKeranjang);
        }
    </script>
</body>

</html>