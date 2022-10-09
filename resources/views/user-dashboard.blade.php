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

                <a href="verify-account" class="btn btn-sm btn-outline-primary">Verify Account</a>

                @else
                <h5 class="card-title text-primary">Congratulations {{Auth::user()->f_name}}! 🎉</h5>
                <p class="mb-4">
                  <b>Lets begin.</b> Enjoy swift and Amazing services on Cardy.

                </p>

                <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>
                <a href="/usd-card" class="btn btn-sm btn-outline-primary">USD Virtual Card</a>
                <a href="/ngn-card" class="btn btn-sm btn-outline-primary">NGN Virtual Card</a>
                <a href="/buy-airtime" class="btn btn-sm btn-outline-primary">Airtime</a>
                <a href="/data" class="btn btn-sm btn-outline-primary">Data</a>
                @endif


              </div>
            </div>



            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img src="{{url('')}}/public/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6 mb-4 order-0">
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


                    @else
                    <div class="card">
                      <h5 class="card-header">Latest Transaction </h5>
                      <div class="table-responsive text-nowrap">
                        <table id="myTable" class="table table-white">
                          <thead>
                            <tr>
                              <th>Trx ID</th>
                              <th>Type</th>
                              <th>Amount</th>
                              <th>Description</th>
                              <th>Date</th>
                              <th>Time</th>

                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            @forelse ($transactions as $item)
                            <tr>
                              <td>{{$item->ref_trans_id}}</td>
                              @if($item->transaction_type  == "Cardy Transfer" &&  $item->from_user_id  == Auth::user()->id)
                              <td><span class="badge rounded-pill bg-warning ">Debit</span></td>
                              @elseif($item->transaction_type == "cash_out")
                              <td><span class="badge rounded-pill bg-warning">Debit</span></td>
                              @elseif($item->transaction_type == "Withdrawl")
                              <td><span class="badge rounded-pill bg-warning">Debit</span></td>
                              @else
                              <td><span class="badge rounded-pill bg-success">Credit</span></td>
                              @endif
                              <td>{{number_format($item->debit, 2)}}</td>
                              <td>{{$item->note}}</td>
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
                {!! $transactions->appends(Request::all())->links() !!}
              </div>
            </div>
            @endif
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
<!-- / Content -->
@endsection