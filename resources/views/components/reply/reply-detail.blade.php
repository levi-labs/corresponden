<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="card p-2">
            <div class="card-header">
                <div class="float-start">
                    <div class="badge bg-info">{{ $incomingLetter->letter_type }} || Replied
                    </div>
                    |{{ $incomingLetter->letter_number }}
                    <h6 class="card-title">Replied</h6>
                </div>
                <div class="float-end">
                    <h4> <i class="bi bi-reply-fill text-primary"></i></h4>
                </div>

            </div>
            <div class="card-body text-start">
                @php
                    if (auth('web')->user()->role == 'admin' || auth('web')->user()->role == 'staff') {
                        $reply = \App\Models\Reply::where('id_letter', $incomingLetter->id)->first();
                    } elseif (auth('web')->user()->role == 'student') {
                        $reply = \App\Models\Reply::where('inbox_id', $incomingLetter->id)->first();
                    } elseif (auth('web')->user()->role == 'lecturer') {
                        $reply = \App\Models\Reply::where('inbox_id', $incomingLetter->id)->first();
                    }

                    if ($reply->file !== null) {
                        if (auth('web')->user()->role == 'admin' || auth('web')->user()->role == 'staff') {
                            $file = \App\Models\Reply::where('id_letter', $incomingLetter->id)
                                ->where('file', '!=', '')
                                ->first();
                        } elseif (auth('web')->user()->role == 'student') {
                            $file = \App\Models\Reply::where('inbox_id', $incomingLetter->id)
                                ->where('file', '!=', '')
                                ->first();
                        } elseif (auth('web')->user()->role == 'lecturer') {
                            $file = \App\Models\Reply::where('inbox_id', $incomingLetter->id)
                                ->where('file', '!=', '')
                                ->first();
                        }

                        $extension = pathinfo($file->file, PATHINFO_EXTENSION);
                        $extensionIs;
                        if ($extension == 'doc' || $extension == 'docx') {
                            $extensionIs = 'doc';
                        } else {
                            $extensionIs = 'pdf';
                        }
                    }

                    //get extension file

                @endphp
                @if (
                    \App\Models\Reply::where('id_letter', $incomingLetter->id)->where('file', '!=', '')->first() ||
                        \App\Models\Reply::where('inbox_id', $incomingLetter->id)->where('file', '!=', '')->first())
                    <a class="d-flex flex-column align-items-center justify-content-start"
                        href="{{ asset('storage/' . $file->file) }}" download>
                        @if ($extensionIs == 'doc')
                            <img width="10%" src="{{ asset('assets/word-svgrepo-com.svg') }}" alt="">
                        @elseif ($extensionIs == 'pdf')
                            <img width="10%" src="{{ asset('assets/pdf-svgrepo-com.svg') }}" alt="">
                        @endif

                        <i class="bi bi-download"></i> Download
                    </a>
                    <h6 class="fw-bold text-sm">Silahkah download lampiran berikut ini: </h6>
                @endif
                @if ($reply->file === null)
                    {{-- <p class="small text-sm">{!! $incomingLetter->greeting !!}</p>
                    <br>
                    <p>Nama : </p> --}}
                    <p class="small">Print | Download:&nbsp;<a target="_blank" class="ms-2 btn btn-secondary btn-sm"
                            href="{{ route('reply-letter.preview', $reply->id) }}"><i class="bi bi-download"></i>
                            Preview</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@if (auth('web')->user()->role == 'admin' || auth('web')->user()->role == 'staff')
    <div class="row justify-content-center">
        <div class="col-md-10 text-end">
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                data-bs-target="#largeModals">Edit</button>
            <a href="{{ route('reply-letter.destroy', $reply->id) }}" class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure?')">Delete</a>

        </div>
    </div>
@endif

@include('components.modal.edit-reply', ['reply' => $reply])
