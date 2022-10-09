@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bank-account"><i class="bx bxs-bank me-1"></i>Bank Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/updatepassword"><i class="bx bxs-lock-alt me-1"></i>Security</a>
                    </li>
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            @if(Auth::user()->gender == 'male')
                            <img src="{{url('')}}/public/assets/img/avatars/male.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            @else
                            <img src="{{url('')}}/public/assets/img/avatars/female.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            @endif
                            <div class="button-wrapper">
                                <div>

                                <h4> {{ Auth::user()->f_name }}  {{ Auth::user()->l_name }} </h4>

                                </div>
                               @if(Auth::user()->is_kyc_verified == 1)
                                <span class="badge bg-success">Account Verified</span>  |  <span class="badge bg-success">Email Verified</span>

                                @else
                                <span class="badge bg-danger">Not verified</span> |  <span class="badge bg-success">Email Verified</span>
                                @endif


                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Surname</label>
                                    <input class="form-control" disabled type="text" id="firstName" name="firstName" value="{{Auth::user()->f_name}}" autofocus />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">First Name</label>
                                    <input class="form-control" disabled type="text" name="lastName" id="lastName" value="{{Auth::user()->l_name}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" disabled type="text" id="email" name="email" value="{{Auth::user()->email}}"  />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="organization" class="form-label">Phone Number</label>
                                    <input type="text" disabled class="form-control" id="organization" name="organization" value="{{Auth::user()->phone}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Gender</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" disabled id="phoneNumber" name="phoneNumber" class="form-control" value="{{Auth::user()->gender}}" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address Line 1</label>
                                    <input type="text" disabled class="form-control" id="address" name="address" value="{{Auth::user()->address_line1}}" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">State</label>
                                    <input class="form-control" disabled type="text" id="state" name="state" value="{{Auth::user()->state}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">City</label>
                                    <input type="text" disabled class="form-control" id="zipCode" name="zipCode" value="{{Auth::user()->city}}" maxlength="6" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">LGA</label>
                                    <input type="text" disabled class="form-control" id="zipCode" name="zipCode" value="{{Auth::user()->lga}}" maxlength="6" />
                                </div>
                            </div>
                         
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                            </div>
                        </div>
                        <form id="formAccountDeactivation" action="/delete" method="POST" onsubmit="return true">
                        @csrf
                            <div class="form-check mb-3">

                                <input class="form-check-input" value="{{Auth::user()->id}}"   required type="checkbox" name="accountActivation" id="accountActivation" />
                                <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
                            </div>
                            <button type="submit"  name="user_id" value="{{Auth::id()}}" class="btn btn-danger deactivate-account">Deactivate Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection