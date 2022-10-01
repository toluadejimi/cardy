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
                                My USD <b>Virtual Card</b>.
                                <p>You can use your USD card to purchace any item on any USD currency website</p>
                                </p>

                                <a href="/fund-wallet" class="btn btn-sm btn-outline-primary">Fund Wallet</a>
                                <a class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" href="#card_info" role="button" aria-expanded="false" aria-controls="card_info">  Get Card Information</a></p>
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

              <div class="row">

 <div class="collapse multi-collapse" id="card_info">
   <div class="card card-body">      
   <h6 class="title">Card Information</h6>
                    
    <div class="mb-2">

    <div class="row">
      <div class="col-lg-3">
        <div class="form-group">
        <h6 class="title" >Card Number </h6>
          <div><p>{{ $usd_card_no_decrypt }}</p></div> 
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-group">
        <h6 class="title" >Expiry Month / Year</h6>
          <div><p>{{ $usd_card_expiry_month_decrypt }} / {{ $usd_card_expiry_year_decrypt }}</p></div> 
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-group">
        <h6 class="title">Card CVV</h6>
          <div><p>{{ $usd_card_cvv_decrypt }}</p></div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-group">
        <h6 class="title" >Card Type</h6>
          <div><p>{{ $type }}</p></div>
        </div>
      </div>


      <div class="col-lg-12 mt-3" >
      <h6 class="title">Billling Information</h6>
      </div>

      <div class="row">
      <div class="col-lg-3">
        <div class="form-group">
        <h6 class="title" >Street </h6>
          <div><p>{{ $street }}</p></div> 
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-group">
        <h6 class="title" >City</h6>
          <div><p>{{$city}}</p></div> 
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-group">
        <h6 class="title">State</h6>
          <div><p>{{ $state }}</p></div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-group">
        <h6 class="title" >Zip Code</h6>
          <div><p>{{ $zip_code }}</p></div>
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
                                                            <input type="text" disabled class="form-control" id="rate" value = "{{ number_format($rate) }}" />


                                                            </div>
                                                            </div>
                                                            <div class="mb-3">
                                                            <label class="form-label" for="">Amount to fund card (NGN)</label>
                                                            <input type="number" class="form-control" name = "amount_to_fund" id="amount_to_fund" placeholder= "Please Enter Amount in NGN  " />
                                                            <span> Min - 10USD  | Max - USD250</span>

                                                            </div>



                                                            <div class="mb-3">
                                                            <label class="form-label" for="">Amount to be funded on USD card (USD)</label>
                                                            <input type="number" id="result" disabled class="form-control" value="result"> </h4>
                                                            </div>

                                                            

                                                          

                                                            
                                                            <button type="submit" class="btn btn-primary">Fund Card</button>
                                                        </form>





                                                    
                                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-12">
                                            <div class="card-body">


                                            

                                                    <h5 class="title">USD Virtual Card</h5>


                                                    <div class="ccard mb-5">
                                                        <div class="cnard__front card__part">
                                                                <h4 class="card_numer">{{$card_amount}} USD</h4>
                                                                <img class="card__front-logo card__logo" src="../assets/img/illustrations/visa.png">
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
                                                                        <p class="card__secret--last">{{ $usd_card_cvv_decrypt }}</p>
                                                                    </div>
                                                                    <img class="card__back-square card__square" src="../assets/img/illustrations/logo.png">    
                                                                </div>
                                                            </div>


                                                           
                                                                     
                                                            </div>
                                                            <div class="row">
                                                              <div class="col-lg-3">
                                                               <a class="btn btn-danger mt-5"  href="/delet-usd-card" role="button" aria-expanded="false" aria-controls="card_info">Delete</a></p>
                                                              </div>

                                                              <div class="col-lg-3">
                                                               <a class="btn btn-warning mt-5"  href="/freeze-usd-card" role="button" aria-expanded="false" aria-controls="card_info">Freeze</a></p>                                                        
                                                              </div>

                                                              <div class="col-lg-3">
                                                               <a class="btn btn-success mt-5"  href="/unfreeze-usd-card" role="button" aria-expanded="false" aria-controls="card_info">Unfreeze</a></p>                                                        
                                                              </div>

                                                          </div>


                                                            </div>
                                                          










                                                        </div>
                                                    </div>
                                                 </div>
                                                </div> 
                                            
                                            </div>
                                            <p>





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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
$('input').keyup(function(){ // run anytime the value changes
    var rate  = Number($('#rate').val());   // get value of field
    var amount = Number($('#amount_to_fund').val()); // convert it to a float

    document.getElementById('result').value = Math.round(amount / rate * 100) / 100;
// add them and output it
});
</script>












@endsection