@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Admin List</h3>
                    <p class="text-subtitle text-muted">View admin list on the system</p>
                    <a class="btn btn-primary fund_user" href="" data-bs-toggle="modal"
                        data-bs-target="#fundWalletModal"> Assign Permissions</a>
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
                                <th></th>
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
                                        <span
                                            class="badge @if ($User->status == 'active') {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif">{{ Str::ucfirst($User->status) }}</span>
                                    </td>
                                    <td>
                                        {{ $User->created_at }}
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
                                                    <a class="dropdown-item" href="/user/remove-admin/{{ $User->id }}">
                                                        Remove admin</a>
                                                    <a class="dropdown-item" href="/admin/permissions/{{ $User->id }}">
                                                        Permissions</a>

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


    {{-- Fund Wallet MODAL ============================================================================ --}}
    <div class="modal fade text-left" id="fundWalletModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Assign Permission to A User</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form method="post" action="{{ route('create-user-permisson') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Assign to: </label>
                            <select class="form-control" name="user_id" required>
                                <option value="" selected>-- Select admin --</option>
                                @foreach ($Users as $User)
                                    <option value="{{ $User->id }}">{{ $User->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row p-2">
                                @foreach ($Permissions as $Permission)
                                    <div class="col-md-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="permissions[]" type="checkbox"
                                                value="{{ $Permission->name }}" />
                                            <label class="form-check-label" for="showHide"><strong> {{ $Permission->name }}
                                                </strong> </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
