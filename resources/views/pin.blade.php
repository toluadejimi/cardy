<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{url('')}}/public/assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Login</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{url('')}}/public/assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

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

<style>

h6 {
  font-family: helvetica;
  text-align:center;
}


.forget-code{
  text-align:center;
}

.pin-code{
  padding: 0;
  margin: 0 auto;
  display: flex;
  justify-content:center;

}

.pin-code input {
  border: none;
  border-color: #5a0af9;
  text-align: center;
  width: 48px;
  height:48px;
  font-size: 36px;
  background-color: #F3F3F3;
  margin-right:5px;
}



.pin-code input:focus {
  border: 1px solid #573D8B;
  outline:none;
}


input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

</style>

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
              <a href=" user-dashboard" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <img src="{{url('')}}/public/assets/img/illustrations/logo.png" height="50" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                </span>
                <span class="app-brand-text demo text-body fw-bolder"></span>
              </a>
            </div>
            <!-- /Logo -->

            @csrf
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

            {{-- <h4 class="mb-2">Welcome to Cardy! 👋</h4>
            <p class="mb-4">Login with your Pin</p> --}}

            <form action="/pin-login" class="mb-3" method="POST">
                @csrf



              <div class="mb-3 form-password-toggle">
                <h6>Enter Pin</h6>
                <div class="pin-code">
                      <input type="password" name="pin1" maxlength="1" autofocus required>
                    <input type="password" name="pin2"  maxlength="1" autofocus required>
                      <input type="password" name="pin3" maxlength="1" autofocus required>
                    <input type="password" name="pin4" maxlength="1" autofocus required>
                 </div>
              </div>

              <div class="text-center">
                <a class="" href="/forgot-password">
                  <small>Forgot Pin</small>
                </a>
              </div>


              <div class="text-center">
                <input type="text" hidden gitname="email" value="{{$email}}" >
                </a>
              </div>



              <div class="mb-3">
                <div class="form-check">
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Continue</button>
              </div>
            </form>


          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>

  <!-- / Content -->

  <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6346d5b854f06e12d899cdc8/1gf6b5nf1';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>



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


  <script>
    //var pinContainer = document.getElementsByClassName("pin-code")[0];
var pinContainer = document.querySelector(".pin-code");
console.log('There is ' + pinContainer.length + ' Pin Container on the page.');

pinContainer.addEventListener('keyup', function (event) {
    var target = event.srcElement;

    var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    var myLength = target.value.length;

    if (myLength >= maxLength) {
        var next = target;
        while (next = next.nextElementSibling) {
            if (next == null) break;
            if (next.tagName.toLowerCase() == "input") {
                next.focus();
                break;
            }
        }
    }

    if (myLength === 0) {
        var next = target;
        while (next = next.previousElementSibling) {
            if (next == null) break;
            if (next.tagName.toLowerCase() == "input") {
                next.focus();
                break;
            }
        }
    }
}, false);

pinContainer.addEventListener('keydown', function (event) {
    var target = event.srcElement;
    target.value = "";
}, false);
  </script>



</body>

</html>
