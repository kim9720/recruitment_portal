    @extends('layouts.guest')
    @section('content')
        <div class="main-banner" id="top">
            <video autoplay muted loop id="bg-video">
                <source src="{{ asset('assets/images/video.mp4') }}" type="video/mp4" />
            </video>
            <div class="video-overlay header-text">
                <div class="caption">
                    <h6>Habari Recruitment Portal</h6>
                    <h2>Find the perfect <em>Job</em></h2>
                    <div class="main-button">
                        <a href="contact.html">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="section" id="trainers">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="section-heading">
                            <h2>Available <em>Jobs</em></h2>
                            <img src="assets/images/line-dec.png" alt="">
                            <p>Explore current career opportunities at Habari and take the next step in your professional journey.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($joblist as $job)
                        <div class="col-lg-4">
                            <div class="trainer-item">
                                {{-- <div class="image-thumb">
                                    <img src="{{ asset('assets/images/product-1-720x480.jpg') }}" alt="">
                                </div> --}}
                                <div class="down-content">
                                    {{-- Example salary placeholder --}}

                                    <span>
                                        <i class="fa fa-map-marker"></i> {{ $job->location }}
                                    </span>
                                    <h4>{{ $job->job_title }}</h4>

                                    <p>{{ $job->category }} &nbsp;/&nbsp; {{ $job->jobfunction }}</p>

                                    <ul class="social-icons">
                                        <li>
                                            <a href="{{ route('jobs.guest_job_show', $job->job_id) }}">
                                                + View More
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <br>

                <div class="main-button text-center">
                    <a href="{{ route('jobs.index') }}">View Jobs</a>
                </div>
            </div>
        </section>
    @endsection
