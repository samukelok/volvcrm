<!-- Top Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4">
    <div class="container-fluid">
        <button class="btn btn-link d-md-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="d-flex align-items-center ms-auto">
            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="profileDropdown"
                    data-bs-toggle="dropdown">
                    <div class="lead-avatar me-2">JS</div>
                    <span>{{ $user->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="" onclick="logoutUser()"><i
                                class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
