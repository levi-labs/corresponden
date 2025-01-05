@extends('layouts.main.master')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        {{-- <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav> --}}
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
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
                        <h5 class="card-title">{{ __('Form Letter Type') }}</h5>

                        <form action="{{ route('letter-type.update', $letterType->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <!-- Quill Editor Default -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $letterType->name }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="description">Description</label>
                                <div id="editor" style="height: 200px"></div>
                                <textarea rows="3" class="mb-3 d-none" name="description" id="quill-editor-area-description">{{ $letterType->description }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- End Quill Editor Default -->
                            <div class="text-center">
                                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

            desc.addEventListener('input', function() {
                quill.root.innerHTML = desc.value
            });
        })
    </script>
@endsection
