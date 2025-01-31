@extends('layouts.main.master')

@section('content')
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
                        <!-- Vertical Form -->
                        <form class="row g-3" action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="inputNanme4" name="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" class="form-select" aria-label="Default select example"
                                    name="role">
                                    <option selected>Open this select roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="staff">Staff</option>
                                    <option value="lecturer">Dosen</option>
                                    <option value="student">Mahasiswa</option>
                                    <option value="rector">Rektor</option>
                                    <option value="vice rector">Wakil Rektor</option>
                                    {{-- @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach --}}
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 is_koordinator">
                                <legend class="col-form-label col-sm-2 pt-0">Koordinator</legend>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="is_koordinator"
                                        value="1">
                                    <label for="gridCheck1" class="form-label">Yes/No</label>
                                </div>

                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                {{-- <button type="reset" class="btn btn-secondary">Reset</button> --}}
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let role = document.getElementById('role');
            let koordinator = document.querySelector('.is_koordinator');
            koordinator.style.display = 'none';
            role.addEventListener('change', function() {
                if (this.value == 'lecturer') {
                    koordinator.style.display = 'block';
                } else {
                    koordinator.style.display = 'none';
                }
            });
        });
    </script>
@endsection
