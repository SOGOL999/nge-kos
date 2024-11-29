@include('templates.header')

<div class="main" id="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h1 class="text-center">Transaction</h1>
                <a href="{{ route('booking.index') }}" class="btn btn-outline-dark btn-sm m-2"> return</i></a>
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <pre class="mt-3">{{ $rekening->rekening }}</pre>
                            <input type="hidden" name="bedroom_id" value="{{ $bedroom_id }}">
                            <label>Proof of Payment:</label>
                            <input type="file" class="form-control mb-2" name="payment_proof">
                            <button class="btn btn-secondary mt-2">Paid</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('templates.footer')
