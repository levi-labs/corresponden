<div class="modal fade" id="largeModal" data-bs-backdrop="false" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Approve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="my-alert"></div>
                <form id="form_approve" action="{{ route('incoming-letter.approve') }}" enctype="multipart/form-data"
                    method="POST">
                    @csrf
                    <input type="hidden" name="id_letter" id="id_letter" value="{{ $incomingLetter->id }}">

                    <div class="form-group mb-3">
                        <label class="form-label" for="email">Source</label>
                        <select name="source" id="source" class="form-control" required>
                            <option value="" selected disabled>Select Source</option>
                            <option value="create">create</option>
                            <option value="from_computer">from computer</option>
                        </select>
                        @error('source')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="create-letter">
                        <div class="form-group mb-3">
                            <label class="form-label" for="greeting">Greeting</label>
                            <div id="greeting" style="height: 100px">
                                <p>Dengan hormat,</p>
                            </div>
                            <textarea rows="3" class="mb-3 d-none" name="greeting" id="quill-editor-area-greeting"></textarea>
                            @error('greeting')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="closing">Closing</label>
                            <div id="closing" style="height: 100px">
                                <p>Demikian surat ini kami sampaikan,</p>
                            </div>
                            <textarea rows="3" class="mb-3 d-none" name="closing" id="quill-editor-area-closing"></textarea>
                            @error('closing')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="student_id">Student ID</label>
                            <input type="text" class="form-control" name="student_id" id="student_id" readonly
                                value="{{ $incomingLetter->student_id }}">
                            @error('student_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="student_name">Student Name</label>
                            <input type="text" class="form-control" name="student_name" id="student_name" readonly
                                value="{{ $incomingLetter->student_name }}">
                            @error('student_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
        let form_approve = document.getElementById('form_approve');

        create.style.display = 'none';
        upload.style.display = 'none';

        source.addEventListener('change', function() {
            if (source.value == 'create') {

                create.style.display = 'block';
                upload.style.display = 'none';

            } else {
                create.style.display = 'none';
                upload.style.display = 'block';
            }
        })

        let greeting = new Quill('#greeting', {
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

        let closing = new Quill('#closing', {
            theme: 'snow'
        });
        let gree = document.getElementById('quill-editor-area-greeting');
        let clos = document.getElementById('quill-editor-area-closing');

        greeting.on('text-change', function(delta, oldDelta, source) {
            gree.value = greeting.root.innerHTML;
        });

        closing.on('text-change', function(delta, oldDelta, source) {
            clos.value = closing.root.innerHTML;
        });

        gree.addEventListener('input', function() {
            greeting.root.innerHTML = gree.value
        });

        clos.addEventListener('input', function() {
            closing.root.innerHTML = clos.value
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
        if (form_approve) {
            form_approve.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form_approve);
                console.log(attachmentInput.files[0]);

                if (attachmentInput.files.length > 0) {
                    formData.set('attachment', attachmentInput.files[
                        0]); // Tambahkan file ke FormData
                }
                // console.log([...formData.entries()]); // O
                const xhr = new XMLHttpRequest();
                xhr.open('POST', form_approve.action);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'));
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.send(formData);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        console.log('ini status', xhr.status);

                        if (xhr.status == 200 && xhr.status < 300) {
                            window.location.reload();
                        } else if (xhr.status == 201) {
                            window.location.reload();

                        } else if (xhr.status == 202) {
                            window.location.reload();
                        } else if (xhr.status == 422) {
                            const response = JSON.parse(xhr.responseText);
                            handleErrors(response.error);
                            let modal = document.getElementById('largeModal');
                            modal.style.display = 'block';

                        } else if (xhr.status == 413) {
                            let alert = document.querySelector('.my-alert');
                            alert.innerHTML = `<div class="alert alert-danger" role="alert">File size
                            melebihi 5MB</div>`;

                        } else if (xhr.status == 500) {
                            let alert = document.querySelector('.my-alert');
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
            const errorMessages = document.querySelectorAll('.text-danger');
            errorMessages.forEach(function(msg) {
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
