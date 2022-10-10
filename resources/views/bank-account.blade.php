@extends('layouts.profile')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account Settings / </span> Bank Information
        </h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-5">
                <li class="nav-item">
                        <a class="nav-link" href="/profile"><i class="bx bx-user me-1"></i> Account Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/bank-account"><i class="bx bxs-bank me-1"></i>Bank Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/updatepassword"><i class="bx bxs-lock-alt me-1"></i>Security</a>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-md-6 col-12 mb-md-0 mb-4">
                        <div class="card">
                            <h5 class="card-header">Bank  Account</h5>
                            <hr class="my-0" />

                            <div class="card-body">
                                <p>Registred Bank Account</p>
                                <!-- Connections -->
                                <div class="d-flex mb-3">

                                    <div class="flex-grow-1 row">
                                        <div class="col-7 mb-sm-0 mb-3">
                                            <h6 class="mb-0">Bank Name</h6>
                                            <small class="text-muted">{{Auth::user()->bank_name}}</small>
                                        </div>

                                        <div class="col-5 mb-sm-0 mb-3">
                                            <h6 class="mb-0">Account Number</h6>
                                            <small class="text-muted">{{Auth::user()->account_number}}</small>
                                        </div>


                                    </div>
                                </div>


                                <div class="d-flex mb-5">
                                <div class="col-7 mb-sm-0 mb-5">
                                            <h6 class="mb-0">Benefeciary Name</h6>
                                            <small class="text-muted">{{Auth::user()->account_name}}</small>
                                        </div>

                                </div>


                            <a button href="/pin-verify-account" type="button" class="btn btn-primary"><span  class="tf-icons bx bxs-send"></span>&nbsp; Update Account</a></button>






                            </div>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
    @endsection
