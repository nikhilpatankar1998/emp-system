
@include('admin.layouts.head')
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

.body-wrapper .app-header{
  width: calc(100% - 270px) !important;
  }

.body-wrapper.collapsed-sidebar .app-header{
  width: calc(100% - 80px) !important;
  }


 #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper .app-header {
    width: calc(100% - 270px) !important;
    transition: all 0.3s ease !important;
  }

  #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper.collapsed-sidebar .app-header {
    width: calc(100% - 80px) !important;
    transition: all 0.3s ease !important;
  }

 /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .body-wrapper.collapsed-sidebar .app-header {
    width: calc(100% - 270px) !important;
  }
  

  /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .app-header {
    width: calc(100% - 270px) !important;
  }

  /* Body wrapper default */
  .body-wrapper {
    margin-left: 270px !important;
    transition: all 0.3s ease !important;
  }

  /* Body wrapper when sidebar collapsed */
  .body-wrapper.collapsed-sidebar {
    margin-left: 80px !important;
  }

/* Small screens (below 1200px) */
@media (max-width: 1199px) {
  /* Sidebar hidden by default */
  #main-wrapper[data-layout=vertical] .left-sidebar {
    left: -100% !important;
    transition: all 0.3s ease !important;
  }

  /* Sidebar shown (mobile toggle) */
  #main-wrapper[data-layout=vertical].show-sidebar .left-sidebar {
    left: 0 !important;
  }
  
  .body-wrapper {
    margin-left: auto !important;
    transition: all 0.3s ease !important;
  }
  .app-header{
  width: 100% !important;
  }

   #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper .app-header {
    width: 100% !important;
    transition: all 0.3s ease !important;
  }

  #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper.collapsed-sidebar .app-header {
    width: 100% !important;
    transition: all 0.3s ease !important;
  }

  

  /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .app-header {
    width: 100% !important;
  }

.body-wrapper .app-header{
  width: 100% !important;
  }

.body-wrapper.collapsed-sidebar .app-header{
  width: 100% !important;
  }

.body-wrapper {
    margin-left: auto !important;
    transition: all 0.3s ease !important;
  }

  /* Body wrapper when sidebar collapsed */
  .body-wrapper.collapsed-sidebar {
    margin-left: auto !important;
  }

#main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .body-wrapper.collapsed-sidebar .app-header {
    width: 100% !important; 
}

.left-sidebar.collapsed {
    width: 100% !important;
}

}



</style>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        @include('admin.layouts.sidebar')

        <div class="body-wrapper">

            @include('admin.layouts.header')
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <!--   <h4 class="card-title mb-4">Admin Dashboard</h4> -->
                                <div class="row">
                                    <div class="four col-md-3 mb-2">
                                        <div class="counter-box colored">

                                            <span class="counter">{{ $employee }}</span>
                                            <p>Total Employee</p>
                                        </div>
                                    </div>
                                    <div class="four col-md-3 mb-2">
                                        <div class="counter-box">

                                            <span class="counter">{{ $projects }}</span>
                                            <p>Total Projects</p>
                                        </div>
                                    </div>
                                    <div class="four col-md-3 mb-2">
                                        <div class="counter-box">

                                            <span class="counter">{{ $tasks }}</span>
                                            <p>Assigned Tasks</p>

                                        </div>
                                    </div>
                                    <div class="four col-md-3 mb-2">
                                        <div class="counter-box">

                                            <span class="counter">{{ $completedtasks }}</span>
                                            <p>Completed Tasks</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="container-fluid"> -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                
<div class="d-flex justify-content-center align-items-center mb-3" style="
                                    background: #dde2e8;
                                    padding: 8px 10px;
                                    border-radius: 5px;
                                ">
                                
                                <h2 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important">
                                Employees Check IN
                                </h2>
                                
                                </div>

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
                                <div class="datatitlenew mb-4" style="background: #dde2e8;
                                    padding: 8px 10px;
                                    border-radius: 5px;">
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
                                
                            <div class="d-flex justify-content-center align-items-center mb-3" style="
                                    background: #dde2e8;
                                    padding: 8px 10px;
                                    border-radius: 5px;
                                ">
                                
                                <h2 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important">
                                Employees Card
                                </h2>
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




                <!-- <div class="container-fluid"> -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                
<div class="d-flex justify-content-center align-items-center mb-3" style="
                                    background: #dde2e8;
                                    padding: 8px 10px;
                                    border-radius: 5px;
                                ">
                                
                                <h2 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important">
                                Project Progress Overview
                                </h2>
                                </div>
                                <canvas id="projectChart"></canvas>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
<div class="d-flex justify-content-center align-items-center mb-3" style="
                                    background: #dde2e8;
                                    padding: 8px 10px;
                                    border-radius: 5px;
                                ">
                                
                                <h2 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important">
                                Employees Task Progress Overview
                                </h2>
                                </div>
                                <canvas id="taskChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-info">
                            <div class="card-body">

                                <h5 class="mb-3 text-primary">Currently Active Broadcast for All Employee.</h5>


                                @if ($broadcast)
                                    <div class="col-md-12 mb-2">
                                        {{-- <p class="broadcast-blink alert alert-warning text-center fw-bold m-0">
                                            {{ $broadcast->message }}
                                        </p> --}}
                                        <marquee behavior="scroll" direction="left" scrollamount="8" scrolldelay="0"
                                            loop="infinite" class="alert alert-warning text-center fw-bold m-0 fs-4">
                                            {{ $broadcast->message }}
                                        </marquee>
                                    </div>
                                @else
                                    <div class="col-md-12 mb-2">
                                        <h6 class="alert alert-secondary text-center m-0">
                                            No alerts for today.
                                        </h6>
                                    </div>
                                @endif
                                <button type="button" id="all-broadcast-btn" class="btn btn-sm btn-primary">All
                                    Broadcast</button>
                                <button id="add-broadcast-btn" class="btn btn-sm btn-primary">Add Broadcast</button>


                                <div id="broadcast-list" style="display: none;">
                                    <h6>Previous Broadcasts:</h6>
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($broadcasts as $index => $broadcast)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $broadcast->start_date }}</td>
                                                    <td>{{ $broadcast->end_date }}</td>
                                                    <td>{{ $broadcast->message }}</td>
                                                    <td>
                                                        <form
                                                            action="{{ route('broadcast.destroy', $broadcast->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this broadcast?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No broadcasts found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="broadcast-card" style="display: none;">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Broadcast Notification for Dashboard</h5>
                                </div>

                                <form action="{{ route('broadcast.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">Broadcast Start
                                                    Date</label>
                                                <input type="date" class="form-control" id="start_date"
                                                    name="start_date" required>
                                            </div>
                                            <div>
                                                <label for="end_date" class="form-label">Broadcast End
                                                    Date</label>
                                                <input type="date" class="form-control" id="end_date"
                                                    name="end_date" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="reason" class="form-label">Notification
                                                Message</label>
                                            <textarea class="form-control" name="reason" id="reason" cols="20" rows="4"
                                                placeholder="Enter your message..." required></textarea>
                                        </div>

                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" id="close-broadcast-btn"
                                                class="btn btn-primary btn-danger">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="container-fluid"> -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
<div class="d-flex justify-content-center align-items-center mb-3" style="
                                    background: #dde2e8;
                                    padding: 8px 10px;
                                    border-radius: 5px;
                                ">
                                
                                <h2 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important">
                                Tasks
                                </h2>
                                </div>
                                <!-- Employee Table -->
                                <!-- Responsive Table Wrapper -->
                                <div class="table-responsive">
                                    <table class="table text-nowrap align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-left">ID</th>
                                                <th scope="col" class="text-left text-nowrap">Project Name</th>
                                                <th scope="col" class="text-left">Task Title</th>
                                                <th scope="col" class="text-left text-nowrap">Assigned To</th>
                                                <th scope="col" class="text-left text-nowrap">Expected Time</th>
                                                <th scope="col" class="text-left text-nowrap">Time Taken</th>
                                                <th scope="col" class="text-left text-nowrap">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="text-left fw-medium text-nowrap">{{ $item->task_id }}
                                                    </td>
                                                    <td class="text-left fw-medium text-nowrap">
                                                        {{ $item->project_name }}</td>
                                                    <td class="text-left fw-medium" style="width:300px;">
                                                        {{ $item->title }}</td>
                                                    <td class="text-left fw-medium  text-nowrap">{{ $item->name }}
                                                    </td>
                                                    {{-- <td class="text-left fw-medium text-nowrap" >{{ $item->expected_time }}</td> --}}
                                                    <td class="text-left fw-medium">
                                                        @php
                                                            $hours = floor($item->expected_time / 60);
                                                            $minutes = $item->expected_time % 60;
                                                            $readableTime =
                                                                ($hours > 0 ? $hours . ' hr' : '') .
                                                                ($hours > 0 && $minutes > 0 ? ' ' : '') .
                                                                ($minutes > 0 ? $minutes . ' min' : '');
                                                        @endphp
                                                        {{ $readableTime }}
                                                    </td>
                                                    {{-- <td class="text-left fw-medium text-nowrap" >{{ $item->time_taken ?? '-- : --' }} --}}
                                                    <td class="text-left fw-medium">
                                                        @php
                                                            $hours = floor($item->time_taken / 60);
                                                            $minutes = $item->time_taken % 60;
                                                            $readableTime =
                                                                ($hours > 0 ? $hours . ' hr' : '') .
                                                                ($hours > 0 && $minutes > 0 ? ' ' : '') .
                                                                ($minutes > 0 ? $minutes . ' min' : '');
                                                        @endphp
                                                        {{ $readableTime !== '' ? $readableTime : '-- : --' }}
                                                    </td>
                                                    </td>
                                                    <td class="text-left fw-medium text-nowrap">
                                                        {{ $item->task_status ?? '----' }}</td>
                                                    {{-- <td class="text-left fw-medium" ><a class="btn btn-primary" href="{{ url('/project-tasks/'.$item->id)}}">Add Tasks</a>
                                                    <a class="btn btn-primary" href="{{ url('/tasks-list/'.$item->id)}}">Task List</a>
                                                <a class="btn btn-secondary" href={{ url('/editproject/'.$item->id) }}><i class="ti ti-edit"></i> Edit</a></td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    </div>
</body>
@include('admin.layouts.footer')

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
<script>
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
</script>
<script>
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
</script>
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
