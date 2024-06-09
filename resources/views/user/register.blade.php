@extends('user/master')
@section('content')
<style>
    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
        font-weight: 500;
    }

    ul {
        list-style-type: disc; /* use a filled circle */
    }
</style>
    <!-- breadcrumb start-->
    <section class="breadcrumb breadcrumb_bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb_iner">
                        <div class="breadcrumb_iner_item">
                            <h2>Register Account</h2>
                            <p>Home <span>-</span> Register Account </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb start-->

    <!--================login_part Area =================-->
    <section class="login_part padding_top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_text text-center">
                        <div class="login_part_text_iner">
                            <h2>Already have account?</h2>
                            <p>There are always new and exciting things happening on the internet, and our website is no exception. We are constantly updating our content and adding new features to improve your experience.</p>
                            <a href="/login" class="btn_3">Login Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <h3>Welcome ! <br>
                                Please Sign up now</h3>
                            <form class="row contact_form" action="/register" method="post">
                                @csrf
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Name">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Email">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password" name="password" value=""
                                        placeholder="Password">
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" placeholder="Confirm Password">
                                    <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-confirm_password"></span>
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="submit" value="submit" class="btn_3">
                                        Register
                                    </button>
                                </div>
                            </form>
                            @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================login_part end =================-->

    <script>
        $(".toggle-password, .toggle-confirm_password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
    <script>
        document.getElementById("name").focus();
    </script>
@endsection