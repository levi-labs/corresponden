@extends('layouts.main.master')

@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title }}</h5>
                        <!-- Vertical Form -->
                        <form class="row g-3" action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="col-12">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}">
                            </div>
                            <div class="col-12">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ $user->username }}">
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $user->email }}">
                            </div>
                            <div class="col-12">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" class="form-select" aria-label="Default select example"
                                    name="role">
                                    <option selected>Open this select roles</option>
                                    <option {{ $user->role === 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                                    <option {{ $user->role === 'staff' ? 'selected' : '' }} value="staff">Staff</option>
                                    <option {{ $user->role === 'lecturer' ? 'selected' : '' }} value="lecturer">Dosen
                                    </option>
                                    <option {{ $user->role === 'student' ? 'selected' : '' }} value="student">Mahasiswa
                                    </option>
                                    <option {{ $user->role === 'rector' ? 'selected' : '' }} value="rector">Rektor</option>
                                    <option {{ $user->role === 'vice rector' ? 'selected' : '' }} value="vice rector">Wakil
                                        Rektor</option>
                                    {{-- @foreach ($roles as $role)
                                        <option {{ $user->role === $role ? 'selected' : '' }} value="{{ $role }}">
                                            {{ $role }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-12 is_koordinator">
                                <legend class="col-form-label col-sm-2 pt-0">Koordinator</legend>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="is_koordinator"
                                        value="1" {{ $user->is_koordinator ? 'checked' : '' }}>
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
            if (role.value == 'lecturer') {
                koordinator.style.display = 'block';

            }
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
