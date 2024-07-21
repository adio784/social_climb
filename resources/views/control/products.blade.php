@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Official Products </h3>
                    <p class="text-subtitle text-muted">View and manage product on the system</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div id="error_result">
            @if (Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show text-dark" role="alert">
                    <strong class="text-white">Success! </strong> <span class="text-white">
                        {{ Session::get('success') }} </span>
                </div>
            @endif
            @if (Session::get('fail'))
                <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                    <strong class="text-white ">Oh Oops! </strong> <span class="text-white">
                        {{ Session::get('fail') }} </span>
                </div>
            @endif
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Product records
                    <a href="{{ route('create-product') }}" class="btn btn-primary">Create New Plan</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col">SN</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Cost Rate</th>
                                <th>Selling Rate</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($Pricing as $index => $Price)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $Price->name }}</strong></td>
                                    <td>{{ $Price->category }}
                                    <td>{{ $Price->product_type }}</td>
                                    <td>{{ $Price->min }}</td>
                                    <td>{{ $Price->max }}</td>
                                    <td>{{ number_format($Price->cost_rate, 2) }}</td>
                                    <td>{{ number_format($Price->product_rate, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($Price->is_active == 1) bg-success @else bg-danger @endif">
                                            {{ $Price->is_active == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
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
                                                    <a class="dropdown-item" href="/pricing/products/{{ $Price->id }}"
                                                        href=""> View</a>
                                                    @if ($Price->is_active == 1)
                                                        <a class="dropdown-item"
                                                            href="/products/deactivate/{{ $Price->id }}">
                                                            Deactivate</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="/products/activate/{{ $Price->id }}">
                                                            Activate</a>
                                                    @endif
                                                    <a class="dropdown-item" href="/products/delete/{{ $Price->id }}"
                                                        confirm="Are you sure to delete this record ?">
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
