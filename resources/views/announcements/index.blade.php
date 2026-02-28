    @extends('layouts.guest')
    <?php
    // Example data for shortlisted applicants
    $shortlisted = [
        (object) [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'mobile' => '0712345678',
            'job_title' => 'Software Developer',
            'applied_date' => '2025-01-10',
            'deadline' => '2025-02-01',
            'applicationstatus' => '3', // Short Listed
        ],
        (object) [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'mobile' => '0789123456',
            'job_title' => 'System Analyst',
            'applied_date' => '2025-01-12',
            'deadline' => '2025-02-05',
            'applicationstatus' => '4', // Rejected
        ],
        (object) [
            'first_name' => 'Ali',
            'last_name' => 'Mohamed',
            'email' => 'ali.mohamed@example.com',
            'mobile' => '0756123456',
            'job_title' => 'Database Administrator',
            'applied_date' => '2025-01-15',
            'deadline' => '2025-02-10',
            'applicationstatus' => '2', // Under Review
        ],
    ];
    ?>

    @section('content')
        <div id="homesection">
            <div class="overlay"></div>
            <div class="container">
                <div class="ftco-search">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active mr-md-1" style="background-color: #d28149" id="v-pills-1-tab"
                                    data-toggle="pill" role="tab" aria-controls="v-pills-1" aria-selected="true"><span
                                        style="color: #fff">Short Listed</span></a>
                            </div>
                            <hr class="hr">

                            <div class="tab-content p-4" id="v-pills-tabContent">


                            </div>
                        </div>
                    </div>
                    <!-- <div class="row"> -->


                    <div class="col-sm-12 ">

                        <div class=" panel-default1">

                            <div class="panel-body">
                                <div class="row">
                                    <div class=" col-sm-12 col-md-12">
                                        <div class="content-block">
                                            <h4> Short Listed Applicants</h4>
                                            <div class="table-responsive shadow-sm rounded">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Email</th>
                                                            <th>Mobile</th>
                                                            <th>Job Title</th>
                                                            <th>Applied Date</th>
                                                            <th>Deadline</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($shortlisted as $index => $row)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $row->first_name }}</td>
                                                                <td>{{ $row->last_name }}</td>
                                                                <td>{{ $row->email }}</td>
                                                                <td>{{ $row->mobile }}</td>
                                                                <td>{{ $row->job_title }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($row->applied_date)->format('d M Y') }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($row->deadline)->format('d M Y') }}
                                                                </td>
                                                                <td>
                                                                    @if ($row->applicationstatus == 3)
                                                                        <span class="badge badge-success">Short
                                                                            Listed</span>
                                                                    @elseif ($row->applicationstatus == 4)
                                                                        <span class="badge badge-danger">Rejected</span>
                                                                    @else
                                                                        <span class="badge badge-info">Under Review</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">No Short Listed
                                                                    Applicants Found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-sm-12">
                                    <div class="col text-center">
                                        <div class="block-27">
                                            <!-- <ul> -->
                                            <!-- <li><a href="#">&lt;</a></li>
                  <li class="active"><span>1</span></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">&gt;</a></li> -->


                                            <!-- </ul> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- </div> -->
                </div>
            </div>
            <!-- </div> -->
        </div>
    @endsection
