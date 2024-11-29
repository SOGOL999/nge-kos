@include('templates.header')

<div class="main" id="main">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h3 class="text-center mt-2">Form Edit Bedroom</h3>
                    <a href="{{ route('bedroom.index') }}" class="btn btn-primary btn-sm mt-4 mb-2">Return</a>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('bedroom.update', $see->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Bedroom Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') ?? $see->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" value="{{ old('price') ?? $see->price }}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <label>Bedroom Picture</label>
                            <input type="file" class="form-control" name="picture">
                            <button class="btn btn-success mt-2">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('templates.footer')
