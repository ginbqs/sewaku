<header class="header-area clearfix">
    <!-- Close Icon -->
    <div class="nav-close">
        <i class="fa fa-close" aria-hidden="true"></i>
    </div>
    <!-- Logo -->
    <div class="logo">
        <a href="/"><img src="{{ asset($config['logo']) }}" alt=""></a>
    </div>
    <!-- Amado Nav -->
    <nav class="amado-nav">
        <ul>
            <li name="menu_home"><a href="/">Home</a></li>
         
        </ul>
    </nav>
    <!-- Button Group -->
    <div class="amado-btn-group mt-30 mb-100">
        @if(isset($config['login_website']) && $config['login_website']=='on')
        <a href="#" class="btn amado-btn" style="margin-bottom: 0;padding-bottom: 0;">LOGIN</a>
        @endif
        <!-- <a href="#" class="btn amado-btn active" id="login_aplikasi"></a> -->
    </div>
    <!-- Cart Menu -->
    <div class="cart-fav-search mb-100">
        <a href="{{ URL :: to('keranjang') }}" class="cart-nav" id="menu_keranjang"><i class="icon_cart_alt" style="margin-right:10px"></i> Keranjang <span>(<span id="total_keranjang"></span>)</span></a>
        @if(isset($config['login_website']) && $config['login_website']=='on')
        <a href="#" class="fav-nav"><i class="icon_wallet" style="margin-right:10px"></i> Pesanan</a>
        @endif
        <a href="#" class="search-nav"><i class="icon_search" style="margin-right:10px"></i> Search</a>
    </div>
    <!-- Social Button -->
    <div class="social-info d-flex justify-content-between">
    </div>
</header>