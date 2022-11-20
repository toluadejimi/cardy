@extends('layouts.gotv')

@section('content')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">

                                    @if (Auth::user()->is_kyc_verified == '0')
                                        <h5 class="card-title text-primary">Congratulations {{ Auth::user()->f_name }}! 🎉
                                        </h5>
                                        <p class="mb-4">
                                            <b>Welcome onboard.</b> To enjoy all the features of cardy please verify your
                                            account.

                                        </p>

                                        <a href="/verify-account" class="btn btn-sm btn-outline-primary">Verify Account</a>
                                    @else
                                        <h5 class="card-title text-primary">Hey!!! {{ Auth::user()->f_name }}! 🎉</h5>
                                        <p class="mb-4">
                                            Subscribe for your GOTV on <b>Cardy</b>.
                                        <p>Pay now for your Cable Tv </p>
                                        </p>

                                        <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>
                                    @endif


                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ url('') }}/public/assets/img/illustrations/gotv.png" height="140"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>









            @if (Auth::user()->is_kyc_verified == '0')
            @else
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-lg-6 mb-4 order-0">

                            <div class="card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-12">
                                        <div class="card-body">

                                            <h5 class="title">VERIFY SMARTCARD NUMBER</h5>

                                            <form action="/verify-gotv-cable/" method="GET">
                                                @csrf
                                                <div class="row">

                                                    <div class="col-lg-9">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="">Enter Smartcard
                                                                Number</label>
                                                            <input type="number" required autfocus class="form-control"
                                                                name="billers_code" id="basic-default-fullname"
                                                                value="" />
                                                        </div>
                                                    </div>


                                                    <input hidden name="service_id" value="gotv">



                                                    <div class="col-lg-3 mt-4">

                                                        <div class="">

                                                            <button type="submit"
                                                                class="btn btn-block btn-warning">Verify</button>
                                                        </div>




                                                    </div>
                                                </div>

                                                <div class="col-lg-12 mt-4">

                                                    @if ($errors->any())
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    @if (session()->has('mm'))
                                                        <div class="alert alert-primary">
                                                            {{ session()->get('mm') }}
                                                        </div>
                                                    @endif
                                                    @if (session()->has('er'))
                                                        <div class="alert alert-danger">
                                                            {{ session()->get('er') }}
                                                        </div>
                                                    @endif

                                                </div>

                                        </div>

                                        </form>

                                    </div>







                                </div>
                            </div>
                        </div>
                    </div>









                    <div class="row">


                        <div class="col-lg-7 mb-4 order-0">

                            <div class="card">
                                <div class="col-lg-12 mb-4 order-0">

                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-12">
                                            <div class="card-body">


                                                <form action="/buy-gotv-now" class="mb-3" method="GET">
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
                                                    <div class="mb-3">


                                                        <div class="mb-3">
                                                            <label class="form-label" for="">ICU Number</label>
                                                            <input type="number" class="form-control" readonly
                                                                name="biller_code" id="basic-default-fullname"
                                                                value="{{ $gotv_number ?? 000000 }}" />
                                                        </div>


                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Current Plan</label>
                                                            <input type="text" readonly class="form-control" name="current_plan"
                                                                id="basic-default-fullname"
                                                                value="{{ Auth::user()->current_gotv_plan }}" />

                                                        </div>




                                                        <div class="mb-3">
                                                            <label class="form-label" for="">Choose GOTV BOUQUET
                                                            </label>
                                                            <select name="variation_code" id=""
                                                                class="form-control">
                                                                <option selected>Select Bundle</option>
                                                                @foreach ($gotv_type as $data)
                                                                    <option
                                                                        value="{{ $data->variation_code }} {{ $data->variation_amount }}">
                                                                        {{ $data->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>




                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Phone Number</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                id="basic-default-fullname"
                                                                value="{{ Auth::user()->phone }}" />

                                                        </div>




                                                        <div class="mb-3">
                                                            <label class="form-label" for="">Pin</label>
                                                            <input type="password" class="form-control" name="pin"
                                                                id="amount_to_fund" placeholder="Enter 4 Digit Pin "
                                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />

                                                        </div>

                                                        <button type="submit" class="btn btn-primary">Subscribe
                                                            Now</button>
                                                </form>

                                            </div>

                                        </div>
                                    </div>







                                </div>
                            </div>
                        </div>


                    </div>
                </div>




                <div class="container-xxl flex-grow-1 container-p-y">



                </div>



        </div>












    </div>

    @endif










    </div>
@endsection
