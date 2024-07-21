@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Order Histories </h3>
                    <p class="text-subtitle text-muted">View and manage order histories on the system</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">order</li>
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
                    Order histories
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col">SN</th>
                                <th>Username</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($Histories as $index => $History)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $History->username }}</strong></td>
                                    <td><strong>{{ strtoupper($History->name) }}</strong></td>
                                    <td><span class="badge bg-primary"> {{ $History->quantity }} </span> </td>
                                    <td><strong>{{ $History->service }}</strong></td>
                                    <td>{{ number_format($History->product_price, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($History->status == 'success') bg-success @else bg-warning @endif">
                                            {{ $History->status }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ date('F d, Y', strtotime($History->created_at)) }}
                                    </td>
                                    <td>
                                        <a href="/view-order-details/{{ $History->id }}" class="btn btn-primary"> View more</a>
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
