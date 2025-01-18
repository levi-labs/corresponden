@extends('layouts.main.master')
<style>
    /* Gaya untuk Select2 */

    .select2-container .select2-selection--single {
        height: 2.5rem !important;
        /* Sesuaikan dengan tinggi standar Bootstrap */
        border: 1px solid #0d6efd;
        /* Gunakan warna border dari primary color Bootstrap */
        border-radius: 0.25rem;
        /* Radius border seperti pada form input standar Bootstrap */
        padding: 5px 5px !important;
        /* Padding standar untuk elemen form Bootstrap */
        font-size: 1rem;
        /* Ukuran font standar */
        line-height: 1.5;
        /* Jarak antar teks dalam input */
        background-color: #fff;
        /* Latar belakang putih */
        color: #495057;
        /* Warna teks standar */
    }

    /* Warna teks placeholder untuk Select2 */
    .select2-container .select2-selection__rendered {
        color: #6c757d;
        /* Warna placeholder di Bootstrap */
    }

    /* Gaya untuk focus state, border dengan warna lebih terang saat fokus */
    .select2-container .select2-selection--single:focus {
        border-color: #80bdff;
        /* Warna border fokus yang lebih terang */
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        /* Efek shadow */
        outline: 0;
    }

    .select2-container .select2-selection__arrow {
        height: 1.5rem !important;
        width: 1rem !important;
        top: 50% !important;
        margin-top: -14px !important;
        right: 5px !important;
        /* border-left: 1px solid #ccc !important; */
    }
</style>
@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        {{-- <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav> --}}
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Form Letter') }}</h5>
                        @if (session('success'))
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Success!</h4>
                                <p>{{ session('success') }}</p>
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Error!</h4>
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <!-- Quill Editor Default -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="fullname">Full Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fullname" id="fullname"
                                    value="{{ old('fullname') ?? $data->fullname }}">
                                @error('fullname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option selected disabled>Choose Gender</option>
                                    <option {{ $data->gender == 'male' ? 'selected' : '' }} value="male">Male</option>
                                    <option {{ $data->gender == 'female' ? 'selected' : '' }} value="female">Female</option>
                                </select>
                                @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="faculty">Faculty</label>
                                <input type="text" class="form-control" name="faculty" id="faculty"
                                    value="{{ old('faculty') ?? $data->faculty }}">
                                @error('faculty')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="date_of_birth">Date Of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                                    value="{{ old('date_of_birth') ?? $data->date_of_birth }}">
                                @error('date_of_birth')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="hobby">Hobby</label>
                                <input type="text" class="form-control" name="hobby" id="hobby"
                                    value="{{ old('hobby') ?? $data->hobby }}">
                                @error('hobby')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ old('phone') ?? $data->phone }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control" name="address" id="address">{{ old('address') ?? $data->address }}</textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="image">Image</label>
                                <input type="file" class="form-control" name="image" id="image"
                                    value="{{ old('image') ?? $data->image }}">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="year_enrolled">Year Enrolled</label>
                                <input type="number" placeholder="YYYY" min="1900" max="2099" class="form-control"
                                    name="year_enrolled" id="year_enrolled"
                                    value="{{ old('year_enrolled') ?? $data->year_enrolled }}">
                                @error('year_enrolled')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- End Quill Editor Default -->
                            <div class="text-end">
                                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- link jquery --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let quill = new Quill('#editor', {
                theme: 'snow'
            });
            let decs = document.getElementById('quill-editor-area-description');

            quill.on('text-change', function(delta, oldDelta, source) {
                decs.value = quill.root.innerHTML;
            });

            // desc.addEventListener('input', function() {
            //     quill.root.innerHTML = desc.value
            // });
        })
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var $j = jQuery.noConflict();

        // In your Javascript (external .js resource or <script> tag)
        $j(document).ready(function() {
            $j('.js-example-basic-single').select2({
                allowClear: true,
            });
        });
    </script>
@endsection
