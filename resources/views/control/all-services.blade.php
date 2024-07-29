@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>All Services</h3>
                    <p class="text-subtitle text-muted">View services on the system</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    List of Services
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Services as $Service)
                                <tr>
                                    <td>{{ $Service->name }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($Service->is_active == 1) {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif">{{ Str::ucfirst($Service->is_active == 1) ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                    <td>
                                        @if ($Service->is_active == 1)
                                            <a href="/service/dissable/{{ $Service->id }}"
                                                class="btn btn-danger">Disable</a>
                                        @else
                                            <a href="/service/activate/{{ $Service->id }}"
                                                class="btn btn-primary">Activate</a>
                                        @endif
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
