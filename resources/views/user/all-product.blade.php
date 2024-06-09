<link rel="stylesheet" href="{{ asset('user/css/price_rangs.css') }}">
@extends('user/master')
@section('content')
<script src="{{ asset('user/js/price_rangs.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js"></script>

<style>
    .simple-pagination ul {
        margin: 0 0 20px;
        padding: 0;
        list-style: none;
        text-align: center;
    }

    .simple-pagination li {
        display: inline-block;
        margin-right: 5px;
    }

    .simple-pagination li a,
    .simple-pagination li span {
        color: #666;
        padding: 5px 10px;
        text-decoration: none;
        border: 1px solid #EEE;
        background-color: #FFF;
        box-shadow: 0px 0px 10px 0px #EEE;
    }

    .simple-pagination .current {
        color: #FFF;
        background-color: #FF7182;
        border-color: #FF7182;
    }

    .simple-pagination .prev.current,
    .simple-pagination .next.current {
        background: #e04e60;
    }

    .card-container {
        background-color: #fff;
        border-radius: 0.25rem;
        margin-top: 10px;
        overflow: hidden;
    }

    .card-container ul {
        display: flex;
        padding: 0;
        margin: 0;
    }

    .card-container li {
        display: flex;
        align-items: center;
        padding: 10px;
        flex: 1;
    }

    .card-container li:not(:last-child) {
        border-right: 1px solid #ddd;
    }

    .card-container li i {
        margin-right: 5px;
    }

    .irs-single {
        left: 0% !important;
    }

</style>
<!--================Home Banner Area =================-->
<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <h2>Shop Category</h2>
                        <p>Home <span>-</span> Shop Category</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb start-->

<!--================Category Product Area =================-->
<section class="cat_product_area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="left_sidebar_area">
                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Product filters</h3>
                        </div>
                        <div class="widgets_inner">
                            <ul class="list">
                                @foreach($products->unique('make') as $product)
                                    <li><a href="#" class="make" data-make={{$product->make}}>{{ $product->make }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>

                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Color Filter</h3>
                        </div>
                        <div class="widgets_inner">
                            <ul class="list">
                                @foreach($products->pluck('color')->unique() as $color)
                                    <li><a href="#" class="color" data-color={{$color}}>{{ $color }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>

                    <aside class="left_widgets p_filter_widgets price_rangs_aside">
                        <div class="l_w_title">
                            <h3>Price Filter</h3>
                        </div>
                        <div class="widgets_inner">
                            <div class="range_item">
                                <!-- <div id="slider-range"></div> -->
                                <input type="text" class="js-range-slider" value="" />
                                <div class="d-flex">
                                    <div class="price_value d-flex justify-content-center">
                                        <input type="text" class="js-input-from" id="amount" style="border:1px solid rgb(212,212, 212);max-width:67px !important;"/>
                                        <span>TO</span>
                                        <input type="text" class="js-input-to" id="amount" style="border:1px solid rgb(212,212, 212);max-width:67px !important;"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product_top_bar d-flex justify-content-between align-items-center">
                            <div class="single_product_menu">
                                <p><span>{{count($products)}} </span> Product Found</p>
                            </div>
                            <div class="single_product_menu d-flex sorting">
                                <h5>sort by : </h5>
                                <select id="sort-by-select">
                                    <option value="latest">Latest</option>
                                    <option value="priceLowToHigh">Price: Low to High</option>
                                    <option value="priceHighToLow">Price: High to Low</option>
                                    <option value="yearOldToNew">Manufacture Year: Old to New</option>
                                    <option value="yearNewToOld">Manufacture Year: New to Old</option>
                                    <option value="mileageLowToHigh">Mileage: Low to High</option>
                                    <option value="mileageHighToLow">Mileage: High to Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center latest_product_inner list-wrapper">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-sm-6 list-item" data-make={{$product->make}} data-color={{$product->color}} data-year={{$product->year}} data-mileage={{$product->mileage}}>
                            <div class="single_product_item">
                                @php
                                    $images = explode('|', $product->product_image);
                                @endphp
                                <img src="{{ asset('user/img/product/'.$images[0]) }}" alt="" style="width: 100%;">
                                <div class="single_product_text">
                                    <h4>{{ $product->make .' '. $product->model }}</h4>
                                    <h3 class="product_price">RM {{ $product->price }}</h3>
                                    <a href="{{ route('products.details',$product->id) }}" class="add_cart">View More</a>
                                </div>
                                <div class="card-container">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-calendar-alt"></i> {{$product->year}}</li>
                                        <li><i class="fas fa-tachometer-alt"></i> {{$product->mileage}} km</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-12">
                        <div id="pagination-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--================End Category Product Area =================-->


<script>
    // Wait for the DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
  
  // Get the product cards
  const productCards = document.querySelectorAll('.list-item');

  // Get the price range input elements
  const priceRange = document.querySelector('.js-range-slider');
  const priceInputFrom = document.querySelector('.js-input-from');
  const priceInputTo = document.querySelector('.js-input-to');

  // Function to filter products based on price range
  function filterProducts() {
    // Get the minimum and maximum price values
    const minPrice = priceRange.min;
    const maxPrice = priceRange.max;
    const currentMinPrice = priceRange.value.split(';')[0];
    const currentMaxPrice = priceRange.value.split(';')[1];
    console.log("min=" + currentMinPrice);
    console.log("max=" + currentMaxPrice);

    // Loop through all the product cards
    for (let i = 0; i < productCards.length; i++) {
      // Get the price of the current product card
      const price = parseFloat(productCards[i].querySelector('.product_price').innerText.replace(/[^\d.-]/g, ''));
      console.log("product price="+price);
      // Check if the price is within the new price range
      if (price >= currentMinPrice && price <= currentMaxPrice) {
        // Show the product card
        productCards[i].style.display = 'block';
        console.log("product show="+price);
      } else {
        // Hide the product card
        productCards[i].style.display = 'none';
      }
    }
    initializePagination();
  }

  // Attach the filterProducts function to the price range input element's onchange event
  priceRange.onchange = filterProducts;
  priceInputFrom.onchange = filterProducts;
  priceInputTo.onchange = filterProducts;

});
</script>

<!-- JavaScript code to filter products -->
<script>
  const makeFilters = document.querySelectorAll('.make');
  const colorFilters = document.querySelectorAll('.color');
  const products = document.querySelectorAll('.list-item');

  makeFilters.forEach(makeFilters => {
    makeFilters.addEventListener('click', e => {
    e.preventDefault();
      const selectedFilter = makeFilters.dataset.make;
      console.log(selectedFilter);

      products.forEach(product => {
        if (product.dataset.make === selectedFilter) {
          product.style.display = 'block';
        } else {
          product.style.display = 'none';
        }
      });
      initializePagination();
    });
  });

  colorFilters.forEach(colorFilters => {
    colorFilters.addEventListener('click', e => {
    e.preventDefault();
      const selectedFilter = colorFilters.dataset.color;

      products.forEach(product => {
        if (product.dataset.color === selectedFilter) {
          product.style.display = 'block';
        } else {
          product.style.display = 'none';
        }
      });
      initializePagination();
    });
  });
</script>

<script>
    // jQuery Plugin: http://flaviusmatis.github.io/simplePagination.js/

    function initializePagination() {
        var items = $(".list-wrapper .list-item").filter(":visible");
        var numItems = items.length;
        var perPage = 9;

        items.slice(perPage).hide();

        $('#pagination-container').pagination({
            items: numItems,
            itemsOnPage: perPage,
            prevText: "&laquo;",
            nextText: "&raquo;",
            onPageClick: function (pageNumber) {
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
                window.scroll({
                    top: 500, left: 0,
                    behavior: 'smooth'
                });
            }
        });
    }

    $(document).ready(function() {
        initializePagination();
    });
</script>

<script>
    const select = document.getElementById("sort-by-select");
    const productList = document.querySelectorAll(".list-item");
    const productContainer = document.querySelector(".list-wrapper");
    const paginationContainer = document.getElementById("pagination-container");
    
    $('.sorting').on("change", select, function() {
        var sortBy = $(select).val();
        switch (sortBy) {
            case "latest":
                productList.forEach((item) => item.style.order = "");
            break;

            case "priceLowToHigh":
                productList.forEach(
                    (item) =>
                    (item.style.order = parseInt(item.querySelector(".product_price").textContent.split(" ")[1]))
                );
                // Move pagination container after product container
                productContainer.after(paginationContainer);
            break;

            case "priceHighToLow":
                productList.forEach(
                    (item) =>
                    (item.style.order = -parseInt(item.querySelector(".product_price").textContent.split(" ")[1]))
                );
            break;

            case "yearOldToNew":
                productList.forEach((item) => (item.style.order = item.dataset.year));
                productContainer.after(paginationContainer);
            break;

            case "yearNewToOld":
                productList.forEach((item) => (item.style.order = -item.dataset.year));
            break;

            case "mileageLowToHigh":
                productList.forEach((item) => (item.style.order = parseInt(item.dataset.mileage)));
                productContainer.after(paginationContainer);
            break;

            case "mileageHighToLow":
                productList.forEach((item) => (item.style.order = -parseInt(item.dataset.mileage)));
            break;

            default:
                productList.forEach((item) => item.style.order = "");
            break;
        }
    });
</script>
@endsection