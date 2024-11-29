@include('templates.header')

<div class="main" id="main">
    <div class="pagetitle">
        <h1>About Information</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Information</li>
                <li class="breadcrumb-item active">Bedroom</li>
            </ol>
        </nav>
    </div>

    {{-- Customer Information  --}}
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow">
                        <h5 class="text-center badge bg-secondary m-3">{{ $bedroom->name }}</h5>
                        <div class="card-body">
                            <img src="{{ asset('uploads/bedroom/' . $bedroom->picture) }}" width="100%" height="100%">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow">
                        <h4 class="card-title text-center fs-5">About Information</h4>
                        <hr class="mt-1">
                        <div class="card-body">

                            <div class="row g-6">
                                <div class="col-6 mt-2 mb-4">
                                    <h5>Name: </h5>{{ auth()->user()->name }}
                                </div>
                                <div class="col-6 mt-2 mb-4">
                                    <h5>Bedroom: </h5>{{ $bedroom->name }}
                                </div>
                                <div class="col-6">
                                    <h5>Check-in Date: </h5>
                                    {{ date('d F Y', strtotime(auth()->user()->check_in)) }}
                                </div>
                                <div class="col-6 mb-4">
                                    <h5>Status User: </h5>
                                    <p class="badge bg-secondary">{{ auth()->user()->user_status }}</p>
                                </div>
                                <div class="row mt-5">
                                    <form id="inactive-form-{{ auth()->user()->id }}" action="{{ route('auth.inactive') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <label>Inactive Your Account?</label><br>
                                        <button onclick="confirmInactive( {{ auth()->user()->id }} )" type="button" class="btn btn-warning mt-2">Click Here</button>
                                    </form>
                                </div>
                                <div class="col-6 mt-3">
                                    @foreach ($booking as $item)
                                        @php
                                            $today = date('Y-m-d');
                                            $maturity = date('Y-m-d', strtotime($item->payment_date . ' +1 month'));
                                        @endphp
                                    @endforeach
                                    @if ($today >= $maturity)
                                        <h5>Extended Period: </h5> <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ajukan">
                                            Pay here
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Transaction History --}}
                <div class="col-md-12 mt-4 mb-3">
                    <div class="card shadow">
                        <h4 class="card-title text-center">Transaction History</h4>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Proof of Payment</th>
                                        <th>Payment Date</th>
                                        <th>Payment Period</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bukti{{ $item->id }}">
                                                    Picture
                                                </button>
                                            </td>
                                            <td>{{ $item->payment_date }}</td>
                                            <td>{{ $item->payment_period }}</td>
                                            <td class="badge bg-success mt-2 text-light">{{ $item->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal request a new Period --}}
<div class="modal fade" id="ajukan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajukan Perpanjangan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <pre class="mt-3">{{ $rekening->rekening }}</pre>
                            <input type="hidden" name="bedroom_id" value="{{ $bedroom->id }}">
                            <label>Proof of Payment:</label>
                            <input type="file" class="form-control" name="payment_proof">
                            <button class="btn btn-secondary mt-2">Paid</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Picture Paid --}}
@foreach ($booking as $see)
    <div class="modal fade" id="bukti{{ $see->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Proof of Payment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <img src="{{ asset('uploads/booking/' . $see->payment_proof) }}" width="100%" height="100%">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@include('templates.footer')
