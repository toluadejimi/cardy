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
                  Instant Data on <b>Cardy</b>.
                <p>Buy instant Data for yourself and loved ones</p>
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
    </div>

    <div class="mb-4">

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



    @if(Auth::user()->is_kyc_verified =='0')

    @else


    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4">


          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-12">
                <div class="card-body">






                  <h5 class="title"> <img src="{{url('')}}/public/assets/img/illustrations/mtn.jpeg" width="50" /> MTN DATA BUNDLE </h5>


                  <p>

                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#mtn" role="button" aria-expanded="false" aria-controls="mtn"> Buy Data</a>
                  </p>


                  <div class="row">
                    <div class="collapse multi-collapse" id="mtn">
                      <div class="card card-body">

                        <form action="/buy-mtn-data" class="col-sm-12" method="GET">
                          @csrf


                          <div class="mb-3">
                            <div class="mb-3">

                              <label class="form-label" for="">Choose Preffered Data Bundle </label>
                              <select name="data_bundle" id="" class="form-control">
                                <option selected>Select Bundle</option>
                                @foreach ($get_mtn_network as $data)
                                <option value="{{ $data->data_bundle }}">{{ $data->data_bundle }}</option>
                                @endforeach
                              </select>
                            </div>



                            <div class="mb-3">
                              <label class="form-label" for="">Enter Phone Number </label>
                              <input type="text" class="form-control" name="phone_number" id="basic-default-fullname" value=" {{ Auth::user()->phone }}" />
                            </div>
                          </div>


                          <div class="mb-3">
                            <input type="text" class="form-control" hidden name="mobilenetwork_code" id="basic-default-fullname" value="01" />
                          </div>




                          <div class="mb-3">
                            <label class="form-label" for="">Pin</label>
                            <input type="password" class="form-control" name="pin" id="amount_to_fund" placeholder="Enter 4 Digit Pin " placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />

                          </div>

                          <button type="submit" class="btn btn-primary">Continue</button>
                        </form>
                      </div>
                    </div>
                  </div>



                </div>

              </div>

            </div>

          </div>
        </div>




        <div class="col-lg-4">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-12">
                <div class="card-body">


                  <h5 class="title"> <img src="{{url('')}}/public/assets/img/illustrations/glo.jpg" width="50" /> GLO DATA BUNDLE </h5>


                  <p>

                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#glo" role="button" aria-expanded="false" aria-controls="glo"> Buy Data</a>
                  </p>


                  <div class="row">
                    <div class="collapse multi-collapse" id="glo">
                      <div class="card card-body">

                        <form action="/buy-glo-data" class="col-sm-12" method="GET">
                          @csrf
                          <div class="mb-3">

                            <div class="mb-3">
                              <label class="form-label" for="">Choose Preffered Data Bundle </label>
                              <select name="data_bundle" id="" class="form-control">
                                <option selected>Select Bundle</option>
                                @foreach ($get_glo_network as $data)
                                <option value="{{ $data->data_bundle }}">{{ $data->data_bundle }}</option>
                                @endforeach
                              </select>
                            </div>



                            <div class="mb-3">
                              <label class="form-label" for="">Enter Phone Number </label>
                              <input type="text" class="form-control" name="phone_number" id="basic-default-fullname" value=" {{ Auth::user()->phone }}" />
                            </div>
                          </div>


                          <div class="mb-3">
                            <input type="text" class="form-control" hidden name="mobilenetwork_code" id="basic-default-fullname" value="02" />
                          </div>




                          <div class="mb-3">
                            <label class="form-label" for="">Pin</label>
                            <input type="password" class="form-control" name="pin" id="amount_to_fund" placeholder="Enter 4 Digit Pin " placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />

                          </div>

                          <button type="submit" class="btn btn-primary">Buy Airtime</button>
                        </form>
                      </div>
                    </div>
                  </div>




                </div>

              </div>

            </div>

          </div>
        </div>


        <div class="col-lg-4">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-12">
                <div class="card-body">

                  <h5 class="title"> <img src="{{url('')}}/public/assets/img/illustrations/airtel.png" width="50" /> AIRTEL DATA BUNDLE </h5>


                  <p>

                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#airtel" role="button" aria-expanded="false" aria-controls="airtel"> Buy Data</a>
                  </p>


                  <div class="row">
                    <div class="collapse multi-collapse" id="airtel">
                      <div class="card card-body">

                        <form action="/buy-airtel-data" class="col-sm-12" method="GET">
                          @csrf

                          <div class="mb-3">

                            <div class="mb-3">
                              <label class="form-label" for="">Choose Preffered Data Bundle </label>
                              <select name="data_bundle" id="" class="form-control">
                                <option selected>Select Bundle</option>
                                @foreach ($get_airtel_network as $data)
                                <option value="{{ $data->data_bundle }}">{{ $data->data_bundle }}</option>
                                @endforeach
                              </select>
                            </div>




                            <div class="mb-3">
                              <label class="form-label" for="">Enter Phone Number </label>
                              <input type="text" class="form-control" name="phone_number" id="basic-default-fullname" value=" {{ Auth::user()->phone }}" />
                            </div>
                          </div>


                          <div class="mb-3">
                            <input type="text" class="form-control" hidden name="mobilenetwork_code" id="basic-default-fullname" value="04" />
                          </div>

                          <div class="mb-3">
                            <label class="form-label" for="">Pin</label>
                            <input type="password" class="form-control" name="pin" id="" placeholder="Enter 4 Digit Pin " placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />

                          </div>

                          <button type="submit" class="btn btn-primary">Buy Airtime</button>
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


    <div class="container-fluid mt-4">
      <div class="row">
        <div class="col-lg-4">


          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-12">
                <div class="card-body">

                  <h5 class="title"> <img src="{{url('')}}/public/assets/img/illustrations/9mobile.jpg" width="50" /> 9MOBILE DATA BUNDLE </h5>


                  <p>

                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#etisalat" role="button" aria-expanded="false" aria-controls="etisalat"> Buy Data</a>
                  </p>


                  <div class="row">
                    <div class="collapse multi-collapse" id="etisalat">
                      <div class="card card-body">

                        <form action="/buy-9mobile-data" class="col-sm-12" method="GET">
                          @csrf


                          <div class="mb-3">

                            <div class="mb-3">
                              <label class="form-label" for="">Choose Preffered Data Bundle </label>
                              <select name="data_bundle" id="" class="form-control">
                                <option selected>Select Bundle</option>
                                @foreach ($get_9mobile_network as $data)
                                <option value="{{ $data->data_bundle }}">{{ $data->data_bundle }}</option>
                                @endforeach
                              </select>
                            </div>




                            <div class="mb-3">
                              <label class="form-label" for="">Enter Phone Number </label>
                              <input type="text" class="form-control" name="phone_number" id="basic-default-fullname" value=" {{ Auth::user()->phone }}" />
                            </div>
                          </div>


                          <div class="mb-3">
                            <input type="text" class="form-control" hidden name="mobilenetwork_code" id="basic-default-fullname" value="04" />
                          </div>

                          <div class="mb-3">
                            <label class="form-label" for="">Pin</label>
                            <input type="password" class="form-control" name="pin" id="" placeholder="Enter 4 Digit Pin " placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />

                          </div>

                          <button type="submit" class="btn btn-primary">Buy Airtime</button>
                        </form>
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





    </div>

  </div>

</div>




@endsection