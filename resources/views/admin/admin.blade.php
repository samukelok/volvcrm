@extends('layouts.admin')

@section('content')
    <div class="admin-dashboard">
        @include('sections.admin_side')
        

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            @include('sections.admin_header')

            <!-- Dashboard Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard Overview</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card primary h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Active Clients</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card success h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Active Funnels</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card warning h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Leads This Month</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">1,248</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card danger h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Pending Funnel Requests</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <!-- Leads Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4" id="maintained">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Leads Overview</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">View Options:</div>
                                        <a class="dropdown-item" href="#">Last 7 Days</a>
                                        <a class="dropdown-item" href="#">Last 30 Days</a>
                                        <a class="dropdown-item" href="#">This Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="leadsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Funnel Performance -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4" id="maintained">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Top Performing Funnels</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Solar Starter Package</span>
                                        <span class="text-primary">45%</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 45%"
                                            aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Premium Solar System</span>
                                        <span class="text-success">32%</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 32%"
                                            aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Commercial Solar</span>
                                        <span class="text-info">25%</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Custom Solar Solution</span>
                                        <span class="text-warning">18%</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 18%"
                                            aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Solar Accessories</span>
                                        <span class="text-danger">12%</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 12%"
                                            aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clients & Funnel Requests -->
                <div class="row">
                    <!-- Active Clients -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4" id="long_card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" >
                                <h6 class="m-0 font-weight-bold text-primary">Active Clients</h6>
                                <a href="#" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Client</th>
                                                <th>Plan</th>
                                                <th>Funnels</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="client-avatar me-2">JS</div>
                                                        <span>John Solar</span>
                                                    </div>
                                                </td>
                                                <td>Growth</td>
                                                <td>3</td>
                                                <td><span class="badge bg-success badge-pill">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="client-avatar me-2">RE</div>
                                                        <span>Real Estate Pros</span>
                                                    </div>
                                                </td>
                                                <td>Scale</td>
                                                <td>5</td>
                                                <td><span class="badge bg-success badge-pill">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="client-avatar me-2">TP</div>
                                                        <span>Tutor Pro</span>
                                                    </div>
                                                </td>
                                                <td>Starter</td>
                                                <td>1</td>
                                                <td><span class="badge bg-warning badge-pill">Pending</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="client-avatar me-2">BS</div>
                                                        <span>Beauty Salon</span>
                                                    </div>
                                                </td>
                                                <td>Growth</td>
                                                <td>2</td>
                                                <td><span class="badge bg-success badge-pill">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="client-avatar me-2">CD</div>
                                                        <span>Car Dealership</span>
                                                    </div>
                                                </td>
                                                <td>Scale</td>
                                                <td>4</td>
                                                <td><span class="badge bg-danger badge-pill">Overdue</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="client-avatar me-2">MS</div>
                                                        <span>M&M Solurgy</span>
                                                    </div>
                                                </td>
                                                <td>Scale</td>
                                                <td>7</td>
                                                <td><span class="badge bg-success badge-pill">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="client-avatar me-2">HD</div>
                                                        <span>High Density</span>
                                                    </div>
                                                </td>
                                                <td>Scale</td>
                                                <td>1</td>
                                                <td><span class="badge bg-danger badge-pill">Suspended</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Funnel Requests -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4" id="long_card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" >
                                <h6 class="m-0 font-weight-bold text-primary">Recent Funnel Requests</h6>
                                <a href="#" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Solar Starter - June Promo</h6>
                                            <small class="text-success">New</small>
                                        </div>
                                        <p class="mb-1">John Solar - Requested today</p>
                                        <small>Goal: Capture leads for June discount offer</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Luxury Home Listing</h6>
                                            <small class="text-warning">In Progress</small>
                                        </div>
                                        <p class="mb-1">Real Estate Pros - Requested 2 days ago</p>
                                        <small>Goal: Generate buyer interest for luxury property</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Summer Tutoring Packages</h6>
                                            <small class="text-info">Pending Review</small>
                                        </div>
                                        <p class="mb-1">Tutor Pro - Requested 3 days ago</p>
                                        <small>Goal: Signups for summer tutoring programs</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Bridal Makeup Special</h6>
                                            <small class="text-success">Completed</small>
                                        </div>
                                        <p class="mb-1">Beauty Salon - Delivered yesterday</p>
                                        <small>Goal: Book bridal makeup appointments</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">SUV Test Drive Campaign</h6>
                                            <small class="text-danger">Needs Info</small>
                                        </div>
                                        <p class="mb-1">Car Dealership - Requested 5 days ago</p>
                                        <small>Goal: Schedule test drives for new SUV model</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
