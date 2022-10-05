<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: Cardy
* Tos: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright Cardy (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{url('')}}/public/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Register</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('')}}/public/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{url('')}}/public/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{url('')}}/public/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{url('')}}/public/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{url('')}}/public/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{url('')}}/public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{url('')}}/public/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="{{url('')}}/public/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{url('')}}/public/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                  <img
                                    src="{{url('')}}/public/assets/img/illustrations/logo.png"
                                    height="50"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png"
                                />
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder"></span>
                </a>
              </div>
              <!-- /Logo -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session()->get('error') }}
                                    </div>
                                @endif


              <h4 class="mb-2">Welcome to Cardy!</h4>
              <p class="mb-4">Please register a new account to enjoy our services</p>

              <form action="/register_now" class="mb-3" method="POST">
              @csrf
                                
                                <div class="mb-3">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input
                    type="text"
                    class="form-control"
                    id="phone"
                    name="phone"
                    value="+234"
                    placeholder="Enter your Phone Number with Country Code"
                    autofocus
                  />
                </div>
                <div class="mb-3">
                  <label for="f_name" class="form-label">Surname</label>
                  <input
                    type="text"
                    class="form-control"
                    id="l_name"
                    name="l_name"
                    placeholder="Enter your  Surname"
                    autofocus
                  />
                </div>
                <div class="mb-3">
                  <label for="l_name" class="form-label">First Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="f_name"
                    name="f_name"
                    placeholder="Enter your First Name"
                    autofocus
                  />
                </div>
                
                
                <div class="mb-3">
                <label for="phone" class="form-label">Gender</label>
                  <select name="gender" id="" class="form-control">
                  <option value="">Select your gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                 </select>
                </div>
                
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
                </div>

                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Pin</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="pin"
                      class="form-control"
                      name="pin"
                      placeholder="Enter your 4 Digit Transfer Pin;"
                      aria-describedby="pin"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                
            

                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" required type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                      I agree to
                      <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Sign up</button>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="/">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

   

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{url('')}}/public/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{url('')}}/public/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{url('')}}/public/assets/vendor/js/bootstrap.js"></script>
    <script src="{{url('')}}/public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{url('')}}/public/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{url('')}}/public/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
