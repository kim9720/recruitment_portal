@extends('layouts.app')
@section('title', isset($candidate) ? 'Edit Candidate' : 'Create Candidate')

<link rel="stylesheet" href="{{ asset('pagestyles/candidates.css') }}">

@section('content')
<div class="content-area">
    <div class="content-section">
        <div class="page-header">
            <h1 class="page-title">{{ isset($candidate) ? 'Edit' : 'Create' }} Candidate</h1>
            <p class="page-subtitle">{{ isset($candidate) ? 'Update candidate personal information' : 'Add new candidate to the system' }}</p>
        </div>

        <div class="candidate-table-container">
            <!-- Header Section -->
            <div class="candidate-table-header">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <h2 class="candidate-table-title">Personal Information Form</h2>
                    <div class="action-buttons">
                        <a href="{{ isset($candidate) ? route('candidate.personal_details.index') : route('candidate.personal_details.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div style="padding: 40px 30px;">
                <form action="{{ isset($candidate) ? route('candidate.personal_details.update', $candidate->id) : route('candidate.personal_details.store') }}" method="POST" enctype="multipart/form-data" id="candidateForm">
                    @csrf
                    @if(isset($candidate))
                        @method('PUT')
                    @endif

                    <!-- Hidden file input -->
                    <input type="file" id="candidate_photo" name="candidate_photo" accept="image/jpeg,image/jpg,image/png" style="display: none;">

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div style="background: #fee; border-left: 4px solid var(--danger-color); padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                            <h4 style="color: var(--danger-color); font-weight: 700; margin-bottom: 10px;">
                                <i class="fas fa-exclamation-triangle"></i> Please correct the following errors:
                            </h4>
                            <ul style="margin: 0; padding-left: 20px; color: var(--danger-color);">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Grid -->
                    <div class="form-grid">

                        <!-- Candidate Photo Preview Section -->
                        <div class="form-group full-width">
                            <label class="form-label">
                                <i class="fas fa-camera"></i> Passport Size Photo
                            </label>
                            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                                <div id="photoPreview" style="width: 150px; height: 150px; border: 2px dashed var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; overflow: hidden;">
                                        <img src="{{ $candidate->profile_photo }}" alt="Candidate Photo" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" onclick="openPhotoModal()" style="margin-bottom: 10px;">
                                        <i class="fas fa-camera"></i> Change Profile Photo
                                    </button>
                                    <p style="font-size: 12px; color: var(--text-muted); margin: 0;">
                                        <i class="fas fa-info-circle"></i> Max size: 200KB. Format: JPG, PNG
                                    </p>
                                </div>
                            </div>
                            @error('candidate_photo')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- First Name -->
                        <div class="form-group">
                            <label for="first_name" class="form-label">
                                <i class="fas fa-user"></i> First Name <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('first_name') is-invalid @enderror"
                                   id="first_name"
                                   name="first_name"
                                   value="{{ old('first_name', $candidate->first_name ?? '') }}"
                                   required>
                            @error('first_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div class="form-group">
                            <label for="middle_name" class="form-label">
                                <i class="fas fa-user"></i> Middle Name
                            </label>
                            <input type="text"
                                   class="form-input @error('middle_name') is-invalid @enderror"
                                   id="middle_name"
                                   name="middle_name"
                                   value="{{ old('middle_name', $candidate->middle_name ?? '') }}">
                            @error('middle_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="last_name" class="form-label">
                                <i class="fas fa-user"></i> Last Name <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('last_name') is-invalid @enderror"
                                   id="last_name"
                                   name="last_name"
                                   value="{{ old('last_name', $candidate->last_name ?? '') }}"
                                   required>
                            @error('last_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label for="gender" class="form-label">
                                <i class="fas fa-venus-mars"></i> Gender <span style="color: var(--danger-color);">*</span>
                            </label>
                            <select class="form-input @error('gender') is-invalid @enderror"
                                    id="gender"
                                    name="gender"
                                    required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $candidate->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $candidate->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $candidate->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="form-group">
                            <label for="date_of_birth" class="form-label">
                                <i class="fas fa-calendar"></i> Date of Birth <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="date"
                                   class="form-input @error('date_of_birth') is-invalid @enderror"
                                   id="date_of_birth"
                                   name="date_of_birth"
                                   value="{{ old('date_of_birth', $candidate->date_of_birth ?? '') }}">
                            @error('date_of_birth')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Marital Status -->
                        <div class="form-group">
                            <label for="marital_status" class="form-label">
                                <i class="fas fa-heart"></i> Marital Status <span style="color: var(--danger-color);">*</span>
                            </label>
                            <select class="form-input @error('marital_status') is-invalid @enderror"
                                    id="marital_status"
                                    name="marital_status">
                                <option value="">Select Marital Status</option>
                                <option value="Single" {{ old('marital_status', $candidate->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('marital_status', $candidate->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Divorced" {{ old('marital_status', $candidate->marital_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="Widowed" {{ old('marital_status', $candidate->marital_status ?? '') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                            @error('marital_status')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nationality -->
                        <div class="form-group">
                            <label for="nationality" class="form-label">
                                <i class="fas fa-flag"></i> Nationality <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('reg_country') is-invalid @enderror"
                                   id="nationality"
                                   name="reg_country"
                                   value="{{ old('reg_country', $candidate->reg_country ?? '') }}">
                            @error('reg_country')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email Address <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="email"
                                   class="form-input @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $candidate->email ?? '') }}"
                                   required>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group">
                            <label for="phone_number" class="form-label">
                                <i class="fas fa-phone"></i> Phone Number <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="tel"
                                   class="form-input @error('mobile') is-invalid @enderror"
                                   id="phone_number"
                                   name="mobile"
                                   value="{{ old('mobile', $candidate->mobile ?? '') }}">
                            @error('mobile')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Alternative Phone -->
                        <div class="form-group">
                            <label for="alternative_phone" class="form-label">
                                <i class="fas fa-mobile-alt"></i> Alternative Phone
                            </label>
                            <input type="tel"
                                   class="form-input @error('secondmobile') is-invalid @enderror"
                                   id="alternative_phone"
                                   name="secondmobile"
                                   value="{{ old('secondmobile', $candidate->secondmobile ?? '') }}">
                            @error('secondmobile')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="form-group full-width">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Address <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('address') is-invalid @enderror"
                                   id="address"
                                   name="address"
                                   value="{{ old('address', $candidate->address ?? '') }}">
                            @error('address')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="form-group">
                            <label for="city" class="form-label">
                                <i class="fas fa-city"></i> City <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('city') is-invalid @enderror"
                                   id="city"
                                   name="city"
                                   value="{{ old('city', $candidate->city ?? '') }}">
                            @error('city')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- ID Number -->
                        <div class="form-group">
                            <label for="id_number" class="form-label">
                                <i class="fas fa-id-card"></i> ID Number <span style="color: var(--danger-color);">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('id_number') is-invalid @enderror"
                                   id="id_number"
                                   name="id_number"
                                   value="{{ old('id_number', $candidate->id_number ?? '') }}">
                            @error('id_number')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Passport Number -->
                        <div class="form-group">
                            <label for="passport_number" class="form-label">
                                <i class="fas fa-passport"></i> Passport Number
                            </label>
                            <input type="text"
                                   class="form-input @error('passport_number') is-invalid @enderror"
                                   id="passport_number"
                                   name="passport_number"
                                   value="{{ old('passport_number', $candidate->passport_number ?? '') }}">
                            @error('passport_number')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <!-- Form Actions -->
                    <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid var(--border-color); display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-success" style="padding: 14px 40px; font-size: 15px;">
                            <i class="fas fa-save"></i> {{ isset($candidate) ? 'Update' : 'Create' }} Candidate
                        </button>
                        <a href="{{ isset($candidate) ? route('candidate.personal_details.index') : route('candidate.personal_details.index') }}"
                           class="btn btn-default"
                           style="padding: 14px 40px; font-size: 15px;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Modal -->
<div id="photoModal" class="photo-modal">
    <div class="photo-modal-content">
        <div class="photo-modal-header">
            <h3>Change your profile photo</h3>
        </div>
        <div class="photo-modal-body">
            <div class="upload-area">
                <i class="fas fa-camera" style="font-size: 64px; color: #555; margin-bottom: 15px;"></i>
                <p style="font-size: 16px; color: #333; margin-bottom: 5px;">Upload your photo here</p>
                <p style="font-size: 12px; color: #999; margin-bottom: 20px;">( max: 200kb )</p>
                <button type="button" class="btn-upload" onclick="document.getElementById('candidate_photo').click()">
                    Upload
                </button>
            </div>
            <div id="selectedFileName" style="margin-top: 15px; font-size: 14px; color: #666;"></div>
        </div>
        <div class="photo-modal-footer">
            <button type="button" class="btn-modal btn-apply" onclick="applyPhoto()">Apply</button>
            <button type="button" class="btn-modal btn-cancel" onclick="closePhotoModal()">Cancel</button>
        </div>
    </div>
</div>

<style>
/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    max-width: 1200px;
    margin: 0 auto;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 13px;
    font-weight: 700;
    color: var(--primary-color);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-label i {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--secondary-color), #d89060);
    color: white;
    border-radius: 5px;
    font-size: 11px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
    color: var(--text-dark);
    background: white;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(38, 34, 97, 0.1);
}

.form-input.is-invalid {
    border-color: var(--danger-color);
}

.form-input.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
}

select.form-input {
    cursor: pointer;
    appearance: none;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="%23262261" viewBox="0 0 16 16"><path d="M8 11L3 6h10l-5 5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 14px;
}

textarea.form-input {
    font-family: inherit;
    line-height: 1.6;
}

.error-message {
    font-size: 12px;
    color: var(--danger-color);
    font-weight: 600;
    margin-top: 4px;
}

/* Photo Modal Styles */
.photo-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.3s ease;
}

.photo-modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    width: 90%;
    max-width: 480px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    animation: slideDown 0.3s ease;
}

.photo-modal-header {
    background: linear-gradient(135deg, #4a9fd8, #3b8bc4);
    color: white;
    padding: 20px 25px;
    font-size: 18px;
    font-weight: 600;
}

.photo-modal-body {
    padding: 40px 30px;
    text-align: center;
}

.upload-area {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.btn-upload {
    background: linear-gradient(135deg, #4a9fd8, #3b8bc4);
    color: white;
    border: none;
    padding: 12px 40px;
    font-size: 15px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-upload:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 159, 216, 0.4);
}

.photo-modal-footer {
    padding: 20px 25px;
    background: #f8f9fa;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-modal {
    padding: 10px 25px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-apply {
    background: linear-gradient(135deg, #4a9fd8, #3b8bc4);
    color: white;
}

.btn-apply:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 159, 216, 0.4);
}

.btn-cancel {
    background: #6c757d;
    color: white;
}

.btn-cancel:hover {
    background: #5a6268;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .form-group.full-width {
        grid-column: 1;
    }

    .photo-modal-content {
        margin: 20% auto;
        width: 95%;
    }
}
</style>

<script>
let selectedFile = null;

function openPhotoModal() {
    document.getElementById('photoModal').style.display = 'block';
}

function closePhotoModal() {
    document.getElementById('photoModal').style.display = 'none';
    document.getElementById('selectedFileName').textContent = '';
    selectedFile = null;
}

// Handle file selection
document.getElementById('candidate_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileSizeKB = file.size / 1024;

        if (fileSizeKB > 200) {
            alert('File size exceeds 200KB. Please choose a smaller image or compress it.');
            e.target.value = '';
            document.getElementById('selectedFileName').textContent = '';
            selectedFile = null;
            return;
        }

        // Check file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, JPEG, or PNG).');
            e.target.value = '';
            document.getElementById('selectedFileName').textContent = '';
            selectedFile = null;
            return;
        }

        selectedFile = file;
        document.getElementById('selectedFileName').textContent = '✓ Selected: ' + file.name + ' (' + Math.round(fileSizeKB) + 'KB)';
    }
});

function applyPhoto() {
    if (selectedFile) {
        // Create preview
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">';
        };
        reader.readAsDataURL(selectedFile);

        closePhotoModal();
    } else {
        alert('Please select a photo first.');
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('photoModal');
    if (event.target == modal) {
        closePhotoModal();
    }
}
</script>
@endsection
