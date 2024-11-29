@include('templates.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <!-- Left side columns -->

    @if (auth()->user()->role == 'customer')
        <p class="fs-3">Welcome To Our Dashboard <b class="fs-3">{{ auth()->user()->name }}</b>!</p>
    @endif

    @if (auth()->user()->role == 'admin')
        @include('templates.dashboard_admin', [
            'bedroom_count'     => $bedroom_count,
            'bedroom_total'     => $bedroom_total,
            'customer_total'    => $customer_total,
            'booking_data'      => $booking_data,
            'bedroom_available' => $bedroom_available,
        ])
    @endif


</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('templates.footer')
