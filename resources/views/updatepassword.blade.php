@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account Settings / </span> Security
        </h4>

        <div class="row">
            <div class="col-md-6">

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
                <ul class="nav nav-pills flex-column flex-md-row mb-5">
                    <li class="nav-item">
                        <a class="nav-link" href="/profile"><i class="bx bx-user me-1"></i> Account Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bank-account"><i class="bx bxs-bank me-1"></i>Bank Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/updatepassword"><i class="bx bxs-lock-alt me-1"></i>Security</a>
                    </li>
                </ul>
  
                <div class="card">
                    <div class="card-body">



                        <h5 class="mb-4">Change Password</h5>

                        <hr class="my-0" />
                        <form action="/update-password-now" class="mb-3" method="POST">
                            @csrf


                            <div class="mb-3 mt-4 col-md-6 form-password-toggle">
                                <label class="form-label" for="password">Old Password</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bxs-lock-alt"></i></span>
                                    <input type="password" id="old_password" class="form-control" name="old_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bxs-lock-alt"></i></span>
                                    <input type="password" id="new_password" class="form-control" name="new_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-5 col-md-6 form-password-toggle">
                                <label class="form-label" for="password">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bxs-lock-alt"></i></span>
                                    <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>


                            <div class="mb-4 col-md-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Update Password</button>
                            </div>
                        </form>


                    </div>
                </div>


            </div>

            
        </div>

        
    </div>
    @endsection