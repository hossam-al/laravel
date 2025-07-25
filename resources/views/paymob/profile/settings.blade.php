@extends('paymob.layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-gear me-2"></i>
                    <span>Account Settings</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if(auth()->user()->image)
                                <img src="{{ asset('upload/' . auth()->user()->image) }}" alt="Profile" class="mt-2 rounded-circle border" width="60" height="60">
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Changes</button>
                    </form>
                </div>
            </div> --}}

            <!-- Browser Mode & Notifications -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white d-flex align-items-center">
                    <i class="bi bi-moon-stars me-2"></i>
                    <span>Preferences</span>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-brightness-high me-2"></i>Browser Mode</span>
                        <button id="toggle-dark" class="btn btn-outline-dark">
                            <i id="theme-icon" class="bi"></i>
                            <span id="theme-label" class="ms-2"></span>
                        </button>
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-bell me-2"></i>Enable Notifications</span>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" id="notifSwitch">
                            <label class="form-check-label" for="notifSwitch"></label>
                        </div>
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-envelope-paper me-2"></i>Email Me About Updates</span>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" id="emailUpdatesSwitch" checked>
                            <label class="form-check-label" for="emailUpdatesSwitch"></label>
                        </div>
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-shield-lock me-2"></i>Two Factor Authentication</span>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" id="twoFactorSwitch">
                            <label class="form-check-label" for="twoFactorSwitch"></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <span>Danger Zone</span>
                </div>
                <div class="card-body">
                  @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Theme & Notification JS -->
<script>
    // Theme toggle
    function updateThemeIcon() {
        const icon = document.getElementById('theme-icon');
        const label = document.getElementById('theme-label');
        if(document.documentElement.classList.contains('dark-mode')) {
            icon.className = 'bi bi-sun';
            label.innerText = 'Light Mode';
        } else {
            icon.className = 'bi bi-moon';
            label.innerText = 'Dark Mode';
        }
    }
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark-mode');
    }
    updateThemeIcon();
    document.getElementById('toggle-dark').onclick = function() {
        document.documentElement.classList.toggle('dark-mode');
        if(document.documentElement.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
        updateThemeIcon();
    }

    // Notifications (demo only)
    document.getElementById('notifSwitch').addEventListener('change', function() {
        if(this.checked) {
            alert('Notifications enabled!');
        } else {
            alert('Notifications disabled!');
        }
    });
    document.getElementById('twoFactorSwitch').addEventListener('change', function() {
        if(this.checked) {
            alert('Two Factor Authentication enabled!');
        } else {
            alert('Two Factor Authentication disabled!');
        }
    });
</script>
@endsection
