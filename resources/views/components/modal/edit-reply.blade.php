<div class="modal fade" id="largeModals" data-bs-backdrop="false" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Approve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="my-alert"></div>
                <form id="form_approve-edit" action="{{ route('incoming-letter.approveUpdates', $reply->id) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="id_letter" id="id_letter" value="{{ $incomingLetter->id }}">
                    <div class="create-letter">
                        <div class="form-group mb-3">
                            <label class="form-label" for="greeting-edit">Greeting</label>
                            <div id="greeting-edit" style="height: 100px">
                                <p>Dengan hormat,</p>
                            </div>
                            <textarea rows="3" class="mb-3 d-none" name="greetings" id="quill-editor-area-greeting-edit">{{ $reply->greeting }}</textarea>
                            @error('greetings')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="closing">Closing</label>
                            <div id="closing-edit" style="height: 100px">
                                <p>Demikian surat ini kami sampaikan,</p>
                            </div>
                            <textarea rows="3" class="mb-3 d-none" name="closings" id="quill-editor-area-closing-edit">{{ $reply->closing }}</textarea>
                            @error('closings')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="closing">Tertanda</label>
                            <select class="form-control" name="sincerelys_id" id="sincerely_id">
                                <option selected disabled>Pilih Tertanda</option>
                                @foreach ($sincerelys as $item)
                                    <option{{ $item->id == $reply->sincerely_id ? ' selected' : '' }}
                                        value="{{ $item->id }}">{{ $item->name . ' - ' . $item->role }}
                                        {{ $item->is_koordinator == 1 ? ' | Koordinator' : '' }}</option>
                                @endforeach
                            </select>
                            @error('closing')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($incomingLetter->sender_role == 'student')
                            <div class="form-group mb-3">
                                <label class="form-label" for="student_id">NIM Mahasiswa :
                                    {{ $incomingLetter->student_id }}</label>
                                {{-- <input type="text" class="form-control" name="student_id" id="student_id" readonly
                                    value="{{ $incomingLetter->student_id }}">
                                @error('student_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror --}}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="student_name">Nama Mahasiswa :
                                    {{ $incomingLetter->student_name }}</label>
                                {{-- <input type="text" class="form-control" name="student_name" id="student_name"
                                    readonly value="{{ $incomingLetter->student_name }}"> --}}
                                {{-- @error('student_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        @else
                            <div class="form-group mb-3">
                                <label class="form-label" for="student_id">NIP Dosen :
                                    {{ $incomingLetter->lecturer_id }}</label>

                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="student_name">Nama Dosen :
                                    {{ $incomingLetter->lecturer_name }}</label>
                            </div>
                        @endif

                    </div>
                    <div class="upload-file">
                        <div class="form-group mb-3">
                            <label class="form-label" for="attachment">File : (doc,docx,pdf)</label>
                            <input type="file" class="form-control" name="attachment" id="attachment">
                            @error('attachment')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let create = document.querySelector('.create-letter');
        let source = document.getElementById('source');
        let upload = document.querySelector('.upload-file');
        let form_approveEdit = document.getElementById('form_approve-edit');
        upload.style.display = 'none';
        let greetingEdit = new Quill('#greeting-edit', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['link'],
                    //indent
                    ['blockquote', 'code-block'],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }]
                ]
            }
        });

        let closingEdit = new Quill('#closing-edit', {
            theme: 'snow'
        });
        let greeEdit = document.getElementById('quill-editor-area-greeting-edit');
        let closEdit = document.getElementById('quill-editor-area-closing-edit');


        greetingEdit.root.innerHTML = greeEdit.value;
        closingEdit.root.innerHTML = closEdit.value;

        greetingEdit.on('text-change', function(delta, oldDelta, source) {
            greeEdit.value = greetingEdit.root.innerHTML;
        });

        closingEdit.on('text-change', function(delta, oldDelta, source) {
            closEdit.value = closingEdit.root.innerHTML;
        });

        greeEdit.addEventListener('input', function() {
            greetingEdit.root.innerHTML = greeEdit.value
        });

        closEdit.addEventListener('input', function() {
            closingEdit.root.innerHTML = closEdit.value
        });
        const attachmentInput = document.getElementById('attachment');
        attachmentInput.addEventListener('change', function() {
            console.log('oke change');

            if (attachmentInput.files.length > 0) {
                const fileName = this.files[0].name;
                const fileExtension = fileName.split('.').pop().toLowerCase();
                const allowedExtensions = ['doc', 'docx', 'pdf'];
                if (!allowedExtensions.includes(fileExtension)) {
                    alert('File harus berekstensi .doc, .docx, atau .pdf');
                }
            }
        });
        if (form_approveEdit) {
            form_approveEdit.addEventListener('submit', function(e) {
                e.preventDefault();
                const formDatas = new FormData(form_approveEdit);
                console.log(attachmentInput.files[0]);

                if (attachmentInput.files.length > 0) {
                    formDatas.set('attachment', attachmentInput.files[
                        0]); // Tambahkan file ke FormData
                }
                // console.log([...formData.entries()]); // O
                console.log(form_approveEdit.action);
                alert(form_approveEdit.method);
                const xhrs = new XMLHttpRequest();
                xhrs.open(form_approveEdit.method, form_approveEdit.action);
                xhrs.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'));
                xhrs.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhrs.send(formDatas);

                xhrs.onreadystatechange = function() {
                    if (xhrs.readyState == 4) {
                        console.log('ini status', xhrs.status);

                        if (xhrs.status == 200 && xhrs.status < 300) {
                            window.location.reload();
                        } else if (xhrs.status == 201) {
                            window.location.reload();

                        } else if (xhrs.status == 202) {
                            window.location.reload();
                        } else if (xhrs.status == 422) {
                            const responses = JSON.parse(xhrs.responseText);
                            handleErrors(responses.error);
                            let modals = document.getElementById('largeModals');
                            modals.style.display = 'block';

                        } else if (xhrs.status == 413) {
                            let alerts = document.querySelector('.my-alert');
                            alerts.innerHTML = `<div class="alert alert-danger" role="alert">File size
                            melebihi 5MB</div>`;

                        } else if (xhrs.status == 500) {
                            let alerts = document.querySelector('.my-alert');
                            alert.innerHTML = `<div class="alert alert-danger" role="alert">Something
                            went wrong</div>`;

                        }
                    }
                };

                // window.location.reload();
            });
        }

        function handleErrors(errors) {
            // Menghapus pesan error sebelumnya
            const errorMessagess = document.querySelectorAll('.text-danger');
            errorMessagess.forEach(function(msg) {
                msg.remove();
            });
            console.log(errors);


            // Menampilkan pesan error untuk setiap field
            for (const key in errors) {
                if (errors.hasOwnProperty(key)) {
                    const errorMessage = errors[key][0]; // Ambil pesan error pertama

                    // Menemukan elemen input atau select berdasarkan nama
                    let element = document.querySelector(`[name="${key}"]`);
                    console.log(element);

                    if (element) {
                        const errorElement = document.createElement('span');
                        errorElement.classList.add('text-danger');
                        errorElement.textContent = errorMessage;
                        element.parentNode.appendChild(errorElement);
                    }
                }
            }
        }
    });
</script>

{{-- <div class="form-group mb-3">
    <label class="form-label" for="email">Source</label>
    <select name="source" id="source" class="form-control" required>
        <option value="" selected disabled>Select Source</option>
        <option value="create">Buat Sendiri</option>
        <option value="from_computer">Upload Dari Komputer</option>
    </select>
    @error('source')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div> --}}
