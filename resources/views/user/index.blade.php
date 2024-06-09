@extends('user/master')
@section('content')
<!-- banner part start-->
<section class="banner_part">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="banner_slider owl-carousel">
                    <div class="single_banner_slider">
                        <div class="row">
                            <div class="col-lg-5 col-md-8">
                                <div class="banner_text">
                                    <div class="banner_text_iner">
                                        <h1>Find Your Dream Car</h1>
                                        <p>Looking for a reliable used car? Check out our wide selection of high-quality pre-owned vehicles at unbeatable prices.</p>
                                        <a href="{{route('products.index')}}" class="btn_2">buy now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="banner_img d-none d-lg-block">
                                <img src="{{asset('user/img/banner/banner1.png')}}" alt="">
                            </div>
                        </div>
                    </div><div class="single_banner_slider">
                        <div class="row">
                            <div class="col-lg-5 col-md-8">
                                <div class="banner_text">
                                    <div class="banner_text_iner">
                                        <h1>Shop for Used Cars</h1>
                                        <p>Discover a wide selection of quality used cars at affordable prices.</p>
                                        <a href="{{route('products.index')}}" class="btn_2">buy now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="banner_img d-none d-lg-block">
                                <img src="{{asset('user/img/banner/banner2.png')}}" alt="">
                            </div>
                        </div>
                    </div><div class="single_banner_slider">
                        <div class="row">
                            <div class="col-lg-5 col-md-8">
                                <div class="banner_text">
                                    <div class="banner_text_iner">
                                        <h1>Upgrade Your Ride</h1>
                                        <p>Find the perfect car that fits your lifestyle and budget from our selection of quality used cars.</p>
                                        <a href="{{route('products.index')}}" class="btn_2">buy now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="banner_img d-none d-lg-block">
                                <img src="{{asset('user/img/banner/banner3.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="single_banner_slider">
                        <div class="row">
                            <div class="col-lg-5 col-md-8">
                                <div class="banner_text">
                                    <div class="banner_text_iner">
                                        <h1>Get Behind the Wheel</h1>
                                        <p>Explore our collection of pre-owned cars and find the one that meets your needs.</p>
                                        <a href="#" class="btn_2">buy now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="banner_img d-none d-lg-block">
                                <img src="{{asset('user/img/banner/banner4.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-counter"></div>
            </div>
        </div>
    </div>
</section>
<!-- banner part start-->

<!-- feature_part start-->
<section class="feature_part padding_top">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section_tittle text-center">
                    <h2>Featured Category</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between">
            @php
                $i = 0;
            @endphp
            @foreach ($products as $item)
                @php
                    if($i==0 || $i==3)
                    {
                        $num = "7";
                        $imageWidth = 300;
                    }
                    else 
                    {
                        $num = "5";
                        $imageWidth = 220;
                    }
                @endphp
                @if ($i <= 3)
                    <div class="col-lg-{{$num}} col-sm-6">
                        <div class="single_feature_post_text">
                            <p>Quality Used Cars</p>
                            <h3>{{$item->make}} {{$item->model}}</h3>
                            <a href="{{ route('products.details',$item->id) }}" class="feature_btn">EXPLORE NOW <i class="fas fa-play"></i></a>
                            @php
                                $imageArray = explode('|', $item->product_image);
                            @endphp
                            <img src="{{asset('user/img/product/'.$imageArray[0])}}" width="{{$imageWidth}}" height="{{$imageWidth}}" alt="">
                        </div>
                    </div>
                @endif
                @php
                    $i++;
                @endphp
            @endforeach
        </div>
    </div>
</section>
<!-- upcoming_event part start-->

<!-- product_list start-->
<section class="product_list section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section_tittle text-center">
                    <h2>awesome <span>shop</span></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="product_list_slider owl-carousel">
                    <div class="single_product_list_slider">
                        <div class="row align-items-center justify-content-between">
                            @foreach ($products_list1 as $item)
                                <div class="col-lg-3 col-sm-6">
                                    <div class="single_product_item">
                                        @php
                                            $imageArray = explode('|', $item->product_image);
                                        @endphp
                                        <img src="{{asset('user/img/product/'.$imageArray[0])}}" alt="">
                                        <div class="single_product_text">
                                            <h4>{{$item->make}} {{$item->model}}</h4>
                                            <h3>RM{{$item->price}}</h3>
                                            <a href="{{ route('products.details',$item->id) }}" class="add_cart">+ View More</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="single_product_list_slider">
                        <div class="row align-items-center justify-content-between">
                            @foreach ($products_list2 as $item)
                                <div class="col-lg-3 col-sm-6">
                                    <div class="single_product_item">
                                        @php
                                            $imageArray = explode('|', $item->product_image);
                                        @endphp
                                        <img src="{{asset('user/img/product/'.$imageArray[0])}}" alt="">
                                        <div class="single_product_text">
                                            <h4>{{$item->make}} {{$item->model}}</h4>
                                            <h3>RM{{$item->price}}</h3>
                                            <a href="{{ route('products.details',$item->id) }}" class="add_cart">+ View More</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product_list part start-->
@endsection