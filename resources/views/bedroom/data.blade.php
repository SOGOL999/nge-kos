@include('templates.header')

<div class="main" id="main">
    <div class="pagetitle">
        <h1>Bedroom</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Bedroom</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <a href="{{ route('bedroom.create') }}" class="btn btn-primary btn-sm mb-2">New <i class="fa fa-plus"></i></a>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bedroom Name</th>
                                    <th>Price</th>
                                    <th>Picture</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bedroom as $see)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $see->name }}</td>
                                        <td>{{ $see->price }}</td>
                                        <td><img src="{{ asset('uploads/bedroom/' . $see->picture) }}" width="200" height="200"></td>
                                        <td>{{ $see->status }}</td>
                                        <td>
                                            <form id="delete-form-{{ $see->id }}" action="{{ route('bedroom.destroy', $see->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <a href="{{ route('bedroom.edit', $see->id) }}"><button type="button" class="btn btn-warning btn-sm"><i class="text-white fa fa-pencil"></i></button></a>
                                                <button onclick="confirmDelete({{ $see->id }})" class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
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


@include('templates.footer')
