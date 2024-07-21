@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Bill Histories </h3>
                    <p class="text-subtitle text-muted">View and manage bill histories on the system</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">bill</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Data histories
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col">SN</th>
                                <th>Disco</th>
                                <th>Username</th>
                                <th>Meter Number</th>
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
                                    <td><strong>{{ strtoupper($History->name) }}</strong></td>
                                    <td><strong>{{ $History->username }}</strong></td>
                                    <td><strong>{{ $History->meter_number }}</strong></td>
                                    <td>{{ $History->paid_amount }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($History->Status == 'success') bg-success @else bg-warning @endif">
                                            {{ $History->Status }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ date('F d, Y', strtotime($History->created_at)) }}
                                    </td>
                                    <td>
                                        <a href="/view-bill-details/{{ $History->id }}" class="btn btn-primary"> View more</a>
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
