<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Respectism</title>

    <link rel="icon" href="{{asset('user/img/favicon.png')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('user/css/bootstrap.min.css')}}">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{asset('user/css/animate.css')}}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{asset('user/css/owl.carousel.min.css')}}">
    <!-- nice select CSS -->
    <link rel="stylesheet" href="{{asset('user/css/nice-select.css')}}">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('user/css/all.css')}}">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="{{asset('user/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/themify-icons.css')}}">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('user/css/magnific-popup.css')}}">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="{{asset('user/css/slick.css')}}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset('user/css/style.css')}}">

    <link rel="stylesheet" href="{{asset('user/css/lightslider.min.css')}}">

    

    
    {{-- sweetalert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- jquery plugins here-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- jquery -->
    <script src="{{asset('user/js/jquery-1.12.1.min.js')}}"></script>
</head>
<body>
    {{View::make('user/header')}}
    {{-- @include('flash-message') --}}
    @yield('content')
    {{View::make('user/footer')}}
    <script src="{{asset('user/js/lightslider.min.js')}}"></script>



    <!-- popper js -->
    <script src="{{asset('user/js/popper.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset('user/js/bootstrap.min.js')}}"></script>
    <!-- easing js -->
    <script src="{{asset('user/js/jquery.magnific-popup.js')}}"></script>
    <!-- swiper js -->
    <script src="{{asset('user/js/swiper.min.js')}}"></script>
    <!-- swiper js -->
    <script src="{{asset('user/js/masonry.pkgd.js')}}"></script>
    <!-- particles js -->
    <script src="{{asset('user/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('user/js/jquery.nice-select.min.js')}}"></script>
    <!-- slick js -->
    <script src="{{asset('user/js/slick.min.js')}}"></script>
    <script src="{{asset('user/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('user/js/waypoints.min.js')}}"></script>
    <script src="{{asset('user/js/contact.js')}}"></script>
    <script src="{{asset('user/js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{asset('user/js/jquery.form.js')}}"></script>
    <script src="{{asset('user/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('user/js/mail-script.js')}}"></script>
    <script src="{{asset('user/js/stellar.js')}}"></script>
    <script src="{{asset('user/js/price_rangs.js')}}"></script>
    <!-- custom js -->
    <script src="{{asset('user/js/custom.js')}}"></script>

{{-- 
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}






</body>

</html>