@extends('layouts.app')

@section('content')



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
                                Create NGN <b>Virtual Card</b>.
                                <p>Note we charge NGN 50 for card creation</p>
                                </p>

                                <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>
                                @endif

                                
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                    src="../assets/img/illustrations/card.png"
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

                                                                                        <h5 class="title">Create Card</h5>

                                                            <form action="/create-ngn-card-now" class="mb-3" method="POST">
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
                                                            <label class="form-label" for="">Creation Fee (NGN) </label>
                                                            <input type="text" disabled class="form-control" id="basic-default-fullname" value = "{{ number_format($ngn_creation_fee) }}" />
                                                            </div>
                                                            </div>
                                                            <div class="mb-3">
                                                            <label class="form-label" for="">Amount to fund card (NGN)</label>
                                                            <input type="number" class="form-control" name = "amount" id="amount_to_fund" placeholder= "Please Enter Amount in NGN  " />
                                                            <span> Min - NGN100 | Max - NGN1,000,000</span>
                                                            </div>



                                    

                                                            <div class="mb-3">
                                                            <label class="form-label" for="">Total (NGN)</label>
                                                            <input type="number" id="result2" disabled class="form-control" value="result2"> </h4>
                                                            </div>

                                                          

                                                            
                                                            <button type="submit" class="btn btn-primary">Create Card</button>
                                                        </form>





                                                    
                                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">


                                            

                                                    <h5 class="title">NGN Virtual Card</h5>


                                                    <div class="ccard">
                                                        <div class="card__front card__part">
                                                                <h3 class="card_numer">  NGN</h3>
                                                                <img class="card__front-logo card__logo" src="../assets/img/illustrations/logo.png">
                                                                <p class="card_numer">**** **** **** 6258</p>
                                                            <div class="card__space-75">
                                                                <span class="card__label">Card holder</span>
                                                                <p class="card__info">John Doe</p>
                                                            </div>
                                                                <div class="card__space-25">
                                                                    <span class="card__label">Expires</span>
                                                                    <p class="card__info">10/25</p>
                                                                </div>
                                                        </div>

                                                        <div class="card__back card__part">
                                                            <div class="card__black-line"></div>
                                                                <div class="card__back-content">
                                                                    <div class="card__secret">
                                                                        <p class="card__secret--last">420</p>
                                                                    </div>
                                                                    <img class="card__back-square card__square" src="../assets/img/illustrations/logo.png">    
                                                                </div>
                                                            </div>
                                                        </div>
</div>
                                        </div>
                                    </div>
                                </div>
                        </div>


                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-12">
                                            <div class="card-body">
                                            <h5 class="title">Available NGN Cards</h5>
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-white">
                                                        <thead>
                                                            <tr>
                                                            <th>Card Type</th>
                                                            <th>Card ID</th>
                                                            <th>Status</th>
                                                            <th>Date Created</th>

                                                          
                                                            </tr>
                                                        </thead>
                                                                <tbody class="table-border-bottom-0">
                                                                    @forelse ($get_ngn_card_records as $item)
                                                                    <tr>
                                                                        <td>{{$item->card_type}}</td>
                                                                        <td>{{$item->card_id}}</td>
                                                                        @if($item->status =='0')         
                                                                        <td><span class="badge rounded-pill bg-warning text-dark">Pending</span></td>         
                                                                        @else
                                                                        <td><span class="badge rounded-pill bg-success">Active</span></td>        
                                                                        @endif
                                                                        <td>{{date('F d, Y', strtotime($item->created_at))}}</td>

                                                                    </tr>
                                                                    @empty
                                                                        <tr colspan="20" class="text-center">No Card Found</tr>
                                                                    @endforelse
                                                                    
                                                                   
                                                                </tbody>
                                                </table>














                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                    </div>
                    











                </div>

                @endif

                







                
            </div>
  @endsection