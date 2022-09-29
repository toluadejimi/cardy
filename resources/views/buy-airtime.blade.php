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
                                Instant Airtime on <b>Cardy</b>.
                                <p>Buy instant airtime for yourself and loved ones</p>
                                </p>

                                <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>
                                @endif

                                
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                    src="../assets/img/illustrations/phone.png"
                                    height="140"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png"
                                />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>


                                                    @if(Auth::user()->is_kyc_verified =='0')
                                                    @else
                                                    <div class="container-xxl flex-grow-1 container-p-y">
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-4 order-0">
                                                                <div class="card">
                                                                    <div class="d-flex align-items-end row">
                                                                        <div class="col-sm-9">
                                                                            <div class="card-body">

                                                                                        <h5 class="title">Buy Airtime</h5>

                                                            <form action="/buy-airtime-now" class="mb-3" method="GET">
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
                                                                <label for="phone" class="form-label">Select Provider Network</label>
                                                                <select name="network" id="" class="form-control">
                                                                <option value="">Select your Network</option>
                                                                <option value="01">MTN</option>
                                                                <option value="02">GLO</option>
                                                                <option value="03">ETISALAT</option>
                                                                <option value="04">AIRTEL</option>
                                                                </select>
                                                                </div>

                                                             

                                                            <div class="mb-3">
                                                            <label class="form-label" for="">Enter Phone Number </label>
                                                            <input type="text" class="form-control" name = "phone_number"id="basic-default-fullname" value = " {{ Auth::user()->phone }}" />
                                                            </div>
                                                            </div>


                                                            <div class="mb-3">
                                                            <label class="form-label" for="">Amount (NGN)</label>
                                                            <input type="number" class="form-control" name = "amount_to_fund" id="amount_to_fund" placeholder= "Please Enter Amount in NGN  " value="100" />
                                                            <span> Min - 100 | Max - 20,000</span>

                                                            </div>

                                                            <div class="mb-3">
                                                            <label class="form-label" for="">Pin</label>
                                                            <input type="password" class="form-control" name = "pin" id="amount_to_fund" placeholder= "Enter 4 Digit Pin " placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />

                                                            </div>
                                 
                                                            <button type="submit" class="btn btn-primary">Buy Airtime</button>
                                                        </form>





                                                    
                                                        
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