@extends('layouts.app')
@section('title', 'Academic Details')

<link rel="stylesheet" href="{{ asset('pagestyles/academic_details.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="content-area">
        <div class="content-section">
            <div class="page-header">
                <h1 class="page-title">Academic Details</h1>
                <p class="page-subtitle">Manage educational qualifications and certifications</p>
            </div>

            <div class="candidate-table-container">
                <!-- Header Section -->
                <div class="candidate-table-header">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                        <h2 class="candidate-table-title">Education History</h2>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary btn-sm" onclick="openCreateModal()">
                                <i class="fas fa-plus"></i> Add Education
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Education Table -->
                <div class="table-responsive">
                    <table class="candidate-data-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> #</th>
                                <th><i class="fas fa-graduation-cap"></i> Level</th>
                                <th><i class="fas fa-university"></i> Institution</th>
                                <th><i class="fas fa-book"></i> Field of Study</th>
                                <th><i class="fas fa-calendar"></i> Start Date</th>
                                <th><i class="fas fa-calendar-check"></i> End Date</th>
                                <th><i class="fas fa-award"></i> Grade/GPA</th>
                                <th><i class="fas fa-cog"></i> Actions</th>
                            </tr>
                        </thead>
                        {{-- {{ dd($academicDetails) }} --}}
                        <tbody>
                            @forelse($academicDetails as $index => $education)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>
                                        <span class="education-badge">
                                            {{ $education->educationlevel }}
                                        </span>
                                    </td>
                                    <td>{{ $education->institute }}</td>
                                    <td>{{ $education->specialization }}</td>
                                    <td>{{ date('M Y', strtotime($education->educationstartdate)) }}</td>
                                    <td>
                                        @if ($education->is_current)
                                            <span class="status-badge status-active">Present</span>
                                        @else
                                            {{ date('M Y', strtotime($education->educationenddate)) }}
                                        @endif
                                    </td>
                                    <td>{{ $education->score ?? 'N/A' }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="openEditModal({{ $education->rec_id }}, '{{ addslashes($education->educationlevel) }}', '{{ addslashes($education->institute) }}', '{{ addslashes($education->specialization) }}', '{{ $education->educationstartdate }}', '{{ $education->educationenddate }}', '{{ addslashes($education->score ?? '') }}', {{ $education->is_current ? 'true' : 'false' }}, '{{ $education->certificate_path ? addslashes(asset('storage/' . $education->certificate_path)) : '' }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm" style="background: var(--danger-color); color: white;" onclick="confirmDelete({{ $education->rec_id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="no-data">
                                        <div class="no-data-message">
                                            <i class="fas fa-graduation-cap" style="font-size: 60px;"></i>
                                            <p>No academic records found. Click "Add Education" to get started.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-plus-circle"></i> Add Education</h3>
                <button type="button" class="modal-close" onclick="closeCreateModal()">&times;</button>
            </div>

            <form action="{{ route('candidate.academic_details.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">

                        <div class="form-group">
                            <label for="create_level" class="form-label">
                                <i class="fas fa-graduation-cap"></i> Education Level <span class="required">*</span>
                            </label>
                            <select class="form-input" id="create_level" name="educationlevel" required>
                                <option value="">Select Level</option>
                                <option value="High School">High School</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Bachelor Degree">Bachelor's Degree</option>
                                <option value="Master Degree">Master's Degree</option>
                                <option value="Doctorate">Doctorate</option>
                                <option value="Certificate">Certificate</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="create_institution" class="form-label">
                                <i class="fas fa-university"></i> Institution <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input" id="create_institution" name="institute" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="create_field_of_study" class="form-label">
                                <i class="fas fa-book"></i> Field of Study <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input" id="create_field_of_study" name="specialization"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="create_start_date" class="form-label">
                                <i class="fas fa-calendar"></i> Start Date <span class="required">*</span>
                            </label>
                            <input type="date" class="form-input" id="create_start_date" name="educationstartdate"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="create_end_date" class="form-label">
                                <i class="fas fa-calendar-check"></i> End Date
                            </label>
                            <input type="date" class="form-input" id="create_end_date" name="educationenddate">
                        </div>

                        <div class="form-group">
                            <label for="create_grade" class="form-label">
                                <i class="fas fa-award"></i> Grade/GPA
                            </label>
                            <input type="number" class="form-input" id="create_grade" name="score"
                                placeholder="e.g., 3.8 GPA">
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="create_is_current" name="is_current" value="1"
                                    onchange="toggleEndDate('create')">
                                <span>Currently studying here</span>
                            </label>
                        </div>

                        <div class="form-group full-width">
                            <label for="create_certificate" class="form-label">Upload Certificate</label>
                            <div class="file-upload-wrapper" id="createFileWrapper">
                                <input type="file" name="certificate_path" id="createCertificate" class="file-input"
                                    accept=".pdf" onchange="handleFileChange('create')">
                                <label for="createCertificate" class="file-label">
                                    <div class="file-label-content">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span id="createFileNameDisplay">Click to upload or drag and drop</span>
                                        <small>PDF file (Max size: 500 KB)</small>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>Preview (local file):</label>
                            <iframe id="createPreview" style="width:100%; height:200px; border:1px solid #ccc; display:none;"></iframe>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="closeCreateModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success" id="createSubmit">
                        <i class="fas fa-save"></i> Save Education
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Edit Education</h3>
                <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-grid">

                        <div class="form-group">
                            <label for="edit_level" class="form-label">
                                <i class="fas fa-graduation-cap"></i> Education Level <span class="required">*</span>
                            </label>
                            <select class="form-input" id="edit_level" name="educationlevel" required>
                                <option value="">Select Level</option>
                                <option value="High School">High School</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Bachelor Degree">Bachelor's Degree</option>
                                <option value="Master Degree">Master's Degree</option>
                                <option value="Doctorate">Doctorate</option>
                                <option value="Certificate">Certificate</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_institution" class="form-label">
                                <i class="fas fa-university"></i> Institution <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input" id="edit_institution" name="institute" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="edit_field_of_study" class="form-label">
                                <i class="fas fa-book"></i> Field of Study <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input" id="edit_field_of_study" name="specialization"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="edit_start_date" class="form-label">
                                <i class="fas fa-calendar"></i> Start Date <span class="required">*</span>
                            </label>
                            <input type="date" class="form-input" id="edit_start_date" name="educationstartdate" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_end_date" class="form-label">
                                <i class="fas fa-calendar-check"></i> End Date
                            </label>
                            <input type="date" class="form-input" id="edit_end_date" name="educationenddate">
                        </div>

                        <div class="form-group">
                            <label for="edit_grade" class="form-label">
                                <i class="fas fa-award"></i> Grade/GPA
                            </label>
                            <input type="number" class="form-input" id="edit_grade" name="score"
                                placeholder="e.g., 3.8 GPA">
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="edit_is_current" name="is_current" value="1"
                                    onchange="toggleEndDate('edit')">
                                <span>Currently studying here</span>
                            </label>
                        </div>

                        <div id="existingCertificateInfo"></div>

                        <div class="form-group full-width">
                            <label for="edit_certificate" class="form-label">Replace with new file (optional)</label>
                            <div class="file-upload-wrapper" id="editFileWrapper">
                                <input type="file" name="certificate_path" id="editCertificate" class="file-input"
                                    accept=".pdf" onchange="handleFileChange('edit')">
                                <label for="editCertificate" class="file-label">
                                    <div class="file-label-content">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span id="editFileNameDisplay">Click to upload or drag and drop a new file</span>
                                        <small>PDF file (Max size: 500 KB)</small>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>Preview new file (if selected):</label>
                            <iframe id="editPreview" style="width:100%; height:200px; border:1px solid #ccc; display:none;"></iframe>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="closeEditModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success" id="editSubmit">
                        <i class="fas fa-save"></i> Update Education
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .file-upload-wrapper {
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: border-color 0.3s ease;
            background: var(--light-gray);
        }

        .file-upload-wrapper.invalid {
            border-color: var(--danger);
            background: #ffebee;
        }

        .file-label-content small {
            color: var(--dark-gray);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: var(--dark-gray) !important;
        }
    </style>

    <script>
        const MAX_FILE_SIZE = 512 * 1024; // 500 KB in bytes (512 KB to be safe)

        let createFileValid = true; // Track validity for create modal
        let editFileValid = true; // Track validity for edit modal

        // Create Modal Functions
        function openCreateModal() {
            createFileValid = true; // Reset validity
            updateSubmitButton('create', true);
            document.getElementById('createModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            document.getElementById('createModal').querySelector('form').reset();
            handleFileChange('create'); // Reset file display and preview
            createFileValid = true;
            updateSubmitButton('create', true);
        }

        // Edit Modal Functions
        function openEditModal(id, educationlevel, institute, specialization, educationstartdate, educationenddate, score, isCurrent, existingCertificateUrl) {
            editFileValid = true; // Reset validity
            updateSubmitButton('edit', true);
            document.getElementById('editModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';

            // Set form action using rec_id
            document.getElementById('editForm').action = `{{ route('candidate.academic_details.update', ':id') }}`.replace(':id', id);

            // Populate form fields
            document.getElementById('edit_level').value = educationlevel;
            document.getElementById('edit_institution').value = institute;
            document.getElementById('edit_field_of_study').value = specialization;
            document.getElementById('edit_start_date').value = educationstartdate;
            document.getElementById('edit_end_date').value = educationenddate;
            document.getElementById('edit_grade').value = score;
            document.getElementById('edit_is_current').checked = isCurrent === true;

            // Handle existing certificate
            const existingInfo = document.getElementById('existingCertificateInfo');
            if (existingCertificateUrl && existingCertificateUrl !== '') {
                existingInfo.innerHTML = `
                    <div class="form-group full-width">
                        <label>Current Certificate:</label>
                        <iframe src="${existingCertificateUrl}" style="width:100%; height:200px; border:1px solid #ccc;"></iframe>
                        <p><a href="${existingCertificateUrl}" target="_blank" class="btn btn-sm btn-info">Download</a></p>
                    </div>
                `;
            } else {
                existingInfo.innerHTML = `
                    <div class="form-group full-width">
                        <label>Current Certificate:</label>
                        <p>No certificate uploaded.</p>
                    </div>
                `;
            }

            // Reset new file preview
            handleFileChange('edit');

            // Toggle end date field
            toggleEndDate('edit');
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            document.getElementById('existingCertificateInfo').innerHTML = '';
            handleFileChange('edit'); // Reset file display and preview
            editFileValid = true;
            updateSubmitButton('edit', true);
        }

        // Toggle end date based on "currently studying" checkbox
        function toggleEndDate(prefix) {
            const isCurrentChecked = document.getElementById(`${prefix}_is_current`).checked;
            const endDateField = document.getElementById(`${prefix}_end_date`);

            if (isCurrentChecked) {
                endDateField.disabled = true;
                endDateField.value = '';
                endDateField.parentElement.style.opacity = '0.5';
            } else {
                endDateField.disabled = false;
                endDateField.parentElement.style.opacity = '1';
            }
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const createModal = document.getElementById('createModal');
            const editModal = document.getElementById('editModal');

            if (event.target === createModal) {
                closeCreateModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
        };

        // Update submit button state
        function updateSubmitButton(prefix, enabled) {
            const submitId = prefix === 'create' ? 'createSubmit' : 'editSubmit';
            const submitBtn = document.getElementById(submitId);
            if (submitBtn) {
                submitBtn.disabled = !enabled;
            }
        }

        // File upload name update and preview
        function handleFileChange(prefix) {
            const fileInputId = prefix === 'create' ? 'createCertificate' : 'editCertificate';
            const wrapperId = prefix === 'create' ? 'createFileWrapper' : 'editFileWrapper';
            const fileInput = document.getElementById(fileInputId);
            const wrapper = document.getElementById(wrapperId);

            if (fileInput && wrapper) {
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const fileSizeInBytes = file.size;
                    const fileSizeInKB = (fileSizeInBytes / 1024).toFixed(2);

                    // Validate file size
                    if (fileSizeInBytes > MAX_FILE_SIZE) {
                        // Invalid: Show red styling, alert, clear file, disable submit
                        wrapper.classList.add('invalid');
                        Swal.fire({
                            title: 'File Too Large!',
                            text: `The selected file is ${fileSizeInKB} KB. Please choose a file smaller than 500 KB.`,
                            icon: 'warning',
                            confirmButtonColor: '#d33'
                        });
                        fileInput.value = ''; // Clear the file
                        updateFileName(prefix);
                        const iframeId = prefix === 'create' ? 'createPreview' : 'editPreview';
                        const iframe = document.getElementById(iframeId);
                        if (iframe) {
                            iframe.style.display = 'none';
                        }
                        if (prefix === 'create') {
                            createFileValid = false;
                        } else {
                            editFileValid = false;
                        }
                        updateSubmitButton(prefix, false);
                        return;
                    }

                    // Validate file type (PDF only)
                    if (file.type !== 'application/pdf') {
                        // Invalid: Show red styling, alert, clear file, disable submit
                        wrapper.classList.add('invalid');
                        Swal.fire({
                            title: 'Invalid File Type!',
                            text: 'Only PDF files are supported.',
                            icon: 'warning',
                            confirmButtonColor: '#d33'
                        });
                        fileInput.value = ''; // Clear the file
                        updateFileName(prefix);
                        const iframeId = prefix === 'create' ? 'createPreview' : 'editPreview';
                        const iframe = document.getElementById(iframeId);
                        if (iframe) {
                            iframe.style.display = 'none';
                        }
                        if (prefix === 'create') {
                            createFileValid = false;
                        } else {
                            editFileValid = false;
                        }
                        updateSubmitButton(prefix, false);
                        return;
                    }

                    // Valid file: Remove red class, update display, preview, enable submit
                    wrapper.classList.remove('invalid');
                    updateFileName(prefix);
                    const iframeId = prefix === 'create' ? 'createPreview' : 'editPreview';
                    previewFile(fileInputId, iframeId);
                    if (prefix === 'create') {
                        createFileValid = true;
                    } else {
                        editFileValid = true;
                    }
                    updateSubmitButton(prefix, true);
                } else {
                    // No file: For create (required), disable submit; for edit (optional), enable
                    wrapper.classList.remove('invalid');
                    updateFileName(prefix);
                    const iframeId = prefix === 'create' ? 'createPreview' : 'editPreview';
                    const iframe = document.getElementById(iframeId);
                    if (iframe) {
                        iframe.style.display = 'none';
                    }
                    if (prefix === 'create') {
                        createFileValid = false; // Required, so invalid without file
                        updateSubmitButton(prefix, false);
                    } else {
                        editFileValid = true; // Optional
                        updateSubmitButton(prefix, true);
                    }
                }
            }
        }

        function updateFileName(prefix) {
            const fileInputId = prefix === 'create' ? 'createCertificate' : 'editCertificate';
            const fileNameDisplayId = prefix === 'create' ? 'createFileNameDisplay' : 'editFileNameDisplay';
            const fileInput = document.getElementById(fileInputId);
            const fileNameDisplay = document.getElementById(fileNameDisplayId);

            if (fileInput && fileNameDisplay) {
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);

                    fileNameDisplay.innerHTML = `
                        <strong style="color: #28a745;">${fileName}</strong><br>
                        <small>Size: ${fileSize} MB</small>
                    `;
                } else {
                    const defaultText = prefix === 'create' ? 'Click to upload or drag and drop' : 'Click to upload or drag and drop a new file';
                    fileNameDisplay.innerHTML = defaultText;
                }
            }
        }

        function previewFile(inputId, iframeId) {
            const input = document.getElementById(inputId);
            const iframe = document.getElementById(iframeId);
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.type === 'application/pdf') {
                    const url = URL.createObjectURL(file);
                    iframe.src = url;
                    iframe.style.display = 'block';
                } else {
                    iframe.style.display = 'none';
                }
            } else {
                iframe.style.display = 'none';
            }
        }

        // SweetAlert for delete confirmation
        function confirmDelete(recId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This education record will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fas fa-trash"></i> Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit delete form dynamically
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('candidate.academic_details.destroy', ':id') }}`.replace(':id', recId);
                    form.style.display = 'none';

                    const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'POST';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
