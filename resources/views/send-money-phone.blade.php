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


                                    <h5 class="title">Send Money to other Cardy User</h5>
                                    <p class="mb-4">
                                        Send Money to other cardy users with their phone numbers.
                                    </p>



                                    <div class="row">


                                        <form action="/confirm-user" class="mb-3" method="POST">
                                            @csrf
                                            <div class="mb-3">

                                                <div class="mb-3 col-sm-8">
                                                    <label class=" form-label" for="">Enter User Phone Number</label>
                                                    <div class="input-group input-group-merge">
                                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                                        <input type="text" required class="form-control" name="phone" id="phone" value="234" />
                                                    </div>
                                                </div>

                                                <div class="mb-3 col-sm-8">
                                                    <label class=" form-label" for="">Amount (NGN)</label>
                                                    <div class="input-group input-group-merge">
                                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-money"></i></span>
                                                        <input type="number" required class="form-control" name="amount" id="amount_to_fund" placeholder="Min - 100 | Max - 1,000,000 " />
                                                    </div>
                                                </div>


                                                <div class="mb-5 col-sm-8 form-password-toggle">
                                                    <label class="form-label" for="pin">Pin</label>
                                                    <div class="input-group input-group-merge">
                                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                                        <input type="password" id="pin" autofocus required class="form-control" name="pin" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                    </div>
                                                </div>




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

                <div class="col-lg-6">


                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-12">



                            </div>

                        </div>

                    </div>
                </div>
                @if(Auth::user()->is_kyc_verified =='0')
                @else
            </div>
            @endif
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

<script>
    $(function() {
        $("#bank").select2();
    });
</script>



@endsection