@include('templates.header')

<div class="main" id="main">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h3 class="text-center">Form Add Bedroom</h3>
                    <a href="{{ route('bedroom.index') }}" class="btn btn-primary btn-sm">Return</a>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('bedroom.store') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf

                            <div class="form-group">
                                <label>Bedroom Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" value="{{ old('price') }}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bedroom Picture</label>
                                <input type="file" class="form-control" name="picture" value="{{ old('picture') }}">
                                @error('picture')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button class="btn btn-success mt-2">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('templates.footer')
