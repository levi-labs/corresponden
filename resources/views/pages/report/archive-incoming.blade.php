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
    </div>
    <!-- End Page Title -->

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
                        <form action="{{ route('report.print-incoming') }}" method="post" target="_blank">
                            @csrf
                            <!-- Quill Editor Default -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="dari">Dari<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="dari" id="dari"
                                    value="{{ old('dari') }}">
                                @error('dari')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="sampai">Sampai<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="sampai" id="sampai"
                                    value="{{ old('sampai') }}">
                                @error('sampai')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- End Quill Editor Default -->
                            <div class="text-end">
                                <button type="button" id="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let from = document.getElementById('dari');
            let to = document.getElementById('sampai');
            let submit = document.getElementById('submit');

            from.addEventListener('change', function() {
                if (from.value === '' && to.value === '') {
                    submit.setAttribute('type', 'button');
                } else if (from.value !== '' || to.value !== '') {
                    submit.setAttribute('type', 'submit');
                    submit.removeAttribute('disabled');
                }
            })

            to.addEventListener('change', function() {
                if (from.value === '' && to.value === '') {
                    submit.setAttribute('type', 'button');
                } else if (from.value !== '' || to.value !== '') {
                    submit.setAttribute('type', 'submit');
                    submit.removeAttribute('disabled');
                }
            })

        })
    </script>
@endsection
