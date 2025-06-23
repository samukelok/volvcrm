@extends('layouts.dashboards')

@section('content')
    <!-- Sidebar -->
    @include('sections.dashboard_side')

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        @include('sections.dashboard_header')

        <!-- Dashboard Content -->
        <div class="container-fluid">

            {{-- Profile Content --}}
            <div class="profile-container">
                <h2 class="text-center mb-4">My Profile</h2>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Profile Info --}}
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="text-center">
                        <div class="img-center">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('img/user.png') }}"
                            class="avatar" alt="Avatar">
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">Change Profile Picture</label>
                            <input class="form-control" type="file" name="avatar" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email (readonly)</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                </form>

                <hr class="my-4">

                {{-- Change Password --}}
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('POST')

                    <h5 class="mb-3">Change Password</h5>

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Change Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
