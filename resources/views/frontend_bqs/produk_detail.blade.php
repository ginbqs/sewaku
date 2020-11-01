@extends('frontend_bqs.layouts.app')
@section('title','BQS - JENIS PRODUK')
@section('content')
<div class="main-content-wrapper d-flex clearfix">
    <!-- Product Details Area Start -->
    <div class="single-product-area section-padding-100 clearfix" style="padding-top: 10px">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-50">
                            <li class="breadcrumb-item"><a href="#">{{$menu['menu_title']}}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{$menu['menu_sub_title']}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="single_product_thumb">
                        <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @if($data['foto_thumnail']!='')
                                <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(' {{asset($data['foto_thumnail'])}}');">
                                </li>
                                @endif
                                <?php $i=0 ?>
                                @foreach($dtIMG as $key)
                                {{ $active = ($data['foto_thumnail']=='' && $i==0 ? 'active' : '') }}
                                <li data-target="#product_details_slider" class="{{$active}}" data-slide-to="1" style="background-image: url(' {{asset($key['foto_thumnail'])}}');">
                                </li>
                                <?php $i++ ?>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @if($data['foto_thumnail']!='')
                                <div class="carousel-item active">
                                    <a class="gallery_img" href="{{ asset($data['foto_thumnail']) }}">
                                        <img class="d-block w-100" src="{{ asset($data['foto_thumnail']) }}" alt="First slide">
                                    </a>
                                </div>
                                @endif
                                <?php $i=0 ?>
                                @foreach($dtIMG as $key)
                                {{ $active = ($data['foto_thumnail']=='' && $i==0 ? 'active' : '') }}
                                <div class="carousel-item {{$active}}">
                                    <a class="gallery_img" href="{{ asset($key['foto_thumnail']) }}">
                                        <img class="d-block w-100" src="{{ asset($key['foto_thumnail']) }}" alt="Second slide">
                                    </a>
                                </div>
                                <?php $i++ ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="single_product_desc">
                        <!-- Product Meta Data -->
                        <div class="product-meta-data">
                            <div class="line"></div>
                            <p class="product-price">Rp. {{number_format($data['harga_jual'],2)}}</p>
                            <a href="product-details.html">
                                <h6>{{$data['nama']}}</h6>
                            </a>
                            <!-- Ratings & Review -->
                            <!-- <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                <div class="ratings">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="review">
                                    <a href="#">Write A Review</a>
                                </div>
                            </div> -->
                            <!-- Avaiable -->
                            <!-- <p class="avaibility"><i class="fa fa-circle"></i> In Stock</p> -->
                        </div>

                        <div class="short_overview my-5">
                            <p>{{isset($data['detail']) && $data['detail']!='' ? $data['detail'] : '-'}}</p>
                        </div>

                        <!-- Add to Cart Form -->
                        <form class="cart clearfix" method="post">
                            <div class="cart-btn d-flex mb-50">
                                <p>Jumlah</p>
                                <div class="quantity">
                                    <span class="qty-minus" onclick="var effect = document.getElementById('jmlKeranjang'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                    <input type="number" class="qty-text" id="jmlKeranjang" step="1" min="1" max="300" name="quantity" value="1">
                                    <span class="qty-plus" onclick="var effect = document.getElementById('jmlKeranjang'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            @if(count($dt_ukuran) > 0)
                            <div class="cart-btn d-flex mb-50">
                                <p>Ukuran</p>
                                <div class="quantity">
                                    <select class="form-control" style="width:100%;" id="ukuran_jenis" name="ukuran_jenis">
                                        @foreach($dt_ukuran as $ukuran)
                                        <option value={{$ukuran->id}}>{{$ukuran->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <button type="button" name="addtocart" value="5" class="btn amado-btn" id="btnTambahKeranjang">Tambah ke Keranjang</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Details Area End -->
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
.img_sizeDetail{
    width: 801.88px;
    height: 828.48px;
}
/* md */
@media (min-width: 992px) {
    .img_sizeDetail{
        width: 801.88px;
        height: 828.48px;
    }
}
</style>
<script type="text/javascript">
    $("#btnTambahKeranjang").click(function(){
        var data = {};
        @if(count($dt_ukuran) > 0)
        var ukuran_id = $("#ukuran_jenis").val();
        @else
        var ukuran_id = '-';
        @endif
        data = {
            'id'        : "{{$data['id']}}",
            'foto'      : "{{$data['foto_thumnail']}}",
            'nama'      : "{{$data['nama']}}",
            'harga'     : "{{$data['harga_jual']}}",
            'jumlah'    : $("#jmlKeranjang").val(),
            'ukuran'    : $("#ukuran_jenis :selected").text(),
            'ukuran_id' : ukuran_id,
        };
        setKeranjang(data);
    });
</script>
@endsection
