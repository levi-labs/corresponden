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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
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
                        <h5 class="card-title">
                            <a href="{{ route('archive-incoming-letter.create') }}" class="btn btn-primary btn-sm">Add</a>
                        </h5>

                        <!-- Table with hoverable rows -->
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Letter Type</th>
                                    <th scope="col">Message</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="flex-column align-items-center">
                                            <span class="badge border-dark border-1 text-dark text-wrap">From:
                                                {{ $item->sender }}</span>
                                            <div class="badge bg-info text-dark">{{ $item->letter_type }}</div>
                                        </td>
                                        <td>
                                            <a class="text-decoration-none text-dark"
                                                href="{{ route('archive-incoming-letter.show', $item->id) }}">
                                                <h6 class="card-title">{{ $item->letter_number }}</h6>
                                            </a>
                                            <span class="small text-muted"> {!! Str::limit(strip_tags($item->subject), 40) !!}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('archive-incoming-letter.edit', $item->id) }}"
                                                class="btn btn-light btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('archive-incoming-letter.destroy', $item->id) }}"
                                                method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!-- End Table with hoverable rows -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
