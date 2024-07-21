@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>User List</h3>
                    <p class="text-subtitle text-muted">View user list on the system</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Users Datatable
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Wallet balance</th>
                                <th>Status</th>
                                <th>Date Joined</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($Users as $index => $User)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $User->last_name . ' ' . $User->first_name }}</td>
                                    <td>{{ $User->email }}</td>
                                    <td>{{ $User->phone }}</td>
                                    <td>{{ number_format($User->wallet_balance, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($User->status == 'active') bg-success @else bg-danger @endif">{{ ucfirst($User->status) }}</span>
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
                                                    <a class="dropdown-item" href="/users/{{ $User->id }}"
                                                        href=""> View</a>
                                                    <a class="dropdown-item" href="/users/{{ $User->id }}"
                                                        href=""> Make admin</a>
                                                    <a class="dropdown-item fund_user" data-id="{{ $User->id }}"
                                                        href="" data-bs-toggle="modal"
                                                        data-bs-target="#fundWalletModal"> Fund user</a>
                                                    <a class="dropdown-item deactivate_user" data-id="{{ $User->id }}"
                                                        href="/users/deactivate/{{ $User->id }}"> Deactivate</a>
                                                    <a class="dropdown-item activate_user" data-id="{{ $User->id }}"
                                                        href="/users/activate/{{ $User->id }}"> Activate</a>
                                                    <a class="dropdown-item change_password" data-id="{{ $User->id }}"
                                                        href="" data-bs-toggle="modal"
                                                        data-bs-target="#changePasswordModal"> Change password</a>
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


    {{-- Change Password MODAL ============================================================================ --}}
    <div class="modal fade text-left" id="changePasswordModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Change Password Form </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="changePasswordForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label>New Password: </label>
                        <div class="form-group">
                            <input type="hidden" id="changePasswordUserId" name="user_id">
                            <input type="password" placeholder="Password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" id="changePassBtn" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Fund Wallet MODAL ============================================================================ --}}
    <div class="modal fade text-left" id="fundWalletModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Fund User Wallet </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="fundWalletForm" method="post" action="{{ route('fund_wallet') }}">
                    @csrf
                    <div class="modal-body">
                        <label>Amount: </label>
                        <div class="form-group">
                            <input type="hidden" id="fundWalletUserId" name="user_id">
                            <input type="number" placeholder="1000" class="form-control" name="amount">
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

    <script>
        $('.fund_user').click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var userId = $(this).data('id');
            $('#fundWalletUserId').val(userId);
        });

        $('.change_password').click(function() {
            var userId = $(this).data('id');
            $('#changePasswordUserId').val(userId);
        });

        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $("#changePassBtn").html($(
                '<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'
            ));
            $.ajax({
                method: 'POST',
                url: "{{ URL::to('change_user_pass') }}",
                data: formData,
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    alert('Password changed successfully.');
                    if (result != "") {
                        if (result.code == 200) {
                            // alert('Password changed successfully.');
                            $('#changePasswordForm').modal('hide');
                            $("#changePassBtn").html('Submit');
                        } else {
                            // alert('Error changing password.');
                            $("#changePassBtn").html('Submit');
                        }

                    }
                },
                error: function(result) {
                    console.log(result);
                    alert('Error changing password.');
                    $("#changePassBtn").html('Submit');
                }
            })
        });


        $('#fundWalletForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{ URL::to('fund_wallet') }}",
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function(response) {
                    alert('Wallet funded successfully.');
                    $('#fundWalletForm').modal('hide');
                },
                error: function(response) {
                    alert('Error funding wallet.');
                    console.log(response);
                }
            });
        });
    </script>
@endsection
