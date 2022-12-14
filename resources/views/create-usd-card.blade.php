@extends('layouts.createusdcard')

@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">



            @if (Auth::user()->identity == '0')
            <div class="col-sm-4 mt-3 mb-5">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-4">
                            <div class="card-body">
                                <div class="badge rounded-default bg-danger">Please update your information
                                </div>

                                <div class="col-lg-4 mt-3">
                                    <div class="mt-0">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalCenter">
                                            Verify
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="/update-information" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalCenterTitle">Sorry for
                                                                the inconveniences.</h5><br>

                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Kindly update your profile to continue enjoying cardy
                                                                services.</p>

                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle"
                                                                        class="form-label">Idendtification
                                                                        Type</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <span id="basic-icon-default-fullname2"
                                                                            required class="input-group-text"><i
                                                                                class="bx bx-user"></i></span>
                                                                        <select name="identification_type"
                                                                            id="" class="form-control">
                                                                            <option value="">Select
                                                                                Identification Type</option>
                                                                            <option value="NIN">NIN</option>
                                                                            <option value="INTERNATIONAL_PASSPORT">
                                                                                International Passport</option>
                                                                            <option value="DRIVERS_LICENSE">Driver's
                                                                                License</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2">
                                                                <label class="form-label"
                                                                    for="basic-icon-default-fullname">Identification
                                                                    Number</label>
                                                                <div class="input-group input-group-merge">
                                                                    <span id="basic-icon-default-fullname2"
                                                                        class="input-group-text"><i
                                                                            class="bx bxs-user-pin"></i></span>
                                                                    <input type="text"
                                                                        class="form-control"required autofocus
                                                                        name="identification_number" id=""
                                                                        placeholder="Enter your ID Number"
                                                                        aria-label=""
                                                                        aria-describedby="basic-icon-default-fullname2" />
                                                                </div>
                                                            </div>

                                                            <div class="row g-2 mt-2">
                                                                <label class="form-label"
                                                                    for="basic-icon-default-fullname">Date of Birth</label>
                                                                <div class="input-group input-group-merge">
                                                                    <span id="basic-icon-default-fullname2"
                                                                        class="input-group-text"><i
                                                                            class="bx bxs-user-pin"></i></span>
                                                                    <input type="date"
                                                                        class="form-control"required autofocus
                                                                        name="dob" placeholder="Pick your date of birth"
                                                                         />
                                                                </div>
                                                            </div>

                                                            <div class="row g-2 mt-2">
                                                                <label class="form-label"
                                                                    for="basic-icon-default-fullname">Identification
                                                                    Image</label>
                                                                <div class="input-group input-group-merge">
                                                                    <span id="basic-icon-default-fullname2"
                                                                        class="input-group-text"><i
                                                                            class="bx bxs-image-add"></i></span>
                                                                    <input type="file"
                                                                        class="form-control"required autofocus
                                                                        name="identification_url" id=""
                                                                        placeholder="choose file" aria-label=""
                                                                        aria-describedby="basic-icon-default-fullname2" />
                                                                </div>
                                                                <span> Upload the valid front page of your selected
                                                                    identification type</span>

                                                            </div>



                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Verify</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-7 mt-3">

                    </div>

                </div>






            </div>
    </div>
    @endif





            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">

                                @if(Auth::user()->is_kyc_verified =='0')
                                <h5 class="card-title text-primary">Congratulations {{Auth::user()->f_name}}! ????</h5>
                                <p class="mb-4">
                                    <b>Welcome onboard.</b> To enjoy all the features of cardy please verify your account.

                                </p>

                                <a href="/verify-account" class="btn btn-sm btn-outline-primary">Verify Account</a>

                                @else
                                <h5 class="card-title text-primary">Hey!!! {{Auth::user()->f_name}}! ????</h5>
                                <p class="mb-4">
                                    Create USD <b>Virtual Card</b>.
                                <p>We charge 2 USD for card creation + 1.5 USD Funding fee</p>
                                <p>1.5USD will be charged at end the month for card maintainace fee</p>

                                </p>

                                <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>
                                @endif


                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{url('')}}/public/assets/img/illustrations/card.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
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

                                    <h5 class="title">Create USD Virtual Card</h5>

                                    <form action="/create-usd-card-now" class="mb-3" method="POST">
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
                                                <label class="form-label" for="">Creation  &  Funding Fee (NGN) </label>
                                                <input type="text" name=rate2 disabled class="form-control" id="rate2" value="{{$rate2}}" />


                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="">Amount to fund card (NGN)</label>
                                            <input type="number" class="form-control" name="amount_to_fund" id="amount_to_fund" placeholder="Please Enter Amount in NGN  " />
                                            <span> Min - NGN {{number_format($min_amount), 2}} | Max - NGN  {{number_format($max_amount), 2}} </span>

                                        </div>

                                        <div class="mb-3">
                                            <input type="number" hidden class="form-control" name="conversion_rate" id="conversion_rate" value="{{$conversion_rate}}"/>
                                        </div>



                                        <div class="mb-3">
                                            <label class="form-label" for="">Amount to be funded on USD card (USD)</label>
                                            <input type="number" name=result id="result3" disabled class="form-control" value="result3"> </h4>
                                            <span> Min - USD10 | Max - USD 250</span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="">Total (NGN)</label>
                                            <input type="number" id="result" name="result" readonly class="form-control" value="result"> </h4>
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




                                    <h5 class="title">USD Virtual Card</h5>


                                    <div class="ccard">
                                        <div class="cnard__front card__part">
                                            <h3 class="card_numer"> USD</h3>
                                            <img class="card__front-logo card__logo" src="{{url('')}}/public/assets/img/illustrations/visa.png">
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
                                                <img class="card__back-square card__square" src="{{url('')}}/public/assets/img/illustrations/logo_white.png">
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
                                        <h5 class="title">Available USD Cards</h5>
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
                                                    @forelse ($get_usd_card_records as $item)
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











        </div>

        @endif



        <script>
            $('input').keyup(function() { // run anytime the value changes
                var conversion = Number($('#conversion_rate').val()); // convert it to a float
                var amount_to_fund = document.getElementById('amount_to_fund').value; // convert it to a float
                var rate = document.getElementById('rate2').value; // convert it to a float


                var result2 = document.getElementById('result').value;

                document.getElementById('result3').value = result2 ;





                document.getElementById('result').value = Number(amount_to_fund) - Number(rate);

                var result2 = document.getElementById('result').value;


                document.getElementById('result3').value = Math.round(result2  / conversion * 100) / 100 ;











                // document.getElementById('result').value = Math.round((amount_to_fund)/ rate2);
                // add them and output it
            });
        </script>


        @endsection
