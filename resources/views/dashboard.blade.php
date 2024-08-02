@extends('components.base-component')

@section('content')

    <div class="page-heading">
        <h3>Profile Statistics</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Users</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalUser ?? 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Networks</h6>
                                        <h6 class="font-extrabold mb-0">{{ $network ?? 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Products</h6>
                                        <h6 class="font-extrabold mb-0">{{ $product ?? 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Order</h6>
                                        <h6 class="font-extrabold mb-0">{{ $order ?? 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="profileVisitChart"></canvas>
                                {{-- <div id="chart-profile-visit"></div> --}}
                                {{--  profileVisitChart  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-5">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img src="{{ asset('images/user.jpeg') }}" alt="Face 1">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->last_name . ' ' . Auth::user()->first_name }}</h5>
                                <h6 class="text-muted mb-0">{{ Auth::user()->email }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Recent Orders</h4>
                    </div>
                    <div class="card-content pb-4">
                        @if ($orders ?? '')
                            @foreach ($orders as $ord)
                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="avatar avatar-lg">
                                        <img src="{{ asset('images/order.jpeg') }}">
                                    </div>
                                    <div class="name ms-4">
                                        <h5 class="mb-1">{{ $ord->name }}</h5>
                                        <h6 class="text-muted mb-0">{{ '@' . $ord->username }}</h6>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="recent-message d-flex px-4 py-3">
                                <h4>No order ...</h4>
                            </div>
                        @endif

                        <div class="px-4">
                            <a href="/history/orders" class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>All
                                orders</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/profile-visits')
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const ctx = document.getElementById('profileVisitChart').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                'Oct', 'Nov', 'Dec'
                            ],
                            datasets: [{
                                label: 'Profile Visits',
                                data: [
                                    data[1] || 0,
                                    data[2] || 0,
                                    data[3] || 0,
                                    data[4] || 0,
                                    data[5] || 0,
                                    data[6] || 0,
                                    data[7] || 0,
                                    data[8] || 0,
                                    data[9] || 0,
                                    data[10] || 0,
                                    data[11] || 0,
                                    data[12] || 0
                                ],
                                backgroundColor: 'rgba(0, 0, 128, 0.8)',
                                borderColor: 'rgba(0, 0, 128, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>

@endsection
