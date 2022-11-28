@extends('layouts.usdcard')

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
                                <h5 class="card-title text-primary">Congratulations {{Auth::user()->f_name}}! 🎉</h5>
                                <p class="mb-4">
                                    <b>Welcome onboard.</b> To enjoy all the features of cardy please verify your account.

                                </p>

                                <a href="/verify-account" class="btn btn-sm btn-outline-primary">Verify Account</a>

                                @else
                                <h5 class="card-title text-primary">Hey!!! {{Auth::user()->f_name}}! 🎉</h5>
                                <p class="mb-4">
                                    My USD <b>Virtual Card</b>.
                                <p>You can use your USD card to purchase any item on any USD currency website</p>
                                </p>

                                <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>
                                <a class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" href="#card_info" role="button" aria-expanded="false" aria-controls="card_info"> Get Card Information</a></p>
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

        <div class="row">

            <div class="collapse multi-collapse" id="card_info">
                <div class="card card-body">
                    <h6 class="title">Card Information</h6>

                    <div class="mb-3">

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <div class="mb-5 form-password-toggle">
                                        <h6 class="form-label" for="card">Card Number </h6>
                                            <div class="input-group input-group-merge">
                                                <input type="password" disabled id="pin" autofocus required class="form-control" name="pin" value="{{$usd_card_no_decrypt}}" aria-describedby="password" />
                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                            </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-3">
                                <div class="form-group">
                                    <h6 class="title">Expiry Month / Year</h6>
                                    <div>
                                        <p>{{ $usd_card_expiry_month_decrypt }} / {{ $usd_card_expiry_year_decrypt }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-3">
                                <div class="form-group">
                                    <div class="mb-5 form-password-toggle">
                                        <h6 class="form-label" for="card">Card CVV </h6>
                                            <div class="input-group input-group-merge">
                                                <input type="password" disabled id="pin" autofocus required class="form-control" name="pin" value="{{$usd_card_cvv_decrypt}}" aria-describedby="password" />
                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <h6 class="title">Card Type</h6>
                                    <div>
                                        <p>{{ $type }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 mt-3 mb-4">
                                <h6 class="title">Billling Information</h6>
                            </div>

                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <h6 class="title">Street </h6>
                                        <div>
                                            <p>{{ $street }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <h6 class="title">City</h6>
                                        <div>
                                            <p>{{$city}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <h6 class="title">State</h6>
                                        <div>
                                            <p>{{ $state }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <h6 class="title">Zip Code</h6>
                                        <div>
                                            <p>{{ $zip_code }}</p>
                                        </div>
                                    </div>
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

                                        <h5 class="title">Fund USD Card</h5>
                                        <form action="/fund-usd-card" class="mb-3" method="POST">
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
                                                    <label class="form-label" for="">Rate (1 USD - NGN) </label>
                                                    <input type="text" disabled class="form-control" id="rate" value="{{ number_format($rate) }}" />


                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="">Amount to fund card (NGN)</label>
                                                <input type="number" class="form-control" name="amount_to_fund" id="amount_to_fund" placeholder="Please Enter Amount in NGN  " />
                                                <span> Min - NGN {{number_format($min_amount), 2}} | Max - NGN  {{number_format($max_amount), 2}} </span>

                                            </div>


                                            <div class="mb-3">
                                                <input type="number" hidden class="form-control" name="fund" id="fund" value="{{$fund}}" />
                                            </div>






                                            <div class="mb-3">
                                                <label class="form-label" for="">Amount to be funded on USD card (USD)</label>
                                                <input type="number" id="result" disabled class="form-control" value="result"> </h4>
                                                <small> {{$fund}} USD | funding fee applies </small>

                                            </div>
                                            <button type="submit" class="btn btn-primary">Fund Card</button>
                                        </form>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="col-lg-6 mb-1 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <h5 class="title">USD Virtual Card</h5>

                                        <div class="col-lg-3 mb-3">

                                        @if($card_status == 'active')
                                        <span class="badge bg-success mb-3">Card Active</span>
                                        @else
                                        <span class="badge bg-danger">Card Frozen</span>
                                        @endif

                                        </div>

                                        <div class="ccard mb-2">
                                            <div class="cnard__front card__part">
                                                <h4 class="card_numer">{{$card_amount}} USD</h4>
                                                <img class="card__front-logo card__logo" src="{{url('')}}/public/assets/img/illustrations/visa.png">
                                                <p class="card_numer">**** **** **** {{ $usd_card_last_decrypt  }}</p>

                                                <div class="card__space-75 ">
                                                    <span class="card__label">Card holder</span>
                                                    <p class="card__info">{{ $card_name }}</p>
                                                </div>
                                                <div class="card__space-25">
                                                    <span class="card__label">M/Y</span>
                                                    <p class="card__info">{{ $usd_card_expiry_month_decrypt }} / {{ $usd_card_expiry_year_decrypt }}</p>
                                                </div>
                                            </div>

                                            <div class="card__back card__part">
                                                <div class="card__black-line"></div>
                                                <div class="card__back-content">
                                                    <div class="card__secret">
                                                        <p class="card__secret--last">***</p>
                                                    </div>
                                                    <img class="card__back-square card__square" src="{{url('')}}/public/assets/img/illustrations/logo_white.png">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-lg-3">
                                                <a class="btn btn-danger mt-5" href="/delet-usd-card" role="button" aria-expanded="false" aria-controls="card_info">Delete</a></p>
                                            </div>

                                            <div class="col-lg-3">
                                                <a class="btn btn-warning mt-5" href="/freeze-usd-card" role="button" aria-expanded="false" aria-controls="card_info">Freeze</a></p>
                                            </div>

                                            <div class="col-lg-3">
                                                <a class="btn btn-success mt-5" href="/unfreeze-usd-card" role="button" aria-expanded="false" aria-controls="card_info">Unfreeze</a></p>
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
                                        <h5 class="title">Card Transactions History</h5>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-white">
                                                <thead>
                                                    <tr>
                                                        <th>Amount(USD)</th>
                                                        <th>Narration</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                        <th>Time</th>



                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">



                                                    @forelse ($cardTransaction as $data)
                                                    <tr>
                                                        <td>{{$data->amount / 100}}</td>
                                                        <td>{{ $data->narration }}</td>
                                                        @if($data->entry == "debit")
                                                        <td><span class="badge rounded-pill bg-warning text-dark">Debit</span></td>
                                                        @else
                                                        <td><span class="badge rounded-pill bg-success">Credit</span></td>
                                                        @endif
                                                        <td>{{date('F d, Y', strtotime($data->date))}}</td>
                                                        <td>{{date('h:i:s A', strtotime($data->date))}}</td>


                                                    </tr>
                                                    @empty
                                                    <tr colspan="20" class="text-center">No History Found</tr>
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
        <!-- / Content -->


        <script>
            $('input').keyup(function() { // run anytime the value changes
                var rate = Number($('#rate').val()); // get value of field
                var funding_fee = Number($('#fund').val()); // get value of field

                var amount = Number($('#amount_to_fund').val()); // convert it to a float

                document.getElementById('result').value = Math.round(amount / rate * 100 ) / 100 - funding_fee;
                // add them and output it
            });
        </script>












        @endsection
