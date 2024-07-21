@extends('components.base-component')

@section('content')



    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detailed History</h3>
                    <p class="text-subtitle text-muted">View history</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">history</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        @isset($History)

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ strtoupper($History->username) .  ' (' . $History->created_at->diffForHumans() . ')' }}</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="company-column">Transaction ID</label>
                                                <h4>{{ $History->reference }}</h4>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">Disco</label>
                                                <h4>{{ strtoupper($History->name) }}</h4>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="last-name-column">Type</label>
                                                <h4>{{ $History->meter_type  }}</h4>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="city-column">Price</label>
                                                <h4>{{ $History->paid_amount }}</h4>
                                            </div><hr>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="city-column">Status</label>
                                                <h4>{{ $History->status }}</h4>
                                            </div><hr>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="country-floating">Medium</label>
                                                <h4>{{ $History->medium }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="company-column">Balance Before</label>
                                                <h4>{{ $History->balance_before }}</h4>
                                            </div><hr>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="company-column">Balance After</label>
                                                <h4>{{ $History->balance_after }}</h4>
                                            </div><hr>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="company-column">Refund</label>
                                                <h4>{{ $History->refund ==1 ? 'Yes' : 'No' }}</h4>
                                            </div><hr>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="company-column">Response from API</label>
                                                <h4>{{ $History->api_response }}</h4>
                                            </div><hr>
                                        </div>

                                        <div class="col-md-12 col-12 mb-10">
                                            <div class="form-group">
                                                <label for="company-column">Transaction Date</label>
                                                <h4>{{ date('F d, Y', strtotime($History->created_at)) }}</h4>
                                            </div>
                                        </div>

                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @else

        <div class="card">
            <div class="card-body">
                <h4>No record found !!!</h4>
            </div>
        </div>
        @endisset
    </div>
@endsection
