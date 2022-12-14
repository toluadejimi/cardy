@extends('layouts.mycard')

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

                                    @if (Auth::user()->is_kyc_verified == '0')
                                        <h5 class="card-title text-primary">Congratulations {{ Auth::user()->f_name }}! ????
                                        </h5>
                                        <p class="mb-4">
                                            <b>Welcome onboard.</b> To enjoy all the features of cardy please verify your
                                            account.

                                        </p>

                                        <a href="/verify-account" class="btn btn-sm btn-outline-primary">Verify Account</a>
                                    @else
                                        <h5 class="card-title text-primary">Hey!!! {{ Auth::user()->f_name }}! ????</h5>
                                        <p class="mb-4">
                                            Claim your NGN or USD <b>Virtual Card</b> on Cardy.

                                        </p>

                                        <a href="/create-usd-card" class="btn btn-sm btn-outline-primary">Create USD Virtual
                                            Card</a>
                                        <a href="/create-ngn-card" class="btn btn-sm btn-outline-primary">Create NGN Virtual
                                            Card</a>
                                    @endif


                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ url('') }}/public/assets/img/illustrations/card.png" height="140"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @if (Auth::user()->is_kyc_verified == '0')
                <h5 class="card-title text-primary">Congratulations {{ Auth::user()->f_name }}! ????</h5>
                <p class="mb-4">
                    <b>Welcome onboard.</b> To enjoy all the features of cardy please verify your account.

                </p>

                <a href="/verify-account" class="btn btn-sm btn-outline-primary">Verify Account</a>
            @else
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-lg-6 mb-4 order-0">
                            <div class="card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-7">
                                        <div class="card-body">




                                            <h5 class="title">USD Virtual Card</h5>

                                            <div class="ccard mb-1">
                                                <div class="cnard__front card__part">
                                                    <h4 class="card_numer">{{ number_format($card_amount), 2 ?? 0000 }} USD
                                                    </h4>
                                                    <img class="card__front-logo card__logo"
                                                        src="{{ url('') }}/public/assets/img/illustrations/visa.png">
                                                    <p class="card_numer">**** **** ****
                                                        {{ $usd_card_last_decrypt ?? 2345 }}</p>

                                                    <div class="card__space-75 ">
                                                        <span class="card__label">Card holder</span>
                                                        <p class="card__info">{{ $card_name ?? 'John Doe' }}</p>
                                                    </div>
                                                    <div class="card__space-25">
                                                        <span class="card__label">M/Y</span>
                                                        <p class="card__info">{{ $usd_card_expiry_month_decrypt ?? 20 }} /
                                                            {{ $usd_card_expiry_year_decrypt ?? 28 }}</p>
                                                    </div>
                                                </div>

                                                <div class="card__back card__part">
                                                    <div class="card__black-line"></div>
                                                    <div class="card__back-content">
                                                        <div class="card__secret">
                                                            <p class="card__secret--last">
                                                                {{ $usd_card_cvv_decrypt ?? 123 }}</p>
                                                        </div>
                                                        <img class="card__back-square card__square"
                                                            src="{{ url('') }}/public/assets/img/illustrations/logo_white.png">
                                                    </div>
                                                </div>



                                            </div>
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


                                            <div class="cncard">
                                                <div class="cnard__front cnard__part">
                                                    <h3 class="card_numer"> NGN</h3>
                                                    <img class="card__front-logo card__logo"
                                                        src="{{ url('') }}/public/assets/img/illustrations/visa.png">
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

                                                <div class="card__back cnard__part">
                                                    <div class="card__black-line"></div>
                                                    <div class="card__back-content">
                                                        <div class="card__secret">
                                                            <p class="card__secret--last">420</p>
                                                        </div>
                                                        <img class="card__back-square card__square"
                                                            src="{{ url('') }}/public/assets/img/illustrations/logo_white.png">
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
                                                <h5 class="title">Available Cards</h5>
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
                                                            @forelse ($card as $item)
                                                                <tr>
                                                                    <td>{{ $item->card_type }}</td>
                                                                    <td>{{ $item->card_id }}</td>
                                                                    @if ($item->status == '0')
                                                                        <td><span
                                                                                class="badge rounded-pill bg-warning text-dark">Pending</span>
                                                                        </td>
                                                                    @else
                                                                        <td><span
                                                                                class="badge rounded-pill bg-success">Active</span>
                                                                        </td>
                                                                    @endif
                                                                    <td>{{ date('F d, Y', strtotime($item->created_at)) }}
                                                                    </td>

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
        <!-- / Content -->


    @endsection
