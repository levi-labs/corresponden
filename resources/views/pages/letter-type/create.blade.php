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
                        <h5 class="card-title">{{ $title }}</h5>

                        <form action="{{ route('letter-type.store') }}" method="post">
                            @csrf
                            <!-- Quill Editor Default -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Nama Surat</label>
                                <input type="text" class="form-control" name="name" id="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="type">Digunakan Untuk</label>
                                <select class="form-control" name="type" id="type">
                                    <option selected disabled>Pilih</option>
                                    <option value="lecture">Dosen</option>
                                    <option value="student">Mahasiswa</option>
                                    <option value="other">Lainnya</option>
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="description">Deskripsi</label>
                                <div id="editor" style="height: 100px">
                                    <p>Deskripsi jenis surat</p>
                                </div>
                                <textarea rows="3" class="mb-3 d-none" name="description" id="quill-editor-area-description"></textarea>
                                @error('description')
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let quill = new Quill('#editor', {
                theme: 'snow'
            });
            let decs = document.getElementById('quill-editor-area-description');

            quill.on('text-change', function(delta, oldDelta, source) {
                decs.value = quill.root.innerHTML;
            });

            decs.addEventListener('input', function() {
                quill.root.innerHTML = decs.value
            });
        })
    </script>
@endsection
