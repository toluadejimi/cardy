@extends('layouts.app')

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

                                @if(Auth::user()->is_kyc_verified =='0')
                                <h5 class="card-title text-primary">Congratulations {{Auth::user()->f_name}}! 🎉</h5>
                                <p class="mb-4">
                                    <b>Welcome onboard.</b> To enjoy all the features of cardy please verify your account.

                                </p>

                                <a href="/verify-account" class="btn btn-sm btn-outline-primary">Verify Account</a>

                                @else
                                <h5 class="card-title text-primary">Hey!!! {{Auth::user()->f_name}}! 🎉</h5>
                                <p class="mb-4">
                                    Sends Funds Out.
                                <p>Send Funds to yourslef or loved ones</p>
                                </p>
                                <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>

                                @endif
                            </div>
                        </div>


                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{url('')}}/public/assets/img/illustrations/phone.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
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


            </div>
        </div>



        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">


                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-12">
                                <div class="card-body">


                                    <h5 class="title">Transaction Preview</h5>
                                    <p class="mb-4">
                                        Check your details for any errors, once your confirm it's irrevasable
                                    </p>


                                    <div class="row">

                                        <form action="/send-money-phone-now" class="mb-3" method="POST">
                                            @csrf
                                            <div class="d-flex mb-2">

                                                <div class="col-7 mb-sm-0 mb-3">
                                                    <h6 class="mb-1">Receiver Details</h6>
                                                    <input class="form-control" readonly name="receiver" value="{{$surname}} {{$first_name}}">
                                                </div>

                                            </div>

                                            <div class="d-flex mb-2">

                                                <div class="col-7 mb-sm-0 mb-3">
                                                    <h6 class="mb-1">Phone Number</h6>
                                                    <input class="form-control" readonly name="phone" value="{{$phone}}">
                                                </div>

                                            </div>


                                            <div class="d-flex mb-2">

                                                <div class="col-7 mb-sm-0 mb-3">
                                                    <h6 class="mb-1">Amount (NGN)</h6>
                                                    <input class="form-control" readonly name="amount" value="{{$amount}}">
                                                </div>

                                            </div>


                                            <div class="col-7 mb-sm-0 mb-5 mt-4">
                                                <button class="btn btn-success d-grid w-100" type="submit">Confirm & Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



@endsection