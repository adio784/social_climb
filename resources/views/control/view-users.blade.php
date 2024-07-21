@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>View User</h3>
                    <p class="text-subtitle text-muted">View User informations and history</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User history</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ '' }}</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">First Name</label>
                                            <input type="text" id="first-name-column" class="form-control"
                                                value="{{ $User->first_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Last Name</label>
                                            <input type="text" id="last-name-column" class="form-control"
                                                value="{{ $User->last_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city-column">Username</label>
                                            <input type="text" id="city-column" class="form-control"
                                                value="{{ $User->username }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="country-floating">Phone</label>
                                            <input type="text" id="country-floating" class="form-control"
                                                value="{{ $User->phone }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="company-column">Referral Username</label>
                                            <input type="text" id="company-column" class="form-control"
                                                value="{{ $User->referral }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Email</label>
                                            <input type="email" id="email-id-column" class="form-control"
                                                value="{{ $User->email }}" readonly>
                                        </div>
                                    </div>
                                    <h4>Account Details</h4>
                                    <hr>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="company-column">Account Name</label>
                                            <input type="text" id="company-column" class="form-control"
                                                value="{{ $User->account_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Account Number</label>
                                            <input type="email" id="email-id-column" class="form-control"
                                                value="{{ $User->account_number }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Bank</label>
                                            <input type="email" id="email-id-column" class="form-control"
                                                value="{{ $User->bank_name }}" readonly>
                                        </div>
                                    </div>

                                    <a href="/users/history/{{ $User->id }}" class="btn btn-primary"> View user history
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
