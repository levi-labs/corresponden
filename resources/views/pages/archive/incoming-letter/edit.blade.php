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
                        <form action="{{ route('archive-incoming-letter.update', $data->id) }}') }}"
                            enctype="multipart/form-data" method="post">
                            @method('PUT')
                            @csrf
                            <!-- Quill Editor Default -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="letter_number">Letter Number<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="letter_number" id="letter_number"
                                    value="{{ old('letter_number') ?? $data->letter_number }}">
                                @error('letter_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="from">From<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="from" id="from"
                                    value="{{ old('from') ?? $data->sender }}">
                                @error('from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="to">To<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="to" id="to"
                                    value="{{ old('to') ?? $data->receiver }}">
                                @error('to')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="date">Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date" id="date"
                                    value="{{ old('date') ?? $data->date }}">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="letter_type">Letter Type<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" name="letter_type" id="letter_type">
                                    <option selected disabled>Select Letter Type</option>
                                    @foreach ($letterTypes as $letterType)
                                        <option {{ $data->letter_type_id == $letterType->id ? 'selected' : '' }}
                                            value="{{ $letterType->id }}">{{ $letterType->name }}</option>
                                    @endforeach
                                </select>
                                @error('letter_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="source_letter">Source Letter<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" name="source_letter" id="source_letter">
                                    <option selected disabled>Select Source Letter</option>
                                    <option {{ $data->source_letter == 'internal' ? 'selected' : '' }} value="internal">
                                        internal</option>
                                    <option {{ $data->source_letter == 'external' ? 'selected' : '' }} value="external">
                                        external</option>
                                </select>
                                @error('source_letter')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="subject">Subject</label>
                                <input type="text" class="form-control" name="subject" id="subject"
                                    value="{{ old('subject') ?? $data->subject }}">
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="description">Description</label>
                                <div id="editor" style="height: 200px"></div>
                                <textarea rows="3" class="mb-3 d-none" name="description" id="quill-editor-area-description">{{ old('description') ?? $data->body }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="attachment">File : (optional)</label>
                                <input type="file" class="form-control" name="attachment" id="attachment">
                                @error('attachment')
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

            quill.root.innerHTML = decs.value;
            quill.on('text-change', function(delta, oldDelta, source) {
                decs.value = quill.root.innerHTML;
            });
            decs.addEventListener('input', function() {
                quill.root.innerHTML = decs.value
            });


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
