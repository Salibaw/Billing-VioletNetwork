<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <title>Violet Network</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
    ======================================================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.16/jspdf.plugin.autotable.min.js"></script>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn"></i>
            &nbsp; &nbsp;
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
                {{-- <img src="assets/img/logo.png" alt=""> --}}
                <span class="d-none d-lg-block">Violet Network</span>
            </a>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#" id="route-search-form">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword"
                    id="route-search-input" autocomplete="off">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
            <ul id="suggestions" class="suggestions-list"></ul>
        </div><!-- End Search Bar -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown">
                    @isset(Auth::user()->username)
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                            data-bs-toggle="dropdown">
                            @isset(Auth::user()->profile->photo)
                                <img src="{{ Auth::user()->profile->photo ? asset('storage/' . Auth::user()->profile->photo) : 'path/to/default/image.jpg' }}"
                                    alt="Profile" class="rounded-circle profile-img">
                            @endisset
                            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->username }}</span>
                        </a><!-- End Profile Image Icon -->
                    @endisset
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">View Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('settings') }}">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                            </form>
                        </li>
                    </ul>
                </li>
                &nbsp; &nbsp;
            </ul>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header -->

    <style>
        .profile-img {
            width: 40px;  /* Adjust the size as needed */
            height: 40px; /* Adjust the size as needed */
            object-fit: cover;
        }
    </style>

    <!-- Logout Form (hidden) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const routes = {
                "home": "/home",
                "dashboard": "/dashboard",
                "add bill": "/add-bill",
                "add product": "/add-product",
                // Add more routes as needed
            };

            const searchInput = document.getElementById('route-search-input');
            const suggestionsList = document.getElementById('suggestions');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.toLowerCase().trim();
                suggestionsList.innerHTML = ''; // Clear previous suggestions

                if (query) {
                    const matchedRoutes = Object.keys(routes).filter(route => route.includes(query));
                    if (matchedRoutes.length > 0) {
                        suggestionsList.style.display = 'block';
                        matchedRoutes.forEach(route => {
                            const listItem = document.createElement('li');
                            listItem.textContent = route;
                            listItem.addEventListener('click', function() {
                                searchInput.value = route;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(listItem);
                        });
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                } else {
                    suggestionsList.style.display = 'none';
                }
            });

            document.getElementById('route-search-form').addEventListener('submit', function(event) {
                event.preventDefault();

                const query = searchInput.value.toLowerCase().trim();
                if (routes[query]) {
                    window.location.href = routes[query];
                } else {
                    alert("No matching route found. Please try again.");
                }
            });

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(event) {
                if (!suggestionsList.contains(event.target) && event.target !== searchInput) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
