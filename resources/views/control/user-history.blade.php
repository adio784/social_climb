@extends('components.base-component')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>View History</h3>
                <p class="text-subtitle text-muted">View User informations and history</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User history</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
<section class="section">
    <div class="card">
        <div class="card-header">
            {{ strtoupper($User->username) . ' Fund History'}}
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>State</th>
                        <th>Channel</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($FHistories as $Fund)
                    <tr>
                        <td>{{ number_format($Fund->amount, 2) }}</td>
                        <td>{{ $Fund->reference }}</td>
                        <td>
                            <span class="badge @if($Fund->status =='active') {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif">{{ Str::ucfirst($Fund->status) }}</span>
                        </td>
                        <td> {{ $Fund->payment_mode }} </td>
                        <td> {{ $User->created_at }} </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</section>


@endsection
