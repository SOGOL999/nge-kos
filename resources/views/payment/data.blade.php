@include('templates.header')

<div class="main" id="main">
    <div class="pagetitle">
        <h1>Payment Data</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Payment</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row">
            <div class="card shadow">
                <h1 class="card-title text-center fs-3">Payment Data</h1>
                <table class="table table-borderless datatable mt-2" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Bedroom</th>
                            <th>Payment Date</th>
                            <th>Payment Period</th>
                            <th>Maturity</th>
                            <th>Status</th>
                            <th>Proof of Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking as $see)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $see->user->name }}</td>
                                <td>{{ $see->bedroom->name }}</td>
                                <td>{{ $see->payment_date }}</td>
                                <td>{{ date('F Y', strtotime($see->payment_period)) }}</td>
                                <td>{{ date('d F Y', strtotime($see->payment_date . '+1 month')) }}</td>
                                @if ($see->status == 'pending')
                                    <td class="badge bg-warning mt-2 text-light">Pending</td>
                                @endif
                                @if ($see->status == 'paid')
                                    <td class="badge bg-success mx-3 mt-2 text-light">Paid</td>
                                @endif
                                @if ($see->status == 'rejected')
                                    <td class="badge bg-danger mt-2 text-light">Rejected</td>
                                @endif
                                <td><button type="button" class="btn btn-secondary btn-sm mx-5" data-bs-toggle="modal" data-bs-target="#proof{{ $see->id }}">
                                        See
                                    </button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail Transaction --}}
@foreach ($booking as $item)
    <div class="modal fade" id="proof{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Proof of Payment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('uploads/booking/' . $item->payment_proof) }}" width="100%" height="100%">
                    <h5 class="mt-2">Customer: {{ $item->user->name }}</h5>
                    <h5>Bedroom: {{ $item->bedroom->name }}</h5>
                    <h5>Payment Date: {{ $item->payment_date }}</h5>
                    <h5>Payment Period: {{ date('F Y', strtotime($item->payment_period)) }}</h5>
                    <div class="modal-footer">

                        @if ($item->status !== 'paid' && $item->status !== 'rejected')
                            <form action="{{ route('booking.status', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="paid">
                                <button type="submit" class="btn btn-success">Paid</button>
                            </form>
                            <form action="{{ route('booking.status', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger">Rejected</button>
                            </form>
                        @endif

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@include('templates.footer')
