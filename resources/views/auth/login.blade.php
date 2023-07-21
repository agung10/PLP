<!DOCTYPE html>
<html lang="en">
    <!--begin::Head-->
    <head>
        <base href="{{ asset('assets') }}" />
        <meta charset="utf-8" />
        <title>{{ config('app.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Global Stylesheets Bundle(used by all pages)-->
        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

        {{-- <link rel="shortcut icon" href="assets/media/logos/favicon.png" /> --}}
    </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body data-kt-name="metronic" id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat" style="background-image: url(assets/media/auth/bg10.jpeg);">
        <!--begin::Theme mode setup on page load-->
        <script>if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }</script>
        <!--end::Theme mode setup on page load-->
        <!--begin::Root-->
        <div class="d-flex flex-column flex-root" id="kt_app_root">
            <!--begin::Page bg image-->
            <style>body { background-image: url('assets/media/auth/bg4.jpg'); } [data-theme="dark"] body { background-image: url('assets/media/auth/bg4-dark.jpg'); }</style>
            <!--end::Page bg image-->
            <!--begin::Authentication - Sign-in -->
            <div class="d-flex flex-column flex-column-fluid flex-lg-row">
                <!--begin::Aside-->
                <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                    <!--begin::Aside-->
                    <div class="d-flex flex-column">
                        <center>
                            <a href="https://www.arindo.net/images/logo-pln.png" class="mb-7">
                                <img alt="Logo" src="https://www.arindo.net/images/logo-pln.png" width="200" />
                            </a>
                            <h1 class="text-dark fw-bold m-0">
                                PLP
                                <hr />
                                (Pembayaran Listrik Pascabayar)
                            </h1>
                        </center>
                        <!--end::Title-->
                    </div>
                    <!--begin::Aside-->
                </div>
                <!--begin::Aside-->
                <!--begin::Body-->
                <div class="d-flex flex-center w-lg-50 p-10">
                    <!--begin::Card-->
                    <div class="card rounded-3 w-md-550px">
                        <!--begin::Card body-->
                        <div class="card-body p-10 p-lg-20 rounded" style="box-shadow: 0.3rem 0.3rem #3D84A8, -0.3rem -0.3rem #48466D">
                            <!--begin::Form-->
                            <form id="form-login" class="kt-form" action="{{ route('login') }}" method="post">
                                {{ csrf_field() }}
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <!--begin::Title-->
                                    <h1 class="text-dark fw-bolder mb-3">Selamat Datang</h1>
                                    <!--end::Title-->
                                </div>
                                <!--begin::Heading-->
                                
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::Username-->
                                    <input type="text" placeholder="Username" name="username" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::Password-->
                                    <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Password-->
                                </div>

                                @if ($errors->any())
                                    <span class="help-block" style="color:red">
                                        <strong>@lang('auth.failed')</strong>
                                    </span>
                                @endif
                                
                                <!--end::Input group=-->
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                    <div></div>
                                    <!--begin::Link-->
                                    {{-- <a href="../../demo1/dist/authentication/layouts/creative/reset-password.html" class="link-primary">Forgot Password ?</a> --}}
                                    <!--end::Link-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-light-primary border border-1 border-primary">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Masuk ke Website</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <!--end::Submit button-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Authentication - Sign-in-->
        </div>
        <!--end::Root-->
        <!--begin::Javascript-->
        <script>var hostUrl = "assets/";</script>
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>
        <!--end::Global Javascript Bundle-->

        <script src="assets/plugins/jquery/jquery.min.js" type="text/javascript"></script>
        <!-- JS Validation -->
        <script src="vendor/jsvalidation/js/jsvalidation.min.js" type="text/javascript"></script>
        {!! JsValidator::formRequest('App\Http\Requests\Auth\LoginRequest', '#form-login') !!}
        <script>
            $(document).ready(function() { 
                // on click submit disable button submit and process
                $('#form-login').on('submit', function() {
                    $(this).valid() && $('#kt_sign_in_submit').attr('data-kt-indicator', 'on');
                });
            }); 
        </script>
        <!--end::Javascript-->
    </body>
    <!--end::Body-->
</html>