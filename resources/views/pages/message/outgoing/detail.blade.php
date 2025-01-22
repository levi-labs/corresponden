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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-secondary btn-sm" href="{{ route('outgoing-letter.index') }}"><i
                                class="bi bi-arrow-90deg-left"></i></a>
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
                        <div class="row justify-content-between">
                            <div class="col-md-9">
                                <p class="text-sm ms-5">To:&nbsp;
                                    {{ $outgoingLetter->receiver_name }} <span
                                        class="small">{{ '<username: ' . $outgoingLetter->receiver_username . '>' }}</span>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-sm ms-5">
                                    {{ \Carbon\Carbon::parse($outgoingLetter->date)->isoFormat('dddd,MMM DD,Y') }} <span
                                        class="small">{{ '(' . \Carbon\Carbon::parse($outgoingLetter->date)->diffForHumans() . ')' }}</span>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row justify-content-center">
                            <div class="col-md-10">

                                <div class="card p-2">
                                    <div class="card-header">
                                        <div class="float-start">
                                            <div class="badge bg-info">{{ $outgoingLetter->letter_type }}</div>
                                            |{{ $outgoingLetter->letter_number }}
                                            <h6 class="card-title">{{ $outgoingLetter->subject }}</h6>
                                        </div>
                                        <div class="float-end">
                                            @if ($outgoingLetter->status == 'unread' || $outgoingLetter->status == 'send')
                                                <h4> <i class="bi bi-send text-primary"></i></h4>
                                            @elseif ($outgoingLetter->status == 'read')
                                                <h4> <i class="bi bi-send-check text-primary"></i></h4>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <p class="small text-sm">{!! $outgoingLetter->body !!}</p>
                                        <hr>
                                        @if ($outgoingLetter->attachment !== null)
                                            <p class="small">Attachment:&nbsp;<a class="ms-2 btn btn-secondary btn-sm"
                                                    href="{{ asset('storage/' . $outgoingLetter->attachment) }}"><i
                                                        class="bi bi-download"></i> Download</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Table with hoverable rows -->

                        <!-- End Table with hoverable rows -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
