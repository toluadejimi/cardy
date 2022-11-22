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
                    <div class="col-lg-6 mb-6">


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
                                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#mtn"
                                                role="button" aria-expanded="false" aria-controls="mtn">Fund Wallet</a>
                                        </p>


                                        <div class="row">
                                            <div class="collapse multi-collapse" id="mtn">


                                                <form action="/pay-now" class="mb-3" method="POST">
                                                    <div class="mb-3">

                                                        <label class="form-label" for="">Amount (NGN)</label>
                                                        <input type="number" class="form-control" name="amount_to_fund"
                                                            id="amount_to_fund" placeholder="Please Enter Amount in NGN" />
                                                        <span> Min - 100 | Max - 1,000,000</span>


                                                    </div>
                                                    <html>

                                                    <head>

                                                        <script src="https://checkout.flutterwave.com/v3.js"></script>

                                                        <script>
                                                            function makePayment() {

                                                                function randomReference() {
                                                                    var length = 10;
                                                                    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                                    var result = '';
                                                                    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
                                                                    return result;
                                                                }


                                                                var transRef = randomReference();
                                                                var amount = document.getElementsByName('amount_to_fund')[0].value;




                                                                FlutterwaveCheckout({
                                                                    public_key: "{{ $fpk }}",
                                                                    tx_ref: transRef,
                                                                    amount: amount,
                                                                    currency: "NGN",
                                                                    payment_options: "card, banktransfer, ussd",
                                                                    redirect_url: "{{ url('') }}/status",

                                                                    meta: {
                                                                        consumer_id: {{ Auth::user()->id }},
                                                                    },
                                                                    customer: {
                                                                        email: "{{ Auth::user()->email }}",
                                                                        phone_number: "{{ Auth::user()->phone }}",
                                                                        name: "{{ Auth::user()->f_name }} {{ Auth::user()->l_name }}",
                                                                    },
                                                                    customizations: {
                                                                        title: "Cardy",
                                                                        description: "Wallet Funding",
                                                                        logo: "{{ url('') }}/public/assets/img/illustrations/logo_round.png",
                                                                    },
                                                                });
                                                            }


                                                        </script>





                                                    </head>

                                                    <button type="button" id="start-payment-button" class="btn btn-primary"
                                                        onclick="makePayment()">Continue</button>

                                                </form>

                                            </div>




                                            <!-- Bootstrap core JavaScript
                                                                                                    ================================================== -->
                                            <!-- Placed at the end of the document so the pages load faster -->
                                            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                                                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
                                            </script>
                                            <script src="https://newwebpay.interswitchng.com/inline-checkout.js"></script>
                                            </body>
                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


                                            </html>


                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-6 mt-0">


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
                                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#bank"
                                                role="button" aria-expanded="false" aria-controls="bank">Fund Wallet</a>
                                        </p>


                                        <div class="row">
                                            <div class="collapse multi-collapse" id="bank">


                                                <form action="/bank-transfer-fund" class="mb-3" method="POST">
                                                    @csrf
                                                    <div class="mb-3">

                                                        <label class="form-label" for="">Amount (NGN)</label>
                                                        <input type="number" class="form-control" name="amount"
                                                            id="amount" placeholder="Please Enter Amount in NGN  " />
                                                        <span> Min - 100 | Max - 1,000,000</span>

                                                    </div>

                                                    <div class="mb-3">
                                                        <button type="submit" id="start-payment-button"
                                                            class="btn btn-primary">Continue</button>
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


            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-12">
                                    <div class="card-body">

                                        @if (Auth::user()->is_kyc_verified == '0')
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
                                                                <td>{{ $item->ref_id }}</td>
                                                                <td>{{ number_format($item->amount, 2) }}</td>
                                                                <td>{{ $item->type }}</td>
                                                                @if ($item->status == '0')
                                                                    <td><span
                                                                            class="badge rounded-pill bg-warning text-dark">pending</span>
                                                                    </td>
                                                                @else
                                                                    <td><span
                                                                            class="badge rounded-pill bg-success">Successful</span>
                                                                    </td>
                                                                @endif
                                                                <td>{{ date('F d, Y', strtotime($item->created_at)) }}
                                                                </td>
                                                                <td>{{ date('h:i:s A', strtotime($item->created_at)) }}
                                                                </td>
                                                                <td>

                                                                    @if ($item->type == 'Instant Funding')
                                                                        <div>
                                                                            <a class="btn btn-secondary"
                                                                                href="{{ url('') }}/check-status?trx={{ $item->ref_id }}"
                                                                                role="button" aria-expanded="false"
                                                                                aria-controls="">Status</a>

                                                                        </div>
                                                                    @endif

                                                                </td>

                                                            </tr>
                                                        @empty
                                                            <tr colspan="20" class="text-center">No Record Found
                                                            </tr>
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
