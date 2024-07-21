@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Payment Histories </h3>
                    <p class="text-subtitle text-muted">View and manage payment on the system</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">payment</li>
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
                    Payment records
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col">SN</th>
                                <th>Username</th>
                                <th>Reference</th>
                                <th>Amount</th>
                                <th>Payment ID</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($Histories as $index => $History)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $History->username }}</strong></td>
                                    <td><strong>{{ $History->reference }}</strong></td>
                                    <td><span class="badge bg-primary"> # {{ $History->amount }} </span> </td>
                                    <td>{{ $History->payment_id }}</td>
                                    <td>{{ $History->payment_mode }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($History->status == 'PAID') bg-success @else bg-danger @endif">
                                            {{ $History->status }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $History->created_at }}
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
