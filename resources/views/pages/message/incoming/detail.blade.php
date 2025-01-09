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
                        <a class="btn btn-secondary btn-sm" href="{{ route('incoming-letter.index') }}"><i
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
                        <!-- Head Detail -->
                        <div class="row justify-content-between">
                            <div class="col-md-9">
                                <p class="text-sm ms-5">From:&nbsp;
                                    {{ $incomingLetter->sender_name }} <span
                                        class="small">{{ '<username: ' . $incomingLetter->sender_username . '>' }}</span>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-sm ms-5">
                                    {{ \Carbon\Carbon::parse($incomingLetter->date)->isoFormat('ddd,MMM DD,Y') }} <span
                                        class="small">{{ '(' . \Carbon\Carbon::parse($incomingLetter->date)->diffForHumans() . ')' }}</span>
                                </p>
                            </div>
                        </div>
                        <!-- End Head Detail -->

                        <hr>
                        <!-- Body Detail -->
                        <div class="row justify-content-center">
                            <div class="col-md-10">

                                <div class="card p-2">
                                    <div class="card-header">
                                        <div class="float-start">
                                            <div class="badge bg-info">{{ $incomingLetter->letter_type }}</div>
                                            |{{ $incomingLetter->letter_number }}
                                            <h6 class="card-title">{{ $incomingLetter->subject }}</h6>
                                        </div>
                                        <div class="float-end">
                                            @if ($incomingLetter->status == 'unread' || $incomingLetter->status == 'send')
                                                <h4> <i class="bi bi-send text-primary"></i></h4>
                                            @elseif ($incomingLetter->status == 'read')
                                                <h4> <i class="bi bi-send-check text-primary"></i></h4>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <p class="small text-sm">{!! $incomingLetter->body !!}</p>
                                        <hr>
                                        @if ($incomingLetter->attachment === null)
                                            <p class="small">Attachment:&nbsp;<a class="ms-2 btn btn-secondary btn-sm"
                                                    href="{{ asset('storage/' . $incomingLetter->attachment) }}"><i
                                                        class="bi bi-download"></i> Download</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Body Detail -->
                        <hr>

                        <!-- Action Button -->
                        @if (\App\Models\Reply::where('id_letter', $incomingLetter->id)->doesntExist())
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-end">
                                    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#largeModal">
                                        Approve
                                    </button>
                                    <div class="btn btn-light btn-sm">Reject</div>
                                </div>
                            </div>
                        @endif

                        <!-- End Action Button -->
                        <!-- Reply Detail -->
                        @if (\App\Models\Reply::where('id_letter', $incomingLetter->id)->exists())
                            @include('components.reply.reply-detail', [
                                'incomingLetter' => $incomingLetter,
                            ])
                        @endif

                        <!-- End Reply Detail -->
                    </div>
                </div>
            </div>
        </div>

    </section>
    @include('components.modal.approve', ['incomingLetter' => $incomingLetter])
@endsection
