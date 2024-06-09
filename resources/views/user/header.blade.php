<!--::header part start::-->
<?php
use App\Models\User;
use App\Models\Order;
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" ></script>
<style>
    .typeahead.dropdown-menu{
        width: 100% !important;
        left: 0px !important;
    }
</style>

<header class="main_menu home_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="/"> <h2>Respectism</h2> </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="menu_icon"><i class="fas fa-bars"></i></span>
                    </button>
                    <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">

                    @if (!Session::has('user'))
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                        <li class="nav-item"><span class="nav-link"></span></li>
                    </ul>
                    @else
                    {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-4" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button> --}}
                        <?php 
                            $data = User::find(Session::get('user')['id']);
                        ?>

                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <img src="{{asset('user/img/profile/'.$data->image)}}" width="40" height="40" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              @if($data->role != 'user')
                                <a class="dropdown-item" href="/admin/admin_portal">Dashboard</a>
                              @endif
                              <a class="dropdown-item" href="/user/edit-profile">Edit Profile</a>
                              <a class="dropdown-item" href="/user/changePassword">Change Password</a>
                              <a class="dropdown-item" href="/user/myCarsOnBid">My Cars on Bid</a>
                              <a class="dropdown-item" href="{{route('payment.displayHistory')}}">Payments</a>
                              <a class="dropdown-item" href="/logout">Log Out</a>
                            </div>
                          </li>   
                          <li class="nav-item"><span class="nav-link"></span></li>
                        </ul>
                    @endif


                    
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/user/sell">Sell</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('products.index')}}">Find</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('reviews')}}">Comments</a>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_1"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Shop
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown_1">
                                    <a class="dropdown-item" href="/all-product"> shop category</a>
                                    <a class="dropdown-item" href="single-product.html">product details</a>
                                    
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_3"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    pages
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                    <a class="dropdown-item" href="login.html"> login</a>
                                    <a class="dropdown-item" href="tracking.html">tracking</a>
                                    <a class="dropdown-item" href="checkout.html">product checkout</a>
                                    <a class="dropdown-item" href="/temp">shopping cart</a>
                                    <a class="dropdown-item" href="/payment-history">Payment History</a>
                                    <a class="dropdown-item" href="elements.html">elements</a>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="hearer_icon d-flex">
                        <a id="search_1" href="javascript:void(0)"><i class="ti-search"></i></a>
                        @if (Session::has('user'))
                        {{-- <a href=""><i class="ti-heart"></i></a> --}}
                        <?php
                            $totalCount = Order::where('user_id', auth()->user()->id)
                                                ->whereIn('status', ['available', 'sold'])
                                                ->count();

                            if($totalCount > 0){
                        ?>
                        <style>
                            .main_menu .cart i:after {
                                content: "<?php echo $totalCount; ?>";
                                display: block;
                            }
                        </style>
                        <?php
                            }
                        ?>
                        
                        <div class="dropdown cart">
                            <a href="/user/cart">
                                <i class="fas fa-cart-plus"></i>
                            </a>
                            {{-- <a class="dropdown-toggle" href="/cart" id="navbarDropdown3" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cart-plus"></i>
                            </a> --}}
                            <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="single_product">
                                </div>
                            </div> -->
                        </div>
                        @endif
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="search_input" id="search_input_box">
        <div class="container ">
            <form class="d-flex justify-content-between search-inner" method="POST" action="/searchProduct">
                @csrf
                <input type="text" class="form-control" id="search_input" name="search_input" placeholder="Search Product Here">
                <button type="submit" class="btn"></button>
                <span class="ti-close" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>

<script>
var path = "{{ url('searchKeyword') }}";
$('#search_input').typeahead({
    source: function(query, process){
        return $.get(path, {query:query}, function(data){
            return process(data);
        });
    }
});
</script>
<!-- Header part end-->