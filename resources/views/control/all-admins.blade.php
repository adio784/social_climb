@extends('components.base-component')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Admin List</h3>
                <p class="text-subtitle text-muted">View admin list on the system</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Administrators</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Admin Datatable
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Wallet balance</th>
                            <th>Status</th>
                            <th>Date Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Users as $User)
                        <tr>
                            <td>{{ $User->last_name . ' ' . $User->first_name }}</td>
                            <td>{{ $User->email }}</td>
                            <td>{{ $User->phone }}</td>
                            <td>{{ number_format($User->wallet_balance, 2) }}</td>
                            <td>
                                <span class="badge @if($User->status =='active') {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif">{{ Str::ucfirst($User->status) }}</span>
                            </td>
                            <td>
                                {{ $User->created_at }}
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
