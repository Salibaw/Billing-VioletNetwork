<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <button type="button" class="btn btn-primary nav-link" data-bs-toggle="modal" data-bs-target="#addBillModal">
                <i class="bi bi-book"></i>
                &nbsp; Tambah Pengguna Baru
            </button>
        </li><!-- End Add Bill Nav -->
        <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active dashboard' : '' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
    </a>
</li><!-- End Dashboard Nav -->

<li class="nav-item">
            <a class="nav-link {{ request()->routeIs('pelanggan') ? 'active pelanggan' : '' }}" href="{{ route('pelanggan') }}">
                <i class="bi bi-person"></i>
                <span>Pelanggan</span>
            </a>
        </li><!-- End Pelanggan Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('tagihan') ? 'active tagihan' : '' }}" href="{{ route('tagihan') }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Tagihan</span>
            </a>
        </li><!-- End Tagihan Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('maps') ? 'active maps' : '' }}" href="{{ route('maps') }}">
                <i class="bi bi-map"></i>
                <span>Maps</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active master' : '' }}" href="{{ route('home') }}">
                <i class="ri-home-3-line"></i>
                <span>Master</span>
            </a>
        </li><!-- End Master Nav -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.index') ? 'active report' : '' }}" href="{{ route('products.index') }}">
                <i class="bx bx-receipt"></i>
                <span>Report</span>
            </a>
        </li><!-- End Report Nav -->
    </ul>
</aside><!-- End Sidebar-->

<style>
    /* Add these styles to your CSS file */
    .sidebar-nav .nav-link {
        color: #000; /* Default color */
    }

    .sidebar-nav .nav-link.active {
        color: #fff; /* Color for active link */
        background-color: #7E8EF1; /* Background color for active link */
    }

    /* Optional: Different colors for different links */
    .sidebar-nav .nav-link.active.dashboard {
        background-color: #9DDE8B; /* Green for Dashboard */
    }

    .sidebar-nav .nav-link.active.pelanggan {
        background-color: #5C2FC2; /* Purple for Pelanggan */
    }

    .sidebar-nav .nav-link.active.tagihan {
        background-color: #FF6F61; /* Coral for Tagihan */
    }

    .sidebar-nav .nav-link.active.maps {
        background-color: #4CBB17; /* Green for Maps */
    }

    .sidebar-nav .nav-link.active.master {
        background-color: #17a2b8; /* Cyan for Master */
    }

    .sidebar-nav .nav-link.active.report {
        background-color: #5C2FC2; /* Purple for Report */
    }
</style>

<main id="main" class="main">

    @include('bills.add')
