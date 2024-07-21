@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>View Plan</h3>
                    <p class="text-subtitle text-muted">View and update plan record</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Plan View/Update</li>
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
                            <h4 class="card-title">{{ 'Data plan table' }}</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form action="{{ route('edit_data') }}" method="post">
                                    @csrf
                                    <div id="error_result">
                                        @if(Session::get('success'))
                                            <div class="alert alert-success alert-dismissible fade show text-dark" role="alert">
                                                <strong class="text-white">Success! </strong> <span class="text-white"> {{ Session::get('success') }} </span>
                                            </div>
                                        @endif
                                        @if(Session::get('fail'))
                                        <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                            <strong class="text-white ">Oh Oops!  </strong> <span class="text-white"> {{ Session::get('fail') }} </span>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">Network</label>
                                                <input type="hidden" name="plan_id" value="{{ $Plan->id }}">
                                                <select class="form-control" name="network">
                                                    @foreach ($Networks as $Network)
                                                        <option @if($Network->id==1) selected @endif value="{{ $Network->id }}">{{ $Network->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('network')
                                                <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="last-name-column">Plan Size</label>
                                                <input type="text" id="last-name-column" name="plan_size" class="form-control" value="{{ $Plan->plan_size }}">
                                            </div>
                                            @error('plan_size')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">Value</label>
                                                <select class="form-control" name="plan_value">
                                                    <option value="mb" @if($Plan->plan_measure=='mb') selected @endif>MB</option>
                                                    <option value="gb" @if($Plan->plan_measure=='gb') selected @endif>GB</option>
                                                </select>
                                            </div>
                                            @error('plan_value')
                                                <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="city-column">Cost Price</label>
                                                <input type="text" id="city-column" name="cost_price" class="form-control" value="{{ $Plan->cost_price }}">
                                            </div>
                                            @error('cost_price')
                                                <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="city-column">Selling Price</label>
                                                <input type="text" id="city-column" name="selling_price" class="form-control" value="{{ $Plan->plan_price }}">
                                            </div>
                                            @error('selling_price')
                                                <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="country-floating">Validity</label>
                                                <input type="text" id="country-floating" name="validity" class="form-control" value="{{ $Plan->plan_validity }}">
                                            </div>
                                            @error('validity')
                                                <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="company-column">Plan ID</label>
                                                <input type="text" id="company-column" name="planID" class="form-control" value="{{ $Plan->vtpass_planid }}">
                                            </div>
                                            @error('planID')
                                                <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary"> Submit </button>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
