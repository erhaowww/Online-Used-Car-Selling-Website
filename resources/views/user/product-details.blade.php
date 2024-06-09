@extends('user/master')
@section('content')

<style>
  .lSGallery img {
    width: 100% !important;
    height: 100% !important;
    /* object-fit: cover !important; */
  }

  .lslide.active img{
    width: 100% !important;
    height: 100% !important;
  }

  .lSSlideOuter .lSSlideWrapper .lSSlide img {
    max-height: 100%;
    max-width: 100%;
  }

  #prevBtn, #nextBtn {
    cursor: pointer;
  }
</style>

  <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Shop Single</h2>
              <p>Home <span>-</span> Shop Single</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->
  <!--================End Home Banner Area =================-->

  <!--================Single Product Area =================-->
  <div class="product_image_area section_padding">
    <div class="container">
      <div class="row s_product_inner justify-content-between">
        <div class="col-lg-7 col-xl-7">
          <div class="product_slider_img">
            @php
            $images = explode('|', $product->product_image);
            @endphp
            <div id="vertical">
              @foreach ($images as $image)
                <div data-thumb="{{ asset('user/img/product/'.$image) }}">
                  <img src="{{ asset('user/img/product/'.$image) }}" />
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-xl-4">
          <div class="s_product_text">
            <h5><a id="prevBtn">previous</a> <span>|</span> <a id="nextBtn">next</a></h5>

            <h3>{{ $product->make }} &nbsp;{{ $product->model }}</h3>
            <h2>RM {{ $product->price }}</h2>
            <ul class="list">
              <li>
                <a href="#"> <span>Availibility</span> : In Stock</a>
              </li>
            </ul>
            <p>
              {{$product->product_description}}
            </p>
            <div class="card_area d-flex justify-content-between align-items-center">
              <a href="" class="btn_3 add-to-cart" id="{{$product->id}}">add to cart</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--================End Single Product Area =================-->

  <!--================Product Description Area =================-->
  <section class="product_description_area">
    <div class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Specification</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
          <p>
            {{ $product->product_description }}
          </p>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>
                    <h5>Year</h5>
                  </td>
                  <td>
                    <h5>{{ $product->product_description }}</h5>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h5>Mileage</h5>
                  </td>
                  <td>
                    <h5>{{ $product->mileage }}</h5>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h5>Color</h5>
                  </td>
                  <td>
                    <h5>{{ $product->color }}</h5>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h5>Transmission</h5>
                  </td>
                  <td>
                    <h5>{{ $product->transmission }}</h5>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!--================End Product Description Area =================-->

  <script>
// Add click events to the previous and next buttons
  $('#prevBtn, #nextBtn').on('click', function(e) {
    e.preventDefault(); // prevent default link behavior
    if ($(this).attr('id') == "prevBtn") {
      $('.lSPrev').click();
    } else if ($(this).attr('id') == "nextBtn") {
      $('.lSNext').click();
    }
  });

  </script>

<script>
  const addToCartBtn = document.querySelector('.add-to-cart');
  
  // add a click event listener to each addToCart button
  addToCartBtn.addEventListener('click', function(event) {
      event.preventDefault();
      const productId = $(this).attr('id');
      // send an AJAX request to the server to update the likes count
      fetch('/addToCart/'+productId)
          .then(response => response.json())
          .then(data => {
              if(data.message === 'success'){
                swal({
                    title: "Item Added to Cart!",
                    text: "Your item has been successfully added to your cart.",
                    icon: "success",
                    timer: 2000, // Display duration in milliseconds
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    animation: {
                        showClass: "animate__animated animate__fadeIn",
                        hideClass: "animate__animated animate__fadeOut"
                    }
                });
              } else if(data.message === 'fail') {
                swal({
                    title: "Add to Cart Failed",
                    text: "This item is already in your cart.",
                    icon: "error",
                    timer: 2000, // Display duration in milliseconds
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    animation: {
                        showClass: "animate__animated animate__fadeIn",
                        hideClass: "animate__animated animate__fadeOut"
                    }
                });
              } else if(data.message === 'owner') {
                swal({
                    title: "Add to Cart Failed",
                    text: "You cannot buy your own product.",
                    icon: "error",
                    timer: 2000, // Display duration in milliseconds
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    animation: {
                        showClass: "animate__animated animate__fadeIn",
                        hideClass: "animate__animated animate__fadeOut"
                    }
                });
              } else if(data.message === 'no login') {
                window.location.href = '/login';
              }
          });
    });
  </script>

@endsection
        