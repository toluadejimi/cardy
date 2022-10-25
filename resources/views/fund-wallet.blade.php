@extends('layouts.fundwallet')

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
                  Top up Wallet.
                <p>Add Cash to your wallet to enjoy our swift services</p>
                </p>
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

      <div class="col-lg-8">
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
        <div class="alert alert-primary">
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


                  <h5 class="title"> Instant Funding</h5>
                  <p class="mb-4">
                    Fund your wallet instantly with flutterwave,</br>
                    2.5% charges will apply.
                  </p>


                  <p>
                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#mtn" role="button" aria-expanded="false" aria-controls="mtn">Fund Wallet</a>
                  </p>


                  <div class="row">
                    <div class="collapse multi-collapse" id="mtn">


                      <form action="/pay-now" class="mb-3" method="POST">
                        <div class="mb-3">

                          <label class="form-label" for="">Amount (NGN)</label>
                          <input type="number" class="form-control" name="amount_to_fund" id="amount_to_fund" placeholder="Please Enter Amount in NGN  " />
                          <span> Min - 100 | Max - 1,000,000</span>

                        </div>

                        <div class="mb-3">
                          <button type="button" id="start-payment-button" class="btn btn-primary" onclick="#">Continue</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>

        <div class="col-lg-6">


          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-12">
                <div class="card-body">


                  <h5 class="title"> Bank Transfer</h5>
                  <p class="mb-4">
                    Fund your wallet by transfering to our Bank account</br>
                    <span>its takes up to 1 - 2hrs for confirmation</span>
                  </p>


                  <p>
                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#bank" role="button" aria-expanded="false" aria-controls="bank">Fund Wallet</a>
                  </p>


                  <div class="row">
                    <div class="collapse multi-collapse" id="bank">


                      <form action="/bank-transfer-fund" class="mb-3" method="POST">
                        @csrf
                        <div class="mb-3">

                          <label class="form-label" for="">Amount (NGN)</label>
                          <input type="number" class="form-control" name="amount" id="amount" placeholder="Please Enter Amount in NGN  " />
                          <span> Min - 100 | Max - 1,000,000</span>

                        </div>

                        <div class="mb-3">
                          <button type="submit" id="start-payment-button" class="btn btn-primary">Continue</button>
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


      <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
          <div class="col-lg-12 mb-4 order-0">
            <div class="card">
              <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                  <div class="card-body">

                    @if(Auth::user()->is_kyc_verified =='0')
                    <h5> Transactions </h5>

                    <p class="mb-4">
                      No Records Found
                    </p>
                    @endif


                    <div class="card">
                      <h5 class="card-header">Latest Transaction </h5>
                      <div class="table-responsive text-nowrap">
                        <table id="myTable" class="table table-white">
                          <thead>
                            <tr>
                              <th>Trx ID</th>
                              <th>Amount</th>
                              <th>Type</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Time</th>

                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            @forelse ($banktransfers as $item)
                            <tr>
                              <td>{{$item->ref_id}}</td>
                              <td>{{number_format($item->amount, 2)}}</td>
                              <td>{{$item->type}}</td>
                              @if($item->status == "0")
                              <td><span class="badge rounded-pill bg-warning text-dark">pending</span></td>
                              @else
                              <td><span class="badge rounded-pill bg-success">Successful</span></td>
                              @endif
                              <td>{{date('F d, Y', strtotime($item->created_at))}}</td>
                              <td>{{date('h:i:s A', strtotime($item->created_at))}}</td>

                            </tr>
                            @empty
                            <tr colspan="20" class="text-center">No Record Found</tr>
                            @endforelse
                      </div>
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
  </div>

</div>

@endsection

<script src="https://checkout.flutterwave.com/v3.js"></script>

<script>
  var amount_to_fund = Number($('#amount_to_fund').val());

  let r = (Math.random() + 1).toString(36).substring(7);

  function makePayment($amount_to_fund) {
    FlutterwaveCheckout({
      public_key: "{{$fpk}}",
      tx_ref: "{{$trx}}",
      amount: document.getElementById('amount_to_fund').value,
      currency: "NGN",
      payment_options: "card, banktransfer, ussd",
      redirect_url: "{{ url('') }}/verify-pay",
      meta: {
        user_id: "{{Auth::id()}}",
      },
      customer: {
        email: "{{Auth::user()->email}}",
        phone_number: "{{Auth::user()->phone}}",
        name: "{{Auth::user()->f_name}}",
      },
      customizations: {
        title: "Cardy",
        description: "Wallet Top UP",
        logo: "{{url('')}}/public/assets/img/illustrations/logo_round.png"
      },

    });
  }
</script>
