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
                        <a class="btn btn-secondary btn-sm" href="{{ route('archive-incoming-letter.index') }}"><i
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
                                <p class="text-sm ms-5">Dari:&nbsp;
                                    {{ strtoupper($data->sender) }}
                                </p>
                                <p class="text-sm ms-5">Kepada:&nbsp; {{ strtoupper($data->receiver) }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-sm ms-5">
                                    {{ \Carbon\Carbon::parse($data->date)->isoFormat('ddd,MMM DD,Y') }}
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
                                            <div class="badge bg-info">{{ $data->letter_type }}</div>
                                            |{{ $data->letter_number }}
                                            <h6 class="card-title">{{ $data->subject }}</h6>
                                        </div>
                                        <div class="float-end">
                                            {{-- @if ($incomingLetter->status == 'unread' || $incomingLetter->status == 'send')
                                                <h4> <i class="bi bi-send text-primary"></i></h4>
                                            @elseif ($incomingLetter->status == 'read')
                                                <h4> <i class="bi bi-send-check text-primary"></i></h4>
                                            @endif --}}
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <p class="small text-sm">{!! $data->body !!}</p>
                                        <hr>
                                        @if ($data->attachment != null)
                                            <p class="small">Attachment:&nbsp;<a class="ms-2 btn btn-secondary btn-sm"
                                                    href="{{ asset('storage/' . $data->attachment) }}"><i
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


                        <!-- End Action Button -->
                        <!-- Reply Detail -->

                        <!-- End Reply Detail -->
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
