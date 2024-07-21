@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Create Plan</h3>
                    <p class="text-subtitle text-muted">Create and manage plan record</p>
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
                            <h4 class="card-title">{{ 'Bill plan table' }}</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form action="{{ route('create_bill') }}" method="post">
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
                                                <label for="first-name-column">Disco Name</label>
                                                <select class="form-control" name="disco">
                                                    @foreach ($Discos as $Disco)
                                                        <option value="{{ $Disco->id }}">{{ $Disco->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4">
                                            <div class="form-group">
                                                <label for="plan_name">Plan Name</label>
                                                <input type="text" id="plan_name" name="plan_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4 mb-4">
                                            <div class="form-group">
                                                <label for="plan_code">Plan Code</label>
                                                <input type="text" id="plan_code" name="plan_code" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4">
                                            <div class="form-group">
                                                <label for="cost_price">Cost Price</label>
                                                <input type="text" id="cost_price" name="cost_price" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-4 mb-4">
                                            <div class="form-group">
                                                <label for="selling_price">Selling Price</label>
                                                <input type="text" id="selling_price" name="selling_price" class="form-control">
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
