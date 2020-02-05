@if(Session::has('msg'))
<div class="alert alert-danger">{{Session::get('msg')}}</div>
@endif


<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - srtdash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/admin/assets/images/icon/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/metisMenu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/slicknav.min.css')}}">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/default-css.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/assets/css/responsive.css')}}">
    <!-- modernizr css -->
    <script src="assets/admin/assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="{{route('login')}}" method="post">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                        <p>Hello there, Sign in and start managing your Admin Template</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="exampleInputEmail1" autocomplete="off" name="email">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="exampleInputPassword1" autocomplete="off" name="password">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <!-- <input type="checkbox" class="custom-control-input" id="customControlAutosizing"> -->
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="register.html">Sign up</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="assets/admin/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/admin/assets/js/popper.min.js"></script>
    <script src="assets/admin/assets/js/bootstrap.min.js"></script>
    <script src="assets/admin/assets/js/owl.carousel.min.js"></script>
    <script src="assets/admin/assets/js/metisMenu.min.js"></script>
    <script src="assets/admin/assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/admin/assets/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="assets/admin/assets/js/plugins.js"></script>
    <script src="assets/admin/assets/js/scripts.js"></script>
</body>

</html>