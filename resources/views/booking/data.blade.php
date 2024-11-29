@include('templates.header')

<style>
    .ukuran-sama {
        aspect-ratio: 3/2;
        object-fit: cover;
    }
</style>
<div id="main" class="main">
    <div class="pagetitle">
        <h1>Booking Bedroom</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Booking</li>
                <li class="breadcrumb-item active">Bedroom</li>
            </ol>
        </nav>
    </div>

    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <h2 class="text-center mb-3">Please select an available room!</h2>
                <div class="w-100"></div>
                @foreach ($bedroom as $item)
                    <div class="col-md-4 mt-4 mb-2">
                        <div class="card">
                            <img src="{{ asset('uploads/bedroom/' . $item->picture) }}" class="card-img-top ukuran-sama">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}
                                    @if ($item->status == 'unavailable')
                                        <small class="text-danger"><b class="badge bg-danger pt-2">Not Available</b></small>
                                    @endif
                                </h5>
                                <p class="card-text">Price: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $item->id }}">
                                    Detail
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@foreach ($bedroom as $see)
    <div class="modal fade" id="detail{{ $see->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Bedroom Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <b>Picture</b>
                            <img src="{{ asset('uploads/bedroom/' . $see->picture) }}" width="200">
                        </div>
                        <div class="col-md-6">
                            <b>Bedroom Facilities</b>
                            <p><i class="fa-solid fa-bed"></i> Mattress, Pillow, Bolster</p>
                            <p><i class="ri-inbox-fill"></i> Wardrobe</p>
                            <p><i class="fa-solid fa-wifi"></i> Wi-Fi</p>
                            <p><i class="fa-solid fa-bolt-lightning"></i> Electricity</p>
                            <b>Bathroom Facilities</b>
                            <p><i class="fa-solid fa-bath"></i> Ensuite Bathroom</p>
                            <p><i class="fa-solid fa-shower"></i> Shower</p>
                            <p><i class="fa-solid fa-sink"></i> Sink</p>
                        </div>
                        <div class="col-md-6">
                            <b>Price</b>
                            <p>Rp{{ number_format($see->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <b>Status</b>
                            <p>{{ $see->status }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    @if ($see->status == 'available' && auth()->user()->user_status == null)
                        <a href="{{ route('booking.transaction', $see->id) }}" class="btn btn-success">Booking</a>
                    @elseif (auth()->user()->user_status == 'active')
                        <small class="text-danger"><b>You Already Have a Bedroom!</b></small>
                    @endif

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@include('templates.footer')
