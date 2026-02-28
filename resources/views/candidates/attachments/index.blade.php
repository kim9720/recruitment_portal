@extends('layouts.app')
@section('title', 'Attachments')

<link rel="stylesheet" href="{{ asset('pagestyles/attachments.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Document Attachments</h1>
                <p class="page-subtitle">Manage and upload your documents</p>
            </div>
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-upload"></i> Upload Document
            </button>
        </div>



        <!-- Documents Table Container -->
        <div class="documents-table-container">
            <div class="documents-table-header">
                <h3 class="documents-table-title">All Documents</h3>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="documents-data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> </th>
                            <th><i class="fas fa-file"></i> Document Type</th>
                            {{-- <th><i class="fas fa-paperclip"></i> File Name</th>
                        <th><i class="fas fa-hdd"></i> File Size</th> --}}
                            <th><i class="fas fa-calendar"></i> Upload Date</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $key => $document)
                            <tr>
                                <td>
                                    <span class="document-id">#DOC{{ ++$key }}</span>
                                </td>
                                <td>
                                    <div class="document-type-info">
                                        <div
                                            class="type-icon {{ strtolower(str_replace(' ', '-', $document->document_name)) }}">
                                            @if ($document->document_name == 'CV')
                                                <i class="fas fa-file-pdf"></i>
                                            @elseif($document->document_name == 'Birth Certificate' || $document->document_name == 'Marriage Certificate')
                                                <i class="fas fa-certificate"></i>
                                            @elseif($document->document_name == 'National Identification')
                                                <i class="fas fa-id-card"></i>
                                            @else
                                                <i class="fas fa-file-alt"></i>
                                            @endif
                                        </div>
                                        <div class="type-details">
                                            <div class="type-name">{{ $document->document_name }}</div>
                                            <div class="type-category">
                                                {{ $document->document_name == 'Other' ? 'Custom Document' : 'Standard Document' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                {{-- <td>
                            <div class="file-badge">
                                <i class="fas fa-file"></i>
                                {{ basename($document->document_file) }}
                            </div>
                        </td>
                        <td>
                            <span class="size-badge">
                                @if (file_exists(public_path($document->document_file)))
                                    {{ number_format(filesize(public_path($document->document_file)) / 1024, 2) }} KB
                                @else
                                    N/A
                                @endif
                            </span>
                        </td> --}}
                                <td>
                                    <div class="date-badge">
                                        <i class="fas fa-clock"></i>
                                        {{ $document->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if ($document->document_url)
                                            <a href="{{ $document->document_url }}" target="_blank"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif

                                        <a href="{{ asset($document->document_url) }}" download
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button class="btn btn-primary btn-sm"
                                            onclick="openEditModal({{ $document->id }}, '{{ addslashes($document->document_name) }}', '{{ addslashes($document->document_file) }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="deleteDocument({{ $document->id }}, '{{ addslashes($document->document_name) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="no-data">
                                    <div class="no-data-message">
                                        <i class="fas fa-folder-open fa-4x"></i>
                                        <p>No documents uploaded yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing 6 of 9 documents
                </div>
                {{-- {{ $documents->links() }} --}}
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="documentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Upload New Document</h2>
                <button class="modal-close" id="closeButton" type="button">&times;</button>
            </div>
            <form action="{{ route('candidate.attachments.store') }}" method="POST" enctype="multipart/form-data"
                id="documentForm">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="document_id" id="documentId">

                <div class="modal-body">
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Document Type *</label>
                        <select name="document_type" id="documentType" class="form-control" required
                            onchange="toggleOtherField()">
                            <option value="">Select Document Type</option>
                            <option value="CV">CV</option>
                            <option value="Birth Certificate">Birth Certificate</option>
                            <option value="Marriage Certificate">Marriage Certificate</option>
                            <option value="National Identification">National Identification</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group" id="otherNameGroup" style="display: none;">
                        <label><i class="fas fa-file-alt"></i> Document Name *</label>
                        <input type="text" name="other_document_name" id="otherDocumentName" class="form-control"
                            placeholder="Enter document name">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-upload"></i> Upload File *</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="document_file" id="documentFile" class="file-input"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required onchange="updateFileName()">
                            <label for="documentFile" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span id="fileNameDisplay">Choose a file or drag it here</span>
                            </label>
                            <div class="file-info">
                                <small>Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="currentFileGroup" style="display: none;">
                        <label><i class="fas fa-file"></i> Current File</label>
                        <div class="current-file-display">
                            <i class="fas fa-paperclip"></i>
                            <span id="currentFileName"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="cancelButton">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Document
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            resetModal();
            document.getElementById('modalTitle').textContent = 'Upload New Document';
            document.getElementById('documentForm').action = "{{ route('candidate.attachments.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('documentId').value = '';
            document.getElementById('otherNameGroup').style.display = 'none';
            document.getElementById('currentFileGroup').style.display = 'none';
            document.getElementById('documentFile').required = true;
            document.getElementById('fileNameDisplay').textContent = 'Choose a file or drag it here';
            showModal();
            initDragAndDrop();
        }

        function openEditModal(id, documentName, documentFile) {
            resetModal();
            document.getElementById('modalTitle').textContent = 'Edit Document';
            document.getElementById('documentForm').action = `{{ url('candidate/attachments/update') }}/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('documentId').value = id;

            // Set document type
            document.getElementById('documentType').value = documentName;
            toggleOtherField();

            // If it's "Other" type, set the custom name
            if (documentName === 'Other' || !['CV', 'Birth Certificate', 'Marriage Certificate', 'National Identification']
                .includes(documentName)) {
                document.getElementById('documentType').value = 'Other';
                document.getElementById('otherDocumentName').value = documentName;
                document.getElementById('otherNameGroup').style.display = 'block';
            }

            // Show current file
            document.getElementById('currentFileName').textContent = documentFile.split('/').pop();
            document.getElementById('currentFileGroup').style.display = 'block';
            document.getElementById('documentFile').required = false;

            showModal();
            initDragAndDrop();
        }

        function showModal() {
            document.getElementById('documentModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                document.querySelector('.modal-content').style.transform = 'scale(1)';
            }, 10);
        }

        function resetModal() {
            document.getElementById('documentForm').reset();
            document.querySelector('.modal-content').style.transform = 'scale(0.7)';
        }

        function closeModal() {
            const modal = document.getElementById('documentModal');
            const modalContent = document.querySelector('.modal-content');
            modalContent.style.transform = 'scale(0.7)';
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function toggleOtherField() {
            const documentType = document.getElementById('documentType').value;
            const otherNameGroup = document.getElementById('otherNameGroup');
            const otherDocumentName = document.getElementById('otherDocumentName');

            if (documentType === 'Other') {
                otherNameGroup.style.display = 'block';
                otherDocumentName.required = true;
            } else {
                otherNameGroup.style.display = 'none';
                otherDocumentName.required = false;
                otherDocumentName.value = '';
            }
        }

        function updateFileName() {
            const fileInput = document.getElementById('documentFile');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                const fileSize = (fileInput.files[0].size / 1024).toFixed(2);
                fileNameDisplay.innerHTML = `<strong>${fileName}</strong> (${fileSize} KB)`;
            } else {
                fileNameDisplay.textContent = 'Choose a file or drag it here';
            }
        }

        function deleteDocument(id, documentName) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${documentName}. This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('candidate/attachments/destroy') }}/${id}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Event listeners for close buttons
        document.addEventListener('DOMContentLoaded', function() {
            const closeButton = document.getElementById('closeButton');
            const cancelButton = document.getElementById('cancelButton');

            if (closeButton) {
                closeButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeModal();
                });
            }

            if (cancelButton) {
                cancelButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeModal();
                });
            }
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('documentModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Drag and drop functionality - initialized when modal opens
        function initDragAndDrop() {
            const fileInput = document.getElementById('documentFile');
            const fileLabel = document.querySelector('.file-label');

            if (fileLabel) {
                // Remove existing listeners to avoid duplicates
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    fileLabel.removeEventListener(eventName, preventDefaults);
                    fileLabel.removeEventListener(eventName, handleDragEvents);
                });

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    fileLabel.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                function handleDragEvents(e) {
                    if (e.type === 'dragenter' || e.type === 'dragover') {
                        fileLabel.classList.add('drag-active');
                    } else {
                        fileLabel.classList.remove('drag-active');
                    }
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    fileLabel.addEventListener(eventName, handleDragEvents, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    fileLabel.addEventListener(eventName, handleDragEvents, false);
                });

                fileLabel.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    fileInput.files = files;
                    updateFileName();
                }, false);
            }
        }

        // Show success/error messages
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#262261'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#262261'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                title: 'Validation Error!',
                html: `
            <ul style="text-align: left;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `,
                icon: 'error',
                confirmButtonColor: '#262261'
            });
        @endif
    </script>
@endsection
