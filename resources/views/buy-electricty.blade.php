@extends('layouts.buyeletricity')

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
                                            Buy Eletricity on <b>Cardy</b>.
                                        <p>Get instant Eletricity token for your Prepaid and Postpaid Meters</p>
                                        </p>

                                        <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>
                                    @endif


                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ url('') }}/public/assets/img/illustrations/phone.png" height="140"
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
                                    <div class="col-sm-9">
                                        <div class="card-body">

                                            <h5 class="title">Verify Meter Number</h5>

                                            <form action="/verify-meter" method="GET">
                                                @csrf
                                                <div class="row">


                                                    <div class="mb-3">
                                                        <label for="phone" class="form-label">Select Electric
                                                            Company</label>
                                                        <select name="serviceid" id="" name="query" class="form-control">

                                                            @foreach ($power as $item)
                                                            <option value="{{  $item->cl_name }}">{{ $item->cl_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="type" class="form-label">Select Meter Type
                                                            </label>
                                                        <select type="text" value=""name="type" id="type" class="form-control">

                                                            <option value="prepaid">Prepaid</option>
                                                            <option value="postpaid">Postpaid</option>
                                                        </select>
                                                    </div>



                                                    <div class="col-lg-9">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="">Enter Meter
                                                                Number</label>
                                                            <input type="text" class="form-control" name="billerscode">
                                                        </div>
                                                    </div>



                                                    <div class="col-lg-3 mt-4">

                                                        <div class="">

                                                            <button type="submit"
                                                                class="btn btn-block btn-warning">Verify</button>
                                                        </div>




                                                    </div>
                                                </div>
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

                                        </form>

                                    </div>







                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="col-lg-12 mb-4 order-0">

                            <div class="d-flex align-items-end row">
                                <div class="col-sm-6">
                                    <div class="card-body">


                                        <form action="/buy-eletricity-now" class="mb-3" method="GET">
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
                                            <p class="mt-3"> Make sure you verify meter number</p>


                                                <div class="mb-3">
                                                    <label class="form-label" for="">Meter Number</label>
                                                    <input type="text" class="form-control" readonly name="meter_number"
                                                        id="basic-default-fullname" value="{{  $meter_number ?? 000000  }}" />
                                                </div>

                                                <div class="mb-3">
                                                    <input type="text" class="form-control" readonly name="eletric_company"
                                                        id="basic-default-fullname" hidden value="{{ $eletric_company  }} " />

                                                </div>


                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Select Meter Type</label>
                                                    <select name="meter_type" id="" class="form-control">
                                                        <option value="{{$eletric_type ?? 0000 }}">{{$eletric_type ?? 0000 }}</option>
                                                        <option value="prepaid">Prepaid</option>
                                                        <option value="postpaid">Postpaid</option>
                                                    </select>
                                                </div>








                                                <div class="mb-3">
                                                    <label class="form-label" for="">Enter Amount (NGN)</label>
                                                    <input type="text" class="form-control" name="amount"
                                                        id="basic-default-fullname" value="" />
                                                    <small> Min - NGN 1,000 | Max - NGN 50,000 </small>
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label" for="">Enter Phone Number</label>
                                                    <input type="text" class="form-control" name="phone_number"
                                                        id="basic-default-fullname" value="{{$phone}} " />
                                                </div>












                                                <div class="mb-3">
                                                    <label class="form-label" for="">Pin</label>
                                                    <input type="password" class="form-control" name="pin"
                                                        id="amount_to_fund" placeholder="Enter 4 Digit Pin "
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />

                                                </div>

                                                <button type="submit" class="btn btn-primary">Buy Eletric Token</button>
                                        </form>

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
