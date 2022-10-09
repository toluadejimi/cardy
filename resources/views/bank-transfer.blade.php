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


                                    <h5 class="title">Withdraw to Main Account</h5>
                                    <p class="mb-4">
                                        Withdraw the funds in your wallat to your bank Account,</br>
                                        NGN 100 charges will apply.
                                    </p>


                                    <p>
                                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#mtn" role="button" aria-expanded="false" aria-controls="mtn">Withdraw</a>
                                    </p>


                                    <div class="row">
                                        <div class="collapse multi-collapse" id="mtn">


                                            <form action="/withdraw-now" class="mb-3" method="POST">
                                                @csrf
                                                <div class="mb-3">

                                                    <label class="form-label" for="">Bank Name</label>
                                                    <input type="text" disabled class="form-control mb-3" name=" " id="account_no" value="{{Auth::user()->bank_name}} " />

                                                    <label class="form-label" for="">Account Name</label>
                                                    <input type="text" disabled class="form-control mb-3" name=" " id="account_no" value="{{Auth::user()->account_name}} " />

                                                    <label class="form-label" for="">Account Number</label>
                                                    <input type="text" disabled class="form-control mb-3" name=" " id="account_no" value="{{Auth::user()->account_number}} " />


                                                    <div class="mb-3
                                                        <label class=" form-label" for="">Amount (NGN)</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-money"></i></span>
                                                            <input type="number" class="form-control" name="amount" id="amount_to_fund" placeholder="Min - 100 | Max - 1,000,000 " />
                                                        </div>
                                                    </div>


                                                    <div class="mb-5 form-password-toggle">
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
                </div>

                <div class="col-lg-6">


                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-12">

                                <div class="card-body">


                                    <h5 class="title">Withdraw to another Bank Account</h5>
                                    <p class="mb-4">
                                        Send funds to external bank account,</br>
                                        NGN 100 charges will apply.
                                    </p>


                                    <p>
                                        <a class="btn btn-warning" data-bs-toggle="collapse" href="#bb" role="button" aria-expanded="false" aria-controls="mtn">Send Funds</a>
                                    </p>


                                    <div class="row">
                                        <div class="collapse multi-collapse" id="bb">


                                            <form action="/send-other-bank" class="mb-3" method="POST">
                                                @csrf
                                                <div class="mb-3">


                                                    <label class="form-label" for="">Select Bank</label>
                                                    <select name="code" id="bank" class="form-control">
                                                        <option selected>Select Bank</option>
                                                        @foreach ($banks as $data)
                                                        <option value="{{ $data->code }} {{ $data->name }}">{{ $data->name}}</option>
                                                        @endforeach
                                                    </select>

                                                    
                                                    <label class="form-label mt-3" for="">Account Number</label>
                                                    <input type="number"  class="form-control " name="account_number" id="account_no" placeholder="Enter account number" />


                                                    <div> 
                                                        <label class="form-label mt-3" for="">Amount (NGN)</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-money"></i></span>
                                                            <input type="number" class="form-control" name="amount" id="amount_to_fund" placeholder="Min - 100 | Max - 1,000,000 " />
                                                        </div>
                                                    </div>


                                                    <div class="mb-5 mt-3 form-password-toggle">
                                                        <label class="form-label" for="pin">Pin</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                                            <input type="password" id="pin" autofocus required class="form-control" name="pin" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                        </div>
                                                    </div>


                                                    




                                                </div>

                                                <div class="mb-3">
                                                    <button type="submit" id="start-payment-button" class="btn btn-warning">Continue</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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
 $(function(){
  $("#bank").select2();
 }); 
</script>



@endsection