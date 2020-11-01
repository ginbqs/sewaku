<footer class="footer_area clearfix">
    <div class="container">
        <div class="row align-items-center">
            <!-- Single Widget Area -->
            <div class="col-12 col-lg-4">
                <div class="single_widget_area">
                    <!-- Logo -->
                    <div class="footer-logo mr-50">
                        <a href="{{ URL :: to('/') }}"><img src="{{ asset($config['logo']) }}" alt=""></a>
                    </div>
                    
                </div>
            </div>
            <!-- Single Widget Area -->
            <div class="col-12 col-lg-8">
                <div class="single_widget_area">
                    <!-- Footer Menu -->
                    <div class="footer_menu">
                        <nav class="navbar navbar-expand-lg justify-content-end">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footerNavContent" aria-controls="footerNavContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                            <div class="collapse navbar-collapse" id="footerNavContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item" name="menu_home">
                                        <a class="nav-link" href="{{ URL :: to('/') }}">Home</a>
                                    </li>
                                  
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ asset('frontEnd_v1/cart.html') }}">Keranjang</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ asset('frontEnd_v1/checkout.html') }}">Pesanan</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>