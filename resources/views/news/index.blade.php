    @extends('layouts.guest')
    @section('content')
        <div id="homesection">
            <div class="overlay"></div>
            <div class="container">
                <div class="ftco-search">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active mr-md-1" style="background-color: #d28149" id="v-pills-1-tab"
                                    data-toggle="pill" role="tab" aria-controls="v-pills-1" aria-selected="true">
                                    <span style="color: #fff">Organization Announcements</span>
                                </a>
                            </div>
                            <hr class="hr">

                            <div class="tab-content p-4" id="v-pills-tabContent"></div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="panel-default1">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="content-block">
                                            <h4 class="mb-4 p-3">Latest Announcements & News</h4>

                                            <div class="list-group shadow-lg rounded">
                                                @forelse($announcements as $row)
                                                    <div
                                                        class="list-group-item list-group-item-action mb-2 rounded shadow-sm">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h5 class="mb-1">{{ $row['title'] }}</h5>

                                                            @if (!empty($row['deadline']))
                                                                <small class="text-muted">Deadline:
                                                                    {{ \Carbon\Carbon::parse($row['deadline'])->format('d M Y') }}</small>
                                                            @elseif (!empty($row['date']))
                                                                <small
                                                                    class="text-muted">{{ \Carbon\Carbon::parse($row['date'])->format('d M Y') }}</small>
                                                            @endif
                                                        </div>
                                                        <p class="mb-1">{{ $row['content'] }}</p>
                                                        <div class="mt-2">
                                                            <a href="#" class="btn btn-sm btn-outline-primary">Read
                                                                More</a>

                                                            @if ($row['type'] === 'advertisement')
                                                                <a href="#" class="btn btn-sm btn-warning">Apply
                                                                    Now</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="alert alert-warning text-center">
                                                        🚨 No Announcements Found
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="col text-center">
                                        <div class="block-27">
                                            <!-- pagination can go here if needed -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
