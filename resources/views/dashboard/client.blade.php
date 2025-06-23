@extends('layouts.dashboards')

@section('content')
<!-- Sidebar -->
@include('sections.dashboard_side')

<!-- Main Content -->
<div class="main-content" id="mainContent">
    @include('sections.dashboard_header')

    <!-- Dashboard Content -->
    <div class="container-fluid">
        <h2 class="mb-4">Dashboard Overview</h2>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3" style="background-color: #6366f1;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Leads</h6>
                                <h3 class="mb-0">1,248</h3>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> 12.5% from last week</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3" style="background-color: #10b981;">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Active Funnels</h6>
                                <h3 class="mb-0">4</h3>
                                <small class="text-muted">Conversion Rate: 8.3%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3" style="background-color: #3b82f6;">
                                <i class="fas fa-envelope-open"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Email Open Rate</h6>
                                <h3 class="mb-0">42.5%</h3>
                                <small class="text-muted">Click Rate: 8.3%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3" style="background-color: #8b5cf6;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Recent Leads</h6>
                                <h3 class="mb-0">24</h3>
                                <small class="text-muted">Last 24 hours: 5</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Leads -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Leads</h5>
                <a href="#" class="btn btn-sm btn-primary">View All Leads</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Funnel</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="lead-avatar me-2">MJ</div>
                                        <span>Michael Johnson</span>
                                    </div>
                                </td>
                                <td>michael@example.com</td>
                                <td>+27 82 123 4567</td>
                                <td>Solar Starter</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success badge-pill">Converted</span></td>
                                <td>2 hours ago</td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="lead-avatar me-2">SD</div>
                                        <span>Sarah Davis</span>
                                    </div>
                                </td>
                                <td>sarah@example.com</td>
                                <td>+27 83 987 6543</td>
                                <td>Premium Solar</td>
                                <td><span class="badge bg-warning bg-opacity-10 text-warning badge-pill">Pending</span></td>
                                <td>1 day ago</td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="lead-avatar me-2">TB</div>
                                        <span>Thomas Brown</span>
                                    </div>
                                </td>
                                <td>thomas@example.com</td>
                                <td>+27 84 555 1234</td>
                                <td>Solar Starter</td>
                                <td><span class="badge bg-danger bg-opacity-10 text-danger badge-pill">Rejected</span></td>
                                <td>2 days ago</td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="lead-avatar me-2">EW</div>
                                        <span>Emma Wilson</span>
                                    </div>
                                </td>
                                <td>emma@example.com</td>
                                <td>+27 81 321 6549</td>
                                <td>Commercial Solar</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success badge-pill">Converted</span></td>
                                <td>3 days ago</td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="lead-avatar me-2">RG</div>
                                        <span>Robert Green</span>
                                    </div>
                                </td>
                                <td>robert@example.com</td>
                                <td>+27 83 111 2222</td>
                                <td>Premium Solar</td>
                                <td><span class="badge bg-warning bg-opacity-10 text-warning badge-pill">Pending</span></td>
                                <td>5 days ago</td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Funnel Performance -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Funnel Performance</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="funnelChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <a href="#" class="btn btn-primary mb-3">
                            <i class="fas fa-plus me-2"></i> Request New Funnel
                        </a>
                        <a href="#" class="btn btn-outline-primary mb-3">
                            <i class="fas fa-envelope me-2"></i> Send Bulk Email
                        </a>
                        <a href="#" class="btn btn-outline-primary mb-3">
                            <i class="fas fa-file-export me-2"></i> Export Leads
                        </a>
                        <a href="#" class="btn btn-outline-primary mb-3">
                            <i class="fas fa-chart-line me-2"></i> View Reports
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i> Invite Team Member
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection