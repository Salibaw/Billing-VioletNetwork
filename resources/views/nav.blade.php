<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <button type="button" class="btn btn-primary nav-link" data-bs-toggle="modal" data-bs-target="#addBillModal">
                <i class="bi bi-book"></i>
                &nbsp; Add New Bill
            </button>
        </li><!-- End Add Bill Nav -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active dashboard' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
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

.sidebar-nav .nav-link.active.master {
    background-color: #17a2b8; /* Cyan for Master */
}

.sidebar-nav .nav-link.active.report {
    background-color: #5C2FC2; /* Yellow for Report */
}

</style>

<main id="main" class="main">

    @include('bills.add')
