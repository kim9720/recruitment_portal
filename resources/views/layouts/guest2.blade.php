<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Habari Recruitment</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/theme/css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/theme/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/theme/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/theme/css/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/theme/css/highlight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jobs.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compare/css/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/theme/css/bootstrap-editable.css') }}" />

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/bootstrap-editable.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.toggle').hide();

            $('.show').click(function() {
                var id = $(this).attr('id');
                var txt = $("#toggle-" + id).is(':visible') ? '+' : '-';
                $("#" + id).text(txt);
                $('#toggle-' + id).toggle(100);
                return false;
            });

            $(".jobfunction").select2({
                placeholder: "{{ session('jobfunction', 'All Job Functions') }}",
                allowClear: true,
            }).val("{{ session('jobfunction', 'All Job Functions') }}");

            $(".category").select2({
                placeholder: "{{ session('category', 'Category') }}",
                allowClear: true,
            }).val("{{ session('category', 'Category') }}");

            $(".location").select2({
                placeholder: "{{ session('location', 'Location') }}",
                allowClear: true,
            }).val("{{ session('location', 'Location') }}");

            $('.editcandidatedetails').editable({
                params: function(params) {
                    params.pk = $(this).editable().data('pk');
                    params.id = $(this).editable().data('id');
                    params.table = $(this).editable().data('table');
                    return params;
                },
                error: function(response, newValue) {
                    if (response.status === 500) {
                        return 'Service unavailable. Please try later.';
                    } else {
                        return response.responseText;
                    }
                },
                ajaxOptions: {
                    dataType: 'json'
                },
                success: function(response, newvalue) {
                    $("#row" + response.saverow.id).text(response.saverow.label);
                }
            });

            var thirdsegment = "{{ $thirdchecksegment ?? '' }}";
            var secondsegment = "{{ $secondchecksegment ?? '' }}";
            if (thirdsegment || secondsegment) {
                $('html, body').animate({
                    scrollTop: $("#vacanciessection").offset().top
                }, 1000);
            }
        });
    </script>
</head>

<body>
    <div>
        @include('layouts.navigation')
        <main>
            {{-- {{ $slot }} --}}
                    @yield('content')
        </main>
    </div>
    <footer class="ftco-footer ftco-bg-dark ftco-section" id="footersection">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">
                            <a href="https://www.foodforhischildren.org/" target="_blank" class="text-white">About
                                Us</a>
                        </h2>
                        <p>We believe success is achieved through strong relationships with God, self, others and the
                            rest of creation.</p>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Candidate</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">How it works</a></li>
                            <li><a href="#" class="py-2 d-block">Register</a></li>
                            <li><a href="#" class="py-2 d-block">Apply Job</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-4">
                        <h2 class="ftco-heading-2">Employer</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">Candidates</a></li>
                            <li><a href="#" class="py-2 d-block">Post a Job</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li>
                                    <span class="glyphicon glyphicon-map-marker fa-fw"></span>
                                    <span class="text">FOOD FOR HIS CHILDREN</span>
                                </li>
                                <li>
                                    <a href="#"><span class="glyphicon glyphicon-phone fa-fw"></span>
                                        <span class="text">+255 659 074 444</span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="glyphicon glyphicon-envelope fa-fw"></span>
                                        <span class="text">kerrie@FoodForHisChildren.org</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        All rights reserved | <i class="icon-heart text-danger" aria-hidden="true"></i>
                        A Product of <a href="https://www.habari.co.tz" target="_blank">Habari Node PLC</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('assets/js/scrollax.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
