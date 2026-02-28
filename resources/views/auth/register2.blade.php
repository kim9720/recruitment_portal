@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="col-sm-12">
            <div class="panel-default1">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">

                            <div class="row justify-content-center mb-5 pb-3">
                                <div class="col-md-7 heading-section text-center">
                                    <h2 class="mb-4" style="color: #262261">Register</h2>
                                </div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> {{ session('error') }}
                                </div>
                            @endif
                            @if (session('info'))
                                <div class="alert alert-info">
                                    <strong>Info!</strong> {{ session('info') }}
                                </div>
                            @endif

                            <form action="" method="POST" enctype="multipart/form-data" name="myform" id="myform"
                                autocomplete="off">
                                @csrf

                                <!-- Login Details -->
                                <div class="col-md-12">
                                    <div class="nav nav-pills text-center" style="background-color: #262261">
                                        <a class="nav-link active mr-md-1" style="background-color: #262261"
                                            id="v-pills-1-tab">Login Details</a>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ old('email') }}" placeholder="Email" required>
                                                @error('email')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Password" required>
                                                @error('password')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    placeholder="Confirm Password" required>
                                                @error('password_confirmation')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Personal Details -->
                                <div class="col-md-12 mt-4">
                                    <div class="nav nav-pills text-center" style="background-color: #262261">
                                        <a class="nav-link active mr-md-1" style="background-color: #262261">Personal
                                            Details * (All are required)</a>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="firstname" class="form-control"
                                                    value="{{ old('firstname') }}" placeholder="First Name" required>
                                                @error('firstname')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="adressline" class="form-control"
                                                    value="{{ old('adressline') }}" placeholder="Address Line" required>
                                                @error('adressline')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="mobilenumber1" class="form-control"
                                                    value="{{ old('mobilenumber1') }}" placeholder="Mobile Number 1"
                                                    required>
                                                @error('mobilenumber1')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="middlename" class="form-control"
                                                    value="{{ old('middlename') }}" placeholder="Middle Name" required>
                                                @error('middlename')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="region" class="form-control"
                                                    value="{{ old('region') }}" placeholder="Region" required>
                                                @error('region')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="mobilenumber2" class="form-control"
                                                    value="{{ old('mobilenumber2') }}" placeholder="Mobile Number 2"
                                                    required>
                                                @error('mobilenumber2')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="lastname" class="form-control"
                                                    value="{{ old('lastname') }}" placeholder="Last Name" required>
                                                @error('lastname')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select name="reg_country" class="form-control" required>
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country }}"
                                                            {{ old('reg_country') == $country ? 'selected' : '' }}>
                                                            {{ $country }}</option>
                                                    @endforeach
                                                </select>
                                                @error('reg_country')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select name="gender" class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male"
                                                        {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female"
                                                        {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                                @error('gender')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Work Experience -->
                                <div class="col-md-12 mt-4">
                                    <div class="nav nav-pills text-center" style="background-color: #262261">
                                        <a class="nav-link active mr-md-1"
                                            style="background-color: #262261;padding-bottom: 12px;">
                                            Work Experience * (All are required)
                                            <button type="button" id="btnAddexperience" style="float: right">+</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 workexperience" id="workexperience">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="organisation[]" class="form-control"
                                                    value="{{ old('organisation.0') }}" placeholder="Organisation"
                                                    required>
                                                @error('organisation.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="role[]" class="form-control"
                                                    value="{{ old('role.0') }}" placeholder="Role" required>
                                                @error('role.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" name="startdate[]" class="form-control startdate"
                                                    placeholder="From? (M YYYY)" required>
                                                @error('startdate.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" name="enddate[]" class="form-control enddate"
                                                    placeholder="To? (M YYYY)" required>
                                                @error('enddate.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-1 btnremoveexperience">
                                            <button type="button" class="btnDeleteexperience"
                                                style="float: right">-</button>
                                        </div>
                                    </div>
                                    <hr class="hr2">
                                </div>
                                <div id="appendworkexperience"></div>

                                <!-- Academic Qualifications -->
                                <div class="col-md-12 mt-4">
                                    <div class="nav nav-pills text-center" style="background-color: #262261">
                                        <a class="nav-link active mr-md-1"
                                            style="background-color: #262261;padding-bottom: 12px;">
                                            Academic Qualifications * (All are required)
                                            <button type="button" id="btnAddqualification"
                                                style="float: right">+</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3" id="qualification">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select name="educationlevel[]" class="form-control" id="educationlevel"
                                                    required>
                                                    <option value="">Select Education Level</option>
                                                    @foreach ($educationLevels as $level)
                                                        <option value="{{ $level }}"
                                                            {{ old('educationlevel.0') == $level ? 'selected' : '' }}>
                                                            {{ $level }}</option>
                                                    @endforeach
                                                </select>
                                                @error('educationlevel.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="specialization[]" class="form-control"
                                                    value="{{ old('specialization.0') }}" placeholder="Specialization"
                                                    required>
                                                @error('specialization.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="educationstartdate[]"
                                                    class="form-control educationstartdate" placeholder="From? (M YYYY)"
                                                    required>
                                                @error('educationstartdate.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select name="school[]" class="form-control" id="Institution" required>
                                                    <option value="">Select Institution</option>
                                                    @foreach ($institutions as $institution)
                                                        <option value="{{ $institution }}"
                                                            {{ old('school.0') == $institution ? 'selected' : '' }}>
                                                            {{ $institution }}</option>
                                                    @endforeach
                                                    <option value="Other"
                                                        {{ old('school.0') == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                <input type="text" name="other_institution[]" id="otherInstitution"
                                                    class="form-control mt-2" placeholder="Enter your institution"
                                                    style="display: {{ old('school.0') == 'Other' ? 'block' : 'none' }};"
                                                    {{ old('school.0') == 'Other' ? 'required' : '' }}>
                                                @error('school.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                                @error('other_institution.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="file" name="uploadcertificate[]"
                                                    class="form-control uploadcertificate" accept=".pdf,.docx,.doc"
                                                    required>
                                                <span id="file_error" class="file_error" style="color: red;"></span>
                                                @error('uploadcertificate.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="educationenddate[]"
                                                    class="form-control educationenddate" placeholder="To? (M YYYY)"
                                                    required>
                                                @error('educationenddate.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr2">
                                </div>
                                <div id="appendqualification"></div>

                                <!-- Referees -->
                                <div class="col-md-12 mt-4">
                                    <div class="nav nav-pills text-center" style="background-color: #262261">
                                        <a class="nav-link active mr-md-1"
                                            style="background-color: #262261;padding-bottom: 12px;">
                                            Referees * (All are required)
                                            <button type="button" id="btnAddreferees" style="float: right">+</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3" id="referees">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="refereename[]" class="form-control"
                                                    value="{{ old('refereename.0') }}" placeholder="Referee Name"
                                                    required>
                                                @error('refereename.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="company[]" class="form-control"
                                                    value="{{ old('company.0') }}" placeholder="Company" required>
                                                @error('company.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="title[]" class="form-control"
                                                    value="{{ old('title.0') }}" placeholder="Title" required>
                                                @error('title.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="telephone[]" class="form-control"
                                                    value="{{ old('telephone.0') }}" placeholder="Telephone" required>
                                                @error('telephone.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="adress[]" class="form-control"
                                                    value="{{ old('adress.0') }}" placeholder="Address" required>
                                                @error('adress.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="email" name="email2[]" class="form-control"
                                                    value="{{ old('email2.0') }}" placeholder="Email" required>
                                                @error('email2.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr2">
                                </div>
                                <div id="appendreferees"></div>

                                <!-- Work Info (Upload CV) -->
                                <div class="col-md-12 mt-4">
                                    <div class="nav nav-pills text-center" style="background-color: #262261">
                                        <a class="nav-link active mr-md-1" style="background-color: #262261">Work Info
                                            (Upload CV)</a>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select name="highqualification" class="form-control"
                                                    id="highqualification" required>
                                                    <option value="">Select Highest Qualification</option>
                                                    @foreach ($highQualifications as $qualification)
                                                        <option value="{{ $qualification }}"
                                                            {{ old('highqualification') == $qualification ? 'selected' : '' }}>
                                                            {{ $qualification }}</option>
                                                    @endforeach
                                                </select>
                                                @error('highqualification')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="file" name="uploadcvfile"
                                                    class="form-control file_upload2" accept=".pdf,.docx,.doc" required>
                                                <span id="file_error2" style="color: red;"></span>
                                                @error('uploadcvfile')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Other Documents -->
                                <div class="col-md-12 mt-4">
                                    <div class="nav nav-pills text-center" style="background-color: #262261">
                                        <a class="nav-link active mr-md-1"
                                            style="background-color: #262261;padding-bottom: 12px;">
                                            Other Documents (e.g., Birth Certificate, Recommendation Letter, etc)
                                            <button type="button" id="btnAddotherdocument"
                                                style="float: right">+</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3" id="otherdocument">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="docname[]" class="form-control"
                                                    value="{{ old('docname.0') }}" placeholder="Document Name" required>
                                                @error('docname.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="file" name="uploadcertificateotherdocument[]"
                                                    class="form-control file_upload3" accept=".pdf,.docx,.doc" required>
                                                <span id="file_error3" style="color: red;"></span>
                                                @error('uploadcertificateotherdocument.0')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr2">
                                </div>
                                <div id="appendotherdocument"></div>

                                <!-- CAPTCHA (Assuming reCAPTCHA) -->
                                {{-- @if (config('app.captcha_registration'))
                                    @if (config('app.use_recaptcha'))
                                        <div class="col-md-12 mt-3">
                                            <div id="recaptcha_image"></div>
                                            <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                                            <div class="recaptcha_only_if_image"><a
                                                    href="javascript:Recaptcha.switch_type('audio')">Get an audio
                                                    CAPTCHA</a></div>
                                            <div class="recaptcha_only_if_audio"><a
                                                    href="javascript:Recaptcha.switch_type('image')">Get an image
                                                    CAPTCHA</a></div>
                                            <div class="form-group">
                                                <input type="text" name="recaptcha_response_field"
                                                    class="form-control" id="recaptcha_response_field">
                                                @error('recaptcha_response_field')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {!! $recaptcha_html !!}
                                        </div>
                                    @else
                                        <div class="col-md-12 mt-3">
                                            <p>Enter the code exactly as it appears:</p>
                                            {!! $captcha_html !!}
                                            <div class="form-group">
                                                <label for="captcha">Confirmation Code</label>
                                                <input type="text" name="captcha" class="form-control" id="captcha"
                                                    required>
                                                @error('captcha')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                @endif --}}

                                <div class="col-md-12 mt-4">
                                    <div class="row justify-content-center">
                                        <div class="col-md-7 text-center">
                                            <button type="submit" class="btn btn-primary btn-b">Register</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Datepickers
            $(".startdate, .enddate, .educationstartdate, .educationenddate").datepicker({
                dateFormat: 'M yyyy',
                minViewMode: 1,
            });

            // Institution Other field toggle
            $(document).on('change', '#Institution', function() {
                var otherInput = $(this).closest('.row').find('#otherInstitution');
                if ($(this).val() === 'Other') {
                    otherInput.show().prop('required', true);
                } else {
                    otherInput.hide().prop('required', false).val('');
                }
            });

            // File validation
            function validateFile(input, errorSpan) {
                var extension = input.val().split('.').pop().toLowerCase();
                var validFileExtensions = ['docx', 'pdf', 'doc'];
                if ($.inArray(extension, validFileExtensions) == -1) {
                    errorSpan.text("Please upload docx, pdf, doc file only.").show();
                    input.val('');
                    return false;
                }
                if (input.get(0).files[0].size > 2048000) {
                    errorSpan.text("Max allowed file size is 2 MB").show();
                    input.val('');
                    return false;
                }
                errorSpan.text('').hide();
                return true;
            }

            $(document).on('change', '.uploadcertificate, .file_upload2, .file_upload3', function() {
                validateFile($(this), $(this).next('.file_error, #file_error2, #file_error3'));
            });

            // Add/Remove Work Experience
            let experienceCount = 1;
            $('#btnAddexperience').click(function() {
                let html = `
            <div class="row workexperience">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="organisation[${experienceCount}]" class="form-control" placeholder="Organisation" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="role[${experienceCount}]" class="form-control" placeholder="Role" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" name="startdate[${experienceCount}]" class="form-control startdate" placeholder="From? (M YYYY)" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" name="enddate[${experienceCount}]" class="form-control enddate" placeholder="To? (M YYYY)" required>
                    </div>
                </div>
                <div class="col-md-1 btnremoveexperience">
                    <button type="button" class="btnDeleteexperience" style="float: right">-</button>
                </div>
                <hr class="hr2">
            </div>`;
                $('#appendworkexperience').append(html);
                $('.startdate, .enddate').datepicker({
                    dateFormat: 'M yyyy',
                    minViewMode: 1,
                });
                experienceCount++;
            });

            $(document).on('click', '.btnDeleteexperience', function() {
                $(this).closest('.workexperience').remove();
            });

            // Add/Remove Qualifications
            let qualificationCount = 1;
            $('#btnAddqualification').click(function() {
                let html = `
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="educationlevel[${qualificationCount}]" class="form-control" required>
                            <option value="">Select Education Level</option>
                            @foreach ($educationLevels as $level)
                                <option value="{{ $level }}">{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="specialization[${qualificationCount}]" class="form-control" placeholder="Specialization" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="educationstartdate[${qualificationCount}]" class="form-control educationstartdate" placeholder="From? (M YYYY)" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="school[${qualificationCount}]" class="form-control" id="Institution${qualificationCount}" required>
                            <option value="">Select Institution</option>
                            @foreach ($institutions as $institution)
                                <option value="{{ $institution }}">{{ $institution }}</option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>
                        <input type="text" name="other_institution[${qualificationCount}]" id="otherInstitution${qualificationCount}" class="form-control mt-2" placeholder="Enter your institution" style="display: none;">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="file" name="uploadcertificate[${qualificationCount}]" class="form-control uploadcertificate" accept=".pdf,.docx,.doc" required>
                        <span class="file_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="educationenddate[${qualificationCount}]" class="form-control educationenddate" placeholder="To? (M YYYY)" required>
                    </div>
                </div>
            </div>
            <hr class="hr2">`;
                $('#appendqualification').append(html);
                $('.educationstartdate, .educationenddate').datepicker({
                    dateFormat: 'M yyyy',
                    minViewMode: 1,
                });
                qualificationCount++;
            });

            // Add/Remove Referees
            let refereeCount = 1;
            $('#btnAddreferees').click(function() {
                let html = `
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="refereename[${refereeCount}]" class="form-control" placeholder="Referee Name" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="company[${refereeCount}]" class="form-control" placeholder="Company" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="title[${refereeCount}]" class="form-control" placeholder="Title" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="telephone[${refereeCount}]" class="form-control" placeholder="Telephone" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="adress[${refereeCount}]" class="form-control" placeholder="Address" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="email" name="email2[${refereeCount}]" class="form-control" placeholder="Email" required>
                    </div>
                </div>
            </div>
            <hr class="hr2">`;
                $('#appendreferees').append(html);
                refereeCount++;
            });

            // Add/Remove Other Documents
            let documentCount = 1;
            $('#btnAddotherdocument').click(function() {
                let html = `
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="docname[${documentCount}]" class="form-control" placeholder="Document Name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="file" name="uploadcertificateotherdocument[${documentCount}]" class="form-control file_upload3" accept=".pdf,.docx,.doc" required>
                        <span class="file_error3" style="color: red;"></span>
                    </div>
                </div>
            </div>
            <hr class="hr2">`;
                $('#appendotherdocument').append(html);
                documentCount++;
            });
        });
    </script>


@endsection
