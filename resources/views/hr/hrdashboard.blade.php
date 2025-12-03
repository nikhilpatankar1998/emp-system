
@include('hr.layouts.head')
<style>
    .container {
        margin-top: 100px;
    }

    .counter-box {
        display: flex;
        background: #0c0c0c3b;
        padding: 15px 15px;
        text-align: center;
        border-radius: 5px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .counter-box p {
        margin: 5px 0 0;
        padding: 0;
        color: #454242;
        font-size: 15px;
        font-weight: 600
    }

    .counter-box i {
        font-size: 60px;
        margin: 0 0 15px;
        color: #d2d2d2
    }

    .counter {
        /* display: inline-block; */
        font-size: 32px;
        font-weight: 700;
        color: #525050;
        line-height: 28px;
        background: #a3abb2;
        padding: 11px;
        border-radius: 100%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .counter-box.colored {
        background: #093862de;
    }

    .counter-box.colored p,
    .counter-box.colored i,
    .counter-box.colored .counter {
        color: #fff
    }

    .alert {
        padding: 3px 0px;
    }

    textarea.form-control {
        height: 123px !important;
    }

    .textstart{
      text-align: left;
      padding-left: 5px;
  }


    @media screen and (max-width: 420px) {
        .four.col-md-3 {
            margin-bottom: 15px
        }

        .datatitlenew {
            display: flex;
            align-items: center;
            gap: 2px;
        }
      
    }


    @media screen and (max-width: 768px) {
        .four.col-md-3 {
            margin-bottom: 15px
        }

        .datatitlenew {
            display: flex;
            align-items: center;
            gap: 2x;
        }
    }

@media only screen 
  and (min-device-width: 768px) 
  and (max-device-width: 1024px) 
  and (orientation: portrait),
only screen 
  and (min-device-width: 768px) 
  and (max-device-width: 1366px) 
  and (orientation: landscape) {

    .col-md-3 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: 33.33% !important; 
    }
}
</style>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        @include('hr.layouts.sidebar')

        <div class="body-wrapper">

            @include('hr.layouts.header')
            <div class="container-fluid">

                <!-- <div class="container-fluid"> -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                <h4 class="card-title mb-3 fw-bold text-primary">Employees Check IN</h4>

                                {{-- On Time Entries --}}
                                <div class="mb-3">
                                    <h6 class="fw-medium" style="color: #534e4e !important;">On Time:</h6>
                                    <div class="row">
                                        @foreach ($log_time as $item)
                                            @php
                                                $checkIn = \Carbon\Carbon::createFromFormat(
                                                    'H:i:s',
                                                    $item->chek_in_time,
                                                );
                                                $isLate = $checkIn->gt(\Carbon\Carbon::createFromTime(10, 15, 0));
                                            @endphp

                                            @if (!$isLate)
                                                <div class="col-md-6 mb-2">
                                                    <div
                                                        class="d-flex flex-column justify-content-between border p-2 rounded fw-semibold">
                                                        <span style="color:#008000;">{{ $item->name }} -</span>
                                                        <span style="color:#008000;">{{ $checkIn->format('h:i A') }}
                                                            LST / {{ $item->created_at->format('h:i A') }} ST</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Late Entries --}}
                                <div class="mt-4">
                                    <h6 class="fw-medium" style="color: #534e4e !important;">Late :</h6>
                                    <div class="row">
                                        @foreach ($log_time as $item)
                                            @php
                                                $checkIn = \Carbon\Carbon::createFromFormat(
                                                    'H:i:s',
                                                    $item->chek_in_time,
                                                );
                                                $isLate = $checkIn->gt(\Carbon\Carbon::createFromTime(10, 15, 0));
                                            @endphp

                                            @if ($isLate)
                                                <div class="col-md-6 mb-2">
                                                    <div
                                                        class="d-flex flex-column justify-content-between border p-2 rounded fw-semibold">
                                                        <span style="color:#ff0000;">{{ $item->name }} -</span>
                                                        <span style="color:#ff0000;">{{ $checkIn->format('h:i A') }}
                                                            LST / {{ $item->created_at->format('h:i A') }} ST</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <small class="text-muted">*LST = LOCAL SYSTEM TIME , *ST = SERVER TIME.</small>
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                <div class="datatitlenew mb-4">
                                    <h4 class="mb-0 card-title text-start fw-bold text-primary">Employees on Leave</h4>
                                    <p class="text-start mb-0 fs-3" style="color: #dd0101;font-weight: 500;">-
                                        &nbsp;Current Month</p> <a href="{{ url('/get-leave-data') }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-4"> View All Leaves</a>
                                </div>

                                <div class="row g-3">
                                    @foreach ($leave as $leaves)
                                        <div class="col-6 col-sm-3 col-md-2">
                                            <div class="card text-center border-0 shadow-sm rounded-3 py-2 px-1">
                                                <div class="mb-1">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                                        style="width: 36px; height: 36px; font-size: 14px;">
                                                        {{ strtoupper(substr($leaves->user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="text-dark small text-truncate px-1">
                                                    {{ explode(' ', $leaves->user->name)[0] }}
                                                </div>
                                                <div class="text-danger fw-bold small mt-1">
                                                    {{ $leaves->leave_count }} days</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- 🔻 Holiday Section -->
                                @if (!empty($holidays))
                                    <div class="mt-4">
                                        <h6 class="fw-bold text-primary mb-2">Upcoming Holidays (This Month)</h6>
                                        <ul class="list-group list-group-sm list-group-flush">
                                            {{-- @if (!empty($holidays)) --}}
                                            @foreach ($holidays as $holiday)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center px-2 py-1">
                                                    <span class="small fw-medium">{{ $holiday['name'] }}</span>
                                                    <span
                                                        class="badge bg-info text-dark small">{{ \Carbon\Carbon::parse($holiday['date'])->format('d M') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- </div> -->



                <!-- Profile Card -->

                <div class="col-lg-12">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <div class="datatitlenew mb-4">
                                <h4 class="mb-0 card-title text-start fw-bold text-primary">Employees Card</h4>

                            </div>
                            <div class="row g-4">
                                @foreach ($employees as $item)
                                    <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                                        <div class="card shadow-sm border-0 rounded-4 p-2 px-2 text-center"
                                            style="width: 100%; max-width: 350px; margin: auto; background: white; margin-bottom: 0px !important; box-shadow: 0px 0rem 5rem 20px rgba(0, 0, 0, 0.075) !important;">
                                            <!-- Profile Image -->
                                            <div class="mb-2">
                                                <img src="https://tse2.mm.bing.net/th?id=OIP.j-JTkZ2VRxE0QvycQpQJbgAAAA&pid=Api&P=0&h=180"
                                                    alt="Profile" class="rounded-circle border border-primary"
                                                    style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #707b85 !important;">
                                            </div>
                                            <!-- Name -->
                                            @php
                                                $nameParts = explode(' ', $item['name']);
                                            @endphp

                                            <h5 class="fw-bold text-uppercase mb-3 fs-3" style="letter-spacing: 1px;">
                                                <strong>{{ $nameParts[0] ?? '' }}</strong><br>
                                                <strong>{{ $nameParts[1] ?? '' }}</strong>
                                            </h5>
                                            <!-- Contact Info -->
                                            <div class="textstart" style="font-size: 14px;">
                                                {{-- <p class="mb-2"><span class="fw-bold">ST</span> :  {{ $item['check_in_today'] ? \Carbon\Carbon::parse($item['check_in_today'])->format('h:i A') : 'Not checked in' }}</p> --}}
                                                @php
                                                    $checkInTime = $item['check_in_today']
                                                        ? \Carbon\Carbon::parse($item['check_in_today'])
                                                        : null;
                                                    $isLate =
                                                        $checkInTime &&
                                                        $checkInTime->gt(\Carbon\Carbon::parse('10:15:00'));
                                                @endphp

                                                <p class="mb-2 fw-medium">
                                                    <span class="fw-bold">ST</span> :
                                                    <span class="{{ $isLate ? 'text-danger' : '' }}">
                                                        {{ $checkInTime ? $checkInTime->format('h:i A') : 'Not checked in' }}
                                                    </span>
                                                </p>
                                                <p class="mb-2 fw-medium"><span class="fw-bold">LST</span> :
                                                    {{ $item['created_at_today'] ? \Carbon\Carbon::parse($item['created_at_today'])->format('h:i A') : ' --:--' }}
                                                </p>
                                                <p class="mb-2 fw-medium"><span class="fw-bold">Leave</span> :
                                                    <a href="{{ url('/get-leave-data') }}">
                                                        {{ $item['total_leave_days'] }} days</a>
                                                </p>
                                                <p class="mb-0 fw-medium"><span class="fw-bold">Work (hrs)</span> :
                                                    {{ floor($item['total_working_minutes'] / 3600) }} :
                                                    {{ $item['total_working_minutes'] % 60 }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Profile Card -->

            </div>
        </div>
    </div>
    </div>
</body>
@include('hr.layouts.footer')

<script>
    $(document).ready(function() {

        $('.counter').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script>
    var ctx = document.getElementById('projectChart').getContext('2d');
    var chartData = @json($chartData);

    if (chartData.length === 0) {
        console.error("No data available for the chart");
    }

    var projectNames = chartData.map(item => item.name);
    var projectProgress = chartData.map(item => item.progress);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: projectNames,
            datasets: [{
                label: 'Project Progress (%)',
                data: projectProgress,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script> --}}
{{-- <script>
    var ctx = document.getElementById("taskChart").getContext("2d");

    var taskData = @json($taskschart);

    var labels = taskData.map(item => item.user_name);
    var totalTasks = taskData.map(item => item.total_tasks);
    var completedTasks = taskData.map(item => item.completed_tasks);

    var chart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                    label: "Assigned Tasks",
                    data: totalTasks,
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                },
                {
                    label: "Completed Tasks",
                    data: completedTasks,
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> --}}
<script>
    const addBtn = document.getElementById('add-broadcast-btn');
    const card = document.getElementById('broadcast-card');
    const closeBtn = document.getElementById('close-broadcast-btn');
    const allBroadcastBtn = document.getElementById('all-broadcast-btn');
    const broadcastList = document.getElementById('broadcast-list');

    addBtn?.addEventListener('click', function() {
        card.style.display = 'block';
        addBtn.style.display = 'none';
    });

    closeBtn?.addEventListener('click', function() {
        card.style.display = 'none';
        addBtn.style.display = 'inline-block';
        broadcastList.style.display = 'none';
    });

    allBroadcastBtn?.addEventListener('click', function() {
        broadcastList.style.display = (broadcastList.style.display === 'none') ? 'block' : 'none';
    });
</script>
