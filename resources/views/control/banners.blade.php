@extends('components.base-component')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>App Banner</h3>
                    <p class="text-subtitle text-muted">View notifications list on the system</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">App Banner</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Notifications
                    <a href="{{ route('create_notice') }}" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createNotice">Create New </a>
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

                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Banners as $Banner)
                                <tr>
                                    <td>{{ $Banner->title }}</td>
                                    <td><img src="{{ asset('storage/' . $Banner->banner_image) }}" alt="Banner Image"
                                            class="img-fluid w-25"></td>
                                    <td>
                                        <span
                                            class="badge @if ($Banner->status == 1) {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif">{{ Str::ucfirst($Banner->status == 1) ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                    <td>
                                        {{ $Banner->created_at }}
                                    </td>
                                    <td>
                                        <a href="/banner/toggle/{{ $Banner->id }}"
                                            class="btn @if ($Banner->status == 1) btn-danger @else btn-success @endif ">
                                            @if ($Banner->status == 1)
                                                Disable
                                            @else
                                                Activate
                                            @endif
                                        </a>
                                        <a href="/banner/delete/{{ $Banner->id }}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>


    {{-- Create Notification Modal --}}
    <div class="modal fade text-left" id="createNotice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">App Banner </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form method="post" action="{{ route('create_banner') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Title: </label>
                            <div class="form-group">
                                <input type="text" placeholder="welcome ..." class="form-control" name="title">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Upload Image: <small> Max Size: 2MB, Image Format: jpg, jpeg, png only | Dimensions: 1920
                                    x 1080 or less </small></label>
                            <div class="form-group">
                                <input type="file" class="form-control" name="bannerImage"></textarea>
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
