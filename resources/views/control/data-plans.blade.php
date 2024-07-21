@extends('components.base-component')

@section('content')

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data List</h3>
                    <p class="text-subtitle text-muted">View and manage data plan on the system</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data plans</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
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
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Data plan records
                    <a href="{{ route('create-data') }}" class="btn btn-primary">Create New Plan</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col">SN</th>
                                <th>Network</th>
                                <th>Plan Size</th>
                                <th>Price</th>
                                <th>Validity</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($Pricing as $index => $Price)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $Price->network_name }}</td>
                                    <td>{{ $Price->plan_size . ' ' . strtoupper($Price->plan_measure) }}
                                    <td>{{ number_format($Price->plan_price, 2) }}</td>
                                    <td>{{ $Price->plan_validity }}</td>
                                    <td>
                                        {{ $Price->created_at }}
                                    </td>
                                    <td>
                                        <div class="btn-group mb-1">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                    id="dropdownMenuButtonIcon" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-error-circle me-50"></i> view more
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon">
                                                    <a class="dropdown-item" href="/pricing/data/{{ $Price->id }}"
                                                        href=""> View</a>
                                                    <a class="dropdown-item" href="/data/delete/{{ $Price->id }}" confirm="Are you sure to delete this record ?">
                                                        Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>


@endsection
