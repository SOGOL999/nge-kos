<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link href="{{ asset('assets/vendor/sweetalert/sweetalert.min.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body style="background-color: #eee;">

    <section class="vh-150 mt-3 mb-2" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-4">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                    <form action="{{ route('auth.store') }}" method="POST" class="mx-1 mx-md-4">
                                        @csrf

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <input name="name" type="text" value="{{ old('name') }}" id="form3Example1c" class="form-control" />
                                                <label class="form-label" for="form3Example1c">Your Name</label>
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <input name="email" type="email" value="{{ old('email') }}" id="form3Example3c" class="form-control" />
                                                <label class="form-label" for="form3Example3c">Your Email</label>
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <input name="password" type="password" id="form3Example4c" class="form-control" />
                                                <label class="form-label" for="form3Example4c">Password</label>
                                                @error('password_confirmation')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <input name="password_confirmation" type="password" id="form3Example4cd" class="form-control" />
                                                <label class="form-label" for="form3Example4cd">Repeat your
                                                    password</label>
                                            </div>
                                        </div>

                                        <div class="form-check d-flex justify-content-center mb-4">
                                            <label class="form-check-label">
                                                already have an account? <a href="{{ route('auth.login') }}">Sign in</a>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg">Register</button>
                                        </div>

                                    </form>
                                </div>

                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2 position-relative">

                                    <p class="text-center h1 fw-semibold mx-1 mx-md-4 mt-4 position-absolute" style="top: 0; width: 100%;">18TH KOS</p>

                                    <img src="{{ asset('uploads/picture/bedroom.jpg') }}" class="img-fluid w-100 mb-5" alt="Sample image">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/fontawesome/js/all.js') }}"></script>
<script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

{{-- Sweetalert --}}

{{-- Success --}}
@if (session('message'))
    <script>
        Swal.fire({
            position: "top-end",
            title: "{{ session('message') }}",
            icon: "{{ session('type-message') }}",
            showConfirmButton: false,
            toast: true,
            timer: 2500,
        });
    </script>
@endif

{{-- Error --}}
@if ($errors->any())
    <script>
        Swal.fire({
            position: "top-end",
            title: "Terjadi kesalahan, silakan coba lagi!",
            icon: "error",
            toast: true,
            showConfirmButton: false,
            timer: 2500,
        });
    </script>
@endif

{{-- Delete --}}
@if (session('message_delete'))
    <script>
        Swal.fire({
            position: "top-end",
            title: "{{ session('message_delete') }}",
            icon: "{{ session('type-message') }}",
            showConfirmButton: false,
            toast: true,
            timer: 2500,
        });
    </script>
@endif

</html>
