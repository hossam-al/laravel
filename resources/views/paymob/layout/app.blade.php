<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Payment API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            transition: background 0.3s, color 0.3s;
        }

        .dark-mode body {
            background-color: #181a1b !important;
            color: #f1f1f1 !important;
        }

        .dark-mode .navbar,
        .dark-mode .navbar.bg-white {
            background-color: #23272b !important;
            color: #f1f1f1 !important;
        }

        .dark-mode .sidebar {
            background-color: #23272b !important;
            color: #fff !important;
        }

        .dark-mode .sidebar a,
        .dark-mode .sidebar a:hover {
            color: #fff !important;
            background: #23272b !important;
        }

        .dark-mode .dropdown-menu {
            background-color: #23272b !important;
            color: #fff !important;
        }

        .sidebar {
            height: 100vh;
            background-color: #0d6efd;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }

        .sidebar a:hover {
            background-color: #0b5ed7;
        }

        /* تنسيق الناف بار */
        .navbar {
            min-height: 70px;
            display: flex;
            align-items: center;
        }

        .navbar .nav-profile img {
            margin-bottom: 0 !important;
            margin-right: 10px;
            border: 2px solid #0d6efd;
            width: 55px;
            height: 55px;
            object-fit: cover;
        }

        .navbar-nav .dropdown-menu {
            min-width: 220px;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-flex flex-column p-3">
                <h4 class="mb-4">PayDashboard</h4>
                <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="{{ route('transaction.index') }}"><i class="bi bi-cash-stack"></i> Transactions</a>
                <a href="{{ route('paymob.index') }}"><i class="bi bi-credit-card-2-back"></i> Payment Methods</a>
                <a href="{{ route('profile.index') }}"><i class="bi bi-person"></i> Users</a>
                <a href="{{ route('transaction.pending') }}"><i class="bi bi-arrow-repeat"></i> pending</a>

                <a href="{{ route('profile.settings') }}"><i class="bi bi-gear"></i> Settings</a>
            </div>
            <!-- Main Content -->
            <div class="col-md-10">
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
                    <div class="container-fluid">
                        <span class="navbar-brand fw-bold text-primary" style="font-size: 1.3rem;">
                            Welcome Paymob Gateway
                        </span>
                        <!-- زر تبديل الوضع -->
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                                    <img src="{{ auth()->user()->image
                                        ? asset('upload/' . auth()->user()->image)
                                        : 'https://imgs.search.brave.com/gZ3W9GjnWyv8g9cDfw1qrVag80rOPbBgaMDkSRu3z40/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/dmVjdG9yc3RvY2su/Y29tL2kvcHJldmll/dy0xeC8wOC82MS9w/ZXJzb24tZ3JheS1w/aG90by1wbGFjZWhv/bGRlci1saXR0bGUt/Ym95LXZlY3Rvci0y/MzE5MDg2MS5qcGc' }}"
                                    class="rounded-circle shadow mb-3" alt="Admin Profile Image">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                    <li class="dropdown-header">
                                        <h6>{{ Auth::user()->name }}</h6>
                                        <span>Web Designer</span>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-person"></i>
                                            <span>My Profile</span>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.settings') }}">
                                            <i class="bi bi-gear"></i>
                                            <span>Account Settings</span>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                            <i class="bi bi-question-circle"></i>
                                            <span>Need Help?</span>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="post" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                                <i class="bi bi-box-arrow-right"></i>
                                                <span>Sign Out</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- Dynamic Content -->
                <div class="container">

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        // تفعيل الوضع الداكن إذا كان محفوظ
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
        document.getElementById('toggle-dark').onclick = function() {
            document.documentElement.classList.toggle('dark-mode');
            if(document.documentElement.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        }
    </script>
</body>
</html>
