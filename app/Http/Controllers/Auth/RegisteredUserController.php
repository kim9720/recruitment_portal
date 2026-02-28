<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\CandidateDocument;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateReferee;

use Illuminate\Auth\Events\Registered;
// use Illuminate\Container\Attributes\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;


// use function Illuminate\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = [
            'Afghanistan' => 'Afghanistan',
            'Albania' => 'Albania',
            'Algeria' => 'Algeria',
            'Andorra' => 'Andorra',
            'Angola' => 'Angola',
            'Antigua and Barbuda' => 'Antigua and Barbuda',
            'Argentina' => 'Argentina',
            'Armenia' => 'Armenia',
            'Australia' => 'Australia',
            'Austria' => 'Austria',
            'Azerbaijan' => 'Azerbaijan',
            'Bahamas' => 'Bahamas',
            'Bahrain' => 'Bahrain',
            'Bangladesh' => 'Bangladesh',
            'Barbados' => 'Barbados',
            'Belarus' => 'Belarus',
            'Belgium' => 'Belgium',
            'Belize' => 'Belize',
            'Benin' => 'Benin',
            'Bhutan' => 'Bhutan',
            'Bolivia' => 'Bolivia',
            'Bosnia and Herzegovina' => 'Bosnia and Herzegovina',
            'Botswana' => 'Botswana',
            'Brazil' => 'Brazil',
            'Brunei' => 'Brunei',
            'Bulgaria' => 'Bulgaria',
            'Burkina Faso' => 'Burkina Faso',
            'Burundi' => 'Burundi',
            'Cabo Verde' => 'Cabo Verde',
            'Cambodia' => 'Cambodia',
            'Cameroon' => 'Cameroon',
            'Canada' => 'Canada',
            'Central African Republic' => 'Central African Republic',
            'Chad' => 'Chad',
            'Chile' => 'Chile',
            'China' => 'China',
            'Colombia' => 'Colombia',
            'Comoros' => 'Comoros',
            'Congo (Congo-Brazzaville)' => 'Congo (Congo-Brazzaville)',
            'Costa Rica' => 'Costa Rica',
            'Croatia' => 'Croatia',
            'Cuba' => 'Cuba',
            'Cyprus' => 'Cyprus',
            'Czechia (Czech Republic)' => 'Czechia (Czech Republic)',
            'Democratic Republic of the Congo' => 'Democratic Republic of the Congo',
            'Denmark' => 'Denmark',
            'Djibouti' => 'Djibouti',
            'Dominica' => 'Dominica',
            'Dominican Republic' => 'Dominican Republic',
            'Ecuador' => 'Ecuador',
            'Egypt' => 'Egypt',
            'El Salvador' => 'El Salvador',
            'Equatorial Guinea' => 'Equatorial Guinea',
            'Eritrea' => 'Eritrea',
            'Estonia' => 'Estonia',
            'Eswatini' => 'Eswatini',
            'Ethiopia' => 'Ethiopia',
            'Fiji' => 'Fiji',
            'Finland' => 'Finland',
            'France' => 'France',
            'Gabon' => 'Gabon',
            'Gambia' => 'Gambia',
            'Georgia' => 'Georgia',
            'Germany' => 'Germany',
            'Ghana' => 'Ghana',
            'Greece' => 'Greece',
            'Grenada' => 'Grenada',
            'Guatemala' => 'Guatemala',
            'Guinea' => 'Guinea',
            'Guinea-Bissau' => 'Guinea-Bissau',
            'Guyana' => 'Guyana',
            'Haiti' => 'Haiti',
            'Honduras' => 'Honduras',
            'Hungary' => 'Hungary',
            'Iceland' => 'Iceland',
            'India' => 'India',
            'Indonesia' => 'Indonesia',
            'Iran' => 'Iran',
            'Iraq' => 'Iraq',
            'Ireland' => 'Ireland',
            'Israel' => 'Israel',
            'Italy' => 'Italy',
            'Jamaica' => 'Jamaica',
            'Japan' => 'Japan',
            'Jordan' => 'Jordan',
            'Kazakhstan' => 'Kazakhstan',
            'Kenya' => 'Kenya',
            'Kiribati' => 'Kiribati',
            'Kuwait' => 'Kuwait',
            'Kyrgyzstan' => 'Kyrgyzstan',
            'Laos' => 'Laos',
            'Latvia' => 'Latvia',
            'Lebanon' => 'Lebanon',
            'Lesotho' => 'Lesotho',
            'Liberia' => 'Liberia',
            'Libya' => 'Libya',
            'Liechtenstein' => 'Liechtenstein',
            'Lithuania' => 'Lithuania',
            'Luxembourg' => 'Luxembourg',
            'Madagascar' => 'Madagascar',
            'Malawi' => 'Malawi',
            'Malaysia' => 'Malaysia',
            'Maldives' => 'Maldives',
            'Mali' => 'Mali',
            'Malta' => 'Malta',
            'Marshall Islands' => 'Marshall Islands',
            'Mauritania' => 'Mauritania',
            'Mauritius' => 'Mauritius',
            'Mexico' => 'Mexico',
            'Micronesia' => 'Micronesia',
            'Moldova' => 'Moldova',
            'Monaco' => 'Monaco',
            'Mongolia' => 'Mongolia',
            'Montenegro' => 'Montenegro',
            'Morocco' => 'Morocco',
            'Mozambique' => 'Mozambique',
            'Myanmar' => 'Myanmar',
            'Namibia' => 'Namibia',
            'Nauru' => 'Nauru',
            'Nepal' => 'Nepal',
            'Netherlands' => 'Netherlands',
            'New Zealand' => 'New Zealand',
            'Nicaragua' => 'Nicaragua',
            'Niger' => 'Niger',
            'Nigeria' => 'Nigeria',
            'North Korea' => 'North Korea',
            'North Macedonia' => 'North Macedonia',
            'Norway' => 'Norway',
            'Oman' => 'Oman',
            'Pakistan' => 'Pakistan',
            'Palau' => 'Palau',
            'Palestine' => 'Palestine',
            'Panama' => 'Panama',
            'Papua New Guinea' => 'Papua New Guinea',
            'Paraguay' => 'Paraguay',
            'Peru' => 'Peru',
            'Philippines' => 'Philippines',
            'Poland' => 'Poland',
            'Portugal' => 'Portugal',
            'Qatar' => 'Qatar',
            'Romania' => 'Romania',
            'Russia' => 'Russia',
            'Rwanda' => 'Rwanda',
            'Saint Kitts and Nevis' => 'Saint Kitts and Nevis',
            'Saint Lucia' => 'Saint Lucia',
            'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines',
            'Samoa' => 'Samoa',
            'San Marino' => 'San Marino',
            'Sao Tome and Principe' => 'Sao Tome and Principe',
            'Saudi Arabia' => 'Saudi Arabia',
            'Senegal' => 'Senegal',
            'Serbia' => 'Serbia',
            'Seychelles' => 'Seychelles',
            'Sierra Leone' => 'Sierra Leone',
            'Singapore' => 'Singapore',
            'Slovakia' => 'Slovakia',
            'Slovenia' => 'Slovenia',
            'Solomon Islands' => 'Solomon Islands',
            'Somalia' => 'Somalia',
            'South Africa' => 'South Africa',
            'South Korea' => 'South Korea',
            'South Sudan' => 'South Sudan',
            'Spain' => 'Spain',
            'Sri Lanka' => 'Sri Lanka',
            'Sudan' => 'Sudan',
            'Suriname' => 'Suriname',
            'Sweden' => 'Sweden',
            'Switzerland' => 'Switzerland',
            'Syria' => 'Syria',
            'Taiwan' => 'Taiwan',
            'Tajikistan' => 'Tajikistan',
            'Tanzania' => 'Tanzania',
            'Thailand' => 'Thailand',
            'Timor-Leste' => 'Timor-Leste',
            'Togo' => 'Togo',
            'Tonga' => 'Tonga',
            'Trinidad and Tobago' => 'Trinidad and Tobago',
            'Tunisia' => 'Tunisia',
            'Turkey' => 'Turkey',
            'Turkmenistan' => 'Turkmenistan',
            'Tuvalu' => 'Tuvalu',
            'Uganda' => 'Uganda',
            'Ukraine' => 'Ukraine',
            'United Arab Emirates' => 'United Arab Emirates',
            'United Kingdom' => 'United Kingdom',
            'United States' => 'United States',
            'Uruguay' => 'Uruguay',
            'Uzbekistan' => 'Uzbekistan',
            'Vanuatu' => 'Vanuatu',
            'Vatican City' => 'Vatican City',
            'Venezuela' => 'Venezuela',
            'Vietnam' => 'Vietnam',
            'Yemen' => 'Yemen',
            'Zambia' => 'Zambia',
            'Zimbabwe' => 'Zimbabwe',
        ];

        $educationLevels = [
            'Certificate' => 'Certificate',
            'Diploma' => 'Diploma',
            'Bachelor' => 'Bachelor',
            'Master' => 'Master',
            'PhD' => 'PhD',
        ];

        $institutions = [
            '' => 'Select Institution',
            'University of Dar es Salaam (UDSM)' => 'University of Dar es Salaam (UDSM)',
            'University of Dodoma (UDOM)' => 'University of Dodoma (UDOM)',
            'Open University of Tanzania (OUT)' => 'Open University of Tanzania (OUT)',
            'Sokoine University of Agriculture (SUA)' => 'Sokoine University of Agriculture (SUA)',
            'Mbeya University of Science and Technology (MUST)' => 'Mbeya University of Science and Technology (MUST)',
            'Nelson Mandela African Institute of Science and Technology (NMAIST)' => 'Nelson Mandela African Institute of Science and Technology (NMAIST)',
            'Mzumbe University' => 'Mzumbe University',
            'State University of Zanzibar (SUZA)' => 'State University of Zanzibar (SUZA)',
            'Hubert Kairuki Memorial University (HKMU)' => 'Hubert Kairuki Memorial University (HKMU)',
            'St. Augustine University of Tanzania (SAUT)' => 'St. Augustine University of Tanzania (SAUT)',
            'Tumaini University Makumira (TUMA)' => 'Tumaini University Makumira (TUMA)',
            'Teofilo Kisanji University (TEKU)' => 'Teofilo Kisanji University (TEKU)',
            'Ruaha Catholic University (RUCU)' => 'Ruaha Catholic University (RUCU)',
            'Jordan University College (JUCo)' => 'Jordan University College (JUCo)',
            'Catholic University of Health and Allied Sciences (CUHAS)' => 'Catholic University of Health and Allied Sciences (CUHAS)',
            'University of Iringa (UoI)' => 'University of Iringa (UoI)',
            'Mount Meru University (MMU)' => 'Mount Meru University (MMU)',
            'International Medical and Technological University (IMTU)' => 'International Medical and Technological University (IMTU)',
            'Kampala International University in Tanzania (KIUT)' => 'Kampala International University in Tanzania (KIUT)',
            'St. John’s University of Tanzania (SJUT)' => 'St. John’s University of Tanzania (SJUT)',
            'United African University of Tanzania (UAUT)' => 'United African University of Tanzania (UAUT)',
            'Other' => 'Other',
        ];

        $highQualifications = [
            'Certificate' => 'Certificate',
            'Diploma' => 'Diploma',
            'Bachelor' => 'Bachelor',
            'Master' => 'Master',
            'PhD' => 'PhD',
        ];

        return view('auth.register', compact('countries', 'educationLevels', 'institutions', 'highQualifications'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(route('dashboard', absolute: false));
    // }

    public function store(Request $request)
    {
        // Validation rules
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            // Login Details
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',

            // Personal Details
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'adressline' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'reg_country' => 'required|string|max:255',
            'mobilenumber1' => 'required|string|max:20',
            'mobilenumber2' => 'required|string|max:20',
            'gender' => 'required|in:Male,Female',

            // Work Experience
            // 'organisation' => 'required|array',
            // 'organisation.*' => 'required|string|max:255',
            // 'role' => 'required|array',
            // 'role.*' => 'required|string|max:255',
            // 'startdate' => 'required|array',
            // 'startdate.*' => 'required',
            // 'enddate' => 'required|array',
            // 'enddate.*' => 'required',

            // // Academic Qualifications
            // 'educationlevel' => 'required|array',
            // 'educationlevel.*' => 'required|string|max:255',
            // 'specialization' => 'required|array',
            // 'specialization.*' => 'required|string|max:255',
            // 'school' => 'required|array',
            // 'school.*' => 'required|string|max:255',
            // 'other_institution' => 'sometimes|array',
            // 'other_institution.*' => 'nullable|string|max:255',
            // 'educationstartdate' => 'required|array',
            // 'educationstartdate.*' => 'required',
            // 'educationenddate' => 'required|array',
            // 'educationenddate.*' => 'required',
            // 'uploadcertificate' => 'required|array',
            // 'uploadcertificate.*' => 'required|file|mimes:pdf,doc,docx|max:2048',

            // // Referees
            // 'refereename' => 'required|array',
            // 'refereename.*' => 'required|string|max:255',
            // 'company' => 'required|array',
            // 'company.*' => 'required|string|max:255',
            // 'title' => 'required|array',
            // 'title.*' => 'required|string|max:255',
            // 'telephone' => 'required|array',
            // 'telephone.*' => 'required|string|max:20',
            // 'adress' => 'required|array',
            // 'adress.*' => 'required|string|max:255',
            // 'email2' => 'required|array',
            // 'email2.*' => 'required|email|max:255',

            // // Work Info
            // 'highqualification' => 'required|string|max:255',
            // 'uploadcvfile' => 'required|file|mimes:pdf,doc,docx|max:2048',

            // // Other Documents
            // 'docname' => 'sometimes|array',
            // 'docname.*' => 'nullable|string|max:255',
            // 'uploadcertificateotherdocument' => 'sometimes|array',
            // 'uploadcertificateotherdocument.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                // Create user
                $user = User::create([
                    'username' => $request->firstname . ' ' . $request->middlename . ' ' . $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'candidate',
                ]);

                $user->assignRole('candidate');

                // Create candidate profile
                $candidateProfile = CandidateProfile::create([
                    'user_id' => $user->id,
                    'user_slug' => Str::slug($request->firstname . '-' . $request->lastname . '-' . $user->id),
                    'login_id' => $user->id,
                    'first_name' => $request->firstname,
                    'middle_name' => $request->middlename,
                    'last_name' => $request->lastname,
                    'address' => $request->adressline,
                    'city' => $request->region,
                    'email' => $request->email,
                    'mobile' => $request->mobilenumber1,
                    'secondmobile' => $request->mobilenumber2,
                    'reg_country' => $request->reg_country,
                    'gender' => $request->gender,
                    'highqualification' => $request->highqualification,
                    'status' => 1,
                    'resumefile' => 'none',
                ]);

                // // Handle Work Experience
                // if ($request->has('organisation')) {
                //     foreach ($request->organisation as $index => $organisation) {
                //         $startDate = $request->startdate[$index];
                //         $endDate = $request->enddate[$index];
                //         // Calculate months difference
                //         $months = $this->calculateMonthsDifference($startDate, $endDate);
                //         // dd($startDate, $endDate);

                //         CandidateExperience::create([
                //             'user_id' => $user->id,
                //             'company_name' => $organisation,
                //             'role' => $request->role[$index],
                //             'startdate' => $startDate,
                //             'enddate' => $endDate,
                //             'months' => $months,
                //         ]);
                //     }
                // }

                // Handle Academic Qualifications
                // if ($request->has('educationlevel')) {
                //     foreach ($request->educationlevel as $index => $educationlevel) {
                //         // Handle file upload
                //         $certificatePath = null;
                //         if ($request->hasFile("uploadcertificate.$index")) {
                //             $certificatePath = $request->file("uploadcertificate.$index")->store('qualifications', 'public');
                //         }

                //         $institution = $request->school[$index] === 'Other'
                //             ? $request->other_institution[$index]
                //             : $request->school[$index];

                //         CandidateEducation::create([
                //             'user_id' => $user->id,
                //             'educationlevel' => $educationlevel,
                //             'specialization' => $request->specialization[$index],
                //             'institute' => $institution,
                //             'educationstartdate' => $request->educationstartdate[$index],
                //             'educationenddate' => $request->educationenddate[$index],
                //             'certificate_path' => $certificatePath,
                //         ]);
                //     }
                // }

                // Handle Referees
                // if ($request->has('refereename')) {
                //     foreach ($request->refereename as $index => $refereename) {
                //         CandidateReferee::create([
                //             'user_id' => $user->id,
                //             'refereename' => $refereename,
                //             'organisation' => $request->company[$index],
                //             'title' => $request->title[$index],
                //             'telephone' => $request->telephone[$index],
                //             'refereeaddress' => $request->adress[$index],
                //             'refereeemail' => $request->email2[$index],
                //         ]);
                //     }
                // }

                // // Handle CV upload
                // if ($request->hasFile('uploadcvfile')) {
                //     $cvPath = $request->file('uploadcvfile')->store('cvs', 'public');
                //     $candidateProfile->update(['resumefile' => $cvPath]);
                // }

                // // Handle Other Documents
                // if ($request->has('docname')) {
                //     foreach ($request->docname as $index => $docname) {
                //         if ($request->hasFile("uploadcertificateotherdocument.$index")) {
                //             $documentPath = $request->file("uploadcertificateotherdocument.$index")->store('documents', 'public');

                //             CandidateDocument::create([
                //                 'user_id' => $user->id,
                //                 'document_name' => $docname,
                //                 'document_file' => $documentPath,
                //             ]);
                //         }
                //     }
                // }
            });

            return redirect()->route('login')
                ->with('success', 'Registration successful! Please login to continue.');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'An error occurred during registration. Please try again.')
                ->withInput();
        }
    }

    private function parseDate($dateString)
    {
        return \Carbon\Carbon::createFromFormat('M Y', $dateString)->format('Y-m-d');
    }
    private function calculateMonthsDifference($startDate, $endDate)
    {
        try {
            // Clean inputs
            $startDate = trim($startDate);
            $endDate   = trim($endDate);

            // Try parsing flexibly
            $start = \Carbon\Carbon::parse($startDate);
            $end   = \Carbon\Carbon::parse($endDate);

            return $start->diffInMonths($end);
        } catch (\Exception $e) {
            // Fallback: try known formats
            $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d', 'd-F-Y', 'd M Y'];
            foreach ($formats as $format) {
                try {
                    $start = \Carbon\Carbon::createFromFormat($format, $startDate);
                    $end   = \Carbon\Carbon::createFromFormat($format, $endDate);
                    return $start->diffInMonths($end);
                } catch (\Exception $e) {
                    // keep trying
                }
            }

            // If still invalid, log error
            Log::error("Date parsing failed: {$e->getMessage()}");
            return null; // or throw an exception
        }
    }

    /**
     * Parse date from "M Y" format to Y-m-d format
     */
    // private function parseDate($dateString)
    // {
    //     return \Carbon\Carbon::createFromFormat('M Y', $dateString)->format('Y-m-d');
    // }

    /**
     * Validate reCAPTCHA (you need to implement this based on your reCAPTCHA setup)
     */
    private function validateRecaptcha($response)
    {
        // Implement reCAPTCHA validation logic
        // This is a placeholder - you'll need to use the reCAPTCHA PHP library
        // or make a request to Google's reCAPTCHA verification endpoint

        return true; // Placeholder
    }
}
