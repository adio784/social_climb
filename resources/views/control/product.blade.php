@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>View Product</h3>
                    <p class="text-subtitle text-muted">View and update product record</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product View/Update</li>
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
                            <h4 class="card-title">{{ 'Product' }}</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form action="{{ route('edit_product') }}" method="POST">
                                    @csrf
                                    <div id="error_result">
                                        @if (Session::get('success'))
                                            <div class="alert alert-success alert-dismissible fade show text-dark"
                                                role="alert">
                                                <strong class="text-white">Success! </strong> <span class="text-white">
                                                    {{ Session::get('success') }} </span>
                                            </div>
                                        @endif
                                        @if (Session::get('fail'))
                                            <div class="alert alert-danger text-danger alert-dismissible fade show"
                                                role="alert">
                                                <strong class="text-white ">Oh Oops! </strong> <span class="text-white">
                                                    {{ Session::get('fail') }} </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">Product ID</label>
                                                <input type="hidden" name="plan_id" value="{{ $Plan->id }}">
                                                <input type="text" class="form-control" name="productId" value="{{ $Plan->product_id }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">Product Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $Plan->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4">
                                            <div class="form-group">
                                                <label for="category">Product Category</label>
                                                <input type="text" id="category" name="category" class="form-control"
                                                    value="{{ $Plan->category }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4">
                                            <div class="form-group">
                                                <label for="cost_rate">Cost Rate</label>
                                                <input type="text" id="cost_rate" name="cost_rate" class="form-control"
                                                    value="{{ $Plan->product_rate }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4">
                                            <div class="form-group">
                                                <label for="product_rate">Product Rate</label>
                                                <input type="text" id="product_rate" name="product_rate" class="form-control"
                                                    value="{{ $Plan->product_rate }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4">
                                            <div class="form-group">
                                                <label for="min">Min</label>
                                                <input type="text" id="min" name="min" class="form-control"
                                                    value="{{ $Plan->product_rate }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4">
                                            <div class="form-group">
                                                <label for="max">Max</label>
                                                <input type="text" id="max" name="max" class="form-control"
                                                    value="{{ $Plan->product_rate }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12 mt-4 mb-4">
                                            <div class="form-group">
                                                <label for="product_type">Product Type</label>
                                                <input type="text" id="product_type" name="product_type"
                                                    class="form-control" value="{{ $Plan->product_type }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12 mt-4 mb-4">
                                            <div class="form-group">
                                                <label for="description">Product Description</label>
                                                <textarea id="description" name="description" class="form-control">{{ $Plan->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12 mt-4 mb-4">
                                            <div class="form-group">
                                                <label for="dripfeed">Dripfeed</label>
                                                <input type="text" id="dripfeed" name="dripfeed"
                                                    class="form-control" value="{{ $Plan->dripfeed }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12 mt-4 mb-4">
                                            <div class="form-group">
                                                <label for="refill">Refill</label>
                                                <input type="text" id="refill" name="refill"
                                                    class="form-control" value="{{ $Plan->refill }}">
                                            </div>
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
