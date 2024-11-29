@include('templates.header')

<div class="main" id="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h1 class="text-center mt-4">Edit Rekening</h1>
                {{-- <a href="{{ route('booking.index') }}" class="btn btn-outline-dark btn-sm m-2"> return</i></a> --}}
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('rekening.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <label>Rekening: </label>
                            <textarea name="rekening" class="form-control" rows="5">{{ $rekening->rekening }}</textarea><br>
                            <button class="btn btn-secondary mt-2">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('templates.footer')
